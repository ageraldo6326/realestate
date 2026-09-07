<?php
    $authUser = Auth::user();
    $isAdmin = $authUser && $authUser->hasAnyRole(['admin', 'superadmin']);
    $userPhotoPath = $authUser->foto ?? null;
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

    $sistemaRoutes = ['usuarios.index', 'usuarios.create', 'usuarios.edit', 'inmobiliaria.index', 'inmobiliaria.edit', 'zonas.index', 'zonas.create', 'zonas.edit', 'tipopropiedades.index', 'tipopropiedades.create', 'tipopropiedades.edit', 'estados.index', 'estados.create', 'estados.edit', 'disponiblepara.index', 'disponiblepara.create', 'disponiblepara.edit', 'tipostareas.index', 'tipostareas.create', 'tipostareas.edit'];
    $websiteRoutes = ['portadas.index', 'portadas.create', 'portadas.edit', 'testimonios.index', 'testimonios.create', 'testimonios.edit', 'posts.index', 'posts.create', 'posts.edit', 'enfoques.index', 'enfoques.create', 'enfoques.edit'];
    $reportesRoutes = ['clientespotenciales', 'clientescerrados', 'fuenteclientes', 'tareasporcategorias', 'propiedadesclick', 'dashboardventas'];
    $crmRoutes = ['clientes.*', 'asignar', 'import.index', 'verificar', 'propiedades.*', 'mostrarinventario', 'todo.*', 'calendario', 'registrarventa'];

    $makeLink = static function (string $key, string $label, string $icon, string $url, bool $active, array $terms = [], ?string $target = null): array {
        return compact('key', 'label', 'icon', 'url', 'active', 'terms', 'target');
    };
    $makeGroup = static function (string $key, string $label, string $icon, array $children, bool $active, array $terms = []): array {
        return compact('key', 'label', 'icon', 'children', 'active', 'terms');
    };

    $groups = [];

    if ($isAdmin) {
        $groups[] = [
            'label' => 'Configuración',
            'items' => [
                $makeGroup('sistema', 'Sistema', 'fas fa-cog', [
                    $makeLink('usuarios', 'Usuarios', 'fas fa-users', route('usuarios.index'), request()->routeIs('usuarios.*'), ['equipo']),
                    $makeLink('empresa', 'Empresa', 'fas fa-building', route('inmobiliaria.index'), request()->routeIs('inmobiliaria.*'), ['inmobiliaria']),
                    $makeLink('zonas', 'Zonas', 'fas fa-map-marker-alt', route('zonas.index'), request()->routeIs('zonas.*'), ['ubicaciones']),
                    $makeLink('tipos-propiedad', 'Tipos de propiedad', 'fas fa-city', route('tipopropiedades.index'), request()->routeIs('tipopropiedades.*'), ['categorías']),
                    $makeLink('estados', 'Estados', 'fas fa-toggle-on', route('estados.index'), request()->routeIs('estados.*'), ['estatus']),
                    $makeLink('disponible-para', 'Disponible para', 'fas fa-tag', route('disponiblepara.index'), request()->routeIs('disponiblepara.*'), ['venta alquiler']),
                    $makeLink('tipos-tarea', 'Tipos de tarea', 'fas fa-tasks', route('tipostareas.index'), request()->routeIs('tipostareas.*'), ['agenda']),
                ], request()->routeIs($sistemaRoutes), ['ajustes']),
                $makeGroup('website', 'Website', 'fas fa-paint-brush', [
                    $makeLink('portadas', 'Portadas', 'fas fa-image', route('portadas.index'), request()->routeIs('portadas.*'), ['inicio']),
                    $makeLink('testimonios', 'Testimonios', 'fas fa-quote-right', route('testimonios.index'), request()->routeIs('testimonios.*'), ['reseñas']),
                    $makeLink('posts', 'Blog / Posts', 'fas fa-blog', route('posts.index'), request()->routeIs('posts.*'), ['artículos']),
                    $makeLink('enfoques', 'Enfoques', 'fas fa-bullseye', route('enfoques.index'), request()->routeIs('enfoques.*'), ['servicios']),
                ], request()->routeIs($websiteRoutes), ['sitio inmobiliario']),
            ],
        ];
    }

    $crmChildren = [
        $makeLink('contactos', 'Contactos', 'fas fa-user-plus', route('clientes.index'), request()->routeIs('clientes.*'), ['clientes leads']),
    ];
    if ($isAdmin) {
        $crmChildren[] = $makeLink('asignar-contacto', 'Asignar contacto', 'fas fa-user-check', route('asignar'), request()->routeIs('asignar'), ['repartir leads']);
        $crmChildren[] = $makeLink('importar-contactos', 'Importar contactos', 'fas fa-file-import', route('import.index'), request()->routeIs('import.index'), ['csv leads']);
    }
    $crmChildren = array_merge($crmChildren, [
        $makeLink('consultar-contacto', 'Consultar contacto', 'fas fa-search', route('verificar'), request()->routeIs('verificar'), ['buscar cliente']),
        $makeLink('mis-propiedades', 'Mis propiedades', 'fas fa-home', route('propiedades.index'), request()->routeIs('propiedades.*'), ['inmuebles']),
        $makeLink('inventario', 'Inventario', 'fas fa-list', route('mostrarinventario'), request()->routeIs('mostrarinventario'), ['portafolio']),
        $makeLink('tareas', 'Tareas', 'fas fa-check-square', route('todo.index'), request()->routeIs('todo.*'), ['pendientes']),
        $makeLink('agenda', 'Agenda', 'fas fa-calendar-alt', route('calendario'), request()->routeIs('calendario'), ['calendario']),
    ]);
    if ($isAdmin) {
        $crmChildren[] = $makeLink('registrar-venta', 'Registrar venta', 'fas fa-money-bill-wave', route('registrarventa'), request()->routeIs('registrarventa'), ['ventas']);
    }
    $groups[] = ['label' => 'CRM', 'items' => [$makeGroup('crm', 'CRM', 'fas fa-briefcase', $crmChildren, request()->routeIs($crmRoutes), ['gestión inmobiliaria'])]];

    $reportChildren = [];
    if ($isAdmin) {
        $reportChildren = [
            $makeLink('clientes-potenciales', 'Clientes potenciales', 'fas fa-user-plus', route('clientespotenciales'), request()->routeIs('clientespotenciales'), ['leads']),
            $makeLink('clientes-cerrados', 'Clientes cerrados', 'fas fa-handshake', route('clientescerrados'), request()->routeIs('clientescerrados'), ['ventas']),
            $makeLink('fuente-clientes', 'Fuente de clientes', 'fas fa-bullhorn', route('fuenteclientes'), request()->routeIs('fuenteclientes'), ['origen leads']),
            $makeLink('tareas-categoria', 'Tareas por categoría', 'fas fa-tasks', route('tareasporcategorias'), request()->routeIs('tareasporcategorias'), ['agenda']),
            $makeLink('propiedades-click', 'Propiedades por click', 'fas fa-mouse-pointer', route('propiedadesclick'), request()->routeIs('propiedadesclick'), ['interacciones']),
        ];
    }
    $reportChildren[] = $makeLink('ventas', 'Ventas', 'fas fa-dollar-sign', route('dashboardventas'), request()->routeIs('dashboardventas'), ['métricas']);
    $groups[] = [
        'label' => 'Estadísticas',
        'items' => [
            $makeLink('mi-dashboard', 'Mi dashboard', 'fas fa-chart-bar', route('dashboardasesor'), request()->routeIs('dashboardasesor'), ['rendimiento']),
            $makeGroup('reportes', 'Reportes', 'fas fa-chart-line', $reportChildren, request()->routeIs($reportesRoutes), ['analítica métricas']),
        ],
    ];

    if ($isAdmin) {
        $adminQueries = [
            $makeLink('clientes-fecha', 'Clientes por fecha', 'fas fa-calendar-check', route('consultaClientesAsesor'), request()->routeIs('consultaClientesAsesor'), ['consultas']),
            $makeLink('todos-contactos', 'Todos los contactos', 'fas fa-address-book', route('contactostodos'), request()->routeIs('contactostodos'), ['clientes']),
            $makeLink('todas-propiedades', 'Todas las propiedades', 'fas fa-th-list', route('consultarpropiedades'), request()->routeIs('consultarpropiedades'), ['inventario']),
        ];
        if ((bool) optional($inmo)->aprobacion) {
            $adminQueries[] = $makeLink('aprobar-propiedades', 'Aprobar propiedades', 'fas fa-clipboard-check', route('poraprobar'), request()->routeIs('poraprobar'), ['pendientes']);
        }
        $groups[] = ['label' => 'Consultas admin', 'items' => $adminQueries];
    }

    $groups[] = ['label' => 'Accesos', 'items' => [
        $makeLink('ver-website', 'Ver website', 'fas fa-globe', url('/'), false, ['sitio público'], '_blank'),
    ]];
?>

<aside id="modern-sidebar" class="main-sidebar app-modern-sidebar" aria-label="Navegación principal">
    <div class="app-modern-sidebar__brand">
        <a href="<?php echo e(route('dashboard')); ?>" class="app-modern-sidebar__brand-link" aria-label="Alis CRM, ir al inicio">
            <img src="<?php echo e(asset('vendor/adminlte/dist/img/AlisCRMInmobiliario.png')); ?>" alt="" class="app-modern-sidebar__brand-logo">
            <span class="app-modern-sidebar__brand-copy"><strong>Alis<span>CRM</span></strong><small>Proptech Suite</small></span>
        </a>
        <button type="button" class="app-modern-sidebar__icon-button app-modern-sidebar__collapse" data-modern-sidebar-collapse aria-label="Contraer menú lateral" aria-pressed="false">
            <i class="fas fa-compress-alt" aria-hidden="true"></i>
        </button>
        <button type="button" class="app-modern-sidebar__icon-button app-modern-sidebar__close" data-modern-sidebar-close aria-label="Cerrar menú lateral">
            <i class="fas fa-times" aria-hidden="true"></i>
        </button>
    </div>

    <div class="app-modern-sidebar__search-wrap">
        <label class="sr-only" for="modern-sidebar-search">Buscar una opción del menú</label>
        <i class="fas fa-search" aria-hidden="true"></i>
        <input id="modern-sidebar-search" type="search" class="app-modern-sidebar__search" data-modern-sidebar-search placeholder="Buscar acción o cliente…" autocomplete="off">
        <kbd aria-hidden="true">⌘K</kbd>
    </div>

    <nav class="app-modern-sidebar__nav" aria-label="Navegación principal" data-modern-sidebar-nav>
        <?php $__currentLoopData = $groups; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $group): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <section class="app-modern-sidebar__section" data-modern-menu-section>
                <h2 class="app-modern-sidebar__section-title"><?php echo e($group['label']); ?></h2>
                <ul class="app-modern-sidebar__list">
                    <?php $__currentLoopData = $group['items']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php if(isset($item['children'])): ?>
                            <?php $submenuId = 'modern-sidebar-submenu-' . $item['key']; ?>
                            <li class="app-modern-sidebar__item app-modern-sidebar__item--parent <?php echo e($item['active'] ? 'is-open' : ''); ?>" data-modern-menu-parent>
                                <button type="button" class="app-modern-sidebar__link app-modern-sidebar__submenu-toggle <?php echo e($item['active'] ? 'is-active' : ''); ?>" data-modern-submenu-button aria-controls="<?php echo e($submenuId); ?>" aria-expanded="<?php echo e($item['active'] ? 'true' : 'false'); ?>" data-search="<?php echo e(strtolower($item['label'] . ' ' . implode(' ', $item['terms']))); ?>" title="<?php echo e($item['label']); ?>">
                                    <i class="app-modern-sidebar__nav-icon <?php echo e($item['icon']); ?>" aria-hidden="true"></i>
                                    <span class="app-modern-sidebar__label"><?php echo e($item['label']); ?></span>
                                    <?php if($item['key'] === 'reportes'): ?>
                                        <span class="app-modern-sidebar__badge"><?php echo e($isAdmin ? '6' : '1'); ?></span>
                                    <?php endif; ?>
                                    <i class="fas fa-chevron-down app-modern-sidebar__chevron" aria-hidden="true"></i>
                                </button>
                                <ul id="<?php echo e($submenuId); ?>" class="app-modern-sidebar__submenu" data-modern-submenu>
                                    <?php $__currentLoopData = $item['children']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $child): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <li data-modern-menu-item>
                                            <a href="<?php echo e($child['url']); ?>" class="app-modern-sidebar__link app-modern-sidebar__sublink <?php echo e($child['active'] ? 'is-active' : ''); ?>" data-search="<?php echo e(strtolower($child['label'] . ' ' . implode(' ', $child['terms']))); ?>" title="<?php echo e($child['label']); ?>" <?php if($child['active']): ?> aria-current="page" <?php endif; ?>>
                                                <i class="app-modern-sidebar__nav-icon <?php echo e($child['icon']); ?>" aria-hidden="true"></i>
                                                <span class="app-modern-sidebar__label"><?php echo e($child['label']); ?></span>
                                            </a>
                                        </li>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </ul>
                            </li>
                        <?php else: ?>
                            <li data-modern-menu-item>
                                <a href="<?php echo e($item['url']); ?>" class="app-modern-sidebar__link <?php echo e($item['active'] ? 'is-active' : ''); ?>" data-search="<?php echo e(strtolower($item['label'] . ' ' . implode(' ', $item['terms']))); ?>" title="<?php echo e($item['label']); ?>" <?php if($item['target']): ?> target="<?php echo e($item['target']); ?>" rel="noopener noreferrer" <?php endif; ?> <?php if($item['active']): ?> aria-current="page" <?php endif; ?>>
                                    <i class="app-modern-sidebar__nav-icon <?php echo e($item['icon']); ?>" aria-hidden="true"></i>
                                    <span class="app-modern-sidebar__label"><?php echo e($item['label']); ?></span>
                                </a>
                            </li>
                        <?php endif; ?>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </ul>
            </section>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        <p class="app-modern-sidebar__empty" data-modern-sidebar-empty hidden>No se encontraron opciones.</p>
    </nav>

    <div class="app-modern-sidebar__profile">
        <div class="app-modern-sidebar__profile-main">
            <img src="<?php echo e($userPhotoUrl); ?>" class="app-modern-sidebar__avatar" alt="<?php echo e($authUser->name); ?>">
            <div class="app-modern-sidebar__profile-copy">
                <span><?php echo e($authUser->name); ?></span>
                <small><?php echo e($isAdmin ? 'Administrador' : 'Asesor'); ?></small>
            </div>
        </div>
        <div class="app-modern-sidebar__profile-actions">
            <a href="<?php echo e(url('/')); ?>" target="_blank" rel="noopener noreferrer" class="app-modern-sidebar__profile-link"><i class="fas fa-external-link-alt" aria-hidden="true"></i><span>Ver sitio web</span></a>
            <form action="<?php echo e(route('logout')); ?>" method="POST">
                <?php echo csrf_field(); ?>
                <button type="submit" class="app-modern-sidebar__logout" aria-label="Cerrar sesión" title="Cerrar sesión"><i class="fas fa-sign-out-alt" aria-hidden="true"></i></button>
            </form>
        </div>
    </div>
</aside>
<div class="app-modern-sidebar__backdrop" data-modern-sidebar-backdrop aria-hidden="true"></div>
<?php /**PATH D:\xampp3\htdocs\realestate_dev\resources\views/components/navigation/modern-sidebar.blade.php ENDPATH**/ ?>