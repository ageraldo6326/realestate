<?php
    $isEdit = ($mode ?? 'create') === 'edit';
    $enfoqueActual = $enfoque ?? null;
    $currentImage = $enfoqueActual && $enfoqueActual->foto ? asset(ltrim($enfoqueActual->foto, '/')) : null;
?>

<link rel="stylesheet" href="https://unpkg.com/dropzone@5/dist/min/dropzone.min.css">

<style>
    .content-form-shell {
        display: grid;
        gap: 1rem;
    }

    .content-form-hero {
        background: linear-gradient(135deg, #0f172a 0%, #1d4ed8 55%, #38bdf8 100%);
        border-radius: 1.25rem;
        color: #fff;
        padding: 1.5rem;
        box-shadow: 0 20px 45px rgba(15, 23, 42, 0.18);
    }

    .content-form-panel {
        border: 1px solid #dbe4f0;
        border-radius: 1.25rem;
        box-shadow: 0 14px 28px rgba(15, 23, 42, 0.06);
        overflow: hidden;
    }

    .content-form-panel .card-body {
        padding: 1.5rem;
    }

    .content-form-label {
        font-size: 0.82rem;
        font-weight: 700;
        letter-spacing: 0.04em;
        text-transform: uppercase;
        color: #64748b;
    }

    .content-form-control {
        border-radius: 0.9rem;
        border-color: #cbd5e1;
        min-height: calc(1.5em + 1rem + 2px);
        box-shadow: 0 8px 20px rgba(15, 23, 42, 0.04);
    }

    .ck-editor__editable_inline {
        min-height: 8rem;
    }

    .content-dropzone {
        min-height: 230px;
        border: 2px dashed #93c5fd;
        border-radius: 1rem;
        background: linear-gradient(180deg, #f8fbff 0%, #eef6ff 100%);
        padding: 1rem;
    }

    .content-dropzone.dz-drag-hover,
    .content-dropzone:hover {
        border-color: #2563eb;
        background: #eff6ff;
    }

    .content-dropzone .dz-message {
        margin: 2.4rem 0;
        color: #334155;
        font-weight: 600;
        text-align: center;
    }

    .content-preview-card {
        border: 1px solid #dbe4f0;
        border-radius: 1rem;
        padding: 0.85rem;
        background: #fff;
    }

    .content-preview-card img {
        width: 100%;
        max-height: 240px;
        object-fit: cover;
        border-radius: 0.85rem;
        border: 1px solid #dbe4f0;
    }

    .content-submit-row {
        display: flex;
        flex-wrap: wrap;
        gap: 0.75rem;
        justify-content: flex-end;
    }
</style>

<div class="container-fluid px-3">
    <div class="content-form-shell">
        <section class="content-form-hero">
            <h2 class="h4 mb-2 font-weight-bold"><?php echo e($isEdit ? 'Editar enfoque' : 'Nuevo enfoque'); ?></h2>
            <p class="mb-0 text-white-50">Administra bloques editoriales con una vista separada para mantener el listado
                limpio y el formulario enfocado.</p>
        </section>

        <?php if(session('error')): ?>
            <div class="alert alert-danger border-0 shadow-sm rounded-lg mb-0"><?php echo e(session('error')); ?></div>
        <?php endif; ?>

        <?php if($errors->any()): ?>
            <div class="alert alert-danger border-0 shadow-sm rounded-lg mb-0">
                <div class="font-weight-bold mb-2">Revisa los campos obligatorios.</div>
                <ul class="mb-0 pl-3">
                    <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <li><?php echo e($error); ?></li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </ul>
            </div>
        <?php endif; ?>

        <form action="<?php echo e($action); ?>" method="POST" enctype="multipart/form-data"
            id="enfoque-form-<?php echo e($mode); ?>">
            <?php echo csrf_field(); ?>
            <?php if($isEdit): ?>
                <?php echo method_field('PUT'); ?>
            <?php endif; ?>

            <div class="row">
                <div class="col-xl-8">
                    <div class="card content-form-panel mb-4">
                        <div class="card-body">
                            <div class="form-group">
                                <label for="titulo" class="content-form-label">Titulo</label>
                                <input type="text"
                                    class="form-control content-form-control <?php $__errorArgs = ['titulo'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                    id="titulo" name="titulo"
                                    value="<?php echo e(old('titulo', optional($enfoqueActual)->titulo)); ?>" maxlength="255"
                                    required>
                            </div>

                            <div class="form-group mb-0">
                                <label for="enfoque-editor" class="content-form-label">Contenido</label>
                                <textarea class="form-control content-form-control <?php $__errorArgs = ['enfoque'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="enfoque-editor"
                                    name="enfoque" rows="10"><?php echo e(old('enfoque', optional($enfoqueActual)->enfoque)); ?></textarea>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-4">
                    <div class="card content-form-panel mb-4">
                        <div class="card-body">
                            <label class="content-form-label d-block">Imagen del enfoque</label>
                            <input type="file" class="d-none" id="foto" name="foto" accept="image/*">
                            <div id="enfoque-dropzone-<?php echo e($mode); ?>"
                                class="content-dropzone <?php $__errorArgs = ['foto'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"></div>
                            <small class="form-text text-muted mt-2">Usa una imagen clara y vertical o semivertical para
                                reforzar el bloque visual.</small>
                            <?php $__errorArgs = ['foto'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <span class="invalid-feedback d-block"><?php echo e($message); ?></span>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                    </div>

                    <?php if($currentImage): ?>
                        <div class="content-preview-card mb-4">
                            <div class="small text-muted font-weight-semibold mb-2">Imagen actual</div>
                            <img src="<?php echo e($currentImage); ?>" alt="Imagen actual del enfoque">
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <div class="content-submit-row">
                <a href="<?php echo e(route('enfoques.index')); ?>" class="btn btn-outline-secondary px-4">Cancelar</a>
                <button type="submit" class="btn btn-primary px-4 js-submit-button"
                    data-loading-text="Guardando..."><?php echo e($isEdit ? 'Guardar cambios' : 'Guardar enfoque'); ?></button>
            </div>
        </form>
    </div>
</div>

<?php $__env->startPush('scripts'); ?>
    <script>
        window.Dropzone = window.Dropzone || {};
        window.Dropzone.autoDiscover = false;
    </script>
    <script src="https://unpkg.com/dropzone@5/dist/min/dropzone.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const textareaSelector = '#enfoque-editor';
            window.AdminCkeditor?.ensure(textareaSelector, (value) => {
                const textarea = document.querySelector(textareaSelector);
                if (textarea) {
                    textarea.value = value;
                }
            });

            const target = document.getElementById('enfoque-dropzone-<?php echo e($mode); ?>');
            const input = document.getElementById('foto');

            if (target && input && typeof Dropzone !== 'undefined' && target.dataset.initialized !== '1') {
                target.dataset.initialized = '1';

                const dropzone = new Dropzone(target, {
                    url: window.location.href,
                    autoProcessQueue: false,
                    uploadMultiple: false,
                    maxFiles: 1,
                    acceptedFiles: 'image/*',
                    addRemoveLinks: true,
                    dictDefaultMessage: 'Suelta la imagen aqui o haz clic para cargarla',
                });

                const syncInput = (file) => {
                    const transfer = new DataTransfer();
                    if (file) {
                        transfer.items.add(file);
                    }
                    input.files = transfer.files;
                };

                dropzone.on('addedfile', (file) => {
                    if (dropzone.files.length > 1) {
                        dropzone.removeFile(dropzone.files[0]);
                    }
                    syncInput(file);
                });

                dropzone.on('removedfile', () => syncInput(null));
            }

            const form = document.getElementById('enfoque-form-<?php echo e($mode); ?>');
            const submitButton = form?.querySelector('.js-submit-button');

            form?.addEventListener('submit', async () => {
                const editor = window.AdminCkeditor?.get(textareaSelector);
                const textarea = document.querySelector(textareaSelector);

                if (editor && textarea) {
                    textarea.value = editor.getData();
                }

                if (submitButton) {
                    submitButton.disabled = true;
                    submitButton.textContent = submitButton.dataset.loadingText || 'Guardando...';
                }
            });
        });
    </script>
<?php $__env->stopPush(); ?>
<?php /**PATH D:\xampp3\htdocs\realestate_dev\resources\views\admin\enfoques\_form.blade.php ENDPATH**/ ?>