

<?php $__env->startSection('content'); ?>
    <div class="container-fluid report-page">
        <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('clientespotencialescerrados')->html();
} elseif ($_instance->childHasBeenRendered('Vptwj1K')) {
    $componentId = $_instance->getRenderedChildComponentId('Vptwj1K');
    $componentTag = $_instance->getRenderedChildComponentTagName('Vptwj1K');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('Vptwj1K');
} else {
    $response = \Livewire\Livewire::mount('clientespotencialescerrados');
    $html = $response->html();
    $_instance->logRenderedChild('Vptwj1K', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layoutadmin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xampp3\htdocs\realestate_dev\resources\views\estadisticas\clientespotencialescerrados.blade.php ENDPATH**/ ?>