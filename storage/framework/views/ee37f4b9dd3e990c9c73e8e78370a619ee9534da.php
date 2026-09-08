

<?php $__env->startSection('title', 'Rotar clave superadmin'); ?>

<?php $__env->startSection('breadcrumb'); ?>
    <li class="breadcrumb-item"><a href="<?php echo e(route('dashboard')); ?>">Dashboard</a></li>
    <li class="breadcrumb-item active">Seguridad</li>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('page_title', 'Rotacion obligatoria de clave'); ?>

<?php $__env->startSection('content'); ?>
    <div class="container-fluid px-3">
        <?php if(session('warning')): ?>
            <div class="alert alert-warning"><?php echo e(session('warning')); ?></div>
        <?php endif; ?>

        <div class="row justify-content-center">
            <div class="col-lg-6 col-xl-5">
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-white border-0 pb-0">
                        <h3 class="h5 mb-1">Cambia la clave inicial del superadmin</h3>
                        <p class="text-muted mb-0">Por seguridad, debes definir una clave nueva para continuar en el panel.
                        </p>
                    </div>
                    <div class="card-body">
                        <?php if($errors->any()): ?>
                            <div class="alert alert-danger">
                                <ul class="mb-0 pl-3">
                                    <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <li><?php echo e($error); ?></li>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </ul>
                            </div>
                        <?php endif; ?>

                        <form method="POST" action="<?php echo e(route('admin.superadmin.password.update')); ?>" autocomplete="off">
                            <?php echo csrf_field(); ?>

                            <div class="form-group">
                                <label for="new_password">Nueva clave</label>
                                <input id="new_password" type="password" name="new_password" class="form-control" required
                                    minlength="8" autofocus>
                            </div>

                            <div class="form-group">
                                <label for="new_password_confirmation">Confirmar nueva clave</label>
                                <input id="new_password_confirmation" type="password" name="new_password_confirmation"
                                    class="form-control" required minlength="8">
                            </div>

                            <button type="submit" class="btn btn-primary btn-block">
                                Actualizar clave y continuar
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layoutadmin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xampp3\htdocs\realestate_dev\resources\views\admin\security\rotate-superadmin-password.blade.php ENDPATH**/ ?>