<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Auditoria extends Model
{
    protected $table='auditoria';
    protected $fillable = ['id_user','cargo_user_id','fecha','diurnas','nocturnas','dominicales','nocturno']; 

    public function users()
    {
        return $this->belongsTo('App\User', 'id_user');
    }
    public function userscargos()
    {
        return $this->belongsTo('App\User_cargo', 'cargo_user_id');
    }
}
