<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Solicitud extends Model
{
    protected $table='solicitudes';
    protected $fillable = ['presupuesto_id','tipo_hora_id','cargo_user_id','total_horas','hora_inicio','hora_fin','actividades','autorizacion']; 

    public function users()
    {
        return $this->belongsTo('App\CargoUser', 'cargo_user_id');
    }

    public function tipoHoras()
    {
        return $this->belongsTo('App\TipoHora', 'tipo_hora_id');
    }

    public function autorizo()
    {
        return $this->belongsTo('App\Users', 'autorizacion');
    }

    public function presupuesto()
    {
        return $this->belongsTo('App\Presupuesto', 'presupuesto_id');
    }
}
