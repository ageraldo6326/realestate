

<?php $__env->startSection('content'); ?>


<?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('mostrar-inventario')->html();
} elseif ($_instance->childHasBeenRendered('Fwmhbi3')) {
    $componentId = $_instance->getRenderedChildComponentId('Fwmhbi3');
    $componentTag = $_instance->getRenderedChildComponentTagName('Fwmhbi3');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('Fwmhbi3');
} else {
    $response = \Livewire\Livewire::mount('mostrar-inventario');
    $html = $response->html();
    $_instance->logRenderedChild('Fwmhbi3', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>


<?php $__env->stopSection(); ?>


<?php echo $__env->make('admin.layoutadmin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xampp3\htdocs\realestate_dev\resources\views\admin\propiedades\mostrarinventario.blade.php ENDPATH**/ ?>