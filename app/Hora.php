<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Hora extends Model
{
    protected $table='horas';
    protected $fillable = ['id_user_cargo','fecha','hora_inicio','hora_fin','tipo_hora']; 

    public function users()
    {
        return $this->belongsTo('App\User', 'id_user');
    }
}
