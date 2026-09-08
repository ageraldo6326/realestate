<div>
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
        }
    </style>

    <?php if(session('status')): ?>
        <div class="alert alert-success border-0 shadow-sm rounded-lg mb-3">
            <?php echo e(session('status')); ?>

        </div>
    <?php endif; ?>

    <?php if(session('error')): ?>
        <div class="alert alert-danger border-0 shadow-sm rounded-lg mb-3">
            <?php echo e(session('error')); ?>

        </div>
    <?php endif; ?>

    <div class="types-shell">
        <section class="types-hero">
            <div class="row align-items-end">
                <div class="col-lg-8 mb-3 mb-lg-0">
                    <span class="badge badge-light text-primary px-3 py-2 rounded-pill mb-3">Catalogos del CRM</span>
                    <h2 class="h3 font-weight-bold mb-2">Gestion de tipos de propiedad con vistas dedicadas.</h2>
                    <p class="mb-0 text-white-50">Busca por nombre o ID, crea nuevos tipos y edita registros sin salir del flujo principal.</p>
                </div>
                <div class="col-lg-4">
                    <div class="types-stat">
                        <div class="text-uppercase small text-white-50">Tipos encontrados</div>
                        <div class="h3 mb-0 font-weight-bold"><?php echo e($tipoPropiedades->total()); ?></div>
                    </div>
                </div>
            </div>
        </section>

        <section class="card types-panel">
            <div class="card-body p-4">
                <div class="d-flex flex-column flex-lg-row justify-content-between align-items-lg-center mb-4">
                    <div>
                        <h3 class="h5 mb-1">Listado de tipos de propiedad</h3>
                        <p class="text-muted mb-0">Administra el catalogo de tipologias utilizadas en captacion y publicacion.</p>
                    </div>
                    <a href="<?php echo e(route('tipopropiedades.create')); ?>" class="btn btn-primary mt-3 mt-lg-0 px-4">Nuevo tipo</a>
                </div>

                <div class="row mb-4">
                    <div class="col-lg-8">
                        <label for="filtro-tipo" class="small text-muted font-weight-semibold">Buscar tipo</label>
                        <input type="text" id="filtro-tipo" wire:model.debounce.350ms="criterio"
                            class="form-control form-control-lg rounded-lg" maxlength="100" placeholder="Ej. Casa o ID 4">
                    </div>
                    <div class="col-lg-4 d-flex align-items-end mt-3 mt-lg-0">
                        <button type="button" class="btn btn-outline-secondary" wire:click="limpiar">Limpiar</button>
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table align-middle mb-0">
                        <thead class="text-uppercase small text-muted">
                            <tr>
                                <th>ID</th>
                                <th>Tipo</th>
                                <th class="text-right">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__empty_2 = true; $__currentLoopData = $tipoPropiedades; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tipo): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_2 = false; ?>
                                <tr>
                                    <td class="font-weight-bold"><?php echo e($tipo->id); ?></td>
                                    <td>
                                        <div class="font-weight-semibold"><?php echo e($tipo->tipo); ?></div>
                                    </td>
                                    <td class="text-right">
                                        <div class="d-flex justify-content-end">
                                            <a href="<?php echo e(route('tipopropiedades.edit', $tipo->id)); ?>"
                                                class="btn btn-outline-primary btn-sm mr-1">Editar</a>
                                            <button type="button" class="btn btn-outline-danger btn-sm"
                                                wire:click="$emit('generarBorrarSweetAlert', <?php echo e($tipo->id); ?>)">Eliminar</button>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_2): ?>
                                <tr>
                                    <td colspan="3" class="text-center py-5 text-muted">
                                        No hay tipos de propiedad registrados con ese criterio.
                                    </td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>

                <div class="mt-4">
                    <?php echo e($tipoPropiedades->links('pagination::bootstrap-4')); ?>

                </div>
            </div>
        </section>
    </div>
</div>
<?php /**PATH D:\xampp3\htdocs\realestate_dev\resources\views\livewire\buscar-tipo-propiedad.blade.php ENDPATH**/ ?>