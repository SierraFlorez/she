<div class="modal fade" id="modalCargo" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog"
  aria-labelledby="modalRegistrar" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header text-center" style="background: #29913A;">
        <h4 class="modal-title w-100 font-weight-bold" style="color: white">Detalles del Cargo Vigente</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true" style="color: white">&times;</span>
        </button>
      </div>
      <div class="modal-body mx-3">
        {{-- Input del nombre del cargo --}}
        <div class="md-form mb-4">
          <div class="form-row mb-6">
            <div class="col">
              <i class="fas fa-tag"></i>
              <label data-error="wrong" data-success="right" for="orangeForm-name">Cargo Vigente</label>
              <input readonly type="text" id="cargov_d" class="form-control validate">
            </div>
            {{-- Input del sueldo --}}
            <div class="col">
              <i class="fas fa-dollar-sign"></i>
              <label data-error="wrong" data-success="right" for="orangeForm-name">Sueldo</label>
              <input readonly type="number" id="sueldov_d" class="form-control validate">

            </div>
          </div>
        </div>
        {{-- Input de diurno --}}
        <div class="md-form mb-4">
          <div class="form-row mb-6">
            <div class="col">
              <i class="fas fa-dollar-sign"></i>
              <label data-error="wrong" data-success="right" for="orangeForm-email">Valor Hora Diurna</label>
              <input readonly type="number" id="diurna_d" class="form-control validate">
            </div>
            {{-- Input de nocturno  --}}
            <div class="col">
              <i class="fas fa-dollar-sign"></i>
              <label data-error="wrong" data-success="right" for="orangeForm-pass">Valor Hora Nocturna</label>
              <input readonly type="number" id="nocturna_d" class="form-control validate">
            </div>
          </div>
        </div>
        {{-- Input dominical  --}}
        <div class="md-form mb-4">
          <div class="form-row mb-6">
            <div class="col">
              <i class="fas fa-dollar-sign"></i>
              <label data-error="wrong" data-success="right" for="orangeForm-pass">Valor Hora Dominical</label>
              <input readonly type="number" id="dominical_d" class="form-control validate">
            </div>
            {{-- Input nocturno  --}}
            <div class="col">
              <i class="fas fa-dollar-sign"></i>
              <label data-error="wrong" data-success="right" for="orangeForm-pass">Valor Hora Recargo Nocturno</label>
              <input readonly type="number" id="nocturno_d" class="form-control validate">
            </div>
          </div>
        </div>
      </div>
      <div class="modal-footer d-flex justify-content-center">
        <button class="btn btn-primary" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>