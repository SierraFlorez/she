
<div class="dashboard-main-wrapper" style="padding-top: 0rem;">
    <!-- ============================================================== -->
    <!-- navbar -->
    <!-- ============================================================== -->
    <div class="dashboard-header">
        <nav class="navbar navbar-expand-lg bg-white fixed-top headerr"
            style="border-bottom-width: 0px; background-color: #29913A !important;">
            {{-- <a style="border-left-width: 0px;border-left-style: solid;padding-left: 90%;"> Iniciar Sesión </a> --}}
            <button class="navbar-toggler collapsed" type="button" data-toggle="collapse" data-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse " id="navbarSupportedContent">
                <ul class="navbar-nav ml-auto navbar-right-top">
                    @if (Auth::User())
                    

                    <li class="nav-item dropdown nav-user">
                        <a class="nav-link nav-user-img btn btn-primary" href="#" id="navbarDropdownMenuLink2" data-toggle="dropdown"
                            aria-haspopup="true" aria-expanded="false"><i class="fa fa-user" style="color:white"></i></a>
                        <div class="dropdown-menu dropdown-menu-right nav-user-dropdown"
                            aria-labelledby="navbarDropdownMenuLink2">
                            <div class="nav-user-info">
                                <h5 class="mb-0 text-white nav-user-name">{{ Auth::user()->nombres }} </h5>
                            </div>
                            <a class="dropdown-item"  onclick='detallesUsuario({{Auth::user()->id}})' data-toggle="modal" href="#" data-target="#modalCuenta"><i class="fas fa-user mr-2"></i>Cuenta</a>
                            <a class="dropdown-item" data-toggle="modal" href="#" data-target="#modalPassword"><i
                                    class="fas fa-cog mr-2"></i>Cambio de contraseña</a>
                            <a class="dropdown-item" href="{{ route('logout') }}"
                                onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><i
                                    class="fas fa-power-off mr-2"></i>Cerrar Sesión
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                {{ csrf_field() }}
                            </form>
                        </div>
                        @endif
                    </li>
                </ul>
            </div>
        </nav>
    </div>
</div>