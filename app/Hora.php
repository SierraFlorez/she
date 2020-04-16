<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Hora extends Model
{
    protected $table='horas';
    protected $fillable = ['cargo_user_id','fecha','hora_inicio','hora_fin','tipo_hora','justificacion','autorizacion','ejecucion']; 

    public function users()
    {
        return $this->belongsTo('App\CargoUser', 'cargo_user_id');
    }

    public function tipoHoras()
    {
        return $this->belongsTo('App\TipoHora', 'tipo_hora');
    }
    public function autorizo()
    {
        return $this->belongsTo('App\Users', 'autorizacion');
    }
}