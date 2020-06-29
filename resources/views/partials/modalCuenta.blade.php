{{-- Modal Detalles de cuenta --}}
<div class="modal fade" id="modalCuenta" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header text-center" style="background: #29913A;">
        <h4 class="modal-title w-100 font-weight-bold" style="color: white">Detalles Del Usuario</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true" style="color: white">&times;</span>
        </button>
      </div>
      <div class="modal-body mx-3">
        {{-- Input del documento --}}
        <div class="md-form mb-4">
          <div class="form-row mb-6">
            <div class="col">
              <i class="fas fa-id-card"></i>
              <label data-error="wrong" data-success="right" for="orangeForm-name">Documento</label>
              <input readonly type="number" id="documento_user" class="form-control validate">
            </div>
            {{-- Input del tipo de documento --}}
            <div class="col">
              <i class="fas fa-id-card"></i>
              <label data-error="wrong" data-success="right" for="orangeForm-name">Tipo Documento</label>
              <select class="form-control validate" id="tipoDocumento_user" name="select_tipoDocumento">
                <option value="CC">Cédula de Ciudadanía</option>
                <option value="TI">Tarjeta de Identidad</option>
                <option value="CE">Cédula de Extranjería</option>
              </select>
            </div>
          </div>
        </div>
        {{-- Input de los nombres --}}
        <div class="md-form mb-4">
          <div class="form-row mb-6">
            <div class="col">
              <i class="fas fa-user"></i>
              <label data-error="wrong" data-success="right" for="orangeForm-email">Nombres</label>
              <input type="text" id="nombres_user" class="form-control validate">
            </div>
            {{-- Input de los apellidos  --}}
            <div class="col">
              <i class="fas fa-user"></i>
              <label data-error="wrong" data-success="right" for="orangeForm-pass">Apellidos</label>
              <input type="text" id="apellidos_user" class="form-control validate">
            </div>
          </div>
        </div>
        {{-- Input del centro  --}}
        <div class="md-form mb-4">
          <div class="form-row mb-6">
            <div class="col">
              <i class="fas fa-building"></i>
              <label data-error="wrong" data-success="right" for="orangeForm-pass">Centro</label>
              <input readonly type="text" id="centro_user" class="form-control validate">
            </div>
            {{-- Input de la regional  --}}
            <div class="col">
              <i class="fas fa-building"></i>
              <label data-error="wrong" data-success="right" for="orangeForm-pass">Regional</label>
              <input readonly type="text" id="regional_user" class="form-control validate">
            </div>
          </div>
        </div>
        {{-- Input del cargo  --}}
        <div class="md-form mb-4">
          <div class="form-row mb-6">
            <div class="col">
              <i class="fas fa-tag"></i>
              <label data-error="wrong" data-success="right" for="orangeForm-pass">Cargo</label>
              <input readonly class="form-control validate" id="cargo_user">
              <input hidden id="cargo_hidden">
            </div>
            {{-- Input del rol  --}}
            <div class="col-6">
              <i class="fas fa-tag"></i>
              <label data-error="wrong" data-success="right" for="orangeForm-name">Rol</label>
              <input readonly class="form-control validate" id="rol_user_a">
              <input hidden id="rol_hidden">
            </div>
          </div>
        </div>
        {{-- Input del correo --}}
        <div class="md-form mb-4">
          <div class="form-row mb-6">
            <div class="col">
              <i class="fas fa-envelope prefix grey-text"></i>
              <label data-error="wrong" data-success="right" for="orangeForm-pass">Correo</label>
              <input type="email" id="email_user" class="form-control validate">
            </div>
            <div class="col">
              <i class="fas fa-phone"></i>
              {{-- Input del telefono --}}
              <label data-error="wrong" data-success="right" for="orangeForm-pass">Teléfono</label>
              <input type="number" id="telefono_user" class="form-control validate">
            </div>
          </div>
        </div>
      </div>
      <div class="modal-footer d-flex justify-content-center">
        <button class="btn btn-primary" data-dismiss="modal">Cerrar</button>
        <button class="btn btn-success" id="updateSesion">Guardar</button>
      </div>
    </div>
  </div>
</div>