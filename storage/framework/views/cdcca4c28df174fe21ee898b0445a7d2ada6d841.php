

<?php $__env->startSection('content'); ?>
    <div class="container-fluid report-page">
        <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('fuenteclientes')->html();
} elseif ($_instance->childHasBeenRendered('H5P2ocm')) {
    $componentId = $_instance->getRenderedChildComponentId('H5P2ocm');
    $componentTag = $_instance->getRenderedChildComponentTagName('H5P2ocm');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('H5P2ocm');
} else {
    $response = \Livewire\Livewire::mount('fuenteclientes');
    $html = $response->html();
    $_instance->logRenderedChild('H5P2ocm', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layoutadmin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xampp3\htdocs\realestate_dev\resources\views/estadisticas/fuenteclientes.blade.php ENDPATH**/ ?>