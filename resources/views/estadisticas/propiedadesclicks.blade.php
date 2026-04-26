@extends('admin.layoutadmin')

@section('content')
    <div class="container-fluid report-page">
        <div class="report-shell">
            <div class="report-shell__header">
                <h1 class="report-shell__title">Top 10 clicks por propiedad</h1>
                <p class="report-shell__subtitle">Ranking de propiedades con mayor interes para priorizar seguimiento comercial.</p>
            </div>

            <div class="report-shell__body">
                <form id="propiedadesclick" action="{{ route('propiedadesclick') }}" method="GET">
                    <div class="report-toolbar">
                        <div class="report-toolbar__item">
                            <label for="periodo">Periodo</label>
                            <select class="form-control" name="periodo" id="periodo">
                                <option @if ($periodo == 'Ultimos 30 dias' || $periodo == '') selected @endif value="Ultimos 30 dias">Ultimos 30 dias</option>
                                <option @if ($periodo == 'Esta semana') selected @endif value="Esta semana">Esta semana</option>
                                <option @if ($periodo == 'La semana pasada') selected @endif value="La semana pasada">La semana pasada</option>
                                <option @if ($periodo == 'Este mes') selected @endif value="Este mes">Este mes</option>
                                <option @if ($periodo == 'Mes pasado') selected @endif value="Mes pasado">Mes pasado</option>
                            </select>
                        </div>
                    </div>
                </form>

                <div class="report-kpis">
                    <div class="report-kpi">
                        <p class="report-kpi__label">Clicks totales</p>
                        <p class="report-kpi__value">{{ collect($data)->sum() }}</p>
                    </div>
                    <div class="report-kpi">
                        <p class="report-kpi__label">Propiedades en ranking</p>
                        <p class="report-kpi__value">{{ collect($labels)->count() }}</p>
                    </div>
                </div>

                @if (collect($data)->isEmpty())
                    <div class="report-empty">No se registran clicks para el periodo seleccionado.</div>
                @else
                    <div class="report-chart-wrap">
                        <canvas id="propiedadesClickChart" height="110"></canvas>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        (function () {
            const periodSelect = document.getElementById('periodo');
            const form = document.getElementById('propiedadesclick');
            const canvas = document.getElementById('propiedadesClickChart');

            if (periodSelect && form) {
                periodSelect.addEventListener('change', function () {
                    form.submit();
                });
            }

            if (!canvas) {
                return;
            }

            const labels = @json(array_values((array) $labels));
            const values = @json(array_values((array) $data));
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
@endsection