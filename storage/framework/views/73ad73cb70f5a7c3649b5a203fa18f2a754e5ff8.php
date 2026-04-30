<aside class="main-sidebar sidebar-dark-primary elevation-0">
    <?php
        $authUser = Auth::user();
        $isAdmin = $authUser && $authUser->hasAnyRole(['admin', 'superadmin']);
        $userPhotoPath = Auth::user()->foto ?? null;
        $userPhotoUrl = asset('vendor/adminlte/dist/img/AdminLTELogo.png');
        
        if ($userPhotoPath) {
            if (\Illuminate\Support\Str::startsWith($userPhotoPath, ['http://', 'https://', '//', 'data:'])) {
                $userPhotoUrl = $userPhotoPath;
            } elseif (\Illuminate\Support\Str::startsWith($userPhotoPath, '/')) {
                $userPhotoUrl = asset(ltrim($userPhotoPath, '/'));
            } else {
                $userPhotoUrl = asset('assets/' . ltrim($userPhotoPath, '/'));
            }
        }

        // Grupos de rutas para activar el estado del menú padre
        $sistemaRoutes = [
            'usuarios.index',
            'usuarios.create',
            'usuarios.edit',
            'inmobiliaria.index',
            'inmobiliaria.edit',
            'zonas.index',
            'zonas.create',
            'zonas.edit',
            'tipopropiedades.index',
            'tipopropiedades.create',
            'tipopropiedades.edit',
            'estados.index',
            'estados.create',
            'estados.edit',
            'disponiblepara.index',
            'disponiblepara.create',
            'disponiblepara.edit',
            'tipostareas.index',
            'tipostareas.create',
            'tipostareas.edit',
        ];
        $websiteRoutes = [
            'portadas.index',
            'portadas.create',
            'portadas.edit',
            'testimonios.index',
            'testimonios.create',
            'testimonios.edit',
            'posts.index',
            'posts.create',
            'posts.edit',
            'enfoques.index',
            'enfoques.create',
            'enfoques.edit',
        ];
        $reportesRoutes = [
            'clientespotenciales',
            'clientescerrados',
            'fuenteclientes',
            'tareasporcategorias',
            'propiedadesclick',
            'dashboardventas',
        ];
        $crmRoutes = [
            'clientes.*',
            'asignar',
            'import.index',
            'verificar',
            'propiedades.*',
            'mostrarinventario',
            'todo.*',
            'calendario',
            'registrarventa',
        ];

        $activeSistema = request()->routeIs($sistemaRoutes);
        $activeWebsite = request()->routeIs($websiteRoutes);
        $activeReportes = request()->routeIs($reportesRoutes);
        $activeCrm = request()->routeIs($crmRoutes);
    ?>

    <a href="<?php echo e(route('dashboard')); ?>" class="brand-link">
        <img src="<?php echo e(asset('vendor/adminlte/dist/img/AlisCRMInmobiliario.png')); ?>" alt="Alis CRM"
            class="brand-image img-circle elevation-0">
        <span class="brand-text">CRM</span>
    </a>

    <div class="sidebar">
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="<?php echo e($userPhotoUrl); ?>" class="img-circle elevation-2" alt="<?php echo e(Auth::user()->name); ?>"
                    style="width:36px;height:36px;object-fit:cover;">
            </div>
            <div class="info">
                <a href="#" class="d-block text-white font-weight-500"><?php echo e(Auth::user()->name); ?></a>
                <span class="text-xs" style="color:#94a3b8"><?php echo e($isAdmin ? 'Administrador' : 'Asesor'); ?></span>
            </div>
        </div>

        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                data-accordion="false">

                <?php if($isAdmin): ?>
                    <li class="nav-header">Configuracion</li>

                    <li class="nav-item <?php echo e($activeSistema ? 'menu-open' : ''); ?>">
                        <a href="#" class="nav-link <?php echo e($activeSistema ? 'active' : ''); ?>">
                            <i class="nav-icon fas fa-cog"></i>
                            <p>Sistema <i class="right fas fa-angle-left"></i></p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item"><a href="<?php echo e(route('usuarios.index')); ?>"
                                    class="nav-link <?php echo e(request()->routeIs('usuarios.*') ? 'active' : ''); ?>"><i
                                        class="nav-icon fas fa-users fa-fw"></i>
                                    <p>Usuarios</p>
                                </a></li>
                            <li class="nav-item"><a href="<?php echo e(route('inmobiliaria.index')); ?>"
                                    class="nav-link <?php echo e(request()->routeIs('inmobiliaria.*') ? 'active' : ''); ?>"><i
                                        class="nav-icon fas fa-building fa-fw"></i>
                                    <p>Empresa</p>
                                </a></li>
                            <li class="nav-item"><a href="<?php echo e(route('zonas.index')); ?>"
                                    class="nav-link <?php echo e(request()->routeIs('zonas.*') ? 'active' : ''); ?>"><i
                                        class="nav-icon fas fa-map-marker-alt fa-fw"></i>
                                    <p>Zonas</p>
                                </a></li>
                            <li class="nav-item"><a href="<?php echo e(route('tipopropiedades.index')); ?>"
                                    class="nav-link <?php echo e(request()->routeIs('tipopropiedades.*') ? 'active' : ''); ?>"><i
                                        class="nav-icon fas fa-city fa-fw"></i>
                                    <p>Tipos de propiedad</p>
                                </a></li>
                            <li class="nav-item"><a href="<?php echo e(route('estados.index')); ?>"
                                    class="nav-link <?php echo e(request()->routeIs('estados.*') ? 'active' : ''); ?>"><i
                                        class="nav-icon fas fa-toggle-on fa-fw"></i>
                                    <p>Estados</p>
                                </a></li>
                            <li class="nav-item"><a href="<?php echo e(route('disponiblepara.index')); ?>"
                                    class="nav-link <?php echo e(request()->routeIs('disponiblepara.*') ? 'active' : ''); ?>"><i
                                        class="nav-icon fas fa-tag fa-fw"></i>
                                    <p>Disponible para</p>
                                </a></li>
                            <li class="nav-item"><a href="<?php echo e(route('tipostareas.index')); ?>"
                                    class="nav-link <?php echo e(request()->routeIs('tipostareas.*') ? 'active' : ''); ?>"><i
                                        class="nav-icon fas fa-tasks fa-fw"></i>
                                    <p>Tipos de tarea</p>
                                </a></li>
                        </ul>
                    </li>

                    <li class="nav-item <?php echo e($activeWebsite ? 'menu-open' : ''); ?>">
                        <a href="#" class="nav-link <?php echo e($activeWebsite ? 'active' : ''); ?>">
                            <i class="nav-icon fas fa-paint-brush"></i>
                            <p>Website <i class="right fas fa-angle-left"></i></p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item"><a href="<?php echo e(route('portadas.index')); ?>"
                                    class="nav-link <?php echo e(request()->routeIs('portadas.*') ? 'active' : ''); ?>"><i
                                        class="nav-icon fas fa-image fa-fw"></i>
                                    <p>Portadas</p>
                                </a></li>
                            <li class="nav-item"><a href="<?php echo e(route('testimonios.index')); ?>"
                                    class="nav-link <?php echo e(request()->routeIs('testimonios.*') ? 'active' : ''); ?>"><i
                                        class="nav-icon fas fa-quote-right fa-fw"></i>
                                    <p>Testimonios</p>
                                </a></li>
                            <li class="nav-item"><a href="<?php echo e(route('posts.index')); ?>"
                                    class="nav-link <?php echo e(request()->routeIs('posts.*') ? 'active' : ''); ?>"><i
                                        class="nav-icon fas fa-blog fa-fw"></i>
                                    <p>Blog / Posts</p>
                                </a></li>
                            <li class="nav-item"><a href="<?php echo e(route('enfoques.index')); ?>"
                                    class="nav-link <?php echo e(request()->routeIs('enfoques.*') ? 'active' : ''); ?>"><i
                                        class="nav-icon fas fa-bullseye fa-fw"></i>
                                    <p>Enfoques</p>
                                </a></li>
                        </ul>
                    </li>
                <?php endif; ?>

                <li class="nav-item <?php echo e($activeCrm ? 'menu-open' : ''); ?>">
                    <a href="#" class="nav-link <?php echo e($activeCrm ? 'active' : ''); ?>">
                        <i class="nav-icon fas fa-briefcase"></i>
                        <p>CRM <i class="right fas fa-angle-left"></i></p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item"><a href="<?php echo e(route('clientes.index')); ?>"
                                class="nav-link <?php echo e(request()->routeIs('clientes.*') ? 'active' : ''); ?>"><i
                                    class="nav-icon fas fa-user-plus fa-fw"></i>
                                <p>Contactos</p>
                            </a></li>
                        <?php if($isAdmin): ?>
                            <li class="nav-item"><a href="<?php echo e(route('asignar')); ?>"
                                    class="nav-link <?php echo e(request()->routeIs('asignar') ? 'active' : ''); ?>"><i
                                        class="nav-icon fas fa-user-check fa-fw"></i>
                                    <p>Asignar contacto</p>
                                </a></li>
                            <li class="nav-item"><a href="<?php echo e(route('import.index')); ?>"
                                    class="nav-link <?php echo e(request()->routeIs('import.index') ? 'active' : ''); ?>"><i
                                        class="nav-icon fas fa-file-import fa-fw"></i>
                                    <p>Importar contactos</p>
                                </a></li>
                        <?php endif; ?>
                        <li class="nav-item"><a href="<?php echo e(route('verificar')); ?>"
                                class="nav-link <?php echo e(request()->routeIs('verificar') ? 'active' : ''); ?>"><i
                                    class="nav-icon fas fa-search fa-fw"></i>
                                <p>Consultar contacto</p>
                            </a></li>
                        <li class="nav-item"><a href="<?php echo e(route('propiedades.index')); ?>"
                                class="nav-link <?php echo e(request()->routeIs('propiedades.*') ? 'active' : ''); ?>"><i
                                    class="nav-icon fas fa-home fa-fw"></i>
                                <p>Mis propiedades</p>
                            </a></li>
                        <li class="nav-item"><a href="<?php echo e(route('mostrarinventario')); ?>"
                                class="nav-link <?php echo e(request()->routeIs('mostrarinventario') ? 'active' : ''); ?>"><i
                                    class="nav-icon fas fa-list fa-fw"></i>
                                <p>Inventario</p>
                            </a></li>
                        <li class="nav-item"><a href="<?php echo e(route('todo.index')); ?>"
                                class="nav-link <?php echo e(request()->routeIs('todo.*') ? 'active' : ''); ?>"><i
                                    class="nav-icon fas fa-check-square fa-fw"></i>
                                <p>Tareas</p>
                            </a></li>
                        <li class="nav-item"><a href="<?php echo e(route('calendario')); ?>"
                                class="nav-link <?php echo e(request()->routeIs('calendario') ? 'active' : ''); ?>"><i
                                    class="nav-icon fas fa-calendar-alt fa-fw"></i>
                                <p>Agenda</p>
                            </a></li>
                        <?php if($isAdmin): ?>
                            <li class="nav-item"><a href="<?php echo e(route('registrarventa')); ?>"
                                    class="nav-link <?php echo e(request()->routeIs('registrarventa') ? 'active' : ''); ?>"><i
                                        class="nav-icon fas fa-money-bill-wave fa-fw"></i>
                                    <p>Registrar venta</p>
                                </a></li>
                        <?php endif; ?>
                    </ul>
                </li>

                <li class="nav-header">Estadisticas</li>
                <li class="nav-item"><a href="<?php echo e(route('dashboardasesor')); ?>"
                        class="nav-link <?php echo e(request()->routeIs('dashboardasesor') ? 'active' : ''); ?>"><i
                            class="nav-icon fas fa-chart-bar fa-fw"></i>
                        <p>Mi dashboard</p>
                    </a></li>

                <li class="nav-item <?php echo e($activeReportes ? 'menu-open' : ''); ?>">
                    <a href="#" class="nav-link <?php echo e($activeReportes ? 'active' : ''); ?>">
                        <i class="nav-icon fas fa-chart-line"></i>
                        <p>
                            Reportes
                            <span class="badge badge-pill report-count-badge ml-2"><?php echo e($isAdmin ? '6' : '1'); ?></span>
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <?php if($isAdmin): ?>
                            <li class="nav-item"><a href="<?php echo e(route('clientespotenciales')); ?>"
                                    class="nav-link <?php echo e(request()->routeIs('clientespotenciales') ? 'active' : ''); ?>"><i
                                        class="fas fa-user-plus nav-icon"></i>
                                    <p>Clientes potenciales</p>
                                </a></li>
                            <li class="nav-item"><a href="<?php echo e(route('clientescerrados')); ?>"
                                    class="nav-link <?php echo e(request()->routeIs('clientescerrados') ? 'active' : ''); ?>"><i
                                        class="fas fa-handshake nav-icon"></i>
                                    <p>Clientes cerrados</p>
                                </a></li>
                            <li class="nav-item"><a href="<?php echo e(route('fuenteclientes')); ?>"
                                    class="nav-link <?php echo e(request()->routeIs('fuenteclientes') ? 'active' : ''); ?>"><i
                                        class="fas fa-bullhorn nav-icon"></i>
                                    <p>Fuente de clientes</p>
                                </a></li>
                            <li class="nav-item"><a href="<?php echo e(route('tareasporcategorias')); ?>"
                                    class="nav-link <?php echo e(request()->routeIs('tareasporcategorias') ? 'active' : ''); ?>"><i
                                        class="fas fa-tasks nav-icon"></i>
                                    <p>Tareas por categoria</p>
                                </a></li>
                            <li class="nav-item"><a href="<?php echo e(route('propiedadesclick')); ?>"
                                    class="nav-link <?php echo e(request()->routeIs('propiedadesclick') ? 'active' : ''); ?>"><i
                                        class="fas fa-mouse-pointer nav-icon"></i>
                                    <p>Propiedades por click</p>
                                </a></li>
                        <?php endif; ?>
                        <li class="nav-item"><a href="<?php echo e(route('dashboardventas')); ?>"
                                class="nav-link <?php echo e(request()->routeIs('dashboardventas') ? 'active' : ''); ?>"><i
                                    class="fas fa-dollar-sign nav-icon"></i>
                                <p>Ventas</p>
                            </a></li>
                    </ul>
                </li>

                <?php if($isAdmin): ?>
                    <li class="nav-header">Consultas admin</li>
                    <li class="nav-item"><a href="<?php echo e(route('consultaClientesAsesor')); ?>"
                            class="nav-link <?php echo e(request()->routeIs('consultaClientesAsesor') ? 'active' : ''); ?>"><i
                                class="nav-icon fas fa-calendar-check fa-fw"></i>
                            <p>Clientes por fecha</p>
                        </a></li>
                    <li class="nav-item"><a href="<?php echo e(route('contactostodos')); ?>"
                            class="nav-link <?php echo e(request()->routeIs('contactostodos') ? 'active' : ''); ?>"><i
                                class="nav-icon fas fa-address-book fa-fw"></i>
                            <p>Todos los contactos</p>
                        </a></li>
                    <li class="nav-item"><a href="<?php echo e(route('consultarpropiedades')); ?>"
                            class="nav-link <?php echo e(request()->routeIs('consultarpropiedades') ? 'active' : ''); ?>"><i
                                class="nav-icon fas fa-th-list fa-fw"></i>
                            <p>Todas las propiedades</p>
                        </a></li>
                    <?php if((bool) optional($inmo)->aprobacion): ?>
                        <li class="nav-item"><a href="<?php echo e(route('poraprobar')); ?>"
                                class="nav-link <?php echo e(request()->routeIs('poraprobar') ? 'active' : ''); ?>"><i
                                    class="nav-icon fas fa-clipboard-check fa-fw"></i>
                                <p>Aprobar propiedades</p>
                            </a></li>
                    <?php endif; ?>
                <?php endif; ?>

                <li class="nav-header">Accesos</li>
                <li class="nav-item"><a href="<?php echo e(url('/')); ?>" target="_blank" class="nav-link"><i
                            class="nav-icon fas fa-globe fa-fw"></i>
                        <p>Ver website</p>
                    </a></li>
                <li class="nav-item">
                    <a href="<?php echo e(route('logout')); ?>"
                        onclick="event.preventDefault(); document.getElementById('logout-sidebar-form').submit();"
                        class="nav-link" style="color:#f87171 !important;">
                        <i class="nav-icon fas fa-sign-out-alt fa-fw"></i>
                        <p>Cerrar sesion</p>
                    </a>
                    <form id="logout-sidebar-form" action="<?php echo e(route('logout')); ?>" method="POST" class="d-none">
                        <?php echo csrf_field(); ?>
                    </form>
                </li>
            </ul>
        </nav>
    </div>
</aside>
<?php /**PATH D:\xampp3\htdocs\realestate_dev\resources\views/admin/menu.blade.php ENDPATH**/ ?>