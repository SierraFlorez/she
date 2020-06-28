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
        $roles = Role::all();
        $tipoHoras = TipoHora::all();
        if (Auth::User()->role_id == 1) {
            $solicitudes = Solicitud::join('cargo_user', 'cargo_user.id', '=', 'solicitudes.cargo_user_id')
                ->join('users', 'users.id', '=', 'cargo_user.user_id')->join('cargos', 'cargos.id', '=', 'cargo_user.cargo_id')
                ->join('tipo_horas', 'solicitudes.tipo_hora_id', '=', 'tipo_horas.id')->join('presupuestos','presupuestos.id','solicitudes.presupuesto_id')
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
            return view('horas.index', compact('solicitudes', 'tipoHoras','roles'));
        } else {
            $id = CargoUser::where('estado', '1')->where('user_id', Auth::User()->id)->first();
            $solicitudes = Solicitud::join('presupuestos', 'presupuestos.id', 'presupuesto_id')->where('cargo_user_id', $id->id)->orderBy('año', 'asc')
                ->orderBy('mes', 'asc')
                ->select(
                    'solicitudes.id',
                    'solicitudes.actividades'
                )->get();
            return view('horas.indexF', compact('solicitudes', 'tipoHoras','roles'));
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
        $roles=Role::all();
        $funcionario =
            CargoUser::join('users', 'cargo_user.user_id', '=', 'users.id')
            ->join('cargos', 'cargo_user.cargo_id', '=', 'cargos.id')->where([['users.estado', '=', 1], ['cargo_user.estado', '=', '1']])
            ->where('users.id', '=', Auth::user()->id)->select('cargo_user.id', 'users.documento', 'users.nombres', 'users.apellidos', 'cargos.nombre')->first();
        // dd($funcionario);
        $fecha = date('Y-m-d');
        $fecha = date('Y-m-d', strtotime('+1 days', strtotime($fecha)));
        $solicitudes = Solicitud::where('cargo_user_id', $funcionario->id)->where('autorizacion', '!=', 0)->get();

        return view('horas.registrarHoras', compact('funcionario', 'fecha', 'solicitudes','roles'));
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
        $horasextras['horas_trabajadas'] = $dato["Horas"];
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
            'horas_trabajadas' => 'required',
        ]);
    }
    // Funcion para validar cada tipo de hora e intervalo de tiempo
    public function validacion($horasextras)
    {
        $msg = 1;
        $id = 0;
        if (isset($horasextras['id'])) {
            $id = $horasextras['id'];
        }
        // Pasar tiempo a decimal
        $inicio = new DateTime($horasextras['hi_registrada']);
        $fin = new DateTime($horasextras['hf_registrada']);
        $intervalo = $inicio->diff($fin);
        $totalHoras = $intervalo->format('%H:%i:00');
        $fraccionHoras = explode(":", $totalHoras);
        $minutosDecimales = $fraccionHoras['1'] / 60;
        $minutosDecimales = explode("0", $minutosDecimales);
        $horasDecimales = $fraccionHoras['0'] . $minutosDecimales[1];
        $horasDecimal = (float) $horasDecimales;
        // En caso que las horas trabajadas sean superiores
        if ($horasextras['horas_trabajadas'] > $horasDecimal) {
            $msg = "las horas trabajadas son superiores a la resta de la hora fin con la inicial";
            return ($msg);
        }
        $horaExistente = Hora::where([
            ['solicitud_id', '=', $horasextras['solicitud_id']], ['fecha', '=', $horasextras['fecha']],
            ['hi_registrada', '=', $horasextras['hi_registrada']], ['hf_registrada', '=', $horasextras['hf_registrada']], ['id', '!=', $id]
        ])->first();
        // En caso que exista una hora exactamente igual
        if ($horaExistente == !NULL) {
            $msg = "ya existe esa misma hora en esa misma fecha";
            return ($msg);
        }
        $solicitud = Solicitud::find($horasextras['solicitud_id']);
        $mes = date('m', strtotime($horasextras['fecha']));
        $año = date('Y', strtotime($horasextras['fecha']));
        $presupuesto = $solicitud->presupuesto;
        // Validación para saber si el mes y el año corresponden con el presupuesto y solicitud
        if (($presupuesto['mes'] != $mes) || ($presupuesto['año'] != $año)) {
            $msg = "la fecha dada no corresponde con el presupuesto de la solicitud";
            return ($msg);
        }
        // Comienza la validación para saber si las horas corresponden con las solicitadas
        if ($horasextras['hi_registrada'] < $solicitud['hora_inicio']) {
            $msg = "la hora inicial no corresponde con la solicitud";
            return ($msg);
        }
        if (($horasextras['hf_registrada'] > $solicitud['hora_fin']) || ($horasextras['hf_registrada'] < $horasextras['hi_registrada'])) {
            $msg = "la hora final no corresponde con la solicitud";
            return ($msg);
        }
        // Consulta para saber si la franja del tiempo se encuentra disponible
        $horasTrabajadas = Hora::where([['fecha', '=', $horasextras['fecha']], ['solicitud_id', '=', $horasextras['solicitud_id']]])->get();
        foreach ($horasTrabajadas as $horasNoDisponibles) {
            if (($horasextras['hf_registrada'] >= $horasNoDisponibles['hi_registrada']) && ($horasextras['hf_registrada'] <= $horasNoDisponibles['hf_registrada']) && ($id != $horasNoDisponibles['id'])) {
                $msg = 'el funcionario ya se encuentra ocupado en ese intervalo de tiempo';
                return ($msg);
            }
            if (($horasextras['hf_registrada'] >= $horasNoDisponibles['hi_registrada']) && ($horasextras['hf_registrada'] >= $horasNoDisponibles['hf_registrada']) && ($id != $horasNoDisponibles['id'])) {
                $msg = 'el funcionario ya se encuentra ocupado en ese intervalo de tiempo';
                return ($msg);
            }
        }
        $horasSolicitud = Hora::where('solicitud_id', $horasextras['solicitud_id'])->sum('horas_trabajadas');
        $horasSolicitud = $horasSolicitud + $horasextras['horas_trabajadas'];
        // Caso en que el total de horas sea superior
        if ($horasSolicitud > $solicitud['total_horas']) {
            $msg = "la cantidad de horas registradas supera al total de horas solicitadas";
            return ($msg);
        }
        $dia = date('D', strtotime($horasextras['fecha']));
        $tipoHora = TipoHora::find($solicitud['tipo_hora_id']);
        $fechasEspeciales = FechaEspecial::all();
        if ($tipoHora['festivo'] == 1) {
            $i = 0;
            foreach ($fechasEspeciales as $fechaEspecial) {
                if (($fechaEspecial['fecha_inicio'] >= $horasextras['fecha']) && ($fechaEspecial['fecha_fin'] <= $horasextras['fecha'])) {
                    return ($msg);
                }
            }
            if ($dia == "Sun") {
                return ($msg);
            }
        } else {
            if ($dia == "Sun") {
                $msg = "no sé puede registrar horas en un día festivo si la solicitud no lo es";
                return ($msg);
            }
            foreach ($fechasEspeciales as $fechaEspecial) {
                if (($fechaEspecial['fecha_inicio'] >= $horasextras['fecha']) && ($fechaEspecial['fecha_fin'] <= $horasextras['fecha'])) {
                    $msg = "no sé puede registrar horas en un día festivo si la solicitud no lo es";
                    return ($msg);
                }
            }
        }
        // // Retorna en caso que no cumpla ninguna de las condiciones y guarda la información
        return ($msg);
    }
    // Trae toda la información del usuario para el modal detalle
    public function detalle($id)
    {
        $hora = Hora::find($id);
        $solicitud = Solicitud::find($hora['solicitud_id']);
        $cargoUser = CargoUser::find($solicitud['cargo_user_id']);
        $cargo = Cargo::find($cargoUser['cargo_id']);
        $user = User::find($cargoUser['user_id']);
        $tipoHora = TipoHora::find($solicitud['tipo_hora_id']);
        $valores = $this->calcularValorHoras($hora);
        $detalle = [];
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
        $horaExtra['horas_trabajadas'] = $dato["Horas"];
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
            'horas_trabajadas' => 'required'
        ]);
    }
    // Función para calcular el valor de las horas
    public function calcularValorHoras($horas)
    {
        $cantidadHoras = $horas['horas_trabajadas'];
        $solicitud = Solicitud::find($horas['solicitud_id']);
        $cargoUser = CargoUser::find($solicitud['cargo_user_id']);
        $cargo = Cargo::find($cargoUser['cargo_id']);
        if ($solicitud['tipo_hora_id'] == 1) {
            $valorTotal = $cantidadHoras * $cargo['valor_diurna'];
            $valor = $cargo['valor_diurna'];
        } elseif ($solicitud['tipo_hora_id'] == 2) {
            $valorTotal = $cantidadHoras * $cargo['valor_nocturna'];
            $valor = $cargo['valor_nocturna'];
        } elseif ($solicitud['tipo_hora_id'] == 3) {
            $valorTotal = $cantidadHoras * $cargo['valor_dominical'];
            $valor = $cargo['valor_dominical'];
        } elseif ($solicitud['tipo_hora_id'] == 4) {
            $valorTotal = $cantidadHoras * $cargo['valor_recargo'];
            $valor = $cargo['valor_recargo'];
        }
        $valores = [];
        $valores['valor_total'] = $valorTotal;
        $valores['valor'] = $valor;
        return ($valores);
    }
}
