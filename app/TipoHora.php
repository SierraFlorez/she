<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TipoHora extends Model
{
    protected $table='tipo_horas';
    protected $primaryKey = 'id';
    protected $fillable = [
        'id','nombre_hora','hora_inicio','hora_fin','tipo_id'
    ];
}
