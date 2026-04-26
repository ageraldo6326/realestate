<div class="report-shell">
    <div class="report-shell__header">
        <h1 class="report-shell__title">Fuente de clientes</h1>
        <p class="report-shell__subtitle">Distribucion de leads por canal para optimizar captacion comercial.</p>
    </div>

    <div class="report-shell__body">
        <div class="report-toolbar">
            <div class="report-toolbar__item">
                <label for="periodo-fuente-clientes">Periodo</label>
                <select class="form-control" id="periodo-fuente-clientes" name="periodo" wire:change="emitActualizar($event.target.value)">
                    <option value="PERIODOS">Seleccionar periodo</option>
                    <option @if ($periodo == 'Ultimos 30 dias') selected @endif value="Ultimos 30 dias">Ultimos 30 dias</option>
                    <option @if ($periodo == 'Esta semana') selected @endif value="Esta semana">Esta semana</option>
                    <option @if ($periodo == 'La semana pasada') selected @endif value="La semana pasada">La semana pasada</option>
                    <option @if ($periodo == 'Este mes') selected @endif value="Este mes">Este mes</option>
                    <option @if ($periodo == 'Mes pasado') selected @endif value="Mes pasado">Mes pasado</option>
                </select>
            </div>
        </div>

        <div class="report-kpis">
            <div class="report-kpi">
                <p class="report-kpi__label">Total clientes</p>
                <p class="report-kpi__value">{{ collect($data)->sum() }}</p>
            </div>
            <div class="report-kpi">
                <p class="report-kpi__label">Canales activos</p>
                <p class="report-kpi__value">{{ collect($labels)->count() }}</p>
            </div>
        </div>

        @if (collect($data)->isEmpty())
            <div class="report-empty">No hay fuentes registradas para el periodo seleccionado.</div>
        @else
            <div class="report-chart-wrap">
                <canvas id="fuenteClientesChart" height="120"></canvas>
            </div>
        @endif
    </div>

    @once
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    @endonce

    <script>
        document.addEventListener('livewire:load', function () {
            const canvas = document.getElementById('fuenteClientesChart');
            if (!canvas) {
                return;
            }

            const palette = ['#0f766e', '#1d4ed8', '#f97316', '#16a34a', '#7c3aed', '#dc2626', '#0891b2'];
            let reportChart;

            const buildColors = (count) => Array.from({ length: count }, (_, i) => palette[i % palette.length]);

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

            renderChart(@json(array_values((array) $labels)), @json(array_values((array) $data)));

            Livewire.on('actualizarComponenteMes', (labels, values) => {
                renderChart(labels || [], values || []);
            });
        });
    </script>
</div>
  
  
  
  
