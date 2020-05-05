<!-- left sidebar -->
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
                    @if (Auth::user() && (Auth::user()->role_id==1))
                    {{-- SIDEBAR ADMINISTRADOR --}}
                    {{-- Gestion de Usuarios --}}
                    <li class="nav-item ">
                        <a class="nav-link " href="{{ url("/usuarios") }}" data-target="#submenu-1"
                            aria-controls="submenu-1" style="margin-bottom: 9px; color:white;font-size: 1.1rem">
                            <i class="fas fa-users" style="color:white;"></i>Gestión de Usuarios<span
                                class="badge badge-success"></span>
                        </a>
                    </li>
                    {{-- Gestion de Cargos --}}
                    <li class="nav-item ">
                        <a class="nav-link " href="{{ url("/cargos") }}" data-target="#submenu-1"
                            aria-controls="submenu-1" style="margin-bottom: 9px; color:white;font-size: 1.1rem">
                            <i class="fas fa-user-circle" style="color:white;"></i>Gestión de Cargos<span
                                class="badge badge-success"></span>
                        </a>
                    </li>
                    {{-- Gestion de Horas Extras --}}
                    <li class="nav-item ">
                        <a class="nav-link" href="{{ url("/horas_extras") }}" data-target="#submenu-1"
                            aria-controls="submenu-1" style="color:white;margin-bottom: 9px;font-size: 1.1rem ">
                            <i class="fas fa-history" style="color: white;"></i>Gestión Horas Extras<span
                                class="badge badge-success">6</span>
                        </a>
                    </li>
                    {{-- Presupuestos --}}
                    <li class="nav-item ">
                        <a class="nav-link" href="{{ url("/presupuestos") }}" data-target="#submenu-1"
                            aria-controls="submenu-1" style="color:white;margin-bottom: 9px;font-size: 1.1rem ">
                            <i class="fas fa-briefcase" style="color: white;"></i>Gestión de Presupuestos<span
                                class="badge badge-success">6</span>
                        </a>
                    </li>
                    {{-- Reportes --}}
                    <li class="nav-item ">
                        <a class="nav-link" href="{{ url("/reportes") }}" data-target="#submenu-1"
                            aria-controls="submenu-1" style="color:white;margin-bottom: 9px;font-size: 1.1rem ">
                            <i class="fas fa-file-excel" style="color: white;"></i>Generar Reportes<span
                                class="badge badge-success">6</span>
                        </a>
                    </li>
                    {{-- Tipo de Horas --}}
                    <li class="nav-item ">
                        <a class="nav-link" href="{{ url("/tipo_horas") }}" data-target="#submenu-1"
                            aria-controls="submenu-1" style="color:white;margin-bottom: 9px;font-size: 1.1rem ">
                            <i class="fas fa-sun" style="color: white;"></i>Gestión de Tipo de Horas<span
                                class="badge badge-success">6</span>
                        </a>
                    </li>
                    {{-- Fechas especiales --}}
                    <li class="nav-item ">
                        <a class="nav-link" href="{{ url("/fechas_especiales") }}" data-target="#submenu-1"
                            aria-controls="submenu-1" style="color:white;margin-bottom: 9px;font-size: 1.1rem ">
                            <i class="fas fa-calendar-check" style="color: white;"></i>Gestión de Fechas Especiales<span
                                class="badge badge-success">6</span>
                        </a>
                    </li>
                    @endif
                    @if (Auth::user() && (Auth::user()->role_id==2))
                    {{-- ------------------------------------------------------------------------------------------------- --}}
                    {{-- SIDEBAR FUNCIONARIOS --}}
                    {{-- Gestion de Horas Extras --}}
                    <li class="nav-item ">
                        <a class="nav-link" href="{{ url("/horas_extras") }}" data-target="#submenu-1"
                            aria-controls="submenu-1" style="color:white;margin-bottom: 9px;font-size: 1.1rem ">
                            <i class="fas fa-history" style="color: white;"></i>Gestión Horas Extras<span
                                class="badge badge-success">6</span>
                        </a>
                    </li>
                    {{-- Reportes --}}
                    <li class="nav-item ">
                        <a class="nav-link" href="{{ url("/reportes") }}" data-target="#submenu-1"
                            aria-controls="submenu-1" style="color:white;margin-bottom: 9px;font-size: 1.1rem ">
                            <i class="fas fa-file-excel" style="color: white;"></i>Generar Reportes<span
                                class="badge badge-success">6</span>
                        </a>
                    </li>
                    @endif
                </ul>
            </div>
    </div>
    </nav>
</div>
</div>
<!-- end left sidebar -->