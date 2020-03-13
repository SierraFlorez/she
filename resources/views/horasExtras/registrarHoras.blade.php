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
    <div class="card row" style="margin-top: 5%">
      <center>
        <h1> Registrar Horas Extras </h1>
      </center><br>
      <div class="card-header">
        {{-- Input del usuario --}}
        <div class="form-row mb-6">
          <div class="col-md-6">
            <label data-error="wrong" data-success="right" for="orangeForm-name">Funcionario:</label>
            <select class="form-control validate" id="id_user_h" name="select_user_h">
              <option value=""></option>
              
              @foreach ($funcionarios as $funcionario)

              <option value="{{$funcionario->id}}">{{$funcionario->nombres}} {{$funcionario->apellidos}}</option>
              @endforeach
            </select>
          </div>
        </div>
        <br>
        <hr>
        <div class="form-row mb-6">
          {{-- Input de fecha --}}
          <div class="col">
            <label data-error="wrong" data-success="right" for="orangeForm-name">Día en que se realizo horas
              extras:</label>
            <br>
            <input hidden class="date-input-native" id="date" type="date" name="date_h" min="2020-01-12" max="{{$fecha}}">
            <input class="form-control date-input-fallback" id="alt" type="text" placeholder="Seleccione una fecha">
            <div id="picker" hidden></div>
          </div>
          {{-- Input de tipo de hora --}}
          <div class="col">
            <label data-error="wrong" data-success="right" for="orangeForm-name">Tipo de horas:</label>
            <select class="form-control validate" id="tipohoras_h" name="tipohoras_h">
              <option value="">Seleccionar tipo de hora </option>
              <option value="1">Diurnas </option>
              <option value="2">Nocturnas </option>
              <option value="3">Dominicales y Festivos </option>
              <option value="4">Recargo Nocturno </option>
            </select>
          </div>
        </div>
        <br>
        <hr>
        <div class="form-row mb-6">
          {{-- Input de hora inicio --}}
          <div class="col">
            <label data-error="wrong" data-success="right" for="orangeForm-name">Hora de inicio:
            </label>
            <input class="form-control bfh-timepicker" type="time" id="hora_inicio">
          </div>
          {{-- Input de tipo de hora --}}
          <div class="col">
            <label data-error="wrong" data-success="right" for="orangeForm-name">Hora fin:</label>
            <input class="form-control" type="time" id="hora_fin">
          </div>
        </div>
        <br>
        <hr>
        <button class="btn btn-success" onclick="guardarHoras()"> Guardar </button>
      </div>
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