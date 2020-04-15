<?php

namespace App\Http\Controllers;
// <modelos>
use App\FechaEspecial;
use Validator;
// </modelos>


class FechasEspecialesController extends Controller
{
    // Retorna la pagina de inicio
    public function index()
    {
        // Retorna la vista de inicio
        $fechas = FechaEspecial::all();
        return view('fechasEspeciales.index', compact('fechas'));
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
        $dato = json_decode($data, true);
        $usuario['nombres'] = $dato["Nombres"];
        $usuario['apellidos'] = $dato["Apellidos"];
        $usuario['documento'] = $dato["Documento"];
        $usuario['estado'] = '1';
        $usuario['telefono'] = $dato["Telefono"];
        $usuario['email'] = $dato["Correo"];
        $usuario['role_id'] = $dato["Rol"];
        $usuario['tipo_documento'] = $dato["TipoDocumento"];
        $usuario['centro'] = $dato['Centro'];
        $usuario['regional'] = $dato['Regional'];
        $usuario['password'] = '$2y$10$vhKmPbvJOEwosRqFUIyV2eu7.gjOI7KVFJlJRxpbmqdHtPQuKdKp6';
        $validador = $this->validatorSave($usuario);
        if ($validador->fails()) {
            return $validador->errors()->all();
        } else {
            $usuariog = User::create($usuario);
            $cargoUsuario = [];
            $cargoUsuario['user_id'] = $usuariog->id;
            $cargoUsuario['cargo_id'] = $dato['cargo'];
            $cargoUsuario['estado'] = 1;
            CargoUser::create($cargoUsuario);

            return (1);
        }
    }
    // Valida la información del usuario que quiere registrar
    public function validatorSave(array $data)
    {
        return Validator::make($data, [
            'nombres' => 'required|max:70',
            'apellidos' => 'required|max:70',
            'tipo_documento' => 'required',
            'documento' => 'required|max:15|unique:users,documento',
            'email' => 'required|email|max:255|unique:users,email',
            'telefono' => 'required|max:70',
            'role_id' => 'required',
            'centro' => 'required',
            'regional' => 'required',
        ]);
    }

    // Actualiza la fecha especial
    public function update($data)
    {
        $dato = json_decode($data, true);
        $fecha = FechaEspecial::find($dato['Id']);
        $fechaEspecial['id'] = $dato["Id"];
        $fechaEspecial['descripcion'] = $dato["Nombre"];
        $fechaEspecial['fecha_inicio'] = $dato["Inicio"];
        $fechaEspecial['fecha_fin'] = $dato["Fin"];
        $ok = $this->validatorUpdate($fechaEspecial);
        if ($ok->fails()) {
            return $ok->errors()->all();;
        } elseif ($fechaEspecial['fecha_inicio'] > $fechaEspecial['fecha_fin']) {
            return ('La fecha inicio es mayor que la final');
        }
        $fecha->update($fechaEspecial);
        return (1);
    }

    // Verifica la actualización
    public function validatorUpdate($request)
    {
        return Validator::make($request, [
            'descripcion' => 'required|max:100|unique:tipo_horas,nombre_hora,' . $request['id'],
            'fecha_inicio' => 'required',
            'fecha_fin' => 'required',
        ]);
    }
}
