<?php

namespace App\Http\Controllers;

// <Extiende los modelos>
use App\Cargo;
use App\Role;
use App\User;
use App\CargoUser;
use Illuminate\Support\Facades\Auth;

// </Extiende los modelos>

use Validator;

class UsuariosController extends Controller
{
    // Trae a la lista de usuarios a la datatable
    public function index()
    {
        $filtro = $this->administrador(Auth::user()->roles->id);
        $cargos = Cargo::where('id', '!=', 0)->get();
        $usuarios = User::select('id', 'nombres', 'apellidos', 'documento', 'estado')->where('id', '!=', 0)->get();
        $roles = Role::orderBy('id', 'DESC')->get();
        return view('usuarios.index', compact('usuarios', 'cargos', 'roles'));
    }
    // Guarda el usuario en la bd
    public function save($data)
    {
        $filtro = $this->administrador(Auth::user()->roles->id);
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
        if ($usuario['role_id'] == 1) {
            $usuario['cargo_id'] = 0;
        }
        else{
            $usuario['cargo_id'] = $dato['cargo'];
        }
        $usuario['cargo'] = $dato['cargo'];
        $usuario['password'] = '$2y$10$vhKmPbvJOEwosRqFUIyV2eu7.gjOI7KVFJlJRxpbmqdHtPQuKdKp6';
        $validador = $this->validatorSave($usuario);
        if ($validador->fails()) {
            return $validador->errors()->all();
        } else {
            // Formato de string
            $usuario['nombres'] = $this->formatoTexto($usuario['nombres']);
            $usuario['apellidos'] = $this->formatoTexto($usuario['apellidos']);
            $usuariog = User::create($usuario);
            $cargoUsuario = [];
            // Condicional si el rol es 1 se le asigna el cargo 0
            if ($usuario['role_id'] == 1) {
                $cargoUsuario['cargo_id'] = 0;
            } else {
                $cargoUsuario['cargo_id'] = $dato['cargo'];
            }
            $cargoUsuario['user_id'] = $usuariog->id;
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
            'role_id' => 'required',
            'centro' => 'required',
            'regional' => 'required',
            'cargo_id' => 'required'
        ]);
    }
    // Valida para llenar la tabla CargoUsuario
    public function validatorCargoUsuario(array $data)
    {
        return Validator::make($data, [
            'user_id' => 'required|max:70',
            'cargo_id' => 'required|max:70',
            'estado' => 'required'
        ]);
    }

    // Trae toda la información del usuario para el modal detalle
    public function detalle($id)
    {
        $usuario = User::find($id);
        $cargoVigente = $usuario->cargos()->where('estado', '1')->first();
        if (empty($cargoVigente)) {
            $cargo['nombre'] = "Administrador";
        } else {
            $cargo = Cargo::find($cargoVigente->cargo_id);
        }
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
        $usuario['regional'] = $dato["Regional"];
        $usuario['centro'] = $dato["Centro"];
        $usuario['email'] = $dato["Correo"];
        $usuario['telefono'] = $dato["Telefono"];
        $usuario['tipo_documento'] = $dato["TipoDocumento"];
        $usuario['role_id'] = $dato["Rol"];
        if ($usuario['role_id']==1){
            $usuario['cargo'] = 0;
        }else{
            $usuario['cargo'] = $dato['Cargo'];
        }
        $cargoActual = $user->cargos->where('estado', 1)->first();
        $ok = $this->validatorUpdate($usuario);
        if ($ok->fails()) {
            return $ok->errors()->all();;
        } else {
            // Condicional en caso que haya cambiado el cargo
            if ($usuario['cargo'] != $cargoActual['cargo_id']) {
                $cambiarCargo = $this->cambiarCargo($usuario['cargo'], $usuario['id']);
                if ($cambiarCargo != 1) {
                    return "Hubo un fallo al cambiar el cargo";
                }
            }
            // Formato de string
            $usuario['nombres'] = $this->formatoTexto($usuario['nombres']);
            $usuario['apellidos'] = $this->formatoTexto($usuario['apellidos']);
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
            'cargo' => 'required',
            'documento' => 'required|max:15|unique:users,documento,' . $request['id'],
            'email' => 'required|email|max:255|unique:users,email,' . $request['id'],
        ]);
    }
    // Trae toda la información del usuario para el modal cargo del usuario
    public function cargo($id)
    {
        $usuario = User::find($id);
        $cargoVigente = $usuario->cargos()->where('estado', '1')->first();
        $cargo = Cargo::find($cargoVigente->cargo_id);
        $usuarioDetalle = [];
        $usuarioDetalle['usuario'] = $usuario;
        $usuarioDetalle['cargo'] = $cargo;
        return ($usuarioDetalle);
    }
    // Cambia el cargo de un usuario, solo puede tener uno vigente
    public function cambiarCargo($cargo, $usuario)
    {
        $filtro = $this->administrador(Auth::user()->roles->id);
        $cargoVigente['user_id'] = $usuario;
        $cargoVigente['cargo_id'] = $cargo;
        $cargoVigente['estado'] = 1;
        $mismoCargoVigente = CargoUser::where([
            ['user_id', '=', $cargoVigente['user_id']],
            ['cargo_id', '=', $cargoVigente['cargo_id']], ['estado', '=', 1]
        ])->first();
        // Condicional en caso que sea el mismo cargo
        if ($mismoCargoVigente == !NULL) {
            return ('El usuario tiene vigente ese mismo cargo.');
        }
        $cargosAntiguos = CargoUser::where('user_id', $cargoVigente['user_id'])->get();
        // Ciclo para buscar todos los cargos y si alguno tiene el estado 1
        foreach ($cargosAntiguos as $cargoAntiguo) {
            if ($cargoAntiguo->estado == 1) {
                $cargoInactivo['estado'] = 0;
                $cargoAntiguo->update($cargoInactivo);
            }
        }
        $mismoCargo = CargoUser::where([
            ['user_id', '=', $cargoVigente['user_id']],
            ['cargo_id', '=', $cargoVigente['cargo_id']]
        ])->first();
        // Condicional para buscar si el usuario tiene desactivado ese mismo cargo y en ese caso se actualiza para que sea vigente
        if ($mismoCargo == !NULL) {
            $cambioEstado['estado'] = 1;
            $mismoCargo->update($cambioEstado);
            return (1);
        } else {
            // En caso contrario se crea
            CargoUser::create($cargoVigente);
            return (1);
        }
    }
    // Cambia el estado a activo
    public function activar($id)
    {
        $filtro = $this->administrador(Auth::user()->roles->id);
        $usuario = User::find($id);
        $usuario->estado = '1';
        $usuario->save();
        return ($usuario);
    }
    // Cambia el estado a inactivo
    public function inactivar($id)
    {
        $filtro = $this->administrador(Auth::user()->roles->id);
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
