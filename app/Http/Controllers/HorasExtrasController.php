<?php

namespace App\Http\Controllers;

// <Modelos>
use App\Hora;
use App\TipoHora;
use App\CargoUser;
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
            $horas = Hora::join('cargo_user', 'cargo_user.id', '=', 'horas.id_user_cargo')
                ->join('users', 'users.id', '=', 'cargo_user.user_id')->join('cargos', 'cargos.id', '=', 'cargo_user.cargo_id')->orderBy('id_user_cargo', 'asc')
                ->orderBy('fecha', 'asc')->orderBy('hora_inicio', 'asc')->get();
            // dd($horas);
            return view('horasExtras.index', compact('horas'));
        } else {
            $id = Auth::User()->cargos()->id;
            $horas = Hora::where('id_user_cargo', $id)->orderBy('fecha', 'asc')
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
            ->where('users.id', '=', Auth::user()->id)->
            select('cargo_user.id', 'users.documento', 'users.nombres', 'users.apellidos', 'cargos.nombre')->first();
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
        $horasextras['id_user_cargo'] = $dato["Id"];
        $horasextras['fecha'] = $dato["Fecha"];
        $horasextras['hora_inicio'] = $dato["Inicio"];
        $horasextras['hora_fin'] = $dato["Fin"];
        $horasextras['tipo_hora'] = $dato["TipoHora"];
        $horasextras['justificacion'] = $dato["Justificacion"];
        $validador = $this->validatorHoraGuardar($horasextras);
        if ($validador->fails()) {
            return $validador->errors()->all();
        }
        // Consulta para saber si la franja del tiempo y el día es exactamente igual
        $horaExistente = Hora::where([
            ['id_user_cargo', '=', $horasextras['id_user_cargo']],
            ['fecha', '=', $horasextras['fecha']], ['hora_inicio', '=', $horasextras['hora_inicio']],
            ['hora_fin', '=', $horasextras['hora_fin']]
        ])->first();
        if ($horaExistente == !NULL) {
            $msg = "ya existe esa misma hora en esa misma fecha";
            return ($msg);
        }
        // Consulta para saber si la franja del tiempo se encuentra disponible
        $horasYaTrabajadas = Hora::where([['id_user_cargo', '=', $horasextras['id_user_cargo']], ['fecha', '=', $horasextras['fecha']]])->get();
        foreach ($horasYaTrabajadas as $horasNoDisponibles) {
            if (($horasextras['hora_fin'] > $horasNoDisponibles['hora_inicio']) && ($horasextras['hora_fin'] < $horasNoDisponibles['hora_fin'])) {
                return ('el funcionario ya se encuentra ocupado en ese intervalo ');
            }
        }
        // Consulta para saber si superan las 10 horas
        $totalHoras = $horasextras['hora_fin'] - $horasextras['hora_inicio'];
        if ($totalHoras >= 10 || $totalHoras <= 0) {
            $msg = "la cantidad de horas supera a 10";
            return ($msg);
        }
        // Validación de horas diurnas
        if (($horasextras['tipo_hora'] == 1) && (($horasextras['hora_inicio'] < '06:00') || ($horasextras['hora_fin'] > '18:00:00'))) {
            return ('ese intervalo de tiempo no se considera una hora diurna');
        }
        // Validación de horas nocturnas
        if (($horasextras['tipo_hora'] == 2) && ($horasextras['hora_inicio'] < '18:00')) {
            return ('ese intervalo de tiempo no se considera una hora nocturna');
        }
        // Validación para recargos nocturnos
        if (($horasextras['tipo_hora'] == 4) && ($horasextras['hora_inicio'] < '18:00')) {
            return ('ese intervalo de tiempo no se considera un recargo nocturno');
        }
        Hora::create($horasextras);
        return (1);
    }
    // Valida la información de la hora extra
    public function validatorHoraGuardar(array $data)
    {
        return Validator::make($data, [
            'id_user_cargo' => 'required',
            'fecha' => 'required',
            'hora_inicio' => 'required',
            'hora_fin' => 'required',
            'tipo_hora' => 'required',
            'justificacion' => 'required',
        ]);
    }

    public function update(Request $request, $id)
    {
        //
    }
}
