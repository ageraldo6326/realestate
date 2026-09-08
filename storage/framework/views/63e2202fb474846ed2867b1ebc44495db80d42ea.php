

<?php $__env->startSection('title', 'Editar Tipo de Tarea'); ?>

<?php $__env->startSection('breadcrumb'); ?>
    <li class="breadcrumb-item">Catalogos</li>
    <li class="breadcrumb-item"><a href="<?php echo e(route('tipostareas.index')); ?>">Tipos de tarea</a></li>
    <li class="breadcrumb-item active">Editar</li>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('page_title', 'Editar Tipo de Tarea'); ?>

<?php $__env->startSection('content'); ?>
    <?php echo $__env->make('admin.tipotarea._form', [
        'mode' => 'edit',
        'tipotarea' => $tipotarea,
        'action' => route('tipostareas.update', $tipotarea->id),
    ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layoutadmin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xampp3\htdocs\realestate_dev\resources\views\admin\tipotarea\edit.blade.php ENDPATH**/ ?>