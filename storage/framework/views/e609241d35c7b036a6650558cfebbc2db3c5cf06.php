<?php $__env->startSection('content'); ?>

    <h1>Probando Livewire</h1>

    <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('admin.posts')->html();
} elseif ($_instance->childHasBeenRendered('CGiv7l0')) {
    $componentId = $_instance->getRenderedChildComponentId('CGiv7l0');
    $componentTag = $_instance->getRenderedChildComponentTagName('CGiv7l0');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('CGiv7l0');
} else {
    $response = \Livewire\Livewire::mount('admin.posts');
    $html = $response->html();
    $_instance->logRenderedChild('CGiv7l0', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout.appadmin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xampp3\htdocs\realestate_dev\resources\views\welcome.blade.php ENDPATH**/ ?>