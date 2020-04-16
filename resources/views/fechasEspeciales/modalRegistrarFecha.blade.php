<div class="modal fade" id="modalRegistrarFecha">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header text-center" style="background: #29913A;">
        <h4 class="modal-title w-100 font-weight-bold" style="color: white">Registrar Fecha</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true" style="color: white">&times;</span>
        </button>
      </div>
      <div class="modal-body mx-3">
         {{-- Input del nombre --}}
        <div class="md-form mb-4">
          <i class="fas fa-id-file-alt"></i>
          <label data-error="wrong" data-success="right" for="orangeForm-name">Descripción</label>
          <input required type="text" id="nombre_fecha_g" class="form-control validate">
        </div>
        {{-- Input de fecha inicio --}}
        <div class="md-form mb-4">
          <i class="fas fa-dollar-sign"></i>
          <label data-error="wrong" data-success="right" for="orangeForm-name">Fecha Inicio</label>
          <input required type="date" id="fecha_inicio_g" class="form-control validate">
        </div>
        {{-- Input de fecha final --}}
        <div class="md-form mb-4">
          <i class="fas fa-dollar-sign"></i>
          <label data-error="wrong" data-success="right" for="orangeForm-email">Fecha Final</label>
          <input required type="date" id="fecha_fin_g" class="form-control validate">
        </div>
      </div>
      <div class="modal-footer d-flex justify-content-center">
        <button class="btn btn-primary" data-dismiss="modal">Cerrar</button>
        <button class="btn btn-secondary" onclick="saveFecha()">Guardar</button>
      </div>
    </div>
  </div>
</div>