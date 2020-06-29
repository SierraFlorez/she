{{-- extiende plantilla principal --}}
@extends('app')
{{-- da un nombre al titulo de la pestaña--}}
@section('htmlheader_title')
Gestión Horas Extras
@endsection
{{-- contenido de la pagina principal (solo ventana) --}}
@section('main-content')
<div class="row animated fadeInDown">
    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
        <div class="card" style="margin-top: 5%">
            <center>
                <h1>Gestionar Horas Extras </h1>
            </center><br>
            <div class="row" style="padding-left: 2%;">
                <div style="margin-bottom: 1%" class="col-md-2 col-6">
                    <a class="btn btn-success" href="{{ url("/registrar_solicitud_saf") }}">Horario Instructor </a>
                </div>
                <div class="col-md-1 col-6">
                    <a class="btn btn-success" href="{{ url("/registrar_solicitud") }}">Registrar Solicitud </a>
                </div>
            </div>
            <div style="margin-top:1%;padding-left: 2%" id="select_presupuesto" class="row">
            </div>
            <div class="card-header" id="div_horas">
                <center>
                    <h2> Solicitudes </h2>
                </center>
                <table id="dthorasExtras" class="table table-hover " cellspacing="0" width="100%"
                    style="text-align: center">
                    <thead class="thead">
                        <tr>
                            <th class="th-sm">ID</th>
                            <th class="th-sm">Usuario</th>
                            <th class="th-sm">Mes y Año</th>
                            <th class="th-sm">Hora Inicio</th>
                            <th class="th-sm">Hora Fin</th>
                            <th class="th-sm">Acción</th>
                            <th class="th-sm">Autorizar</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($solicitudes as $solicitud)
                        <tr>
                            <td>{{$solicitud->id}}</td>
                            <td>{{$solicitud->nombres}} {{$solicitud->apellidos}}</td>
                            <td>{{$solicitud->mes}} del {{$solicitud->año}}</td>
                            <td>{{$solicitud->hora_inicio}}</td>
                            <td>{{$solicitud->hora_fin}}</td>
                            <td><button class="btn btn-primary" data-toggle="modal"
                                    data-target="#modalDetallesSolicitud"
                                    onclick="detallesSolicitud({{$solicitud->id}})">Editar</button>
                                <button class="btn btn-success" data-toggle="modal" data-target="#modalTableHoras"
                                    onclick="modalHoras({{$solicitud->id}})">Horas</button>
                            </td>
                            <td> @if ($solicitud->autorizacion==0)
                                <button class="btn btn-danger" onclick="autorizarSolicitud('{{$solicitud->id}}')"> No
                                    Autorizado </button>
                                    <button class="btn btn-danger" onclick="eliminarSolicitud('{{$solicitud->id}}')">
                                        Eliminar </button>
                                @else
                                <button class="btn btn-primary"> Autorizado </button>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@include('horas.modalVerHoras')
@include('solicitudes.modalDetallesSolicitud')
@endsection