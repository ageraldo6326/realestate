

<?php $__env->startSection('title', 'Editar Estado'); ?>

<?php $__env->startSection('breadcrumb'); ?>
    <li class="breadcrumb-item">Catálogos</li>
    <li class="breadcrumb-item"><a href="<?php echo e(route('estados.index')); ?>">Estados</a></li>
    <li class="breadcrumb-item active">Editar</li>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('page_title', 'Editar Estado'); ?>

<?php $__env->startSection('content'); ?>
    <style>
        .estados-panel {
            border: 1px solid #dbe4f0;
            border-radius: 1.25rem;
            box-shadow: 0 14px 28px rgba(15, 23, 42, 0.06);
            overflow: hidden;
        }

        .estados-panel .card-body {
            padding: 1.5rem;
        }
    </style>

    <div class="container-fluid px-3">
        <?php if(session('error')): ?>
            <div class="alert alert-danger border-0 shadow-sm rounded-lg mb-3">
                <?php echo e(session('error')); ?>

            </div>
        <?php endif; ?>

        <div class="card estados-panel">
            <div class="card-body p-4">
                <div class="mb-4">
                    <h2 class="h5 mb-1">Actualizar estado</h2>
                    <p class="text-muted mb-0">Modifica el nombre del estado y guarda los cambios.</p>
                </div>

                <form action="<?php echo e(route('estados.update', $estado)); ?>" method="POST" autocomplete="off">
                    <?php echo csrf_field(); ?>
                    <?php echo method_field('PUT'); ?>

                    <div class="form-group mb-4">
                        <label for="estado" class="font-weight-semibold">Nombre del estado</label>
                        <input type="text" class="form-control form-control-lg rounded-lg <?php $__errorArgs = ['estado'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                            id="estado" name="estado" value="<?php echo e(old('estado', $estado->estado)); ?>"
                            placeholder="Ej. Disponible" maxlength="50" minlength="2" required>
                        <?php $__errorArgs = ['estado'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <div class="invalid-feedback"><?php echo e($message); ?></div>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    <div class="d-flex flex-column flex-md-row align-items-md-center">
                        <button type="submit" class="btn btn-primary px-4 mr-md-2 mb-2 mb-md-0" id="btn-update-estado">
                            Guardar cambios
                        </button>
                        <a href="<?php echo e(route('estados.index')); ?>" class="btn btn-outline-secondary px-4">Cancelar</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const form = document.querySelector('form[action="<?php echo e(route('estados.update', $estado)); ?>"]');
            const submitButton = document.getElementById('btn-update-estado');

            if (!form || !submitButton) {
                return;
            }

            form.addEventListener('submit', () => {
                submitButton.setAttribute('disabled', 'disabled');
                submitButton.textContent = 'Guardando...';
            });
        });
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('admin.layoutadmin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xampp3\htdocs\realestate_dev\resources\views\admin\estados\edit.blade.php ENDPATH**/ ?>