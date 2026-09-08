<div>
    <div class="card border-0 shadow-sm mb-3">
        <div class="card-body p-4">
            <div class="row align-items-center">
                <div class="col-12 col-lg-7 mb-3 mb-lg-0">
                    <label for="criterio" class="small text-uppercase text-muted mb-2">Buscar operación</label>
                    <div class="input-group input-group-lg">
                        <div class="input-group-prepend">
                            <span class="input-group-text bg-white border-right-0"><i class="fas fa-search"></i></span>
                        </div>
                        <input type="text" class="form-control border-left-0" wire:model.debounce.400ms="criterio" id="criterio" placeholder="Referencia, propiedad, asesor o comprador">
                    </div>
                </div>
                <div class="col-12 col-md-4 col-lg-2 mb-3 mb-md-0">
                    <div class="small text-uppercase text-muted">Resultados</div>
                    <div class="h3 font-weight-bold mb-0 mt-2"><?php echo e($ventas->total()); ?></div>
                </div>
                <div class="col-12 col-md-8 col-lg-3 text-lg-right">
                    <a href="<?php echo e(route('crearventa')); ?>" class="btn btn-primary btn-lg btn-block">
                        <i class="fas fa-plus mr-1"></i> Nueva venta
                    </a>
                </div>
            </div>
        </div>
    </div>

    <?php if(session('ventagrabada')): ?>
        <div class="alert alert-success border-0 shadow-sm"><?php echo e(session('ventagrabada')); ?></div>
    <?php endif; ?>

    <?php if(session('ventaactualizada')): ?>
        <div class="alert alert-success border-0 shadow-sm"><?php echo e(session('ventaactualizada')); ?></div>
    <?php endif; ?>

    <?php if(session('ventaborrada')): ?>
        <div class="alert alert-danger border-0 shadow-sm"><?php echo e(session('ventaborrada')); ?></div>
    <?php endif; ?>

    <div class="row">
        <div class="col-12 col-md-6 col-xl-3 mb-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="small text-uppercase text-muted">Ventas listadas</div>
                    <div class="display-4 font-weight-bold mb-0 mt-2"><?php echo e($ventas->count()); ?></div>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-6 col-xl-3 mb-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="small text-uppercase text-muted">Valor visible</div>
                    <div class="h4 font-weight-bold mb-0 mt-2">RD$ <?php echo e(number_format($ventas->getCollection()->sum('precio'))); ?></div>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-6 col-xl-3 mb-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="small text-uppercase text-muted">Asesores</div>
                    <div class="h4 font-weight-bold mb-0 mt-2"><?php echo e($ventas->getCollection()->pluck('nombre_asesor')->filter()->unique()->count()); ?></div>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-6 col-xl-3 mb-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="small text-uppercase text-muted">Compradores</div>
                    <div class="h4 font-weight-bold mb-0 mt-2"><?php echo e($ventas->getCollection()->pluck('nombre_comprador')->filter()->unique()->count()); ?></div>
                </div>
            </div>
        </div>
    </div>

    <div class="card border-0 shadow-sm overflow-hidden">
        <div class="card-body p-0">
            <?php if($ventas->isEmpty()): ?>
                <div class="text-center py-5 px-4">
                    <div class="mb-3"><i class="fas fa-file-invoice-dollar text-muted" style="font-size: 2rem;"></i></div>
                    <h3 class="h5 mb-1">No hay ventas registradas</h3>
                    <p class="text-muted mb-3">Registra la primera operación para comenzar el seguimiento comercial.</p>
                    <a href="<?php echo e(route('crearventa')); ?>" class="btn btn-primary btn-sm">Registrar venta</a>
                </div>
            <?php else: ?>
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead style="background:#f8fafc;">
                            <tr>
                                <th class="border-0 pl-4">Operación</th>
                                <th class="border-0">Asesor</th>
                                <th class="border-0">Comprador</th>
                                <th class="border-0">Valor</th>
                                <th class="border-0">Cierre</th>
                                <th class="border-0 text-right pr-4">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $ventas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $venta): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td class="pl-4">
                                        <div class="font-weight-bold text-dark"><?php echo e($venta->tituloPropiedad); ?></div>
                                        <div class="small text-muted">#<?php echo e($venta->id); ?> · <?php echo e($venta->refPropiedad); ?> · <?php echo e($venta->tipoPropiedad); ?></div>
                                        <div class="small text-muted"><?php echo e($venta->zonaPropiedad); ?> · <?php echo e($venta->estadoPropiedad); ?></div>
                                    </td>
                                    <td>
                                        <div class="font-weight-600"><?php echo e($venta->nombre_asesor); ?></div>
                                        <div class="small text-muted"><?php echo e($venta->nombre_vendedor); ?></div>
                                    </td>
                                    <td>
                                        <div class="font-weight-600"><?php echo e($venta->nombre_comprador); ?></div>
                                        <span class="badge badge-light border mt-1"><?php echo e($venta->medio_comprador ?: 'Sin medio'); ?></span>
                                    </td>
                                    <td>
                                        <div class="font-weight-bold">RD$ <?php echo e(number_format($venta->precio)); ?></div>
                                        <div class="small text-muted">Comisión: <?php echo e($venta->comision); ?></div>
                                    </td>
                                    <td>
                                        <div class="font-weight-600"><?php echo e($venta->fechaVentaCierre ?: 'Sin cierre'); ?></div>
                                        <div class="small text-muted">Captada: <?php echo e($venta->fechaPropiedadCreada ?: 'N/D'); ?></div>
                                    </td>
                                    <td class="text-right pr-4">
                                        <div class="d-flex justify-content-end gap-2">
                                            <a class="btn btn-outline-primary btn-sm mr-2" href="<?php echo e(route('editarventa', $venta->id)); ?>" role="button">Editar</a>
                                            <form class="delete-form d-inline-block" action="<?php echo e(route('borrarventa', $venta->id)); ?>" method="GET">
                                                <?php echo csrf_field(); ?>
                                                <button class="btn btn-outline-danger btn-sm delete-button" data-element-id="<?php echo e($venta->id); ?>" type="submit">Borrar</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                </div>
                <div class="px-4 py-3 border-top">
                    <?php echo e($ventas->links()); ?>

                </div>
            <?php endif; ?>
        </div>
    </div>

    <script>
        if (!window.__ventasDeleteHandlerAttached) {
            window.__ventasDeleteHandlerAttached = true;

            document.addEventListener('submit', function(event) {
                const form = event.target.closest('.delete-form');

                if (!form) {
                    return;
                }

                event.preventDefault();

                const elementId = form.querySelector('.delete-button')?.getAttribute('data-element-id');

                Swal.fire({
                    title: '¿Eliminar venta #' + elementId + '?',
                    text: 'Esta acción no se puede deshacer.',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#dc3545',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: 'Sí, eliminar',
                    cancelButtonText: 'Cancelar'
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            });
        }
    </script>
</div>
<?php /**PATH D:\xampp3\htdocs\realestate_dev\resources\views\livewire\registrar-ventas.blade.php ENDPATH**/ ?>