

<?php $__env->startSection('content'); ?>
    <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('clientes-asesor-consulta')->html();
} elseif ($_instance->childHasBeenRendered('fGETl8X')) {
    $componentId = $_instance->getRenderedChildComponentId('fGETl8X');
    $componentTag = $_instance->getRenderedChildComponentTagName('fGETl8X');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('fGETl8X');
} else {
    $response = \Livewire\Livewire::mount('clientes-asesor-consulta');
    $html = $response->html();
    $_instance->logRenderedChild('fGETl8X', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layoutadmin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xampp3\htdocs\realestate_dev\resources\views\consultas\consultaClientesPorAsesor.blade.php ENDPATH**/ ?>