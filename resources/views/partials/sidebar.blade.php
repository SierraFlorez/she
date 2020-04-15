<!-- left sidebar -->
<!-- ============================================================== -->
<div class="nav-left-sidebar sidebar-dark">
    {{-- style="background-image: url(images/sidebar.png); background-repeat: no-repeat;background-position: center center; display: block;" #29913A !important --}}
    <div class="menu-list">
        <a class="navbar-brand" href="{{ url("/") }}" style="color: white">SHE</a>
        <nav class="navbar navbar-expand-lg navbar-light">
            <a class="d-xl-none d-lg-none" href="#"></a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav flex-column">
                    {{-- Gestion de Usuarios --}}
                    @if (Auth::user() && (Auth::user()->role_id==1))
                    <li class="nav-item ">
                        <a class="nav-link " href="{{ url("/usuarios") }}" data-target="#submenu-1"
                            aria-controls="submenu-1" style="margin-bottom: 10px; color:white;">
                            <i class="fas fa-address-card" style="color:white;"></i>Gestionar Usuarios<span
                                class="badge badge-success"></span>
                        </a>
                    </li>
                    {{-- Gestion de Cargos --}}
                    
                    <li class="nav-item ">
                        <a class="nav-link " href="{{ url("/cargos") }}" data-target="#submenu-1"
                            aria-controls="submenu-1" style="margin-bottom: 10px; color:white;">
                            <i class="fas fa-address-card" style="color:white;"></i>Gestionar Cargos<span
                                class="badge badge-success"></span>
                        </a>
                    </li>
                    {{-- Gestion de Horas Extras --}}
                    
                    <li class="nav-item ">
                        <a class="nav-link" href="{{ url("/horasExtras") }}" data-target="#submenu-1"
                            aria-controls="submenu-1" style="color:white;margin-bottom: 10px; ">
                            <i class="fas fa-address-card" style="color: white;"></i>Gestionar Horas Extras<span
                                class="badge badge-success">6</span>
                        </a>
                    </li>
                    {{-- Solicitud Autrizacion Horas Extras --}}
                    
                    <li class="nav-item ">
                        <a class="nav-link" href="{{ url("/solicitudes") }}" data-target="#submenu-1"
                            aria-controls="submenu-1" style="color:white;margin-bottom: 10px; ">
                            <i class="fas fa-address-card" style="color: white;"></i>Solicitud de Horas Extras<span
                                class="badge badge-success">6</span>
                        </a>
                    </li>
                    {{-- Reportes --}}
                    
                    <li class="nav-item ">
                        <a class="nav-link" href="{{ url("/reportes") }}" data-target="#submenu-1"
                            aria-controls="submenu-1" style="color:white;margin-bottom: 10px; ">
                            <i class="fas fa-address-card" style="color: white;"></i>Generar Reportes<span
                                class="badge badge-success">6</span>
                        </a>
                    </li>

                     {{-- Tipo de Horas --}}
                    
                     <li class="nav-item ">
                        <a class="nav-link" href="{{ url("/tipo_horas") }}" data-target="#submenu-1"
                            aria-controls="submenu-1" style="color:white;margin-bottom: 10px; ">
                            <i class="fas fa-address-card" style="color: white;"></i>Gestionar Tipo de Horas<span
                                class="badge badge-success">6</span>
                        </a>
                    </li>

                    {{-- Fechas especiales --}}
                    
                    <li class="nav-item ">
                        <a class="nav-link" href="{{ url("/fechas_especiales") }}" data-target="#submenu-1"
                            aria-controls="submenu-1" style="color:white;margin-bottom: 10px; ">
                            <i class="fas fa-address-card" style="color: white;"></i>Fechas Especiales<span
                                class="badge badge-success">6</span>
                        </a>
                    </li>

                        @endif
                    
                    @if (Auth::user())
                    <br>
                    <li class="nav-item">
                        <div class="dropdown invisibles">
                            <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenu2"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                {{ Auth::user()->nombres }}
                            </button>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenu2" style="width: 62%; ">
                                <button class="dropdown-item" type="button"
                                    onclick='detallesUsuario({{Auth::user()->id}})' data-toggle="modal" href="#"
                                    data-target="#modalCuenta"><i class="fas fa-user mr-2"></i>Cuenta</button>
                                    <hr>
                                <button class="dropdown-item" type="button" data-toggle="modal" href="#"
                                    data-target="#modalPassword"><i class="fas fa-cog mr-2"></i>Cambio de
                                    Contraseña</button>
                                    <hr>
                                <button class="dropdown-item" type="button" href="{{ route('logout') }}"
                                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><i
                                        class="fas fa-power-off mr-2"></i>Cerrar Sesión</button>
                            </div>
                        </div>
                    </li>
                    @endif
                </ul>
            </div>
    </div>
    </nav>
</div>
</div>
<!-- ============================================================== -->
<!-- end left sidebar -->