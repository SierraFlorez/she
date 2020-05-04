<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Hora extends Model
{
    protected $table='horas';
    protected $fillable = ['solicitud_id','fecha','hi_registrada','hf_registrada','horas_trabajadas']; 

    public function solicitud()
    {
        return $this->belongsTo('App\Solicitud', 'solicitud_id');
    }

}