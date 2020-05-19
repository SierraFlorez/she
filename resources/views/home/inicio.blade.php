{{-- extiende plantilla principal --}}
@extends('app')
{{-- da un nombre al titulo de la pestaña--}}
@section('htmlheader_title')
Inicio
@endsection
{{-- contenido de la pagina principal (solo ventana) --}}
@section('main-content')
{{-- Si el usuario no ha iniciado sesión --}}
@if(Auth::guest())
@include ('partials.modalRestaurar')
<div class="container">
    <div class="row">
        <div class="col-md-7 col-md-offset-2 login loginr animated fadeInDown">
            <div class="panel panel-default">
                <br>
                <div class="panel-body row">
                    <div class="col-md-6">
                        <img src="{{URL::asset('images/imagotipo.png')}}" width="100%">
                    </div>
                    <div class="col-md-6">
                        <form class="form-horizontal" method="POST" action="{{ route('login') }}">
                            {{ csrf_field() }}
                            <div class="form-group{{ $errors->has('documento') ? ' has-error' : '' }}">
                                <label for="email" class="col-md-4 control-label">Documento</label>
                                <div class="col-md-12">
                                    <input id="documento" autocomplete="off" type="text" class="form-control"
                                        name="documento" value="{{ old('documento') }}" required autofocus>
                                    @if ($errors->has('documento'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('documento') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                                <label for="password" class="col-md-4 control-label">Contraseña</label>
                                <div class="col-md-12">
                                    <input id="password" type="password" class="form-control" name="password" required>
                                    @if ($errors->has('password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-md-8 col-md-offset-4">
                                    <button type="submit" class="btn btn-primary">
                                        Iniciar Sesión
                                    </button>
                                    <a class="btn linkr" data-toggle="modal" data-target="#modalRestaurar">                                        ¿Olvido su contraseña?
                                    </a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@else
{{-- Si el usuario ya inicio sesión --}}
{{-- <div class="row">
    <div class="card w-100"> --}}
<div class="col-md-5 col-md-offset-2 logind loginr animated fadeInDown">
    <div>
        <h1> Bienvenido(@)</h1>
        <h2> Rol: {{Auth::User()->roles->nombre}}</h2>
        <hr>
        <h3> Bienvenido al Sistema de Horas Extras: <br> {{ Auth::user()->nombres }}
            @if(Auth::User()->password=='$2y$10$vhKmPbvJOEwosRqFUIyV2eu7.gjOI7KVFJlJRxpbmqdHtPQuKdKp6')
            <br>
            <p style="color:#f0346e">Se recomienda cambiar su contraseña</p>
            @endif
        </h3>
    </div>
</div>
@endif
@endsection