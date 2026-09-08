<div>
    <?php
        $propertyPlaceholder = asset('assets/prop-apto-1.jpg');
        $resolvePropertyImage = function ($value, $version = null, $fallback = null) {
            $fallback ??= asset('assets/prop-apto-1.jpg');

            if (empty($value)) {
                return $fallback;
            }

            $appendVersion = function (string $url) use ($version): string {
                if (!$version) {
                    return $url;
                }

                $separator = str_contains($url, '?') ? '&' : '?';

                return $url . $separator . 'v=' . rawurlencode((string) $version);
            };

            if (\Illuminate\Support\Str::startsWith($value, ['http://', 'https://', '//', 'data:'])) {
                return $appendVersion($value);
            }

            if (\Illuminate\Support\Str::startsWith($value, ['/img/', '/assets/', 'img/', 'assets/'])) {
                return $appendVersion(asset(ltrim($value, '/')));
            }

            return $appendVersion(asset('assets/' . ltrim($value, '/')));
        };
    ?>

    <!-- SECTION HEADER -->
    <div class="d-flex align-items-center gap-3 mb-4">
        <div>
            <span class="section-badge">PORTAFOLIO</span>
            <h1 class="section-title mb-0">Propiedades del Agente</h1>
        </div>
    </div>
    <!-- GRID -->
    <div class="row g-4">
        <?php $__empty_2 = true; $__currentLoopData = $propiedades; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $propiedad): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_2 = false; ?>
            <div class="col-lg-4 col-md-6">
                <article class="prop-card h-100">
                    <div class="card-img-wrap">
                        <a href="<?php echo e(route('propiedad', $propiedad->slug)); ?>" aria-label="<?php echo e($propiedad->titulo); ?>">
                            <img loading="lazy"
                                src="<?php echo e($resolvePropertyImage($propiedad->foto_portada, data_get($propiedad, 'updated_at'), $propertyPlaceholder)); ?>"
                                onerror="this.onerror=null;this.src='<?php echo e($propertyPlaceholder); ?>';"
                                alt="<?php echo e($propiedad->titulo); ?>" title="<?php echo e($propiedad->titulo); ?>">
                        </a>
                        <?php $disp = strtolower($propiedad->disponible_para ?? ''); ?>
                        <span
                            class="badge-status <?php echo e(str_contains($disp, 'alquil') ? 'en-alquiler' : ''); ?>"><?php echo e($propiedad->disponible_para); ?></span>
                        <span
                            class="price-overlay"><?php echo e($propiedad->Moneda); ?><?php echo e(number_format($propiedad->precio, 0)); ?></span>
                    </div>
                    <div class="card-body">
                        <h2 class="card-title mb-0">
                            <a href="<?php echo e(route('propiedad', $propiedad->slug)); ?>"><?php echo e($propiedad->titulo); ?></a>
                        </h2>
                        <div class="prop-location">
                            <i class="fas fa-location-dot text-accent"></i>
                            <span><?php echo e($propiedad->zona); ?></span>
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
                                    target="_blank" rel="noopener noreferrer" aria-label="WhatsApp"
                                    class="whatsapp-btn">
                                    <i class="fab fa-whatsapp"></i>
                                </a>
                            <?php endif; ?>
                        </div>
                    </div>
                </article>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_2): ?>
            <div class="col-12">
                <div class="empty-state">
                    <i class="fas fa-house-circle-xmark"></i>
                    <p>Este agente no tiene propiedades publicadas por el momento.</p>
                </div>
            </div>
        <?php endif; ?>
    </div>
    <?php if($propiedades->hasPages()): ?>
        <div class="d-flex justify-content-center mt-5"><?php echo e($propiedades->links('pagination::bootstrap-4')); ?></div>
    <?php endif; ?>
</div>
<?php /**PATH D:\xampp3\htdocs\realestate_dev\resources\views\livewire\propiedades-por-agentes.blade.php ENDPATH**/ ?>