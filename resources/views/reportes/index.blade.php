{{-- extiende plantilla principal --}}
@extends('app')
{{-- da un nombre al titulo de la pestaña--}}
@section('htmlheader_title')
Consultar usuarios
@endsection
{{-- contenido de la pagina principal (solo ventana) --}}
@section('main-content')

<div class="row">
  <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
    <div class="card" style="margin-top: 5%">
      <center>
        <h1> Generar Excel</h1>
      </center><br>
      <div class="card-header">
        <label data-error="wrong" data-success="right" for="orangeForm-name">Usuario</label>
        <select class="form-control validate" id="select_f" name="select_f">
          <option value=""> Seleccione un Funcionario </option>
          @foreach ($usuarios as $usuario)
          <option value="{{$usuario->id}}">{{$usuario->users->nombres}} {{$usuario->users->apellidos}}</option>
          @endforeach
        </select>
        <br>
        <label data-error="wrong" data-success="right" for="orangeForm-name">Seleccione el mes que desea generar</label>
        <select class="form-control validate" id="select_mes" name="select_mes">
          <option value=""></option>
          <option value="01">Enero</option>
          <option value="02">Febrero</option>
          <option value="03">Marzo</option>
          <option value="04">Abril</option>
          <option value="05">Mayo</option>
          <option value="06">Junio</option>
          <option value="07">Julio</option>
          <option value="08">Agosto</option>
          <option value="09">Septiembre</option>
          <option value="10">Octubre</option>
          <option value="11">Noviembre</option>
          <option value="12">Diciembre</option>
        </select>
        <br>
        <a style="color:white" class="btn btn-success" onclick="solicitudAutorizacion()">Solicitud de Autorización</a>
        <a style="color:white" class="btn btn-success" onclick="legalizacion()">Formato de Legalización</a>
      </div>
    </div>
  </div>
</div>


@endsection