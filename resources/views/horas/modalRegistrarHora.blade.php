<div class="modal fade" id="modalRegistrarHora" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog"
  aria-labelledby="modalRegistrar" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header text-center" style="background: #29913A;">
        <h4 class="modal-title w-100 font-weight-bold" style="color: white">Registrar Horas</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true" style="color: white">&times;</span>
        </button>
      </div>
      <div class="modal-body mx-3">
        <div class="form-row mb-6" style="margin-top:1%">
          {{-- Input de hora inicio --}}
          <div class="col-md-6">
            <label data-error="wrong" data-success="right" for="orangeForm-name">Hora de inicio:
            </label>
            <input class="form-control " type="hidden" id="rol_hidden_h">
            <input class="form-control " type="time" id="hora_inicio">
          </div>
          {{-- Input de hora fin --}}
          <div class="col-md-6">
            <label data-error="wrong" data-success="right" for="orangeForm-name">Hora fin:</label>
            <input class="form-control" type="time" id="hora_fin">
          </div>
        </div>
        <div class="form-row mb-6" style="margin-top:1%">
          {{-- Input de fecha --}}
          <div class="col-md-6">
            <label data-error="wrong" data-success="right" for="orangeForm-name">Fecha de Registro</label>
            <input type="date" id="fecha_hs" class="form-control validate">
            <input type="hidden" id="solicitud_hs" class="form-control validate">
          </div>
        </div>
      </div>
      <div class="modal-footer d-flex justify-content-center">
        <button class="btn btn-primary" data-dismiss="modal">Cerrar</button>
        <button id="guardarHoraE"class="btn btn-success" onclick="guardarHoras();">Guardar</button>
      </div>
    </div>
  </div>
</div>