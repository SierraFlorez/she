{{-- extiende plantilla principal --}}
@extends('app')
{{-- da un nombre al titulo de la pestaña--}}
@section('htmlheader_title')
Gestión Presupuesto
@endsection
{{-- contenido de la pagina principal (solo ventana) --}}
@section('main-content')
<div class="row animated fadeInDown">
    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
        <div class="card" style="margin-top: 5%"><br>
            <center>
                <h1> Gestión de Presupuesto</h1>
            </center><br>
            <div style="padding-left: 2%;">
                <a style="color:white" class="btn btn-success" data-toggle="modal"
                    data-target="#modalRegistrarPresupuesto">Registrar Presupuesto</a>
            </div>
            <div class="card-header" id="div_presupuesto">
                <table style="text-align: center" id="dtPresupuestos" class="table table-hover" cellspacing="0"
                    width="100%">
                    <thead class="thead">
                        <tr>
                            <th class="th-sm">ID</th>
                            <th class="th-sm">Presupuesto Inicial</th>
                            <th class="th-sm">Presupuesto Restante</th>
                            <th class="th-sm">Año</th>
                            <th class="th-sm">Mes</th>
                            <th class="th-sm">Acción</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($presupuestos as $presupuesto)
                        <tr>
                            <td>{{$presupuesto->id}}</td>
                            <td>{{$presupuesto->presupuesto_inicial}}</td>
                            <td>{{$presupuesto->presupuesto_inicial-$presupuesto->presupuesto_gastado}}</td>
                            <td>{{$presupuesto->año}}</td>
                            <td>{{$presupuesto->mes}}</td>
                            <td>
                                <button class="btn btn-primary" data-toggle="modal"
                                    data-target="#modalDetallePresupuesto"
                                    onclick="detallesPresupuesto({{ $presupuesto->id}})">Editar</button>
                                <button class="btn btn-success" data-toggle="modal" data-target="#modalTableSolicitudes"
                                    onclick="modalSolicitudes({{ $presupuesto->id}})">Solicitudes</button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
</div>
@include('presupuestos.modalRegistrarPresupuesto')
@include('presupuestos.modalDetallesPresupuesto')
@include('presupuestos.modalVerSolicitudes')
@endsection