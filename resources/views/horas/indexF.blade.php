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
                <h1>Mis solicitudes</h1>
            </center><br>
            <div class="card-header" id="div_horas">
                <table id="dthorasExtras" class="table table-hover " cellspacing="0" width="100%"
                    style="text-align: center">
                    <thead class="thead">
                        <tr>
                            <th class="th-sm">ID</th>
                            <th class="th-sm">Mes y Año</th>
                            <th class="th-sm">Hora Inicio</th>
                            <th class="th-sm">Hora Fin</th>
                            <th class="th-sm">Acción</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($solicitudes as $solicitud)
                        <tr>
                            <td>{{$solicitud->id}}</td>
                            <td>{{$solicitud->mes}} del {{$solicitud->año}}</td>
                            <td>{{$solicitud->hora_inicio}}</td>
                            <td>{{$solicitud->hora_fin}}</td>
                            <td><button class="btn btn-primary" data-toggle="modal"
                                    data-target="#modalDetallesSolicitud"
                                    onclick="detallesSolicitud({{$solicitud->id}})">Ver Detalles</button>
                                <button class="btn btn-success" data-toggle="modal" data-target="#modalTableHoras"
                                    onclick="modalHoras({{$solicitud->id}},{{Auth::User()->roles->id}})">Horas</button>
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