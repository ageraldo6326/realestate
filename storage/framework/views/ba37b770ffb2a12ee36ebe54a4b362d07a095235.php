

<?php $__env->startSection('title', 'Crear usuario'); ?>

<?php $__env->startSection('breadcrumb'); ?>
    <li class="breadcrumb-item"><a href="<?php echo e(route('usuarios.index')); ?>">Usuarios</a></li>
    <li class="breadcrumb-item active">Crear</li>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('page_title', 'Crear usuario'); ?>

<?php $__env->startSection('content'); ?>
    <?php echo $__env->make('admin.usuarios._form', [
        'mode' => 'create',
        'action' => route('usuarios.store'),
    ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layoutadmin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xampp3\htdocs\realestate_dev\resources\views\admin\usuarios\create.blade.php ENDPATH**/ ?>