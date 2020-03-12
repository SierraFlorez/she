<?php

namespace App\Http\Controllers;

// <Modelos>
use App\User;
use App\CargoUser;
use App\Hora;

// </Modelos>
use Illuminate\Http\Request;

class horasExtrasController extends Controller
{
    // Retorna la vista de horas del usuario
    public function index()
    {
        return view('horasExtras.inicio');
    }

    // Lleva a la vista los usuarios que sean funcionarios, tengan estado activo, y tengan un CargoUsuario activo
    public function registrar()
    {
        $funcionarios = User::join('cargo_user','cargo_user.user_id','=','users.id')->
        where([['users.estado', '=', 1], ['role_id', '=', 2],['cargo_user.estado','=','1']])->get();

        // dd($funcionarios);
        return view('horasExtras.registrarHoras', compact('funcionarios'));

    }

    // Guarda la información de las horas extras
    public function guardar($data)
    {
        $dato = json_decode($data, true);
        $horasextras['id_user_cargo'] = $dato["Id"];
        $horasextras['fecha'] = $dato["Fecha"];
        $horasextras['hora_inicio'] = $dato["Inicio"];
        $horasextras['hora_fin'] = $dato["Fin"];
        $horasextras['tipo_hora'] = $dato["TipoHora"];


        $validador = $this->validatorCargoSave($cargo);
        if ($validador->fails()) {
            return (0);
        } else {
            Hora::create($horasextras);
            return (1);
        }
    }

    public function update(Request $request, $id)
    {
        //
    }

}
