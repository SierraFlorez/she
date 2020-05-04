{{-- extiende plantilla principal --}}
@extends('app')
{{-- da un nombre al titulo de la pestaña--}}
@section('htmlheader_title')
Gestión de Presupuesto
@endsection
{{-- contenido de la pagina principal (solo ventana) --}}
@section('main-content')
    <div class="row">            
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="card" style="margin-top: 5%"><br>
                <center><h1> Gestión de Presupuesto</h1></center><br>
                <div style="padding-left: 2%;">
                <a  style="color:white" class="btn btn-success" data-toggle="modal" data-target="#modalRegistrarPresupuesto">Registrar Presupuesto</a>
                </div>
                <br>
                <div style="padding-left: 2%;padding-right: 2%">
                <label data-error="wrong" data-success="right" for="orangeForm-name">Seleccionar Presupuesto</label>
                <select class="form-control validate" id="seleccionar_presupuesto" name="" onchange="tabla_de_presupuestos();">
                    <option value="0"></option>
                    @foreach ($presupuestos as $presupuesto)
                        <option value="{{$presupuesto->id}}">{{$presupuesto->mes}}/{{$presupuesto->año}}</option>
                    @endforeach
              </select>
              <div class="row" style="margin-top: 2%" id="informacion_presupuesto"></div>
            </div>
                <div class="card-header" id="div_presupuesto">
                    <center><h2> Solicitudes </h2></center>
                    <table id="dtPresupuestos" class="table table-hover table-dark" cellspacing="0" width="100%">
                        <thead class="thead-dark">
                            <tr>
                            <th class="th-sm">Usuario</th>
                            <th class="th-sm">Cargo</th>
                            <th class="th-sm">Cantidad de Horas</th> 
                            <th class="th-sm">Hora Inicio</th>
                            <th class="th-sm">Hora Fin</th>
                            <th class="th-sm">Tipo Hora</th>
                            <th class="th-sm">Acción</th>
                            </tr>
                        </thead>
                        {{-- js 1050 --}}
                        <tbody>
                        </tbody>
                    </table>       
                </div>      
            </div>
        </div>     
    </div>
    @include('presupuestos.modalRegistrarPresupuesto') 
    @include('presupuestos.modalVerDetallesHoraP') 
    @include('presupuestos.modalDetallesPresupuesto')                                             
@endsection