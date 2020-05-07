{{-- extiende plantilla principal --}}
@extends('app')
{{-- da un nombre al titulo de la pestaña--}}
@section('htmlheader_title')
Consultar Tipo de Horas
@endsection
{{-- contenido de la pagina principal (solo ventana) --}}
@section('main-content')

<div class="row">
    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
        <div class="card" style="margin-top: 5%">
            <center>
                <h1> Tipo de Horas </h1>
            </center><br>
            {{-- <div style="padding-left: 2%;">
                <a data-toggle="modal" data-target="#modalRegistrarUsuario" id="modal" class="btn btn-outline-success">
                    Registrar Tipo Hora</a>
            </div> --}}
            <div class="card-header" id="table_div_tipoHoras">
                <table style="text-align: center" id="dtTipoHoras" class="table table-hover" cellspacing="0" width="100%">
                    <thead class="thead">
                        <tr>
                            <th class="th-sm">ID</th>
                            <th class="th-sm">Nombre</th>
                            <th class="th-sm">Hora inicio</th>
                            <th class="th-sm">Hora fin</th>
                            <th class="th-sm"><center>Acción</center></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($tipoHoras as $tipoHora)
                        <tr>
                            <td>{{ $tipoHora->id}}</td>
                            <td>{{ $tipoHora->nombre_hora}}</td>
                            <td>{{ $tipoHora->hora_inicio}}</td>
                            <td>{{ $tipoHora->hora_fin}}</td>
                            <td>
                                <center><button class="btn btn-primary" data-toggle="modal" data-target="#modalDetalleTipoHora"
                                    onclick="detallesTipoHora({{ $tipoHora->id}})">Editar</button>
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
@include('tipoHora.modalVerDetallesTipoHora')

@endsection