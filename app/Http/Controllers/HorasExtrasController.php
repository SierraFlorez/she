<?php

namespace App\Http\Controllers;

// <Modelos>
use App\Hora;
use App\TipoHora;
use App\Cargo;
use App\CargoUser;
use App\FechaEspecial;
use App\User;
use App\Presupuesto;

// </Modelos>
use Validator;
use Illuminate\Support\Facades\Auth;

class horasExtrasController extends Controller
{
    // Retorna la vista de horas del usuario
    public function index()
    {
        if (Auth::User()->role_id == 1) {
            $usuarios = User::where('id', '!=', 0)->get();
            $horas = Hora::join('cargo_user', 'cargo_user.id', '=', 'horas.cargo_user_id')
                ->join('users', 'users.id', '=', 'cargo_user.user_id')->join('cargos', 'cargos.id', '=', 'cargo_user.cargo_id')->join('tipo_horas', 'horas.tipo_hora', '=', 'tipo_horas.id')
                ->orderBy('fecha', 'desc')->orderBy('hi_solicitada', 'asc')
                ->where('autorizacion', 0)
                ->select(
                    'users.nombres',
                    'users.apellidos',
                    'cargos.nombre',
                    'horas.id',
                    'horas.fecha',
                    'horas.hi_solicitada',
                    'horas.hf_solicitada',
                    'horas.autorizacion',
                    'horas.hi_ejecutada',
                    'horas.hf_ejecutada',
                    'tipo_horas.nombre_hora'
                )->get();
            $tipoHoras = TipoHora::all();
            return view('horasExtras.index', compact('horas', 'tipoHoras', 'usuarios'));
        } else {
            $id = Auth::User()->cargos()->id;
            $horas = Hora::where('cargo_user_id', $id)->orderBy('fecha', 'asc')
                ->orderBy('hi_solicitada', 'asc')->raw('hi_solicitada', '-', 'hf_solicitada')->get();
            return view('horasExtras.index', compact('horas'));
        }
    }

    // Llena la tabla con cada peticion del js
    public function tabla($id)
    {
        if ($id == "all") {
            $horas = Hora::join('cargo_user', 'cargo_user.id', '=', 'horas.cargo_user_id')
                ->join('users', 'users.id', '=', 'cargo_user.user_id')
                ->join('cargos', 'cargos.id', '=', 'cargo_user.cargo_id')
                ->join('tipo_horas', 'horas.tipo_hora', '=', 'tipo_horas.id')
                ->orderBy('fecha', 'desc')->orderBy('hi_solicitada', 'asc')
                ->where('autorizacion', 0)
                ->select(
                    'users.nombres',
                    'users.apellidos',
                    'cargos.nombre',
                    'horas.id',
                    'horas.fecha',
                    'horas.hi_solicitada',
                    'horas.hf_solicitada',
                    'horas.autorizacion',
                    'tipo_horas.nombre_hora'
                )->get();
        } else {
            $horas = Hora::join('cargo_user', 'cargo_user.id', '=', 'horas.cargo_user_id')
                ->join('users', 'users.id', '=', 'cargo_user.user_id')
                ->join('cargos', 'cargos.id', '=', 'cargo_user.cargo_id')
                ->join('tipo_horas', 'horas.tipo_hora', '=', 'tipo_horas.id')
                ->orderBy('fecha', 'desc')->orderBy('hi_solicitada', 'asc')
                ->where('autorizacion', 0)
                ->where('cargo_user.user_id', $id)
                ->select(
                    'users.nombres',
                    'users.apellidos',
                    'cargos.nombre',
                    'horas.id',
                    'horas.fecha',
                    'horas.hi_solicitada',
                    'horas.hf_solicitada',
                    'horas.autorizacion',
                    'tipo_horas.nombre_hora'
                )->get();
        }
        // die($horas);
        return ($horas);
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
        $tipoHoras = TipoHora::all();
        return view('horasExtras.registrarHoras', compact('funcionario', 'fecha', 'tipoHoras', 'id'));
    }

    // Guarda la información de las horas extras
    public function guardar($data)
    {
        $dato = json_decode($data, true);
        // dd($dato);
        $horasextras['cargo_user_id'] = $dato["Id"];
        $horasextras['fecha'] = $dato["Fecha"];
        $horasextras['hi_solicitada'] = $dato["Inicio"] . ':00';
        $horasextras['hf_solicitada'] = $dato["Fin"];
        $horasextras['tipo_hora'] = $dato["TipoHora"];
        $horasextras['justificacion'] = $dato["Justificacion"];
        $horasextras['autorizacion'] = 0;
        $horasextras['hi_ejecutada'] = '00:00:00';
        $horasextras['hf_ejecutada'] = '00:00:00';
        $mesPresupuesto = date('m', strtotime($horasextras['fecha']));
        $añoPresupuesto = date('Y', strtotime($horasextras['fecha']));
        $presupuesto = Presupuesto::where('mes', '=', $mesPresupuesto)->where('año', '=', $añoPresupuesto)->first();
        if ($presupuesto == NULL) {
            $msg = "No se tiene un presupuesto asignado para la fecha dada";
            return ($msg);
        }
        $horasextras['presupuesto_id'] = $presupuesto['id'];
        $validador = $this->validatorHoraGuardar($horasextras);
        if ($validador->fails()) {
            return $validador->errors()->all();
        }
        $horasextras['guardar'] = 1;
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
            'cargo_user_id' => 'required',
            'fecha' => 'required',
            'hi_solicitada' => 'required',
            'hf_solicitada' => 'required',
            'tipo_hora' => 'required',
            'justificacion' => 'required',
        ]);
    }

    // Funcion para validar cada tipo de hora e intervalo de tiempo
    public function validacion($horasextras)
    {
        $msg = 1;
        // Consulta para saber si la franja del tiempo y el día es exactamente igual
        if ($horasextras['guardar'] == 1) {
            $horaExistente = Hora::where([
                ['cargo_user_id', '=', $horasextras['cargo_user_id']],
                ['fecha', '=', $horasextras['fecha']], ['hi_solicitada', '=', $horasextras['hi_solicitada']],
                ['hf_solicitada', '=', $horasextras['hf_solicitada']], ['justificacion', '=', $horasextras['justificacion']]
            ])->irst();
            if ($horaExistente == !NULL) {
                $msg = "ya existe esa misma hora en esa misma fecha";
                return ($msg);
            }
        }
        // Consulta para saber si la franja del tiempo se encuentra disponible
        $horasYaTrabajadas = Hora::where([['cargo_user_id', '=', $horasextras['cargo_user_id']], ['fecha', '=', $horasextras['fecha']]])->get();
        foreach ($horasYaTrabajadas as $horasNoDisponibles) {
            if (($horasextras['hf_solicitada'] > $horasNoDisponibles['hi_solicitada']) && ($horasextras['hf_solicitada'] < $horasNoDisponibles['hf_solicitada'])) {
                if (($horasextras['id'] != NULL) && ($horasextras['id' == $horasYaTrabajadas['id']])) {
                } else {
                    $msg = 'el funcionario ya se encuentra ocupado en ese intervalo de tiempo';
                    return ($msg);
                }
            }
        }
        // Consulta para saber si superan las 10 horas
        $totalHoras = $horasextras['hf_solicitada'] - $horasextras['hi_solicitada'];
        if ($totalHoras >= 10 || $totalHoras <= 0) {
            $msg = "en caso que las horas se extiendan en más de un día, por favor ingresar manualmente cada día";
            return ($msg);
        }

        // Comienza la validación dependiendo del tipo de hora
        $th = TipoHora::find($horasextras['tipo_hora']);
        // Caso en que no sea ni festivo ni nocturno
        if (($th['festivo'] == 0) && ($th['hora_nocturna'] == 0)) {
            // dd($th);
            if (($horasextras['hi_solicitada'] < $th['hora_inicio']) || ($horasextras['hf_solicitada'] > $th['hora_fin'])) {
                $msg = 'ese intervalo de tiempo no se consideran horas ' . $th['nombre_hora'];
                return ($msg);
            }
        }
        // Caso que sea nocturno pero no festivo
        elseif (($th['festivo'] == 0) && ($th['hora_nocturna'] == 1)) {
            // Caso en donde las horas que se vayan a ingresar son por la madrugada
            if (($horasextras['hi_solicitada'] >= '00:00:00') && ($horasextras['hf_solicitada'] <= '12:00:00')) {
                if ($horasextras['hi_solicitada'] > $th['hora_fin']) {
                    $msg = 'ese intervalo de tiempo no se consideran horas ' . $th['nombre_hora'];
                    return ($msg);
                }
            } else {
                // Caso en donde las horas que se vayan a ingresar son por la noche
                if ($horasextras['hi_solicitada'] < $th['hora_inicio']) {
                    $msg = 'ese intervalo de tiempo no se consideran horas ' . $th['nombre_hora'];
                    return ($msg);
                }
            }
        }
        // Caso en que sea festivo
        elseif ($th['festivo'] == 1) {
            $contador = 0;
            $fechasEspeciales = FechaEspecial::all();
            foreach ($fechasEspeciales as $fechaEspecial) {
                if (($horasextras['fecha'] >= $fechaEspecial['fecha_inicio']) && ($horasextras['fecha'] <= $fechaEspecial['fecha_fin'])) {
                    $contador++;
                }
            }
            if ($contador == 0) {
                $dia = date("D", strtotime($horasextras['fecha']));
                // dd($dia);
                if ($dia != "Sun") {
                    $msg = 'el día no se considera festivo';
                    return ($msg);
                }
            }
        }
        // Comienza la validacion del presupuesto
        $valorTotal = $this->calcularValorHoras($horasextras);
        $presupuesto = Presupuesto::find($horasextras['presupuesto_id']);
        $presupuesto['sumaRestante'] = $valorTotal['valor_total'] + $presupuesto['presupuesto_gastado'];
        // Caso en que supere el presupuesto
        if ($presupuesto['sumaRestante'] > $presupuesto['presupuesto_inicial']) {
            $msg = "excede el presupuesto restante";
        }
        // Retorna en caso que no cumpla ninguna de las condiciones y guarda la información
        return ($msg);
    }

    // Función para calcular el valor de las horas
    public function calcularValorHoras($hora)
    {
        $cantidadHoras = $hora['hf_solicitada'] - $hora['hi_solicitada'];
        $cargoUser = CargoUser::find($hora['cargo_user_id']);
        $cargo = Cargo::find($cargoUser['cargo_id']);
        if ($hora['tipo_hora'] == 1) {
            $valorTotal = $cantidadHoras * $cargo['valor_diurna'];
            $valor = $cargo['valor_diurna'];
        } elseif ($hora['tipo_hora'] == 2) {
            $valorTotal = $cantidadHoras * $cargo['valor_nocturna'];
            $valor = $cargo['valor_nocturna'];
        } elseif ($hora['tipo_hora'] == 3) {
            $valorTotal = $cantidadHoras * $cargo['valor_dominical'];
            $valor = $cargo['valor_dominical'];
        } elseif ($hora['tipo_hora'] == 4) {
            $valorTotal = $cantidadHoras * $cargo['valor_recargo'];
            $valor = $cargo['valor_recargo'];
        }
        $valores = [];
        $valores['valor_total'] = $valorTotal;
        $valores['valor'] = $valor;
        return ($valores);
    }

    // Trae toda la información del usuario para el modal detalle
    public function detalle($id)
    {
        $hora = Hora::find($id);
        $cargoUser = CargoUser::find($hora['cargo_user_id']);
        $cargo = Cargo::find($cargoUser['cargo_id']);
        $user = User::find($cargoUser['user_id']);
        $tipoHora = TipoHora::find($hora['tipo_hora']);
        $cantidadHoras = $hora['hf_solicitada'] - $hora['hi_solicitada'];
        $valores = $this->calcularValorHoras($hora);
        $autorizado = User::find($hora['autorizacion']);
        if (is_null($autorizado)) {
            $autorizado = 0;
        }
        $detalle = [];
        $detalle['hora'] = $hora;
        $detalle['cargo'] = $cargo;
        $detalle['cargoUser'] = $cargoUser;
        $detalle['user'] = $user;
        $detalle['tipoHora'] = $tipoHora;
        $detalle['cantidadHoras'] = $cantidadHoras;
        $detalle['valorTotal'] = $valores['valor_total'];
        $detalle['autorizado'] = $autorizado;
        $detalle['valor'] = $valores['valor'];
        return ($detalle);
    }

    // Actualiza la información de horas
    public function update($data)
    {
        $dato = json_decode($data, true);
        $hora = Hora::find($dato['Id']);
        $horaExtra['id'] = $dato["Id"];
        $horaExtra['cargo_user_id'] = $dato["CargoUser"];
        $horaExtra['fecha'] = $dato["Fecha"];
        $horaExtra['hi_solicitada'] = $dato["Inicio"];
        $horaExtra['hf_solicitada'] = $dato["Fin"];
        $horaExtra['tipo_hora'] = $dato["Th"];
        $horaExtra['justificacion'] = $dato["Justificacion"];
        $mesPresupuesto = date('m', strtotime($horaExtra['fecha']));
        $añoPresupuesto = date('Y', strtotime($horaExtra['fecha']));
        $presupuesto = Presupuesto::where('mes', '=', $mesPresupuesto)->where('año', '=', $añoPresupuesto)->first();
        if ($presupuesto == NULL) {
            $msg = "No se tiene un presupuesto asignado para la fecha dada";
            return ($msg);
        }
        $horaExtra['presupuesto_id'] = $presupuesto['id'];
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
            'hi_solicitada' => 'required',
            'hf_solicitada' => 'required',
            'justificacion' => 'required'
        ]);
    }

    // Cambia el estado a activo
    public function autorizar($data)
    {
        $dato = json_decode($data, true);
        // dd($dato);
        $hora = Hora::find($dato['Id']);
        if ($hora['autorizacion'] == 0) {
            $msg = $this->validacion($hora);
            if ($msg == 1) {
                $horasextra['autorizacion'] = Auth::user()->id;
                $hora->update($horasextra);
                $presupuesto = Presupuesto::find($hora['presupuesto_id']);
                $valor = $this->calcularValorHoras($hora);
                $presupuestoRestante['presupuesto_gastado'] = $presupuesto['presupuesto_gastado'] + $valor['valor_total'];
                $presupuesto->update($presupuestoRestante);
            }
            return ($msg);
        } else {
            return ('estas horas ya se encuentran autorizadas; se recomienda recargar la pagina');
        }
    }
}
