<?php

namespace App\Http\Controllers;
// Extiende modelo
use App\User;
use App\Role;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    
    public function __construct()
    {
        // $this->middleware('auth');
    }
    
    // Retorna la pagina de inicio
    public function index()
    {
        // Retorna la vista de inicio
        $roles= Role::all();
        return view('home.inicio', compact('roles'));
    }
}
