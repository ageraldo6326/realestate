

<?php $__env->startSection('title', 'Editar portada'); ?>

<?php $__env->startSection('breadcrumb'); ?>
    <li class="breadcrumb-item">Contenido</li>
    <li class="breadcrumb-item"><a href="<?php echo e(route('portadas.index')); ?>">Portadas</a></li>
    <li class="breadcrumb-item active">Editar</li>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('page_title', 'Editar portada'); ?>

<?php $__env->startSection('content'); ?>
    <?php echo $__env->make('admin.portadas._form', [
        'mode' => 'edit',
        'action' => route('portadas.update', $portada),
        'portada' => $portada,
    ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layoutadmin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xampp3\htdocs\realestate_dev\resources\views\admin\portadas\edit.blade.php ENDPATH**/ ?>