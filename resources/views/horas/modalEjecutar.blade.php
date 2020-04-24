<div class="modal fade" id="modalEjecutar">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header text-center" style="background: #29913A;">
        <h4 class="modal-title w-100 font-weight-bold" style="color: white">Ejecutar Horas</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true" style="color: white">&times;</span>
        </button>
      </div>
      <div class="modal-body mx-3">
         {{-- Input del nombre --}}
        <div class="md-form mb-4">
          <i class="fas fa-calendar"></i>
          <label data-error="wrong" data-success="right" for="orangeForm-name">Fecha</label>
          <input readonly type="date" id="fecha_e" class="form-control validate">
        </div>
        {{-- Input de fecha inicio --}}
        <div class="md-form mb-4">
          <div class="form-row mb-6">
          <div class="col">
          <i class="fas fa-clock"></i>
          <label data-error="wrong" data-success="right" for="orangeForm-name">Hora Inicio Solicitada</label>
          <input readonly type="time" id="is_e" class="form-control validate">
          </div>
          <div class="col">
            <i class="fas fa-clock"></i>
            <label data-error="wrong" data-success="right" for="orangeForm-email">Hora Fin Solicitada</label>
            <input readonly type="time" id="fs_e" class="form-control validate">
          </div>
        </div>
        </div>

        <div class="md-form mb-4">
          <div class="form-row mb-6">
          <div class="col">
          <i class="fas fa-clock"></i>
          <label data-error="wrong" data-success="right" for="orangeForm-name">Hora Inicio Ejecutada</label>
          <input required type="time" id="ij_e" class="form-control validate">
          </div>
          <div class="col">
            <i class="fas fa-clock"></i>
            <label data-error="wrong" data-success="right" for="orangeForm-email">Hora Fin Ejecutada</label>
            <input required type="time" id="fj_e" class="form-control validate">
          </div>
        </div>
        </div>

      </div>
      <div class="modal-footer d-flex justify-content-center">
        <button class="btn btn-primary" data-dismiss="modal">Cerrar</button>
        <button class="btn btn-secondary" id="ejecutar">Ejecutar</button>
      </div>
    </div>
  </div>
</div>