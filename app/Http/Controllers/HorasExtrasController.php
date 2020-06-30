<?php

namespace App\Http\Controllers;

// <Modelos>
use App\Hora;
use App\TipoHora;
use App\Cargo;
use App\CargoUser;
use App\FechaEspecial;
use App\User;
use App\Solicitud;
use App\Role;
use DateTime;
// </Modelos>
use Validator;
use DB;
use Illuminate\Support\Facades\Auth;

class horasExtrasController extends Controller
{
    // Retorna la vista de horas por autorizar
    public function index()
    {
        $tipoHoras = TipoHora::all();
        $seguridad = $this->seguridad(['Administrador', 'Coordinador']);
        // ------ VISTA PARA COORDINADORES Y ADMINISTRADORES
        if ($seguridad[0] === true) {
            $solicitudes = Solicitud::join('cargo_user', 'cargo_user.id', '=', 'solicitudes.cargo_user_id')
                ->join('users', 'users.id', '=', 'cargo_user.user_id')->join('cargos', 'cargos.id', '=', 'cargo_user.cargo_id')
                ->join('tipo_horas', 'solicitudes.tipo_hora_id', '=', 'tipo_horas.id')->join('presupuestos', 'presupuestos.id', 'solicitudes.presupuesto_id')
                ->select(
                    DB::raw('(CASE 
                    WHEN presupuestos.mes = 1 THEN "Enero"
                    WHEN presupuestos.mes = 2 THEN "Febrero"
                    WHEN presupuestos.mes = 3 THEN "Marzo"
                    WHEN presupuestos.mes = 4 THEN "Abril"
                    WHEN presupuestos.mes = 5 THEN "Mayo"
                    WHEN presupuestos.mes = 6 THEN "Junio"
                    WHEN presupuestos.mes = 7 THEN "Julio"
                    WHEN presupuestos.mes = 8 THEN "Agosto"
                    WHEN presupuestos.mes = 9 THEN "Septiembre"
                    WHEN presupuestos.mes = 10 THEN "Octubre"
                    WHEN presupuestos.mes = 11 THEN "Noviembre"
                    WHEN presupuestos.mes = 12 THEN "Diciembre"
                    END) AS mes'),
                    'presupuestos.año',
                    'solicitudes.id',
                    'users.nombres',
                    'users.apellidos',
                    'cargos.nombre',
                    'solicitudes.hora_inicio',
                    'solicitudes.hora_fin',
                    'tipo_horas.nombre_hora',
                    'solicitudes.autorizacion'
                )->get();
            return view('horas.index', compact('solicitudes', 'tipoHoras'));
        }
        // ---- VISTA PARA FUNCIONARIOS E INSTRUCTORES
        $seguridad = $this->seguridad(['Funcionario', 'Instructor']);
        if ($seguridad[0] === true) {
            $id = CargoUser::where('estado', '1')->where('user_id', Auth::User()->id)->first();
            $solicitudes = Solicitud::join('presupuestos', 'presupuestos.id', 'presupuesto_id')
                ->join('cargo_user', 'cargo_user.id', '=', 'solicitudes.cargo_user_id')
                ->join('cargos', 'cargos.id', '=', 'cargo_user.cargo_id')
                ->join('tipo_horas', 'solicitudes.tipo_hora_id', '=', 'tipo_horas.id')
                ->where('cargo_user_id', $id->id)->orderBy('año', 'asc')
                ->orderBy('mes', 'asc')
                ->select(
                    DB::raw('(CASE 
                    WHEN presupuestos.mes = 1 THEN "Enero"
                    WHEN presupuestos.mes = 2 THEN "Febrero"
                    WHEN presupuestos.mes = 3 THEN "Marzo"
                    WHEN presupuestos.mes = 4 THEN "Abril"
                    WHEN presupuestos.mes = 5 THEN "Mayo"
                    WHEN presupuestos.mes = 6 THEN "Junio"
                    WHEN presupuestos.mes = 7 THEN "Julio"
                    WHEN presupuestos.mes = 8 THEN "Agosto"
                    WHEN presupuestos.mes = 9 THEN "Septiembre"
                    WHEN presupuestos.mes = 10 THEN "Octubre"
                    WHEN presupuestos.mes = 11 THEN "Noviembre"
                    WHEN presupuestos.mes = 12 THEN "Diciembre"
                    END) AS mes'),
                    'presupuestos.año',
                    'solicitudes.id',
                    'cargos.nombre',
                    'solicitudes.hora_inicio',
                    'solicitudes.hora_fin',
                    'tipo_horas.nombre_hora',
                    'solicitudes.autorizacion'
                )->get();
            return view('horas.indexF', compact('solicitudes', 'tipoHoras'));
        } else {
            abort(404);
        }
    }
    // Llena la tabla con cada peticion del js
    public function tabla($data)
    {
        $dato = json_decode($data, true);
        $solicitud = Solicitud::find($dato['Id']);
        $horas = Hora::Where('solicitud_id', '=', $dato['Id'])
            ->join('solicitudes', 'solicitudes.id', '=', 'horas.solicitud_id')
            ->join('cargo_user', 'cargo_user.id', '=', 'solicitudes.cargo_user_id')
            ->join('users', 'users.id', '=', 'cargo_user.user_id')
            ->join('cargos', 'cargos.id', '=', 'cargo_user.cargo_id')
            ->join('tipo_horas', 'solicitudes.tipo_hora_id', '=', 'tipo_horas.id')
            ->select(
                'users.nombres',
                'users.apellidos',
                'cargos.nombre',
                'horas.id',
                'horas.fecha',
                'horas.hi_registrada',
                'horas.hf_registrada',
                'tipo_horas.nombre_hora'
            )
            ->get();
        $tabla['horas'] = $horas;
        $tabla['solicitud'] = $solicitud;
        return ($tabla);
    }
    // Lleva a la vista los usuarios que sean funcionarios, tengan estado activo, y tengan un CargoUsuario activo
    public function registrar()
    {
        $funcionario =
            CargoUser::join('users', 'cargo_user.user_id', '=', 'users.id')
            ->join('cargos', 'cargo_user.cargo_id', '=', 'cargos.id')->where([['users.estado', '=', 1], ['cargo_user.estado', '=', '1']])
            ->where('users.id', '=', Auth::user()->id)->select('cargo_user.id', 'users.documento', 'users.nombres', 'users.apellidos', 'cargos.nombre')->first();
        // dd($funcionario);
        $fecha = date('Y-m-d');
        $fecha = date('Y-m-d', strtotime('+1 days', strtotime($fecha)));
        $solicitudes = Solicitud::where('cargo_user_id', $funcionario->id)->where('autorizacion', '!=', 0)->get();

        return view('horas.registrarHoras', compact('funcionario', 'fecha', 'solicitudes'));
    }
    // Guarda la información de las horas extras
    public function guardar($data)
    {
        $dato = json_decode($data, true);
        // dd($dato);
        $horasextras['fecha'] = $dato["Fecha"];
        $horasextras['hi_registrada'] = $dato["Inicio"] . ':00';
        $horasextras['hf_registrada'] = $dato["Fin"];
        $horasextras['solicitud_id'] = $dato["Solicitud"];
        $validador = $this->validatorHoraGuardar($horasextras);
        if ($validador->fails()) {
            return $validador->errors()->all();
        }
        $msg = $this->validacion($horasextras);
        if ($msg == 1) {
            Hora::create($horasextras);
            return (1);
        } else {
            return ($msg);
        }
    }
    // Valida la información de la hora extra
    public function validatorHoraGuardar(array $data)
    {
        return Validator::make($data, [
            'fecha' => 'required',
            'hi_registrada' => 'required',
            'hf_registrada' => 'required',
            'solicitud_id' => 'required',
        ]);
    }
    // Funcion para validar cada tipo de hora e intervalo de tiempo
    public function validacion($horasextras)
    {
        $msg = 1;
        $id = 0;
        // En caso de venir del update
        if (isset($horasextras['id'])) {
            $id = $horasextras['id'];
        }
        // Pasar tiempo a decimal
        $inicio = new DateTime($horasextras['hi_registrada']);
        $fin = new DateTime($horasextras['hf_registrada']);
        $intervalo = $inicio->diff($fin);
        $cantidadHoras = $intervalo->h + ($intervalo->i / 60);
        $totalHoras = $cantidadHoras;
        // Caso en que la fecha inicio supere a la fin  
        if ($inicio >= $fin) {
            $msg = "la hora fin debe ser mayor a la hora inicial";
            return $msg;
        }
        $solicitud = Solicitud::where('solicitudes.id', $horasextras['solicitud_id'])->join('presupuestos', 'presupuestos.id', 'solicitudes.presupuesto_id')->first();
        $primerDiaMes = $solicitud['año'] . "-" . $solicitud['mes'] . "-01";
        $ultimoDiaMes = date('Y-m-t', strtotime($primerDiaMes));
        // Caso en que no este dentro del mes de la solicitud
        if ($horasextras['fecha'] < $primerDiaMes && $horasextras['fecha'] > $ultimoDiaMes) {
            $msg = "la fecha debe estar ubicada dentro del mes de la solicitud";
            return ($msg);
        }
        // Condicional para comparar si esta dentro del rango de horas de la solicitud
        if (($horasextras['hi_registrada'] < $solicitud['hora_inicio']) || ($horasextras['hf_registrada'] > $solicitud['hora_fin'])) {
            $msg = 'el intervalo de tiempo no esta dentro de la hora inicial y final de la solicitud';
            return ($msg);
        }

        $horasSolicitud = Hora::where('solicitud_id', $solicitud['id'])->where('id', '!=', $id)->get();
        foreach ($horasSolicitud as $hora) {
            $inicio = new DateTime($hora['hi_registrada']);
            $fin = new DateTime($hora['hf_registrada']);
            $intervalo = $inicio->diff($fin);
            $cantidadHoras = $intervalo->h + ($intervalo->i / 60);
            $totalHoras += $cantidadHoras;
        }
        // En caso que se supere el total de horas de la solicitud
        if ($totalHoras > $solicitud['total_horas']) {
            $msg = "al registrar esa hora, supera la cantidad de total de horas de la solicitud";
            return ($msg);
        }
        $th = TipoHora::find($solicitud['tipo_hora_id']);
        $festivos = false;
        if ($th['tipo_id'] == 4) {
            $festivos = true;
        }
        $esFestivo = false;
        $dia = date('N', strtotime($horasextras['fecha']));
        $festivos = FechaEspecial::where('fecha', $horasextras['fecha'])->first();
        // Condicional para saber si el dia es festivo
        if (($dia == 7) || (!empty($festivos))) {
            $esFestivo = true;
        }
        // Caso en que este habilitado para recibir festivos pero no es un dia festivo
        if ($festivos == true && $esFestivo == false) {
            $msg = "la fecha ingresada no esta dentro de las fechas especiales";
            return ($msg);
        }
        // Caso en que sea un dia festivo pero no esta habilitado para recibir festivos
        if ($festivos == false && $esFestivo == true) {
            $msg = "solo se pueden ingresar días festivos si la solicitud tiene ese tipo de hora";
            return ($msg);
        }
        // Consulta para buscar todas las horas del usuario de un día
        $horasNoDisponibles = Hora::where('fecha', $horasextras['fecha'])
            ->where('cargo_user_id', $solicitud['cargo_user_id'])
            ->where('horas.id','!=',$id)
            ->join('solicitudes', 'solicitudes.id', 'horas.solicitud_id')
            ->join('cargo_user', 'cargo_user.id', 'solicitudes.cargo_user_id')
            ->join('users', 'users.id', 'cargo_user.user_id')->get();
        if (!empty($horasNoDisponibles)) {
            // Recorre cada hora de la fecha dada para ver si esta dentro del rango horario
            foreach ($horasNoDisponibles as $horaNoDisponible) {
                if (($horasextras['hi_registrada'] == $horaNoDisponible['hi_registrada']) && ($horasextras['hf_registrada'] == $horaNoDisponible['hf_registrada'])) {
                    $msg = 'el funcionario ya se encuentra ocupado en ese intervalo de tiempo';
                    return ($msg);
                }
                if (($horasextras['hi_registrada'] >= $horaNoDisponible['hi_registrada']) && ($horasextras['hf_registrada'] <= $horaNoDisponible['hf_registrada'])) {
                    $msg = 'el funcionario ya se encuentra ocupado en ese intervalo de tiempo';
                    return ($msg);
                }
                if (($horasextras['hi_registrada'] <= $horaNoDisponible['hi_registrada']) && ($horasextras['hf_registrada'] >= $horaNoDisponible['hf_registrada'])) {
                    $msg = 'el funcionario ya se encuentra ocupado en ese intervalo de tiempo';
                    return ($msg);
                }
            }
        }
        return ($msg);
    }
    // Trae toda la información del usuario para el modal detalle
    public function detalle($id)
    {
        $hora = Hora::find($id);
        $horaInicio = new DateTime($hora['hi_registrada']);
        $horaFin = new DateTime($hora['hf_registrada']);
        $intervalo = $horaInicio->diff($horaFin);
        $cantidadHoras = $intervalo->h + ($intervalo->i / 60);
        $hora['cantidad_horas'] = $cantidadHoras;
        $usuario['total_horas'] = (float) $cantidadHoras;
        $solicitud = Solicitud::find($hora['solicitud_id']);
        $cargoUser = CargoUser::find($solicitud['cargo_user_id']);
        $cargo = Cargo::find($cargoUser['cargo_id']);
        $user = User::find($cargoUser['user_id']);
        $tipoHora = TipoHora::find($solicitud['tipo_hora_id']);
        $valores = $this->calcularValorHoras($hora);
        $detalle = [];
        $detalle['solicitud']=$solicitud;
        $detalle['hora'] = $hora;
        $detalle['cargo'] = $cargo;
        $detalle['cargoUser'] = $cargoUser;
        $detalle['user'] = $user;
        $detalle['tipoHora'] = $tipoHora;
        $detalle['valorTotal'] = $valores['valor_total'];
        $detalle['valor'] = $valores['valor'];
        return ($detalle);
    }
    // Actualiza la información de horas
    public function update($data)
    {
        $dato = json_decode($data, true);
        $hora = Hora::find($dato['Id']);
        $horaExtra['id'] = $dato["Id"];
        $horaExtra['fecha'] = $dato["Fecha"];
        $horaExtra['hi_registrada'] = $dato["Inicio"];
        $horaExtra['hf_registrada'] = $dato["Fin"];
        $horaExtra['solicitud_id'] = $hora['solicitud_id'];
        $ok = $this->validatorUpdate($horaExtra);
        if ($ok->fails()) {
            return $ok->errors()->all();;
        }
        $msg = $this->validacion($horaExtra);
        if ($msg == 1) {
            $hora->update($horaExtra);
            return (1);
        } else {
            return ($msg);
        }
    }
    // Verifica la actualización
    public function validatorUpdate($request)
    {
        return Validator::make($request, [
            'fecha' => 'required',
            'hi_registrada' => 'required',
            'hf_registrada' => 'required',
        ]);
    }
    // Función para calcular el valor de las horas
    public function calcularValorHoras($horas)
    {
        $horaInicio = new DateTime($horas['hi_registrada']);
        $horaFin = new DateTime($horas['hf_registrada']);
        $intervalo = $horaInicio->diff($horaFin);
        $cantidadHoras = $intervalo->h + ($intervalo->i / 60);
        $solicitud = Solicitud::find($horas['solicitud_id']);
        $cargoUser = CargoUser::find($solicitud['cargo_user_id']);
        $cargo = Cargo::find($cargoUser['cargo_id']);
        $th = TipoHora::find($solicitud['tipo_hora_id']);
        if ($th['tipo_id'] == 1) {
            $valorTotal = $cantidadHoras * $cargo['valor_diurna'];
            $valor = $cargo['valor_diurna'];
        } elseif ($th['tipo_id'] == 2) {
            $valorTotal = $cantidadHoras * $cargo['valor_nocturna'];
            $valor = $cargo['valor_nocturna'];
        } elseif ($th['tipo_id'] == 4) {
            $valorTotal = $cantidadHoras * $cargo['valor_dominical'];
            $valor = $cargo['valor_dominical'];
        } elseif ($th['tipo_id'] == 3) {
            $valorTotal = $cantidadHoras * $cargo['valor_recargo'];
            $valor = $cargo['valor_recargo'];
        }
        $valores = [];
        $valores['valor_total'] = $valorTotal;
        $valores['valor'] = $valor;
        return ($valores);
    }
    // Función que trae las horas según solicitud_id
    public function horasSolicitud($id)
    {
        $horas['horas'] = Hora::where('horas.solicitud_id', $id)->join('solicitudes', 'solicitudes.id', 'horas.solicitud_id')
            ->select('horas.id', 'horas.fecha', 'horas.hi_registrada', 'horas.hf_registrada', 'solicitudes.autorizacion')->get();
        $totalHoras = 0;
        foreach ($horas['horas'] as $hora) {
            $horaInicio = new DateTime($hora['hi_registrada']);
            $horaFin = new DateTime($hora['hf_registrada']);
            $intervalo = $horaInicio->diff($horaFin);
            $cantidadHoras = $intervalo->h + ($intervalo->i / 60);
            $totalHoras += $cantidadHoras;
        }
        $solicitud = Solicitud::find($id);
        $horasFaltantes = $solicitud['total_horas'] - $totalHoras;
        $horas['faltantes'] = "Se pueden registrar " . $horasFaltantes . " horas en esta solicitud";
        return ($horas);
    }
    public function eliminar($data)
    {
        if (Auth::User()->roles->id != 1) {
            $msg = "no tienes el permiso para ejecutar esta acción";
            return ($msg);
        }
        $dato = json_decode($data, true);
        Hora::where('id', $dato)->delete();
        return (1);
    }
}
