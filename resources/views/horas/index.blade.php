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
                <center><h1>Gestionar Horas Extras </h1></center><br>
                <div class="row" style="padding-left: 2%;">
                <div style="margin-bottom: 1%" class="col-md-9">
                <a class="btn btn-success" href="{{ url("/registrar_horas") }}" >Registrar Horas Extras </a>
                </div>
                <div class="col-md-1">
                <a class="btn btn-success" href="{{ url("/registrar_solicitud") }}" >Registrar Solicitud </a>
                </div>

                </div>
                @if (Auth::User()->roles->id==1)
                <div style="margin-top: 1%; padding-left: 2%;padding-right: 2%">
                    <label data-error="wrong" data-success="right" for="orangeForm-name">Seleccionar Usuario</label>
                    <select class="form-control validate" id="seleccionar_usuario" name="" onchange="tabla_de_horas();">
                        <option value="0"></option>
                        @foreach ($usuarios as $usuario)
                        <option value="{{$usuario->id}}">{{$usuario->nombres}} {{$usuario->apellidos}}</option>
                        @endforeach
                        <option value="all">Todos los usuarios</option>
                     </select>
                </div>
                @endif
                <div style="padding-left: 2%; margin-top:2%" class="row form-check form-check-inline" id="checkboxes">
                    <div class="col-md-3">
                        <div class="row"><div class="col-1"><input class="form-check-input" id="input1" onclick="tabla_de_horas()" type="checkbox" value="ejecutado"></div><div class="col-5"><label class="form-check-label">Ejecutado</label></div> <div class="col-3"> <div style="width:1rem;height:1rem;background-color: #5ed84f"></div></div></div>
                    </div>
                    <div class="col-md-3">
                        <div class="row"><div class="col-1"><input class="form-check-input" id="input2" onclick="tabla_de_horas()" type="checkbox" value="autorizado"></div><div class="col-6"><label class="form-check-label">Autorizado</label></div> <div class="col-3"> <div style="width:1rem;height:1rem;background-color: #ffc108"></div></div></div>
                    </div>
                    <div class="col-md-3">
                        <div class="row"><div class="col-1"><input class="form-check-input" id="input3" onclick="tabla_de_horas()" type="checkbox" value="no"></div><div class="col-7"><label class="form-check-label">No autorizado</label></div> <div class="col-1"> <div style="width:1rem;height:1rem;background-color: #ef172c"></div></div></div>
                    </div>
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
                            <th class="th-sm">Tipo de Hora</th>
                            <th class="th-sm">Estado</th>
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
    @include('horas.modalEjecutar')                        
@endsection