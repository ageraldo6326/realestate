@extends('admin.layoutadmin')

@section('content')
    <div class="container-fluid report-page">
        <div class="report-shell">
            <div class="report-shell__header">
                <h1 class="report-shell__title">Tareas por categoria</h1>
                <p class="report-shell__subtitle">Distribucion de tareas por tipo para detectar carga operativa del equipo.
                </p>
            </div>

            <div class="report-shell__body">
                <form id="tareasporcategorias" action="{{ route('tareasporcategorias') }}" method="GET">
                    <div class="report-toolbar">
                        <div class="report-toolbar__item">
                            <label for="periodo">Periodo</label>
                            <select class="form-control" name="periodo" id="periodo">
                                <option @if ($periodo == 'Ultimos 30 dias' || $periodo == '') selected @endif value="Ultimos 30 dias">Ultimos 30
                                    dias</option>
                                <option @if ($periodo == 'Esta semana') selected @endif value="Esta semana">Esta semana
                                </option>
                                <option @if ($periodo == 'La semana pasada') selected @endif value="La semana pasada">La semana
                                    pasada</option>
                                <option @if ($periodo == 'Este mes') selected @endif value="Este mes">Este mes</option>
                                <option @if ($periodo == 'Mes pasado') selected @endif value="Mes pasado">Mes pasado
                                </option>
                            </select>
                        </div>
                    </div>
                </form>

                <div class="report-kpis">
                    <div class="report-kpi">
                        <p class="report-kpi__label">Total tareas</p>
                        <p class="report-kpi__value">{{ collect($data)->sum() }}</p>
                    </div>
                    <div class="report-kpi">
                        <p class="report-kpi__label">Categorias</p>
                        <p class="report-kpi__value">{{ collect($labels)->count() }}</p>
                    </div>
                </div>

                @if (collect($data)->isEmpty())
                    <div class="report-empty">No hay tareas registradas para el periodo seleccionado.</div>
                @else
                    <div class="report-chart-wrap">
                        <canvas id="tareasCategoriasChart" height="110"></canvas>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection

@section('js')
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

            const labels = @json(array_values((array) $labels));
            const values = @json(array_values((array) $data));
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
@endsection
