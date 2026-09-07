

<?php $__env->startSection('content'); ?>
    <div class="container-fluid report-page">
        <div class="report-shell">
            <div class="report-shell__header">
                <h1 class="report-shell__title">Tareas por categoria</h1>
                <p class="report-shell__subtitle">Distribucion de tareas por tipo para detectar carga operativa del equipo.
                </p>
            </div>

            <div class="report-shell__body">
                <form id="tareasporcategorias" action="<?php echo e(route('tareasporcategorias')); ?>" method="GET">
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
                        <p class="report-kpi__label">Total tareas</p>
                        <p class="report-kpi__value"><?php echo e(collect($data)->sum()); ?></p>
                    </div>
                    <div class="report-kpi">
                        <p class="report-kpi__label">Categorias</p>
                        <p class="report-kpi__value"><?php echo e(collect($labels)->count()); ?></p>
                    </div>
                </div>

                <?php if(collect($data)->isEmpty()): ?>
                    <div class="report-empty">No hay tareas registradas para el periodo seleccionado.</div>
                <?php else: ?>
                    <div class="report-chart-wrap">
                        <canvas id="tareasCategoriasChart" height="110"></canvas>
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
            const form = document.getElementById('tareasporcategorias');
            const canvas = document.getElementById('tareasCategoriasChart');
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
            const colors = ['#1d4ed8', '#0f766e', '#f59e0b', '#ef4444', '#8b5cf6', '#0891b2', '#16a34a'];

            new Chart(canvas.getContext('2d'), {
                type: 'pie',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Tareas por categoria',
                        data: values,
                        backgroundColor: labels.map((_, i) => colors[i % colors.length])
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'bottom'
                        }
                    }
                }
            });
        })();
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layoutadmin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xampp3\htdocs\realestate_dev\resources\views/estadisticas/tareasporcategorias.blade.php ENDPATH**/ ?>