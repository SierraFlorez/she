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
        '/horas/detalle/*',
        '/horas/update/*',
        '/horas/tabla/*',
        // Reportes
        '/reportes/solicitudAutorizacion/*',
        // Tipo Horas
        '/tipo_horas/detalle/*',
        '/tipo_horas/update/*',
        // Fechas especiales
        '/fechas_especiales/detalle/*',
        '/fechas_especiales/update/*',
        '/fechas_especiales/save/*',
        // Presupuesto
        '/presupuesto/save/*',
        '/presupuesto/tabla/*',
        '/presupuesto/detalle/*',
        '/presupuesto/update/*',
        // Solicitudes
        '/solicitud/guardar/*',
        '/solicitudes/*',
        '/solicitudes/detalles/*',
        '/solicitudes/update/*',
        '/solicitudes/autorizar/*',



    ];
}
