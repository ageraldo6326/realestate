<?php $__env->startSection('title', 'Clientes del asesor'); ?>

<?php $__env->startSection('breadcrumb'); ?>
    <li class="breadcrumb-item"><a href="<?php echo e(route('consultaClientesAsesor')); ?>">Clientes por asesor</a></li>
    <li class="breadcrumb-item active">Detalle</li>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('page_title', 'Clientes del asesor'); ?>

<?php $__env->startSection('content'); ?>
    <div class="container-fluid py-3 py-md-4 advisor-client-detail">
        <header class="advisor-client-detail__header">
            <div><a href="<?php echo e(route('consultaClientesAsesor')); ?>" class="advisor-client-detail__back"><i class="fas fa-arrow-left" aria-hidden="true"></i> Volver a la consulta</a><h1>Clientes del asesor</h1><p>Registros entre <?php echo e(\Illuminate\Support\Carbon::parse($fecha_ini)->format('d/m/Y')); ?> y <?php echo e(\Illuminate\Support\Carbon::parse($fecha_fin)->format('d/m/Y')); ?>.</p></div>
            <div class="advisor-client-detail__count"><span>Total de clientes</span><strong><?php echo e(number_format($clientes->count())); ?></strong></div>
        </header>

        <?php $__empty_1 = true; $__currentLoopData = $clientes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cliente): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <article class="advisor-client-detail__card">
                <div class="advisor-client-detail__identity"><span class="advisor-client-detail__avatar" aria-hidden="true"><?php echo e(\Illuminate\Support\Str::upper(\Illuminate\Support\Str::substr($cliente->nombre ?: 'C', 0, 1))); ?></span><div><h2><?php echo e($cliente->nombre ?: 'Cliente sin nombre'); ?></h2><p><?php echo e($cliente->created_at ? $cliente->created_at->format('d/m/Y') : 'Fecha no disponible'); ?></p></div></div>
                <dl class="advisor-client-detail__metadata"><div><dt>Teléfono</dt><dd><?php echo e($cliente->telefono ?: 'No registrado'); ?></dd></div><div><dt>Correo</dt><dd><?php echo e($cliente->email ?: 'No registrado'); ?></dd></div><div><dt>Rango de interés</dt><dd><?php echo e($cliente->precio_mini || $cliente->precio_max ? number_format($cliente->precio_mini ?: 0) . ' – ' . number_format($cliente->precio_max ?: 0) : 'No registrado'); ?></dd></div><div><dt>Contacto</dt><dd><?php echo e($cliente->contact_at ?: 'No registrado'); ?></dd></div></dl>
                <a href="<?php echo e(route('vercliente', $cliente->id)); ?>" class="btn btn-outline-secondary advisor-client-detail__action">Ver ficha</a>
            </article>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <div class="advisor-client-detail__empty" role="status"><i class="fas fa-users" aria-hidden="true"></i><h2>No hay clientes para este asesor</h2><p>Prueba con otro período de consulta.</p><a href="<?php echo e(route('consultaClientesAsesor')); ?>" class="btn btn-outline-primary">Volver a la consulta</a></div>
        <?php endif; ?>
    </div>

    <style>
        .advisor-client-detail{--ink:#17343a;--teal:#0d4c55;--border:#dbe5e7;--muted:#63767a;color:var(--ink)}.advisor-client-detail__header{display:flex;align-items:end;justify-content:space-between;gap:1.5rem;margin-bottom:1.25rem;padding:1.5rem 1.75rem;border-radius:.9rem;background:#0d4c55;color:#fff}.advisor-client-detail__back{display:inline-flex;align-items:center;gap:.4rem;color:#d9ecef;font-size:.9rem}.advisor-client-detail__back:hover{color:#fff}.advisor-client-detail h1{margin:.85rem 0 0;font-size:clamp(1.45rem,3vw,2.15rem);font-weight:700}.advisor-client-detail__header p{margin:.4rem 0 0;color:#e1eff0}.advisor-client-detail__count{min-width:8rem;padding:.25rem 0 .25rem 1rem;border-left:1px solid rgba(255,255,255,.32);text-align:right}.advisor-client-detail__count span,.advisor-client-detail__count strong{display:block}.advisor-client-detail__count span{color:#d2e5e7;font-size:.78rem;font-weight:600}.advisor-client-detail__count strong{font-size:1.65rem}.advisor-client-detail__card{display:grid;grid-template-columns:minmax(210px,.8fr) minmax(0,2fr) 115px;gap:1rem;align-items:center;margin-bottom:.75rem;padding:1rem 1.15rem;border:1px solid var(--border);border-radius:.8rem;background:#fff;box-shadow:0 .2rem .75rem rgba(18,52,59,.045)}.advisor-client-detail__identity{display:flex;align-items:center;gap:.75rem;min-width:0}.advisor-client-detail__avatar{display:grid;flex:none;width:42px;height:42px;place-items:center;border-radius:50%;background:#eaf3f5;color:var(--teal);font-weight:800}.advisor-client-detail h2{margin:0;font-size:1rem}.advisor-client-detail__identity p{margin:.15rem 0 0;color:var(--muted);font-size:.82rem}.advisor-client-detail__metadata{display:grid;grid-template-columns:repeat(2,minmax(0,1fr));gap:.55rem 1rem;margin:0}.advisor-client-detail__metadata dt{color:var(--muted);font-size:.72rem;font-weight:600}.advisor-client-detail__metadata dd{margin:.1rem 0 0;font-size:.84rem;overflow-wrap:anywhere}.advisor-client-detail__action{min-height:44px;display:inline-flex;align-items:center;justify-content:center}.advisor-client-detail__empty{padding:3.5rem 1rem;border:1px dashed #b8c9cd;border-radius:.8rem;background:#fcfdfd;color:var(--muted);text-align:center}.advisor-client-detail__empty i{margin-bottom:.8rem;color:var(--teal);font-size:1.65rem}.advisor-client-detail__empty h2{color:var(--ink);font-size:1.15rem}@media(max-width:991.98px){.advisor-client-detail__card{grid-template-columns:1fr auto}.advisor-client-detail__metadata{grid-column:1/-1}.advisor-client-detail__action{grid-column:2;grid-row:1}}@media(max-width:575.98px){.advisor-client-detail__header{display:block;padding:1.25rem}.advisor-client-detail__count{margin-top:1rem;padding:.7rem 0 0;border-top:1px solid rgba(255,255,255,.32);border-left:0;text-align:left}.advisor-client-detail__card{grid-template-columns:1fr}.advisor-client-detail__metadata{grid-template-columns:1fr}.advisor-client-detail__action{grid-column:1;grid-row:auto;width:100%}}
    </style>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layoutadmin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xampp3\htdocs\realestate_dev\resources\views\consultas\consultaClientesPorAsesorDetalle.blade.php ENDPATH**/ ?>