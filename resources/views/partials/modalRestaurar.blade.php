<div class="modal fade" id="modalRestaurar" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header text-center" style="background: #29913A;">
                <h4 class="modal-title w-100 font-weight-bold"
                    style="color: white; text-align: center; padding-left: 6%;">Restaurar Contraseña</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true" style="color: white">&times;</span>
                </button>
            </div>
            {{ csrf_field() }}
            <div align="center" class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                <br>
                <label for="email" class="col-md-4 control-label">Correo Electrónico</label>
                <div class="col-md-12">
                    <input id="email_restaurar" type="email" class="form-control" name="email" required>
                </div>
            </div>
            <br>
            <br>
            <div class="form-group" align="right">
                <div class="col-md-6 col-md-offset-4">
                    <button onclick="restaurarContrasena();" id="notificacionCorreo" type="submit"
                        class="btn btn-primary">Enviar Enlace</button>
                </div>
            </div>
        </div>
    </div>
</div>