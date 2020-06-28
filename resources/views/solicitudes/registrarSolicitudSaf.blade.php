{{-- extiende plantilla principal --}}
@extends('app')
{{-- da un nombre al titulo de la pestaña--}}
@section('htmlheader_title')
Registrar Solicitud Instructor
@endsection
{{-- contenido de la pagina principal (solo ventana) --}}
@section('main-content')

<div class="row animated fadeInDown">
  <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
    <div class="card row" style="margin-top: 5%;border-radius:10px">
      <center>
        <br>
        <h1> Sincronizar Horario SAF </h1>
      </center>
      <div class="card-body">
        <center>
          <div class="form-row mb-6">
            <div class="col-md-4">
              <h5>Instructor:</h5>
              &nbsp;<p id="funcS"></p>
              <hr style="width:50%;border-color:#0275d8">
            </div>
            <div class="col-md-4">
              <h5>Documento:</h5>
              &nbsp;<p id="docuS"></p>
              <hr style="width:50%;border-color:#0275d8">
            </div>
            <div class="col-md-4">
              <h5>Cargo Vigente:</h5>
              &nbsp;<p id="cargvS"></p>
              <hr style="width:50%;border-color:#0275d8">
            </div>
          </div>
        </center>
        {{-- Input funcionario --}}
        <div class="form-row mb-6" style="margin-bottom: 4px">
          <div class="col-md-6">
            <label data-error="wrong" data-success="right" for="orangeForm-name">Funcionario</label>
            <select onchange="infoFuncionarioS();" class="form-control validate" id="select_f" name="select_funcionario_s">
              <option value=""> Seleccione un Instructor </option>
              @foreach ($funcionarios as $funcionario)
              <option value="{{$funcionario->id}}">{{$funcionario->nombres}} {{$funcionario->apellidos}}</option>
              @endforeach
            </select>
          </div>
          {{-- Input de tipo de hora --}}
          <div class="col-md-6">
            <label data-error="wrong" data-success="right" for="orangeForm-name">Tipo de Hora</label>
            <select onchange="infoTipoHoraS();" class="form-control validate" id="tipohoras_s" name="tipohoras_saf">
              <option value="">Seleccione tipo de hora </option>
              @foreach($tipoHoras as $tipoHora)
              <option value="{{$tipoHora->id}}">{{$tipoHora->nombre_hora}}</option>
              @endforeach
            </select>
          </div>
        </div>
        <div class="form-row mb-6" style="margin-bottom: 4px" id="th_saf">
        </div>


        <div class="form-row mb-6" style="margin-top:1%">

          <div class="col-md-7">
            <label data-error="wrong" data-success="right" for="orangeForm-name">Meses</label>
            <br>
            <div style="border-style: solid;">&nbsp;
              <label for="Mes1">Enero</label>
              <input type="checkbox" id="Mes1" value="1">&nbsp;&nbsp;&nbsp;
              <label for="Mes2">Febrero</label>
              <input type="checkbox" id="Mes2" value="2">&nbsp;&nbsp;&nbsp;
              <label for="Mes3">Marzo</label>
              <input type="checkbox" id="Mes3" value="3">&nbsp;&nbsp;&nbsp;
              <label for="Mes4">Abril</label>
              <input type="checkbox" id="Mes4" value="4">&nbsp;&nbsp;&nbsp;
              <label for="Mes5">Mayo</label>
              <input type="checkbox" id="Mes5" value="5">&nbsp;&nbsp;&nbsp;
              <label for="Mes6">Junio</label>
              <input type="checkbox" id="Mes6" value="6">&nbsp;&nbsp;&nbsp;
              <label for="Mes7">Julio</label>
              <input type="checkbox" id="Mes7" value="7">&nbsp;&nbsp;&nbsp;
              <label for="Mes8">Agosto</label>
              <input type="checkbox" id="Mes8" value="8">&nbsp;&nbsp;&nbsp;
              <label for="Mes9">Septiembre</label>
              <input type="checkbox" id="Mes9" value="9">&nbsp;&nbsp;&nbsp;
              <label for="Mes10">Octubre</label>
              <input type="checkbox" id="Mes10" value="10">&nbsp;&nbsp;&nbsp;
              <label for="Mes11">Noviembre</label>
              <input type="checkbox" id="Mes11" value="11">&nbsp;&nbsp;&nbsp;
              <label for="Mes12">Diciembre</label>
              <input type="checkbox" id="Mes12" value="12">&nbsp;&nbsp;&nbsp;
            </div>
          </div>
          <div class="col-md-5">
            <label data-error="wrong" data-success="right" for="orangeForm-email">Año</label>
            <select class="form-control validate" id="year_saf" name="year_saf">
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
        <div class="form-row mb-6" style="margin-top:1%">
          <div class="col-md-6">
            <input class="form-control" type="hidden" value="{{Auth::User()->id}}" id="created_by">
          </div>
        </div><br>
        <div class="row">
          <div class="col">
            <button class="btn btn-success" onclick="guardarSolicitudSaf()"> Guardar </button>
          </div>
          <div class="col-4">
            <a class="btn btn-success" href="{{ url("/horas_extras") }}"> Volver </a>
          </div>
        </div>
      </div><br>
    </div>
  </div>
</div>
@endsection