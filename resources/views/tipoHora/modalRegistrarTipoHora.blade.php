<div class="modal fade" id="modalRegistrarTipoHora">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header text-center" style="background: #29913A;">
        <h4 class="modal-title w-100 font-weight-bold" style="color: white">Registrar Tipo de Hora</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true" style="color: white">&times;</span>
        </button>
      </div>
      <div class="modal-body mx-3">
        {{-- Input del nombre --}}
        <div class="md-form mb-4">
          <i class="fas fa-file-alt"></i>
          <label data-error="wrong" data-success="right" for="orangeForm-name">Descripción</label>
          <input required type="text" id="nombre_hora_g" class="form-control validate">
        </div>
        {{-- Hora inicio --}}
        <div class="md-form mb-4">
          <i class="fas fa-clock"></i>
          <label data-error="wrong" data-success="right" for="orangeForm-name">Hora Inicio</label>
          <input required type="time" id="hora_inicio_g" class="form-control validate">
        </div>
        {{-- Hora fin --}}
        <div class="md-form mb-4">
          <i class="fas fa-clock"></i>
          <label data-error="wrong" data-success="right" for="orangeForm-email">Hora Fin</label>
          <input required type="time" id="hora_fin_g" class="form-control validate">
        </div>
        {{-- tipo --}}
        <div class="md-form mb-4">
          <i class="fas fa-clock"></i>
          <label data-error="wrong" data-success="right" for="orangeForm-email">Tipo</label>
          <select required class="form-control validate" id="tipohora_g" name="select_tipohora_g">
            <option value=""></option>
            @foreach($tipos as $tipo)
            <option value="{{$tipo->id}}">{{$tipo->descripcion}}</option>
            @endforeach
          </select>
        </div>
      </div>
      <div class="modal-footer d-flex justify-content-center">
        <button class="btn btn-primary" data-dismiss="modal">Cerrar</button>
        <button class="btn btn-success" onclick="guardarTipoHora();">Guardar
        </button>
      </div>
    </div>
  </div>
</div>