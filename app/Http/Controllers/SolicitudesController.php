<?php

namespace App\Http\Controllers;
// <Modelos>
use App\TipoHora;
use App\CargoUser;
use App\Cargo;
use App\Presupuesto;
use App\Solicitud;
use App\User;
use App\Hora;
// </Modelos>
use Validator;
use Illuminate\Support\Facades\Auth;

class SolicitudesController extends Controller
{
    // Vista para registrar solicitudes
    public function registrar()
    {
        $funcionario =
            CargoUser::join('users', 'cargo_user.user_id', '=', 'users.id')
            ->join('cargos', 'cargo_user.cargo_id', '=', 'cargos.id')->where([['users.estado', '=', 1], ['cargo_user.estado', '=', '1']])
            ->where('users.id', '=', Auth::user()->id)->select('cargo_user.id', 'users.documento', 'users.nombres', 'users.apellidos', 'cargos.nombre')->first();
        // dd($funcionario);
        $fecha = date('Y-m-d');
        $fecha = date('Y-m-d', strtotime('+1 days', strtotime($fecha)));
        $tipoHoras = TipoHora::all();
        return view('solicitudes.registrarSolicitud', compact('funcionario', 'fecha', 'tipoHoras', 'id'));
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
        $presupuesto = Presupuesto::where('año', $dato['Año'])->where('mes', $dato['Mes'])->first();
        if ($presupuesto == NULL) {
            $msg = "El mes y el año seleccionado, no cuentan con un presupuesto";
            return ($msg);
        }
        $solicitud['presupuesto_id'] = $presupuesto['id'];
        $validador = $this->validator($solicitud);
        if ($validador->fails()) {
            return $validador->errors()->all();
        }
        $msg = $this->validacion($solicitud);
        if ($msg == 1) {
            Solicitud::create($solicitud);
            return (1);
        } else {
            return ($msg);
        }
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
            'total_horas' => 'required|numeric|max:10|min:1',
        ]);
    }
    // Funcion para validar cada tipo de hora e intervalo de tiempo
    public function validacion($solicitud)
    {
        $msg = 1;
        $id = 0;
        if (isset($solicitud['id'])) {
            $id = $solicitud['id'];
        }
        // Consulta para saber si la franja del tiempo se encuentra disponible
        $solicitudIgual =  Solicitud::where([['cargo_user_id', '=', $solicitud['cargo_user_id']], ['presupuesto_id', '=', $solicitud['presupuesto_id']], ['hora_inicio', '=', $solicitud['hora_inicio']], ['hora_fin', '=', $solicitud['hora_fin']], ['actividades', '=', $solicitud['actividades']], ['autorizacion','!=',0]])->first();
        if ($solicitudIgual != NULL) {
            $msg = 'ya existe esa misma solicitud';
            return ($msg);
        }
        $solicitudesAnteriores = Solicitud::where([['cargo_user_id', '=', $solicitud['cargo_user_id']], ['presupuesto_id', '=', $solicitud['presupuesto_id']]])->get();
        foreach ($solicitudesAnteriores as $horasNoDisponibles) {
            if (($solicitud['hora_inicio'] <= $horasNoDisponibles['hora_inicio']) && ($solicitud['hora_fin'] >= $horasNoDisponibles['hora_fin']) && ($id != $horasNoDisponibles['id'])) {
                $msg = 'el funcionario ya se encuentra ocupado en ese intervalo de tiempo';
                return ($msg);
            }
            if (($solicitud['hora_inicio'] >= $horasNoDisponibles['hora_inicio']) && ($solicitud['hora_fin'] <= $horasNoDisponibles['hora_fin']) && ($id != $horasNoDisponibles['id'])) {
                $msg = 'el funcionario ya se encuentra ocupado en ese intervalo de tiempo';
                return ($msg);
            }
            if (($solicitud['hora_inicio'] < $horasNoDisponibles['hora_inicio']) && ($solicitud['hora_fin'] <= $horasNoDisponibles['hora_fin']) && ($solicitud['hora_fin'] > $horasNoDisponibles['hora_inicio']) && ($id != $horasNoDisponibles['id'])) {
                $msg = 'el funcionario ya se encuentra ocupado en ese intervalo de tiempo';
                return ($msg);
            }
        }

        // Comienza la validación dependiendo del tipo de hora
        $th = TipoHora::find($solicitud['tipo_hora_id']);
        // Caso en que no sea ni festivo ni nocturno
        if (($th['festivo'] == 0) && ($th['hora_nocturna'] == 0)) {
            // dd($th);
            if (($solicitud['hora_inicio'] < $th['hora_inicio']) || ($solicitud['hora_fin'] > $th['hora_fin'])) {
                $msg = 'ese intervalo de tiempo no se consideran horas ' . $th['nombre_hora'];
                return ($msg);
            }
        }
        // Caso que sea nocturno pero no festivo
        elseif (($th['festivo'] == 0) && ($th['hora_nocturna'] == 1)) {
            // Caso en donde las horas que se vayan a ingresar son por la madrugada
            if (($solicitud['hora_inicio'] >= '00:00:00') && ($solicitud['hora_fin'] <= '12:00:00')) {
                if ($solicitud['hora_fin'] > $th['hora_fin']) {
                    $msg = 'ese intervalo de tiempo no se consideran horas ' . $th['nombre_hora'];
                    return ($msg);
                }
            } else {
                // Caso en donde las horas que se vayan a ingresar son por la noche
                if ($solicitud['hora_inicio'] < $th['hora_inicio']) {
                    $msg = 'ese intervalo de tiempo no se consideran horas ' . $th['nombre_hora'];
                    return ($msg);
                }
            }
        }
        // Comienza la validacion del presupuesto
        $valorTotal = $this->calcularValorHoras($solicitud);
        $presupuesto = Presupuesto::find($solicitud['presupuesto_id']);
        $presupuesto['sumaRestante'] = $valorTotal['valor_total'] + $presupuesto['presupuesto_gastado'];
        // Caso en que supere el presupuesto
        if ($presupuesto['sumaRestante'] > $presupuesto['presupuesto_inicial']) {
            $msg = "excede el presupuesto restante";
        }
        // Retorna en caso que no cumpla ninguna de las condiciones y guarda la información
        return ($msg);
    }
    // Función para calcular el valor de las horas
    public function calcularValorHoras($solicitud)
    {
        $cantidadHoras = $solicitud['total_horas'];
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
        $solicitud['horas_restantes']=Hora::where('solicitud_id',$id)->sum('horas_trabajadas');
        // dd($solicitud);
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
    // Autoriza las horas
    public function autorizar($data)
    {
        $dato = json_decode($data, true);
        // dd($dato);
        $solicitud = Solicitud::find($dato['Id']);
        if ($solicitud['autorizacion'] == 0) {
            $msg = $this->validacion($solicitud);
            if ($msg == 1) {
                $solicitudA['autorizacion'] = Auth::user()->id;
                $solicitud->update($solicitudA);
                $presupuesto = Presupuesto::find($solicitud['presupuesto_id']);
                $valor = $this->calcularValorHoras($solicitud);
                $presupuestoRestante['presupuesto_gastado'] = $presupuesto['presupuesto_gastado'] + $valor['valor_total'];
                $presupuesto->update($presupuestoRestante);
            }
            return ($msg);
        } else {
            return ('estas horas ya se encuentran autorizadas; se recomienda recargar la pagina');
        }
    }
}
