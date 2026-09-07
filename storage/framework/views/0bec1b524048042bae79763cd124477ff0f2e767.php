<div class="report-shell">
    <div class="report-shell__header">
        <h1 class="report-shell__title">Clientes cerrados</h1>
        <p class="report-shell__subtitle">Monitorea cierres por fecha para evaluar conversion de oportunidades.</p>
    </div>

    <div class="report-shell__body">
        <div class="report-toolbar">
            <div class="report-toolbar__item">
                <label for="periodo-clientes-cerrados">Periodo</label>
                <select class="form-control" id="periodo-clientes-cerrados" name="periodo"
                    wire:change="emitActualizar($event.target.value)">
                    <option value="PERIODOS">Seleccionar periodo</option>
                    <option <?php if($periodo == 'Ultimos 30 dias'): ?> selected <?php endif; ?> value="Ultimos 30 dias">Ultimos 30 dias
                    </option>
                    <option <?php if($periodo == 'Esta semana'): ?> selected <?php endif; ?> value="Esta semana">Esta semana</option>
                    <option <?php if($periodo == 'La semana pasada'): ?> selected <?php endif; ?> value="La semana pasada">La semana pasada
                    </option>
                    <option <?php if($periodo == 'Este mes'): ?> selected <?php endif; ?> value="Este mes">Este mes</option>
                    <option <?php if($periodo == 'Mes pasado'): ?> selected <?php endif; ?> value="Mes pasado">Mes pasado</option>
                </select>
            </div>
        </div>

        <div class="report-kpis">
            <div class="report-kpi">
                <p class="report-kpi__label">Total cierres</p>
                <p class="report-kpi__value"><?php echo e(collect($data)->sum()); ?></p>
            </div>
            <div class="report-kpi">
                <p class="report-kpi__label">Fechas con cierre</p>
                <p class="report-kpi__value"><?php echo e(collect($labels)->count()); ?></p>
            </div>
        </div>

        <?php if(collect($data)->isEmpty()): ?>
            <div class="report-empty">No hay cierres para el periodo seleccionado.</div>
        <?php else: ?>
            <div class="report-chart-wrap">
                <canvas id="clientesCerradosChart" height="120"></canvas>
            </div>
        <?php endif; ?>
    </div>

    <?php if (! $__env->hasRenderedOnce('b7737f7e-ed2c-485d-8f7c-196c5520b60b')): $__env->markAsRenderedOnce('b7737f7e-ed2c-485d-8f7c-196c5520b60b'); ?>
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <?php endif; ?>

    <script>
        document.addEventListener('livewire:load', function() {
            const canvas = document.getElementById('clientesCerradosChart');
            if (!canvas) {
                return;
            }

            const palette = ['#0f766e', '#1d4ed8', '#16a34a', '#f59e0b', '#ef4444', '#8b5cf6'];
            let reportChart;

            const buildColors = (count) => Array.from({
                length: count
            }, (_, i) => palette[i % palette.length]);

            const renderChart = (labels, values) => {
                if (reportChart) {
                    reportChart.destroy();
                }

                reportChart = new Chart(canvas.getContext('2d'), {
                    type: 'bar',
                    data: {
                        labels: labels,
                        datasets: [{
                            label: 'Clientes cerrados',
                            data: values,
                            backgroundColor: buildColors(values.length),
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
            };

            renderChart(<?php echo json_encode(array_values((array) $labels), 15, 512) ?>, <?php echo json_encode(array_values((array) $data), 15, 512) ?>);

            Livewire.on('actualizarComponenteMes', (labels, values) => {
                renderChart(labels || [], values || []);
            });
        });
    </script>
</div>
<?php /**PATH D:\xampp3\htdocs\realestate_dev\resources\views/livewire/clientespotencialescerrados.blade.php ENDPATH**/ ?>