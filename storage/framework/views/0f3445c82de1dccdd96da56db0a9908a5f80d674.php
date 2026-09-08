

<?php $__env->startSection('content'); ?>


<?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('mostrar-inventario')->html();
} elseif ($_instance->childHasBeenRendered('8FNo5EZ')) {
    $componentId = $_instance->getRenderedChildComponentId('8FNo5EZ');
    $componentTag = $_instance->getRenderedChildComponentTagName('8FNo5EZ');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('8FNo5EZ');
} else {
    $response = \Livewire\Livewire::mount('mostrar-inventario');
    $html = $response->html();
    $_instance->logRenderedChild('8FNo5EZ', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>


<?php $__env->stopSection(); ?>


<?php echo $__env->make('admin.layoutadmin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xampp3\htdocs\realestate_dev\resources\views\admin\propiedades\mostrarinventario.blade.php ENDPATH**/ ?>