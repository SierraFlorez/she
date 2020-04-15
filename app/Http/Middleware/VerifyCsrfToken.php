<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as BaseVerifier;

class VerifyCsrfToken extends BaseVerifier
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array
     */
    // Permite el metodo post
    protected $except = [
        // Usuarios
        '/logout',
        '/usuarios/detalle/*',
        '/usuarios/detalleCargo/*',
        '/usuarios/cambiarCargo/*',
        '/usuarios/actualizar/*',
        '/usuarios/activar/*',
        '/usuarios/inactivar/*',
        '/registrar/guardar/*',
        '/passreset/*',
        // Cargos
        '/cargos/detalle/*',
        '/cargos/update/*',
        '/cargos/guardar/*',
        // Horas Extras
        '/horas/guardar/*',
        // Reportes
        '/reportes/solicitudAutorizacion/*',
        // Tipo Horas
        '/tipo_horas/detalle/*',
        '/tipo_horas/update/*',
        // Fechas especiales
        '/fechas_especiales/detalle/*',
        '/fechas_especiales/update/*'


    ];
}
