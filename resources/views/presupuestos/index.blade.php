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
                <label data-error="wrong" data-success="right" for="orangeForm-name">Seleccionar</label>
                <select class="form-control validate" id="mes_p" name="">
                    <option value=""></option>
                    @foreach ($presupuestos as $presupuesto)
                        <option value="{{$presupuesto->id}}">{{$presupuesto->mes}}/{{$presupuesto->año}}</option>
                    @endforeach
              </select>
            </div>
                <div class="card-header" id="div_presupuesto">
                    <table id="dtPresupuestos" class="table table-hover table-dark" cellspacing="0" width="100%">
                        <thead class="thead-dark">
                            <tr>
                            <th class="th-sm">Usuario</th>
                            <th class="th-sm">Cargo</th>
                            <th class="th-sm">Mes</th> 
                            <th class="th-sm">Cantidad de Horas</th>
                            <th class="th-sm">Tipo de Hora</th>
                            <th class="th-sm">Fecha Solicitud</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>       
                </div>      
            </div>
        </div>     
    </div>
    @include('presupuestos.modalRegistrarPresupuesto')            
@endsection