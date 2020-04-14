{{-- extiende plantilla principal --}}
@extends('app')
{{-- da un nombre al titulo de la pestaña--}}
@section('htmlheader_title')
Solicitud de Horas Extras
@endsection
{{-- contenido de la pagina principal (solo ventana) --}}
@section('main-content')
    <div class="row">            
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="card" style="margin-top: 5%"><br>
                <center><h1> Solicitud de Horas Extras </h1></center><br>
                <div style="padding-left: 2%;">

                <a class="btn btn-success" href="{{ url("/solicitudes/crear_solicitud") }}" >Crear Solicitud de Horas Extras</a>
                </div>
                <div class="card-header" id="div_solicitud_horas">
                    
                    
                    <table id="dtsolicitudhorasExtras" class="table table-hover table-dark" cellspacing="0" width="100%">
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
@endsection