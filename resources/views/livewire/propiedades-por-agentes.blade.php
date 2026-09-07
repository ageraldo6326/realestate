<div>
    @php
        $propertyPlaceholder = asset('assets/prop-apto-1.jpg');
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

    <!-- SECTION HEADER -->
    <div class="d-flex align-items-center gap-3 mb-4">
        <div>
            <span class="section-badge">PORTAFOLIO</span>
            <h1 class="section-title mb-0">Propiedades del Agente</h1>
        </div>
    </div>
    <!-- GRID -->
    <div class="row g-4">
        @forelse ($propiedades as $propiedad)
            <div class="col-lg-4 col-md-6">
                <article class="prop-card h-100">
                    <div class="card-img-wrap">
                        <a href="{{ route('propiedad', $propiedad->slug) }}" aria-label="{{ $propiedad->titulo }}">
                            <img loading="lazy"
                                src="{{ $resolvePropertyImage($propiedad->foto_portada, data_get($propiedad, 'updated_at'), $propertyPlaceholder) }}"
                                onerror="this.onerror=null;this.src='{{ $propertyPlaceholder }}';"
                                alt="{{ $propiedad->titulo }}" title="{{ $propiedad->titulo }}">
                        </a>
                        @php $disp = strtolower($propiedad->disponible_para ?? ''); @endphp
                        <span
                            class="badge-status {{ str_contains($disp, 'alquil') ? 'en-alquiler' : '' }}">{{ $propiedad->disponible_para }}</span>
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
                                    target="_blank" rel="noopener noreferrer" aria-label="WhatsApp"
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
                    <p>Este agente no tiene propiedades publicadas por el momento.</p>
                </div>
            </div>
        @endforelse
    </div>
    @if ($propiedades->hasPages())
        <div class="d-flex justify-content-center mt-5">{{ $propiedades->links('pagination::bootstrap-4') }}</div>
    @endif
</div>
