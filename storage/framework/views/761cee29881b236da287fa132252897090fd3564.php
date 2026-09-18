

<?php $__env->startSection('content'); ?>
    <div class="container-fluid report-page">
        <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('fuenteclientes')->html();
} elseif ($_instance->childHasBeenRendered('JwKkDuZ')) {
    $componentId = $_instance->getRenderedChildComponentId('JwKkDuZ');
    $componentTag = $_instance->getRenderedChildComponentTagName('JwKkDuZ');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('JwKkDuZ');
} else {
    $response = \Livewire\Livewire::mount('fuenteclientes');
    $html = $response->html();
    $_instance->logRenderedChild('JwKkDuZ', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layoutadmin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xampp3\htdocs\realestate_dev\resources\views\estadisticas\fuenteclientes.blade.php ENDPATH**/ ?>