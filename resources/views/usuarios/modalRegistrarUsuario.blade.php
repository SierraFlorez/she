<div class="modal fade" id="modalRegistrarUsuario" data-backdrop="static" data-keyboard="false" tabindex="-1"
  role="dialog" aria-labelledby="modalRegistrar" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header text-center" style="background: #29913A;">
        <h4 class="modal-title w-100 font-weight-bold" style="color: white">Registrar Usuario</h4>
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
              <label data-error="wrong" data-success="right" for="orangeForm-name">Documento *</label>
              <input required type="number" id="documento_user_g" class="form-control validate">
            </div>
            {{-- Input del tipo de documento --}}
            <div class="col">
              <i class="fas fa-id-card"></i>
              <label data-error="wrong" data-success="right" for="orangeForm-name">Tipo Documento *</label>
              <select required class="form-control validate" id="tipoDocumento_user_g" name="select_tipoDocumento_g">
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
              <label data-error="wrong" data-success="right" for="orangeForm-email">Nombres *</label>
              <input required type="text" id="nombres_user_g" class="form-control validate">
            </div>
            {{-- Input de los apellidos  --}}
            <div class="col">
              <i class="fas fa-user"></i>
              <label data-error="wrong" data-success="right" for="orangeForm-pass">Apellidos *</label>
              <input required type="text" id="apellidos_user_g" class="form-control validate">
            </div>
          </div>
        </div>
        {{-- Input del centro  --}}
        <div class="md-form mb-4">
          <div class="form-row mb-6">
            <div class="col">
              <i class="fas fa-building"></i>
              <label data-error="wrong" data-success="right" for="orangeForm-pass">Centro *</label>
              <select required class="form-control validate" id="centro_user_g" name="select_centro_g">
                <option value="CEAI">CEAI</option>
              </select>
            </div>
            {{-- Input de la regional  --}}
            <div class="col">
              <i class="fas fa-building"></i>
              <label data-error="wrong" data-success="right" for="orangeForm-pass">Regional *</label>
              <select required class="form-control validate" id="regional_user_g" name="select_regional_g">
                <option value="VALLE">Valle</option>
              </select>
            </div>
          </div>
        </div>
        {{-- Input del rol  --}}
        <div class="md-form mb-4">
          <div class="form-row mb-6">
            <div class="col">
              <i class="fas fa-tag"></i>
              <label data-error="wrong" data-success="right" for="orangeForm-pass">Rol *</label>
              <select onchange="NoCargo();" required class="form-control validate" id="cargo_user_g" name="select_rol_g">
                <option value=""></option>
                @foreach($roles as $rol)
                <option value="{{$rol->id}}">{{$rol->nombre}}</option>
                @endforeach
              </select>
            </div>
            {{-- Input del cargo --}}
            <div class="col" id="divCargo">
              <i class="fas fa-tag"></i>
              <label data-error="wrong" data-success="right" for="orangeForm-pass">Cargo *</label>
              <select required class="form-control validate" id="cargo_user_g" name="select_cargo_g">
                <option value=""></option>
                @foreach($cargos as $cargo)
                <option value="{{$cargo->id}}">{{$cargo->nombre}}</option>
                @endforeach
              </select>
            </div>
          </div>
        </div>
        {{-- Input del correo --}}
        <div class="md-form mb-4">
          <div class="form-row mb-6">
            <div class="col">
              <i class="fas fa-envelope prefix grey-text"></i>
              <label data-error="wrong" data-success="right" for="orangeForm-pass">Correo *</label>
              <input required type="email" id="email_user_g" class="form-control validate">
            </div>
            <div class="col">
              <i class="fas fa-phone"></i>
              {{-- Input del telefono --}}
              <label data-error="wrong" data-success="right" for="orangeForm-pass">Teléfono

              </label>
              <input required type="number" id="telefono_user_g" class="form-control validate">
            </div>
          </div>
        </div>
      </div>
      <div class="modal-footer d-flex justify-content-center">
        <button class="btn btn-primary" data-dismiss="modal">Cerrar</button>
        <button class="btn btn-success" id="" onclick="crearUsuario()">Guardar</button>
      </div>
    </div>
  </div>
</div>