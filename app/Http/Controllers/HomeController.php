<?php

namespace App\Http\Controllers;
// Extiende modelo
use App\User;
use App\Role;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('auth');
    }
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Retorna la vista de inicio
        $roles= Role::all();
        return view('home.inicio', compact('roles'));
    }
}
