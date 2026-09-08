

<?php $__env->startSection('content'); ?>
    <div class="container-fluid report-page">
        <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('clientespotenciales')->html();
} elseif ($_instance->childHasBeenRendered('N5FyA7q')) {
    $componentId = $_instance->getRenderedChildComponentId('N5FyA7q');
    $componentTag = $_instance->getRenderedChildComponentTagName('N5FyA7q');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('N5FyA7q');
} else {
    $response = \Livewire\Livewire::mount('clientespotenciales');
    $html = $response->html();
    $_instance->logRenderedChild('N5FyA7q', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layoutadmin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xampp3\htdocs\realestate_dev\resources\views\estadisticas\clientespotenciales.blade.php ENDPATH**/ ?>