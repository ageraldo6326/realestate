<?php $__env->startSection('title', 'Detalle de propiedad'); ?>

<?php $__env->startSection('breadcrumb'); ?>
    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('access-admin')): ?>
        <li class="breadcrumb-item"><a href="<?php echo e(route('poraprobar')); ?>">Aprobar propiedades</a></li>
    <?php else: ?>
        <li class="breadcrumb-item"><a href="<?php echo e(route('propiedades.index')); ?>">Propiedades</a></li>
    <?php endif; ?>
    <li class="breadcrumb-item active">Detalle</li>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('page_title', 'Detalle de propiedad'); ?>

<?php $__env->startSection('content'); ?>
    <?php
        $resolveImage = static function ($value): string {
            $fallback = asset('assets/prop-apto-1.jpg');
            if (blank($value)) return $fallback;
            if (\Illuminate\Support\Str::startsWith($value, ['http://', 'https://', '//', 'data:'])) return $value;
            if (\Illuminate\Support\Str::startsWith($value, ['/img/', '/assets/', 'img/', 'assets/'])) return asset(ltrim($value, '/'));
            return asset('assets/' . ltrim($value, '/'));
        };
        $approved = (bool) $propiedad->aprobada;
        $currentUser = auth()->user();
        $canManageApproval = $currentUser ? $currentUser->can('access-admin') : false;
        $returnUrl = $canManageApproval ? route('poraprobar') : route('propiedades.index');
        $returnLabel = $canManageApproval ? 'Volver a revisión' : 'Volver a propiedades';
        $gallery = collect([$propiedad->foto1, $propiedad->foto2, $propiedad->foto3, $propiedad->foto4, $propiedad->foto5, $propiedad->foto6, $propiedad->foto7, $propiedad->foto8])->filter();
        $location = collect([$propiedad->zona, $propiedad->direccion])->filter()->implode(', ');
        $description = \App\Support\PropertyDescriptionSanitizer::sanitize($propiedad->descripcion);
    ?>

    <div class="container-fluid property-review py-4">
        <header class="property-review__hero">
            <div>
                <a href="<?php echo e($returnUrl); ?>" class="property-review__back"><i class="fas fa-arrow-left" aria-hidden="true"></i> <?php echo e($returnLabel); ?></a>
                <p class="property-review__reference"><?php echo e($propiedad->referencia ?: 'ID ' . $propiedad->id); ?></p>
                <h1><?php echo e($propiedad->titulo ?: 'Propiedad sin título'); ?></h1>
                <p class="property-review__location"><i class="fas fa-map-marker-alt" aria-hidden="true"></i> <?php echo e($location ?: 'Ubicación no registrada'); ?></p>
            </div>
            <div class="property-review__actions">
                <span class="property-review__badge <?php echo e($approved ? 'is-approved' : 'is-pending'); ?>"><i class="fas <?php echo e($approved ? 'fa-check-circle' : 'fa-clock'); ?>" aria-hidden="true"></i> <?php echo e($approved ? 'Aprobada' : 'Pendiente de aprobación'); ?></span>
                <?php if($canManageApproval): ?>
                    <a href="<?php echo e(route('editarpendientes', $propiedad->id)); ?>" class="btn btn-light"><i class="fas fa-pen mr-1" aria-hidden="true"></i> Editar propiedad</a>
                <?php endif; ?>
            </div>
        </header>

        <div class="row mt-4">
            <div class="col-lg-8 mb-4">
                <div class="card border-0 shadow-sm property-review__card overflow-hidden">
                    <img src="<?php echo e($resolveImage($propiedad->foto_portada)); ?>" class="property-review__cover" alt="Portada de <?php echo e($propiedad->titulo); ?>" onerror="this.onerror=null;this.src='<?php echo e(asset('assets/prop-apto-1.jpg')); ?>';">
                    <div class="card-body p-4">
                        <h2>Resumen de la propiedad</h2>
                        <p class="property-review__short-description"><?php echo e($propiedad->descripcion_corta ?: 'No hay resumen registrado.'); ?></p>
                        <?php if($description !== ''): ?>
                            <div class="property-review__description"><?php echo $description; ?></div>
                        <?php endif; ?>
                    </div>
                </div>

                <?php if($gallery->isNotEmpty()): ?>
                    <section class="card border-0 shadow-sm property-review__card mt-4">
                        <div class="card-body p-4"><h2>Galería</h2><div class="property-review__gallery"><?php $__currentLoopData = $gallery; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $image): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><img src="<?php echo e($resolveImage($image)); ?>" alt="Imagen adicional de <?php echo e($propiedad->titulo); ?>" onerror="this.parentElement.remove();"><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?></div></div>
                    </section>
                <?php endif; ?>
            </div>
            <aside class="col-lg-4">
                <section class="card border-0 shadow-sm property-review__card mb-4"><div class="card-body p-4"><h2>Datos comerciales</h2><dl class="property-review__data"><div><dt>Precio</dt><dd><?php echo e($propiedad->Moneda ?: 'RD$'); ?> <?php echo e(is_numeric($propiedad->precio) ? number_format($propiedad->precio, 2) : 'No registrado'); ?></dd></div><div><dt>Disponible para</dt><dd><?php echo e($propiedad->disponible_para ?: 'No registrado'); ?></dd></div><div><dt>Tipo</dt><dd><?php echo e($propiedad->tipo ?: 'No registrado'); ?></dd></div><div><dt>Registrada</dt><dd><?php echo e(optional($propiedad->created_at)->format('d/m/Y H:i') ?: 'No disponible'); ?></dd></div></dl></div></section>
                <section class="card border-0 shadow-sm property-review__card"><div class="card-body p-4"><h2>Características</h2><dl class="property-review__data property-review__data--features"><div><dt>Habitaciones</dt><dd><?php echo e($propiedad->habitaciones ?: '—'); ?></dd></div><div><dt>Baños</dt><dd><?php echo e($propiedad->banos ?: '—'); ?></dd></div><div><dt>Parqueos</dt><dd><?php echo e($propiedad->parqueos ?: '—'); ?></dd></div><div><dt>Metraje</dt><dd><?php echo e($propiedad->metraje ? $propiedad->metraje . ' m²' : '—'); ?></dd></div></dl></div></section>
            </aside>
        </div>
    </div>

    <style>
        .property-review{--ink:#17343a;--teal:#1c4f59;--amber:#804311;color:var(--ink)}.property-review__hero{display:flex;align-items:flex-end;justify-content:space-between;gap:1.5rem;padding:1.6rem;border-radius:.9rem;background:linear-gradient(120deg,#12343b,#1c4f59);color:#fff}.property-review__back{display:inline-flex;gap:.45rem;align-items:center;color:#d9ecef;font-size:.9rem}.property-review__back:hover{color:#fff}.property-review__reference{margin:1rem 0 .2rem;color:#c4dcdf;font-size:.8rem;font-weight:700}.property-review h1{margin:0;font-size:clamp(1.5rem,3vw,2.25rem);font-weight:700}.property-review__location{margin:.45rem 0 0;color:#e5f0f1}.property-review__actions{display:flex;align-items:center;flex-wrap:wrap;gap:.6rem}.property-review__badge{display:inline-flex;align-items:center;gap:.35rem;padding:.45rem .7rem;border-radius:99px;font-size:.84rem;font-weight:700}.property-review__badge.is-approved{background:#dff4e8;color:#0d5130}.property-review__badge.is-pending{background:#fff0dd;color:var(--amber)}.property-review__card{border-radius:.85rem}.property-review__cover{width:100%;height:min(48vw,450px);object-fit:cover;background:#eef3f4}.property-review h2{margin:0 0 1rem;font-size:1.1rem;font-weight:700}.property-review__short-description{font-size:1.03rem;color:#425b61}.property-review__description{line-height:1.75;color:#344b50}.property-review__description p,.property-review__description ul,.property-review__description ol,.property-review__description blockquote{margin:0 0 1rem}.property-review__description h1,.property-review__description h2,.property-review__description h3,.property-review__description h4{margin:1.5rem 0 .75rem}.property-review__description>:last-child{margin-bottom:0}.property-review__gallery{display:grid;grid-template-columns:repeat(auto-fit,minmax(140px,1fr));gap:.75rem}.property-review__gallery img{width:100%;height:120px;object-fit:cover;border-radius:.55rem}.property-review__data{display:grid;grid-template-columns:1fr 1fr;gap:1rem;margin:0}.property-review__data div{padding-bottom:.8rem;border-bottom:1px solid #e6edef}.property-review__data dt{font-size:.75rem;color:#627579}.property-review__data dd{margin:.2rem 0 0;font-weight:700;overflow-wrap:anywhere}.property-review__data--features dd{font-size:1.1rem}@media(max-width:575.98px){.property-review__hero{display:grid;padding:1.2rem}.property-review__actions{width:100%}.property-review__actions .btn{flex:1}.property-review__cover{height:250px}.property-review__data{gap:.75rem}.property-review__data div{min-width:0}}
    </style>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layoutadmin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xampp3\htdocs\realestate_dev\resources\views\admin\propiedades\revision.blade.php ENDPATH**/ ?>