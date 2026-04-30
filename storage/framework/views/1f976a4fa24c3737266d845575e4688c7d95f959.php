<div>
    <?php
        $propertyPlaceholder = asset('assets/prop-apto-1.jpg');
        $personPlaceholder = asset('vendor/adminlte/dist/img/user2-160x160.jpg');
    ?>

    <!-- FILTROS DE BÚSQUEDA -->
    <div class="lw-search-form mb-4">
        <div class="row g-3 align-items-end">

            <div class="col-md-3 col-sm-6">
                <label class="form-label lw-label" for="lw-provincia">Provincia</label>
                <select id="lw-provincia" class="form-select lw-select" wire:model="provincia_id_criterio">
                    <option value="">Todas las provincias</option>
                    <?php $__currentLoopData = $provincias; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $provincia): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($provincia->id); ?>"><?php echo e($provincia->provincia); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>

            <div class="col-md-3 col-sm-6">
                <label class="form-label lw-label" for="lw-sector-barrio">Sector</label>
                <select id="lw-sector-barrio" class="form-select lw-select" wire:model="sector_barrio_criterio">
                    <option value="">Todos los sectores</option>
                    <?php $__currentLoopData = $sectores; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sector): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($sector->id); ?>"><?php echo e($sector->sector); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>

            <div class="col-md-3 col-sm-6">
                <label class="form-label lw-label" for="lw-tipo">Tipo de propiedad</label>
                <select id="lw-tipo" class="form-select lw-select" wire:model="tipo_id_criterio">
                    <option value="">Todos los tipos</option>
                    <?php $__currentLoopData = $tipos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tipo): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($tipo->id); ?>"><?php echo e($tipo->tipo); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>

            <div class="col-md-3 col-sm-6">
                <label class="form-label lw-label" for="lw-precio-ini">Precio mínimo</label>
                <input type="text" id="lw-precio-ini" class="form-control lw-input" placeholder="Ej: 50,000"
                    wire:model.debounce.500ms="precio_inicial">
            </div>

            <div class="col-md-3 col-sm-6">
                <label class="form-label lw-label" for="lw-precio-fin">Precio máximo</label>
                <input type="text" id="lw-precio-fin" class="form-control lw-input" placeholder="Ej: 500,000"
                    wire:model.debounce.500ms="precio_final">
            </div>

        </div>
    </div>

    <!-- INDICADOR DE CARGA: solo durante actualizaciones de filtros -->
    <div wire:loading.delay.shortest
        wire:target="provincia_id_criterio,sector_barrio_criterio,tipo_id_criterio,precio_inicial,precio_final,updatingProvinciaIdCriterio"
        class="lw-loading">
        <div class="spinner-border spinner-border-sm" role="status" style="color:var(--clr-accent)">
            <span class="visually-hidden">Cargando...</span>
        </div>
        <span>Buscando propiedades...</span>
    </div>

    <!-- RESULTADOS -->
    <div wire:loading.class.delay.shortest="lw-results-loading"
        wire:target="provincia_id_criterio,sector_barrio_criterio,tipo_id_criterio,precio_inicial,precio_final">

        <?php if($propiedades->count()): ?>
            <p class="lw-results-count">
                <?php echo e($propiedades->total()); ?> propiedad<?php echo e($propiedades->total() !== 1 ? 'es' : ''); ?>

                encontrada<?php echo e($propiedades->total() !== 1 ? 's' : ''); ?>

            </p>

            <div class="row g-4">
                <?php $__currentLoopData = $propiedades; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $propiedad): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="col-lg-4 col-md-6">
                        <article class="prop-card h-100">
                            <div class="card-img-wrap">
                                <a href="<?php echo e(route('propiedad', $propiedad->slug)); ?>"
                                    aria-label="<?php echo e($propiedad->titulo); ?>">
                                    <img loading="lazy"
                                        src="<?php echo e(!empty($propiedad->foto_portada) ? asset('assets/' . $propiedad->foto_portada) : $propertyPlaceholder); ?>"
                                        onerror="this.onerror=null;this.src='<?php echo e($propertyPlaceholder); ?>';"
                                        alt="<?php echo e($propiedad->titulo); ?>" title="<?php echo e($propiedad->titulo); ?>">
                                </a>

                                <?php $disp = strtolower($propiedad->disponible_para ?? ''); ?>
                                <span class="badge-status <?php echo e(str_contains($disp, 'alquil') ? 'en-alquiler' : ''); ?>">
                                    <?php echo e($propiedad->disponible_para); ?>

                                </span>

                                <span class="price-overlay">
                                    <?php echo e($propiedad->Moneda); ?><?php echo e(number_format($propiedad->precio, 0)); ?>

                                </span>
                            </div>

                            <div class="card-body">
                                <?php
                                    $asesorNombre = $propiedad->asesor_nombre ?: 'Asesor inmobiliario';
                                    $asesorFotoRaw = $propiedad->asesor_foto ?: '';
                                    if (
                                        $asesorFotoRaw &&
                                        \Illuminate\Support\Str::startsWith($asesorFotoRaw, [
                                            'http://',
                                            'https://',
                                            '//',
                                            'data:',
                                        ])
                                    ) {
                                        $asesorFoto = $asesorFotoRaw;
                                    } elseif (
                                        $asesorFotoRaw &&
                                        \Illuminate\Support\Str::startsWith($asesorFotoRaw, [
                                            '/img/',
                                            '/assets/',
                                            'img/',
                                            'assets/',
                                        ])
                                    ) {
                                        $asesorFoto = asset(ltrim($asesorFotoRaw, '/'));
                                    } elseif ($asesorFotoRaw) {
                                        $asesorFoto = asset('assets/' . ltrim($asesorFotoRaw, '/'));
                                    } else {
                                        $asesorFoto = $personPlaceholder;
                                    }
                                ?>
                                <h3 class="card-title mb-0">
                                    <a href="<?php echo e(route('propiedad', $propiedad->slug)); ?>"><?php echo e($propiedad->titulo); ?></a>
                                </h3>

                                <div class="prop-location">
                                    <i class="fas fa-location-dot text-accent"></i>
                                    <span>
                                        <?php echo e($propiedad->ciudad ?: 'Santo Domingo'); ?>,
                                        <?php echo e($propiedad->provincia_nombre); ?>

                                        <?php if($propiedad->barrio_nombre || $propiedad->sector_nombre): ?>
                                            - <?php echo e($propiedad->barrio_nombre ?: $propiedad->sector_nombre); ?>

                                        <?php endif; ?>
                                    </span>
                                </div>

                                <div class="prop-specs">
                                    <?php if($propiedad->habitaciones): ?>
                                        <div class="prop-spec">
                                            <i class="fas fa-bed"></i>
                                            <span><?php echo e($propiedad->habitaciones); ?></span>
                                        </div>
                                    <?php endif; ?>
                                    <?php if($propiedad->banos): ?>
                                        <div class="prop-spec">
                                            <i class="fas fa-bath"></i>
                                            <span><?php echo e($propiedad->banos); ?></span>
                                        </div>
                                    <?php endif; ?>
                                    <?php if($propiedad->metraje): ?>
                                        <div class="prop-spec">
                                            <i class="fas fa-vector-square"></i>
                                            <span><?php echo e($propiedad->metraje); ?> m²</span>
                                        </div>
                                    <?php endif; ?>
                                </div>

                                <div class="d-flex justify-content-between align-items-center mt-2">
                                    <span class="prop-ref">REF: <?php echo e($propiedad->referencia); ?></span>
                                    <?php if($propiedad->asesor_telefono): ?>
                                        <a href="<?php echo e('https://api.whatsapp.com/send/?phone=' . $propiedad->asesor_telefono . '&text=' . urlencode($propiedad->descripcion_corta . ' ' . route('propiedad', $propiedad->slug))); ?>"
                                            target="_blank" rel="noopener noreferrer"
                                            aria-label="Contactar por WhatsApp" class="whatsapp-btn">
                                            <i class="fab fa-whatsapp"></i>
                                        </a>
                                    <?php endif; ?>
                                </div>
                                <div class="d-flex align-items-center mt-3 pt-2 border-top">
                                    <img src="<?php echo e($asesorFoto); ?>" alt="<?php echo e($asesorNombre); ?>" loading="lazy"
                                        onerror="this.onerror=null;this.src='<?php echo e($personPlaceholder); ?>';"
                                        style="width: 34px; height: 34px; border-radius: 50%; object-fit: cover;"
                                        class="mr-2">
                                    <span class="small text-muted">Asesor: <?php echo e($asesorNombre); ?></span>
                                </div>
                            </div>
                        </article>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>

            <!-- PAGINACIÓN -->
            <div class="lw-pagination mt-5">
                <?php echo e($propiedades->links()); ?>

            </div>
        <?php else: ?>
            <div class="lw-empty">
                <i class="fas fa-house-circle-xmark"></i>
                <h4>No se encontraron propiedades</h4>
                <p>Intenta con otros filtros o elimina algunos criterios de búsqueda.</p>
            </div>
        <?php endif; ?>

    </div><!-- /wire:loading.remove -->

    <style>
        .lw-search-form {
            background: #fff;
            border: 1px solid var(--clr-border);
            border-radius: var(--radius);
            padding: 1.5rem;
            box-shadow: var(--shadow-sm)
        }

        .lw-label {
            font-size: .7rem;
            font-weight: 700;
            letter-spacing: .5px;
            text-transform: uppercase;
            color: var(--clr-gray);
            margin-bottom: .3rem;
            display: block
        }

        .lw-select,
        .lw-input {
            border: 1.5px solid var(--clr-border);
            border-radius: var(--radius-sm);
            font-size: .875rem;
            padding: .6rem .85rem;
            color: var(--clr-dark);
            transition: border-color .2s
        }

        .lw-select:focus,
        .lw-input:focus {
            border-color: var(--clr-accent);
            box-shadow: 0 0 0 3px rgba(201, 168, 76, .12);
            outline: none
        }

        .lw-loading {
            display: flex;
            align-items: center;
            gap: .75rem;
            padding: .75rem 0;
            color: var(--clr-gray);
            font-size: .85rem;
            min-height: 2.5rem
        }

        .lw-results-loading {
            opacity: .45;
            pointer-events: none;
            transition: opacity .2s
        }

        .lw-results-count {
            font-size: .82rem;
            color: var(--clr-gray);
            margin-bottom: 1.25rem
        }

        .lw-pagination {
            display: flex;
            justify-content: center
        }

        .lw-pagination .pagination {
            gap: .25rem
        }

        .lw-pagination .page-link {
            border: 1.5px solid var(--clr-border);
            border-radius: var(--radius-sm) !important;
            color: var(--clr-dark);
            font-size: .85rem;
            padding: .45rem .85rem;
            transition: var(--transition)
        }

        .lw-pagination .page-link:hover {
            background: var(--clr-accent);
            border-color: var(--clr-accent);
            color: var(--clr-dark)
        }

        .lw-pagination .page-item.active .page-link {
            background: var(--clr-dark);
            border-color: var(--clr-dark);
            color: #fff
        }

        .lw-empty {
            text-align: center;
            padding: 4rem 2rem;
            color: var(--clr-gray)
        }

        .lw-empty i {
            font-size: 3rem;
            color: var(--clr-accent-lt);
            display: block;
            margin-bottom: 1rem
        }

        .lw-empty h4 {
            font-size: 1.1rem;
            color: var(--clr-dark);
            margin-bottom: .5rem
        }

        .lw-empty p {
            font-size: .88rem
        }
    </style>

</div>
<?php /**PATH D:\xampp3\htdocs\realestate_dev\resources\views/livewire/buscar-propiedades-home.blade.php ENDPATH**/ ?>