<?php

namespace App\Http\Controllers;
// <modelos>
use App\Presupuesto;
use App\Hora;
use App\TipoHora;
// </modelos>
use Illuminate\Http\Request;
use Validator;


class PresupuestosController extends Controller
{
    // Retorna la vista de presupuestos
    public function index()
    {
        $tipoHoras=TipoHora::all();
        $presupuestos=Presupuesto::where('id','!=','0')->get();
        return view('presupuestos.index', compact('presupuestos','tipoHoras'));
    }
    // Guarda la información de las horas extras
    public function guardar($data)
    {
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
        $presupuestoExistente=Presupuesto::where('mes','=',$presupuesto['mes'])->where('año','=',$presupuesto['año'])->first();
        if ($presupuestoExistente== !NULL){
            $msg="ese mes ya tiene un presupuesto asignado";
            return ($msg);
        }
        Presupuesto::create($presupuesto);
        return (1);
    }
    // Valida la información de la hora extra
    public function validatorGuardar(array $data)
    {
        return Validator::make($data, [
            'presupuesto_inicial' => 'required|numeric|max:100000000|min:1000000',
            'mes' => 'required',
            'año' => 'required',
        ]);
    }
    // Llena la tabla de presupuestos mostrando las horas extras de dicho presupuesto
    public function horas($id)
    {
        $presupuesto=Presupuesto::Find($id);
        $presupuesto['restante']=$presupuesto['presupuesto_inicial']-$presupuesto['presupuesto_gastado'];
        $horas=Hora::where('presupuesto_id','=',$id)
        ->join('cargo_user','cargo_user.id','=','horas.cargo_user_id')
        ->join('cargos','cargo_user.cargo_id','=','cargos.id')
        ->join('users','cargo_user.user_id','=','users.id')
        ->join('tipo_horas','horas.tipo_hora','=','tipo_horas.id')
        ->select('horas.id','users.nombres','users.apellidos','cargos.nombre','hi_solicitada','hf_solicitada','tipo_horas.nombre_hora','horas.fecha')->get();
        $presupuesto['horas']=$horas;
        return ($presupuesto);
    }
    //  Llena el modulo de detalles del presupuesto
    public function detalle($id)
    {
        $presupuesto=Presupuesto::find($id);
        $restante=$presupuesto['presupuesto_inicial']-$presupuesto['presupuesto_gastado'];
        $presupuesto['restante']=$restante;
        return ($presupuesto);
    }
    // Actualiza la información del presupuesto
    public function update($data)
    {
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
            'presupuesto_inicial' => 'required|numeric|max:100000000|min:1000000',
        ]);
    }
}
