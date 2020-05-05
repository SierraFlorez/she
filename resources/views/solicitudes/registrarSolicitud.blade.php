{{-- extiende plantilla principal --}}
@extends('app')
{{-- da un nombre al titulo de la pestaña--}}
@section('htmlheader_title')
Registrar Solicitud
@endsection
{{-- contenido de la pagina principal (solo ventana) --}}
@section('main-content')

<div class="row">
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
              <h5>Funcionario:</h5> &nbsp;{{$funcionario->nombres.' '.$funcionario->apellidos}}
              <hr style="width:50%;border-color:darkgrey">
            </div>
            <div class="col-md-4">
              <h5>Documento:</h5> &nbsp;{{$funcionario->documento}}
              <hr style="width:50%;border-color:darkgrey">
            </div>
            <div class="col-md-4">
              <h5>Cargo Actual:</h5> &nbsp;{{$funcionario->nombre}}
              <hr style="width:50%;border-color:darkgrey">
            </div>
          </div>
        </center>
        <div class="form-row mb-6">
          {{-- Input de mes --}}
          <div class="col">
            <label data-error="wrong" data-success="right" for="orangeForm-name">Año de Solicitud</label>
            <br>
            <select class="form-control validate" id="año_s" name="año_solicitud">
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
          <div class="col">
            <label data-error="wrong" data-success="right" for="orangeForm-name">Mes de Solicitud</label>
            <select class="form-control validate" id="mes_s" name="mes_solicitud">
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
        </div>
        <div class="form-row mb-6" style="margin-top:1%">
          {{-- Input de hora inicio --}}
          <div class="col-md-6">
            <label data-error="wrong" data-success="right" for="orangeForm-name">Hora de inicio:
            </label>
            <input class="form-control bfh-timepicker" type="time" id="hora_inicio_s">
          </div>
          {{-- Input de tipo de hora --}}
          <div class="col-md-6">
            <label data-error="wrong" data-success="right" for="orangeForm-name">Hora fin:</label>
            <input class="form-control" type="time" id="hora_fin_s">
          </div>
        </div>
        <div class="form-row mb-6" style="margin-top:1%">
          <div class="col-md-6">
            <label data-error="wrong" data-success="right" for="orangeForm-name">Total de Horas</label>
            <input class="form-control" type="number" id="horas_s">
          </div>
          {{-- Input de tipo de hora --}}
          <div class="col">
            <label data-error="wrong" data-success="right" for="orangeForm-name">Tipo de Hora</label>
            <select class="form-control validate" id="tipohoras_s" name="tipohoras_s">
              <option value="">Seleccione tipo de hora </option>
              @foreach($tipoHoras as $tipoHora)
              <option value="{{$tipoHora->id}}">{{$tipoHora->nombre_hora}}</option>
              @endforeach
            </select>
          </div>
        </div>
        {{-- Input Justificacion --}}
        <div class="form-row mb-6" style="margin-top:1%">

          <div class="col-md-12" style="margin-top:1%">
            <label data-error="wrong" data-success="right" for="orangeForm-name">Actividades:</label>
            <textarea class="form-control" id="actividades_s" style="height: 120px;"></textarea>
          </div>
          <div class="col-md-6">
            <input class="form-control" type="hidden" value="{{$funcionario->id}}" id="funcionario_cargo_user_s">
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

{{-- Función para el input date --}}
<script>
  (function () {
    'use strict';

    var dayNamesShort = ['Lu', 'Ma', 'Mi', 'Ju', 'Vi', 'Sa', 'Do'];

    var monthNames = ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre',
      'Octubre', 'Noviembre', 'Diciembre'
    ];

    var icon =
      '<svg viewBox="0 0 512 512"><polygon points="268.395,256 134.559,121.521 206.422,50 411.441,256 206.422,462 134.559,390.477 "/></svg>';

    var root = document.getElementById('picker');

    var dateInput = document.getElementById('date');

    var altInput = document.getElementById('alt');

    var doc = document.documentElement;

    function format(dt) {

      //   return Picker.prototype.pad(dt.getDate()) + '-' + monthNames[dt.getMonth()].slice(0,3) + '-' + dt.getFullYear();
      return Picker.prototype.pad(dt.getFullYear() + '-' + monthNames[dt.getMonth()].slice(0, 3) + '-' + dt
    .getDate());
    }

    function show() {

      root.removeAttribute('hidden');

    }

    function hide() {

      root.setAttribute('hidden', '');

      doc.removeEventListener('click', hide);

    }

    function onSelectHandler() {

      var value = this.get();

      if (value.start) {

        dateInput.value = value.start.Ymd();

        altInput.value = format(value.start);

        hide();

      }

    }

    var picker = new Picker(root, {

      min: new Date(dateInput.min),

      max: new Date(dateInput.max),

      icon: icon,

      twoCalendars: false,

      dayNamesShort: dayNamesShort,

      monthNames: monthNames,

      onSelect: onSelectHandler

    });


    root.parentElement.addEventListener('click', function (e) {
      e.stopPropagation();
    });

    dateInput.addEventListener('change', function () {

      if (dateInput.value) {

        picker.select(new Date(dateInput.value));

      } else {

        picker.clear();

      }

    });

    altInput.addEventListener('focus', function () {

      altInput.blur();

      show();

      doc.addEventListener('click', hide, false);

    });

  }());
</script>
@endsection