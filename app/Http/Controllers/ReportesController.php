<?php

namespace App\Http\Controllers;

// <Modelos>
use App\Hora;
use App\User;
use App\CargoUser;


// </Modelos>

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ReportesController extends Controller
{
    
    public function index()
    {
        $usuarios=CargoUser::where('estado',1)->get();
        return view('reportes.index', compact('usuarios'));
    }

    
    public function create()
    {
        //
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
