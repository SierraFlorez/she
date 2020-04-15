<?php
namespace App;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
// Modelo de usuario
class User extends Authenticatable
{
    use Notifiable;
    protected $table='Users';
    protected $primaryKey = 'id';
    public $incrementing = true;
    protected $fillable = [
        'nombres','apellidos', 'email', 'password','tipo_documento','documento','regional','centro','telefono','estado','role_id'
    ];
    protected $hidden = [
        'password', 'remember_token',
    ];
    public function roles()
    {
        return $this->belongsTo('App\Role', 'role_id');
    }
    public function cargos()
    {
        return $this->hasMany('App\CargoUser','user_id','id');
    }
}