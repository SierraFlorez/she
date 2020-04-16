<?php

namespace App\Http\Controllers;
// <modelos>
use App\Presupuesto;
// </modelos>
use Illuminate\Http\Request;
use Validator;


class PresupuestosController extends Controller
{
    // Retorna la vista de presupuestos
    public function index()
    {
        $presupuestos=Presupuesto::where('id','!=','0')->get();
        return view('presupuestos.index', compact('presupuestos'));
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

    
    public function store(Request $request)
    {
        //
    }

   
    public function show($id)
    {
        //
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
