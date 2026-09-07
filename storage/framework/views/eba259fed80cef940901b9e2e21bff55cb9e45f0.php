

<?php $__env->startSection('content'); ?>
    <div class="container-fluid report-page">
        <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('clientespotenciales')->html();
} elseif ($_instance->childHasBeenRendered('RwDo46N')) {
    $componentId = $_instance->getRenderedChildComponentId('RwDo46N');
    $componentTag = $_instance->getRenderedChildComponentTagName('RwDo46N');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('RwDo46N');
} else {
    $response = \Livewire\Livewire::mount('clientespotenciales');
    $html = $response->html();
    $_instance->logRenderedChild('RwDo46N', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layoutadmin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xampp3\htdocs\realestate_dev\resources\views/estadisticas/clientespotenciales.blade.php ENDPATH**/ ?>