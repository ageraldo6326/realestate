<div>
    <!-- FILTROS DE BÚSQUEDA -->
    <div class="lw-search-form mb-4">
        <div class="row g-3 align-items-end">

            <div class="col-md-3 col-sm-6">
                <label class="form-label lw-label" for="lw-zona">Ubicación / Zona</label>
                <select id="lw-zona" class="form-select lw-select" wire:model="zona_id_criterio">
                    <option value="">Todas las zonas</option>
                    @foreach ($zonas as $zona)
                        <option value="{{ $zona->id }}">{{ $zona->zona }}</option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-3 col-sm-6">
                <label class="form-label lw-label" for="lw-tipo">Tipo de propiedad</label>
                <select id="lw-tipo" class="form-select lw-select" wire:model="tipo_id_criterio">
                    <option value="">Todos los tipos</option>
                    @foreach ($tipos as $tipo)
                        <option value="{{ $tipo->id }}">{{ $tipo->tipo }}</option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-3 col-sm-6">
                <label class="form-label lw-label" for="lw-precio-ini">Precio mínimo</label>
                <input type="text" id="lw-precio-ini" class="form-control lw-input" placeholder="Ej: 50,000"
                    wire:model.debounce.500ms="precio_inicial">
            </div>

            <div class="col-md-3 col-sm-6">
                <label class="form-label lw-label" for="lw-precio-fin">Precio máximo</label>
                <input type="text" id="lw-precio-fin" class="form-control lw-input" placeholder="Ej: 500,000"
                    wire:model.debounce.500ms="precio_final">
            </div>

        </div>
    </div>

    <!-- INDICADOR DE CARGA: solo durante actualizaciones de filtros -->
    <div wire:loading.delay.shortest wire:target="zona_id_criterio,tipo_id_criterio,precio_inicial,precio_final"
        class="lw-loading">
        <div class="spinner-border spinner-border-sm" role="status" style="color:var(--clr-accent)">
            <span class="visually-hidden">Cargando...</span>
        </div>
        <span>Buscando propiedades...</span>
    </div>

    <!-- RESULTADOS -->
    <div wire:loading.class.delay.shortest="lw-results-loading"
        wire:target="zona_id_criterio,tipo_id_criterio,precio_inicial,precio_final">

        @if ($propiedades->count())
            <p class="lw-results-count">
                {{ $propiedades->total() }} propiedad{{ $propiedades->total() !== 1 ? 'es' : '' }}
                encontrada{{ $propiedades->total() !== 1 ? 's' : '' }}
            </p>

            <div class="row g-4">
                @foreach ($propiedades as $propiedad)
                    <div class="col-lg-4 col-md-6">
                        <article class="prop-card h-100">
                            <div class="card-img-wrap">
                                <a href="{{ route('propiedad', $propiedad->slug) }}"
                                    aria-label="{{ $propiedad->titulo }}">
                                    <img loading="lazy" src="{{ asset('assets/' . $propiedad->foto_portada) }}"
                                        alt="{{ $propiedad->titulo }}" title="{{ $propiedad->titulo }}">
                                </a>

                                @php $disp = strtolower($propiedad->disponible_para ?? ''); @endphp
                                <span class="badge-status {{ str_contains($disp, 'alquil') ? 'en-alquiler' : '' }}">
                                    {{ $propiedad->disponible_para }}
                                </span>

                                <span class="price-overlay">
                                    {{ $propiedad->Moneda }}{{ number_format($propiedad->precio, 0) }}
                                </span>
                            </div>

                            <div class="card-body">
                                <h3 class="card-title mb-0">
                                    <a href="{{ route('propiedad', $propiedad->slug) }}">{{ $propiedad->titulo }}</a>
                                </h3>

                                <div class="prop-location">
                                    <i class="fas fa-location-dot text-accent"></i>
                                    <span>{{ $propiedad->zona }}</span>
                                </div>

                                <div class="prop-specs">
                                    @if ($propiedad->habitaciones)
                                        <div class="prop-spec">
                                            <i class="fas fa-bed"></i>
                                            <span>{{ $propiedad->habitaciones }}</span>
                                        </div>
                                    @endif
                                    @if ($propiedad->banos)
                                        <div class="prop-spec">
                                            <i class="fas fa-bath"></i>
                                            <span>{{ $propiedad->banos }}</span>
                                        </div>
                                    @endif
                                    @if ($propiedad->metraje)
                                        <div class="prop-spec">
                                            <i class="fas fa-vector-square"></i>
                                            <span>{{ $propiedad->metraje }} m²</span>
                                        </div>
                                    @endif
                                </div>

                                <div class="d-flex justify-content-between align-items-center mt-2">
                                    <span class="prop-ref">REF: {{ $propiedad->referencia }}</span>
                                    @if ($propiedad->telefono)
                                        <a href="{{ 'https://api.whatsapp.com/send/?phone=' . $propiedad->telefono . '&text=' . urlencode($propiedad->descripcion_corta . ' ' . route('propiedad', $propiedad->slug)) }}"
                                            target="_blank" rel="noopener noreferrer"
                                            aria-label="Contactar por WhatsApp" class="whatsapp-btn">
                                            <i class="fab fa-whatsapp"></i>
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </article>
                    </div>
                @endforeach
            </div>

            <!-- PAGINACIÓN -->
            <div class="lw-pagination mt-5">
                {{ $propiedades->links() }}
            </div>
        @else
            <div class="lw-empty">
                <i class="fas fa-house-circle-xmark"></i>
                <h4>No se encontraron propiedades</h4>
                <p>Intenta con otros filtros o elimina algunos criterios de búsqueda.</p>
            </div>
        @endif

    </div><!-- /wire:loading.remove -->

    <style>
        .lw-search-form {
            background: #fff;
            border: 1px solid var(--clr-border);
            border-radius: var(--radius);
            padding: 1.5rem;
            box-shadow: var(--shadow-sm)
        }

        .lw-label {
            font-size: .7rem;
            font-weight: 700;
            letter-spacing: .5px;
            text-transform: uppercase;
            color: var(--clr-gray);
            margin-bottom: .3rem;
            display: block
        }

        .lw-select,
        .lw-input {
            border: 1.5px solid var(--clr-border);
            border-radius: var(--radius-sm);
            font-size: .875rem;
            padding: .6rem .85rem;
            color: var(--clr-dark);
            transition: border-color .2s
        }

        .lw-select:focus,
        .lw-input:focus {
            border-color: var(--clr-accent);
            box-shadow: 0 0 0 3px rgba(201, 168, 76, .12);
            outline: none
        }

        .lw-loading {
            display: flex;
            align-items: center;
            gap: .75rem;
            padding: .75rem 0;
            color: var(--clr-gray);
            font-size: .85rem;
            min-height: 2.5rem
        }

        .lw-results-loading {
            opacity: .45;
            pointer-events: none;
            transition: opacity .2s
        }

        .lw-results-count {
            font-size: .82rem;
            color: var(--clr-gray);
            margin-bottom: 1.25rem
        }

        .lw-pagination {
            display: flex;
            justify-content: center
        }

        .lw-pagination .pagination {
            gap: .25rem
        }

        .lw-pagination .page-link {
            border: 1.5px solid var(--clr-border);
            border-radius: var(--radius-sm) !important;
            color: var(--clr-dark);
            font-size: .85rem;
            padding: .45rem .85rem;
            transition: var(--transition)
        }

        .lw-pagination .page-link:hover {
            background: var(--clr-accent);
            border-color: var(--clr-accent);
            color: var(--clr-dark)
        }

        .lw-pagination .page-item.active .page-link {
            background: var(--clr-dark);
            border-color: var(--clr-dark);
            color: #fff
        }

        .lw-empty {
            text-align: center;
            padding: 4rem 2rem;
            color: var(--clr-gray)
        }

        .lw-empty i {
            font-size: 3rem;
            color: var(--clr-accent-lt);
            display: block;
            margin-bottom: 1rem
        }

        .lw-empty h4 {
            font-size: 1.1rem;
            color: var(--clr-dark);
            margin-bottom: .5rem
        }

        .lw-empty p {
            font-size: .88rem
        }
    </style>

</div>
