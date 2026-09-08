

<?php $__env->startSection('title', 'Editar Zona'); ?>

<?php $__env->startSection('breadcrumb'); ?>
    <li class="breadcrumb-item">Catálogos</li>
    <li class="breadcrumb-item"><a href="<?php echo e(route('zonas.index')); ?>">Zonas</a></li>
    <li class="breadcrumb-item active">Editar</li>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('page_title', 'Editar Zona'); ?>

<?php $__env->startSection('content'); ?>
    <?php echo $__env->make('admin.zonas._form', [
        'mode' => 'edit',
        'zona' => $zona,
        'action' => route('zonas.update', $zona),
    ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('admin.layoutadmin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xampp3\htdocs\realestate_dev\resources\views\admin\zonas\edit.blade.php ENDPATH**/ ?>