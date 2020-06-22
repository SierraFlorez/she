<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tipo extends Model
{
    protected $table='tipos';
    protected $fillable = ['descripcion']; 

    public function tipo_horas()
    {
        return $this->hasMany('App/TipoHora');
    }
}
