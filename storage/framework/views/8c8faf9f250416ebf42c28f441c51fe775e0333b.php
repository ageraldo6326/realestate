<?php $__env->startSection('title', 'Aprobar propiedades'); ?>

<?php $__env->startSection('breadcrumb'); ?>
    <li class="breadcrumb-item active">Aprobar propiedades</li>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('page_title', 'Aprobar propiedades'); ?>

<?php $__env->startSection('content'); ?>
    <div class="container-fluid py-4">
        <section class="approval-page-hero mb-4">
            <div>
                <h1>Revisión de propiedades</h1>
                <p>Consulta la información de cada inmueble y actualiza su aprobación sin salir del listado.</p>
            </div>
            <a href="<?php echo e(route('propiedades.create')); ?>" class="btn btn-light">
                <i class="fas fa-plus mr-1" aria-hidden="true"></i> Crear propiedad
            </a>
        </section>

        <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('mostrar-propiedades-pendientes-por-aprobar')->html();
} elseif ($_instance->childHasBeenRendered('PyBkDwL')) {
    $componentId = $_instance->getRenderedChildComponentId('PyBkDwL');
    $componentTag = $_instance->getRenderedChildComponentTagName('PyBkDwL');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('PyBkDwL');
} else {
    $response = \Livewire\Livewire::mount('mostrar-propiedades-pendientes-por-aprobar');
    $html = $response->html();
    $_instance->logRenderedChild('PyBkDwL', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
    </div>

    <style>
        .approval-page-hero { display: flex; align-items: center; justify-content: space-between; gap: 1rem; padding: 1.5rem; border-radius: .9rem; color: #fff; background: linear-gradient(120deg, #12343b, #1c4f59); }
        .approval-page-hero h1 { margin: 0; font-size: clamp(1.45rem, 2.6vw, 2rem); font-weight: 700; }
        .approval-page-hero p { max-width: 44rem; margin: .35rem 0 0; color: rgba(255,255,255,.84); }
        .approval-page-hero .btn { min-height: 44px; white-space: nowrap; color: #17343a; font-weight: 700; }
        @media (max-width: 575.98px) { .approval-page-hero { display: grid; padding: 1.2rem; } .approval-page-hero .btn { width: 100%; } }
    </style>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layoutadmin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xampp3\htdocs\realestate_dev\resources\views\admin\propiedades\pendientes.blade.php ENDPATH**/ ?>