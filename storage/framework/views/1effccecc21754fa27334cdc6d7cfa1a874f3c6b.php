<div>
    <?php
        $propertyPlaceholder = asset('assets/prop-apto-1.jpg');
    ?>

    <!-- FILTER BAR -->
    <div class="filter-bar">
        <div class="row g-3 align-items-end">
            <div class="col-md-3 col-sm-6">
                <label class="form-label" for="lw-provincia">Provincia</label>
                <select id="lw-provincia" class="form-select" wire:model="provincia_id_criterio">
                    <option value="">Todas las provincias</option>
                    <?php $__currentLoopData = $provincias; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $provincia): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($provincia->id); ?>"><?php echo e($provincia->provincia); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>
            <div class="col-md-3 col-sm-6">
                <label class="form-label" for="lw-sector-barrio">Sector</label>
                <select id="lw-sector-barrio" class="form-select" wire:model="sector_barrio_criterio">
                    <option value="">Todos los sectores</option>
                    <?php $__currentLoopData = $sectores; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sector): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($sector->id); ?>"><?php echo e($sector->sector); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>
            <div class="col-md-3 col-sm-6">
                <label class="form-label" for="lw-tipo">Tipo</label>
                <select id="lw-tipo" class="form-select" wire:model="tipo_id_criterio">
                    <option value="">Todos los tipos</option>
                    <?php $__currentLoopData = $tipos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tipo): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($tipo->id); ?>"><?php echo e($tipo->tipo); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>
            <div class="col-md-3 col-sm-6">
                <label class="form-label" for="lw-min">Precio mínimo</label>
                <input id="lw-min" type="number" class="form-control" placeholder="Desde..."
                    wire:model.debounce.500ms="precio_inicial">
            </div>
            <div class="col-md-3 col-sm-6">
                <label class="form-label" for="lw-max">Precio máximo</label>
                <input id="lw-max" type="number" class="form-control" placeholder="Hasta..."
                    wire:model.debounce.500ms="precio_final">
            </div>
        </div>
    </div>

    <!-- RESULTS COUNT -->
    <div class="d-flex justify-content-between align-items-center mb-3">
        <p class="text-muted mb-0" style="font-size:.875rem">
            <strong><?php echo e($propiedades->total()); ?></strong> propiedades encontradas
        </p>
        <div wire:loading class="text-accent" style="font-size:.8rem">
            <i class="fas fa-spinner fa-spin me-1"></i>Actualizando...
        </div>
    </div>

    <!-- GRID -->
    <div class="row g-4">
        <?php $__empty_1 = true; $__currentLoopData = $propiedades; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $propiedad): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <div class="col-lg-4 col-md-6">
                <article class="prop-card h-100">
                    <div class="card-img-wrap">
                        <a href="<?php echo e(route('propiedad', $propiedad->slug)); ?>" aria-label="<?php echo e($propiedad->titulo); ?>">
                            <img loading="lazy"
                                src="<?php echo e(!empty($propiedad->foto_portada) ? asset('assets/' . $propiedad->foto_portada) : $propertyPlaceholder); ?>"
                                onerror="this.onerror=null;this.src='<?php echo e($propertyPlaceholder); ?>';"
                                alt="<?php echo e($propiedad->titulo); ?>" title="<?php echo e($propiedad->titulo); ?>">
                        </a>
                        <?php $disp = strtolower($propiedad->disponible_para ?? ''); ?>
                        <span class="badge-status <?php echo e(str_contains($disp, 'alquil') ? 'en-alquiler' : ''); ?>">
                            <?php echo e($propiedad->disponible_para); ?>

                        </span>
                        <span
                            class="price-overlay"><?php echo e($propiedad->Moneda); ?><?php echo e(number_format($propiedad->precio, 0)); ?></span>
                    </div>
                    <div class="card-body">
                        <h2 class="card-title mb-0">
                            <a href="<?php echo e(route('propiedad', $propiedad->slug)); ?>"><?php echo e($propiedad->titulo); ?></a>
                        </h2>
                        <div class="prop-location">
                            <i class="fas fa-location-dot text-accent"></i>
                            <span>
                                <?php echo e($propiedad->ciudad ?: 'Santo Domingo'); ?>, <?php echo e($propiedad->provincia_nombre); ?>

                                <?php if($propiedad->barrio_nombre || $propiedad->sector_nombre): ?>
                                    - <?php echo e($propiedad->barrio_nombre ?: $propiedad->sector_nombre); ?>

                                <?php endif; ?>
                            </span>
                        </div>
                        <div class="prop-specs">
                            <?php if($propiedad->habitaciones): ?>
                                <div class="prop-spec"><i
                                        class="fas fa-bed"></i><span><?php echo e($propiedad->habitaciones); ?></span></div>
                            <?php endif; ?>
                            <?php if($propiedad->banos): ?>
                                <div class="prop-spec"><i class="fas fa-bath"></i><span><?php echo e($propiedad->banos); ?></span>
                                </div>
                            <?php endif; ?>
                            <?php if($propiedad->parqueos): ?>
                                <div class="prop-spec"><i
                                        class="fas fa-car"></i><span><?php echo e($propiedad->parqueos); ?></span></div>
                            <?php endif; ?>
                            <?php if($propiedad->metraje): ?>
                                <div class="prop-spec"><i
                                        class="fas fa-vector-square"></i><span><?php echo e($propiedad->metraje); ?> m2</span>
                                </div>
                            <?php endif; ?>
                        </div>
                        <div class="d-flex justify-content-between align-items-center mt-2">
                            <span class="prop-ref">REF: <?php echo e($propiedad->referencia); ?></span>
                            <?php if($propiedad->telefono): ?>
                                <a href="<?php echo e('https://api.whatsapp.com/send/?phone=' . $propiedad->telefono . '&text=' . urlencode(($propiedad->descripcion_corta ?? $propiedad->titulo) . ' ' . route('propiedad', $propiedad->slug))); ?>"
                                    target="_blank" rel="noopener noreferrer" aria-label="Contactar por WhatsApp"
                                    class="whatsapp-btn">
                                    <i class="fab fa-whatsapp"></i>
                                </a>
                            <?php endif; ?>
                        </div>
                    </div>
                </article>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <div class="col-12">
                <div class="empty-state">
                    <i class="fas fa-house-circle-xmark"></i>
                    <p>No encontramos propiedades con esos criterios.<br>Intenta ajustar los filtros.</p>
                </div>
            </div>
        <?php endif; ?>
    </div>

    <!-- PAGINATION -->
    <?php if($propiedades->hasPages()): ?>
        <div class="d-flex justify-content-center mt-5">
            <?php echo e($propiedades->links('pagination::bootstrap-4')); ?>

        </div>
    <?php endif; ?>
</div>
<?php /**PATH D:\xampp3\htdocs\realestate_dev\resources\views/livewire/buscar-propiedades-propiedades.blade.php ENDPATH**/ ?>