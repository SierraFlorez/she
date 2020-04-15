<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FechaEspecial extends Model
{
    protected $table='fechas_especiales';
    protected $primaryKey = 'id';
    protected $fillable = [
        'fecha_inicio','fecha_fin', 'descripcion'
    ];
}