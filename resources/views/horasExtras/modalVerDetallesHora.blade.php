<div class="modal fade" id="modalDetallesHora" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog"
  aria-labelledby="modalRegistrar" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header text-center" style="background: #29913A;">
        <h4 class="modal-title w-100 font-weight-bold" style="color: white">Detalles de Horas</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true" style="color: white">&times;</span>
        </button>
      </div>
      <div class="modal-body mx-3">
        {{-- Input del usuario --}}
        <div class="md-form mb-4">
          <div class="form-row mb-6">
            <div class="col">
              <i class="fas fa-user"></i>
              <label data-error="wrong" data-success="right" for="orangeForm-name">Funcionario</label>
              <input readonly type="text" id="funcionario_h" class="form-control validate">
            </div>
            {{-- Input del cargo --}}
            <div class="col">
              <i class="fas fa-tag"></i>
              <label data-error="wrong" data-success="right" for="orangeForm-name">Cargo Vigente</label>
              <input readonly type="text" id="cargo_h" class="form-control validate">
            </div>
          </div>
        </div>
        {{-- Fecha --}}
        <div class="md-form mb-4">
          <div class="form-row mb-6">
            <div class="col">
              <i class="fas fa-calendar"></i>
              <label data-error="wrong" data-success="right" for="orangeForm-email">Fecha</label>
              <input type="date" id="fecha_h" class="form-control validate">
            </div>
            {{-- Input de los apellidos  --}}
            <div class="col">
              <i class="fas fa-moon"></i>
              <label data-error="wrong" data-success="right" for="orangeForm-pass">Tipo de Hora</label>
              <input type="text" id="th_h" class="form-control validate">
            </div>
          </div>
        </div>
        {{-- Input del centro  --}}
        <div class="md-form mb-4">
          <div class="form-row mb-6">
            <div class="col">
              <i class="fas fa-clock"></i>
              <label data-error="wrong" data-success="right" for="orangeForm-pass">Hora Inicio</label>
              <input type="time" id="hora_inicio_h" class="form-control validate">
            </div>
            {{-- Input de la regional  --}}
            <div class="col">
              <i class="fas fa-clock"></i>
              <label data-error="wrong" data-success="right" for="orangeForm-pass">Hora Fin</label>
              <input type="time" id="hora_fin_h" class="form-control validate">
            </div>
          </div>
        </div>
        {{-- Input del cargo  --}}
        <div class="md-form mb-4">
          <div class="form-row mb-6">
            <div class="col">
              <i class="fas fa-tag"></i>
              <label data-error="wrong" data-success="right" for="orangeForm-pass">Cantidad de Horas</label>
              <input readonly class="form-control validate" id="horas_h">
            </div>
            {{-- Input del sueldo  --}}
            <div class="col">
              <i class="fas fa-dollar-sign"></i>
              <label data-error="wrong" data-success="right" for="orangeForm-pass">Valor de Hora</label>
              <input readonly type="number" id="valor_hora_h" class="form-control validate">
            </div>
          </div>
        </div>
        {{-- Input del correo --}}
        <div class="md-form mb-4">
          <div class="form-row mb-6">
            <div class="col">
              <i class="fas fa-dollar-sign"></i>
              <label data-error="wrong" data-success="right" for="orangeForm-pass">Valor Total</label>
              <input readonly type="number" id="valor_total_h" class="form-control validate">
            </div>
            <div class="col">
              <i class="fas fa-user"></i>
              <label data-error="wrong" data-success="right" for="orangeForm-pass">Autorizado</label>
              <input readonly type="text" id="autorizado_h" class="form-control validate">
            </div>
          </div>
           {{-- Input Justificacion --}}
           <div class="md-form mb-4">
            <div class="form-row mb-6">
           <div class="col" style="margin-top:">
            <label data-error="wrong" data-success="right" for="orangeForm-name">Justificación:</label>
            <textarea class="form-control" id="justificacion_h" style="height:100%;"></textarea>
          </div>
        </div>
        </div>
      </div>
      </div>
      <div class="modal-footer d-flex justify-content-center">
        <button class="btn btn-primary" data-dismiss="modal">Cerrar</button>
        <button class="btn btn-secondary" id="update">Editar</button>
      </div>
    </div>
  </div>
</div>
<script>
  $(document).ready(function (){
          $('.documento_user').keyup(function (){
            this.value = (this.value + '').replace(/[^0-9]/g, '');
          });
        });
</script>