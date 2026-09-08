

<?php $__env->startSection('title', 'Reporte de ventas'); ?>
<?php $__env->startSection('page_title', 'Reporte de ventas'); ?>

<?php $__env->startSection('content'); ?>
    <?php
        $cantidadVentas = (int) ($ventas->CantidadVentas ?? 0);
        $montoVendido = (float) ($ventas->TotalMontoVentas ?? 0);
        $totalComisiones = (float) ($ventas->TotalComisiones ?? 0);
        $ventaMaxima = (float) ($ventas->VentaMaxima ?? 0);
        $promedioDias = (int) ceil((float) ($ventas->promedioTiempoEnDias ?? 0));
        $rangoActual = trim((string) $fi) . ' - ' . trim((string) $ff);
        $cardStyles = ['bg-info', 'bg-success', 'bg-warning', 'bg-danger', 'bg-gradient-blue'];
        $defaultAdvisorAvatar = asset('vendor/adminlte/dist/img/AdminLTELogo.png');
    ?>

    <div class="container-fluid report-page">
        <div class="report-shell">
            <div class="report-shell__header">
                <h1 class="report-shell__title">Dashboard de ventas</h1>
                <p class="report-shell__subtitle">
                    Analiza conversiones, rendimiento y montos por periodo para tomar decisiones comerciales con mayor
                    precision.
                </p>
            </div>

            <div class="report-shell__body">
                <form id="dashboard" method="GET" action="<?php echo e(route('dashboardventas')); ?>" class="report-toolbar">
                    <div class="report-toolbar__item">
                        <label for="periodo">Periodo</label>
                        <select class="form-control" name="periodo" id="periodo">
                            <option <?php if((string) $periodo === (string) date('Y') || $periodo == ''): ?> selected <?php endif; ?> value="<?php echo e(date('Y')); ?>">
                                <?php echo e(date('Y')); ?></option>
                            <option <?php if($periodo == 'Mes pasado'): ?> selected <?php endif; ?> value="Mes pasado">Mes pasado</option>
                            <option <?php if($periodo == 'Ultimo trimestre'): ?> selected <?php endif; ?> value="Ultimo trimestre">Ultimo
                                trimestre</option>
                            <option <?php if($periodo == 'Ultimo semestre'): ?> selected <?php endif; ?> value="Ultimo semestre">Ultimo
                                semestre</option>
                            <option <?php if($periodo == 'Ano pasado'): ?> selected <?php endif; ?> value="Ano pasado">Ano pasado</option>
                        </select>
                    </div>
                    <div class="report-toolbar__item d-flex align-items-end">
                        <div class="w-100 report-kpi">
                            <p class="report-kpi__label">Rango analizado</p>
                            <p class="report-kpi__value mb-0"><?php echo e($rangoActual); ?></p>
                        </div>
                    </div>
                </form>

                <div class="row">
                    <div class="col-lg-2 col-md-4 col-6">
                        <div class="small-box <?php echo e($cardStyles[0]); ?>">
                            <div class="inner">
                                <h3><?php echo e(number_format($cantidadVentas)); ?></h3>
                                <p>Cantidad de ventas</p>
                            </div>
                            <div class="icon"><i class="ion ion-android-home"></i></div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-4 col-6">
                        <div class="small-box <?php echo e($cardStyles[1]); ?>">
                            <div class="inner">
                                <h3><?php echo e(number_format($montoVendido)); ?></h3>
                                <p>Monto vendido</p>
                            </div>
                            <div class="icon"><i class="ion ion-stats-bars"></i></div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-4 col-6">
                        <div class="small-box <?php echo e($cardStyles[2]); ?>">
                            <div class="inner">
                                <h3><?php echo e(number_format($totalComisiones)); ?></h3>
                                <p>Total comisiones</p>
                            </div>
                            <div class="icon"><i class="ion ion-android-checkbox"></i></div>
                        </div>
                    </div>
                    <div class="col-lg-2 col-md-6 col-6">
                        <div class="small-box <?php echo e($cardStyles[3]); ?>">
                            <div class="inner">
                                <h3><?php echo e(number_format($ventaMaxima)); ?></h3>
                                <p>Venta maxima</p>
                            </div>
                            <div class="icon"><i class="ion ion-star"></i></div>
                        </div>
                    </div>
                    <div class="col-lg-2 col-md-6 col-12">
                        <div class="small-box <?php echo e($cardStyles[4]); ?>">
                            <div class="inner">
                                <h3><?php echo e(number_format($promedioDias)); ?></h3>
                                <p>Promedio dias por venta</p>
                            </div>
                            <div class="icon"><i class="ion ion-clock"></i></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <section class="col-lg-6 mb-3">
                <div class="card h-100">
                    <div class="card-header d-flex align-items-center justify-content-between">
                        <h3 class="card-title mb-0"><i class="fas fa-chart-pie mr-1"></i>Distribucion de ventas</h3>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6 mb-3 mb-md-0">
                                <h2 class="h6 text-center font-weight-600">Medios</h2>
                                <div class="report-chart-wrap">
                                    <canvas id="myChart1"></canvas>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <h2 class="h6 text-center font-weight-600">Zonas</h2>
                                <div class="report-chart-wrap">
                                    <canvas id="myChart2"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <section class="col-lg-6 mb-3">
                <div class="card h-100">
                    <div class="card-header border-0">
                        <h3 class="card-title mb-0"><i class="fas fa-chart-bar mr-1"></i>Cantidad de ventas por mes</h3>
                    </div>
                    <div class="card-body">
                        <div class="report-chart-wrap">
                            <canvas id="myChart3"></canvas>
                        </div>
                    </div>
                    <div class="card-body pt-0">
                        <h4 class="h6 font-weight-600 mb-3">Top asesores por cantidad</h4>
                        <div class="row">
                            <?php $__empty_1 = true; $__currentLoopData = $ventas_por_asesores; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ventas_por_asesor): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                <div class="col-md-4 col-12 mb-3">
                                    <div class="report-kpi text-center h-100 d-flex flex-column justify-content-center">
                                        <img class="img-circle mx-auto mb-2"
                                            src="<?php echo e($ventas_por_asesor->foto ?: $defaultAdvisorAvatar); ?>"
                                            alt="<?php echo e($ventas_por_asesor->nombre_asesor); ?>"
                                            style="width: 70px; height: 70px; object-fit: cover;">
                                        <p class="mb-1 font-weight-600"><?php echo e($ventas_por_asesor->nombre_asesor); ?></p>
                                        <p class="report-kpi__value mb-0">
                                            <?php echo e(number_format($ventas_por_asesor->TotalVentas)); ?></p>
                                    </div>
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                <div class="col-12">
                                    <div class="report-empty">No hay datos de asesores para el periodo seleccionado.</div>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </section>
        </div>

        <div class="row">
            <section class="col-lg-6 mb-3">
                <div class="card h-100">
                    <div class="card-header d-flex align-items-center justify-content-between">
                        <h3 class="card-title mb-0"><i class="fas fa-chart-pie mr-1"></i>Segmentacion de ventas</h3>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6 mb-3 mb-md-0">
                                <h2 class="h6 text-center font-weight-600">Tipos</h2>
                                <div class="report-chart-wrap">
                                    <canvas id="myChart4"></canvas>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <h2 class="h6 text-center font-weight-600">Estado</h2>
                                <div class="report-chart-wrap">
                                    <canvas id="myChart5"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <section class="col-lg-6 mb-3">
                <div class="card h-100">
                    <div class="card-header border-0">
                        <h3 class="card-title mb-0"><i class="fas fa-money-bill-wave mr-1"></i>Monto vendido por mes</h3>
                    </div>
                    <div class="card-body">
                        <div class="report-chart-wrap">
                            <canvas id="myChart6"></canvas>
                        </div>
                    </div>
                    <div class="card-body pt-0">
                        <h4 class="h6 font-weight-600 mb-3">Top asesores por monto</h4>
                        <div class="row">
                            <?php $__empty_1 = true; $__currentLoopData = $ventas_por_asesores_monto; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ventas_por_asesor_monto): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                <div class="col-md-4 col-12 mb-3">
                                    <div class="report-kpi text-center h-100 d-flex flex-column justify-content-center">
                                        <img class="img-circle mx-auto mb-2"
                                            src="<?php echo e($ventas_por_asesor_monto->foto ?: $defaultAdvisorAvatar); ?>"
                                            alt="<?php echo e($ventas_por_asesor_monto->nombre_asesor); ?>"
                                            style="width: 70px; height: 70px; object-fit: cover;">
                                        <p class="mb-1 font-weight-600"><?php echo e($ventas_por_asesor_monto->nombre_asesor); ?></p>
                                        <p class="report-kpi__value mb-0">
                                            <?php echo e(number_format($ventas_por_asesor_monto->TotalVentas)); ?></p>
                                    </div>
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                <div class="col-12">
                                    <div class="report-empty">No hay datos de monto por asesor para el periodo
                                        seleccionado.</div>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
    <script>
        (() => {
            const colorPalette = ['#0ea5e9', '#22c55e', '#f59e0b', '#ef4444', '#8b5cf6', '#14b8a6', '#f97316'];

            Chart.register(ChartDataLabels);

            const labelsFuenteVentas = <?php echo json_encode($labels_fuente_de_las_ventas, 15, 512) ?>;
            const dataFuenteVentas = <?php echo json_encode($data_fuente_de_las_ventas, 15, 512) ?>;

            const labelsZonaVentas = <?php echo json_encode($labels_zona_de_las_ventas, 15, 512) ?>;
            const dataZonaVentas = <?php echo json_encode($data_zona_de_las_ventas, 15, 512) ?>;

            const labelsVentasMes = <?php echo json_encode($labels_ventas_por_mes, 15, 512) ?>;
            const dataVentasMes = <?php echo json_encode($data_ventas_por_mes, 15, 512) ?>;

            const labelsTipoVentas = <?php echo json_encode($labels_tipo_de_las_ventas, 15, 512) ?>;
            const dataTipoVentas = <?php echo json_encode($data_tipo_de_las_ventas, 15, 512) ?>;

            const labelsEstadoVentas = <?php echo json_encode($labels_estado_de_las_ventas, 15, 512) ?>;
            const dataEstadoVentas = <?php echo json_encode($data_estado_de_las_ventas, 15, 512) ?>;

            const labelsVentasMesMonto = <?php echo json_encode($labels_ventas_por_mes_monto, 15, 512) ?>;
            const dataVentasMesMonto = <?php echo json_encode($data_ventas_por_mes_monto, 15, 512) ?>;

            const numberFormatter = new Intl.NumberFormat('es-DO');

            const basePieOptions = {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            boxWidth: 10,
                            usePointStyle: true,
                        },
                    },
                    datalabels: {
                        color: '#fff',
                        font: {
                            weight: '700',
                            size: 12,
                        },
                        formatter: (value) => value > 0 ? numberFormatter.format(value) : '',
                    },
                },
            };

            const baseBarOptions = {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: (value) => numberFormatter.format(value),
                        },
                    },
                },
                plugins: {
                    legend: {
                        display: false,
                    },
                    datalabels: {
                        anchor: 'end',
                        align: 'top',
                        color: '#0f172a',
                        font: {
                            weight: '700',
                            size: 11,
                        },
                        formatter: (value) => numberFormatter.format(value),
                    },
                },
            };

            const createChart = (chartId, config) => {
                const ctx = document.getElementById(chartId);
                if (!ctx) {
                    return;
                }
                new Chart(ctx, config);
            };

            createChart('myChart1', {
                type: 'pie',
                data: {
                    labels: labelsFuenteVentas,
                    datasets: [{
                        data: dataFuenteVentas,
                        backgroundColor: colorPalette,
                        borderWidth: 0,
                    }],
                },
                options: basePieOptions,
            });

            createChart('myChart2', {
                type: 'pie',
                data: {
                    labels: labelsZonaVentas,
                    datasets: [{
                        data: dataZonaVentas,
                        backgroundColor: colorPalette,
                        borderWidth: 0,
                    }],
                },
                options: basePieOptions,
            });

            createChart('myChart3', {
                type: 'bar',
                data: {
                    labels: labelsVentasMes,
                    datasets: [{
                        label: 'Cantidad de ventas',
                        data: dataVentasMes,
                        backgroundColor: '#0ea5e9',
                        borderRadius: 8,
                    }],
                },
                options: baseBarOptions,
            });

            createChart('myChart4', {
                type: 'doughnut',
                data: {
                    labels: labelsTipoVentas,
                    datasets: [{
                        data: dataTipoVentas,
                        backgroundColor: colorPalette,
                        borderWidth: 0,
                    }],
                },
                options: basePieOptions,
            });

            createChart('myChart5', {
                type: 'doughnut',
                data: {
                    labels: labelsEstadoVentas,
                    datasets: [{
                        data: dataEstadoVentas,
                        backgroundColor: colorPalette,
                        borderWidth: 0,
                    }],
                },
                options: basePieOptions,
            });

            createChart('myChart6', {
                type: 'bar',
                data: {
                    labels: labelsVentasMesMonto,
                    datasets: [{
                        label: 'Monto vendido',
                        data: dataVentasMesMonto,
                        backgroundColor: '#22c55e',
                        borderRadius: 8,
                    }],
                },
                options: baseBarOptions,
            });

            const periodSelect = document.getElementById('periodo');
            const dashboardForm = document.getElementById('dashboard');

            if (periodSelect && dashboardForm) {
                periodSelect.addEventListener('change', () => dashboardForm.submit());
            }
        })();
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('admin.layoutadmin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xampp3\htdocs\realestate_dev\resources\views\admin\dashboard\dashboardventas.blade.php ENDPATH**/ ?>