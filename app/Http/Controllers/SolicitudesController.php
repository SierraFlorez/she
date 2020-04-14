<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\CargoUser;
use App\Cargo;
use Auth;

class SolicitudesController extends Controller
{
    // Vista de descargar reportes y trae todos los usuarios con su cargo vigente
    public function index()
    {
        // $usuarios = CargoUser::where('estado', 1)->get();
        return view('solicitudes.index');
    }

    public function crear_solicitud()
    {
        $funcionarios=User::where('id',Auth::User()->id)->get();
        $cargos=CargoUser::where('user_id',Auth::User()->id)->where('estado',1)->get();
        foreach ($cargos as $key => $value) {
            $cargos1=Cargo::where('id',$value->cargo_id)->get();
        }
        return view('solicitudes.solicitar',compact('funcionarios','cargos1','cargos'));
    }
}
