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
                
                <div class="card-header" id="div_horas">
                    <a class="btn btn-success" href="{{ url("/registrar/horasExtras") }}" >Registrar Horas Extras </a>
                    <br>
                    
                    <table id="dthorasExtras" class="table table-hover table-dark" cellspacing="0" width="100%">
                        <thead class="thead-dark">
                            <tr>
                            <th class="th-sm">ID</th>
                            <th class="th-sm">Documento</th>
                            <th class="th-sm">Nombre</th>
                            <th class="th-sm">Apellidos</th>
                            </tr>
                        </thead>
                        <tbody>
                           <td> </td>
                           <td> </td>
                           <td> </td>
                           <td> </td>
                        </tbody>
                    </table>       
                </div>      
            </div>
        </div>     
    </div>            
@endsection