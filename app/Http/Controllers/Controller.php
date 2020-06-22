<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    // Función para comprobar si es administrador
    public function administrador($rol)
    {
        $administrador = [];
        $administrador[0] = 1;
        $autentificador = [];
        $autentificador[0] = $rol;
        if ($autentificador[0] != $administrador[0]) {
            abort(404);
        }
    }

    // Funcion para comprobar si es funcionario
    public function funcionario($rol)
    {
        $funcionario = [];
        $funcionario[0] = 2;
        $autentificador = [];
        $autentificador[0] = $rol;
        if ($autentificador[0] != $funcionario[0]) {
            abort(404);
        }
    }
    // Función para colocar primera letra en mayuscula y quitar espacios en blanco
    public function formatoTexto($dato)
    {
        if (is_string($dato)) {
            $dato = trim($dato);
            $dato = mb_convert_case($dato, MB_CASE_TITLE, "UTF-8");
        }
        return ($dato);
    }
}
