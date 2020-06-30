{{-- extiende plantilla principal --}}
@extends('app')
{{-- da un nombre al titulo de la pestaña--}}
@section('htmlheader_title')
Registrar Solicitud
@endsection
{{-- contenido de la pagina principal (solo ventana) --}}
@section('main-content')

<div class="row animated fadeInDown">
  <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
    <div class="card row" style="margin-top: 5%;border-radius:10px">
      <center>
        <br>
        <h1> Solicitud de Horas Extras </h1>
      </center>
      <div class="card-body">
        <center>
          <div class="form-row mb-6">
            <div class="col-md-4">
              <h5>Funcionario:</h5>
              &nbsp;<p id="func"></p>
              <hr style="width:50%;border-color:#0275d8">
            </div>
            <div class="col-md-4">
              <h5>Documento:</h5>
              &nbsp;<p id="docu"></p>
              <hr style="width:50%;border-color:#0275d8">
            </div>
            <div class="col-md-4">
              <h5>Cargo Vigente:</h5>
              &nbsp;<p id="cargv"></p>
              <hr style="width:50%;border-color:#0275d8">
            </div>
          </div>
        </center>
        {{-- Input funcionario --}}
        <div class="form-row mb-6" style="margin-bottom: 4px">
          <div class="col-md-6">
            <label data-error="wrong" data-success="right" for="orangeForm-name">Funcionario</label>
            <select onchange="infoFuncionario();" class="form-control validate" id="select_f" name="select_funcionario">
              <option value=""> Seleccione un Funcionario </option>
              @foreach ($funcionarios as $funcionario)
              <option value="{{$funcionario->id}}">{{$funcionario->nombres}} {{$funcionario->apellidos}}</option>
              @endforeach
            </select>
          </div>
          {{-- Input de tipo de hora --}}
          <div class="col-md-6">
            <label data-error="wrong" data-success="right" for="orangeForm-name">Tipo de Hora</label>
            <select onchange="infoTipoHora();" class="form-control validate" id="tipohoras_s" name="tipohoras_s">
              <option value="">Seleccione tipo de hora </option>
              @foreach($tipoHoras as $tipoHora)
              <option value="{{$tipoHora->id}}">{{$tipoHora->nombre_hora}}</option>
              @endforeach
            </select>
          </div>
        </div>
        <div class="form-row mb-6" style="margin-bottom: 4px" id="th_s">
        </div>
        <div class="form-row mb-6" style="margin-top:1%">
          {{-- Input de hora inicio --}}
          <div class="col-md-6">
            <label data-error="wrong" data-success="right" for="orangeForm-name">Hora inicio:
            </label>
            <input onchange="calcularTotalHoras();" class="form-control bfh-timepicker" type="time" id="hora_inicio_s">
          </div>
          {{-- Input de hora fin --}}
          <div class="col-md-6">
            <label data-error="wrong" data-success="right" for="orangeForm-name">Hora fin:</label>
            <input onchange="calcularTotalHoras();" class="form-control" type="time" id="hora_fin_s">
          </div>
        </div>
        {{-- Fecha inicio --}}
        <div class="form-row mb-6" style="margin-top:1%">
          <div class="col-md-3">
            <label data-error="wrong" data-success="right" for="orangeForm-name">Fecha Inicio</label>
            <input onchange="calcularTotalHoras();" class="form-control" type="date" id="inicio_s">
          </div>
          {{-- Input fin --}}
          <div class="col-md-3">
            <label data-error="wrong" data-success="right" for="orangeForm-name">Fecha Fin</label>
            <input onchange="calcularTotalHoras();" class="form-control" type="date" id="fin_s">
          </div>
          <div class="col-md-6">
            <label data-error="wrong" data-success="right" for="orangeForm-name">Días de la semana</label>
            <br>
            <div style="border-style: solid;">&nbsp;
              <label for="Dia1">Lunes </label>
              <input onchange="calcularTotalHoras();" type="checkbox" id="Dia1" value="1">&nbsp;&nbsp;&nbsp;
              <label for="Dia2">Martes</label>
              <input onchange="calcularTotalHoras();" type="checkbox" id="Dia2" value="1">&nbsp;&nbsp;&nbsp;
              <label for="Dia3">Miercoles</label>
              <input onchange="calcularTotalHoras();" type="checkbox" id="Dia3" value="1">&nbsp;&nbsp;&nbsp;
              <label for="Dia4">Jueves</label>
              <input onchange="calcularTotalHoras();" type="checkbox" id="Dia4" value="1">&nbsp;&nbsp;&nbsp;
              <label for="Dia5">Viernes</label>
              <input onchange="calcularTotalHoras();" type="checkbox" id="Dia5" value="1">&nbsp;&nbsp;&nbsp;
              <label for="Dia6">Sabado</label>
              <input onchange="calcularTotalHoras();" type="checkbox" id="Dia6" value="1">
              <div id="domingo">
              </div>
            </div>
          </div>
        </div>
        {{-- Input total de horas --}}
        <div class="form-row mb-6" style="margin-top:1%">
          <div class="col-md-6">
            <label data-error="wrong" data-success="right" for="orangeForm-name">Total de Horas de Solicitud</label>
            <input class="form-control" type="number" id="horas_s">
          </div>
          <div class="col-md-3">
            <label data-error="wrong" data-success="right" for="orangeForm-name">Valor Solicitud</label>
            <input title="Calcula el valor de la solicitud(no tiene en cuenta fechas especiales)"readonly class="form-control" type="text" id="val_s">
          </div>
          <div class="col-md-3">
            <label data-error="wrong" data-success="right" for="orangeForm-name">Presupuesto Actual</label>
            <input title="Este campo es el presupuesto actual" readonly class="form-control" type="text" id="presupuesto_s">
          </div>
        </div>
        {{-- Input actividades --}}
        <div class="form-row mb-6" style="margin-top:1%">

          <div class="col-md-12" style="margin-top:1%">
            <label data-error="wrong" data-success="right" for="orangeForm-name">Actividades:</label>
            <textarea class="form-control" id="actividades_s" style="height: 120px;"></textarea>
          </div>
          <div class="col-md-6">
            <input class="form-control" type="hidden" value="{{Auth::User()->id}}" id="created">
          </div>
        </div><br>
        <div class="row">
          <div class="col">
            <button class="btn btn-success" onclick="guardarSolicitud()"> Guardar </button>
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