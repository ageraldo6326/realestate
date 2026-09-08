

<?php $__env->startSection('content'); ?>


<?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('mostrar-propiedades-pendientes-por-aprobar')->html();
} elseif ($_instance->childHasBeenRendered('0mMwGvJ')) {
    $componentId = $_instance->getRenderedChildComponentId('0mMwGvJ');
    $componentTag = $_instance->getRenderedChildComponentTagName('0mMwGvJ');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('0mMwGvJ');
} else {
    $response = \Livewire\Livewire::mount('mostrar-propiedades-pendientes-por-aprobar');
    $html = $response->html();
    $_instance->logRenderedChild('0mMwGvJ', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>


<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layoutadmin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xampp3\htdocs\realestate_dev\resources\views\admin\propiedades\pendientes.blade.php ENDPATH**/ ?>