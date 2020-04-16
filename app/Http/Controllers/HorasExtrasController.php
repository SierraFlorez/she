<?php

namespace App\Http\Controllers;

// <Modelos>
use App\Hora;
use App\TipoHora;
use App\Cargo;
use App\CargoUser;
use App\FechaEspecial;
use App\User;

// </Modelos>
use Illuminate\Http\Request;
use Validator;
use Illuminate\Support\Facades\Auth;

class horasExtrasController extends Controller
{
    // Retorna la vista de horas del usuario
    public function index()
    {
        if (Auth::User()->role_id == 1) {
            $horas = Hora::join('cargo_user', 'cargo_user.id', '=', 'horas.cargo_user_id')
                ->join('users', 'users.id', '=', 'cargo_user.user_id')->join('cargos', 'cargos.id', '=', 'cargo_user.cargo_id')->join('tipo_horas', 'horas.tipo_hora', '=', 'tipo_horas.id')
                ->orderBy('fecha', 'desc')->orderBy('hora_inicio', 'asc')
                ->select(
                    'users.nombres',
                    'users.apellidos',
                    'cargos.nombre',
                    'horas.id',
                    'horas.fecha',
                    'horas.hora_inicio',
                    'horas.hora_fin',
                    'horas.autorizacion',
                    'horas.ejecucion',
                    'tipo_horas.nombre_hora'
                )->get();
            // dd($horas);
            return view('horasExtras.index', compact('horas'));
        } else {
            $id = Auth::User()->cargos()->id;
            $horas = Hora::where('cargo_user_id', $id)->orderBy('fecha', 'asc')
                ->orderBy('hora_inicio', 'asc')->raw('hora_inicio', '-', 'hora_fin')->get();
            return view('horasExtras.index', compact('horas'));
        }
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
        $horasextras['hora_inicio'] = $dato["Inicio"] . ':00';
        $horasextras['hora_fin'] = $dato["Fin"];
        $horasextras['tipo_hora'] = $dato["TipoHora"];
        $horasextras['justificacion'] = $dato["Justificacion"];
        $horasextras['autorizacion'] = 0;
        $horasextras['ejecucion'] = 0;
        $validador = $this->validatorHoraGuardar($horasextras);
        if ($validador->fails()) {
            return $validador->errors()->all();
        }
        // dd($horasextras);
        // Consulta para saber si la franja del tiempo y el día es exactamente igual
        $horaExistente = Hora::where([
            ['cargo_user_id', '=', $horasextras['cargo_user_id']],
            ['fecha', '=', $horasextras['fecha']], ['hora_inicio', '=', $horasextras['hora_inicio']],
            ['hora_fin', '=', $horasextras['hora_fin']]
        ])->first();
        if ($horaExistente == !NULL) {
            $msg = "ya existe esa misma hora en esa misma fecha";
            return ($msg);
        }
        // Consulta para saber si la franja del tiempo se encuentra disponible
        $horasYaTrabajadas = Hora::where([['cargo_user_id', '=', $horasextras['cargo_user_id']], ['fecha', '=', $horasextras['fecha']]])->get();
        foreach ($horasYaTrabajadas as $horasNoDisponibles) {
            if (($horasextras['hora_fin'] > $horasNoDisponibles['hora_inicio']) && ($horasextras['hora_fin'] < $horasNoDisponibles['hora_fin'])) {
                return ('el funcionario ya se encuentra ocupado en ese intervalo ');
            }
        }
        // Consulta para saber si superan las 10 horas
        $totalHoras = $horasextras['hora_fin'] - $horasextras['hora_inicio'];
        if ($totalHoras >= 10 || $totalHoras <= 0) {
            $msg = "en caso que las horas se extiendan en más de un día, por favor ingresar manualmente cada día";
            return ($msg);
        }

        // Comienza la validación dependiendo del tipo de hora
        $th = TipoHora::find($horasextras['tipo_hora']);
        // Caso en que no sea ni festivo ni nocturno
        if (($th['festivo'] == 0) && ($th['hora_nocturna'] == 0)) {
            // dd($th);
            if (($horasextras['hora_inicio'] < $th['hora_inicio']) || ($horasextras['hora_fin'] > $th['hora_fin'])) {
                return ('ese intervalo de tiempo no se consideran horas ' . $th['nombre_hora']);
            }
        }
        // Caso que sea nocturno pero no festivo
        elseif (($th['festivo'] == 0) && ($th['hora_nocturna'] == 1)) {
            // Caso en donde las horas que se vayan a ingresar son por la madrugada
            if (($horasextras['hora_inicio'] >= '00:00:00') && ($horasextras['hora_fin'] <= '12:00:00')) {
                if ($horasextras['hora_inicio'] > $th['hora_fin']) {
                    return ('ese intervalo de tiempo no se consideran horas ' . $th['nombre_hora']);
                }
            } else {
                // Caso en donde las horas que se vayan a ingresar son por la noche
                if ($horasextras['hora_inicio'] < $th['hora_inicio']) {
                    return ('ese intervalo de tiempo no se consideran horas ' . $th['nombre_hora']);
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
                    return ('el día no se considera festivo');
                }
            }
        }
        Hora::create($horasextras);
        return (1);
    }
    // Valida la información de la hora extra
    public function validatorHoraGuardar(array $data)
    {
        return Validator::make($data, [
            'cargo_user_id' => 'required',
            'fecha' => 'required',
            'hora_inicio' => 'required',
            'hora_fin' => 'required',
            'tipo_hora' => 'required',
            'justificacion' => 'required',
        ]);
    }



    // Trae toda la información del usuario para el modal detalle
    public function detalle($id)
    {
        $hora = Hora::find($id);
        $cargoUser = CargoUser::find($hora['cargo_user_id']);
        $cargo = Cargo::find($cargoUser['cargo_id']);
        $user = User::find($cargoUser['user_id']);
        $tipoHora = TipoHora::find($hora['tipo_hora']);
        $cantidadHoras = $hora['hora_fin'] - $hora['hora_inicio'];
        if ($hora['tipo_hora']==1){
            $valorTotal = $cantidadHoras * $cargo['valor_diurna'];
            $valor = $cargo['valor_diurna'];
        }
        elseif ($hora['tipo_hora']==2){
            $valorTotal = $cantidadHoras * $cargo['valor_nocturna'];
            $valor = $cargo['valor_nocturna'];
        }
        elseif ($hora['tipo_hora']==3){
            $valorTotal = $cantidadHoras * $cargo['valor_dominical'];
            $valor = $cargo['valor_dominical'];
        }
        elseif ($hora['tipo_hora']==4){
            $valorTotal = $cantidadHoras * $cargo['valor_recargo'];
            $valor = $cargo['valor_recargo'];
        }
        $autorizado = User::find($hora['autorizacion']);
        if (is_null($autorizado)) {
            $autorizado = 0;
        }
        $detalle = [];
        $detalle['hora'] = $hora;
        $detalle['cargo'] = $cargo;
        $detalle['user'] = $user;
        $detalle['tipoHora'] = $tipoHora;
        $detalle['cantidadHoras'] = $cantidadHoras;
        $detalle['valorTotal'] = $valorTotal;
        $detalle['autorizado'] = $autorizado;
        $detalle['valor'] = $valor;
        return ($detalle);
    }

    public function update(Request $request, $id)
    {
        //
    }

    // Cambia el estado a activo
    public function autorizar($data)
    {
        $dato = json_decode($data, true);
        // dd($dato);
        $hora = Hora::find($dato['Id']);
        if ($hora['autorizacion']==0) {
            $horasextra['autorizacion'] = $dato["Id_user"];
            $hora->update($horasextra);
            return (1);
        } else {
            return ('estas horas ya se encuentran autorizadas; se recomienda recargar la pagina');
        }
    }
}
