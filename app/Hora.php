<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Hora extends Model
{
    protected $table='horas';
    protected $fillable = ['solicitud_id','fecha','hi_solicitada','hf_solicitada','justificacion','autorizacion','hi_ejecutada','hf_ejecutada']; 

    public function solicitud()
    {
        return $this->belongsTo('App\Solicitud', 'solicitud_id');
    }

}