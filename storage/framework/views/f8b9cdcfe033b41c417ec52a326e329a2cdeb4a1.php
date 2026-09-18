<?php $__env->startSection('title', 'Todas las propiedades'); ?>

<?php $__env->startSection('breadcrumb'); ?>
    <li class="breadcrumb-item active">Todas las propiedades</li>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('page_title', 'Todas las propiedades'); ?>

<?php $__env->startSection('content'); ?>
    <div class="container-fluid py-3 py-md-4">
        <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('mostrar-propiedades')->html();
} elseif ($_instance->childHasBeenRendered('WsL2Hai')) {
    $componentId = $_instance->getRenderedChildComponentId('WsL2Hai');
    $componentTag = $_instance->getRenderedChildComponentTagName('WsL2Hai');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('WsL2Hai');
} else {
    $response = \Livewire\Livewire::mount('mostrar-propiedades');
    $html = $response->html();
    $_instance->logRenderedChild('WsL2Hai', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
    </div>


<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layoutadmin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xampp3\htdocs\realestate_dev\resources\views/admin/propiedades/consultarpropiedades.blade.php ENDPATH**/ ?>