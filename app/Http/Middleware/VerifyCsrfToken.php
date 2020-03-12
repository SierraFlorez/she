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
        '/registrar/horas/guardar/*',
    ];
}
