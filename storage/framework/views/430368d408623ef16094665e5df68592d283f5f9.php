

<?php $__env->startSection('content'); ?>
    <div class="container-fluid report-page">
        <div class="report-shell">
            <div class="report-shell__header">
                <h1 class="report-shell__title">Top 10 clicks por propiedad</h1>
                <p class="report-shell__subtitle">Ranking de propiedades con mayor interes para priorizar seguimiento
                    comercial.</p>
            </div>

            <div class="report-shell__body">
                <form id="propiedadesclick" action="<?php echo e(route('propiedadesclick')); ?>" method="GET">
                    <div class="report-toolbar">
                        <div class="report-toolbar__item">
                            <label for="periodo">Periodo</label>
                            <select class="form-control" name="periodo" id="periodo">
                                <option <?php if($periodo == 'Ultimos 30 dias' || $periodo == ''): ?> selected <?php endif; ?> value="Ultimos 30 dias">Ultimos 30
                                    dias</option>
                                <option <?php if($periodo == 'Esta semana'): ?> selected <?php endif; ?> value="Esta semana">Esta semana
                                </option>
                                <option <?php if($periodo == 'La semana pasada'): ?> selected <?php endif; ?> value="La semana pasada">La semana
                                    pasada</option>
                                <option <?php if($periodo == 'Este mes'): ?> selected <?php endif; ?> value="Este mes">Este mes</option>
                                <option <?php if($periodo == 'Mes pasado'): ?> selected <?php endif; ?> value="Mes pasado">Mes pasado
                                </option>
                            </select>
                        </div>
                    </div>
                </form>

                <div class="report-kpis">
                    <div class="report-kpi">
                        <p class="report-kpi__label">Clicks totales</p>
                        <p class="report-kpi__value"><?php echo e(collect($data)->sum()); ?></p>
                    </div>
                    <div class="report-kpi">
                        <p class="report-kpi__label">Propiedades en ranking</p>
                        <p class="report-kpi__value"><?php echo e(collect($labels)->count()); ?></p>
                    </div>
                </div>

                <?php if(collect($data)->isEmpty()): ?>
                    <div class="report-empty">No se registran clicks para el periodo seleccionado.</div>
                <?php else: ?>
                    <div class="report-chart-wrap">
                        <canvas id="propiedadesClickChart" height="110"></canvas>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('js'); ?>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        (function() {
            const periodSelect = document.getElementById('periodo');
            const form = document.getElementById('propiedadesclick');
            const canvas = document.getElementById('propiedadesClickChart');

            if (periodSelect && form) {
                periodSelect.addEventListener('change', function() {
                    form.submit();
                });
            }

            if (!canvas) {
                return;
            }

            const labels = <?php echo json_encode(array_values((array) $labels), 15, 512) ?>;
            const values = <?php echo json_encode(array_values((array) $data), 15, 512) ?>;
            const color = '#1d4ed8';

            new Chart(canvas.getContext('2d'), {
                type: 'bar',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Clicks',
                        data: values,
                        backgroundColor: color,
                        borderRadius: 8,
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                precision: 0
                            }
                        }
                    }
                }
            });
        })();
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layoutadmin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xampp3\htdocs\realestate_dev\resources\views/estadisticas/propiedadesclicks.blade.php ENDPATH**/ ?>