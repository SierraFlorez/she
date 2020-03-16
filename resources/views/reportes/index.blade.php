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
                <h1> Generar Reporte </h1>
            </center><br>
            <div class="card-header">
                <label data-error="wrong" data-success="right" for="orangeForm-name">Usuario</label>
              <select class="form-control validate" id="tipoDocumento_user_d" name="select_tipoDocumento">
                  <option> Seleccione un Funcionario </option>
                @foreach ($usuarios as $usuario)
                <option value="{{$usuario->id}}">{{$usuario->users->nombres}} {{$usuario->users->apellidos}}</option>
                @endforeach
              </select>
              <br>
              <label data-error="wrong" data-success="right" for="orangeForm-name">Día en que se realizo horas
                extras:</label>
              <input class="form-control" type="date"  min="2020-01-12" max="2020-12-00">
              
              <br>
              <button class="btn btn-success">Solicitud de Autorización</button>
              <button class="btn btn-success">Formato de Legalización</button>
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