<?php

namespace App\Http\Controllers;
// <modelos>
use App\Presupuesto;
use App\Solicitud;
use App\TipoHora;
use App\Role;
use DB;

use Illuminate\Support\Facades\Auth;
// </modelos>
use Validator;

class PresupuestosController extends Controller
{
    // Retorna la vista de presupuestos
    public function index()
    {
        $roles = Role::orderBy('id', 'DESC')->get();
        $filtro = $this->administrador(Auth::user()->roles->id);
        $tipoHoras = TipoHora::all();
        $presupuestos = Presupuesto::where('id', '!=', '0')->orderBy('año','mes')
        ->select('presupuestos.*',DB::raw('(CASE 
        WHEN presupuestos.mes = 1 THEN "Enero"
        WHEN presupuestos.mes = 2 THEN "Febrero"
        WHEN presupuestos.mes = 3 THEN "Marzo"
        WHEN presupuestos.mes = 4 THEN "Abril"
        WHEN presupuestos.mes = 5 THEN "Mayo"
        WHEN presupuestos.mes = 6 THEN "Junio"
        WHEN presupuestos.mes = 7 THEN "Julio"
        WHEN presupuestos.mes = 8 THEN "Agosto"
        WHEN presupuestos.mes = 9 THEN "Septiembre"
        WHEN presupuestos.mes = 10 THEN "Octubre"
        WHEN presupuestos.mes = 11 THEN "Noviembre"
        WHEN presupuestos.mes = 12 THEN "Diciembre"
         END) AS mes'))
        ->get();
        return view('presupuestos.index', compact('presupuestos', 'tipoHoras','roles'));
    }
    // Guarda la información de las horas extras
    public function guardar($data)
    {
        $filtro = $this->administrador(Auth::user()->roles->id);
        $dato = json_decode($data, true);
        // dd($dato);
        $presupuesto['presupuesto_inicial'] = $dato["Presupuesto"];
        $presupuesto['mes'] = $dato["Mes"];
        $presupuesto['año'] = $dato["Año"];
        $presupuesto['presupuesto_gastado'] = 0;
        $validador = $this->validatorGuardar($presupuesto);
        if ($validador->fails()) {
            return $validador->errors()->all();
        }
        // En caso que exista un presupuesto ya en ese mes y año
        $presupuestoExistente = Presupuesto::where('mes', '=', $presupuesto['mes'])->where('año', '=', $presupuesto['año'])->first();
        if ($presupuestoExistente == !NULL) {
            $msg = "ese mes ya tiene un presupuesto asignado";
            return ($msg);
        }
        Presupuesto::create($presupuesto);
        return (1);
    }
    // Valida la información de la hora extra
    public function validatorGuardar(array $data)
    {
        return Validator::make($data, [
            'presupuesto_inicial' => 'required|numeric|min:1',
            'mes' => 'required',
            'año' => 'required',
        ]);
    }
    // Llena la tabla de presupuestos mostrando las horas extras de dicho presupuesto
    public function tabla($id)
    {
        $filtro = $this->administrador(Auth::user()->roles->id);
        $presupuesto = Presupuesto::Find($id);
        $presupuesto['restante'] = $presupuesto['presupuesto_inicial'] - $presupuesto['presupuesto_gastado'];
        $solicitudes = Solicitud::where('presupuesto_id', '=', $id)
            ->join('cargo_user', 'cargo_user.id', '=', 'solicitudes.cargo_user_id')
            ->join('cargos', 'cargo_user.cargo_id', '=', 'cargos.id')
            ->join('users', 'cargo_user.user_id', '=', 'users.id')
            ->join('tipo_horas', 'solicitudes.tipo_hora_id', '=', 'tipo_horas.id')
            ->select('solicitudes.id', 'users.nombres', 'users.apellidos', 'cargos.nombre', 'solicitudes.hora_inicio', 'solicitudes.hora_fin', 'tipo_horas.nombre_hora', 'total_horas')->get();
        $presupuesto['solicitudes'] = $solicitudes;
        return ($presupuesto);
    }
    //  Llena el modulo de detalles del presupuesto
    public function detalle($id)
    {
        $filtro = $this->administrador(Auth::user()->roles->id);
        $presupuesto = Presupuesto::find($id);
        $restante = $presupuesto['presupuesto_inicial'] - $presupuesto['presupuesto_gastado'];
        $presupuesto['restante'] = $restante;
        return ($presupuesto);
    }
    // Actualiza la información del presupuesto
    public function update($data)
    {
        $filtro = $this->administrador(Auth::user()->roles->id);
        $dato = json_decode($data, true);
        $presupuesto = Presupuesto::find($dato['Id']);
        $Presupuesto['id'] = $dato["Id"];
        $Presupuesto['año'] = $dato["Año"];
        $Presupuesto['mes'] = $dato["Mes"];
        $Presupuesto['presupuesto_inicial'] = $dato["Presupuesto"];
        $ok = $this->validatorUpdate($Presupuesto);
        if ($ok->fails()) {
            return $ok->errors()->all();;
        }
        $presupuesto->update($Presupuesto);
        return (1);
    }
    // Verifica la actualización
    public function validatorUpdate($request)
    {
        return Validator::make($request, [
            'año' => 'required',
            'mes' => 'required',
            'presupuesto_inicial' => 'required|numeric|min:1',
        ]);
    }
}
