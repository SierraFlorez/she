{{-- extiende plantilla principal --}}
@extends('app')
{{-- da un nombre al titulo de la pestaña--}}
@section('htmlheader_title')
Consultar Horas Extras
@endsection
{{-- contenido de la pagina principal (solo ventana) --}}
@section('main-content')
    <div class="row">            
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="card" style="margin-top: 5%">
                <center><h1> Gestionar Horas Extras </h1></center><br>
                <div style="padding-left: 2%;">
                <a class="btn btn-success" href="{{ url("/horasExtras_registro") }}" >Registrar Horas Extras </a>
                </div>
                <div class="card-header" id="div_horas">
                    <table id="dthorasExtras" class="table table-hover table-dark" cellspacing="0" width="100%" style="text-align: center">
                        <thead class="thead-dark">
                            <tr>
                            <th class="th-sm">Usuario</th>
                            <th class="th-sm">Cargo</th>
                            <th class="th-sm">Fecha</th>
                            <th class="th-sm">Hora Inicio</th>
                            <th class="th-sm">Hora Fin</th>
                            <th class="th-sm">Cantidad de Horas</th>
                            <th class="th-sm">Tipo de Hora</th>
                            <th class="th-sm">Estado</th>
                            <th class="th-sm">Acción</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($horas as $hora)
                            <tr>
                            <td>{{$hora->nombres}} {{$hora->apellidos}}</td>
                            <td>{{$hora->nombre}}</td>
                                <td>{{$hora->fecha}}</td>
                                <td>{{$hora->hora_inicio}}</td>
                                <td>{{$hora->hora_fin}} </td>
                                <td>@php echo $hora->hora_fin - $hora->hora_inicio @endphp</td>
                                <td>{{$hora->nombre_hora}} </td>
                                @if ($hora->autorizacion==0 && $hora->ejecucion==0)
                                <td><button class="btn btn-danger" onclick="autorizar({{$hora->id}},{{Auth::User()->id}},this)">No autorizado
                                    </button>
                                </td>
                                @elseif ($hora->autorizacion!=0 && $hora->ejecucion==0)
                                <td><button class="btn btn-success">Autorizado
                                    </button>
                                </td>
                                @elseif ($hora->autorizacion!=0 && $hora->ejecucion==1)
                                <td><button class="btn btn-primary">Ejecutado
                                    </button>
                                </td>
                                @endif
                                <td> 
                                <button class="btn btn-secondary" data-toggle="modal" data-target="#modalDetallesHora" onclick="detallesHora({{ $hora->id}},this)">Detalles
                                </button>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>       
                </div>      
            </div>
        </div>     
    </div>
    @include('horasExtras.modalVerDetallesHora')            
@endsection