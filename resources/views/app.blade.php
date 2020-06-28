<!DOCTYPE html>
<html class="loading" lang="en" data-textdirection="ltr">
{{-- Header js y css --}}
@include('partials.htmlheader')
<body>
    {{-- Cabecera --}}
    @include('partials.mainheader')
    {{-- Sidebar --}}
    @include('partials.sidebar')
    <section>
        <div class="dashboard-wrapper imgbackground"
            style="background-image: url('images/CEAIbackground1.png'); background-repeat: no-repeat; background-position: -20% 68%">
            <div class="dashboard-ecommerce">
                <div class="container-fluid dashboard-content ">
                <!-- Contenido de cada pagina -->
                @yield('main-content')
            </div>
        </div>
        <br>
    </section>
    {{-- Pie de pagina --}}
    @include('partials.footer')
    {{-- Scripts js --}}
    @include('partials.scripts')
</body>
</html>