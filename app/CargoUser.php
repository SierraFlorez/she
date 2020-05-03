<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CargoUser extends Model
{
    protected $table='cargo_user';
    protected $primaryKey = 'id';
    protected $fillable = ['id','user_id','cargo_id','estado']; 

    public function users()
    {
        return $this->belongsTo('App\User', 'user_id');
    }
    public function cargos()
    {
        return $this->belongsTo('App\Cargo','cargo_id');
    }

    public function solicitudes()
    {
        return $this->hasMany('App\Solicitud','cargo_user_id','id');
    }
}
