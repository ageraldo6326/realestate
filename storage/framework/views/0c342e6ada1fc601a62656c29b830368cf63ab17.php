

<?php $__env->startSection('title', 'Editar testimonio'); ?>

<?php $__env->startSection('breadcrumb'); ?>
    <li class="breadcrumb-item">Contenido</li>
    <li class="breadcrumb-item"><a href="<?php echo e(route('testimonios.index')); ?>">Testimonios</a></li>
    <li class="breadcrumb-item active">Editar</li>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('page_title', 'Editar testimonio'); ?>

<?php $__env->startSection('content'); ?>
    <?php echo $__env->make('admin.testimonios._form', [
        'mode' => 'edit',
        'action' => route('testimonios.update', $testimonio),
        'testimonio' => $testimonio,
    ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('admin.layoutadmin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xampp3\htdocs\realestate_dev\resources\views\admin\testimonios\edit.blade.php ENDPATH**/ ?>