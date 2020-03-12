<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cargo extends Model
{
    protected $table='cargos';
    protected $fillable = ['nombre','sueldo','valor_diurna','valor_nocturna','valor_dominical','valor_recargo'];

    public function users()
    {
        return $this->hasMany('App\CargoUser','cargo_id','id');
    }
}
