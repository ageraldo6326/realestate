

<?php $__env->startSection('title', 'Empresa'); ?>

<?php $__env->startSection('breadcrumb'); ?>
    <li class="breadcrumb-item">Configuración</li>
    <li class="breadcrumb-item active">Empresa</li>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('page_title', 'Empresa'); ?>

<?php $__env->startSection('content'); ?>
    <?php echo $__env->make('admin.empresa._form', [
        'mode' => 'create',
        'inmobiliaria' => null,
        'action' => route('inmobiliaria.store'),
    ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layoutadmin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xampp3\htdocs\realestate_dev\resources\views\admin\empresa\create.blade.php ENDPATH**/ ?>