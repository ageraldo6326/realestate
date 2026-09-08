<?php
    $resolveImage = function ($value) {
        if (!$value) {
            return null;
        }

        if (is_object($value) && method_exists($value, 'temporaryUrl')) {
            return $value->temporaryUrl();
        }

        return asset('assets/' . ltrim($value, '/'));
    };

    $photoPreview = $resolveImage($cliente_foto);
?>

<div>
    <style>
        .content-shell { display: grid; gap: 1rem; }
        .content-hero {
            background: linear-gradient(135deg, #0f172a 0%, #1d4ed8 55%, #38bdf8 100%);
            border-radius: 1.25rem;
            color: #fff;
            padding: 1.5rem;
            box-shadow: 0 20px 45px rgba(15, 23, 42, 0.18);
        }
        .content-panel {
            border: 1px solid #dbe4f0;
            border-radius: 1.25rem;
            box-shadow: 0 14px 28px rgba(15, 23, 42, 0.06);
        }
        .content-avatar {
            width: 56px; height: 56px; object-fit: cover; border-radius: 999px; border: 2px solid #e2e8f0;
        }
        .content-modal .modal-dialog { max-width: 1080px; }
        .media-preview {
            width: 120px; height: 120px; object-fit: cover; border-radius: 1rem; border: 1px solid #dbe4f0; background: #f8fafc;
        }
    </style>

    <?php if(session('status')): ?>
        <div class="alert alert-success border-0 shadow-sm rounded-lg mb-3"><?php echo e(session('status')); ?></div>
    <?php endif; ?>

    <div class="content-shell">
        <section class="content-hero">
            <h2 class="h4 mb-2 font-weight-bold">Testimonios</h2>
            <p class="mb-0 text-white-50">Gestiona prueba social del portal con cliente, foto y mensaje enriquecido.</p>
        </section>

        <section class="card content-panel">
            <div class="card-body p-4">
                <div class="d-flex flex-column flex-lg-row justify-content-between align-items-lg-center mb-4">
                    <div>
                        <h3 class="h5 mb-1">Listado de testimonios</h3>
                        <p class="text-muted mb-0">Busca por cliente y actualiza testimonios sin perder contexto.</p>
                    </div>
                    <button type="button" class="btn btn-primary mt-3 mt-lg-0 px-4" wire:click="clear" data-toggle="modal" data-target="#modalForm">
                        Nuevo testimonio
                    </button>
                </div>

                <div class="row mb-4">
                    <div class="col-lg-8">
                        <label class="small text-muted font-weight-semibold">Buscar</label>
                        <input type="text" class="form-control form-control-lg rounded-lg" wire:model.debounce.350ms="criterio" placeholder="Ej. Maria Perez o ID 5">
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table align-middle mb-0">
                        <thead class="text-uppercase small text-muted">
                            <tr>
                                <th>ID</th>
                                <th>Cliente</th>
                                <th class="d-none d-md-table-cell">Testimonio</th>
                                <th class="text-right">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__empty_2 = true; $__currentLoopData = $testimonios; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $testimonioItem): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_2 = false; ?>
                                <tr>
                                    <td class="font-weight-semibold"><?php echo e($testimonioItem->id); ?></td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <?php if($testimonioItem->cliente_foto): ?>
                                                <img src="<?php echo e(asset('assets/' . $testimonioItem->cliente_foto)); ?>" class="content-avatar mr-3" alt="<?php echo e($testimonioItem->cliente); ?>">
                                            <?php endif; ?>
                                            <span><?php echo e($testimonioItem->cliente); ?></span>
                                        </div>
                                    </td>
                                    <td class="d-none d-md-table-cell text-muted"><?php echo \Illuminate\Support\Str::limit(strip_tags($testimonioItem->testimonio), 80); ?></td>
                                    <td class="text-right">
                                        <button type="button" class="btn btn-outline-primary btn-sm mr-1" wire:click="edit(<?php echo e($testimonioItem->id); ?>)" data-toggle="modal" data-target="#modalForm">Editar</button>
                                        <button type="button" class="btn btn-outline-danger btn-sm" wire:click="$emit('generarBorrarTestimonioSweetAlert', <?php echo e($testimonioItem->id); ?>)">Borrar</button>
                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_2): ?>
                                <tr>
                                    <td colspan="4" class="text-center py-5 text-muted">No hay testimonios para mostrar.</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>

                <div class="mt-4"><?php echo e($testimonios->links()); ?></div>
            </div>
        </section>
    </div>

    <div class="modal fade content-modal" id="modalForm" wire:ignore.self tabindex="-1" data-backdrop="static">
        <div class="modal-dialog modal-dialog-scrollable">
            <div class="modal-content border-0 shadow-lg">
                <div class="modal-header border-0 pb-0 px-4 pt-4">
                    <div>
                        <div class="text-uppercase small text-muted"><?php echo e($Id ? 'Edicion' : 'Nuevo testimonio'); ?></div>
                        <h4 class="modal-title mb-0"><?php echo e($Id ? 'Editar testimonio' : 'Registrar testimonio'); ?></h4>
                    </div>
                    <button type="button" class="close" wire:click="clear" data-dismiss="modal" aria-label="Cerrar"><span aria-hidden="true">&times;</span></button>
                </div>

                <div class="modal-body px-4 pb-3">
                    <?php if($errors->any()): ?>
                        <div class="alert alert-danger rounded-lg border-0 shadow-sm">
                            <div class="font-weight-bold mb-1">Revisa los campos requeridos.</div>
                            <ul class="mb-0 pl-3">
                                <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <li><?php echo e($error); ?></li>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </ul>
                        </div>
                    <?php endif; ?>

                    <div class="row">
                        <div class="col-xl-7">
                            <div class="card content-panel">
                                <div class="card-body p-4">
                                    <div class="form-group">
                                        <label>Cliente</label>
                                        <input type="text" class="form-control" wire:model.lazy="cliente" placeholder="Nombre del cliente">
                                    </div>
                                    <div class="form-group mb-0" wire:ignore>
                                        <label>Testimonio</label>
                                        <textarea class="form-control" id="testimonio-editor" rows="10"><?php echo e($testimonio); ?></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-5">
                            <div class="card content-panel">
                                <div class="card-body p-4" x-data="{ isUploading: false, progress: 0 }"
                                    x-on:livewire-upload-start="isUploading = true"
                                    x-on:livewire-upload-finish="isUploading = false"
                                    x-on:livewire-upload-error="isUploading = false"
                                    x-on:livewire-upload-progress="progress = $event.detail.progress">
                                    <h5 class="mb-3">Foto del cliente</h5>
                                    <input type="file" class="form-control-file mb-3" wire:model="cliente_foto" accept="image/*">
                                    <?php $__errorArgs = ['cliente_foto'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <span class="text-danger d-block mb-2"><?php echo e($message); ?></span>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                    <div x-show="isUploading" class="mb-3">
                                        <div class="small text-muted mb-1" x-text="'Subiendo: ' + progress + '%' "></div>
                                        <div class="progress" style="height: 8px;">
                                            <div class="progress-bar" role="progressbar" x-bind:style="`width: ${progress}%`"></div>
                                        </div>
                                    </div>
                                    <?php if($photoPreview): ?>
                                        <img class="media-preview mb-3" src="<?php echo e($photoPreview); ?>" alt="Foto cliente">
                                        <div>
                                            <button type="button" class="btn btn-sm btn-outline-danger" wire:click="borrar_foto">Quitar foto</button>
                                        </div>
                                    <?php else: ?>
                                        <div class="text-muted small">Sin foto cargada.</div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer border-0 px-4 pb-4 pt-0">
                    <button type="button" class="btn btn-light px-4" wire:click="clear" data-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-primary px-4" <?php if($Id == 0): ?> wire:click.prevent="store" <?php else: ?> wire:click.prevent="update(<?php echo e($Id); ?>)" <?php endif; ?>>
                        <?php echo e($Id ? 'Actualizar testimonio' : 'Guardar testimonio'); ?>

                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('livewire:load', () => {
            const selector = '#testimonio-editor';
            const ensureTestimonioEditor = () => window.AdminCkeditor?.ensure(selector, (value) => {
                window.livewire.find('<?php echo e($_instance->id); ?>').set('testimonio', value);
            });

            ensureTestimonioEditor();

            window.livewire.on('editarTestimonio', (value) => {
                window.AdminCkeditor?.setData(selector, value || '');
            });

            window.livewire.on('limpiarTestimonio', () => {
                window.AdminCkeditor?.clear(selector);
            });

            window.addEventListener('close-modal', () => {
                $('#modalForm').modal('hide');
            });

            $('#modalForm').on('shown.bs.modal', () => {
                ensureTestimonioEditor();
            });
        });
    </script>
</div>
<?php /**PATH D:\xampp3\htdocs\realestate_dev\resources\views\livewire\buscar-testimonio.blade.php ENDPATH**/ ?>