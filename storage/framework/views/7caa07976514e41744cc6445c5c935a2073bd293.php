

<?php $__env->startSection('content'); ?>
    <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('editar-venta',['Id' => $id])->html();
} elseif ($_instance->childHasBeenRendered('HRBAds6')) {
    $componentId = $_instance->getRenderedChildComponentId('HRBAds6');
    $componentTag = $_instance->getRenderedChildComponentTagName('HRBAds6');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('HRBAds6');
} else {
    $response = \Livewire\Livewire::mount('editar-venta',['Id' => $id]);
    $html = $response->html();
    $_instance->logRenderedChild('HRBAds6', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layoutadmin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xampp3\htdocs\realestate_dev\resources\views\admin\ventas\edit.blade.php ENDPATH**/ ?>