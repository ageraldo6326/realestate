

<?php $__env->startSection('seo_title', 'Propiedades en Venta y Alquiler — ' . ($inmo->titulo ?? 'Portal Inmobiliario')); ?>
<?php $__env->startSection('seo_description', 'Explora nuestra lista completa de propiedades en venta y alquiler. Filtra por zona, tipo y
    precio.'); ?>

<?php $__env->startSection('extra_styles'); ?>
    <style>
        .page-hero {
            background: linear-gradient(135deg, var(--clr-dark) 0%, var(--clr-dark-2) 100%);
            padding: 3rem 0 2.5rem;
            margin-bottom: 0;
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

        .listings-section {
            padding: 3rem 0 4rem;
            background: var(--clr-bg);
        }

        /* Filter bar */
        .filter-bar {
            background: var(--clr-white);
            border-radius: var(--radius);
            padding: 1.25rem 1.5rem;
            box-shadow: var(--shadow-sm);
            border: 1px solid var(--clr-border);
            margin-bottom: 2rem;
        }

        .filter-bar .form-label {
            font-size: .7rem;
            font-weight: 700;
            letter-spacing: .5px;
            text-transform: uppercase;
            color: var(--clr-gray);
            margin-bottom: .3rem;
        }

        .filter-bar .form-select,
        .filter-bar .form-control {
            border: 1.5px solid var(--clr-border);
            border-radius: var(--radius-sm);
            font-size: .875rem;
            padding: .55rem .9rem;
            color: var(--clr-dark);
        }

        .filter-bar .form-select:focus,
        .filter-bar .form-control:focus {
            border-color: var(--clr-accent);
            box-shadow: 0 0 0 3px rgba(201, 168, 76, .15);
            outline: none;
        }

        /* Pagination override */
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

        /* Empty state */
        .empty-state {
            text-align: center;
            padding: 4rem 2rem;
            color: var(--clr-gray);
        }

        .empty-state i {
            font-size: 3rem;
            margin-bottom: 1rem;
            color: var(--clr-accent);
        }

        .empty-state p {
            font-size: 1rem;
        }
    </style>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>

    <!-- PAGE HERO -->
    <section class="page-hero" aria-label="Propiedades">
        <div class="container">
            <h1 class="page-hero-title">Propiedades en Venta y Alquiler</h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?php echo e(route('home')); ?>">Inicio</a></li>
                    <li class="breadcrumb-item active">Propiedades</li>
                </ol>
            </nav>
        </div>
    </section>

    <!-- LISTINGS -->
    <section class="listings-section">
        <div class="container">
            <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('buscar-propiedades-propiedades')->html();
} elseif ($_instance->childHasBeenRendered('GwUtTuT')) {
    $componentId = $_instance->getRenderedChildComponentId('GwUtTuT');
    $componentTag = $_instance->getRenderedChildComponentTagName('GwUtTuT');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('GwUtTuT');
} else {
    $response = \Livewire\Livewire::mount('buscar-propiedades-propiedades');
    $html = $response->html();
    $_instance->logRenderedChild('GwUtTuT', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
        </div>
    </section>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layout.layout-landing', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xampp3\htdocs\realestate_dev\resources\views/frontend/propiedades.blade.php ENDPATH**/ ?>