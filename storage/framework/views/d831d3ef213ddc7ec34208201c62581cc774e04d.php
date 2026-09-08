

<?php $__env->startSection('title', 'Nuevo Tipo de Tarea'); ?>

<?php $__env->startSection('breadcrumb'); ?>
    <li class="breadcrumb-item">Catalogos</li>
    <li class="breadcrumb-item"><a href="<?php echo e(route('tipostareas.index')); ?>">Tipos de tarea</a></li>
    <li class="breadcrumb-item active">Nuevo</li>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('page_title', 'Nuevo Tipo de Tarea'); ?>

<?php $__env->startSection('content'); ?>
    <?php echo $__env->make('admin.tipotarea._form', [
        'mode' => 'create',
        'tipotarea' => null,
        'action' => route('tipostareas.store'),
    ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layoutadmin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xampp3\htdocs\realestate_dev\resources\views\admin\tipotarea\create.blade.php ENDPATH**/ ?>