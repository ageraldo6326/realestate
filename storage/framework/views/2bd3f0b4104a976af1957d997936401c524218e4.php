

<?php $__env->startSection('content'); ?>


<?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('mostrar-propiedades')->html();
} elseif ($_instance->childHasBeenRendered('ZGayPq0')) {
    $componentId = $_instance->getRenderedChildComponentId('ZGayPq0');
    $componentTag = $_instance->getRenderedChildComponentTagName('ZGayPq0');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('ZGayPq0');
} else {
    $response = \Livewire\Livewire::mount('mostrar-propiedades');
    $html = $response->html();
    $_instance->logRenderedChild('ZGayPq0', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>


<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layoutadmin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xampp3\htdocs\realestate_dev\resources\views\admin\propiedades\consultarpropiedades.blade.php ENDPATH**/ ?>