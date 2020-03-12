{{-- extiende plantilla principal --}}
@extends('app')
{{-- da un nombre al titulo de la pestaña--}}
@section('htmlheader_title')
Consultar usuarios
@endsection
{{-- contenido de la pagina principal (solo ventana) --}}
@section('main-content')

<div class="row">
    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
        <div class="card" style="margin-top: 5%">
            <center>
                <h1> Lista De Usuarios </h1>
            </center><br>
            <div style="padding-left: 3%;">
                <a data-toggle="modal" data-target="#modalRegistrarUsuario" id="" class="btn btn-outline-success">
                    Registrar Usuario </a>
            </div>
            <div class="card-header" id="table_div_user">
                <table id="dtUsuarios" class="table table-hover table-dark" cellspacing="0" width="100%">
                    <thead class="thead-dark">
                        <tr>
                            <th class="th-sm">ID</th>
                            <th class="th-sm">Documento</th>
                            <th class="th-sm">Nombre</th>
                            <th class="th-sm">Apellidos</th>
                            <th class="th-sm">Estado</th>
                            <th class="th-sm">Acción</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($usuarios as $usuario)
                        <tr>
                            <td>{{ $usuario->id}}</td>
                            <td>{{ $usuario->documento}}</td>
                            <td>{{ $usuario->nombres}}</td>
                            <td>{{ $usuario->apellidos}}</td>
                            @if ($usuario->estado=='1')
                            <td><button class="btn btn-success" onclick="inactivar({{ $usuario->id}},this)">Activo
                                </button></td>
                            @else
                            <td><button class="btn btn-danger" onclick="activar({{ $usuario->id}},this)">Inactivo
                                </button></td>
                            @endif
                            <td><button class="btn btn-primary" data-toggle="modal" data-target="#modalDetalle"
                                    onclick="detallesUsuario({{ $usuario->id}})">Ver Detalles</button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@include('usuarios.modalVerDetalles')
@include('usuarios.modalRegistrarUsuario')
@endsection