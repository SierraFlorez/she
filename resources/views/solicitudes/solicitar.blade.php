{{-- extiende plantilla principal --}}
@extends('app')
{{-- da un nombre al titulo de la pestaña--}}
@section('htmlheader_title')
Registrar Horas Extras
@endsection
{{-- contenido de la pagina principal (solo ventana) --}}
@section('main-content')

<div class="row">
  <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
    <div class="card row" style="margin-top: 5%;border-radius:10px">
      <center>
        <br><h1> Solicitud de Horas Extras </h1>
      </center>
      <div class="card-body" >
        {{--  --}}
        <center>
            <div class="form-row mb-6">
                @foreach($funcionarios as $funcionario)
                <div class="col-md-4">
                    <h5>Funcionario:</h5> &nbsp;{{$funcionario->nombres.' '.$funcionario->apellidos}}
                    <hr style="width:300%;border-color:darkgrey">
                </div>
                <div class="col-md-4">
                    <h5>Documento:</h5> &nbsp;{{$funcionario->documento}}
                </div>
                @endforeach
                @foreach($cargos1 as $cargo)
                <div class="col-md-4">
                    <h5>Cargo Actual:</h5> &nbsp;{{$cargo->nombre}}
                </div>
                @endforeach
            </div>
        </center>
        <div class="form-row mb-6">
          {{-- Input de mes --}}
          <div class="col">
          <label data-error="wrong" data-success="right" for="orangeForm-name">Mes de Solicitud:</label>
            <select class="form-control validate" id="tipohoras_solicitud" name="tipohoras_solicitud">
              <option value="">Seleccione mes </option>
              <option value="1">Enero </option>
              <option value="2">Febrero </option>
              <option value="3">Marzo</option>
              <option value="4">Abril</option>
              <option value="5">Mayo</option>
              <option value="6">Junio</option>
              <option value="7">Julio</option>
              <option value="8">Agosto</option>
              <option value="9">Septiembre</option>
              <option value="10">Octubre</option>
              <option value="11">Noviembre</option>
              <option value="12">Diciembre</option>
            </select>
          </div>
          {{-- Input de tipo de hora --}}
          <div class="col">
            <label data-error="wrong" data-success="right" for="orangeForm-name">Tipo de horas:</label>
            <select class="form-control validate" id="tipohoras_solicitud" name="tipohoras_solicitud">
              <option value="">Seleccione tipo de hora </option>
              <option value="1">Diurnas </option>
              <option value="2">Nocturnas </option>
              <option value="3">Dominicales y Festivos </option>
              <option value="4">Recargo Nocturno </option>
            </select>
          </div>
        </div>
        <div class="form-row mb-6" style="margin-top:1%">
          {{-- Input de hora inicio --}}
          <div class="col-md-6">
            <label data-error="wrong" data-success="right" for="orangeForm-name">Hora de inicio:
            </label>
            <input class="form-control bfh-timepicker" type="time" id="hora_inicio">
          </div>
          {{-- Input de tipo de hora --}}
          <div class="col-md-6">
            <label data-error="wrong" data-success="right" for="orangeForm-name">Hora fin:</label>
            <input class="form-control" type="time" id="hora_fin">
          </div>
          {{-- Input Justificacion --}}
          <div class="col-md-12" style="margin-top:1%">
            <label data-error="wrong" data-success="right" for="orangeForm-name">Justificación:</label>
            <textarea class="form-control" id="justificacion" style="height: 120px;"></textarea>
          </div>
          @foreach($cargos as $cargouser)
            <div class="col-md-6">
                <input class="form-control" type="hidden" value="{{$cargouser->id}}" name="cargo_user_id_solicitud">
            </div>
          @endforeach
        </div><br>
        <button class="btn btn-success" onclick="guardarHoras()"> Guardar </button>
      </div><br>
    </div>
  </div>
</div>

{{-- Función para el input date --}}
<script>
  (function(){
        'use strict';

        var dayNamesShort = ['Lu', 'Ma', 'Mi', 'Ju', 'Vi', 'Sa', 'Do'];

        var monthNames = ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'];

        var icon = '<svg viewBox="0 0 512 512"><polygon points="268.395,256 134.559,121.521 206.422,50 411.441,256 206.422,462 134.559,390.477 "/></svg>';

        var root = document.getElementById('picker');

        var dateInput = document.getElementById('date');

        var altInput = document.getElementById('alt');

        var doc = document.documentElement;

        function format ( dt ) {

        //   return Picker.prototype.pad(dt.getDate()) + '-' + monthNames[dt.getMonth()].slice(0,3) + '-' + dt.getFullYear();
          return Picker.prototype.pad(dt.getFullYear() + '-' + monthNames[dt.getMonth()].slice(0,3) + '-' + dt.getDate());
        }

        function show ( ) {

          root.removeAttribute('hidden');

        }

        function hide ( ) {

          root.setAttribute('hidden', '');

          doc.removeEventListener('click', hide);

        }

        function onSelectHandler ( ) {

          var value = this.get();

          if ( value.start ) {

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


        root.parentElement.addEventListener('click', function ( e ) { e.stopPropagation(); });

        dateInput.addEventListener('change', function ( ) {

          if ( dateInput.value ) {

            picker.select(new Date(dateInput.value));

          } else {

            picker.clear();

          }

        });

        altInput.addEventListener('focus', function ( ) {

          altInput.blur();

          show();

          doc.addEventListener('click', hide, false);

        });

      }());
</script>
@endsection
