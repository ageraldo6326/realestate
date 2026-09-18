<?php $__env->startSection('title', 'Clientes por asesor'); ?>

<?php $__env->startSection('breadcrumb'); ?>
    <li class="breadcrumb-item active">Clientes por asesor</li>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('page_title', 'Clientes por asesor'); ?>

<?php $__env->startSection('content'); ?>
    <div class="container-fluid py-3 py-md-4">
        <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('clientes-asesor-consulta')->html();
} elseif ($_instance->childHasBeenRendered('Vc3fdVs')) {
    $componentId = $_instance->getRenderedChildComponentId('Vc3fdVs');
    $componentTag = $_instance->getRenderedChildComponentTagName('Vc3fdVs');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('Vc3fdVs');
} else {
    $response = \Livewire\Livewire::mount('clientes-asesor-consulta');
    $html = $response->html();
    $_instance->logRenderedChild('Vc3fdVs', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layoutadmin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xampp3\htdocs\realestate_dev\resources\views\consultas\consultaClientesPorAsesor.blade.php ENDPATH**/ ?>