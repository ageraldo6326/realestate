

<?php $__env->startSection('content'); ?>
    <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('editar-venta',['Id' => $id])->html();
} elseif ($_instance->childHasBeenRendered('WwKEgNl')) {
    $componentId = $_instance->getRenderedChildComponentId('WwKEgNl');
    $componentTag = $_instance->getRenderedChildComponentTagName('WwKEgNl');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('WwKEgNl');
} else {
    $response = \Livewire\Livewire::mount('editar-venta',['Id' => $id]);
    $html = $response->html();
    $_instance->logRenderedChild('WwKEgNl', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layoutadmin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xampp3\htdocs\realestate_dev\resources\views\admin\ventas\edit.blade.php ENDPATH**/ ?>