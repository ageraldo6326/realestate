<?php
    $isEdit = ($mode ?? 'create') === 'edit';
    $zonaActual = $zona ?? null;
?>

<div class="container-fluid px-3">
    <style>
        .zones-shell {
            display: grid;
            gap: 1rem;
        }

        .zones-hero {
            background: linear-gradient(135deg, #0f172a 0%, #1d4ed8 55%, #38bdf8 100%);
            border-radius: 1.25rem;
            color: #fff;
            padding: 1.5rem;
            box-shadow: 0 20px 45px rgba(15, 23, 42, 0.18);
        }

        .zones-stat {
            background: rgba(255, 255, 255, 0.14);
            border: 1px solid rgba(255, 255, 255, 0.16);
            border-radius: 1rem;
            padding: 1rem;
        }

        .zones-panel {
            border: 1px solid #dbe4f0;
            border-radius: 1.25rem;
            box-shadow: 0 14px 28px rgba(15, 23, 42, 0.06);
            overflow: hidden;
        }
    </style>

    <div class="zones-shell">
        <section class="zones-hero">
            <div class="row align-items-end">
                <div class="col-lg-8 mb-3 mb-lg-0">
                    <span class="badge badge-light text-primary px-3 py-2 rounded-pill mb-3">Catalogos del CRM</span>
                    <h1 class="h3 font-weight-bold mb-2"><?php echo e($isEdit ? 'Editar zona' : 'Crear zona'); ?></h1>
                    <p class="mb-0 text-white-50">Gestiona zonas para clasificar propiedades y clientes con un flujo dedicado sin modales.</p>
                </div>
                <div class="col-lg-4">
                    <div class="zones-stat">
                        <div class="text-uppercase small text-white-50">Modo</div>
                        <div class="h4 mb-1 font-weight-bold"><?php echo e($isEdit ? 'Edicion' : 'Alta'); ?></div>
                        <div class="small text-white-50"><?php echo e($isEdit ? 'Registro existente' : 'Nuevo registro'); ?></div>
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

        <section class="card zones-panel">
            <div class="card-body p-4">
                <div class="mb-4">
                    <h2 class="h5 mb-1"><?php echo e($isEdit ? 'Actualizar zona' : 'Registrar zona'); ?></h2>
                    <p class="text-muted mb-0">Usa nombres claros para mejorar busqueda, filtros y reportes del CRM.</p>
                </div>

                <form action="<?php echo e($action); ?>" method="POST" enctype="multipart/form-data" autocomplete="off" id="zona-form">
                    <?php echo csrf_field(); ?>
                    <?php if($isEdit): ?>
                        <?php echo method_field('PUT'); ?>
                    <?php endif; ?>

                    <div class="form-group mb-4">
                        <label for="zona" class="font-weight-semibold">Nombre de zona</label>
                        <input type="text" id="zona" name="zona"
                            class="form-control form-control-lg rounded-lg <?php $__errorArgs = ['zona'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                            value="<?php echo e(old('zona', optional($zonaActual)->zona)); ?>" placeholder="Ej. Piantini"
                            maxlength="50" minlength="2" required>
                        <?php $__errorArgs = ['zona'];
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

                    <hr class="my-4">
                    <h3 class="h6 font-weight-bold mb-3">Publicación y SEO de la zona</h3>

                    <?php if($isEdit && optional($zonaActual)->slug): ?>
                        <div class="form-group">
                            <label class="font-weight-semibold">URL pública</label>
                            <input type="text" class="form-control" value="<?php echo e(route('propiedadesPorZona', $zonaActual->slug)); ?>" readonly>
                            <small class="form-text text-muted">El slug se conserva para evitar enlaces rotos.</small>
                        </div>
                    <?php endif; ?>

                    <div class="custom-control custom-switch mb-4">
                        <input class="custom-control-input" type="checkbox" id="is_public" name="is_public" value="1"
                            <?php echo e(old('is_public', optional($zonaActual)->is_public ?? true) ? 'checked' : ''); ?>>
                        <label class="custom-control-label" for="is_public">Publicar esta página de zona</label>
                    </div>

                    <div class="row">
                        <div class="col-lg-6 form-group">
                            <label for="seo_h1" class="font-weight-semibold">Encabezado H1</label>
                            <input type="text" id="seo_h1" name="seo_h1" class="form-control"
                                maxlength="120" value="<?php echo e(old('seo_h1', optional($zonaActual)->seo_h1)); ?>"
                                placeholder="Apartamentos y casas en Piantini">
                        </div>
                        <div class="col-lg-6 form-group">
                            <label for="seo_title" class="font-weight-semibold">Título SEO</label>
                            <input type="text" id="seo_title" name="seo_title" class="form-control"
                                maxlength="70" value="<?php echo e(old('seo_title', optional($zonaActual)->seo_title)); ?>">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="meta_description" class="font-weight-semibold">Meta description</label>
                        <textarea id="meta_description" name="meta_description" class="form-control" rows="3"
                            maxlength="160"><?php echo e(old('meta_description', optional($zonaActual)->meta_description)); ?></textarea>
                    </div>

                    <div class="form-group">
                        <label for="seo_description" class="font-weight-semibold">Contenido editorial</label>
                        <textarea id="seo_description" name="seo_description" class="form-control" rows="7"
                            maxlength="10000" placeholder="Describe la zona, sus ventajas y el tipo de propiedades disponible."><?php echo e(old('seo_description', optional($zonaActual)->seo_description)); ?></textarea>
                        <small class="form-text text-muted">Este contenido permite publicar una página útil incluso cuando cambia el inventario.</small>
                    </div>

                    <div class="row">
                        <div class="col-lg-6 form-group">
                            <label for="image" class="font-weight-semibold">Imagen de la zona</label>
                            <input type="file" id="image" name="image" class="form-control-file" accept="image/jpeg,image/png,image/webp">
                        </div>
                        <div class="col-lg-6 form-group">
                            <label for="image_alt" class="font-weight-semibold">Texto alternativo</label>
                            <input type="text" id="image_alt" name="image_alt" class="form-control" maxlength="160"
                                value="<?php echo e(old('image_alt', optional($zonaActual)->image_alt)); ?>">
                        </div>
                    </div>

                    <?php if($isEdit && optional($zonaActual)->image): ?>
                        <img src="<?php echo e(asset(ltrim($zonaActual->image, '/'))); ?>" alt="<?php echo e($zonaActual->image_alt ?: $zonaActual->zona); ?>"
                            class="img-fluid rounded mb-4" style="max-height: 220px; object-fit: cover;" loading="lazy">
                    <?php endif; ?>

                    <div class="d-flex flex-column flex-md-row align-items-md-center">
                        <button type="submit" class="btn btn-primary px-4 mr-md-2 mb-2 mb-md-0" id="btn-submit-zona">
                            <?php echo e($isEdit ? 'Guardar cambios' : 'Guardar zona'); ?>

                        </button>
                        <a href="<?php echo e(route('zonas.index')); ?>" class="btn btn-outline-secondary px-4">Cancelar</a>
                    </div>
                </form>
            </div>
        </section>
    </div>
</div>

<?php $__env->startPush('scripts'); ?>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const form = document.getElementById('zona-form');
            const submitButton = document.getElementById('btn-submit-zona');

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
<?php /**PATH D:\xampp3\htdocs\realestate_dev\resources\views/admin/zonas/_form.blade.php ENDPATH**/ ?>