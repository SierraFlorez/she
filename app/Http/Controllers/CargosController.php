<?php

namespace App\Http\Controllers;

use App\Cargo;
use Validator;

class CargosController extends Controller
{
    // Tabla de cargos
    public function index()
    {
        $cargos = Cargo::all();
        return view('cargos.index', compact('cargos'));
    }

    // Modal detalle cargo
    public function detalle($id)
    {
        $cargo = Cargo::find($id);
        return ($cargo);
    }
    // Actualizar cargo
    public function update($data)
    {
        $dato = json_decode($data, true);

        $Cargo = Cargo::find($dato['Id']);
        $cargo['id'] = $dato["Id"];
        $cargo['nombre'] = $dato["Nombre"];
        $cargo['sueldo'] = $dato["Sueldo"];
        $cargo['valor_diurna'] = $dato["Diurna"];
        $cargo['valor_nocturna'] = $dato["Nocturna"];
        $cargo['valor_dominical'] = $dato["Dominical"];
        $cargo['valor_recargo'] = $dato["Recargo"];
        $cargo['valor_nocturna'] = $dato["Nocturna"];

        $ok = $this->validatorCargoUpdate($cargo);
        if ($ok->fails()) {
            return $ok->errors()->all();
        } else {
            $Cargo->update($cargo);
            return (1);
        }
    }
    // Verifica la actualización
    public function validatorCargoUpdate($cargo)
    {
        return Validator::make($cargo, [
            'nombre' => 'required|max:50|unique:cargos,nombre,'.$cargo['id'],
            'sueldo' => 'required|numeric|max:10000000|min:1000000',
            'valor_diurna' => 'required|numeric|min:1000|max:100000',
            'valor_diurna' => 'rrequired|numeric|min:1000|max:100000',
            'valor_nocturna' => 'required|numeric|min:1000|max:100000',
            'valor_dominical' => 'required|numeric|min:1000|max:100000',
            'valor_recargo' => 'required|numeric|min:1000|max:100000',
            'valor_nocturna' => 'required|numeric|min:1000|max:100000',
        ]);
    }
    // Guarda cargo nuevo
    public function save($data)
    {
        $dato = json_decode($data, true);
        $cargo['nombre'] = $dato["Nombre"];
        $cargo['sueldo'] = $dato["Sueldo"];
        $cargo['valor_diurna'] = $dato["Diurna"];
        $cargo['valor_nocturna'] = $dato["Nocturna"];
        $cargo['valor_dominical'] = $dato["Dominical"];
        $cargo['valor_recargo'] = $dato["Nocturno"];

        
        $validador = $this->validatorCargoSave($cargo);
        if ($validador->fails()) {
            return $validador->errors()->all();
        } else {
            Cargo::create($cargo);
            return (1);
            }
        
    }

    public function validatorCargoSave($cargo)
    {
        return Validator::make($cargo, [
            'nombre' => 'required|max:50|unique:cargos,nombre',
            'sueldo' => 'required|numeric|max:10000000|min:1000000',
            'valor_diurna' => 'required|numeric|min:1000|max:100000',
            'valor_diurna' => 'required|numeric|min:1000|max:100000',
            'valor_nocturna' => 'required|numeric|min:1000|max:100000',
            'valor_dominical' => 'required|numeric|min:1000|max:100000',
            'valor_recargo' => 'required|numeric|min:1000|max:100000',
            'valor_nocturna' => 'required|numeric|min:1000|max:100000',
        ]);
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        //
    }

    public function destroy($id)
    {
        //
    }
}
