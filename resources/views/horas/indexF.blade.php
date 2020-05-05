{{-- extiende plantilla principal --}}
@extends('app')
{{-- da un nombre al titulo de la pestaña--}}
@section('htmlheader_title')
Gestión Horas Extras
@endsection
{{-- contenido de la pagina principal (solo ventana) --}}
@section('main-content')
<div class="row">
    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
        <div class="card" style="margin-top: 5%">
            <center>
                <h1>Gestionar Horas Extras </h1>
            </center><br>
            <div class="row" style="padding-left: 2%;">
                <div style="margin-bottom: 1%" class="col-md-9">
                    <a class="btn btn-success" href="{{ url("/registrar_horas") }}">Registrar Horas Extras </a>
                </div>
                <div class="col-md-1">
                    <a class="btn btn-success" href="{{ url("/registrar_solicitud") }}">Registrar Solicitud </a>
                </div>
            </div>
            <div style="margin-top: 1%; padding-left: 2%;padding-right: 2%">
                <label data-error="wrong" data-success="right" for="orangeForm-name">Seleccionar Solicitud</label>
                <select class="form-control validate" id="seleccionar_usuario" name="" onchange="selectSolicitud();">
                    <option value="0"></option>
                    @foreach ($solicitudes as $solicitud)
                    <option value="{{$solicitud->id}}">{{$solicitud->actividades}}</option>
                    @endforeach
                </select>
            </div>
            <div style="margin-top:1%;padding-left: 2%" id="select_presupuesto" class="row">
            </div>
            <div class="card-header" id="div_horas">
                <center><h2> Horas Registradas </h2></center>
                <table id="dthorasExtras" class="table table-hover " cellspacing="0" width="100%"
                    style="text-align: center">
                    <thead class="thead">
                        <tr>
                            <th class="th-sm">Usuario</th>
                            <th class="th-sm">Cargo</th>
                            <th class="th-sm">Fecha</th>
                            <th class="th-sm">Hora Inicio</th>
                            <th class="th-sm">Hora Fin</th>
                            <th class="th-sm">Tipo de Hora</th>
                            <th class="th-sm">Acción</th>
                        </tr>
                    </thead>
                    {{-- js 639 --}}
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@include('horas.modalVerDetallesHora')
@include('solicitudes.modalDetallesSolicitud')
@endsection