<?php
    $isAdmin =
        auth()->check() &&
        auth()
            ->user()
            ->hasAnyRole(['admin', 'superadmin']);
    $galleryFields = collect(range(1, 8))->map(
        fn($index) => [
            'field' => 'foto' . $index,
            'label' => 'Foto ' . $index,
        ],
    );

    $featureFields = [
        'lobby' => 'Lobby',
        'plantaelectrica' => 'Planta electrica',
        'camaravigilancia' => 'Camara de vigilancia',
        'escaleraemergencia' => 'Escalera de emergencia',
        'maderapreciosa' => 'Madera preciosa',
        'balcon' => 'Balcon',
        'walkincloset' => 'Walk-in closet',
        'jacuzzi' => 'Jacuzzi',
        'areainfantil' => 'Area infantil',
        'banovisitas' => 'Bano de visitas',
        'cisterna' => 'Cisterna',
        'inversorareacomun' => 'Inversor en area comun',
        'gascomun' => 'Gas comun',
        'gazebo' => 'Gazebo',
        'pozo' => 'Pozo',
        'piscina' => 'Piscina',
        'familyroom' => 'Family room',
        'cuartodeservicio' => 'Cuarto de servicio',
        'patio' => 'Patio',
        'portonelectrico' => 'Porton electrico',
        'seguridad24horas' => 'Seguridad 24 horas',
        'ascensor' => 'Ascensor',
        'parqueostechados' => 'Parqueos techados',
        'preinstalacionairetinacoinversor' => 'Preinstalacion de aire',
        'terraza' => 'Terraza',
        'estudio' => 'Estudio',
        'gimnasio' => 'Gimnasio',
        'controldeacceso' => 'Control de acceso',
    ];

    $resolveImage = function ($value, $version = null) {
        if (!$value) {
            return null;
        }

        $appendVersion = function (string $url) use ($version): string {
            if (!$version) {
                return $url;
            }

            $separator = str_contains($url, '?') ? '&' : '?';

            return $url . $separator . 'v=' . rawurlencode((string) $version);
        };

        if (is_object($value) && method_exists($value, 'temporaryUrl')) {
            return $value->temporaryUrl();
        }

        if (\Illuminate\Support\Str::startsWith($value, ['http://', 'https://'])) {
            return $appendVersion($value);
        }

        if (\Illuminate\Support\Str::startsWith($value, '/')) {
            return $appendVersion(asset(ltrim($value, '/')));
        }

        return $appendVersion(asset('assets/' . ltrim($value, '/')));
    };

    $videoPreview = '';
    if ($video1) {
        $videoPreview =
            'https://www.youtube.com/embed/' . \Illuminate\Support\Str::of($video1)->after('watch?v=')->afterLast('/');
    }
?>

<div>
    <style>
        .property-shell {
            display: grid;
            gap: 1rem;
        }

        .property-hero {
            background: linear-gradient(135deg, #0f172a 0%, #1d4ed8 55%, #38bdf8 100%);
            border-radius: 1.25rem;
            color: #fff;
            padding: 1.5rem;
            box-shadow: 0 20px 45px rgba(15, 23, 42, 0.18);
        }

        .property-stat {
            background: rgba(255, 255, 255, 0.14);
            border: 1px solid rgba(255, 255, 255, 0.16);
            border-radius: 1rem;
            padding: 1rem;
        }

        .property-panel {
            border: 1px solid #dbe4f0;
            border-radius: 1.25rem;
            box-shadow: 0 14px 28px rgba(15, 23, 42, 0.06);
        }

        .property-thumb {
            width: 88px;
            height: 68px;
            object-fit: cover;
            border-radius: 0.75rem;
            background: #e2e8f0;
        }

        .photo-card {
            border: 1px dashed #cbd5e1;
            border-radius: 1rem;
            padding: 0.9rem;
            background: #f8fafc;
            height: 100%;
        }

        .photo-preview {
            width: 100%;
            aspect-ratio: 4 / 3;
            object-fit: cover;
            border-radius: 0.8rem;
            background: linear-gradient(135deg, #e2e8f0, #f8fafc);
        }

        .feature-pill {
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 999px;
            padding: 0.5rem 0.85rem;
        }
    </style>

    <?php if(session('status')): ?>
        <div class="alert alert-success border-0 shadow-sm rounded-lg mb-3">
            <?php echo e(session('status')); ?>

        </div>
    <?php endif; ?>

    <div class="property-shell">
        <section class="property-hero">
            <div class="row align-items-end">
                <div class="col-lg-7 mb-3 mb-lg-0">
                    <span class="badge badge-light text-primary px-3 py-2 rounded-pill mb-3">CRM inmobiliario</span>
                    <h2 class="h3 font-weight-bold mb-2">Modulo de propiedades renovado para captacion, edicion y control
                        visual.</h2>
                    <p class="mb-0 text-white-50">Busqueda rapida, formulario mas claro, CKEditor 5 y administracion de
                        fotografias con previsualizacion inmediata.</p>
                </div>
                <div class="col-lg-5">
                    <div class="row">
                        <div class="col-6 mb-3">
                            <div class="property-stat">
                                <div class="text-uppercase small text-white-50">Total</div>
                                <div class="h3 mb-0 font-weight-bold"><?php echo e($propiedades->total()); ?></div>
                            </div>
                        </div>
                        <div class="col-6 mb-3">
                            <div class="property-stat">
                                <div class="text-uppercase small text-white-50">Pagina</div>
                                <div class="h3 mb-0 font-weight-bold"><?php echo e($propiedades->count()); ?></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="card property-panel">
            <div class="card-body p-4">
                <div class="d-flex flex-column flex-lg-row justify-content-between align-items-lg-center mb-4">
                    <div>
                        <h3 class="h5 mb-1">Inventario de propiedades</h3>
                        <p class="text-muted mb-0">Filtra por titulo, referencia, provincia o sector y entra al
                            formulario completo
                            de edicion cuando necesites actualizar una propiedad.</p>
                    </div>
                    <div class="d-flex flex-wrap gap-2 mt-3 mt-lg-0">
                        <a href="<?php echo e(route('propiedades.create')); ?>" class="btn btn-primary px-4">
                            Nueva propiedad
                        </a>
                    </div>
                </div>

                <div class="row mb-4">
                    <div class="col-lg-8">
                        <label class="small text-muted font-weight-semibold">Buscar</label>
                        <input type="text" class="form-control form-control-lg rounded-lg"
                            wire:model.debounce.350ms="criterio"
                            placeholder="Ej. penthouse, PROP-0001, Santo Domingo, Naco">
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table align-middle mb-0">
                        <thead class="text-uppercase small text-muted">
                            <tr>
                                <th>Propiedad</th>
                                <th class="d-none d-md-table-cell">Ubicacion</th>
                                <th class="d-none d-lg-table-cell">Precio</th>
                                <th class="d-none d-lg-table-cell">Estado</th>
                                <th class="text-right">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__empty_1 = true; $__currentLoopData = $propiedades; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $propiedad): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                <?php
                                    $rowImage = $resolveImage(
                                        $propiedad->foto_portada,
                                        optional($propiedad)->updated_at,
                                    );
                                    $activeState = data_get(
                                        $propiedad,
                                        'activa_estado',
                                        data_get($propiedad, 'activa', 0),
                                    );
                                    $isActive = (int) $activeState === 1;
                                    $provinciaNombre = trim((string) ($propiedad->provincia_nombre ?? ''));
                                    $sectorNombre = trim((string) ($propiedad->sector_nombre ?? ''));
                                    $ubicacion = trim(
                                        collect([$provinciaNombre, $sectorNombre])
                                            ->filter()
                                            ->implode(' - '),
                                    );
                                ?>
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <?php if($rowImage): ?>
                                                <img src="<?php echo e($rowImage); ?>" alt="<?php echo e($propiedad->titulo); ?>"
                                                    class="property-thumb mr-3">
                                            <?php else: ?>
                                                <div
                                                    class="property-thumb mr-3 d-flex align-items-center justify-content-center text-muted">
                                                    <i class="fas fa-image"></i>
                                                </div>
                                            <?php endif; ?>
                                            <div>
                                                <div class="font-weight-bold"><?php echo e($propiedad->titulo); ?></div>
                                                <div class="text-muted small"><?php echo e($propiedad->referencia); ?></div>
                                                <div class="small text-muted d-md-none">
                                                    <?php echo e($ubicacion !== '' ? $ubicacion : 'Sin ubicacion'); ?></div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="d-none d-md-table-cell">
                                        <div class="font-weight-semibold">
                                            <?php echo e($ubicacion !== '' ? $ubicacion : 'Sin ubicacion'); ?></div>
                                        <div class="small text-muted"><?php echo e(optional($propiedad)->created_at); ?></div>
                                    </td>
                                    <td class="d-none d-lg-table-cell font-weight-semibold">
                                        <?php echo e($propiedad->Moneda ?? 'RD$'); ?>

                                        <?php echo e(number_format((float) $propiedad->precio, 0, '.', ',')); ?></td>
                                    <td class="d-none d-lg-table-cell">
                                        <span
                                            class="badge badge-pill <?php echo e($isActive ? 'badge-success' : 'badge-secondary'); ?> mr-2"><?php echo e($isActive ? 'Activa' : 'Inactiva'); ?></span>
                                        <?php if($propiedad->destacada): ?>
                                            <span class="badge badge-pill badge-warning">Destacada</span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="text-right">
                                        <div class="d-inline-flex align-items-center">
                                            <a href="<?php echo e(route('propiedades.edit', $propiedad->id)); ?>"
                                                class="btn btn-outline-primary mr-2">
                                                Editar
                                            </a>
                                            <button type="button" class="btn btn-outline-danger"
                                                wire:click="$emit('generarBorrarPropiedadSweetAlert', <?php echo e($propiedad->id); ?>)">
                                                Borrar
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                <tr>
                                    <td colspan="5" class="text-center py-5 text-muted">
                                        No hay propiedades para mostrar con el criterio actual.
                                    </td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>

                <div class="mt-4">
                    <?php echo e($propiedades->links()); ?>

                </div>
            </div>
        </section>
    </div>
</div>
<?php /**PATH D:\xampp3\htdocs\realestate_dev\resources\views\livewire\buscar-propiedad.blade.php ENDPATH**/ ?>