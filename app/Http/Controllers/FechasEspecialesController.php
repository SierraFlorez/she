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
        $seguridad = $this->seguridad(['Administrador']);
        if ($seguridad[0] === false) {
            abort(404);
        }
        $fechas = FechaEspecial::all();
        return view('fechasEspeciales.index', compact('fechas'));
    }
    // Llena la información del modal
    public function detalle($id)
    {
        $seguridad = $this->seguridad(['Administrador']);
        if ($seguridad[0] === false) {
            abort(404);
        }
        $detalle = FechaEspecial::find($id);
        return ($detalle);
    }
    // Guarda la fecha
    public function save($data)
    {
        $seguridad = $this->seguridad(['Administrador']);
        if ($seguridad[0] === false) {
            abort(404);
        }
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
        $seguridad = $this->seguridad(['Administrador']);
        if ($seguridad[0] === false) {
            abort(404);
        }
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
