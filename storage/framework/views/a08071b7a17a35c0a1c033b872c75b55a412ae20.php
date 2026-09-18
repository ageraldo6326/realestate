<?php $__env->startSection('title', 'SEO e indexación'); ?>

<?php $__env->startSection('breadcrumb'); ?>
    <li class="breadcrumb-item">Configuración</li>
    <li class="breadcrumb-item active">SEO e indexación</li>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('page_title', 'SEO e indexación'); ?>

<?php $__env->startSection('content'); ?>
    <?php if(session('status')): ?>
        <div class="alert alert-success" role="status"><?php echo e(session('status')); ?></div>
    <?php endif; ?>

    <div class="d-flex flex-wrap align-items-center justify-content-between mb-3">
        <p class="text-muted mb-2 mb-md-0">Auditoría interna de URLs canónicas, elegibilidad y sitemap dinámico.</p>
        <form method="POST" action="<?php echo e(route('seo-audit.run')); ?>">
            <?php echo csrf_field(); ?>
            <button class="btn btn-primary" type="submit"><i class="fas fa-sync-alt mr-1" aria-hidden="true"></i> Ejecutar auditoría</button>
        </form>
    </div>

    <div class="row">
        <?php $__currentLoopData = [['Verdes', $summary['green'], 'success'], ['Advertencias', $summary['yellow'], 'warning'], ['Bloqueadas', $summary['red'], 'danger'], ['En sitemap', $summary['in_sitemap'], 'info']]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $card): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="col-sm-6 col-lg-3">
                <div class="small-box bg-<?php echo e($card[2]); ?>">
                    <div class="inner"><h3><?php echo e($card[1]); ?></h3><p><?php echo e($card[0]); ?></p></div>
                    <div class="icon"><i class="fas fa-search" aria-hidden="true"></i></div>
                </div>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>

    <div class="card card-outline card-primary">
        <div class="card-header">
            <h2 class="card-title">Resultados por URL</h2>
            <?php if($summary['last_run']): ?>
                <span class="float-right text-muted text-sm">Última auditoría: <?php echo e($summary['last_run']->finished_at->format('d/m/Y H:i')); ?></span>
            <?php endif; ?>
        </div>
        <div class="card-body">
            <form method="GET" class="form-row mb-3" aria-label="Filtros de auditoría SEO">
                <div class="col-md-3"><label for="seo-type">Tipo</label><select id="seo-type" name="type" class="form-control"><option value="">Todos</option><?php $__currentLoopData = ['page' => 'Página', 'property' => 'Propiedad', 'zone' => 'Zona', 'post' => 'Artículo']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><option value="<?php echo e($value); ?>" @selected(request('type') === $value)><?php echo e($label); ?></option><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?></select></div>
                <div class="col-md-3"><label for="seo-status">Estado</label><select id="seo-status" name="status" class="form-control"><option value="">Todos</option><?php $__currentLoopData = ['green' => 'Verde', 'yellow' => 'Advertencia', 'red' => 'Bloqueado']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><option value="<?php echo e($value); ?>" @selected(request('status') === $value)><?php echo e($label); ?></option><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?></select></div>
                <div class="col-md-3"><label for="seo-severity">Severidad</label><select id="seo-severity" name="severity" class="form-control"><option value="">Todas</option><?php $__currentLoopData = ['critical' => 'Crítica', 'high' => 'Alta', 'medium' => 'Media', 'low' => 'Baja']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><option value="<?php echo e($value); ?>" @selected(request('severity') === $value)><?php echo e($label); ?></option><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?></select></div>
                <div class="col-md-3 d-flex align-items-end"><button class="btn btn-outline-primary" type="submit">Filtrar</button></div>
            </form>

            <div class="table-responsive">
                <table class="table table-hover">
                    <thead><tr><th>URL</th><th>Tipo</th><th>Estado</th><th>Índice</th><th>Sitemap</th><th>Hallazgos</th></tr></thead>
                    <tbody>
                    <?php $__empty_1 = true; $__currentLoopData = $results; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $result): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr>
                            <td><a href="<?php echo e($result->canonical_url); ?>" target="_blank" rel="noopener noreferrer"><?php echo e(\Illuminate\Support\Str::limit($result->canonical_url, 58)); ?></a><small class="d-block text-muted"><?php echo e($result->entity_title); ?></small></td>
                            <td><?php echo e(['page' => 'Página', 'property' => 'Propiedad', 'zone' => 'Zona', 'post' => 'Artículo'][$result->auditable_type] ?? $result->auditable_type); ?></td>
                            <td><span class="badge badge-<?php echo e($result->status === 'green' ? 'success' : ($result->status === 'yellow' ? 'warning' : 'danger')); ?>"><?php echo e($result->status); ?></span></td>
                            <td><?php echo e($result->is_indexable ? 'Sí' : 'No'); ?></td><td><?php echo e($result->is_in_sitemap ? 'Sí' : 'No'); ?></td>
                            <td><?php $__empty_2 = true; $__currentLoopData = $result->findings; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $finding): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_2 = false; ?><span class="badge badge-light border mr-1"><?php echo e($finding->rule_code); ?></span><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_2): ?><span class="text-muted">Sin hallazgos</span><?php endif; ?></td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr><td colspan="6" class="text-center text-muted py-4">Todavía no hay resultados. Ejecuta una auditoría.</td></tr>
                    <?php endif; ?>
                    </tbody>
                </table>
            </div>
            <?php echo e($results->links()); ?>

        </div>
    </div>

    <?php if($lastSitemap): ?>
        <p class="text-muted text-sm">Sitemap vigente: <?php echo e($lastSitemap->url_count); ?> URLs, host <?php echo e($lastSitemap->canonical_host); ?>, generado <?php echo e($lastSitemap->generated_at->format('d/m/Y H:i')); ?>.</p>
    <?php endif; ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layoutadmin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xampp3\htdocs\realestate_dev\resources\views/admin/seo-audit/index.blade.php ENDPATH**/ ?>