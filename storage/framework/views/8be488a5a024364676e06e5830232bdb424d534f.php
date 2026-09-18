

<?php $__env->startSection('content'); ?>
    <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('contactos-todos')->html();
} elseif ($_instance->childHasBeenRendered('f1Nnp0H')) {
    $componentId = $_instance->getRenderedChildComponentId('f1Nnp0H');
    $componentTag = $_instance->getRenderedChildComponentTagName('f1Nnp0H');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('f1Nnp0H');
} else {
    $response = \Livewire\Livewire::mount('contactos-todos');
    $html = $response->html();
    $_instance->logRenderedChild('f1Nnp0H', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>;
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layoutadmin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xampp3\htdocs\realestate_dev\resources\views\admin\clientes\indexTodos.blade.php ENDPATH**/ ?>