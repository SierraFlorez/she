{{-- extiende plantilla principal --}}
@extends('app')
{{-- da un nombre al titulo de la pestaña--}}
@section('htmlheader_title')
Consultar Cargos
@endsection
{{-- contenido de la pagina principal (solo ventana) --}}
@section('main-content')

<div class="row animated fadeInDown">
    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
        <div class="card" style="margin-top: 5%">
            <center>
                <h1> Lista de Cargos </h1>
            </center><br>
            <div style="padding-left: 2%;">
                <a data-toggle="modal" data-target="#modalRegistrarCargo" id="" class="btn btn-success" style="color: white">
                    Registrar Cargo</a>
            </div>
            <div class="card-header" id="table_div_cargos">
                <table style="text-align: center" id="dtCargos" class="table table-hover" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th class="th-sm">ID</th>
                            <th class="th-sm">Descripción</th>
                            <th class="th-sm">Sueldo</th>
                            <th class="th-sm">Hora Diurna</th>
                            <th class="th-sm">Hora Nocturna</th>
                            <th class="th-sm">Hora Dominical y Festivos</th>
                            <th class="th-sm">Hora Recargo Nocturno</th>
                            <th class="th-sm">Acción</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($cargos as $cargo)
                        <tr>
                            <td>{{ $cargo->id}}</td>
                            <td>{{ $cargo->nombre}}</td>
                            <td>${{ $cargo->sueldo}}</td>
                            <td>${{ $cargo->valor_diurna}}</td>
                            <td>${{ $cargo->valor_nocturna}}</td>
                            <td>${{ $cargo->valor_dominical}}</td>
                            <td>${{ $cargo->valor_recargo}}</td>
                            <td><button class="btn btn-primary" data-toggle="modal" data-target="#modalDetalleCargo"
                                    onclick="detallesCargo({{ $cargo->id}})">Editar</button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@include('cargos.modalVerDetallesCargo')
@include('cargos.modalRegistrarCargo')
@endsection