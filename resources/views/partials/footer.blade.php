<div class="footer" style="margin-top: 14px; padding-top:2%;padding-left: 18%; background-color: #29913A !important;">
    <div class="container-fluid">
        <div class="row">
            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
               <p class="fottext" style="color: white;">Desarrollado por el Centro de Electricidad y Automatización Industrial - CEAI</p>
            </div>
        </div>
    </div>
</div>
@if (Auth::User())
@include('partials.modalCambiarContrasena')
@include('partials.modalCuenta')
@include('partials.modalCuentaCargo')
@endif