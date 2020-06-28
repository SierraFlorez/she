<?php

namespace App\Http\Controllers;
// <modelos>
use App\FechaEspecial;
use Validator;
use App\Role;

use Illuminate\Support\Facades\Auth;
// </modelos>


class FechasEspecialesController extends Controller
{
    // Retorna la pagina de inicio
    public function index()
    {
        $filtro = $this->administrador(Auth::user()->roles->id);
        // Retorna la vista de inicio
        $fechas = FechaEspecial::all();
        $roles = Role::orderBy('id', 'DESC')->get();
        return view('fechasEspeciales.index', compact('fechas','roles'));
    }
    // Llena la información del modal
    public function detalle($id)
    {
        $detalle = FechaEspecial::find($id);
        return ($detalle);
    }
    // Guarda la fecha
    public function save($data)
    {
        $filtro = $this->administrador(Auth::user()->roles->id);
        $dato = json_decode($data, true);
        $fecha['descripcion'] = $dato["Nombre"];
        $fecha['fecha'] = $dato["Inicio"];
        $validador = $this->validatorSave($fecha);
        if ($validador->fails()) {
            return $validador->errors()->all();
        } 
        FechaEspecial::create($fecha);
        return (1);
    }
    // Valida la información de la fecha que quiere registrar
    public function validatorSave(array $data)
    {
        return Validator::make($data, [
            'descripcion' => 'required|max:70',
            'fecha' => 'required',
        ]);
    }
    // Actualiza la fecha especial
    public function update($data)
    {
        $filtro = $this->administrador(Auth::user()->roles->id);
        $dato = json_decode($data, true);
        $fecha = FechaEspecial::find($dato['Id']);
        $fechaEspecial['id'] = $dato["Id"];
        $fechaEspecial['descripcion'] = $dato["Nombre"];
        $fechaEspecial['fecha'] = $dato["Inicio"];
        $ok = $this->validatorUpdate($fechaEspecial);
        if ($ok->fails()) {
            return $ok->errors()->all();;
        }
        $fecha->update($fechaEspecial);
        return (1);
    }
    // Verifica la actualización
    public function validatorUpdate($request)
    {
        return Validator::make($request, [
            'descripcion' => 'required|max:100|unique:tipo_horas,nombre_hora,' . $request['id'],
            'fecha' => 'required',
        ]);
    }
}
