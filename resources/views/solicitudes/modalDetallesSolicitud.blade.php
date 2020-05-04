<div class="modal fade" id="modalDetallesSolicitud" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog"
  aria-labelledby="modalRegistrar" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header text-center" style="background: #29913A;">
        <h4 class="modal-title w-100 font-weight-bold" style="color: white">Detalles de Solicitud</h4>
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
              <input readonly type="text" id="funcionario_s" class="form-control validate">
              <input hidden type="text" id="cargo_user_s" class="form-control validate">
            </div>
            {{-- Input del cargo --}}
            <div class="col">
              <i class="fas fa-tag"></i>
              <label data-error="wrong" data-success="right" for="orangeForm-name">Cargo Solicitud</label>
              <input readonly type="text" id="cargo_s" class="form-control validate">
            </div>
          </div>
        </div>
        {{-- Fecha --}}
        <div class="md-form mb-4">
          <div class="form-row mb-6">
            {{-- Input de los apellidos  --}}
            <div class="col-6">
              <i class="fas fa-moon"></i>
              <label data-error="wrong" data-success="right" for="orangeForm-pass">Tipo de Hora</label>
              <select class="form-control validate" id="th_solicitud_s" name="tipohoras_s">
                @foreach($tipoHoras as $tipoHora)
                <option value="{{$tipoHora->id}}">{{$tipoHora->nombre_hora}}</option>
                @endforeach
              </select>
            </div>
          </div>
        </div>
        <div class="md-form mb-4">
          <div class="form-row mb-6">
            <div class="col">
              <i class="fas fa-clock"></i>
              <label data-error="wrong" data-success="right" for="orangeForm-name">Año de Solicitud</label>
            <br>
            <select class="form-control validate" id="año_solicitud_s" name="año_solicitud_s">
              <option value=""></option>
              <option value="2019">2019</option>
              <option value="2020">2020</option>
              <option value="2021">2021</option>
              <option value="2022">2022</option>
              <option value="2023">2023</option>
              <option value="2024">2024</option>
              <option value="2025">2025</option>
              <option value="2026">2026</option>
              <option value="2027">2027</option>
              <option value="2028">2028</option>
              <option value="2029">2029</option>
              <option value="2030">2030</option>
            </select>
            </div>
            {{-- Input de la regional  --}}
            <div class="col">
              <i class="fas fa-clock"></i>
              <label data-error="wrong" data-success="right" for="orangeForm-name">Mes de Solicitud</label>
            <select class="form-control validate" id="mes_solicitud_sd" name="mes_solicitud_s">
              <option value=""></option>
              <option value="1">Enero</option>
              <option value="2">Febrero</option>
              <option value="3">Marzo</option>
              <option value="4">Abril</option>
              <option value="5">Mayo</option>
              <option value="6">Junio</option>
              <option value="7">Julio</option>
              <option value="8">Agosto</option>
              <option value="9">Septiembre</option>
              <option value="10">Octubre</option>
              <option value="11">Noviembre</option>
              <option value="12">Diciembre</option>
            </select>
            </div>
          </div>
        </div>
        {{-- Input del centro  --}}
        <div class="md-form mb-4">
          <div class="form-row mb-6">
            <div class="col">
              <i class="fas fa-clock"></i>
              <label data-error="wrong" data-success="right" for="orangeForm-pass">Hora Inicio</label>
              <input type="time" id="hora_inicio_s" class="form-control validate">
            </div>
            {{-- Input de la regional  --}}
            <div class="col">
              <i class="fas fa-clock"></i>
              <label data-error="wrong" data-success="right" for="orangeForm-pass">Hora Fin</label>
              <input type="time" id="hora_fin_s" class="form-control validate">
            </div>
          </div>
        </div>
        <div id="inputs_e" class="md-form mb-4">
        </div>
        {{-- Input del cargo  --}}
        <div class="md-form mb-4">
          <div class="form-row mb-6">
            <div class="col">
              <i class="fas fa-tag"></i>
              <label data-error="wrong" data-success="right" for="orangeForm-pass">Valor Total</label>
              <input readonly class="form-control validate" id="valor_total_s">
            </div>
            {{-- Input del sueldo  --}}
            <div class="col-6">
              <i class="fas fa-dollar-sign"></i>
              <label data-error="wrong" data-success="right" for="orangeForm-pass">Valor de Hora</label>
              <input readonly type="number" id="valor_hora_s" class="form-control validate">
            </div>
          </div>
        </div>
        {{-- Input del correo --}}
        <div class="md-form mb-4">
          <div class="form-row mb-6">
            <div class="col">
              <i class="fas fa-clock"></i>
              <label data-error="wrong" data-success="right" for="orangeForm-pass">Cantidad de Horas</label>
              <input type="number" id="horas_s" class="form-control validate">
            </div>
            <div class="col">
              <i class="fas fa-user"></i>
              <label data-error="wrong" data-success="right" for="orangeForm-pass">Autorizado</label>
              <input readonly type="text" id="autorizado_s" class="form-control validate">
            </div>
          </div>
           {{-- Input Justificacion --}}
           <div class="md-form mb-4">
            <div class="form-row mb-6">
           <div class="col" style="margin-top:1%">
            <label data-error="wrong" data-success="right" for="orangeForm-name">Actividades:</label>
            <textarea class="form-control" id="actividades_s" style="height:100%;"></textarea>
            <input hidden type="text" id="cargo_user_s" class="form-control validate">
          </div>
        </div>
        </div>
      </div>
      </div>
      <div class="modal-footer d-flex justify-content-center">
        <button class="btn btn-primary" data-dismiss="modal">Cerrar</button>
        <button class="btn btn-secondary"  id="update_solicitud">Editar</button>
      </div>
    </div>
  </div>
</div>