@extends('admin.layoutadmin')

@section('title', 'SEO e indexación')

@section('breadcrumb')
    <li class="breadcrumb-item">Configuración</li>
    <li class="breadcrumb-item active">SEO e indexación</li>
@endsection

@section('page_title', 'SEO e indexación')

@section('content')
    @if (session('status'))
        <div class="alert alert-success" role="status">{{ session('status') }}</div>
    @endif

    <div class="d-flex flex-wrap align-items-center justify-content-between mb-3">
        <p class="text-muted mb-2 mb-md-0">Auditoría interna de URLs canónicas, elegibilidad y sitemap dinámico.</p>
        <form method="POST" action="{{ route('seo-audit.run') }}">
            @csrf
            <button class="btn btn-primary" type="submit"><i class="fas fa-sync-alt mr-1" aria-hidden="true"></i> Ejecutar auditoría</button>
        </form>
    </div>

    <div class="row">
        @foreach ([['Verdes', $summary['green'], 'success'], ['Advertencias', $summary['yellow'], 'warning'], ['Bloqueadas', $summary['red'], 'danger'], ['En sitemap', $summary['in_sitemap'], 'info']] as $card)
            <div class="col-sm-6 col-lg-3">
                <div class="small-box bg-{{ $card[2] }}">
                    <div class="inner"><h3>{{ $card[1] }}</h3><p>{{ $card[0] }}</p></div>
                    <div class="icon"><i class="fas fa-search" aria-hidden="true"></i></div>
                </div>
            </div>
        @endforeach
    </div>

    <div class="card card-outline card-primary">
        <div class="card-header">
            <h2 class="card-title">Resultados por URL</h2>
            @if ($summary['last_run'])
                <span class="float-right text-muted text-sm">Última auditoría: {{ $summary['last_run']->finished_at->format('d/m/Y H:i') }}</span>
            @endif
        </div>
        <div class="card-body">
            <form method="GET" class="form-row mb-3" aria-label="Filtros de auditoría SEO">
                <div class="col-md-3"><label for="seo-type">Tipo</label><select id="seo-type" name="type" class="form-control"><option value="">Todos</option>@foreach (['page' => 'Página', 'property' => 'Propiedad', 'zone' => 'Zona', 'post' => 'Artículo'] as $value => $label)<option value="{{ $value }}" @selected(request('type') === $value)>{{ $label }}</option>@endforeach</select></div>
                <div class="col-md-3"><label for="seo-status">Estado</label><select id="seo-status" name="status" class="form-control"><option value="">Todos</option>@foreach (['green' => 'Verde', 'yellow' => 'Advertencia', 'red' => 'Bloqueado'] as $value => $label)<option value="{{ $value }}" @selected(request('status') === $value)>{{ $label }}</option>@endforeach</select></div>
                <div class="col-md-3"><label for="seo-severity">Severidad</label><select id="seo-severity" name="severity" class="form-control"><option value="">Todas</option>@foreach (['critical' => 'Crítica', 'high' => 'Alta', 'medium' => 'Media', 'low' => 'Baja'] as $value => $label)<option value="{{ $value }}" @selected(request('severity') === $value)>{{ $label }}</option>@endforeach</select></div>
                <div class="col-md-3 d-flex align-items-end"><button class="btn btn-outline-primary" type="submit">Filtrar</button></div>
            </form>

            <div class="table-responsive">
                <table class="table table-hover">
                    <thead><tr><th>URL</th><th>Tipo</th><th>Estado</th><th>Índice</th><th>Sitemap</th><th>Hallazgos</th></tr></thead>
                    <tbody>
                    @forelse ($results as $result)
                        <tr>
                            <td><a href="{{ $result->canonical_url }}" target="_blank" rel="noopener noreferrer">{{ \Illuminate\Support\Str::limit($result->canonical_url, 58) }}</a><small class="d-block text-muted">{{ $result->entity_title }}</small></td>
                            <td>{{ ['page' => 'Página', 'property' => 'Propiedad', 'zone' => 'Zona', 'post' => 'Artículo'][$result->auditable_type] ?? $result->auditable_type }}</td>
                            <td><span class="badge badge-{{ $result->status === 'green' ? 'success' : ($result->status === 'yellow' ? 'warning' : 'danger') }}">{{ $result->status }}</span></td>
                            <td>{{ $result->is_indexable ? 'Sí' : 'No' }}</td><td>{{ $result->is_in_sitemap ? 'Sí' : 'No' }}</td>
                            <td>@forelse($result->findings as $finding)<span class="badge badge-light border mr-1">{{ $finding->rule_code }}</span>@empty<span class="text-muted">Sin hallazgos</span>@endforelse</td>
                        </tr>
                    @empty
                        <tr><td colspan="6" class="text-center text-muted py-4">Todavía no hay resultados. Ejecuta una auditoría.</td></tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
            {{ $results->links() }}
        </div>
    </div>

    @if ($lastSitemap)
        <p class="text-muted text-sm">Sitemap vigente: {{ $lastSitemap->url_count }} URLs, host {{ $lastSitemap->canonical_host }}, generado {{ $lastSitemap->generated_at->format('d/m/Y H:i') }}.</p>
    @endif
@endsection
