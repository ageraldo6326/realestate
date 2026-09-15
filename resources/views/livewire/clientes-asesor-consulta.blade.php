<section class="advisor-client-report" aria-labelledby="advisor-client-report-title">
    <header class="advisor-client-report__header">
        <div>
            <h1 id="advisor-client-report-title">Clientes por asesor</h1>
            <p>Consulta los clientes captados por cada asesor dentro de un período específico.</p>
        </div>
        @if ($this->hasDateRange && ! $this->invalidDateRange)
            <div class="advisor-client-report__total" aria-live="polite"><span>Contactos encontrados</span><strong>{{ number_format($clientes_por_asesores->sum('total')) }}</strong></div>
        @endif
    </header>

    <form class="advisor-client-report__filters" wire:submit.prevent="applyFilters" aria-label="Filtrar clientes por período">
        <div class="advisor-client-report__field">
            <label for="advisor-client-start">Fecha de inicio</label>
            <input id="advisor-client-start" type="date" class="form-control" wire:model.defer="fecha_ini" required>
        </div>
        <div class="advisor-client-report__field">
            <label for="advisor-client-end">Fecha de fin</label>
            <input id="advisor-client-end" type="date" class="form-control" wire:model.defer="fecha_fin" required>
        </div>
        <div class="advisor-client-report__filter-actions">
            <button type="submit" class="btn btn-primary" wire:loading.attr="disabled" wire:target="applyFilters"><i class="fas fa-search mr-1" aria-hidden="true"></i> Consultar</button>
            @if ($fecha_ini !== '' || $fecha_fin !== '')<button type="button" wire:click="clearFilters" class="btn btn-outline-secondary" wire:loading.attr="disabled" wire:target="clearFilters">Limpiar</button>@endif
        </div>
        <p class="advisor-client-report__loading" role="status" aria-live="polite"><span wire:loading wire:target="applyFilters, clearFilters"><i class="fas fa-circle-notch fa-spin" aria-hidden="true"></i> Actualizando consulta</span></p>
    </form>

    @if ($this->hasDateRange && $this->invalidDateRange)
        <div class="advisor-client-report__alert" role="alert"><i class="fas fa-exclamation-circle" aria-hidden="true"></i> La fecha de fin debe ser igual o posterior a la fecha de inicio.</div>
    @elseif (! $this->hasDateRange)
        <div class="advisor-client-report__empty" role="status"><i class="fas fa-calendar-alt" aria-hidden="true"></i><h2>Selecciona un período</h2><p>Elige una fecha de inicio y una fecha de fin para consultar los clientes por asesor.</p></div>
    @elseif ($clientes_por_asesores->isEmpty())
        <div class="advisor-client-report__empty" role="status"><i class="fas fa-search" aria-hidden="true"></i><h2>No hay clientes para este período</h2><p>Prueba con un rango de fechas diferente.</p></div>
    @else
        <div class="advisor-client-report__summary" aria-live="polite"><strong>{{ number_format($clientes_por_asesores->count()) }}</strong> asesores con clientes captados entre {{ \Illuminate\Support\Carbon::parse($fecha_ini)->format('d/m/Y') }} y {{ \Illuminate\Support\Carbon::parse($fecha_fin)->format('d/m/Y') }}.</div>
        <div class="advisor-client-report__list" wire:loading.class="is-loading" wire:target="applyFilters, clearFilters">
            @foreach ($clientes_por_asesores as $clientes_por_asesor)
                <article class="advisor-client-card" wire:key="advisor-client-{{ $clientes_por_asesor->userid ?: 'unassigned' }}">
                    <div class="advisor-client-card__identity"><span class="advisor-client-card__avatar" aria-hidden="true">{{ \Illuminate\Support\Str::upper(\Illuminate\Support\Str::substr($clientes_por_asesor->asesor_nombre ?: 'S', 0, 1)) }}</span><div><h2>{{ $clientes_por_asesor->asesor_nombre ?: 'Sin asesor registrado' }}</h2><p>{{ $clientes_por_asesor->userid ? 'Asesor responsable' : 'Registro sin asesor asociado' }}</p></div></div>
                    <div class="advisor-client-card__count"><span>Clientes captados</span><strong>{{ number_format($clientes_por_asesor->total) }}</strong></div>
                    @if ($clientes_por_asesor->userid)
                        <a href="{{ route('verclientesporasesor', ['asesorid' => $clientes_por_asesor->userid, 'fecha_ini' => $fecha_ini, 'fecha_fin' => $fecha_fin]) }}" class="btn btn-outline-secondary advisor-client-card__action">Ver clientes</a>
                    @else
                        <span class="advisor-client-card__unavailable">Detalle no disponible</span>
                    @endif
                </article>
            @endforeach
        </div>
    @endif

    <style>
        .advisor-client-report{--ink:#17343a;--teal:#0d4c55;--border:#dbe5e7;--muted:#63767a;color:var(--ink)}.advisor-client-report__header{display:flex;align-items:center;justify-content:space-between;gap:1.5rem;padding:1.65rem 1.75rem;border-radius:.9rem;background:var(--teal);color:#fff}.advisor-client-report__header h1{margin:0;font-size:clamp(1.55rem,3vw,2.25rem);font-weight:700}.advisor-client-report__header p{max-width:48rem;margin:.45rem 0 0;color:#e1eff0;font-size:1.02rem}.advisor-client-report__total{min-width:8.5rem;padding:.25rem 0 .25rem 1rem;border-left:1px solid rgba(255,255,255,.32);text-align:right}.advisor-client-report__total span,.advisor-client-report__total strong{display:block}.advisor-client-report__total span{color:#d2e5e7;font-size:.78rem;font-weight:600}.advisor-client-report__total strong{font-size:1.7rem;line-height:1.15}.advisor-client-report__filters{display:grid;grid-template-columns:minmax(170px,220px) minmax(170px,220px) auto 1fr;gap:1rem;align-items:end;margin:1.25rem 0;padding:1rem;border:1px solid var(--border);border-radius:.8rem;background:#fff}.advisor-client-report__field label{display:block;margin:0 0 .35rem;font-size:.83rem;font-weight:700}.advisor-client-report__field .form-control{min-height:44px}.advisor-client-report__filter-actions{display:flex;gap:.5rem}.advisor-client-report__filter-actions .btn{min-height:44px;white-space:nowrap}.advisor-client-report__loading{min-height:1.25rem;margin:0;color:var(--muted);font-size:.85rem}.advisor-client-report__alert{display:flex;align-items:center;gap:.55rem;margin:1rem 0;padding:.9rem 1rem;border-radius:.65rem;background:#fce9e9;color:#7a1e20}.advisor-client-report__empty{padding:3.5rem 1rem;border:1px dashed #b8c9cd;border-radius:.8rem;background:#fcfdfd;color:var(--muted);text-align:center}.advisor-client-report__empty i{margin-bottom:.8rem;color:var(--teal);font-size:1.65rem}.advisor-client-report__empty h2{color:var(--ink);font-size:1.15rem}.advisor-client-report__summary{margin:0 0 .8rem;color:var(--muted);font-size:.9rem}.advisor-client-report__summary strong{color:var(--teal)}.advisor-client-report__list{display:grid;gap:.75rem;transition:opacity .15s}.advisor-client-report__list.is-loading{opacity:.58;pointer-events:none}.advisor-client-card{display:grid;grid-template-columns:minmax(0,1fr) 150px 145px;gap:1rem;align-items:center;padding:1rem 1.15rem;border:1px solid var(--border);border-radius:.8rem;background:#fff;box-shadow:0 .2rem .75rem rgba(18,52,59,.045)}.advisor-client-card__identity{display:flex;align-items:center;gap:.8rem;min-width:0}.advisor-client-card__avatar{display:grid;flex:none;width:42px;height:42px;place-items:center;border-radius:50%;background:#eaf3f5;color:var(--teal);font-weight:800}.advisor-client-card h2{margin:0;font-size:1rem}.advisor-client-card__identity p{margin:.18rem 0 0;color:var(--muted);font-size:.82rem}.advisor-client-card__count{text-align:center}.advisor-client-card__count span,.advisor-client-card__count strong{display:block}.advisor-client-card__count span{color:var(--muted);font-size:.74rem;font-weight:600}.advisor-client-card__count strong{color:var(--teal);font-size:1.45rem;line-height:1.15}.advisor-client-card__action{min-height:44px;display:inline-flex;align-items:center;justify-content:center}.advisor-client-card__unavailable{color:var(--muted);font-size:.82rem;text-align:center}.advisor-client-report .btn:focus-visible,.advisor-client-report .form-control:focus-visible{outline:3px solid rgba(13,76,85,.35);outline-offset:2px}@media(max-width:767.98px){.advisor-client-report__header{display:block;padding:1.25rem}.advisor-client-report__total{margin-top:1rem;padding:.7rem 0 0;border-top:1px solid rgba(255,255,255,.32);border-left:0;text-align:left}.advisor-client-report__filters{grid-template-columns:1fr 1fr}.advisor-client-report__filter-actions{grid-column:1/-1}.advisor-client-report__loading{grid-column:1/-1}.advisor-client-card{grid-template-columns:1fr auto}.advisor-client-card__count{grid-column:1;text-align:left}.advisor-client-card__action,.advisor-client-card__unavailable{grid-column:2;grid-row:2}}@media(max-width:460px){.advisor-client-report__filters{grid-template-columns:1fr}.advisor-client-card{grid-template-columns:1fr}.advisor-client-card__count,.advisor-client-card__action,.advisor-client-card__unavailable{grid-column:1;grid-row:auto;text-align:left}.advisor-client-card__action{width:100%}}@media(prefers-reduced-motion:reduce){.advisor-client-report__list{transition:none}}
    </style>
</section>
