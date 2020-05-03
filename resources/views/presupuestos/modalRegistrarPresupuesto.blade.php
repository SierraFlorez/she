<div class="modal fade" id="modalRegistrarPresupuesto">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header text-center" style="background: #29913A;">
        <h4 class="modal-title w-100 font-weight-bold" style="color: white">Registrar Presupuesto</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true" style="color: white">&times;</span>
        </button>
      </div>
      <div class="modal-body mx-3">
        {{-- Input del presupuesto --}}
        <div class="md-form mb-4">
          <i class="fas fa-dollar-sign"></i>
          <label data-error="wrong" data-success="right" for="orangeForm-name">Presupuesto</label>
          <input required type="number" id="presupuesto_p" class="form-control validate">
        </div>
        {{-- Input del mes --}}
        <div class="md-form mb-4">
          <i class="fas fa-calendar"></i>
          <label data-error="wrong" data-success="right" for="orangeForm-name">Mes</label>
          <select class="form-control validate" id="mes_presupuesto">
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
        {{-- Input del año --}}
        <div class="md-form mb-4">
          <i class="fas fa-calendar"></i>
          <label data-error="wrong" data-success="right" for="orangeForm-email">Año</label>
          <select class="form-control validate" id="año_p" name="">
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
      </div>
      <div class="modal-footer d-flex justify-content-center">
        <button class="btn btn-primary" data-dismiss="modal">Cerrar</button>
        <button class="btn btn-secondary" onclick="savePresupuesto()">Guardar</button>
      </div>
    </div>
  </div>
</div>