<?php

namespace App\Http\Controllers;

// <modelos>
use App\Cargo;
use Validator;
use App\Role;

// </modelos>
use Illuminate\Support\Facades\Auth;


class CargosController extends Controller
{
    // Tabla de cargos
    public function index()
    {
        $roles = Role::orderBy('id', 'DESC')->get();
        $filtro = $this->administrador(Auth::user()->roles->id);
        $cargos = Cargo::where('id','!=',0)->get();
        return view('cargos.index', compact('cargos','roles'));
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
        $filtro = $this->administrador(Auth::user()->roles->id);
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
            $cargo['nombre'] = $this->formatoTexto($cargo['nombre']);
            $Cargo->update($cargo);
            return (1);
        }
    }
    // Verifica la actualización
    public function validatorCargoUpdate($cargo)
    {
        return Validator::make($cargo, [
            'nombre' => 'required|max:50|unique:cargos,nombre,' . $cargo['id'],
            'sueldo' => 'required|numeric|min:0',
            'valor_diurna' => 'required|numeric|min:0',
            'valor_diurna' => 'required|numeric|min:0',
            'valor_nocturna' => 'required|numeric|min:0',
            'valor_dominical' => 'required|numeric|min:0',
            'valor_recargo' => 'required|numeric|min:0',
            'valor_nocturna' => 'required|numeric|min:0',
        ]);
    }
    // Guarda cargo nuevo
    public function save($data)
    {
        $filtro = $this->administrador(Auth::user()->roles->id);
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
            $cargo['nombre'] = $this->formatoTexto($cargo['nombre']);
            Cargo::create($cargo);
            return (1);
        }
    }
    // Valida cuando se guarda un cargo
    public function validatorCargoSave($cargo)
    {
        return Validator::make($cargo, [
            'nombre' => 'required|max:50|unique:cargos,nombre',
            'sueldo' => 'required|numeric|min:0',
            'valor_diurna' => 'required|numeric|min:0',
            'valor_diurna' => 'required|numeric|min:0',
            'valor_nocturna' => 'required|numeric|min:0',
            'valor_dominical' => 'required|numeric|min:0',
            'valor_recargo' => 'required|numeric|min:0',
            'valor_nocturna' => 'required|numeric|min:0',
        ]);
    }
}
