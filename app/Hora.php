<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Hora extends Model
{
    protected $table='horas';
    protected $fillable = ['cargo_user_id','fecha','hi_solicitada','hf_solicitada','tipo_hora','justificacion','autorizacion','hi_ejecutada','hf_ejecutada','presupuesto_id']; 

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
    public function presupuesto()
    {
        return $this->belongsTo('App\Presupuesto', 'presupuesto_id');
    }
}