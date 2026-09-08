<div>
    <div class="card border-0 shadow-sm mb-3">
        <div class="card-body p-4">
            <div class="row align-items-end">
                <div class="col-12 col-lg-4 mb-3">
                    <label for="criterio" class="small text-uppercase text-muted mb-2">Referencia o ID</label>
                    <input type="text" class="form-control form-control-lg" wire:model.debounce.400ms="criterio" id="criterio" placeholder="Ej. PROP-00012 o 45">
                </div>
                <div class="col-12 col-md-6 col-lg-3 mb-3">
                    <label for="zona" class="small text-uppercase text-muted mb-2">Zona</label>
                    <select class="form-control form-control-lg" name="zona" id="zona" wire:model="zona">
                        <option value="Seleccionar zona">Todas las zonas</option>
                        <?php $__currentLoopData = $zonas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $zona): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($zona->id); ?>"><?php echo e($zona->zona); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>
                <div class="col-12 col-md-6 col-lg-2 mb-3">
                    <label for="moneda" class="small text-uppercase text-muted mb-2">Moneda</label>
                    <select class="form-control form-control-lg" name="moneda" id="moneda" wire:model="moneda">
                        <option value="RD$">RD$</option>
                        <option value="US$">US$</option>
                    </select>
                </div>
                <div class="col-6 col-lg-1 mb-3">
                    <label for="precio_inicial" class="small text-uppercase text-muted mb-2">Desde</label>
                    <input type="text" wire:model.debounce.500ms="precio_inicial" class="form-control form-control-lg monto" id="precio_inicial" placeholder="0">
                </div>
                <div class="col-6 col-lg-2 mb-3">
                    <label for="precio_final" class="small text-uppercase text-muted mb-2">Hasta</label>
                    <input type="text" wire:model.debounce.500ms="precio_final" class="form-control form-control-lg monto" id="precio_final" placeholder="0">
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12 col-md-4 col-xl-3 mb-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="small text-uppercase text-muted">Resultados</div>
                    <div class="d-flex align-items-center justify-content-between mt-2">
                        <div class="display-4 font-weight-bold mb-0"><?php echo e($propiedades->total()); ?></div>
                        <span class="badge badge-light border">Activas</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-4 col-xl-3 mb-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="small text-uppercase text-muted">Moneda actual</div>
                    <div class="d-flex align-items-center justify-content-between mt-2">
                        <div class="h3 font-weight-bold mb-0"><?php echo e($moneda); ?></div>
                        <span class="badge badge-info">Filtro</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-4 col-xl-6 mb-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="small text-uppercase text-muted">Rango</div>
                    <div class="h5 mb-0 mt-2 text-dark">
                        <?php echo e($precio_inicial ? number_format((int) str_replace(',', '', $precio_inicial)) : '0'); ?>

                        -
                        <?php echo e($precio_final ? number_format((int) str_replace(',', '', $precio_final)) : 'Sin tope'); ?>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card border-0 shadow-sm overflow-hidden">
        <div class="card-body p-0">
            <?php if($propiedades->isEmpty()): ?>
                <div class="text-center py-5 px-4">
                    <div class="mb-3"><i class="fas fa-search text-muted" style="font-size: 2rem;"></i></div>
                    <h3 class="h5 mb-1">No se encontraron propiedades</h3>
                    <p class="text-muted mb-0">Ajusta los filtros para ampliar la búsqueda del inventario.</p>
                </div>
            <?php else: ?>
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead style="background:#f8fafc;">
                            <tr>
                                <th class="border-0 pl-4">Propiedad</th>
                                <th class="border-0">Ubicación</th>
                                <th class="border-0">Precio</th>
                                <th class="border-0">Asignada</th>
                                <th class="border-0 text-right pr-4">Acción</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $propiedades; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $propiedad): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php
                                    $cover = $propiedad->foto_portada ? asset('assets/' . ltrim($propiedad->foto_portada, '/')) : asset('vendor/adminlte/dist/img/AdminLTELogo.png');
                                ?>
                                <tr>
                                    <td class="pl-4">
                                        <div class="d-flex align-items-center">
                                            <img src="<?php echo e($cover); ?>" alt="<?php echo e($propiedad->titulo); ?>" class="rounded mr-3" style="width:72px; height:54px; object-fit:cover;">
                                            <div>
                                                <div class="font-weight-bold text-dark"><?php echo e($propiedad->titulo); ?></div>
                                                <div class="small text-muted">#<?php echo e($propiedad->id); ?> · <?php echo e($propiedad->referencia ?? 'Sin referencia'); ?></div>
                                            </div>
                                        </div>
                                    </td>
                                    <td><?php echo e($propiedad->zona ?: 'Sin zona'); ?></td>
                                    <td>
                                        <div class="font-weight-bold"><?php echo e($moneda); ?> <?php echo e(number_format($propiedad->precio)); ?></div>
                                        <div class="small text-muted"><?php echo e($propiedad->metraje ? number_format($propiedad->metraje) . ' m²' : 'Metraje no disponible'); ?></div>
                                    </td>
                                    <td><?php echo e($propiedad->asignada_a ?: 'Sin asignar'); ?></td>
                                    <td class="text-right pr-4">
                                        <a target="_blank" class="btn btn-outline-secondary btn-sm" href="<?php echo e(url('/admin/vercualquierpropiedad/' . $propiedad->id)); ?>" role="button">
                                            <i class="fas fa-eye mr-1"></i> Ver ficha
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                </div>
                <div class="px-4 py-3 border-top">
                    <?php echo e($propiedades->links()); ?>

                </div>
            <?php endif; ?>
        </div>
    </div>
</div>
<?php /**PATH D:\xampp3\htdocs\realestate_dev\resources\views\livewire\mostrar-inventario.blade.php ENDPATH**/ ?>