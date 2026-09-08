

<?php $__env->startSection('title', 'Dashboard'); ?>

<?php $__env->startSection('breadcrumb'); ?>
    <li class="breadcrumb-item active">Dashboard</li>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('page_title', 'Dashboard'); ?>

<?php $__env->startSection('page_actions'); ?>
    <a href="<?php echo e(route('propiedades.create')); ?>" class="btn btn-primary btn-sm">
        <i class="fas fa-plus mr-1"></i> Nueva propiedad
    </a>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="container-fluid px-3">

        
        <div class="row mt-3">

            <div class="col-6 col-md-3 mb-3">
                <div class="card border-0 h-100">
                    <div class="card-body d-flex align-items-center p-3">
                        <div class="rounded-circle d-flex align-items-center justify-content-center mr-3 flex-shrink-0"
                            style="width:48px;height:48px;background:rgba(37,99,235,.12);">
                            <i class="fas fa-home" style="color:#2563eb;font-size:1.1rem;"></i>
                        </div>
                        <div>
                            <div class="h4 mb-0 font-weight-700"><?php echo e($totalPropiedades); ?></div>
                            <div class="text-xs text-muted font-weight-500 text-uppercase">Mis propiedades</div>
                        </div>
                    </div>
                    <div class="card-footer bg-transparent border-top px-3 py-2 d-flex justify-content-between">
                        <span class="text-xs text-success"><i class="fas fa-check-circle mr-1"></i><?php echo e($propPublicadas); ?>

                            activas</span>
                        <span class="text-xs text-warning"><i class="fas fa-clock mr-1"></i><?php echo e($propPendientes); ?>

                            pendientes</span>
                    </div>
                </div>
            </div>

            <div class="col-6 col-md-3 mb-3">
                <div class="card border-0 h-100">
                    <div class="card-body d-flex align-items-center p-3">
                        <div class="rounded-circle d-flex align-items-center justify-content-center mr-3 flex-shrink-0"
                            style="width:48px;height:48px;background:rgba(16,185,129,.12);">
                            <i class="fas fa-users" style="color:#10b981;font-size:1.1rem;"></i>
                        </div>
                        <div>
                            <div class="h4 mb-0 font-weight-700"><?php echo e($totalContactos); ?></div>
                            <div class="text-xs text-muted font-weight-500 text-uppercase">Contactos totales</div>
                        </div>
                    </div>
                    <div class="card-footer bg-transparent border-top px-3 py-2">
                        <span class="text-xs text-primary"><i class="fas fa-calendar mr-1"></i><?php echo e($contactosMes); ?> este
                            mes</span>
                    </div>
                </div>
            </div>

            <div class="col-6 col-md-3 mb-3">
                <div class="card border-0 h-100">
                    <div class="card-body d-flex align-items-center p-3">
                        <div class="rounded-circle d-flex align-items-center justify-content-center mr-3 flex-shrink-0"
                            style="width:48px;height:48px;background:rgba(245,158,11,.12);">
                            <i class="fas fa-clock" style="color:#f59e0b;font-size:1.1rem;"></i>
                        </div>
                        <div>
                            <div class="h4 mb-0 font-weight-700"><?php echo e($tareasPendientes); ?></div>
                            <div class="text-xs text-muted font-weight-500 text-uppercase">Tareas pendientes</div>
                        </div>
                    </div>
                    <div class="card-footer bg-transparent border-top px-3 py-2">
                        <span class="text-xs text-success"><i class="fas fa-check mr-1"></i><?php echo e($tareasCompletadas); ?>

                            completadas</span>
                    </div>
                </div>
            </div>

            <div class="col-6 col-md-3 mb-3">
                <div class="card border-0 h-100">
                    <div class="card-body d-flex align-items-center p-3">
                        <div class="rounded-circle d-flex align-items-center justify-content-center mr-3 flex-shrink-0"
                            style="width:48px;height:48px;background:rgba(139,92,246,.12);">
                            <i class="fas fa-chart-line" style="color:#8b5cf6;font-size:1.1rem;"></i>
                        </div>
                        <div>
                            <?php
                                $tasa =
                                    $totalContactos > 0
                                        ? round(
                                            ($tareasCompletadas / max($tareasPendientes + $tareasCompletadas, 1)) * 100,
                                        )
                                        : 0;
                            ?>
                            <div class="h4 mb-0 font-weight-700"><?php echo e($tasa); ?>%</div>
                            <div class="text-xs text-muted font-weight-500 text-uppercase">Tareas completadas</div>
                        </div>
                    </div>
                    <div class="card-footer bg-transparent border-top px-3 py-2">
                        <a href="<?php echo e(route('dashboardasesor')); ?>" class="text-xs text-primary">
                            Ver estadísticas <i class="fas fa-arrow-right ml-1"></i>
                        </a>
                    </div>
                </div>
            </div>

        </div>

        
        <div class="row mb-3">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <i class="fas fa-bolt mr-2 text-warning"></i> Accesos rápidos
                    </div>
                    <div class="card-body py-2">
                        <div class="d-flex flex-wrap gap-2" style="gap:.5rem">
                            <a href="<?php echo e(route('propiedades.create')); ?>" class="btn btn-outline-primary btn-sm">
                                <i class="fas fa-plus mr-1"></i> Nueva propiedad
                            </a>
                            <a href="<?php echo e(route('clientes.create')); ?>" class="btn btn-outline-success btn-sm">
                                <i class="fas fa-user-plus mr-1"></i> Nuevo contacto
                            </a>
                            <a href="<?php echo e(route('todo.create')); ?>" class="btn btn-outline-warning btn-sm">
                                <i class="fas fa-tasks mr-1"></i> Nueva tarea
                            </a>
                            <a href="<?php echo e(route('calendario')); ?>" class="btn btn-outline-info btn-sm">
                                <i class="fas fa-calendar-alt mr-1"></i> Ver agenda
                            </a>
                            <a href="<?php echo e(route('dashboardasesor')); ?>" class="btn btn-outline-secondary btn-sm">
                                <i class="fas fa-chart-bar mr-1"></i> Mis estadísticas
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        
        <div class="row">
            <div class="col-md-6 mb-3">
                <div class="card h-100">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <span><i class="fas fa-home mr-2 text-primary"></i>Últimas propiedades</span>
                        <a href="<?php echo e(route('propiedades.index')); ?>" class="btn btn-xs btn-outline-primary"
                            style="font-size:.72rem;padding:.15rem .5rem;">Ver todas</a>
                    </div>
                    <div class="card-body p-0">
                        <?php if($ultimasPropiedades->isEmpty()): ?>
                            <div class="text-center py-4 text-muted text-sm">
                                <i class="fas fa-home fa-2x mb-2 d-block"></i>Sin propiedades registradas
                            </div>
                        <?php else: ?>
                            <div class="table-responsive">
                                <table class="table mb-0">
                                    <thead>
                                        <tr>
                                            <th>Propiedad</th>
                                            <th>Precio</th>
                                            <th>Estado</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $__currentLoopData = $ultimasPropiedades; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $prop): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <tr>
                                                <td>
                                                    <a href="<?php echo e(route('propiedades.edit', $prop->id)); ?>"
                                                        class="font-weight-500 text-dark text-decoration-none">
                                                        <?php echo e(Str::limit($prop->titulo, 30)); ?>

                                                    </a>
                                                    <div class="text-xs text-muted"><?php echo e($prop->tipo ?? '—'); ?></div>
                                                </td>
                                                <td class="text-sm"><?php echo e(number_format($prop->precio)); ?></td>
                                                <td>
                                                    <?php if($prop->activa): ?>
                                                        <span class="badge badge-success">Activa</span>
                                                    <?php else: ?>
                                                        <span class="badge badge-secondary">Pendiente</span>
                                                    <?php endif; ?>
                                                </td>
                                            </tr>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </tbody>
                                </table>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <div class="col-md-6 mb-3">
                <div class="card h-100">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <span><i class="fas fa-users mr-2 text-success"></i>Últimos contactos</span>
                        <a href="<?php echo e(route('clientes.index')); ?>" class="btn btn-xs btn-outline-success"
                            style="font-size:.72rem;padding:.15rem .5rem;">Ver todos</a>
                    </div>
                    <div class="card-body p-0">
                        <?php if($ultimosContactos->isEmpty()): ?>
                            <div class="text-center py-4 text-muted text-sm">
                                <i class="fas fa-users fa-2x mb-2 d-block"></i>Sin contactos registrados
                            </div>
                        <?php else: ?>
                            <div class="table-responsive">
                                <table class="table mb-0">
                                    <thead>
                                        <tr>
                                            <th>Nombre</th>
                                            <th>Teléfono</th>
                                            <th>Tipo</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $__currentLoopData = $ultimosContactos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cliente): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <tr>
                                                <td>
                                                    <a href="<?php echo e(route('vercliente', $cliente->id)); ?>"
                                                        class="font-weight-500 text-dark text-decoration-none">
                                                        <?php echo e($cliente->nombre); ?>

                                                    </a>
                                                    <div class="text-xs text-muted">
                                                        <?php echo e($cliente->created_at->diffForHumans()); ?></div>
                                                </td>
                                                <td class="text-sm"><?php echo e($cliente->telefono ?? '—'); ?></td>
                                                <td>
                                                    <span class="badge badge-info" style="font-size:.68rem;">
                                                        <?php echo e($cliente->tipo_contacto ?? '—'); ?>

                                                    </span>
                                                </td>
                                            </tr>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </tbody>
                                </table>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>

    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layoutadmin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xampp3\htdocs\realestate_dev\resources\views\admin\adminlte\dashboard.blade.php ENDPATH**/ ?>