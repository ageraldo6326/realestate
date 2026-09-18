<?php $__env->startSection('content'); ?>

    <h1>Probando Livewire</h1>

    <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('admin.posts')->html();
} elseif ($_instance->childHasBeenRendered('9uNfX9t')) {
    $componentId = $_instance->getRenderedChildComponentId('9uNfX9t');
    $componentTag = $_instance->getRenderedChildComponentTagName('9uNfX9t');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('9uNfX9t');
} else {
    $response = \Livewire\Livewire::mount('admin.posts');
    $html = $response->html();
    $_instance->logRenderedChild('9uNfX9t', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout.appadmin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xampp3\htdocs\realestate_dev\resources\views\welcome.blade.php ENDPATH**/ ?>