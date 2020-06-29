{{-- extiende plantilla principal --}}
@extends('app')
{{-- da un nombre al titulo de la pestaña--}}
@section('htmlheader_title')
Reportes
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
        <h2>Reporte Solicitud de Autorización</h2>
      </center>
      <div class="card-header">
        <form action="{{url('/reportes/solicitudAutorizacion/')}}" method="GET">
          @if(Auth::User()->roles->id ==1 || Auth::User()->roles->id ==4)
          <label data-error="wrong" data-success="right" for="orangeForm-name">Usuario</label>
          <select required class="form-control validate" id="select_f" name="select_f">
            <option value=""> Seleccione un Funcionario </option>
            @foreach ($usuarios as $usuario)
            <option value="{{$usuario->id}}">{{$usuario->nombres}} {{$usuario->apellidos}}</option>
            @endforeach
          </select>
          @endif
          @if(Auth::User()->roles->id ==2 || Auth::User()->roles->id ==3)
          <input hidden id="select_f" name="select_f" value="{{$actual->id}}">
          @endif
          <br>
          <div class="row">
            <div class="col-md-8">
              <label data-error="wrong" data-success="right" for="orangeForm-name">Meses</label>
              <br>
              <div style="border-style: solid;">&nbsp;
                <label for="Mes1">Enero</label>
                <input type="checkbox" name="Mes[1]" value="1">&nbsp;&nbsp;&nbsp;
                <label for="Mes[2]">Febrero</label>
                <input type="checkbox" name="Mes[2]" value="2">&nbsp;&nbsp;&nbsp;
                <label for="Mes[3]">Marzo</label>
                <input type="checkbox" name="Mes[3]" value="3">&nbsp;&nbsp;&nbsp;
                <label for="Mes[4]">Abril</label>
                <input type="checkbox" name="Mes[4]" value="4">&nbsp;&nbsp;&nbsp;
                <label for="Mes[5]">Mayo</label>
                <input type="checkbox" name="Mes[5]" value="5">&nbsp;&nbsp;&nbsp;
                <label for="Mes[6]">Junio</label>
                <input type="checkbox" name="Mes[6]" value="6">&nbsp;&nbsp;&nbsp;
                <label for="Mes[7]">Julio</label>
                <input type="checkbox" name="Mes[7]" value="7">&nbsp;&nbsp;&nbsp;
                <label for="Mes[8]">Agosto</label>
                <input type="checkbox" name="Mes[8]" value="8">&nbsp;&nbsp;&nbsp;
                <label for="Mes[9]">Septiembre</label>
                <input type="checkbox" name="Mes[9]" value="9">&nbsp;&nbsp;&nbsp;
                <label for="Mes[10]">Octubre</label>
                <input type="checkbox" name="Mes[10]" value="10">&nbsp;&nbsp;&nbsp;
                <label for="Mes[11]">Noviembre</label>
                <input type="checkbox" name="Mes[11]" value="11">&nbsp;&nbsp;&nbsp;
                <label for="Mes[12]">Diciembre</label>
                <input type="checkbox" name="Mes[12]" value="12">&nbsp;&nbsp;&nbsp;
              </div>
            </div>
            <div class="col-md-4">
              <label data-error="wrong" data-success="right" for="orangeForm-email">Seleccione el Año</label>
              <select required class="form-control validate" id="año_p" name="select_año">
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
          <br>
          <br>
          <input class="btn btn-success" type="submit" value="Generar Reporte">
        </form>
      </div>
    </div>
  </div>
</div>

<div class="row animated fadeInDown">
  <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
    <div class="card" style="margin-top: 5%">
      <center><br>
        <h2>Reporte Legalización de Horas Extras</h2>
      </center>
      <div class="card-header">
        <form action="{{url('/reportes/legalizacion/')}}" method="GET">
          @if(Auth::User()->roles->id ==1 || Auth::User()->roles->id ==4)
          <label data-error="wrong" data-success="right" for="orangeForm-name">Usuario</label>
          <select required class="form-control validate" id="select_f" name="select_f">
            <option value=""> Seleccione un Funcionario </option>
            @foreach ($usuarios as $usuario)
            <option value="{{$usuario->id}}">{{$usuario->nombres}} {{$usuario->apellidos}}</option>
            @endforeach
          </select>
          @endif
          @if(Auth::User()->roles->id ==2 || Auth::User()->roles->id ==3)
          <input hidden id="select_f" name="select_f" value="{{$actual->id}}">
          @endif
          <br>
          <div class="row">
            <div class="col">
              <label data-error="wrong" data-success="right" for="orangeForm-name">Seleccione el Mes</label>
              <select required class="form-control validate" id="select_mes" name="select_mes">
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
              <select required class="form-control validate" id="año_p" name="select_año">
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

          <br>
          <br>
          <input class="btn btn-success" type="submit" value="Generar Reporte">
        </form>
      </div>
    </div>
  </div>
</div>
@endsection