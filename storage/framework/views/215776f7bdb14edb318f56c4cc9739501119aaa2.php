

<?php $__env->startSection('seo_title', 'Propiedades de Tipo ' . ($tipo->tipo ?? '') . ' — ' . ($inmo->titulo ?? 'Portal Inmobiliario')); ?>
<?php $__env->startSection('seo_description', 'Explora propiedades de tipo ' . ($tipo->tipo ?? '') . ' disponibles en venta y alquiler.'); ?>

<?php $__env->startSection('extra_styles'); ?>
<style>
    .page-hero { background: linear-gradient(135deg, var(--clr-dark) 0%, var(--clr-dark-2) 100%); padding: 3rem 0 2.5rem; }
    .page-hero .page-hero-title { font-family: var(--ff-head); font-size: clamp(1.8rem,4vw,2.4rem); color: var(--clr-white); font-weight: 700; margin-bottom: .5rem; }
    .page-hero .breadcrumb { background: transparent; padding: 0; margin: 0; font-size: .85rem; }
    .page-hero .breadcrumb-item a { color: var(--clr-accent); text-decoration: none; }
    .page-hero .breadcrumb-item.active { color: rgba(255,255,255,.7); }
    .page-hero .breadcrumb-item + .breadcrumb-item::before { color: rgba(255,255,255,.4); }
    .listings-section { padding: 3rem 0 4rem; background: var(--clr-bg); }
    .empty-state { text-align: center; padding: 4rem 2rem; color: var(--clr-gray); }
    .empty-state i { font-size: 3rem; margin-bottom: 1rem; color: var(--clr-accent); display: block; }
</style>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>

<section class="page-hero" aria-label="Propiedades por Tipo">
    <div class="container">
        <h1 class="page-hero-title"><?php echo e($tipo->tipo ?? 'Propiedades'); ?></h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?php echo e(route('home')); ?>">Inicio</a></li>
                <li class="breadcrumb-item"><a href="<?php echo e(route('listapropiedades')); ?>">Propiedades</a></li>
                <li class="breadcrumb-item active"><?php echo e($tipo->tipo ?? ''); ?></li>
            </ol>
        </nav>
    </div>
</section>

<section class="listings-section">
    <div class="container">
        <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('buscar-propiedades-por-tipos', ['tipo_id' => $tipo_id, 'tipo' => $tipo])->html();
} elseif ($_instance->childHasBeenRendered('Yec5P31')) {
    $componentId = $_instance->getRenderedChildComponentId('Yec5P31');
    $componentTag = $_instance->getRenderedChildComponentTagName('Yec5P31');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('Yec5P31');
} else {
    $response = \Livewire\Livewire::mount('buscar-propiedades-por-tipos', ['tipo_id' => $tipo_id, 'tipo' => $tipo]);
    $html = $response->html();
    $_instance->logRenderedChild('Yec5P31', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
    </div>
</section>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout.layout-landing', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xampp3\htdocs\realestate_dev\resources\views\frontend\PropiedadesPorTipo.blade.php ENDPATH**/ ?>