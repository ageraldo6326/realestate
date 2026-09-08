<div>
    <style>
        .catalog-shell {
            display: grid;
            gap: 1rem;
        }

        .catalog-hero {
            background: linear-gradient(135deg, #0f172a 0%, #1d4ed8 55%, #38bdf8 100%);
            border-radius: 1.25rem;
            color: #fff;
            padding: 1.5rem;
            box-shadow: 0 20px 45px rgba(15, 23, 42, 0.18);
        }

        .catalog-panel {
            border: 1px solid #dbe4f0;
            border-radius: 1.25rem;
            box-shadow: 0 14px 28px rgba(15, 23, 42, 0.06);
        }

        .catalog-modal .modal-dialog {
            max-width: 680px;
        }
    </style>

    <?php if(session('status')): ?>
        <div class="alert alert-success border-0 shadow-sm rounded-lg mb-3">
            <?php echo e(session('status')); ?>

        </div>
    <?php endif; ?>

    <div class="catalog-shell">
        <section class="catalog-hero">
            <h2 class="h4 mb-2 font-weight-bold">Zonas comerciales</h2>
            <p class="mb-0 text-white-50">Administra zonas de ubicacion para clasificar propiedades de forma consistente.
            </p>
        </section>

        <section class="card catalog-panel">
            <div class="card-body p-4">
                <div class="d-flex flex-column flex-lg-row justify-content-between align-items-lg-center mb-4">
                    <div>
                        <h3 class="h5 mb-1">Listado de zonas</h3>
                        <p class="text-muted mb-0">Busca por nombre o ID y edita sin salir de la pantalla.</p>
                    </div>
                    <button type="button" class="btn btn-primary mt-3 mt-lg-0 px-4" wire:click="clear"
                        data-toggle="modal" wire:loading.attr="disabled" wire:target="save,store,update,borrarZona"
                        data-target="#modalForm">
                        Nueva zona
                    </button>
                </div>

                <div class="row mb-4">
                    <div class="col-lg-8">
                        <label for="zona-criterio" class="small text-muted font-weight-semibold">Buscar</label>
                        <input type="text" class="form-control form-control-lg rounded-lg"
                            wire:model.debounce.350ms="criterio" id="zona-criterio" placeholder="Ej. Naco o ID 12"
                            autocomplete="off" maxlength="50">
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table align-middle mb-0">
                        <thead class="text-uppercase small text-muted">
                            <tr>
                                <th>ID</th>
                                <th>Zona</th>
                                <th class="text-right">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__empty_2 = true; $__currentLoopData = $zonas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $zona): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_2 = false; ?>
                                <tr wire:key="zona-row-<?php echo e($zona->id); ?>">
                                    <td class="font-weight-semibold"><?php echo e($zona->id); ?></td>
                                    <td><?php echo e($zona->zona); ?></td>
                                    <td class="text-right">
                                        <button type="button" class="btn btn-outline-primary btn-sm mr-1"
                                            wire:click="edit(<?php echo e($zona->id); ?>)" data-toggle="modal"
                                            data-target="#modalForm" wire:loading.attr="disabled"
                                            wire:target="edit(<?php echo e($zona->id); ?>)">
                                            Editar
                                        </button>
                                        <button type="button" class="btn btn-outline-danger btn-sm"
                                            wire:click="$emit('generarBorrarZonaSweetAlert', <?php echo e($zona->id); ?>, <?php echo \Illuminate\Support\Js::from($zona->zona)->toHtml() ?>)"
                                            wire:loading.attr="disabled" wire:target="borrarZona">
                                            Borrar
                                        </button>
                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_2): ?>
                                <tr>
                                    <td colspan="3" class="text-center py-5 text-muted">No hay zonas para mostrar.
                                    </td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>

                <div class="mt-4">
                    <?php echo e($zonas->links()); ?>

                </div>
            </div>
        </section>
    </div>

    <div class="modal fade catalog-modal" id="modalForm" wire:ignore.self tabindex="-1" data-backdrop="static">
        <div class="modal-dialog modal-dialog-scrollable">
            <div class="modal-content border-0 shadow-lg">
                <form wire:submit.prevent="save" autocomplete="off">
                    <div class="modal-header border-0 pb-0 px-4 pt-4">
                        <div>
                            <div class="text-uppercase small text-muted"><?php echo e($Id ? 'Edicion' : 'Nueva zona'); ?></div>
                            <h4 class="modal-title mb-0"><?php echo e($Id ? 'Editar zona' : 'Registrar zona'); ?></h4>
                        </div>
                        <button type="button" class="close" wire:click="clear" data-dismiss="modal"
                            aria-label="Cerrar" wire:loading.attr="disabled" wire:target="save,store,update">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <div class="modal-body px-4 pb-3">
                        <div class="form-group mb-0">
                            <label for="zona-nombre">Zona</label>
                            <input type="text" id="zona-nombre" class="form-control" wire:model.debounce.350ms="zona"
                                placeholder="Nombre de zona" maxlength="50" minlength="2" required>
                            <?php $__errorArgs = ['zona'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <small class="text-danger"><?php echo e($message); ?></small>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                    </div>

                    <div class="modal-footer border-0 px-4 pb-4 pt-0">
                        <button type="button" class="btn btn-light px-4" wire:click="clear" data-dismiss="modal"
                            wire:loading.attr="disabled" wire:target="save,store,update">Cancelar</button>
                        <button type="submit" class="btn btn-primary px-4" wire:loading.attr="disabled"
                            wire:target="save,store,update">
                            <span wire:loading.remove
                                wire:target="save,store,update"><?php echo e($Id ? 'Actualizar' : 'Guardar'); ?></span>
                            <span wire:loading wire:target="save,store,update">Procesando...</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <?php if (! $__env->hasRenderedOnce('d642f4c1-008f-4633-926c-71313f2fea37')): $__env->markAsRenderedOnce('d642f4c1-008f-4633-926c-71313f2fea37'); ?>
        <?php $__env->startPush('scripts'); ?>
            <script>
                window.addEventListener('close-modal', () => {
                    $('#modalForm').modal('hide');
                });

                window.addEventListener('zona-operation-result', event => {
                    if (!event.detail || !event.detail.message) {
                        return;
                    }

                    Swal.fire({
                        icon: event.detail.type || 'info',
                        text: event.detail.message,
                        timer: 2200,
                        showConfirmButton: false,
                        toast: true,
                        position: 'top-end'
                    });
                });
            </script>
        <?php $__env->stopPush(); ?>
    <?php endif; ?>
</div>
<?php /**PATH D:\xampp3\htdocs\realestate_dev\resources\views\livewire\buscar-zona.blade.php ENDPATH**/ ?>