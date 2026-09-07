

<?php $__env->startSection('seo_title', 'Nuestro Equipo — ' . ($inmo->titulo ?? 'Portal Inmobiliario')); ?>
<?php $__env->startSection('seo_description',
    'Conoce a nuestros agentes inmobiliarios expertos. Estamos listos para ayudarte en cada
    paso.'); ?>

<?php $__env->startSection('extra_styles'); ?>
    <style>
        .page-hero {
            background: linear-gradient(135deg, var(--clr-dark) 0%, var(--clr-dark-2) 100%);
            padding: 3rem 0 2.5rem;
        }

        .page-hero .page-hero-title {
            font-family: var(--ff-head);
            font-size: clamp(1.8rem, 4vw, 2.4rem);
            color: var(--clr-white);
            font-weight: 700;
            margin-bottom: .5rem;
        }

        .page-hero .breadcrumb {
            background: transparent;
            padding: 0;
            margin: 0;
            font-size: .85rem;
        }

        .page-hero .breadcrumb-item a {
            color: var(--clr-accent);
            text-decoration: none;
        }

        .page-hero .breadcrumb-item.active {
            color: rgba(255, 255, 255, .7);
        }

        .page-hero .breadcrumb-item+.breadcrumb-item::before {
            color: rgba(255, 255, 255, .4);
        }

        .team-section {
            padding: 4rem 0;
            background: var(--clr-bg);
        }

        .agent-card {
            background: var(--clr-white);
            border-radius: var(--radius);
            overflow: hidden;
            box-shadow: var(--shadow-sm);
            border: 1px solid var(--clr-border);
            transition: var(--transition);
            text-align: center;
        }

        .agent-card:hover {
            box-shadow: var(--shadow-lg);
            transform: translateY(-4px);
        }

        .agent-img-wrap {
            height: 280px;
            overflow: hidden;
        }

        .agent-img-wrap img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform .4s ease;
        }

        .agent-card:hover .agent-img-wrap img {
            transform: scale(1.05);
        }

        .agent-body {
            padding: 1.5rem 1.25rem;
        }

        .agent-name {
            font-family: var(--ff-head);
            font-size: 1.1rem;
            font-weight: 700;
            color: var(--clr-dark);
            margin-bottom: .25rem;
        }

        .agent-role {
            font-size: .8rem;
            color: var(--clr-accent);
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: .5px;
            margin-bottom: .75rem;
        }

        .agent-phone {
            font-size: .875rem;
            color: var(--clr-gray);
            margin-bottom: 1rem;
        }

        .agent-phone i {
            color: var(--clr-accent);
            margin-right: .35rem;
        }

        .btn-ver-props {
            display: inline-flex;
            align-items: center;
            gap: .4rem;
            background: var(--clr-dark);
            color: var(--clr-white);
            font-size: .8rem;
            font-weight: 600;
            padding: .5rem 1.25rem;
            border-radius: var(--radius-sm);
            text-decoration: none;
            transition: var(--transition);
        }

        .btn-ver-props:hover {
            background: var(--clr-accent);
            color: var(--clr-dark);
        }

        .pagination .page-link {
            color: var(--clr-dark);
            border-radius: var(--radius-sm) !important;
            margin: 0 2px;
            border: 1.5px solid var(--clr-border);
            font-size: .85rem;
        }

        .pagination .page-item.active .page-link {
            background: var(--clr-accent);
            border-color: var(--clr-accent);
            color: var(--clr-dark);
            font-weight: 600;
        }

        .pagination .page-link:hover {
            background: var(--clr-bg);
            color: var(--clr-accent);
        }

        .empty-state {
            text-align: center;
            padding: 4rem 2rem;
            color: var(--clr-gray);
        }

        .empty-state i {
            font-size: 3rem;
            margin-bottom: 1rem;
            color: var(--clr-accent);
            display: block;
        }
    </style>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>

    <section class="page-hero" aria-label="Equipo">
        <div class="container">
            <h1 class="page-hero-title">Nuestro Equipo de Agentes</h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?php echo e(route('home')); ?>">Inicio</a></li>
                    <li class="breadcrumb-item active">Agentes</li>
                </ol>
            </nav>
        </div>
    </section>

    <?php
        $agentPlaceholder = 'https://dummyimage.com/640x640/edf2f7/6b7280&text=Sin+foto';
        $resolveAgentPhoto = function ($foto) {
            if (!$foto) {
                return 'https://dummyimage.com/640x640/edf2f7/6b7280&text=Sin+foto';
            }

            if (\Illuminate\Support\Str::startsWith($foto, ['http://', 'https://', '//', 'data:'])) {
                return $foto;
            }

            if (\Illuminate\Support\Str::startsWith($foto, ['/assets/', 'assets/', '/img/', 'img/'])) {
                return asset(ltrim($foto, '/'));
            }

            return asset('assets/' . ltrim($foto, '/'));
        };
    ?>

    <section class="team-section">
        <div class="container">
            <div class="text-center mb-5">
                <span class="section-badge">EQUIPO</span>
                <h2 class="section-title">Conoce a nuestros expertos</h2>
                <p class="section-subtitle">Profesionales comprometidos con ayudarte a encontrar la propiedad perfecta.</p>
            </div>
            <div class="row g-4">
                <?php $__empty_1 = true; $__currentLoopData = $usuarios; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $usuario): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <div class="col-lg-3 col-md-4 col-sm-6">
                        <article class="agent-card h-100">
                            <div class="agent-img-wrap">
                                <a href="<?php echo e(route('propiedadesPorAgente', $usuario->id)); ?>"
                                    aria-label="<?php echo e($usuario->name); ?>">
                                    <img loading="lazy" src="<?php echo e($resolveAgentPhoto($usuario->foto ?? null)); ?>"
                                        onerror="this.onerror=null;this.src='<?php echo e($agentPlaceholder); ?>';"
                                        alt="Agente <?php echo e($usuario->name); ?>" title="<?php echo e($usuario->name); ?>">
                                </a>
                            </div>
                            <div class="agent-body">
                                <h3 class="agent-name"><?php echo e($usuario->name); ?></h3>
                                <?php if($usuario->titulo): ?>
                                    <p class="agent-role"><?php echo e($usuario->titulo); ?></p>
                                <?php endif; ?>
                                <?php if($usuario->telefono): ?>
                                    <p class="agent-phone"><i class="fas fa-phone"></i><?php echo e($usuario->telefono); ?></p>
                                <?php endif; ?>
                                <a href="<?php echo e(route('propiedadesPorAgente', $usuario->id)); ?>" class="btn-ver-props">
                                    <i class="fas fa-house"></i> Ver propiedades
                                </a>
                            </div>
                        </article>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <div class="col-12">
                        <div class="empty-state">
                            <i class="fas fa-users-slash"></i>
                            <p>No hay agentes disponibles en este momento.</p>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
            <?php if($usuarios->hasPages()): ?>
                <div class="d-flex justify-content-center mt-5">
                    <?php echo e($usuarios->links('pagination::bootstrap-4')); ?>

                </div>
            <?php endif; ?>
        </div>
    </section>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layout.layout-landing', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xampp3\htdocs\realestate_dev\resources\views/frontend/equipo.blade.php ENDPATH**/ ?>