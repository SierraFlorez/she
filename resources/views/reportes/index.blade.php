{{-- extiende plantilla principal --}}
@extends('app')
{{-- da un nombre al titulo de la pestaña--}}
@section('htmlheader_title')
Consultar usuarios
@endsection
{{-- contenido de la pagina principal (solo ventana) --}}
@section('main-content')
@if(\Session::has('actualizado'))
<div class="alert alert-success" role="alert" style="top:3rem">{{ \Session::get('actualizado') }}</div>
@endif
@if(\Session::has('warning'))
<div class="alert alert-warning" role="alert" style="top:3rem">{{ \Session::get('warning') }}</div>
@endif
<div class="row animated fadeInDown">
  <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
    <div class="card" style="margin-top: 5%">
      <center><br>
        <h1> Generar Reportes</h1>
      </center>
      <div class="card-header">
        <form action="{{url('/reportes/solicitudAutorizacion/')}}" method="GET">
          @if(Auth::User()->roles->id ==1)
          <label data-error="wrong" data-success="right" for="orangeForm-name">Usuario</label>
          <select class="form-control validate" id="select_f" name="select_f">
            <option value=""> Seleccione un Funcionario </option>
            @foreach ($usuarios as $usuario)
            <option value="{{$usuario->id}}">{{$usuario->users->nombres}} {{$usuario->users->apellidos}}</option>
            @endforeach
          </select>
          @endif
          @if(Auth::User()->roles->id ==2)
          <select hidden class="form-control validate" id="select_f" name="select_f">
            <option value={{Auth::User()->cargos()->where('estado',1)->select('cargo_user.id')->first()}}></option>
          </select>
            @endif
            <br>
            <div class="row">
              <div class="col">
                <label data-error="wrong" data-success="right" for="orangeForm-name">Seleccione el Mes</label>
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
              </div>
              <div class="col">
                <label data-error="wrong" data-success="right" for="orangeForm-email">Seleccione el Año</label>
                <select class="form-control validate" id="año_p" name="select_año">
                  <option value=""></option>
                  <option value="2019">2019</option>
                  <option value="2020">2020</option>
                  <option value="2021">2021</option>
                  <option value="2022">2022</option>
                  <option value="2023">2023</option>
                  <option value="2024">2024</option>
                  <option value="2025">2025</option>
                  <option value="2026">2026</option>
                  <option value="2027">2027</option>
                  <option value="2028">2028</option>
                  <option value="2029">2029</option>
                  <option value="2030">2030</option>
                </select>
              </div>
            </div>
            <div style="margin-top:2%; border-style: solid;" class="row form-check form-check-inline" id="checkboxes">
              <div class="col-md-1 form-check"><input class="form-check-input" name="sa" type="checkbox" value="1">
              </div>
              <div class="col-md-3"><label class="form-check-label">Solicitud de Autorización</label>
              </div>

              <div class="col-md-1 form-check"><input class="form-check-input" name="lhe" type="checkbox" value="1">
              </div>
              <div class="col-md-4"><label class="form-check-label">Legalización de horas extras</label>
              </div>
            </div>
            <br>
            <br>
            <input class="btn btn-success" type="submit" value="Generar Reporte">
        </form>
      </div>

      {{-- <a style="color:white" class="btn btn-success" onclick="solicitudAutorizacion()" href="{{url('/reportes/solicitudAutorizacion/5/03')}}">Solicitud
      de Autorización</a>
      <a style="color:white" class="btn btn-success" onclick="legalizacion()">Formato de Legalización</a> --}}
    </div>
  </div>
</div>
@endsection