<div class="modal fade" id="modalRegistrarCargo">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header text-center" style="background: #29913A;">
        <h4 class="modal-title w-100 font-weight-bold" style="color: white">Registrar Cargos</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true" style="color: white">&times;</span>
        </button>
      </div>
      <div class="modal-body mx-3">
         {{-- Input del nombre --}}
        <div class="md-form mb-4">
          <i class="fas fa-id-card"></i>
          <label data-error="wrong" data-success="right" for="orangeForm-name">Descripción</label>
          <input required type="text" id="nombre_cargo_g" class="form-control validate">
        </div>
        {{-- Input del sueldo --}}
        <div class="md-form mb-4">
          <i class="fas fa-id-card"></i>
          <label data-error="wrong" data-success="right" for="orangeForm-name">Sueldo</label>
          <input required type="number" id="sueldo_cargo_g" class="form-control validate">
        </div>
        {{-- Input diurno --}}
        <div class="md-form mb-4">
          <i class="fas fa-user"></i>
          <label data-error="wrong" data-success="right" for="orangeForm-email">Valor Hora Diurna</label>
          <input required type="number" id="diurna_cargo_g" class="form-control validate">
        </div>
        {{-- Input nocturno  --}}
        <div class="md-form mb-4">
          <i class="fas fa-user"></i>
          <label data-error="wrong" data-success="right" for="orangeForm-email">Valor Hora Nocturna</label>
          <input required type="number" id="nocturna_cargo_g" class="form-control validate">
        </div>
        {{-- Input dominical  --}}
        <div class="md-form mb-4">
          <i class="fas fa-user"></i>
          <label data-error="wrong" data-success="right" for="orangeForm-email">Valor Hora Dominical</label>
          <input required type="number" id="dominical_cargo_g" class="form-control validate">
        </div>
        {{-- Input nocturno  --}}
        <div class="md-form mb-4">
          <i class="fas fa-user"></i>
          <label data-error="wrong" data-success="right" for="orangeForm-email">Valor Hora Recargo Nocturno</label>
          <input required type="number" id="nocturno_cargo_g" class="form-control validate">
        </div>
      </div>
      <div class="modal-footer d-flex justify-content-center">
        <button class="btn btn-primary" data-dismiss="modal">Cerrar</button>
        <button class="btn btn-secondary" onclick="crearCargo()">Guardar</button>
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