<?php

namespace App\Http\Controllers;
// <modelos>
use App\TipoHora;
use Validator;
use App\Role;
use App\Tipo;
use Illuminate\Support\Facades\Auth;
// </modelos>

class TipoHorasController extends Controller
{

    // Vista de la lista de tipo horas
    public function index()
    {
        $seguridad = $this->seguridad(['Administrador']);
        if ($seguridad[0] === false) {
            abort(404);
        }
        $tipoHoras = TipoHora::all();
        $tipos = Tipo::all();
        return view('tipoHora.index', compact('tipoHoras','tipos'));
    }

    // Llena la información del modal
    public function detalle($id)
    {
        $seguridad = $this->seguridad(['Administrador']);
        if ($seguridad[0] === false) {
            abort(404);
        }
        $tipoHora = TipoHora::find($id);
        return ($tipoHora);
    }

    // Actualiza la hora extra
    public function update($data)
    {
        $seguridad = $this->seguridad(['Administrador']);
        if ($seguridad[0] === false) {
            abort(404);
        }
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
            $validador = $this->validar($tipoHora['hora_inicio'], $tipoHora['hora_fin']);
            if ($validador == 1) {
                $hora->update($tipoHora);
                return (1);
            } else {
                return $validador;
            }
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
    // Guarda el tipo de hora
    public function guardar($data)
    {
        $seguridad = $this->seguridad(['Administrador']);
        if ($seguridad[0] === false) {
            abort(404);
        }  
        $dato = json_decode($data, true);
        $tipoHora['nombre_hora'] = $dato["Descripcion"];
        $tipoHora['hora_inicio'] = $dato["Inicio"];
        $tipoHora['hora_fin'] = $dato["Fin"];
        $tipoHora['tipo_id'] = $dato["Tipo"];
        $validador = $this->validatorSave($tipoHora);
        if ($validador->fails()) {
            return $validador->errors()->all();
        } else {
            $validador = $this->validar($tipoHora['hora_inicio'], $tipoHora['hora_fin']);
            if ($validador == 1) {
                // Formato de string
                $tipoHora['nombre_hora'] = $this->formatoTexto($tipoHora['nombre_hora']);
                $save = TipoHora::create($tipoHora);
                return (1);
            } else {
                return $validador;
            }
        }
    }
    // Valida la información del tipo de hora que quiere registrar
    public function validatorSave(array $data)
    {
        return Validator::make($data, [
            'nombre_hora' => 'required|max:70',
            'hora_inicio' => 'required',
            'hora_fin' => 'required',
            'tipo_id' => 'required',
        ]);
    }
    // Valida que el inicio debe ser menor al fin
    public function validar($inicio, $fin)
    {
        $msg = 1;
        if ($inicio > $fin) {
            $msg = "la fecha inicio debe ser menor a la fin";
        }
        return $msg;
    }
}
