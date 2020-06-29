<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Auth;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    
    // Función para comprobar si es el rol pedido (valida que sea el mismo nombre)
    public function seguridad($roles)
    {
        $rolUsuario = [];
        $rolUsuario[0] = Auth::User()->roles->nombre;
        $tieneAcceso[0] = false;
        foreach ($roles as $rol) {
            $autentificador[0] = $rol;
            if ($autentificador[0] === $rolUsuario[0]) {
                $tieneAcceso[0] = true;
                return $tieneAcceso;
            }
        }
        return $tieneAcceso;
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

    // Función para traer el mes al español
    public function mesEspañol($mes)
    {
        switch ($mes) {
            case 1:
                $mesEspañol = "Enero";
                break;
            case 2:
                $mesEspañol = "Febrero";
                break;
            case 3:
                $mesEspañol = "Marzo";
                break;
            case 4:
                $mesEspañol = "Abril";
                break;
            case 5:
                $mesEspañol = "Mayo";
                break;
            case 6:
                $mesEspañol = "Junio";
                break;
            case 7:
                $mesEspañol = "Julio";
                break;
            case 8:
                $mesEspañol = "Agosto";
                break;
            case 9:
                $mesEspañol = "Septiembre";
                break;
            case 10:
                $mesEspañol = "Octubre";
                break;
            case 11:
                $mesEspañol = "Noviembre";
                break;
            case 12:
                $mesEspañol = "Diciembre";
                break;
        }
        return ($mesEspañol);
    }
}
