

<?php $__env->startSection('title', 'Editar Disponible Para'); ?>

<?php $__env->startSection('breadcrumb'); ?>
    <li class="breadcrumb-item">Catalogos</li>
    <li class="breadcrumb-item"><a href="<?php echo e(route('disponiblepara.index')); ?>">Disponible para</a></li>
    <li class="breadcrumb-item active">Editar</li>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('page_title', 'Editar Disponible Para'); ?>

<?php $__env->startSection('content'); ?>
    <?php echo $__env->make('admin.disponiblepara._form', [
        'mode' => 'edit',
        'disponiblepara' => $disponiblepara,
        'action' => route('disponiblepara.update', $disponiblepara->id),
    ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('admin.layoutadmin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xampp3\htdocs\realestate_dev\resources\views\admin\disponiblepara\edit.blade.php ENDPATH**/ ?>