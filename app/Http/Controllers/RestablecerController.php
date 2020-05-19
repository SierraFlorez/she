<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use App\Mail\RestablecerContrasena;
use Illuminate\Support\Facades\Mail;

class RestablecerController extends Controller
{

    public function index($data)
    {
        $dato = json_decode($data, true);
        $email = $dato['Correo'];
        // Usuario que coincide con el correo dado
        $user = User::where('email', $email)->first();
        if ($user != NULL) {
            // Numero aleatorio
            $password = rand(100000, 10000000);
            $obj = new \stdClass();
            $obj->sender = 'Administrador';
            $obj->receiver = $user['nombres']. " " .$user['apellidos'];
            $obj->password = $password;
            $mail = Mail::to($email)->send(new RestablecerContrasena($obj));
            if ($mail==NULL) {
                $msg = 1;
                $hash = bcrypt($password);
                $usuario=[];
                $usuario['password']=$hash;
                $user->update($usuario);
                return ($msg);
            } else {
                $msg = "hay un error al enviar el email";
                return ($msg);
            }
        } else {
            $msg = "el correo dado no se encuentra en la base de datos";
            return ($msg);
        }
    }
}
