<div>
    @php
        $propertyPlaceholder = asset('assets/prop-apto-1.jpg');
        $personPlaceholder = asset('vendor/adminlte/dist/img/user2-160x160.jpg');
        $resolvePropertyImage = function ($value, $version = null, $fallback = null) {
            $fallback ??= asset('assets/prop-apto-1.jpg');

            if (empty($value)) {
                return $fallback;
            }

            $appendVersion = function (string $url) use ($version): string {
                if (!$version) {
                    return $url;
                }

                $separator = str_contains($url, '?') ? '&' : '?';

                return $url . $separator . 'v=' . rawurlencode((string) $version);
            };

            if (\Illuminate\Support\Str::startsWith($value, ['http://', 'https://', '//', 'data:'])) {
                return $appendVersion($value);
            }

            if (\Illuminate\Support\Str::startsWith($value, ['/img/', '/assets/', 'img/', 'assets/'])) {
                return $appendVersion(asset(ltrim($value, '/')));
            }

            return $appendVersion(asset('assets/' . ltrim($value, '/')));
        };
    @endphp

    <!-- FILTROS DE BÚSQUEDA -->
    <div class="lw-search-form mb-4">
        <div class="lw-search-grid">
            <div class="lw-field lw-field-title">
                <label class="form-label lw-label" for="lw-titulo">Título</label>
                <input type="search" id="lw-titulo" class="form-control lw-input"
                    placeholder="Ej. Apartamento en Piantini" wire:model.debounce.500ms="titulo_criterio"
                    autocomplete="off">
            </div>

            <div class="lw-field">
                <label class="form-label lw-label" for="lw-provincia">Provincia</label>
                <select id="lw-provincia" class="form-select lw-select" wire:model="provincia_id_criterio">
                    <option value="">Todas las provincias</option>
                    @foreach ($provincias as $provincia)
                        <option value="{{ $provincia->id }}">{{ $provincia->provincia }}</option>
                    @endforeach
                </select>
            </div>

            <div class="lw-field">
                <label class="form-label lw-label" for="lw-sector-barrio">Sector</label>
                <select id="lw-sector-barrio" class="form-select lw-select" wire:model="sector_barrio_criterio">
                    <option value="">Todos los sectores</option>
                    @foreach ($sectores as $sector)
                        <option value="{{ $sector->id }}">{{ $sector->sector }}</option>
                    @endforeach
                </select>
            </div>

            <div class="lw-field">
                <label class="form-label lw-label" for="lw-tipo">Tipo de propiedad</label>
                <select id="lw-tipo" class="form-select lw-select" wire:model="tipo_id_criterio">
                    <option value="">Todos los tipos</option>
                    @foreach ($tipos as $tipo)
                        <option value="{{ $tipo->id }}">{{ $tipo->tipo }}</option>
                    @endforeach
                </select>
            </div>

            <div class="lw-field lw-field-price">
                <label class="form-label lw-label">Margen de precio</label>
                <div class="lw-price-grid">
                    <input type="text" id="lw-precio-ini" class="form-control lw-input" placeholder="Mín"
                        wire:model.debounce.500ms="precio_inicial" aria-label="Precio mínimo">
                    <input type="text" id="lw-precio-fin" class="form-control lw-input" placeholder="Máx"
                        wire:model.debounce.500ms="precio_final" aria-label="Precio máximo">
                </div>
            </div>

        </div>
    </div>

    <!-- INDICADOR DE CARGA: solo durante actualizaciones de filtros -->
    <div wire:loading.delay.shortest
        wire:target="titulo_criterio,provincia_id_criterio,sector_barrio_criterio,tipo_id_criterio,precio_inicial,precio_final"
        class="lw-loading" role="status" aria-live="polite">
        <div class="lw-loading-content">
            <div class="spinner-border spinner-border-sm" aria-hidden="true" style="color:var(--clr-accent)"></div>
            <span>Buscando propiedades...</span>
        </div>
    </div>

    <!-- RESULTADOS -->
    <div wire:loading.class.delay.shortest="lw-results-loading"
        wire:target="titulo_criterio,provincia_id_criterio,sector_barrio_criterio,tipo_id_criterio,precio_inicial,precio_final">

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
                                    <img loading="lazy"
                                        src="{{ $resolvePropertyImage($propiedad->foto_portada, data_get($propiedad, 'updated_at'), $propertyPlaceholder) }}"
                                        onerror="this.onerror=null;this.src='{{ $propertyPlaceholder }}';"
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
                                @php
                                    $asesorNombre = $propiedad->asesor_nombre ?: 'Asesor inmobiliario';
                                    $asesorFotoRaw = $propiedad->asesor_foto ?: '';
                                    if (
                                        $asesorFotoRaw &&
                                        \Illuminate\Support\Str::startsWith($asesorFotoRaw, [
                                            'http://',
                                            'https://',
                                            '//',
                                            'data:',
                                        ])
                                    ) {
                                        $asesorFoto = $asesorFotoRaw;
                                    } elseif (
                                        $asesorFotoRaw &&
                                        \Illuminate\Support\Str::startsWith($asesorFotoRaw, [
                                            '/img/',
                                            '/assets/',
                                            'img/',
                                            'assets/',
                                        ])
                                    ) {
                                        $asesorFoto = asset(ltrim($asesorFotoRaw, '/'));
                                    } elseif ($asesorFotoRaw) {
                                        $asesorFoto = asset('assets/' . ltrim($asesorFotoRaw, '/'));
                                    } else {
                                        $asesorFoto = $personPlaceholder;
                                    }
                                @endphp
                                <h3 class="card-title mb-0">
                                    <a href="{{ route('propiedad', $propiedad->slug) }}">{{ $propiedad->titulo }}</a>
                                </h3>

                                <div class="prop-location">
                                    <i class="fas fa-location-dot text-accent"></i>
                                    <span>
                                        {{ $propiedad->ciudad ?: 'Santo Domingo' }},
                                        {{ $propiedad->provincia_nombre }}
                                        @if ($propiedad->barrio_nombre || $propiedad->sector_nombre)
                                            - {{ $propiedad->barrio_nombre ?: $propiedad->sector_nombre }}
                                        @endif
                                    </span>
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
                                    @if ($propiedad->asesor_telefono)
                                        <a href="{{ 'https://api.whatsapp.com/send/?phone=' . $propiedad->asesor_telefono . '&text=' . urlencode($propiedad->descripcion_corta . ' ' . route('propiedad', $propiedad->slug)) }}"
                                            target="_blank" rel="noopener noreferrer"
                                            aria-label="Contactar por WhatsApp" class="whatsapp-btn">
                                            <i class="fab fa-whatsapp"></i>
                                        </a>
                                    @endif
                                </div>
                                <div class="d-flex align-items-center mt-3 pt-2 border-top">
                                    <img src="{{ $asesorFoto }}" alt="{{ $asesorNombre }}" loading="lazy"
                                        onerror="this.onerror=null;this.src='{{ $personPlaceholder }}';"
                                        style="width: 34px; height: 34px; border-radius: 50%; object-fit: cover;"
                                        class="mr-2">
                                    <span class="small text-muted">Asesor: {{ $asesorNombre }}</span>
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

        .lw-search-grid {
            display: grid;
            grid-template-columns: minmax(0, 1fr);
            gap: 1rem;
            align-items: end
        }

        .lw-field {
            min-width: 0
        }

        .lw-price-grid {
            display: grid;
            grid-template-columns: minmax(0, 1fr);
            gap: .625rem
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
            width: 100%;
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

        .lw-loading-content {
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

        @media (min-width: 576px) {
            .lw-price-grid {
                grid-template-columns: repeat(2, minmax(0, 1fr))
            }
        }

        @media (min-width: 768px) {
            .lw-search-grid {
                grid-template-columns: repeat(2, minmax(0, 1fr))
            }

            .lw-field-title {
                grid-column: 1 / -1
            }
        }

        @media (min-width: 1200px) {
            .lw-search-grid {
                grid-template-columns: minmax(220px, 1.25fr) repeat(3, minmax(150px, 1fr)) minmax(260px, 1.2fr)
            }

            .lw-field-title,
            .lw-field-price {
                grid-column: auto
            }
        }
    </style>

</div>
