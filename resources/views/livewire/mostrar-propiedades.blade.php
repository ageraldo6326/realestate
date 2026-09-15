<section class="property-inventory" aria-labelledby="property-inventory-title">
    @php
        $resolveImage = static function ($value): string {
            $fallback = asset('assets/prop-apto-1.jpg');

            if (blank($value)) return $fallback;
            if (\Illuminate\Support\Str::startsWith($value, ['http://', 'https://', '//', 'data:'])) return $value;
            if (\Illuminate\Support\Str::startsWith($value, ['/img/', '/assets/', 'img/', 'assets/'])) return asset(ltrim($value, '/'));

            return asset('assets/' . ltrim($value, '/'));
        };
    @endphp

    <header class="inventory-header">
        <div>
            <p class="inventory-header__eyebrow">Inventario global</p>
            <h1 id="property-inventory-title">Todas las propiedades</h1>
            <p>Consulta el inventario completo registrado en el sistema.</p>
        </div>
        <div class="inventory-count" aria-live="polite" aria-atomic="true">
            <span>Resultados</span>
            <strong>{{ number_format($propiedades->total()) }}</strong>
        </div>
    </header>

    <div class="inventory-toolbar" aria-label="Búsqueda de propiedades">
        <label class="sr-only" for="inventory-search">Buscar propiedades</label>
        <div class="input-group inventory-search">
            <div class="input-group-prepend" aria-hidden="true"><span class="input-group-text"><i class="fas fa-search"></i></span></div>
            <input id="inventory-search" type="search" class="form-control" wire:model.debounce.300ms="criterio" placeholder="Busca por título, referencia, ciudad, provincia, sector o barrio" autocomplete="off">
            @if ($criterio !== '')
                <div class="input-group-append"><button type="button" wire:click="clearSearch" class="btn btn-outline-secondary inventory-search__clear" aria-label="Limpiar búsqueda"><i class="fas fa-times" aria-hidden="true"></i></button></div>
            @endif
        </div>
        <p class="inventory-toolbar__status" role="status" aria-live="polite">
            <span wire:loading wire:target="criterio, clearSearch, gotoPage, previousPage, nextPage"><i class="fas fa-circle-notch fa-spin" aria-hidden="true"></i> Actualizando inventario</span>
        </p>
    </div>

    <div class="inventory-list" wire:loading.class="is-loading" wire:target="criterio, clearSearch, gotoPage, previousPage, nextPage" aria-live="polite">
        @forelse ($propiedades as $propiedad)
            @php
                $location = collect([$propiedad->ciudad, $propiedad->provincia_nombre, $propiedad->barrio_nombre ?: $propiedad->sector_nombre])->filter()->implode(', ');
                $availability = $propiedad->disponible_para_nombre ?: $propiedad->disponible_para;
                $type = $propiedad->tipo_nombre ?: ($propiedad->tipo ? 'Tipo ' . $propiedad->tipo : null);
                $registeredAt = $propiedad->created_at ? \Illuminate\Support\Carbon::parse($propiedad->created_at)->format('d/m/Y') : 'No disponible';
            @endphp
            <article class="inventory-card" wire:key="inventory-property-{{ $propiedad->id }}">
                <img class="inventory-card__image" src="{{ $resolveImage($propiedad->foto_portada) }}" alt="Portada de {{ $propiedad->titulo ?: 'propiedad' }}" onerror="this.onerror=null;this.src='{{ asset('assets/prop-apto-1.jpg') }}';">

                <div class="inventory-card__content">
                    <div class="inventory-card__heading">
                        <div>
                            <p class="inventory-card__reference">{{ $propiedad->referencia ?: 'ID ' . $propiedad->id }}</p>
                            <h2><a href="{{ route('vercualquierpropiedad', $propiedad->id) }}">{{ $propiedad->titulo ?: 'Propiedad sin título' }}</a></h2>
                        </div>
                        <div class="inventory-card__badges" aria-label="Estados de la propiedad">
                            <span class="inventory-badge {{ $propiedad->aprobada ? 'inventory-badge--approved' : 'inventory-badge--pending' }}"><i class="fas {{ $propiedad->aprobada ? 'fa-check-circle' : 'fa-clock' }}" aria-hidden="true"></i> {{ $propiedad->aprobada ? 'Aprobada' : 'Pendiente' }}</span>
                            <span class="inventory-badge {{ $propiedad->activa ? 'inventory-badge--active' : 'inventory-badge--inactive' }}"><i class="fas {{ $propiedad->activa ? 'fa-eye' : 'fa-eye-slash' }}" aria-hidden="true"></i> {{ $propiedad->activa ? 'Publicada' : 'No publicada' }}</span>
                            @if ($propiedad->vendida)<span class="inventory-badge inventory-badge--sold"><i class="fas fa-handshake" aria-hidden="true"></i> Vendida</span>@endif
                        </div>
                    </div>

                    <dl class="inventory-card__metadata">
                        <div><dt><i class="fas fa-map-marker-alt" aria-hidden="true"></i> Ubicación</dt><dd>{{ $location ?: 'Ubicación no registrada' }}</dd></div>
                        <div><dt><i class="fas fa-building" aria-hidden="true"></i> Tipo</dt><dd>{{ $type ?: 'No registrado' }}</dd></div>
                        <div><dt><i class="fas fa-calendar-alt" aria-hidden="true"></i> Registrada</dt><dd>{{ $registeredAt }}</dd></div>
                        @if ($propiedad->asignada_a)<div><dt><i class="fas fa-user" aria-hidden="true"></i> Asignada a</dt><dd>{{ $propiedad->asignada_a }}</dd></div>@endif
                    </dl>
                </div>

                <div class="inventory-card__aside">
                    <p class="inventory-card__price">{{ $propiedad->Moneda ?: 'RD$' }} {{ is_numeric($propiedad->precio) ? number_format($propiedad->precio, 2) : 'Precio no registrado' }}</p>
                    @if ($availability)<p class="inventory-card__availability">{{ $availability }}</p>@endif
                    <div class="inventory-card__specs" aria-label="Características">
                        @if ($propiedad->habitaciones)<span><i class="fas fa-bed" aria-hidden="true"></i> {{ $propiedad->habitaciones }} hab.</span>@endif
                        @if ($propiedad->banos)<span><i class="fas fa-bath" aria-hidden="true"></i> {{ $propiedad->banos }} baños</span>@endif
                        @if ($propiedad->parqueos)<span><i class="fas fa-car" aria-hidden="true"></i> {{ $propiedad->parqueos }} parqueos</span>@endif
                        @if ($propiedad->metraje)<span><i class="fas fa-ruler-combined" aria-hidden="true"></i> {{ $propiedad->metraje }} m²</span>@endif
                    </div>
                    <div class="inventory-card__actions">
                        <a href="{{ route('vercualquierpropiedad', $propiedad->id) }}" class="btn btn-outline-secondary">Ver detalle</a>
                        <a href="{{ route('editarpendientescualquiera', $propiedad->id) }}" class="btn btn-primary">Editar</a>
                    </div>
                </div>
            </article>
        @empty
            <div class="inventory-empty" role="status">
                <i class="fas fa-search" aria-hidden="true"></i>
                <h2>No encontramos propiedades</h2>
                <p>Prueba con otro término de búsqueda.</p>
                @if ($criterio !== '')<button type="button" wire:click="clearSearch" class="btn btn-outline-primary">Limpiar búsqueda</button>@endif
            </div>
        @endforelse
    </div>

    @if ($propiedades->hasPages())
        <nav class="inventory-pagination" aria-label="Paginación de propiedades">{{ $propiedades->links('pagination::bootstrap-4') }}</nav>
    @endif

    <style>
        .property-inventory{--ink:#17343a;--teal:#1c4f59;--teal-soft:#eaf3f5;--border:#dbe5e7;--muted:#63767a;--amber:#804311;--amber-soft:#fff3e5;color:var(--ink)}.inventory-header{display:flex;align-items:end;justify-content:space-between;gap:1.5rem;padding:1.25rem 0 1.5rem;border-bottom:2px solid var(--teal)}.inventory-header__eyebrow{margin:0 0 .3rem;color:var(--teal);font-size:.82rem;font-weight:700}.inventory-header h1{margin:0;font-size:clamp(1.55rem,3vw,2.25rem);font-weight:700}.inventory-header p:not(.inventory-header__eyebrow){margin:.4rem 0 0;color:#51656a}.inventory-count{min-width:8.5rem;padding:.75rem 1rem;border-left:1px solid var(--border);text-align:right}.inventory-count span,.inventory-count strong{display:block}.inventory-count span{color:var(--muted);font-size:.78rem;font-weight:600}.inventory-count strong{color:var(--teal);font-size:1.65rem;line-height:1.1}.inventory-toolbar{display:flex;align-items:center;gap:1rem;margin:1.25rem 0}.inventory-search{max-width:48rem}.inventory-search .input-group-text{background:#fff;border-right:0;color:var(--teal)}.inventory-search .form-control{min-height:46px;border-left:0}.inventory-search .form-control:focus{border-color:#ced4da;box-shadow:none}.inventory-search__clear{min-width:46px}.inventory-toolbar__status{min-width:11rem;margin:0;color:var(--muted);font-size:.85rem}.inventory-list{display:grid;gap:.85rem;transition:opacity .15s}.inventory-list.is-loading{opacity:.58;pointer-events:none}.inventory-card{display:grid;grid-template-columns:148px minmax(0,1fr) minmax(225px,280px);gap:1.25rem;align-items:center;padding:1rem;border:1px solid var(--border);border-radius:.8rem;background:#fff;box-shadow:0 .2rem .75rem rgba(18,52,59,.045)}.inventory-card__image{width:148px;height:118px;object-fit:cover;border-radius:.55rem;background:#eef3f4}.inventory-card__heading{display:flex;align-items:flex-start;justify-content:space-between;gap:1rem}.inventory-card__reference{margin:0 0 .2rem;color:var(--muted);font-size:.78rem;font-weight:700}.inventory-card h2{margin:0;font-size:1.1rem;line-height:1.3}.inventory-card h2 a{color:inherit}.inventory-card h2 a:hover{color:var(--teal)}.inventory-card__badges{display:flex;flex-wrap:wrap;justify-content:flex-end;gap:.35rem}.inventory-badge{display:inline-flex;align-items:center;gap:.3rem;padding:.28rem .55rem;border-radius:999px;font-size:.75rem;font-weight:700;white-space:nowrap}.inventory-badge--approved,.inventory-badge--active{background:#e7f6ee;color:#0d5130}.inventory-badge--pending{background:var(--amber-soft);color:var(--amber)}.inventory-badge--inactive{background:#eff2f3;color:#526065}.inventory-badge--sold{background:#f8e9ee;color:#7c2640}.inventory-card__metadata{display:flex;flex-wrap:wrap;gap:.6rem 1.5rem;margin:.9rem 0 0}.inventory-card__metadata div{min-width:8rem}.inventory-card__metadata dt{margin:0;color:var(--muted);font-size:.73rem;font-weight:600}.inventory-card__metadata dd{margin:.13rem 0 0;font-size:.86rem;overflow-wrap:anywhere}.inventory-card__aside{display:grid;gap:.55rem}.inventory-card__price{margin:0;font-size:1.12rem;font-weight:700;text-align:right}.inventory-card__availability{margin:0;color:var(--teal);font-size:.84rem;font-weight:700;text-align:right}.inventory-card__specs{display:flex;justify-content:flex-end;flex-wrap:wrap;gap:.35rem .65rem;color:#51656a;font-size:.78rem}.inventory-card__actions{display:grid;grid-template-columns:1fr 1fr;gap:.5rem;margin-top:.1rem}.inventory-card__actions .btn{display:inline-flex;align-items:center;justify-content:center;min-height:44px}.inventory-empty{padding:3.5rem 1rem;border:1px dashed #b8c9cd;border-radius:.8rem;background:#fcfdfd;color:var(--muted);text-align:center}.inventory-empty i{margin-bottom:.8rem;color:var(--teal);font-size:1.65rem}.inventory-empty h2{color:var(--ink);font-size:1.15rem}.inventory-pagination{margin-top:1.5rem}.inventory-pagination .pagination{margin-bottom:0}.inventory-pagination .page-link{min-width:44px;min-height:44px;display:inline-flex;align-items:center;justify-content:center;color:var(--teal)}.inventory-pagination .page-item.active .page-link{border-color:var(--teal);background:var(--teal)}.inventory-search .form-control:focus-visible,.inventory-search__clear:focus-visible,.inventory-card h2 a:focus-visible,.inventory-card__actions .btn:focus-visible,.inventory-empty .btn:focus-visible{outline:3px solid rgba(28,79,89,.35);outline-offset:2px}@media(max-width:991.98px){.inventory-card{grid-template-columns:112px minmax(0,1fr)}.inventory-card__image{width:112px;height:100%;min-height:118px}.inventory-card__aside{grid-column:1/-1;grid-template-columns:1fr auto;align-items:center;padding-top:.75rem;border-top:1px solid var(--border)}.inventory-card__price,.inventory-card__availability{text-align:left}.inventory-card__specs{justify-content:flex-start}.inventory-card__actions{grid-column:2;min-width:220px}}@media(max-width:575.98px){.inventory-header{align-items:flex-start;padding-top:.5rem}.inventory-header p:not(.inventory-header__eyebrow){max-width:28rem}.inventory-count{min-width:0;padding:.25rem 0 0;border-left:0}.inventory-toolbar{display:block}.inventory-toolbar__status{min-height:1.25rem;margin-top:.6rem}.inventory-card{grid-template-columns:88px minmax(0,1fr);gap:.8rem;padding:.75rem}.inventory-card__image{width:88px;height:88px;min-height:0}.inventory-card__heading{display:block}.inventory-card__badges{justify-content:flex-start;margin-top:.5rem}.inventory-card__metadata{display:block;margin-top:.7rem}.inventory-card__metadata div+div{margin-top:.45rem}.inventory-card__aside{display:block;grid-column:1/-1}.inventory-card__price,.inventory-card__availability{text-align:left}.inventory-card__specs{justify-content:flex-start;margin:.55rem 0}.inventory-card__actions{grid-template-columns:1fr 1fr;min-width:0}.inventory-pagination .pagination{justify-content:center;flex-wrap:wrap}}@media(prefers-reduced-motion:reduce){.inventory-list{transition:none}}
    </style>
</section>
