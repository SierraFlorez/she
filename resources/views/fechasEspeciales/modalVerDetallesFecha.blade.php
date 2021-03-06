<div class="modal fade" id="modalDetalleFecha">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header text-center" style="background: #29913A;">
        <h4 class="modal-title w-100 font-weight-bold" style="color: white">Detalle de Fecha</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true" style="color: white">&times;</span>
        </button>
      </div>
      <div class="modal-body mx-3">
         {{-- Descripcion --}}
        <div class="md-form mb-4">
          <i class="fas fa-file-alt"></i>
          <label data-error="wrong" data-success="right" for="orangeForm-name">Descripción</label>
          <input required type="text" id="nombre_fecha_t" class="form-control validate">
        </div>
        {{-- Fecha --}}
        <div class="md-form mb-4">
          <i class="fas fa-clock"></i>
          <label data-error="wrong" data-success="right" for="orangeForm-name">Fecha</label>
          <input required type="date" id="fecha_inicio_t" class="form-control validate">
        </div>
      </div>
      <div class="modal-footer d-flex justify-content-center">
        <button class="btn btn-primary" data-dismiss="modal">Cerrar</button>
        <button class="btn btn-success" id="updateFecha">Guardar</button>
      </div>
    </div>
  </div>
</div>