

<?php $__env->startSection('content'); ?>
    <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('clientes-asesor-consulta')->html();
} elseif ($_instance->childHasBeenRendered('t78anOF')) {
    $componentId = $_instance->getRenderedChildComponentId('t78anOF');
    $componentTag = $_instance->getRenderedChildComponentTagName('t78anOF');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('t78anOF');
} else {
    $response = \Livewire\Livewire::mount('clientes-asesor-consulta');
    $html = $response->html();
    $_instance->logRenderedChild('t78anOF', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layoutadmin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xampp3\htdocs\realestate_dev\resources\views/consultas/consultaClientesPorAsesor.blade.php ENDPATH**/ ?>