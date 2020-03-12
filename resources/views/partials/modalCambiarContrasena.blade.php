{{-- Modal para cambiar contraseña  --}}
<div class="modal fade" id="modalPassword" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
  aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header text-center" style="background: #29913A;">
        <h4 class="modal-title w-100 font-weight-bold" style="color: white">Cambiar Contraseña</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true" style="color: white">&times;</span>
        </button>
      </div>
      <div class="modal-body mx-3">
        <div class="md-form mb-4">
      <h3 class="mt-1 mb-2">{{ Auth::user()->nombres }}</h3>
      <input type="hidden" id="userid" value="{{ Auth::user()->id }}">
        </div>
        <div class="md-form mb-4">
          <label data-error="wrong" data-success="right" for="form29" class="ml-0">Contraseña</label>
        <input type="password" type="text" id="password" placeholder="Minimo 6 caracteres"
          class="form-control form-control-sm validate ml-0">
      </div>
      <br>
      <div class="md-form mb-4">
        <label data-error="wrong" data-success="right" for="form29" class="ml-0">Confirmar Contraseña</label>
        <input type="password" type="text" id="confirmPassword" placeholder="Minimo 6 caracteres"
          class="form-control form-control-sm validate ml-0">
      </div>
      <br>
      <div class="md-form mb-4">
        <button id="passReset" class="btn btn-success">Aplicar<i
            class="glyphicon glyphicon-floppy-save"></i></button>
      </div>
    </div>
  </div>
</div>
</div>