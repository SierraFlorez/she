<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Horas extends Model
{
    protected $table='horas';
    protected $fillable = ['id_user','fecha','hora_inicio','hora_fin','diurnas','nocturnas','dominicales','nocturno']; 

    public function users()
    {
        return $this->belongsTo('App\User', 'id_user');
    }
}
