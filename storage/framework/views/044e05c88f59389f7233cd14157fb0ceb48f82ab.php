<div class="report-shell">
    <div class="report-shell__header">
        <h1 class="report-shell__title">Fuente de clientes</h1>
        <p class="report-shell__subtitle">Distribucion de leads por canal para optimizar captacion comercial.</p>
    </div>

    <div class="report-shell__body">
        <div class="report-toolbar">
            <div class="report-toolbar__item">
                <label for="periodo-fuente-clientes">Periodo</label>
                <select class="form-control" id="periodo-fuente-clientes" name="periodo"
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
                <p class="report-kpi__label">Total clientes</p>
                <p class="report-kpi__value"><?php echo e(collect($data)->sum()); ?></p>
            </div>
            <div class="report-kpi">
                <p class="report-kpi__label">Canales activos</p>
                <p class="report-kpi__value"><?php echo e(collect($labels)->count()); ?></p>
            </div>
        </div>

        <?php if(collect($data)->isEmpty()): ?>
            <div class="report-empty">No hay fuentes registradas para el periodo seleccionado.</div>
        <?php else: ?>
            <div class="report-chart-wrap">
                <canvas id="fuenteClientesChart" height="120"></canvas>
            </div>
        <?php endif; ?>
    </div>

    <?php if (! $__env->hasRenderedOnce('a778aadd-1561-478a-a3b7-eacf09426699')): $__env->markAsRenderedOnce('a778aadd-1561-478a-a3b7-eacf09426699'); ?>
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <?php endif; ?>

    <script>
        document.addEventListener('livewire:load', function() {
            const canvas = document.getElementById('fuenteClientesChart');
            if (!canvas) {
                return;
            }

            const palette = ['#0f766e', '#1d4ed8', '#f97316', '#16a34a', '#7c3aed', '#dc2626', '#0891b2'];
            let reportChart;

            const buildColors = (count) => Array.from({
                length: count
            }, (_, i) => palette[i % palette.length]);

            const renderChart = (labels, values) => {
                if (reportChart) {
                    reportChart.destroy();
                }

                reportChart = new Chart(canvas.getContext('2d'), {
                    type: 'doughnut',
                    data: {
                        labels: labels,
                        datasets: [{
                            label: 'Fuente de clientes',
                            data: values,
                            backgroundColor: buildColors(values.length),
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                display: true,
                                position: 'bottom'
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
<?php /**PATH D:\xampp3\htdocs\realestate_dev\resources\views\livewire\fuenteclientes.blade.php ENDPATH**/ ?>