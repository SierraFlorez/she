<?php

namespace App\Http\Controllers;
// <Modelos>
use App\Hora;
use App\TipoHora;
use App\Cargo;
use App\CargoUser;
use App\FechaEspecial;
use App\User;
use App\Presupuesto;
use App\Solicitud;

// </Modelos>
use Validator;
use Illuminate\Support\Facades\Auth;

class SolicitudesController extends Controller
{
    // Vista para registrar solicitudes
    public function registrar()
    {
        $funcionario =
            CargoUser::join('users', 'cargo_user.user_id', '=', 'users.id')
            ->join('cargos', 'cargo_user.cargo_id', '=', 'cargos.id')->where([['users.estado', '=', 1], ['cargo_user.estado', '=', '1']])
            ->where('users.id', '=', Auth::user()->id)->select('cargo_user.id', 'users.documento', 'users.nombres', 'users.apellidos', 'cargos.nombre')->first();
        // dd($funcionario);
        $fecha = date('Y-m-d');
        $fecha = date('Y-m-d', strtotime('+1 days', strtotime($fecha)));
        $tipoHoras = TipoHora::all();
        return view('solicitudes.registrarSolicitud', compact('funcionario', 'fecha', 'tipoHoras', 'id'));
    }

    // Guarda la solicitud
    public function guardar($data)
    {
        $dato = json_decode($data, true);
        // dd($dato);
        $solicitud['cargo_user_id'] = $dato["Id"];
        $solicitud['tipo_hora_id'] = $dato["TipoHora"];
        $solicitud['total_horas'] = $dato["Horas"];
        $solicitud['hora_inicio'] = $dato["Inicio"] . ':00';
        $solicitud['hora_fin'] = $dato["Fin"] . ':00';
        $solicitud['actividades'] = $dato["Actividad"];
        $solicitud['autorizacion'] = 0;
        $presupuesto = Presupuesto::where('año', $dato['Año'])->where('mes', $dato['Mes'])->first();
        if ($presupuesto == NULL) {
            $msg = "El mes y el año seleccionado, no cuentan con un presupuesto";
            return ($msg);
        }
        $solicitud['presupuesto_id'] = $presupuesto['id'];
        $validador = $this->validator($solicitud);
        if ($validador->fails()) {
            return $validador->errors()->all();
        }
         Solicitud::create($solicitud);
        return (1);
    }

    // Valida la información de la hora extra
    public function validator(array $data)
    {
        return Validator::make($data, [
            'tipo_hora_id' => 'required',
            'cargo_user_id' => 'required',
            'hora_inicio' => 'required',
            'hora_fin' => 'required',
            'actividades' => 'required',
            'total_horas' => 'required',
        ]);
    }
}
