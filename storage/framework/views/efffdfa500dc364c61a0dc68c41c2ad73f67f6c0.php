

<?php $__env->startSection('title', 'Editar usuario'); ?>

<?php $__env->startSection('breadcrumb'); ?>
    <li class="breadcrumb-item"><a href="<?php echo e(route('usuarios.index')); ?>">Usuarios</a></li>
    <li class="breadcrumb-item active">Editar</li>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('page_title', 'Editar usuario'); ?>

<?php $__env->startSection('content'); ?>
    <?php
        $isProtectedSuperadmin = $usuario->isConfiguredSuperadmin() && !\App\Models\User::superadminMutationsAllowed();
    ?>

    <?php echo $__env->make('admin.usuarios._form', [
        'mode' => 'edit',
        'usuario' => $usuario,
        'isProtectedSuperadmin' => $isProtectedSuperadmin,
        'action' => route('usuarios.update', $usuario->id),
    ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layoutadmin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xampp3\htdocs\realestate_dev\resources\views\admin\usuarios\edit.blade.php ENDPATH**/ ?>