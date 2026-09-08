

<?php $__env->startSection('content'); ?>
    <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('contactos-todos')->html();
} elseif ($_instance->childHasBeenRendered('OVCI8Y2')) {
    $componentId = $_instance->getRenderedChildComponentId('OVCI8Y2');
    $componentTag = $_instance->getRenderedChildComponentTagName('OVCI8Y2');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('OVCI8Y2');
} else {
    $response = \Livewire\Livewire::mount('contactos-todos');
    $html = $response->html();
    $_instance->logRenderedChild('OVCI8Y2', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>;
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layoutadmin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xampp3\htdocs\realestate_dev\resources\views\admin\clientes\indexTodos.blade.php ENDPATH**/ ?>