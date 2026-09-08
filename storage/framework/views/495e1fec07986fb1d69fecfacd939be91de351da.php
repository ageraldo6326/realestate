

<?php $__env->startSection('title', 'Nuevo enfoque'); ?>

<?php $__env->startSection('breadcrumb'); ?>
    <li class="breadcrumb-item">Contenido</li>
    <li class="breadcrumb-item"><a href="<?php echo e(route('enfoques.index')); ?>">Enfoques</a></li>
    <li class="breadcrumb-item active">Crear</li>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('page_title', 'Nuevo enfoque'); ?>

<?php $__env->startSection('content'); ?>
    <?php echo $__env->make('admin.enfoques._form', [
        'mode' => 'create',
        'action' => route('enfoques.store'),
    ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layoutadmin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xampp3\htdocs\realestate_dev\resources\views\admin\enfoques\create.blade.php ENDPATH**/ ?>