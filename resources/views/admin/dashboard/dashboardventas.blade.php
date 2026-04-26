@extends('admin.layoutadmin')

@section('title', 'Reporte de ventas')
@section('page_title', 'Reporte de ventas')

@section('content')
@php
    $cantidadVentas = (int) ($ventas->CantidadVentas ?? 0);
    $montoVendido = (float) ($ventas->TotalMontoVentas ?? 0);
    $totalComisiones = (float) ($ventas->TotalComisiones ?? 0);
    $ventaMaxima = (float) ($ventas->VentaMaxima ?? 0);
    $promedioDias = (int) ceil((float) ($ventas->promedioTiempoEnDias ?? 0));
    $rangoActual = trim((string) $fi) . ' - ' . trim((string) $ff);
    $cardStyles = ['bg-info', 'bg-success', 'bg-warning', 'bg-danger', 'bg-gradient-blue'];
    $defaultAdvisorAvatar = asset('vendor/adminlte/dist/img/AdminLTELogo.png');
@endphp

<div class="container-fluid report-page">
    <div class="report-shell">
        <div class="report-shell__header">
            <h1 class="report-shell__title">Dashboard de ventas</h1>
            <p class="report-shell__subtitle">
                Analiza conversiones, rendimiento y montos por periodo para tomar decisiones comerciales con mayor precision.
            </p>
        </div>

        <div class="report-shell__body">
            <form id="dashboard" method="GET" action="{{ route('dashboardventas') }}" class="report-toolbar">
                <div class="report-toolbar__item">
                    <label for="periodo">Periodo</label>
                    <select class="form-control" name="periodo" id="periodo">
                        <option @if ((string) $periodo === (string) date('Y') || $periodo == '') selected @endif value="{{ date('Y') }}">{{ date('Y') }}</option>
                        <option @if ($periodo == 'Mes pasado') selected @endif value="Mes pasado">Mes pasado</option>
                        <option @if ($periodo == 'Ultimo trimestre') selected @endif value="Ultimo trimestre">Ultimo trimestre</option>
                        <option @if ($periodo == 'Ultimo semestre') selected @endif value="Ultimo semestre">Ultimo semestre</option>
                        <option @if ($periodo == 'Ano pasado') selected @endif value="Ano pasado">Ano pasado</option>
                    </select>
                </div>
                <div class="report-toolbar__item d-flex align-items-end">
                    <div class="w-100 report-kpi">
                        <p class="report-kpi__label">Rango analizado</p>
                        <p class="report-kpi__value mb-0">{{ $rangoActual }}</p>
                    </div>
                </div>
            </form>

            <div class="row">
                <div class="col-lg-2 col-md-4 col-6">
                    <div class="small-box {{ $cardStyles[0] }}">
                        <div class="inner">
                            <h3>{{ number_format($cantidadVentas) }}</h3>
                            <p>Cantidad de ventas</p>
                        </div>
                        <div class="icon"><i class="ion ion-android-home"></i></div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-4 col-6">
                    <div class="small-box {{ $cardStyles[1] }}">
                        <div class="inner">
                            <h3>{{ number_format($montoVendido) }}</h3>
                            <p>Monto vendido</p>
                        </div>
                        <div class="icon"><i class="ion ion-stats-bars"></i></div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-4 col-6">
                    <div class="small-box {{ $cardStyles[2] }}">
                        <div class="inner">
                            <h3>{{ number_format($totalComisiones) }}</h3>
                            <p>Total comisiones</p>
                        </div>
                        <div class="icon"><i class="ion ion-android-checkbox"></i></div>
                    </div>
                </div>
                <div class="col-lg-2 col-md-6 col-6">
                    <div class="small-box {{ $cardStyles[3] }}">
                        <div class="inner">
                            <h3>{{ number_format($ventaMaxima) }}</h3>
                            <p>Venta maxima</p>
                        </div>
                        <div class="icon"><i class="ion ion-star"></i></div>
                    </div>
                </div>
                <div class="col-lg-2 col-md-6 col-12">
                    <div class="small-box {{ $cardStyles[4] }}">
                        <div class="inner">
                            <h3>{{ number_format($promedioDias) }}</h3>
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
                        @forelse ($ventas_por_asesores as $ventas_por_asesor)
                            <div class="col-md-4 col-12 mb-3">
                                <div class="report-kpi text-center h-100 d-flex flex-column justify-content-center">
                                    <img
                                        class="img-circle mx-auto mb-2"
                                        src="{{ $ventas_por_asesor->foto ?: $defaultAdvisorAvatar }}"
                                        alt="{{ $ventas_por_asesor->nombre_asesor }}"
                                        style="width: 70px; height: 70px; object-fit: cover;"
                                    >
                                    <p class="mb-1 font-weight-600">{{ $ventas_por_asesor->nombre_asesor }}</p>
                                    <p class="report-kpi__value mb-0">{{ number_format($ventas_por_asesor->TotalVentas) }}</p>
                                </div>
                            </div>
                        @empty
                            <div class="col-12">
                                <div class="report-empty">No hay datos de asesores para el periodo seleccionado.</div>
                            </div>
                        @endforelse
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
                        @forelse ($ventas_por_asesores_monto as $ventas_por_asesor_monto)
                            <div class="col-md-4 col-12 mb-3">
                                <div class="report-kpi text-center h-100 d-flex flex-column justify-content-center">
                                    <img
                                        class="img-circle mx-auto mb-2"
                                        src="{{ $ventas_por_asesor_monto->foto ?: $defaultAdvisorAvatar }}"
                                        alt="{{ $ventas_por_asesor_monto->nombre_asesor }}"
                                        style="width: 70px; height: 70px; object-fit: cover;"
                                    >
                                    <p class="mb-1 font-weight-600">{{ $ventas_por_asesor_monto->nombre_asesor }}</p>
                                    <p class="report-kpi__value mb-0">{{ number_format($ventas_por_asesor_monto->TotalVentas) }}</p>
                                </div>
                            </div>
                        @empty
                            <div class="col-12">
                                <div class="report-empty">No hay datos de monto por asesor para el periodo seleccionado.</div>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </section>
    </div>
</div>
@endsection

@push('scripts')
<script>
    (() => {
        const colorPalette = ['#0ea5e9', '#22c55e', '#f59e0b', '#ef4444', '#8b5cf6', '#14b8a6', '#f97316'];

        Chart.register(ChartDataLabels);

        const labelsFuenteVentas = @json($labels_fuente_de_las_ventas);
        const dataFuenteVentas = @json($data_fuente_de_las_ventas);

        const labelsZonaVentas = @json($labels_zona_de_las_ventas);
        const dataZonaVentas = @json($data_zona_de_las_ventas);

        const labelsVentasMes = @json($labels_ventas_por_mes);
        const dataVentasMes = @json($data_ventas_por_mes);

        const labelsTipoVentas = @json($labels_tipo_de_las_ventas);
        const dataTipoVentas = @json($data_tipo_de_las_ventas);

        const labelsEstadoVentas = @json($labels_estado_de_las_ventas);
        const dataEstadoVentas = @json($data_estado_de_las_ventas);

        const labelsVentasMesMonto = @json($labels_ventas_por_mes_monto);
        const dataVentasMesMonto = @json($data_ventas_por_mes_monto);

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
@endpush
