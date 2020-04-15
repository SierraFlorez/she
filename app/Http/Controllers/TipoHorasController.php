<?php

namespace App\Http\Controllers;

// <modelos>
use App\TipoHora;
use Validator;

// </modelos>

class TipoHorasController extends Controller
{
    // Vista de la lista de tipo horas
    public function index()
    {
        $tipoHoras = TipoHora::all();
        return view('tipoHora.index', compact('tipoHoras'));
    }

    // Llena la información del modal
    public function detalle($id)
    {
        $tipoHora = TipoHora::find($id);
        return ($tipoHora);
    }
    // Actualiza la hora extra
    public function update($data)
    {
        $dato = json_decode($data, true);
        $hora = TipoHora::find($dato['Id']);
        $tipoHora['id'] = $dato["Id"];
        $tipoHora['nombre_hora'] = $dato["Nombre"];
        $tipoHora['hora_inicio'] = $dato["Inicio"];
        $tipoHora['hora_fin'] = $dato["Fin"];
        $ok = $this->validatorUpdate($tipoHora);
        if ($ok->fails()) {
            return $ok->errors()->all();;
        } else {
            $hora->update($tipoHora);
            return (1);
        }
    }
    // Verifica la actualización
    public function validatorUpdate($request)
    {
        return Validator::make($request, [
            'nombre_hora' => 'required|max:100|unique:tipo_horas,nombre_hora,' . $request['id'],
            'hora_inicio' => 'required',
            'hora_fin' => 'required',
        ]);
    }
}
