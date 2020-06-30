<div class="modal fade" id="modalTableHoras" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog"
  aria-labelledby="modalRegistrar" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header text-center" style="background: #29913A;">
        <h4 class="modal-title w-100 font-weight-bold" style="color: white">Horas Extras</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true" style="color: white">&times;</span>
        </button>
      </div>
      <div class="modal-body mx-3">
        <div class="md-form mb-4">
          <div class="row">
            <div class="col-md-3" id="agregarHora">
            </div>
            <div class="col-md-6">
              <input readonly type="text" id="horas_faltantes" class="form-control validate">
            </div>
          </div>
          <div id="modal_horas">
            <table style="text-align: center" id="dtmHoras" class="table table-hover" cellspacing="0" width="100%">
              <thead class="thead">
                <tr>
                  <th class="th-sm">ID</th>
                  <th class="th-sm">Fecha</th>
                  <th class="th-sm">Hora Inicio</th>
                  <th class="th-sm">Hora Fin</th>
                  <th class="th-sm">Acción</th>
                </tr>
              </thead>
              <tbody>
              </tbody>
            </table>
          </div>


        </div>
        <div class="modal-footer d-flex justify-content-center">
          <button class="btn btn-primary" data-dismiss="modal">Cerrar</button>
        </div>
      </div>
    </div>
  </div>
</div>