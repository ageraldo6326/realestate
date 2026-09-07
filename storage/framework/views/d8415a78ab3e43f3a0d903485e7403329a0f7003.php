

<?php $__env->startSection('content'); ?>
    <div class="container-fluid report-page">
        <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('clientespotencialescerrados')->html();
} elseif ($_instance->childHasBeenRendered('MXvOTz7')) {
    $componentId = $_instance->getRenderedChildComponentId('MXvOTz7');
    $componentTag = $_instance->getRenderedChildComponentTagName('MXvOTz7');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('MXvOTz7');
} else {
    $response = \Livewire\Livewire::mount('clientespotencialescerrados');
    $html = $response->html();
    $_instance->logRenderedChild('MXvOTz7', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layoutadmin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xampp3\htdocs\realestate_dev\resources\views/estadisticas/clientespotencialescerrados.blade.php ENDPATH**/ ?>