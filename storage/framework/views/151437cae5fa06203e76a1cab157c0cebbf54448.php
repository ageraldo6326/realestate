<?php
    $isEdit = ($mode ?? 'create') === 'edit';
    $tipoActual = $tipopropiedad ?? null;
?>

<div class="container-fluid px-3">
    <style>
        .types-shell {
            display: grid;
            gap: 1rem;
        }

        .types-hero {
            background: linear-gradient(135deg, #0f172a 0%, #1d4ed8 55%, #38bdf8 100%);
            border-radius: 1.25rem;
            color: #fff;
            padding: 1.5rem;
            box-shadow: 0 20px 45px rgba(15, 23, 42, 0.18);
        }

        .types-stat {
            background: rgba(255, 255, 255, 0.14);
            border: 1px solid rgba(255, 255, 255, 0.16);
            border-radius: 1rem;
            padding: 1rem;
        }

        .types-panel {
            border: 1px solid #dbe4f0;
            border-radius: 1.25rem;
            box-shadow: 0 14px 28px rgba(15, 23, 42, 0.06);
            overflow: hidden;
        }
    </style>

    <div class="types-shell">
        <section class="types-hero">
            <div class="row align-items-end">
                <div class="col-lg-8 mb-3 mb-lg-0">
                    <span class="badge badge-light text-primary px-3 py-2 rounded-pill mb-3">Catalogos del CRM</span>
                    <h1 class="h3 font-weight-bold mb-2"><?php echo e($isEdit ? 'Editar tipo de propiedad' : 'Crear tipo de propiedad'); ?></h1>
                    <p class="mb-0 text-white-50">
                        <?php echo e($isEdit ? 'Actualiza el tipo manteniendo consistencia en captacion y publicacion.' : 'Registra una nueva tipologia para mantener estandar del catalogo inmobiliario.'); ?>

                    </p>
                </div>
                <div class="col-lg-4">
                    <div class="types-stat">
                        <div class="text-uppercase small text-white-50">Modo</div>
                        <div class="h4 mb-1 font-weight-bold"><?php echo e($isEdit ? 'Edicion' : 'Alta'); ?></div>
                        <div class="small text-white-50"><?php echo e($isEdit ? 'ID ' . optional($tipoActual)->id : 'Nuevo registro'); ?></div>
                    </div>
                </div>
            </div>
        </section>

        <?php if(session('error')): ?>
            <div class="alert alert-danger border-0 shadow-sm rounded-lg mb-0">
                <?php echo e(session('error')); ?>

            </div>
        <?php endif; ?>

        <?php if($errors->any()): ?>
            <div class="alert alert-danger border-0 shadow-sm rounded-lg mb-0">
                <div class="font-weight-bold mb-1">Revisa los campos requeridos antes de guardar.</div>
                <ul class="mb-0 pl-3">
                    <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <li><?php echo e($error); ?></li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </ul>
            </div>
        <?php endif; ?>

        <section class="card types-panel">
            <div class="card-body p-4">
                <div class="mb-4">
                    <h2 class="h5 mb-1"><?php echo e($isEdit ? 'Actualizar tipo' : 'Registrar tipo'); ?></h2>
                    <p class="text-muted mb-0">Usa un nombre claro y unico para facilitar filtros y reportes.</p>
                </div>

                <form action="<?php echo e($action); ?>" method="POST" autocomplete="off" id="tipo-propiedad-form">
                    <?php echo csrf_field(); ?>
                    <?php if($isEdit): ?>
                        <?php echo method_field('PUT'); ?>
                    <?php endif; ?>

                    <div class="form-group mb-4">
                        <label for="tipo" class="font-weight-semibold">Tipo de propiedad</label>
                        <input type="text"
                            class="form-control form-control-lg rounded-lg <?php $__errorArgs = ['tipo'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                            id="tipo" name="tipo" value="<?php echo e(old('tipo', optional($tipoActual)->tipo)); ?>"
                            placeholder="Ej. Apartamento, Casa, Penthouse" maxlength="100" minlength="2" required>
                        <small class="form-text text-muted mt-2">Maximo 100 caracteres. Evita duplicados.</small>
                        <?php $__errorArgs = ['tipo'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <div class="invalid-feedback d-block"><?php echo e($message); ?></div>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    <div class="d-flex flex-column flex-md-row align-items-md-center">
                        <button type="submit" class="btn btn-primary px-4 mr-md-2 mb-2 mb-md-0" id="btn-submit-tipo">
                            <?php echo e($isEdit ? 'Guardar cambios' : 'Guardar tipo'); ?>

                        </button>
                        <a href="<?php echo e(route('tipopropiedades.index')); ?>" class="btn btn-outline-secondary px-4">Cancelar</a>
                    </div>
                </form>
            </div>
        </section>
    </div>
</div>

<?php $__env->startPush('scripts'); ?>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const form = document.getElementById('tipo-propiedad-form');
            const submitButton = document.getElementById('btn-submit-tipo');
            const tipoInput = document.getElementById('tipo');

            if (tipoInput) {
                tipoInput.addEventListener('input', function() {
                    this.value = this.value.replace(/\s+/g, ' ').trimStart();
                });
            }

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
<?php /**PATH D:\xampp3\htdocs\realestate_dev\resources\views\admin\tipopropiedades\_form.blade.php ENDPATH**/ ?>