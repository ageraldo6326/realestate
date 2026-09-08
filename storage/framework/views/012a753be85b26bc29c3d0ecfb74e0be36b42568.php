

<?php $__env->startSection('seo_title', 'Propiedades del Agente — ' . ($inmo->titulo ?? 'Portal Inmobiliario')); ?>
<?php $__env->startSection('seo_description', 'Explora el portafolio de propiedades de nuestros agentes especializados.'); ?>

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
    .pagination .page-link { color: var(--clr-dark); border-radius: var(--radius-sm)!important; margin: 0 2px; border: 1.5px solid var(--clr-border); font-size: .85rem; }
    .pagination .page-item.active .page-link { background: var(--clr-accent); border-color: var(--clr-accent); color: var(--clr-dark); font-weight: 600; }
</style>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>

<section class="page-hero" aria-label="Propiedades por Agente">
    <div class="container">
        <h1 class="page-hero-title">Propiedades del Agente</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?php echo e(route('home')); ?>">Inicio</a></li>
                <li class="breadcrumb-item"><a href="<?php echo e(route('equipo')); ?>">Agentes</a></li>
                <li class="breadcrumb-item active">Propiedades</li>
            </ol>
        </nav>
    </div>
</section>

<section class="listings-section">
    <div class="container">
        <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('propiedades-por-agentes', ['id_agente' => $id_agente])->html();
} elseif ($_instance->childHasBeenRendered('I7YMQZ9')) {
    $componentId = $_instance->getRenderedChildComponentId('I7YMQZ9');
    $componentTag = $_instance->getRenderedChildComponentTagName('I7YMQZ9');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('I7YMQZ9');
} else {
    $response = \Livewire\Livewire::mount('propiedades-por-agentes', ['id_agente' => $id_agente]);
    $html = $response->html();
    $_instance->logRenderedChild('I7YMQZ9', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
    </div>
</section>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout.layout-landing', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xampp3\htdocs\realestate_dev\resources\views\frontend\propiedadesPorAgentes.blade.php ENDPATH**/ ?>