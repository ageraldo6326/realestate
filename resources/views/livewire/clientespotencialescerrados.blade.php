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
                    <option @if ($periodo == 'Ultimos 30 dias') selected @endif value="Ultimos 30 dias">Ultimos 30 dias
                    </option>
                    <option @if ($periodo == 'Esta semana') selected @endif value="Esta semana">Esta semana</option>
                    <option @if ($periodo == 'La semana pasada') selected @endif value="La semana pasada">La semana pasada
                    </option>
                    <option @if ($periodo == 'Este mes') selected @endif value="Este mes">Este mes</option>
                    <option @if ($periodo == 'Mes pasado') selected @endif value="Mes pasado">Mes pasado</option>
                </select>
            </div>
        </div>

        <div class="report-kpis">
            <div class="report-kpi">
                <p class="report-kpi__label">Total cierres</p>
                <p class="report-kpi__value">{{ collect($data)->sum() }}</p>
            </div>
            <div class="report-kpi">
                <p class="report-kpi__label">Fechas con cierre</p>
                <p class="report-kpi__value">{{ collect($labels)->count() }}</p>
            </div>
        </div>

        @if (collect($data)->isEmpty())
            <div class="report-empty">No hay cierres para el periodo seleccionado.</div>
        @else
            <div class="report-chart-wrap">
                <canvas id="clientesCerradosChart" height="120"></canvas>
            </div>
        @endif
    </div>

    @once
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    @endonce

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

            renderChart(@json(array_values((array) $labels)), @json(array_values((array) $data)));

            Livewire.on('actualizarComponenteMes', (labels, values) => {
                renderChart(labels || [], values || []);
            });
        });
    </script>
</div>
