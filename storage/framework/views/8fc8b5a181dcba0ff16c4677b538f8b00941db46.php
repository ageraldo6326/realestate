<div class="property-approval" aria-label="Listado para aprobar propiedades">
    <?php
        $resolveImage = static function ($value): string {
            $fallback = asset('assets/prop-apto-1.jpg');

            if (blank($value)) return $fallback;
            if (\Illuminate\Support\Str::startsWith($value, ['http://', 'https://', '//', 'data:'])) return $value;
            if (\Illuminate\Support\Str::startsWith($value, ['/img/', '/assets/', 'img/', 'assets/'])) return asset(ltrim($value, '/'));

            return asset('assets/' . ltrim($value, '/'));
        };
    ?>

    <div class="approval-summary row">
        <?php $__currentLoopData = [
            'todos' => ['Total de propiedades', $total, ''],
            'pendientes' => ['Pendientes de aprobación', $pendientes, 'is-pending'],
            'aprobadas' => ['Propiedades aprobadas', $aprobadas, 'is-approved'],
        ]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $filter => [$label, $count, $modifier]): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="col-12 col-md-4 mb-3">
                <button type="button" wire:click="setEstado('<?php echo e($filter); ?>')" class="approval-summary__item text-left w-100 <?php echo e($estado === $filter ? 'is-active ' . $modifier : ''); ?>" aria-pressed="<?php echo e($estado === $filter ? 'true' : 'false'); ?>">
                    <span><?php echo e($label); ?></span><strong><?php echo e(number_format($count)); ?></strong>
                </button>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>

    <div class="approval-toolbar">
        <label class="sr-only" for="approval-search">Buscar propiedades</label>
        <div class="input-group approval-search">
            <div class="input-group-prepend" aria-hidden="true"><span class="input-group-text"><i class="fas fa-search"></i></span></div>
            <input id="approval-search" type="search" class="form-control" wire:model.debounce.300ms="criterio" placeholder="Busca por título, referencia o zona">
        </div>
        <div class="approval-toolbar__status" role="status" aria-live="polite"><span wire:loading wire:target="criterio, estado, setEstado"><i class="fas fa-circle-notch fa-spin" aria-hidden="true"></i> Actualizando listado</span></div>
    </div>

    <div id="approval-feedback" class="approval-feedback" role="status" aria-live="polite" aria-atomic="true"></div>

    <div class="approval-list" wire:loading.class="is-loading" wire:target="criterio, estado, setEstado">
        <?php $__empty_1 = true; $__currentLoopData = $propiedades; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $propiedad): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <?php
                $approved = (bool) $propiedad->aprobada;
                $location = collect([$propiedad->zona->zona ?? null, $propiedad->direccion])->filter()->implode(', ');
                $creator = $propiedad->captador->name ?? $propiedad->captador->email ?? null;
            ?>
            <article class="approval-card" wire:key="approval-property-<?php echo e($propiedad->id); ?>" data-approval-card="<?php echo e($propiedad->id); ?>">
                <img class="approval-card__image" src="<?php echo e($resolveImage($propiedad->foto_portada)); ?>" alt="Portada de <?php echo e($propiedad->titulo); ?>" onerror="this.onerror=null;this.src='<?php echo e(asset('assets/prop-apto-1.jpg')); ?>';">
                <div class="approval-card__content">
                    <div class="approval-card__heading">
                        <div><p class="approval-card__reference"><?php echo e($propiedad->referencia ?: 'ID ' . $propiedad->id); ?></p><h2><?php echo e($propiedad->titulo ?: 'Propiedad sin título'); ?></h2></div>
                        <span class="approval-badge <?php echo e($approved ? 'approval-badge--approved' : 'approval-badge--pending'); ?>" data-approval-badge><i class="fas <?php echo e($approved ? 'fa-check-circle' : 'fa-clock'); ?>" aria-hidden="true"></i><span data-approval-badge-text><?php echo e($approved ? 'Aprobada' : 'Pendiente'); ?></span></span>
                    </div>
                    <dl class="approval-card__metadata">
                        <div><dt><i class="fas fa-map-marker-alt" aria-hidden="true"></i> Ubicación</dt><dd><?php echo e($location ?: 'Ubicación no registrada'); ?></dd></div>
                        <div><dt><i class="fas fa-user" aria-hidden="true"></i> Creada por</dt><dd><?php echo e($creator ?: 'No disponible'); ?></dd></div>
                        <div><dt><i class="fas fa-calendar-alt" aria-hidden="true"></i> Registrada</dt><dd><?php echo e(optional($propiedad->created_at)->format('d/m/Y') ?: 'No disponible'); ?></dd></div>
                    </dl>
                </div>
                <div class="approval-card__actions">
                    <div class="approval-control">
                        <div class="approval-control__copy"><span class="approval-control__title">Estado de aprobación</span><span id="approval-status-<?php echo e($propiedad->id); ?>" class="approval-control__status" data-approval-label><?php echo e($approved ? 'Aprobada' : 'Pendiente de aprobación'); ?></span></div>
                        <label class="approval-switch" for="approval-toggle-<?php echo e($propiedad->id); ?>"><span class="sr-only"><?php echo e($approved ? 'Retirar aprobación de' : 'Aprobar'); ?> <?php echo e($propiedad->titulo); ?></span><input id="approval-toggle-<?php echo e($propiedad->id); ?>" type="checkbox" role="switch" aria-describedby="approval-status-<?php echo e($propiedad->id); ?>" class="js-approval-toggle" data-approval-url="<?php echo e(route('admin.propiedades.aprobacion', $propiedad->id)); ?>" data-approved="<?php echo e($approved ? '1' : '0'); ?>" <?php echo e($approved ? 'checked' : ''); ?>><span class="approval-switch__track" aria-hidden="true"></span></label>
                        <span class="approval-spinner" aria-hidden="true"><i class="fas fa-circle-notch fa-spin"></i></span>
                    </div>
                    <div class="approval-card__links"><a href="<?php echo e(route('vercualquierpropiedad', $propiedad->id)); ?>" class="btn btn-outline-secondary">Ver detalle</a><a href="<?php echo e(route('editarpendientes', $propiedad->id)); ?>" class="btn btn-primary">Editar</a></div>
                </div>
            </article>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <div class="approval-empty" role="status"><i class="fas fa-search" aria-hidden="true"></i><h2>No encontramos propiedades</h2><p>Prueba con otro término o cambia el filtro de estado.</p><?php if($criterio !== '' || $estado !== 'todos'): ?><button type="button" wire:click="clearFilters" class="btn btn-outline-primary">Limpiar filtros</button><?php endif; ?></div>
        <?php endif; ?>
    </div>

    <?php if($propiedades->hasPages()): ?><div class="approval-pagination"><?php echo e($propiedades->links('pagination::bootstrap-4')); ?></div><?php endif; ?>

    <style>
        .property-approval{--ink:#17343a;--teal:#1c4f59;--teal-soft:#eaf3f5;--amber:#9a5417;--amber-soft:#fff3e5;--border:#dbe5e7;color:var(--ink)}.approval-summary__item{min-height:100px;padding:1.1rem 1.25rem;border:1px solid var(--border);border-radius:.9rem;background:#fff;color:var(--ink);transition:border-color .15s,box-shadow .15s}.approval-summary__item:hover,.approval-summary__item:focus-visible,.approval-summary__item.is-active{border-color:var(--teal);box-shadow:0 .35rem 1rem rgba(18,52,59,.1);outline:0}.approval-summary__item span,.approval-summary__item strong{display:block}.approval-summary__item span{font-size:.85rem}.approval-summary__item strong{margin-top:.2rem;font-size:1.9rem;line-height:1}.approval-summary__item.is-pending.is-active{border-color:var(--amber);background:var(--amber-soft)}.approval-summary__item.is-approved.is-active{background:var(--teal-soft)}.approval-toolbar{display:flex;align-items:center;gap:1rem;margin:.5rem 0 1.25rem}.approval-search{max-width:42rem}.approval-search .input-group-text{background:#fff;border-right:0;color:var(--teal)}.approval-search .form-control{min-height:46px;border-left:0}.approval-search .form-control:focus{box-shadow:none;border-color:#ced4da}.approval-toolbar__status{min-height:1.25rem;font-size:.875rem;color:#52656a}.approval-feedback{display:none;margin:0 0 1rem;padding:.85rem 1rem;border-radius:.5rem}.approval-feedback.is-visible{display:block}.approval-feedback.is-success{color:#0d5130;background:#e7f6ee}.approval-feedback.is-error{color:#7a1e20;background:#fce9e9}.approval-list{display:grid;gap:.9rem;transition:opacity .15s}.approval-list.is-loading{opacity:.58;pointer-events:none}.approval-card{display:grid;grid-template-columns:144px minmax(0,1fr) minmax(225px,285px);gap:1.25rem;align-items:center;padding:1rem;border:1px solid var(--border);border-radius:.9rem;background:#fff;box-shadow:0 .2rem .75rem rgba(18,52,59,.045)}.approval-card__image{width:144px;height:112px;object-fit:cover;border-radius:.65rem;background:#eef3f4}.approval-card__heading{display:flex;align-items:flex-start;justify-content:space-between;gap:1rem}.approval-card__reference{margin:0 0 .2rem;color:#65777b;font-size:.78rem;font-weight:600}.approval-card h2{margin:0;font-size:1.08rem;font-weight:700;line-height:1.3}.approval-badge{display:inline-flex;align-items:center;gap:.35rem;flex:none;padding:.3rem .6rem;border-radius:999px;font-size:.78rem;font-weight:700}.approval-badge--approved{color:#0d5130;background:#e7f6ee}.approval-badge--pending{color:#804311;background:var(--amber-soft)}.approval-card__metadata{display:flex;flex-wrap:wrap;gap:.5rem 1.5rem;margin:.9rem 0 0}.approval-card__metadata div{min-width:8rem}.approval-card__metadata dt{margin:0;font-size:.73rem;color:#6a7a7d;font-weight:600}.approval-card__metadata dd{margin:.12rem 0 0;font-size:.84rem;overflow-wrap:anywhere}.approval-card__actions{display:grid;gap:.8rem}.approval-control{position:relative;display:flex;align-items:center;justify-content:space-between;gap:.7rem;min-height:52px;padding:.6rem .7rem;border:1px solid var(--border);border-radius:.65rem;background:#f9fbfb}.approval-control__copy{display:grid;gap:.1rem}.approval-control__title{font-size:.72rem;font-weight:600;color:#65777b}.approval-control__status{font-size:.86rem;font-weight:700}.approval-switch{position:relative;display:inline-flex;width:48px;height:32px;flex:none;margin:0;cursor:pointer}.approval-switch input{position:absolute;opacity:0;width:1px;height:1px}.approval-switch__track{width:48px;height:32px;border-radius:99px;background:#9aa8ab;transition:background .15s}.approval-switch__track::after{content:'';position:absolute;top:4px;left:4px;width:24px;height:24px;border-radius:50%;background:#fff;box-shadow:0 1px 3px rgba(0,0,0,.2);transition:transform .15s}.approval-switch input:checked+.approval-switch__track{background:var(--teal)}.approval-switch input:checked+.approval-switch__track::after{transform:translateX(16px)}.approval-switch input:focus-visible+.approval-switch__track{outline:3px solid rgba(28,79,89,.35);outline-offset:2px}.approval-switch input:disabled+.approval-switch__track{opacity:.55;cursor:wait}.approval-spinner{display:none;position:absolute;inset:0;place-items:center;border-radius:.65rem;background:rgba(255,255,255,.8);color:var(--teal)}.approval-control.is-processing .approval-spinner{display:grid}.approval-card__links{display:grid;grid-template-columns:1fr 1fr;gap:.5rem}.approval-card__links .btn{min-height:42px;display:inline-flex;align-items:center;justify-content:center}.approval-empty{padding:3.5rem 1rem;border:1px dashed #b8c9cd;border-radius:.9rem;color:#627579;text-align:center;background:#fcfdfd}.approval-empty i{margin-bottom:.8rem;font-size:1.6rem;color:var(--teal)}.approval-empty h2{font-size:1.1rem;color:var(--ink)}.approval-pagination{margin-top:1.5rem}@media(max-width:991.98px){.approval-card{grid-template-columns:112px minmax(0,1fr)}.approval-card__image{width:112px;height:100%;min-height:118px}.approval-card__actions{grid-column:1/-1;grid-template-columns:minmax(0,1fr) minmax(210px,280px);align-items:center}}@media(max-width:575.98px){.approval-toolbar{display:block}.approval-toolbar__status{margin-top:.6rem}.approval-card{grid-template-columns:86px minmax(0,1fr);gap:.8rem;padding:.75rem}.approval-card__image{width:86px;min-height:86px;height:86px}.approval-card__heading{display:block}.approval-badge{margin-top:.5rem}.approval-card__metadata{display:block;margin-top:.7rem}.approval-card__metadata div+div{margin-top:.42rem}.approval-card__actions{display:grid;grid-column:1/-1}.approval-card__links{grid-template-columns:1fr 1fr}}@media(prefers-reduced-motion:reduce){.approval-summary__item,.approval-list,.approval-switch__track,.approval-switch__track::after{transition:none}}
    </style>

    <script>
        if (!window.__propertyApprovalToggleBound) { window.__propertyApprovalToggleBound = true; document.addEventListener('change', async function(event) {
            const toggle = event.target.closest('.js-approval-toggle'); if (!toggle || toggle.disabled) return;
            const previousState = toggle.dataset.approved === '1', requestedState = toggle.checked;
            const proceed = window.Swal ? await window.Swal.fire({title: requestedState ? '¿Deseas aprobar esta propiedad?' : '¿Deseas retirar la aprobación?',text: requestedState ? 'La propiedad quedará disponible como aprobada.' : 'La propiedad volverá a quedar pendiente de aprobación.',icon:'question',showCancelButton:true,confirmButtonText:requestedState?'Sí, aprobar':'Sí, retirar',cancelButtonText:'Cancelar',reverseButtons:true}).then(result => result.isConfirmed) : window.confirm(requestedState ? '¿Deseas aprobar esta propiedad?' : '¿Deseas retirar la aprobación?');
            if (!proceed) { toggle.checked = previousState; return; }
            const card = toggle.closest('[data-approval-card]'), control = toggle.closest('.approval-control'), feedback = document.getElementById('approval-feedback'); toggle.disabled = true; control.classList.add('is-processing');
            try { const response = await fetch(toggle.dataset.approvalUrl,{method:'PATCH',credentials:'same-origin',headers:{'Accept':'application/json','Content-Type':'application/json','X-CSRF-TOKEN':document.querySelector('meta[name="csrf-token"]')?.getAttribute('content')||''},body:JSON.stringify({aprobada:requestedState})}), data = await response.json().catch(() => ({})); if (!response.ok) throw new Error(data.message || 'No se pudo actualizar la aprobación.'); const approved = Boolean(data.aprobada); toggle.checked = approved; toggle.dataset.approved = approved ? '1' : '0'; card.querySelector('[data-approval-label]').textContent = data.status_label; const badge = card.querySelector('[data-approval-badge]'); badge.classList.toggle('approval-badge--approved',approved); badge.classList.toggle('approval-badge--pending',!approved); badge.querySelector('i').className = 'fas ' + (approved ? 'fa-check-circle' : 'fa-clock'); badge.querySelector('[data-approval-badge-text]').textContent = approved ? 'Aprobada' : 'Pendiente'; feedback.textContent=data.message; feedback.className='approval-feedback is-visible is-success'; }
            catch (error) { toggle.checked = previousState; feedback.textContent = error.message || 'No se pudo actualizar la aprobación. Inténtalo nuevamente.'; feedback.className = 'approval-feedback is-visible is-error'; }
            finally { toggle.disabled = false; control.classList.remove('is-processing'); }
        }); }
    </script>
</div>
<?php /**PATH D:\xampp3\htdocs\realestate_dev\resources\views/livewire/mostrar-propiedades-pendientes-por-aprobar.blade.php ENDPATH**/ ?>