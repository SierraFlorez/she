{{-- extiende plantilla principal --}}
@extends('app')
{{-- da un nombre al titulo de la pestaña--}}
@section('htmlheader_title')
Consultar Fechas Especiales
@endsection
{{-- contenido de la pagina principal (solo ventana) --}}
@section('main-content')

<div class="row animated fadeInDown">
    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
        <div class="card" style="margin-top: 5%">
            <center>
                <h1> Fechas Especiales </h1>
            </center><br>
            <div style="padding-left: 2%;">
                <a  class="btn btn-success" style="color:white" data-toggle="modal" data-target="#modalRegistrarFecha" id="modal">
                    Registrar Fecha</a>
            </div>
            <div class="card-header" id="table_div_fechas">
                <table style="text-align: center" id="dtFechas" class="table table-hover" cellspacing="0" width="100%">
                    <thead class="thead">
                        <tr>
                            <th class="th-sm">ID</th>
                            <th class="th-sm">Descripcion</th>
                            <th class="th-sm">Fecha</th>
                            <th class="th-sm"><center>Acción</center></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($fechas as $fecha)
                        <tr>
                            <td>{{$fecha->id}}</td>
                            <td>{{$fecha->descripcion}}</td>
                            <td>{{$fecha->fecha}}</td>
                            <td>
                                <center><button class="btn btn-primary" data-toggle="modal" data-target="#modalDetalleFecha"
                                    onclick="detallesFecha({{$fecha->id}})">Editar</button>
                                </center>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@include('fechasEspeciales.modalVerDetallesFecha')
@include('fechasEspeciales.modalRegistrarFecha')
@endsection