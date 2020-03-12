<?php

namespace App\Http\Controllers;

// Extiende los modelos
use App\Cargo;
use App\Role;
use App\User;
use App\CargoUser;
use Validator;

class UsuariosController extends Controller
{
    // Trae a la lista de usuarios a la datatable
    public function index()
    {
        $cargos = Cargo::all();
        $usuarios = User::select('id', 'nombres', 'apellidos', 'documento', 'estado')->get();
        $roles = Role::orderBy('id', 'DESC')->get();
        return view('usuarios.index', compact('usuarios', 'cargos', 'roles'));
    }
    // Guarda el usuario en la bd
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
            return (0);
        } else {
            $usuariog=User::create($usuario);
            $cargoUsuario=[];
            $cargoUsuario['user_id']=$usuariog->id;
            $cargoUsuario['cargo_id']=$dato['cargo'];
            $cargoUsuario['estado']=1;
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

    public function registrar()
    {
        return view('usuarios.registrar');
    }
    // Trae toda la información del usuario para el modal detalle
    public function detalle($id)
    {
        $usuario = User::find($id);
        $cargoVigente = $usuario->cargos()->where('estado', '1')->get();
        $cargo = Cargo::find($cargoVigente[0]->cargo_id);
        $usuarioDetalle = [];
        $usuarioDetalle['usuario'] = $usuario;
        $usuarioDetalle['cargo'] = $cargo;
        return ($usuarioDetalle);
    }
    // Actualiza la información del usuario
    public function update($data)
    {
        $dato = json_decode($data, true);
        $user = User::find($dato['Id']);
        $usuario['id'] = $dato["Id"];
        $usuario['nombres'] = $dato["Nombres"];
        $usuario['apellidos'] = $dato["Apellidos"];
        $usuario['documento'] = $dato["Documento"];
        $usuario['cargo'] = $dato["Cargo"];
        $usuario['sueldo'] = $dato["Sueldo"];
        $usuario['regional'] = $dato["Regional"];
        $usuario['centro'] = $dato["Centro"];
        $usuario['email'] = $dato["Correo"];
        $usuario['telefono'] = $dato["Telefono"];
        $usuario['tipo_documento'] = $dato["TipoDocumento"];
        $ok = $this->validatorUpdate($usuario);
        if ($ok->fails()) {
            return (0);
        } else {
            $user->update($usuario);
            return (1);
        }
    }
    // Verifica la actualización
    public function validatorUpdate($request)
    {
        return Validator::make($request, [
            'nombres' => 'required|max:100',
            'apellidos' => 'required|max:100',
            'documento' => 'required|max:15|unique:users,documento,' . $request['id'],
            'email' => 'required|email|max:255|unique:users,email,' . $request['id'],
            'telefono' => 'required|max:15',
        ]);
    }
    // Cambia el estado a activo
    public function activar($id)
    {
        $usuario = User::find($id);
        $usuario->estado = '1';
        $usuario->save();
        return ($usuario);
    }
    // Cambia el estado a inactivo
    public function inactivar($id)
    {
        $usuario = User::find($id);
        $usuario->estado = '0';
        $usuario->save();
        return ($usuario);
    }
    // Función para cambiar la contraseña del usuario que inicio sesión
    public function cambiar_password($data)
    {

        $data2 = json_decode($data, true);
        $usuario = User::find($data2["id"]);
        if ($usuario != null) {
            $usuario->password = bcrypt($data2['contraseña']);
            $usuario->save();
            return json_encode($usuario);
        } else {
            $msg = "No se pudo cambiar la contraseña";
            return $msg;
        }
    }
}
