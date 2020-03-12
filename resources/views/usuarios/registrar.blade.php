{{-- extiende plantilla principal --}}
@extends('app')
{{-- da un nombre al titulo de la pestaña--}}
@section('htmlheader_title')
Registrar usuarios
@endsection
{{-- contenido de la pagina principal (solo ventana) --}}
@section('main-content')
@include('usuarios.modalVerDetalles')
@include('usuarios.modalRegistrar')
    <div class="row">            
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="card" style="margin-top: 5%">
                <div class="card-header">
                    <h2> Registrar Usuarios Manual</h2>
                    <hr>
                    <button class="btn btn-primary" data-toggle="modal" data-target="#modalRegistrar">Registrar Usuario</button>
                </div>      
            </div>
        </div>     
    </div>
    
    <div class="row">            
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="card" style="margin-top: 5%">
                <div class="card-header">
                    <h2> Registrar Usuarios Masivo</h2>
                    <hr>
                    <button class="btn btn-primary">Descargar Formato</button>
                    <button class="btn btn-success">Cargar Formato</button>
                </div>      
            </div>
        </div>     
    </div>  
@endsection