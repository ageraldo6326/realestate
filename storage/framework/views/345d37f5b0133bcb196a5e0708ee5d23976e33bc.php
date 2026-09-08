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
            <h2 class="h4 mb-2 font-weight-bold">Estados de propiedad</h2>
            <p class="mb-0 text-white-50">Define estados comerciales para controlar disponibilidad y ciclo de venta.</p>
        </section>

        <section class="card catalog-panel">
            <div class="card-body p-4">
                <div class="d-flex flex-column flex-lg-row justify-content-between align-items-lg-center mb-4">
                    <div>
                        <h3 class="h5 mb-1">Listado de estados</h3>
                        <p class="text-muted mb-0">Mantiene consistente el catalogo de estados visibles en sistema.</p>
                    </div>
                    <button type="button" class="btn btn-primary mt-3 mt-lg-0 px-4" wire:click="clear" data-toggle="modal"
                        data-target="#modalForm">
                        Nuevo estado
                    </button>
                </div>

                <div class="row mb-4">
                    <div class="col-lg-8">
                        <label class="small text-muted font-weight-semibold">Buscar</label>
                        <input type="text" class="form-control form-control-lg rounded-lg" wire:model.debounce.350ms="criterio"
                            placeholder="Ej. Vendida, Rentada o ID 3">
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table align-middle mb-0">
                        <thead class="text-uppercase small text-muted">
                            <tr>
                                <th>ID</th>
                                <th>Estado</th>
                                <th class="d-none d-md-table-cell">Creado</th>
                                <th class="text-right">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__empty_1 = true; $__currentLoopData = $estados; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $estado): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                <tr>
                                    <td class="font-weight-semibold"><?php echo e($estado->id); ?></td>
                                    <td><?php echo e($estado->estado); ?></td>
                                    <td class="d-none d-md-table-cell text-muted small"><?php echo e($estado->created_at); ?></td>
                                    <td class="text-right">
                                        <button type="button" class="btn btn-outline-primary btn-sm mr-1"
                                            wire:click="edit(<?php echo e($estado->id); ?>)" data-toggle="modal" data-target="#modalForm">
                                            Editar
                                        </button>
                                        <button type="button" class="btn btn-outline-danger btn-sm"
                                            wire:click="$emit('generarBorrarEstadoSweetAlert', <?php echo e($estado->id); ?>)">
                                            Borrar
                                        </button>
                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                <tr>
                                    <td colspan="4" class="text-center py-5 text-muted">No hay estados para mostrar.</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>

                <div class="mt-4">
                    <?php echo e($estados->links()); ?>

                </div>
            </div>
        </section>
    </div>

    <div class="modal fade catalog-modal" id="modalForm" wire:ignore.self tabindex="-1" data-backdrop="static">
        <div class="modal-dialog modal-dialog-scrollable">
            <div class="modal-content border-0 shadow-lg">
                <div class="modal-header border-0 pb-0 px-4 pt-4">
                    <div>
                        <div class="text-uppercase small text-muted"><?php echo e($Id ? 'Edicion' : 'Nuevo estado'); ?></div>
                        <h4 class="modal-title mb-0"><?php echo e($Id ? 'Editar estado' : 'Registrar estado'); ?></h4>
                    </div>
                    <button type="button" class="close" wire:click="clear" data-dismiss="modal" aria-label="Cerrar">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body px-4 pb-3">
                    <div class="form-group mb-0">
                        <label>Estado</label>
                        <input type="text" class="form-control" wire:model.lazy="estado" maxlength="50"
                            placeholder="Ej. Disponible, Vendida, Rentada">
                        <?php $__errorArgs = ['estado'];
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
                    <button type="button" class="btn btn-light px-4" wire:click="clear" data-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-primary px-4"
                        <?php if($Id == 0): ?> wire:click.prevent="store" <?php else: ?> wire:click.prevent="update(<?php echo e($Id); ?>)" <?php endif; ?>>
                        <?php echo e($Id ? 'Actualizar' : 'Guardar'); ?>

                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('close-modal', () => {
            $('#modalForm').modal('hide');
        });
    </script>
</div>
<?php /**PATH D:\xampp3\htdocs\realestate_dev\resources\views\livewire\buscar-estado.blade.php ENDPATH**/ ?>