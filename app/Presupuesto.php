<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Presupuesto extends Model
{
    protected $table='presupuestos';
    protected $primaryKey = 'id';
    protected $fillable = ['presupuesto_inicial','presupuesto_final','mes','año'];

    public function horas()
    {
        return $this->hasMany('App\Hora','presupuesto_id','id');
    }
}