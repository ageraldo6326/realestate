<aside class="main-sidebar sidebar-dark-primary elevation-0">
    @php
        $authUser = Auth::user();
        $isAdmin = $authUser && $authUser->hasAnyRole(['admin', 'superadmin']);
        $userPhotoPath = Auth::user()->foto ?? null;
        $userPhotoUrl = $userPhotoPath
            ? (\Illuminate\Support\Str::startsWith($userPhotoPath, ['http://', 'https://', '//', 'data:'])
                ? $userPhotoPath
                : url('/assets/' . ltrim($userPhotoPath, '/')))
            : asset('vendor/adminlte/dist/img/AdminLTELogo.png');

        // Grupos de rutas para activar el estado del menú padre
        $sistemaRoutes = ['usuarios.index', 'usuarios.create', 'usuarios.edit', 'inmobiliaria.index', 'inmobiliaria.edit', 'zonas.index', 'zonas.create', 'zonas.edit', 'tipopropiedades.index', 'tipopropiedades.create', 'tipopropiedades.edit', 'estados.index', 'estados.create', 'estados.edit', 'disponiblepara.index', 'disponiblepara.create', 'disponiblepara.edit', 'tipostareas.index', 'tipostareas.create', 'tipostareas.edit'];
        $websiteRoutes = ['portadas.index', 'portadas.create', 'portadas.edit', 'testimonios.index', 'testimonios.create', 'testimonios.edit', 'posts.index', 'posts.create', 'posts.edit', 'enfoques.index', 'enfoques.create', 'enfoques.edit'];
        $reportesRoutes = ['clientespotenciales', 'clientescerrados', 'fuenteclientes', 'tareasporcategorias', 'propiedadesclick', 'dashboardventas'];

        $activeSistema = request()->routeIs($sistemaRoutes);
        $activeWebsite = request()->routeIs($websiteRoutes);
        $activeReportes = request()->routeIs($reportesRoutes);
    @endphp

    <a href="{{ route('dashboard') }}" class="brand-link">
        <img src="{{ asset('vendor/adminlte/dist/img/AlisCRMInmobiliario.png') }}" alt="Alis CRM"
            class="brand-image img-circle elevation-0">
        <span class="brand-text">CRM</span>
    </a>

    <div class="sidebar">
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="{{ $userPhotoUrl }}" class="img-circle elevation-2" alt="{{ Auth::user()->name }}"
                    style="width:36px;height:36px;object-fit:cover;">
            </div>
            <div class="info">
                <a href="#" class="d-block text-white font-weight-500">{{ Auth::user()->name }}</a>
                <span class="text-xs" style="color:#94a3b8">{{ $isAdmin ? 'Administrador' : 'Asesor' }}</span>
            </div>
        </div>

        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                data-accordion="false">

                @if ($isAdmin)
                    <li class="nav-header">Configuracion</li>

                    <li class="nav-item {{ $activeSistema ? 'menu-open' : '' }}">
                        <a href="#" class="nav-link {{ $activeSistema ? 'active' : '' }}">
                            <i class="nav-icon fas fa-cog"></i>
                            <p>Sistema <i class="right fas fa-angle-left"></i></p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item"><a href="{{ route('usuarios.index') }}" class="nav-link {{ request()->routeIs('usuarios.*') ? 'active' : '' }}"><i
                                        class="nav-icon fas fa-users fa-fw"></i>
                                    <p>Usuarios</p>
                                </a></li>
                            <li class="nav-item"><a href="{{ route('inmobiliaria.index') }}" class="nav-link {{ request()->routeIs('inmobiliaria.*') ? 'active' : '' }}"><i
                                        class="nav-icon fas fa-building fa-fw"></i>
                                    <p>Empresa</p>
                                </a></li>
                            <li class="nav-item"><a href="{{ route('zonas.index') }}" class="nav-link {{ request()->routeIs('zonas.*') ? 'active' : '' }}"><i
                                        class="nav-icon fas fa-map-marker-alt fa-fw"></i>
                                    <p>Zonas</p>
                                </a></li>
                            <li class="nav-item"><a href="{{ route('tipopropiedades.index') }}" class="nav-link {{ request()->routeIs('tipopropiedades.*') ? 'active' : '' }}"><i
                                        class="nav-icon fas fa-city fa-fw"></i>
                                    <p>Tipos de propiedad</p>
                                </a></li>
                            <li class="nav-item"><a href="{{ route('estados.index') }}" class="nav-link {{ request()->routeIs('estados.*') ? 'active' : '' }}"><i
                                        class="nav-icon fas fa-toggle-on fa-fw"></i>
                                    <p>Estados</p>
                                </a></li>
                            <li class="nav-item"><a href="{{ route('disponiblepara.index') }}" class="nav-link {{ request()->routeIs('disponiblepara.*') ? 'active' : '' }}"><i
                                        class="nav-icon fas fa-tag fa-fw"></i>
                                    <p>Disponible para</p>
                                </a></li>
                            <li class="nav-item"><a href="{{ route('tipostareas.index') }}" class="nav-link {{ request()->routeIs('tipostareas.*') ? 'active' : '' }}"><i
                                        class="nav-icon fas fa-tasks fa-fw"></i>
                                    <p>Tipos de tarea</p>
                                </a></li>
                        </ul>
                    </li>

                    <li class="nav-item {{ $activeWebsite ? 'menu-open' : '' }}">
                        <a href="#" class="nav-link {{ $activeWebsite ? 'active' : '' }}">
                            <i class="nav-icon fas fa-paint-brush"></i>
                            <p>Website <i class="right fas fa-angle-left"></i></p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item"><a href="{{ route('portadas.index') }}" class="nav-link {{ request()->routeIs('portadas.*') ? 'active' : '' }}"><i
                                        class="nav-icon fas fa-image fa-fw"></i>
                                    <p>Portadas</p>
                                </a></li>
                            <li class="nav-item"><a href="{{ route('testimonios.index') }}" class="nav-link {{ request()->routeIs('testimonios.*') ? 'active' : '' }}"><i
                                        class="nav-icon fas fa-quote-right fa-fw"></i>
                                    <p>Testimonios</p>
                                </a></li>
                            <li class="nav-item"><a href="{{ route('posts.index') }}" class="nav-link {{ request()->routeIs('posts.*') ? 'active' : '' }}"><i
                                        class="nav-icon fas fa-blog fa-fw"></i>
                                    <p>Blog / Posts</p>
                                </a></li>
                            <li class="nav-item"><a href="{{ route('enfoques.index') }}" class="nav-link {{ request()->routeIs('enfoques.*') ? 'active' : '' }}"><i
                                        class="nav-icon fas fa-bullseye fa-fw"></i>
                                    <p>Enfoques</p>
                                </a></li>
                        </ul>
                    </li>
                @endif

                <li class="nav-header">CRM</li>
                <li class="nav-item"><a href="{{ route('clientes.index') }}" class="nav-link {{ request()->routeIs('clientes.*') ? 'active' : '' }}"><i
                            class="nav-icon fas fa-user-plus fa-fw"></i>
                        <p>Contactos</p>
                    </a></li>
                @if ($isAdmin)
                    <li class="nav-item"><a href="{{ route('asignar') }}" class="nav-link {{ request()->routeIs('asignar') ? 'active' : '' }}"><i
                                class="nav-icon fas fa-user-check fa-fw"></i>
                            <p>Asignar contacto</p>
                        </a></li>
                    <li class="nav-item"><a href="{{ route('import.index') }}" class="nav-link {{ request()->routeIs('import.index') ? 'active' : '' }}"><i
                                class="nav-icon fas fa-file-import fa-fw"></i>
                            <p>Importar contactos</p>
                        </a></li>
                @endif
                <li class="nav-item"><a href="{{ route('verificar') }}" class="nav-link {{ request()->routeIs('verificar') ? 'active' : '' }}"><i
                            class="nav-icon fas fa-search fa-fw"></i>
                        <p>Consultar contacto</p>
                    </a></li>
                <li class="nav-item"><a href="{{ route('propiedades.index') }}" class="nav-link {{ request()->routeIs('propiedades.*') ? 'active' : '' }}"><i
                            class="nav-icon fas fa-home fa-fw"></i>
                        <p>Mis propiedades</p>
                    </a></li>
                <li class="nav-item"><a href="{{ route('mostrarinventario') }}" class="nav-link {{ request()->routeIs('mostrarinventario') ? 'active' : '' }}"><i
                            class="nav-icon fas fa-list fa-fw"></i>
                        <p>Inventario</p>
                    </a></li>
                <li class="nav-item"><a href="{{ route('todo.index') }}" class="nav-link {{ request()->routeIs('todo.*') ? 'active' : '' }}"><i
                            class="nav-icon fas fa-check-square fa-fw"></i>
                        <p>Tareas</p>
                    </a></li>
                <li class="nav-item"><a href="{{ route('calendario') }}" class="nav-link {{ request()->routeIs('calendario') ? 'active' : '' }}"><i
                            class="nav-icon fas fa-calendar-alt fa-fw"></i>
                        <p>Agenda</p>
                    </a></li>
                @if ($isAdmin)
                    <li class="nav-item"><a href="{{ route('registrarventa') }}" class="nav-link {{ request()->routeIs('registrarventa') ? 'active' : '' }}"><i
                                class="nav-icon fas fa-money-bill-wave fa-fw"></i>
                            <p>Registrar venta</p>
                        </a></li>
                @endif

                <li class="nav-header">Estadisticas</li>
                <li class="nav-item"><a href="{{ route('dashboardasesor') }}" class="nav-link {{ request()->routeIs('dashboardasesor') ? 'active' : '' }}"><i
                            class="nav-icon fas fa-chart-bar fa-fw"></i>
                        <p>Mi dashboard</p>
                    </a></li>

                <li class="nav-item {{ $activeReportes ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link {{ $activeReportes ? 'active' : '' }}">
                        <i class="nav-icon fas fa-chart-line"></i>
                        <p>
                            Reportes
                            <span class="badge badge-pill report-count-badge ml-2">{{ $isAdmin ? '6' : '1' }}</span>
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        @if ($isAdmin)
                            <li class="nav-item"><a href="{{ route('clientespotenciales') }}" class="nav-link {{ request()->routeIs('clientespotenciales') ? 'active' : '' }}"><i
                                        class="fas fa-user-plus nav-icon"></i>
                                    <p>Clientes potenciales</p>
                                </a></li>
                            <li class="nav-item"><a href="{{ route('clientescerrados') }}" class="nav-link {{ request()->routeIs('clientescerrados') ? 'active' : '' }}"><i
                                        class="fas fa-handshake nav-icon"></i>
                                    <p>Clientes cerrados</p>
                                </a></li>
                            <li class="nav-item"><a href="{{ route('fuenteclientes') }}" class="nav-link {{ request()->routeIs('fuenteclientes') ? 'active' : '' }}"><i
                                        class="fas fa-bullhorn nav-icon"></i>
                                    <p>Fuente de clientes</p>
                                </a></li>
                            <li class="nav-item"><a href="{{ route('tareasporcategorias') }}" class="nav-link {{ request()->routeIs('tareasporcategorias') ? 'active' : '' }}"><i
                                        class="fas fa-tasks nav-icon"></i>
                                    <p>Tareas por categoria</p>
                                </a></li>
                            <li class="nav-item"><a href="{{ route('propiedadesclick') }}" class="nav-link {{ request()->routeIs('propiedadesclick') ? 'active' : '' }}"><i
                                        class="fas fa-mouse-pointer nav-icon"></i>
                                    <p>Propiedades por click</p>
                                </a></li>
                        @endif
                        <li class="nav-item"><a href="{{ route('dashboardventas') }}" class="nav-link {{ request()->routeIs('dashboardventas') ? 'active' : '' }}"><i
                                    class="fas fa-dollar-sign nav-icon"></i>
                                <p>Ventas</p>
                            </a></li>
                    </ul>
                </li>

                @if ($isAdmin)
                    <li class="nav-header">Consultas admin</li>
                    <li class="nav-item"><a href="{{ route('consultaClientesAsesor') }}" class="nav-link {{ request()->routeIs('consultaClientesAsesor') ? 'active' : '' }}"><i
                                class="nav-icon fas fa-calendar-check fa-fw"></i>
                            <p>Clientes por fecha</p>
                        </a></li>
                    <li class="nav-item"><a href="{{ route('contactostodos') }}" class="nav-link {{ request()->routeIs('contactostodos') ? 'active' : '' }}"><i
                                class="nav-icon fas fa-address-book fa-fw"></i>
                            <p>Todos los contactos</p>
                        </a></li>
                    <li class="nav-item"><a href="{{ route('consultarpropiedades') }}" class="nav-link {{ request()->routeIs('consultarpropiedades') ? 'active' : '' }}"><i
                                class="nav-icon fas fa-th-list fa-fw"></i>
                            <p>Todas las propiedades</p>
                        </a></li>
                    @if (optional($inmo)->aprobacion == 'on')
                        <li class="nav-item"><a href="{{ route('poraprobar') }}" class="nav-link {{ request()->routeIs('poraprobar') ? 'active' : '' }}"><i
                                    class="nav-icon fas fa-clipboard-check fa-fw"></i>
                                <p>Aprobar propiedades</p>
                            </a></li>
                    @endif
                @endif

                <li class="nav-header">Accesos</li>
                <li class="nav-item"><a href="{{ url('/') }}" target="_blank" class="nav-link"><i
                            class="nav-icon fas fa-globe fa-fw"></i>
                        <p>Ver website</p>
                    </a></li>
                <li class="nav-item">
                    <a href="{{ route('logout') }}"
                        onclick="event.preventDefault(); document.getElementById('logout-sidebar-form').submit();"
                        class="nav-link" style="color:#f87171 !important;">
                        <i class="nav-icon fas fa-sign-out-alt fa-fw"></i>
                        <p>Cerrar sesion</p>
                    </a>
                    <form id="logout-sidebar-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                </li>
            </ul>
        </nav>
    </div>
</aside>
