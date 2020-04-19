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
        $horas=Hora::where('presupuesto_id','=',$id)->select('id','cargo_user_id','cargo_user_id','fecha','hi_solicitada','hf_solicitada','tipo_hora','id')->get();
        $presupuesto['horas']=$horas;
        
        return ($presupuesto);
    }

    //  Llena el modulo de detalle
    public function detalle($id)
    {
        $presupuesto=Presupuesto::find($id);
        $restante=$presupuesto['presupuesto_inicial']-$presupuesto['presupuesto_gastado'];
        $presupuesto['restante']=$restante;
        return ($presupuesto);
    }

   
  

    public function edit($id)
    {
        //
    }


    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        //
    }
}
