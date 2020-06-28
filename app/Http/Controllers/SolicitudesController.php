<?php

namespace App\Http\Controllers;
// <Modelos>
use App\TipoHora;
use App\CargoUser;
use App\Cargo;
use App\Role;
use App\Presupuesto;
use App\Solicitud;
use App\User;
use App\Hora;
// </Modelos>
use DateTime;
use Validator;
use DB;
use Illuminate\Support\Facades\Auth;

class SolicitudesController extends Controller
{
    // Vista para registrar solicitudes
    public function registrar()
    {
        $roles = Role::all();
        $funcionarios =
            CargoUser::join('users', 'cargo_user.user_id', '=', 'users.id')
            ->join('cargos', 'cargo_user.cargo_id', '=', 'cargos.id')->where([['users.estado', '=', 1], ['cargo_user.estado', '=', '1'], ['cargos.id', '!=', '0']])
            ->select('cargo_user.id as id', 'users.nombres as nombres', 'users.apellidos as apellidos', 'users.documento as documento', 'cargos.nombre as cargos')
            ->get();
        $fecha = date('Y-m-d');
        $fecha = date('Y-m-d', strtotime('+1 days', strtotime($fecha)));
        $tipoHoras = TipoHora::all();
        return view('solicitudes.registrarSolicitud', compact('funcionarios', 'fecha', 'tipoHoras', 'id', 'roles'));
    }

    // Guarda la solicitud
    public function guardar($data)
    {
        $dato = json_decode($data, true);
        // dd($dato);
        $solicitud['cargo_user_id'] = $dato["Id"];
        $solicitud['tipo_hora_id'] = $dato["TipoHora"];
        $solicitud['total_horas'] = $dato["Horas"];
        $solicitud['hora_inicio'] = $dato["Inicio"] . ':00';
        $solicitud['hora_fin'] = $dato["Fin"] . ':00';
        $solicitud['actividades'] = $dato["Actividad"];
        $solicitud['autorizacion'] = 0;
        $solicitud['created_by'] = $dato['Creado'];
        $solicitud['FechaInicio'] = $dato['FechaInicio'];
        $solicitud['FechaFin'] = $dato['FechaFin'];
        $solicitud['dias'] = $dato['Dias'];
        $fecha = strtotime($dato['FechaInicio']);
        $año = date('Y', $fecha);
        $mes = date('m', $fecha);
        $mes = (int) $mes;
        $presupuesto = Presupuesto::where('año', $año)->where('mes', $mes)->first();
        if ($presupuesto == NULL) {
            $msg = "El mes y el año seleccionado, no cuentan con un presupuesto";
            return ($msg);
        }
        $solicitud['presupuesto_id'] = $presupuesto['id'];
        $validador = $this->validator($solicitud);
        // Validacion laravel
        if ($validador->fails()) {
            return $validador->errors()->all();
        }
        // Validacion de solicitud
        $msg = $this->validacion($solicitud);
        if ($msg['msg'] == 1) {
            $valorSolicitud['presupuesto_gastado'] = $msg['valor_total'] + $presupuesto['presupuesto_gastado'];
            // Validación de cada hora extra
            $msg = $this->validarHorasExtras($solicitud);
            if ($msg['msg'] == 1) {
                $solicitudN = Solicitud::create($solicitud);
                // Comentar la siguiente linea en caso que quieran desco
                $presupuesto->update($valorSolicitud);
                //  Ciclo para crear cada hora extra
                foreach ($msg['hora'] as $horaExtra) {
                    $horaExtra['solicitud_id'] = $solicitudN['id'];
                    Hora::create($horaExtra);
                }
                $msg = 1;
            } else {
                return $msg['msg'];
            }
        } else {
            return $msg['msg'];
        }
        return ($msg);
    }
    // Valida la información de la hora extra
    public function validator(array $data)
    {
        return Validator::make($data, [
            'tipo_hora_id' => 'required',
            'cargo_user_id' => 'required',
            'hora_inicio' => 'required',
            'hora_fin' => 'required',
            'actividades' => 'required',
            'total_horas' => 'required|numeric|min:1',
            'FechaFin' => 'required',
            'FechaInicio' => 'required',
            'created_by' => 'required',
            'dias' => 'required'
        ]);
    }
    // Funcion para validar cada tipo de hora e intervalo de tiempo
    public function validacion($solicitud)
    {
        $msg['msg'] = 1;
        // Condicional para validar la hora inicio y fin
        if ($solicitud['hora_inicio'] >= $solicitud['hora_fin']) {
            $msg['msg'] = "la hora inicio es mayor a la hora fin";
            return ($msg);
        }
        // Condicional para validar la fecha inicial y fecha final
        if ($solicitud['FechaInicio'] > $solicitud['FechaFin']) {
            $msg['msg'] = "la fecha inicial es mayor a la fecha final";
            return ($msg);
        }
        // Busca el tipo de hora
        $th = TipoHora::find($solicitud['tipo_hora_id']);
        // Condicional para comparar si esta dentro del rango de horas del tipo de hora
        if (($solicitud['hora_inicio'] < $th['hora_inicio']) || ($solicitud['hora_fin'] > $th['hora_fin'])) {
            $msg['msg'] = 'ese intervalo de tiempo no se consideran horas ' . $th['nombre_hora'];
            return ($msg);
        }
        // Comienza la validacion del presupuesto
        $valorTotal = $this->calcularValorHoras($solicitud);
        $presupuesto = Presupuesto::find($solicitud['presupuesto_id']);
        $presupuesto['sumaRestante'] = $valorTotal['valor_total'] + $presupuesto['presupuesto_gastado'];
        // Caso en que supere el presupuesto
        if ($presupuesto['sumaRestante'] > $presupuesto['presupuesto_inicial']) {
            $msg['msg'] = "excede el presupuesto restante";
        }
        // Retorna en caso que no cumpla ninguna de las condiciones
        $msg['valor_total'] = $valorTotal['valor_total'];
        return ($msg);
    }
    // Función para calcular el valor de la solicitud
    public function calcularValorHoras($solicitud)
    {
        $cantidadHoras = $solicitud['total_horas'];
        $cargoUser = CargoUser::find($solicitud['cargo_user_id']);
        $cargo = Cargo::find($cargoUser['cargo_id']);
        $th = TipoHora::find($solicitud['tipo_hora_id']);
        if ($th['tipo_id'] == 1) {
            $valorTotal = $cantidadHoras * $cargo['valor_diurna'];
            $valor = $cargo['valor_diurna'];
        } elseif ($th['tipo_id'] == 2) {
            $valorTotal = $cantidadHoras * $cargo['valor_nocturna'];
            $valor = $cargo['valor_nocturna'];
        } elseif ($th['tipo_id'] == 3) {
            $valorTotal = $cantidadHoras * $cargo['valor_recargo'];
            $valor = $cargo['valor_recargo'];
        } elseif ($th['tipo_id'] == 4) {
            $valorTotal = $cantidadHoras * $cargo['valor_dominical'];
            $valor = $cargo['valor_dominical'];
        }
        $valores = [];
        $valores['valor_total'] = $valorTotal;
        $valores['valor'] = $valor;
        return ($valores);
    }
    // Valida las horas extras automaticas de la solicitud antes de ingresarlas
    public function validarHorasExtras($solicitud)
    {
        $fechaInicio = strtotime($solicitud['FechaInicio']);
        $fechaFin = strtotime($solicitud['FechaFin']);
        $dias = $solicitud['dias'];
        $msg = [];
        $msg['msg'] = 1;
        // Ciclo para recorrer la diferencia entre la fecha inicio y fecha fin
        for ($i = $fechaInicio; $i <= $fechaFin; $i += 86400) {
            $dia = date('N', $i);
            $fecha = date('Y-m-d', $i);
            $horaExtra['fecha'] = $fecha;
            $horaExtra['hi_registrada'] = $solicitud['hora_inicio'];
            $horaExtra['hf_registrada'] = $solicitud['hora_fin'];
            $horaExtra['autorizado'] = 0;

            // Valida si existe la variable
            if (isset($dias['Lunes'])) {
                // Valida si es el día que corresponde
                if ($dia == 1) {
                    // Valida la hora
                    $msg['msg'] = $this->validarHoraExtra($horaExtra, $solicitud['cargo_user_id']);
                    if ($msg['msg'] != 1) {
                        return $msg;
                    }
                    // Lo va guardando en un arreglo si cumple las condiciones para luego guardarla
                    $msg['hora'][] = $horaExtra;
                }
            }
            if (isset($dias['Martes'])) {
                if ($dia == 2) {
                    $msg['msg'] = $this->validarHoraExtra($horaExtra, $solicitud['cargo_user_id']);
                    if ($msg['msg'] != 1) {
                        return $msg;
                    }
                    $msg['hora'][] = $horaExtra;
                }
            }
            if (isset($dias['Miercoles'])) {
                if ($dia == 3) {
                    $msg['msg'] = $this->validarHoraExtra($horaExtra, $solicitud['cargo_user_id']);
                    if ($msg['msg'] != 1) {
                        return $msg;
                    }
                    $msg['hora'][] = $horaExtra;
                }
            }
            if (isset($dias['Jueves'])) {
                if ($dia == 4) {
                    $msg['msg'] = $this->validarHoraExtra($horaExtra, $solicitud['cargo_user_id']);
                    if ($msg['msg'] != 1) {
                        return $msg;
                    }
                    $msg['hora'][] = $horaExtra;
                }
            }
            if (isset($dias['Viernes'])) {
                if ($dia == 5) {
                    $msg['msg'] = $this->validarHoraExtra($horaExtra, $solicitud['cargo_user_id']);
                    if ($msg['msg'] != 1) {
                        return $msg;
                    }
                    $msg['hora'][] = $horaExtra;
                }
            }
            if (isset($dias['Sabado'])) {
                if ($dia == 6) {
                    $msg['msg'] = $this->validarHoraExtra($horaExtra, $solicitud['cargo_user_id']);
                    if ($msg['msg'] != 1) {
                        return $msg;
                    }
                    $msg['hora'][] = $horaExtra;
                }
            }
            if (isset($dias['Domingo'])) {
                if ($dia == 7) {
                    $msg['msg'] = $this->validarHoraExtra($horaExtra, $solicitud['cargo_user_id']);
                }
            }
        }
        return $msg;
    }
    // Valida una hora extra
    public function validarHoraExtra($horaExtra, $cargoUser)
    {
        // Consulta para buscar todas las horas del usuario de un día
        $horasNoDisponibles = Hora::where('fecha', $horaExtra['fecha'])
            ->where('cargo_user_id', $cargoUser)
            ->join('solicitudes', 'solicitudes.id', 'horas.solicitud_id')
            ->join('cargo_user', 'cargo_user.id', 'solicitudes.cargo_user_id')
            ->join('users', 'users.id', 'cargo_user.user_id')->get();
        $msg = 1;
        if (!empty($horasNoDisponibles)) {
            foreach ($horasNoDisponibles as $horaNoDisponible) {
                if (($horaExtra['hi_registrada'] == $horaNoDisponible['hi_registrada']) && ($horaExtra['hf_registrada'] == $horaNoDisponible['hf_registrada'])) {
                    $msg = 'el funcionario ya se encuentra ocupado en ese intervalo de tiempo';
                    return ($msg);
                }
                if (($horaExtra['hi_registrada'] <= $horaNoDisponible['hi_registrada']) && ($horaExtra['hf_registrada'] <= $horaNoDisponible['hf_registrada'])) {
                    $msg = 'el funcionario ya se encuentra ocupado en ese intervalo de tiempo';
                    return ($msg);
                }
                if (($horaExtra['hi_registrada'] <= $horaNoDisponible['hi_registrada']) && ($horaExtra['hf_registrada'] >= $horaNoDisponible['hf_registrada'])) {
                    $msg = 'el funcionario ya se encuentra ocupado en ese intervalo de tiempo';
                    return ($msg);
                }
            }
        }
        return ($msg);
    }
    public function descontarPresupuesto($solicitud){
        
    }

    // Todas las solicitudes del cargo vigente
    public function solicitudes($id)
    {
        $solicitudes = Solicitud::where('cargo_user_id', '=', $id)
            ->with('presupuesto')
            ->with('tipoHoras')

            // ->with('tipo_horas.nombre_hora')
            ->get();
        return ($solicitudes);
    }
    // Información de la solicitud
    public function detalles($id)
    {
        $solicitud = Solicitud::where('solicitudes.id', $id)
            ->join('tipo_horas', 'tipo_horas.id', 'solicitudes.tipo_hora_id')
            ->join('presupuestos', 'presupuestos.id', 'solicitudes.presupuesto_id')
            ->join('cargo_user', 'cargo_user.id', 'solicitudes.cargo_user_id')
            ->join('users', 'users.id', 'cargo_user.user_id')
            ->join('cargos', 'cargos.id', 'cargo_user.cargo_id')
            ->select(
                'cargo_user.id as cargo_user_id',
                'users.nombres',
                'users.apellidos',
                'cargos.nombre',
                'tipo_horas.nombre_hora',
                'presupuestos.año',
                'presupuestos.mes',
                'solicitudes.hora_inicio',
                'solicitudes.hora_fin',
                'solicitudes.total_horas',
                'solicitudes.autorizacion',
                'solicitudes.actividades',
                'solicitudes.tipo_hora_id'
            )
            ->first();
        $valores = $this->calcularValorHoras($solicitud);
        $solicitud['valor_total'] = $valores['valor_total'];
        $solicitud['valor_hora'] = $valores['valor'];
        $totalHoras = Hora::select(DB::raw('TIMEDIFF(hf_registrada,hi_registrada)AS total_horas'))->where('solicitud_id', $id)->get();
        $solicitud['horas_usadas'] = 0;
        if (!empty($totalHoras)) {
            foreach ($totalHoras as $totalHora) {
                $solicitud['horas_usadas'] += $totalHora['total_horas'];
            }
        }
        $solicitud['horas_restantes'] = $solicitud['total_horas'] - $solicitud['horas_usadas'];
        if ($solicitud['autorizacion'] == 0) {
            $solicitud['autorizacion'] = "La solicitud no ha sido autorizada";
        } else {
            $autorizado = User::find($solicitud['autorizacion']);
            $solicitud['autorizacion'] = "Fue autorizado por " . $autorizado['nombres'] . " " . $autorizado['apellidos'];
        }
        return ($solicitud);
    }
    // Actualiza la información de solicitud
    public function update($data)
    {
        $dato = json_decode($data, true);
        $solicitud = Solicitud::find($dato['Id']);
        $solicitudE['id'] = $dato["Id"];
        $solicitudE['tipo_hora_id'] = $dato["Th"];
        $solicitudE['cargo_user_id'] = $dato["CargoUser"];
        $solicitudE['hora_inicio'] = $dato["Inicio"];
        $solicitudE['hora_fin'] = $dato["Fin"];
        $solicitudE['tipo_hora_id'] = $dato["Th"];
        $solicitudE['total_horas'] = $dato["Horas"];
        $solicitudE['actividades'] = $dato["Actividades"];
        $solicitudE['update'] = 1;
        $mesPresupuesto = $dato["Mes"];
        $añoPresupuesto = $dato["Año"];
        $presupuesto = Presupuesto::where('mes', '=', $mesPresupuesto)->where('año', '=', $añoPresupuesto)->first();
        if ($presupuesto == NULL) {
            $msg = "No se tiene un presupuesto asignado para la fecha dada";
            return ($msg);
        }
        if ($solicitud['autorizacion'] != 0) {
            $msg = "No se puede editar una hora ya autorizada";
            return ($msg);
        }
        $solicitudE['presupuesto_id'] = $presupuesto['id'];
        $ok = $this->validatorUpdate($solicitudE);
        if ($ok->fails()) {
            return $ok->errors()->all();;
        }
        $msg = $this->validacion($solicitudE);
        if ($msg == 1) {
            $solicitud->update($solicitudE);
            return (1);
        } else {
            return ($msg);
        }
    }
    // Verifica la actualización
    public function validatorUpdate($request)
    {
        return Validator::make($request, [
            'cargo_user_id' => 'required',
            'presupuesto_id' => 'required',
            'hora_inicio' => 'required',
            'hora_fin' => 'required',
            'total_horas' => 'required',
            'tipo_hora_id' => 'required'
        ]);
    }
    // Autoriza la solicitud
    public function autorizar($data)
    {
        if (Auth::User()->roles->id != 1) {
            $msg = "no tienes el permiso para ejecutar esta acción";
            return ($msg);
        }
        $msg = 1;
        $dato = json_decode($data, true);
        // dd($dato);
        $solicitud = Solicitud::find($dato['Id']);
        // En caso que la solicitud no este autorizada
        if ($solicitud['autorizacion'] == 0) {
            $solicitudA['autorizacion'] = Auth::user()->id;
            $solicitud->update($solicitudA);
            // -- Descomentar en caso que deseen descontar presupuesto al momento de autorizar
            // $presupuesto = Presupuesto::find($solicitud['presupuesto_id']);
            // $valor = $this->calcularValorHoras($solicitud);
            // $presupuestoRestante['presupuesto_gastado'] = $presupuesto['presupuesto_gastado'] + $valor['valor_total'];
            // $presupuesto->update($presupuestoRestante);
        } else {
            $msg = 'estas horas ya se encuentran autorizadas; se recomienda recargar la pagina';
        }
        return $msg;
    }
    // Calcula el total de horas de la solicitud
    public function totalHoras($data)
    {
        $dato = json_decode($data, true);
        $fechaInicio = strtotime($dato['FechaInicio']);
        $fechaFin = strtotime($dato['FechaFin']);
        $horaInicio = new DateTime($dato['HoraInicio']);
        $horaFin = new DateTime($dato['HoraFin']);
        // Condicional para validar que la hora fin sea mayor y que la fecha fin sea mayor
        if (($horaFin > $horaInicio) && ($fechaFin >= $fechaInicio)) {
            $intervalo = $horaInicio->diff($horaFin);
            $cantidadHoras = $intervalo->h;
            $cantidadDias = 0;
            // Ciclo para recorrer el intervalo entre fecha inicio y fecha fin
            for ($i = $fechaInicio; $i <= $fechaFin; $i += 86400) {
                $dia = date('N', $i);
                if (isset($dato['Lunes'])) {
                    if ($dia == 1) {
                        $cantidadDias++;
                    }
                }
                if (isset($dato['Martes'])) {
                    if ($dia == 2) {
                        $cantidadDias++;
                    }
                }
                if (isset($dato['Miercoles'])) {
                    if ($dia == 3) {
                        $cantidadDias++;
                    }
                }
                if (isset($dato['Jueves'])) {
                    if ($dia == 4) {
                        $cantidadDias++;
                    }
                }
                if (isset($dato['Viernes'])) {
                    if ($dia == 5) {
                        $cantidadDias++;
                    }
                }
                if (isset($dato['Sabado'])) {
                    if ($dia == 6) {
                        $cantidadDias++;
                    }
                }
                if (isset($dato['Domingo'])) {
                    if ($dia == 7) {
                        $cantidadDias++;
                    }
                }
            }
            $totalHoras = $cantidadDias * $cantidadHoras;
            return $totalHoras;
        }
    }
    // Vista para sincronizar los horarios de saf con horas extras
    public function horarioSaf()
    {
        $roles = Role::all();
        $funcionarios =
            CargoUser::join('users', 'cargo_user.user_id', '=', 'users.id')
            ->join('cargos', 'cargo_user.cargo_id', '=', 'cargos.id')->where([['users.estado', '=', 1], ['cargo_user.estado', '=', '1'], ['cargos.id', '!=', '0']])
            ->join('roles', 'roles.id', 'users.role_id')
            ->select('cargo_user.id as id', 'users.nombres as nombres', 'users.apellidos as apellidos', 'users.documento as documento', 'cargos.nombre as cargos')
            ->where('roles.nombre', 'Instructor')
            ->get();
        $fecha = date('Y-m-d');
        $fecha = date('Y-m-d', strtotime('+1 days', strtotime($fecha)));
        $tipoHoras = TipoHora::where('tipo_id', '!=', '4')->get();
        return view('solicitudes.registrarSolicitudSaf', compact('funcionarios', 'fecha', 'tipoHoras', 'id', 'roles'));
    }
    // Valida la información y la organiza antes de mandarla a saf
    public function preGuardarSaf($data)
    {
        $dato = json_decode($data, true);
        $msg = $this->validatorSaf($dato);
        if ($msg->fails()) {
            return $msg->errors()->all();;
        }
        $meses = $dato['Meses'];
        $solicitudes = [];
        // Se organiza una solicitud por cada mes que haya seleccionado
        foreach ($meses as $mes) {
            $solicitud['cargo_user_id'] = $dato['Id'];
            $presupuesto = Presupuesto::where('año', $dato['Año'])->where('mes', $mes)->first();
            if ($presupuesto == NULL) {
                $msg = "el mes " . $mes . " del año " . $dato['Año'] . " no cuenta con un presupuesto";
                return ($msg);
            }
            $solicitud['presupuesto_id'] = $presupuesto['id'];
            $solicitud['created_by'] = $dato['Creado'];
            $solicitud['autorizado'] = 0;
            $solicitud['fecha_inicio'] = $dato['Año'] . "-" . $mes . "-01";
            $solicitud['fecha_fin'] = $dato['Año'] . "-" . $mes . "-31";
            $solicitud['hora_inicio'] = $dato['Inicio'];
            $solicitud['hora_fin'] = $dato['Fin'];
            $solicitudes[] = $solicitud;
        }
        $usuario = User::join('cargo_user', 'cargo_user.user_id', 'users.id')->where('cargo_user.id', $solicitud['cargo_user_id'])->first();
        $solicitudes['documento'] = $usuario['documento'];
        $solicitudes['msg'] = 1;
        $solicitudes = json_encode($solicitudes);
        return ($solicitudes);
    }
    // Valida que los campos esten llenos antes de mandarlos a saf
    public function validatorSaf($request)
    {
        return Validator::make($request, [
            'Id' => 'required',
            'Inicio' => 'required',
            'Fin' => 'required',
            'Creado' => 'required',
            'Año' => 'required',
            'Meses' => 'required',
            'Th' => 'required'
        ]);
    }
    // Guarda la información entregada por SAF
    public function guardarSaf($data, $tipoHora, $funcionario)
    {
        $datos = json_decode($data, true);
        // Recorremos cada mes
        foreach ($datos as $contadorMes => $mesesSaf) {
            // Recorremos cada dia
            foreach ($mesesSaf as $solicitud) {
                $horas['hi_registrada'] = $solicitud['Horario']['horainicio'] . ":00";
                $horas['hf_registrada'] = $solicitud['Horario']['horafin'] . ":00";
                $horas['fecha'] = $solicitud['Diashorario']['fechacita'];
                $horas['autorizado'] = 0;
                $horaInicio = new DateTime($horas['hi_registrada']);
                $horaFin = new DateTime($horas['hf_registrada']);
                $intervalo = $horaInicio->diff($horaFin);
                $horas['total_horas'] = $intervalo->h;
                // Guardamos la informacion en un arreglo dentro del mes que corresponde
                $meses[$contadorMes][] = $horas;
            }
        }
        // Recorremos cada mes y creamos una solicitud por mes
        foreach ($meses as $mes) {
            $fecha = strtotime($mes[0]['fecha']);
            $año = date('Y', $fecha);
            $mesP = date('m', $fecha);
            $mesP = (int) $mesP;
            $presupuesto = Presupuesto::where('año', $año)->where('mes', $mesP)->first();
            $solicitudG['presupuesto_id'] = $presupuesto['id'];
            $solicitudG['tipo_hora_id'] = $tipoHora;
            $solicitudG['cargo_user_id'] = $funcionario;
            $solicitudG['autorizacion'] = 0;
            $solicitudG['hora_inicio'] = $mes[0]['hi_registrada'];
            $solicitudG['hora_fin'] = $mes[0]['hf_registrada'];
            $solicitudG['total_horas'] = 0;
            $solicitudG['actividades'] = "prueba";
            $solicitudG['created_by'] = Auth::User()->id;
            $diasHorarios=[];
            // Recorremos cada dia de ese mes
            foreach ($mes as $diaHorario) {
                $solicitudG['total_horas'] += $diaHorario['total_horas'];
                // La solicitud queda en el mayor rango de horas posible de acuerdo al dia
                if ($diaHorario['hi_registrada'] < $solicitudG['hora_inicio']) {
                    $solicitudG['hora_inicio'] = $diaHorario['hi_registrada'];
                }
                if ($diaHorario['hf_registrada'] > $solicitudG['hora_fin']) {
                    $solicitudG['hora_fin'] = $diaHorario['hf_registrada'];
                }
                $diasHorarios[]=$diaHorario;
            }
            $solicitudG['horas_extras']=$diasHorarios;
            $solicitudesG[]=$solicitudG;
        }
        // Proceso para guardar cada solicitud
        foreach ($solicitudesG as $solicitud) {
            $solicitudCreada = Solicitud::create($solicitud);
            // Recorremos cada hora extra de la solicitud y la guardamos
            foreach ($solicitud['horas_extras'] as $horasExtras) {
                $horasExtras['solicitud_id'] = $solicitudCreada->id;
                Hora::create($horasExtras);
            }
        }
        return 1;
    }
}
