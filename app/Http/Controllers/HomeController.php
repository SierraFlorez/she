<?php

namespace App\Http\Controllers;
// Extiende modelo
use App\Role;

class HomeController extends Controller
{

    // Retorna la pagina de inicio
    public function index()
    {
        $roles = Role::all();
        return view('home.inicio', compact('roles'));
    }
}
