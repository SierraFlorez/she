<h1> Sistema de Horas Extras</h1>
Hola <i>{{ $obj->receiver }}</i>,
<p>Se ha pedido un restablecimiento de su contraseña en el aplicativo SHE.</p>
<p>La contraseña para iniciar sesión en la aplicación es:</p>

<div>
    <b>{{ $obj->password }}</b>
</div>

<p>Se recomienda que después de iniciar sesión cambie la contraseña que deseé en el mismo aplicativo a través del menu de perfil.</p>

<div>

</div>

Atentamente el <i>{{ $obj->sender }}</i>.