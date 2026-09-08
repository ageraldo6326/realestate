

<?php $__env->startSection('title', 'Crear Tipo de Propiedad'); ?>

<?php $__env->startSection('breadcrumb'); ?>
    <li class="breadcrumb-item">Catálogos</li>
    <li class="breadcrumb-item"><a href="<?php echo e(route('tipopropiedades.index')); ?>">Tipos de propiedad</a></li>
    <li class="breadcrumb-item active">Crear</li>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('page_title', 'Crear Tipo de Propiedad'); ?>

<?php $__env->startSection('content'); ?>
    <?php echo $__env->make('admin.tipopropiedades._form', [
        'mode' => 'create',
        'tipopropiedad' => null,
        'action' => route('tipopropiedades.store'),
    ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layoutadmin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xampp3\htdocs\realestate_dev\resources\views\admin\tipopropiedades\create.blade.php ENDPATH**/ ?>