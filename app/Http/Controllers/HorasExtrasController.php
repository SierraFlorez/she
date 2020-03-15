<?php

namespace App\Http\Controllers;

// <Modelos>
use App\Hora;
use App\User;

// </Modelos>
use Illuminate\Http\Request;
use Validator;
use Illuminate\Support\Facades\Auth;

class horasExtrasController extends Controller
{
    // Retorna la vista de horas del usuario
    public function index()
    {
        if (Auth::User()->role_id==1){
            $horas=Hora::join('cargo_user','cargo_user.id','=','horas.id_user_cargo')
                ->join('users','users.id','=','cargo_user.user_id')->join('cargos','cargos.id','=','cargo_user.cargo_id')->orderBy('id_user_cargo','asc')
                ->orderBy('fecha','asc')->orderBy('hora_inicio','asc')->get();
                // dd($horas);
            return view('horasExtras.index', compact('horas'));
        }
        else{
            $id=Auth::User()->cargos()->id;
            $horas=Hora::where('id_user_cargo',$id)->orderBy('fecha','asc')
            ->orderBy('hora_inicio','asc')->raw('hora_inicio','-','hora_fin')->get();
            return view('horasExtras.index',compact('horas'));

        }
    }

    // Lleva a la vista los usuarios que sean funcionarios, tengan estado activo, y tengan un CargoUsuario activo
    public function registrar()
    {
        $funcionarios = User::join('cargo_user', 'cargo_user.user_id', '=', 'users.id')->
            where([['users.estado', '=', 1], ['role_id', '=', 2], ['cargo_user.estado', '=', '1']])->get();
        // dd($funcionarios);
        $fecha=date('Y-m-d');
        $fecha=date('Y-m-d',strtotime('+1 days',strtotime($fecha)));
        // dd($fecha);
        return view('horasExtras.registrarHoras', compact('funcionarios','fecha'));

    }

    // Guarda la información de las horas extras
    public function guardar($data)
    {
        $dato = json_decode($data, true);
        $horasextras['id_user_cargo'] = $dato["Id"];
        $horasextras['fecha'] = $dato["Fecha"];
        $horasextras['hora_inicio'] = $dato["Inicio"];
        $horasextras['hora_fin'] = $dato["Fin"];
        $horasextras['tipo_hora'] = $dato["TipoHora"];
        $validador = $this->validatorHoraGuardar($horasextras);
        if ($validador->fails()) {
            return ('Todos los Campos son obligatorios');
        }
        $horaExistente = Hora::where([['id_user_cargo', '=', $horasextras['id_user_cargo']],
            ['fecha', '=', $horasextras['fecha']], ['hora_inicio', '=', $horasextras['hora_inicio']], 
            ['hora_fin', '=', $horasextras['hora_fin']]])->first();
        if($horaExistente==!NULL){
            // Valido si existe un registro con la misma fecha, en la misma hora para el mismo usuario
            $msg="Ya existe esa misma hora en esa misma fecha";
            return ($msg);
        }
        $horasYaTrabajadas= Hora::where([['id_user_cargo', '=', $horasextras['id_user_cargo']],['fecha','=',$horasextras['fecha']]])->get();
        foreach ($horasYaTrabajadas as $horasNoDisponibles){
            if(($horasextras['hora_inicio']>$horasNoDisponibles['hora_inicio']) && ($horasextras['hora_fin']<$horasNoDisponibles['hora_inicio'])){
                return ('Estimado Usuario; esas horas ya se encuentran registradas.');
            }
        }
        $totalHoras = $horasextras['hora_fin'] - $horasextras['hora_inicio'];
        if ($totalHoras >= 10 || $totalHoras <= 0) {
            // En caso que supere 10 horas o no hayan nigunas
            $msg="La cantidad de horas supera a 10";
            return ($msg);
        }
        
            Hora::create($horasextras);
            return (1);
    }
    // Valida la información de la hora extra
    public function validatorHoraGuardar(array $data)
    {
        return Validator::make($data, [
            'id_user_cargo' => 'required',
            'fecha' => 'required',
            'hora_inicio' => 'required',
            'hora_fin' => 'required',
            'tipo_hora' => 'required',
        ]);
    }

    public function update(Request $request, $id)
    {
        //
    }

}
