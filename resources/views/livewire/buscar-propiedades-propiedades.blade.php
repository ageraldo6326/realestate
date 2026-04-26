<div>
    <!-- FILTER BAR -->
    <div class="filter-bar">
        <div class="row g-3 align-items-end">
            <div class="col-md-3 col-sm-6">
                <label class="form-label" for="lw-zona">Zona</label>
                <select id="lw-zona" class="form-select" wire:model="zona_id_criterio">
                    <option value="">Todas las zonas</option>
                    @foreach ($zonas as $zona)
                        <option value="{{ $zona->id }}">{{ $zona->zona }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3 col-sm-6">
                <label class="form-label" for="lw-tipo">Tipo</label>
                <select id="lw-tipo" class="form-select" wire:model="tipo_id_criterio">
                    <option value="">Todos los tipos</option>
                    @foreach ($tipos as $tipo)
                        <option value="{{ $tipo->id }}">{{ $tipo->tipo }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3 col-sm-6">
                <label class="form-label" for="lw-min">Precio mínimo</label>
                <input id="lw-min" type="number" class="form-control" placeholder="Desde..."
                    wire:model.debounce.500ms="precio_inicial">
            </div>
            <div class="col-md-3 col-sm-6">
                <label class="form-label" for="lw-max">Precio máximo</label>
                <input id="lw-max" type="number" class="form-control" placeholder="Hasta..."
                    wire:model.debounce.500ms="precio_final">
            </div>
        </div>
    </div>

    <!-- RESULTS COUNT -->
    <div class="d-flex justify-content-between align-items-center mb-3">
        <p class="text-muted mb-0" style="font-size:.875rem">
            <strong>{{ $propiedades->total() }}</strong> propiedades encontradas
        </p>
        <div wire:loading class="text-accent" style="font-size:.8rem">
            <i class="fas fa-spinner fa-spin me-1"></i>Actualizando...
        </div>
    </div>

    <!-- GRID -->
    <div class="row g-4">
        @forelse ($propiedades as $propiedad)
            <div class="col-lg-4 col-md-6">
                <article class="prop-card h-100">
                    <div class="card-img-wrap">
                        <a href="{{ route('propiedad', $propiedad->slug) }}" aria-label="{{ $propiedad->titulo }}">
                            <img loading="lazy" src="{{ asset('assets/' . $propiedad->foto_portada) }}"
                                alt="{{ $propiedad->titulo }}" title="{{ $propiedad->titulo }}">
                        </a>
                        @php $disp = strtolower($propiedad->disponible_para ?? ''); @endphp
                        <span class="badge-status {{ str_contains($disp, 'alquil') ? 'en-alquiler' : '' }}">
                            {{ $propiedad->disponible_para }}
                        </span>
                        <span
                            class="price-overlay">{{ $propiedad->Moneda }}{{ number_format($propiedad->precio, 0) }}</span>
                    </div>
                    <div class="card-body">
                        <h2 class="card-title mb-0">
                            <a href="{{ route('propiedad', $propiedad->slug) }}">{{ $propiedad->titulo }}</a>
                        </h2>
                        <div class="prop-location">
                            <i class="fas fa-location-dot text-accent"></i>
                            <span>{{ $propiedad->zona }}</span>
                        </div>
                        <div class="prop-specs">
                            @if ($propiedad->habitaciones)
                                <div class="prop-spec"><i
                                        class="fas fa-bed"></i><span>{{ $propiedad->habitaciones }}</span></div>
                            @endif
                            @if ($propiedad->banos)
                                <div class="prop-spec"><i class="fas fa-bath"></i><span>{{ $propiedad->banos }}</span>
                                </div>
                            @endif
                            @if ($propiedad->parqueos)
                                <div class="prop-spec"><i
                                        class="fas fa-car"></i><span>{{ $propiedad->parqueos }}</span></div>
                            @endif
                            @if ($propiedad->metraje)
                                <div class="prop-spec"><i
                                        class="fas fa-vector-square"></i><span>{{ $propiedad->metraje }} m2</span>
                                </div>
                            @endif
                        </div>
                        <div class="d-flex justify-content-between align-items-center mt-2">
                            <span class="prop-ref">REF: {{ $propiedad->referencia }}</span>
                            @if ($propiedad->telefono)
                                <a href="{{ 'https://api.whatsapp.com/send/?phone=' . $propiedad->telefono . '&text=' . urlencode(($propiedad->descripcion_corta ?? $propiedad->titulo) . ' ' . route('propiedad', $propiedad->slug)) }}"
                                    target="_blank" rel="noopener noreferrer" aria-label="Contactar por WhatsApp"
                                    class="whatsapp-btn">
                                    <i class="fab fa-whatsapp"></i>
                                </a>
                            @endif
                        </div>
                    </div>
                </article>
            </div>
        @empty
            <div class="col-12">
                <div class="empty-state">
                    <i class="fas fa-house-circle-xmark"></i>
                    <p>No encontramos propiedades con esos criterios.<br>Intenta ajustar los filtros.</p>
                </div>
            </div>
        @endforelse
    </div>

    <!-- PAGINATION -->
    @if ($propiedades->hasPages())
        <div class="d-flex justify-content-center mt-5">
            {{ $propiedades->links('pagination::bootstrap-4') }}
        </div>
    @endif
</div>
