

<?php $__env->startSection('title', 'Dashboard Asesor'); ?>

<?php $__env->startSection('breadcrumb'); ?>
    <li class="breadcrumb-item active">Dashboard Asesor</li>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('page_title', 'Mi Dashboard'); ?>

<?php $__env->startSection('page_actions'); ?>
    <a href="<?php echo e(route('clientes.index')); ?>" class="btn btn-outline-primary btn-sm">
        <i class="fas fa-users mr-1"></i> Mis contactos
    </a>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>

<div class="container-fluid px-3">

    <?php
        $pctAltas = $contactos->CantidadContactos > 0
            ? number_format($contactos_altas->CantidadContactos / $contactos->CantidadContactos * 100)
            : 0;
    ?>

    
    <div class="row mt-3 mb-2">
        <div class="col-12">
            <div class="card border-0" style="background:rgba(37,99,235,.04);">
                <div class="card-body py-2 px-3 d-flex flex-wrap align-items-center" style="gap:.75rem;">
                    <i class="fas fa-calendar-alt text-primary mr-1"></i>
                    <span class="font-weight-600 text-sm mr-2">Período:</span>
                    <form id="dashboard" method="GET" action="<?php echo e(route('dashboardasesor')); ?>" class="d-flex align-items-center" style="gap:.5rem;">
                        <select class="form-control form-control-sm" name="periodo" id="periodo" style="min-width:160px;">
                            <option <?php if($periodo == date('Y')): ?> selected <?php endif; ?> value="<?php echo e(date('Y')); ?>"><?php echo e(date('Y')); ?></option>
                            <option <?php if($periodo == 'Mes pasado'): ?> selected <?php endif; ?> value="Mes pasado">Mes pasado</option>
                            <option <?php if($periodo == 'Ultimo trimestre'): ?> selected <?php endif; ?> value="Ultimo trimestre">Último trimestre</option>
                            <option <?php if($periodo == 'Ultimo semestre'): ?> selected <?php endif; ?> value="Ultimo semestre">Último semestre</option>
                            <option <?php if($periodo == 'Ano pasado'): ?> selected <?php endif; ?> value="Ano pasado">Año pasado</option>
                        </select>
                    </form>
                    <?php if($fi && $ff): ?>
                        <span class="badge badge-light border text-muted" style="font-size:.78rem;padding:.3rem .6rem;">
                            <i class="fas fa-clock mr-1"></i><?php echo e($fi); ?> → <?php echo e($ff); ?>

                        </span>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    
    <div class="row">

        <div class="col-6 col-md-4 col-xl-2 mb-3">
            <div class="card border-0 h-100">
                <div class="card-body d-flex align-items-center p-3">
                    <div class="rounded-circle d-flex align-items-center justify-content-center mr-3 flex-shrink-0"
                        style="width:46px;height:46px;background:rgba(37,99,235,.12);">
                        <i class="fas fa-handshake" style="color:#2563eb;font-size:1rem;"></i>
                    </div>
                    <div>
                        <div class="h4 mb-0 font-weight-700"><?php echo e($ventas->CantidadVentas ?? 0); ?></div>
                        <div class="text-xs text-muted font-weight-500 text-uppercase">Ventas</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-6 col-md-4 col-xl-2 mb-3">
            <div class="card border-0 h-100">
                <div class="card-body d-flex align-items-center p-3">
                    <div class="rounded-circle d-flex align-items-center justify-content-center mr-3 flex-shrink-0"
                        style="width:46px;height:46px;background:rgba(16,185,129,.12);">
                        <i class="fas fa-dollar-sign" style="color:#10b981;font-size:1rem;"></i>
                    </div>
                    <div>
                        <div class="h4 mb-0 font-weight-700" style="font-size:1rem;"><?php echo e(number_format($ventas->TotalMontoVentas ?? 0)); ?></div>
                        <div class="text-xs text-muted font-weight-500 text-uppercase">Monto vendido</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-6 col-md-4 col-xl-2 mb-3">
            <div class="card border-0 h-100">
                <div class="card-body d-flex align-items-center p-3">
                    <div class="rounded-circle d-flex align-items-center justify-content-center mr-3 flex-shrink-0"
                        style="width:46px;height:46px;background:rgba(245,158,11,.12);">
                        <i class="fas fa-percentage" style="color:#f59e0b;font-size:1rem;"></i>
                    </div>
                    <div>
                        <div class="h4 mb-0 font-weight-700" style="font-size:1rem;"><?php echo e(number_format($ventas->TotalComisiones ?? 0)); ?></div>
                        <div class="text-xs text-muted font-weight-500 text-uppercase">Comisiones</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-6 col-md-4 col-xl-2 mb-3">
            <div class="card border-0 h-100">
                <div class="card-body d-flex align-items-center p-3">
                    <div class="rounded-circle d-flex align-items-center justify-content-center mr-3 flex-shrink-0"
                        style="width:46px;height:46px;background:rgba(139,92,246,.12);">
                        <i class="fas fa-chart-bar" style="color:#8b5cf6;font-size:1rem;"></i>
                    </div>
                    <div>
                        <div class="h4 mb-0 font-weight-700" style="font-size:1rem;"><?php echo e(number_format($ventas->VentaPromedio ?? 0)); ?></div>
                        <div class="text-xs text-muted font-weight-500 text-uppercase">Precio prom.</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-6 col-md-4 col-xl-2 mb-3">
            <div class="card border-0 h-100">
                <div class="card-body d-flex align-items-center p-3">
                    <div class="rounded-circle d-flex align-items-center justify-content-center mr-3 flex-shrink-0"
                        style="width:46px;height:46px;background:rgba(239,68,68,.12);">
                        <i class="fas fa-trophy" style="color:#ef4444;font-size:1rem;"></i>
                    </div>
                    <div>
                        <div class="h4 mb-0 font-weight-700" style="font-size:1rem;"><?php echo e(number_format($ventas->VentaMaxima ?? 0)); ?></div>
                        <div class="text-xs text-muted font-weight-500 text-uppercase">Venta máxima</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-6 col-md-4 col-xl-2 mb-3">
            <div class="card border-0 h-100">
                <div class="card-body d-flex align-items-center p-3">
                    <div class="rounded-circle d-flex align-items-center justify-content-center mr-3 flex-shrink-0"
                        style="width:46px;height:46px;background:rgba(6,182,212,.12);">
                        <i class="fas fa-calendar-check" style="color:#06b6d4;font-size:1rem;"></i>
                    </div>
                    <div>
                        <div class="h4 mb-0 font-weight-700"><?php echo e(ceil($ventas->promedioTiempoEnDias ?? 0)); ?></div>
                        <div class="text-xs text-muted font-weight-500 text-uppercase">Días/venta prom.</div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    
    <div class="row mb-2">

        <div class="col-6 col-md-3 mb-3">
            <div class="card border-0 h-100">
                <div class="card-body d-flex align-items-center p-3">
                    <div class="rounded-circle d-flex align-items-center justify-content-center mr-3 flex-shrink-0"
                        style="width:46px;height:46px;background:rgba(37,99,235,.12);">
                        <i class="fas fa-users" style="color:#2563eb;font-size:1rem;"></i>
                    </div>
                    <div>
                        <div class="h4 mb-0 font-weight-700"><?php echo e($contactos->CantidadContactos ?? 0); ?></div>
                        <div class="text-xs text-muted font-weight-500 text-uppercase">Contactos</div>
                    </div>
                </div>
                <div class="card-footer bg-transparent border-top px-3 py-2">
                    <a href="<?php echo e(route('clientes.index')); ?>" class="text-xs text-primary">
                        Ver todos <i class="fas fa-arrow-right ml-1"></i>
                    </a>
                </div>
            </div>
        </div>

        <div class="col-6 col-md-3 mb-3">
            <div class="card border-0 h-100">
                <div class="card-body d-flex align-items-center p-3">
                    <div class="rounded-circle d-flex align-items-center justify-content-center mr-3 flex-shrink-0"
                        style="width:46px;height:46px;background:rgba(16,185,129,.12);">
                        <i class="fas fa-star" style="color:#10b981;font-size:1rem;"></i>
                    </div>
                    <div>
                        <div class="h4 mb-0 font-weight-700"><?php echo e($pctAltas); ?>%</div>
                        <div class="text-xs text-muted font-weight-500 text-uppercase">Prob. altas</div>
                    </div>
                </div>
                <div class="card-footer bg-transparent border-top px-3 py-2">
                    <span class="text-xs text-success">
                        <i class="fas fa-user-check mr-1"></i><?php echo e($contactos_altas->CantidadContactos ?? 0); ?> contactos
                    </span>
                </div>
            </div>
        </div>

    </div>

    
    <div class="row">

        <div class="col-lg-6 mb-3">
            <div class="card border-0 h-100">
                <div class="card-header border-bottom d-flex justify-content-between align-items-center">
                    <span class="font-weight-600">
                        <i class="fas fa-chart-pie mr-1 text-primary"></i> Ventas por medio y zona
                    </span>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-6 text-center">
                            <div class="text-xs text-muted font-weight-600 text-uppercase mb-2">Medios</div>
                            <canvas id="myChart1"></canvas>
                        </div>
                        <div class="col-6 text-center">
                            <div class="text-xs text-muted font-weight-600 text-uppercase mb-2">Zonas</div>
                            <canvas id="myChart2"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-6 mb-3">
            <div class="card border-0 h-100">
                <div class="card-header border-bottom d-flex justify-content-between align-items-center">
                    <span class="font-weight-600">
                        <i class="fas fa-chart-bar mr-1 text-info"></i> Cantidad de ventas por mes
                    </span>
                </div>
                <div class="card-body">
                    <canvas id="myChart3"></canvas>
                </div>
            </div>
        </div>

    </div>

    
    <div class="row">

        <div class="col-lg-6 mb-3">
            <div class="card border-0 h-100">
                <div class="card-header border-bottom d-flex justify-content-between align-items-center">
                    <span class="font-weight-600">
                        <i class="fas fa-chart-pie mr-1 text-warning"></i> Ventas por tipo y estado
                    </span>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-6 text-center">
                            <div class="text-xs text-muted font-weight-600 text-uppercase mb-2">Tipos</div>
                            <canvas id="myChart4"></canvas>
                        </div>
                        <div class="col-6 text-center">
                            <div class="text-xs text-muted font-weight-600 text-uppercase mb-2">Estado</div>
                            <canvas id="myChart5"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-6 mb-3">
            <div class="card border-0 h-100">
                <div class="card-header border-bottom d-flex justify-content-between align-items-center">
                    <span class="font-weight-600">
                        <i class="fas fa-dollar-sign mr-1 text-success"></i> Monto vendido por mes
                    </span>
                </div>
                <div class="card-body">
                    <canvas id="myChart6"></canvas>
                </div>
            </div>
        </div>

    </div>
    <script type="text/javascript">
        Chart.register(ChartDataLabels);

        const PALETTE = ['#2563eb','#10b981','#f59e0b','#ef4444','#8b5cf6','#06b6d4','#f97316','#84cc16'];

        function pieConfig(labels, data, type) {
            return {
                type: type || 'pie',
                data: {
                    labels: labels,
                    datasets: [{ backgroundColor: PALETTE, borderWidth: 1, borderColor: '#fff', data: data }]
                },
                options: {
                    plugins: {
                        legend: { display: true, position: 'bottom', labels: { boxWidth: 12, padding: 8, font: { size: 11 } } },
                        datalabels: {
                            anchor: 'center', align: 'center', color: 'white',
                            font: { weight: 'bold', size: 13 },
                            formatter: v => v > 0 ? v.toLocaleString() : ''
                        }
                    }
                }
            };
        }

        function barConfig(labels, data, label) {
            return {
                type: 'bar',
                data: {
                    labels: labels,
                    datasets: [{
                        label: label,
                        backgroundColor: PALETTE,
                        borderRadius: 4,
                        data: data
                    }]
                },
                options: {
                    plugins: {
                        legend: { display: false },
                        datalabels: {
                            anchor: 'end', align: 'top', color: '#374151',
                            font: { weight: '600', size: 11 },
                            formatter: v => v > 0 ? v.toLocaleString() : ''
                        }
                    },
                    scales: { y: { beginAtZero: true, grid: { color: '#f3f4f6' } }, x: { grid: { display: false } } }
                }
            };
        }

        new Chart(document.getElementById('myChart1'), pieConfig(
            <?php echo e(Js::from($labels_fuente_de_las_ventas)); ?>,
            <?php echo e(Js::from($data_fuente_de_las_ventas)); ?>

        ));

        new Chart(document.getElementById('myChart2'), pieConfig(
            <?php echo e(Js::from($labels_zona_de_las_ventas)); ?>,
            <?php echo e(Js::from($data_zona_de_las_ventas)); ?>

        ));

        new Chart(document.getElementById('myChart3'), barConfig(
            <?php echo e(Js::from($labels_ventas_por_mes)); ?>,
            <?php echo e(Js::from($data_ventas_por_mes)); ?>,
            '# de ventas'
        ));

        new Chart(document.getElementById('myChart4'), pieConfig(
            <?php echo e(Js::from($labels_tipo_de_las_ventas)); ?>,
            <?php echo e(Js::from($data_tipo_de_las_ventas)); ?>,
            'doughnut'
        ));

        new Chart(document.getElementById('myChart5'), pieConfig(
            <?php echo e(Js::from($labels_estado_de_las_ventas)); ?>,
            <?php echo e(Js::from($data_estado_de_las_ventas)); ?>,
            'doughnut'
        ));

        new Chart(document.getElementById('myChart6'), barConfig(
            <?php echo e(Js::from($labels_ventas_por_mes_monto)); ?>,
            <?php echo e(Js::from($data_ventas_por_mes_monto)); ?>,
            '$ vendido'
        ));
    </script>

</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
    $(document).ready(function () {
        $('#periodo').change(function () {
            $('#dashboard').submit();
        });
    });
</script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('admin.layoutadmin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xampp3\htdocs\realestate_dev\resources\views\admin\dashboard\dashboardasesor.blade.php ENDPATH**/ ?>