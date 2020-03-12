<?php

namespace App\Http\Controllers;

// <Modelos>
use App\User;
// </Modelos>
use Illuminate\Http\Request;

class horasExtrasController extends Controller
{
    // Retorna la vista de horas del usuario
    public function index()
    {
        return view('horasExtras.inicio');
    }

    // Lleva a la vista los usuarios que tengan el estado activo y que sean funcionarios
    public function registrar()
    {
        $funcionarios = User::where([['estado', '=', 1], ['role_id', '=', 2]])->get();
        return view('horasExtras.registrarHoras', compact('funcionarios'));
    }

    // Guarda la información de las horas extras
    public function guardar($data)
    {
     
        $dato = json_decode($data, true);
        dd($data);
        $cargo['nombre'] = $dato["Nombre"];
        $cargo['sueldo'] = $dato["Sueldo"];
        $cargo['valor_diurna'] = $dato["Diurna"];
        $cargo['valor_nocturna'] = $dato["Nocturna"];
        $cargo['valor_dominical'] = $dato["Dominical"];
        $cargo['valor_recargo'] = $dato["Nocturno"];

        
        $validador = $this->validatorCargoSave($cargo);
        if ($validador->fails()) {
            return (0);
        } else {
            Cargo::create($cargo);
            return (1);
            }
    }

    public function update(Request $request, $id)
    {
        //
    }

}
