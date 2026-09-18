<?php $__env->startSection('title', 'Todas las propiedades'); ?>

<?php $__env->startSection('breadcrumb'); ?>
    <li class="breadcrumb-item active">Todas las propiedades</li>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('page_title', 'Todas las propiedades'); ?>

<?php $__env->startSection('content'); ?>
    <div class="container-fluid py-3 py-md-4">
        <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('mostrar-propiedades')->html();
} elseif ($_instance->childHasBeenRendered('07E4sXy')) {
    $componentId = $_instance->getRenderedChildComponentId('07E4sXy');
    $componentTag = $_instance->getRenderedChildComponentTagName('07E4sXy');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('07E4sXy');
} else {
    $response = \Livewire\Livewire::mount('mostrar-propiedades');
    $html = $response->html();
    $_instance->logRenderedChild('07E4sXy', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
    </div>


<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layoutadmin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xampp3\htdocs\realestate_dev\resources\views\admin\propiedades\consultarpropiedades.blade.php ENDPATH**/ ?>