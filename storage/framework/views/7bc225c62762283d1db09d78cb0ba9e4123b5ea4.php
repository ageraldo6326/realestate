<div>
    <div class="card shadow-sm border-0 mb-3">
        <div class="card-body">
            <div class="row align-items-end">
                <div class="col-md-8 mb-2 mb-md-0">
                    <label for="criterio" class="text-uppercase text-muted small mb-1">Telefono o correo</label>
                    <div class="input-group input-group-lg">
                        <div class="input-group-prepend">
                            <span class="input-group-text bg-white"><i class="fas fa-search"></i></span>
                        </div>
                        <input
                            id="criterio"
                            type="text"
                            class="form-control"
                            wire:model.debounce.400ms="criterio"
                            placeholder="Ej: 8095551234 o cliente@correo.com"
                        >
                    </div>
                    <small class="text-muted d-block mt-2">La busqueda se ejecuta automaticamente al escribir.</small>
                </div>
                <div class="col-md-4 text-md-right">
                    <a href="<?php echo e(route('clientes.index')); ?>" class="btn btn-outline-primary mt-2 mt-md-0">
                        <i class="fas fa-users mr-1"></i> Ir a gestion de contactos
                    </a>
                </div>
            </div>
        </div>
    </div>

    <?php if(trim((string) $criterio) === ''): ?>
        <div class="card border-0 shadow-sm">
            <div class="card-body text-center py-5">
                <i class="fas fa-id-card text-muted" style="font-size: 2rem;"></i>
                <h3 class="h5 mt-3 mb-1">Inicia una verificacion</h3>
                <p class="text-muted mb-0">Escribe un telefono o correo para validar si el contacto ya existe.</p>
            </div>
        </div>
    <?php elseif($clientes->isEmpty()): ?>
        <div class="card border-0 shadow-sm">
            <div class="card-body text-center py-5">
                <i class="fas fa-user-plus text-info" style="font-size: 2rem;"></i>
                <h3 class="h5 mt-3 mb-1">No se encontraron coincidencias</h3>
                <p class="text-muted mb-3">Puedes crear este contacto desde el modulo principal.</p>
                <a href="<?php echo e(route('clientes.index')); ?>" class="btn btn-info">Registrar nuevo contacto</a>
            </div>
        </div>
    <?php else: ?>
        <div class="row">
            <?php $__currentLoopData = $clientes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cliente): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="col-12 col-lg-6 mb-3 d-flex align-items-stretch">
                    <div class="card shadow-sm border-0 w-100">
                        <div class="card-header d-flex align-items-center justify-content-between" style="background: #eff6ff; border-bottom: 1px solid #dbeafe;">
                            <strong><?php echo e($cliente->nombre); ?></strong>
                            <span class="badge badge-primary"><?php echo e($cliente->tipo_contacto); ?></span>
                        </div>
                        <div class="card-body">
                            <div class="mb-2">
                                <span class="text-muted">Contacto</span>
                                <div>
                                    <i class="fas fa-phone-alt text-muted mr-1"></i><?php echo e($cliente->cliente_telefono ?? 'N/D'); ?>

                                </div>
                                <div>
                                    <i class="fas fa-envelope text-muted mr-1"></i><?php echo e($cliente->cliente_email ?? 'Sin correo'); ?>

                                </div>
                            </div>

                            <hr>

                            <div class="mb-2">
                                <span class="text-muted">Asesor asignado</span>
                                <div>
                                    <i class="fas fa-user text-muted mr-1"></i><?php echo e($cliente->asesor_nombre ?? 'Sin asignar'); ?>

                                </div>
                                <div>
                                    <i class="fas fa-phone-alt text-muted mr-1"></i><?php echo e($cliente->asesor_telefono ?? 'N/D'); ?>

                                </div>
                                <div>
                                    <i class="fas fa-at text-muted mr-1"></i><?php echo e($cliente->asesor_email ?? 'N/D'); ?>

                                </div>
                            </div>
                        </div>
                        <div class="card-footer bg-white text-muted small">
                            Registrado: <?php echo e(\Carbon\Carbon::parse($cliente->created_at)->format('d/m/Y H:i')); ?>

                        </div>
                    </div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    <?php endif; ?>

</div>
<?php /**PATH D:\xampp3\htdocs\realestate_dev\resources\views\livewire\consultar-cliente.blade.php ENDPATH**/ ?>