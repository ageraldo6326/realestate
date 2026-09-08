

<?php $__env->startSection('title', 'Editar Propiedad'); ?>

<?php $__env->startSection('breadcrumb'); ?>
    <li class="breadcrumb-item"><a href="<?php echo e(route('propiedades.index')); ?>">Propiedades</a></li>
    <li class="breadcrumb-item active">Editar</li>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('page_title', 'Editar Propiedad'); ?>

<?php $__env->startSection('content'); ?>
    <?php
        $isAdmin =
            auth()->check() &&
            auth()
                ->user()
                ->hasAnyRole(['admin', 'superadmin']);
        $extraPhotos = ['foto1', 'foto2', 'foto3', 'foto4', 'foto5', 'foto6', 'foto7', 'foto8'];
        $amenities = [
            'lobby' => 'Lobby',
            'plantaelectrica' => 'Planta electrica',
            'camaravigilancia' => 'Camara de vigilancia',
            'escaleraemergencia' => 'Escalera de emergencia',
            'maderapreciosa' => 'Madera preciosa',
            'balcon' => 'Balcon',
            'walkincloset' => 'Walk in closet',
            'jacuzzi' => 'Jacuzzi',
            'areainfantil' => 'Area infantil',
            'banovisitas' => 'Bano de visitas',
            'cisterna' => 'Cisterna',
            'inversorareacomun' => 'Inversor area comun',
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
            'preinstalacionairetinacoinversor' => 'Pre-instalacion aire/tinaco/inversor',
            'terraza' => 'Terraza',
            'estudio' => 'Estudio',
            'gimnasio' => 'Gimnasio',
            'controldeacceso' => 'Control de acceso',
        ];

        $metaDescription = old('metadescription', $propiedad->metadescription ?: $propiedad->metadescripcion);
        $resolveImage = function ($value, $version = null) {
            if (!$value) {
                return '';
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
    ?>

    <div class="container-fluid modern-property-create py-4">
        <section class="create-hero mb-4">
            <div class="d-flex flex-wrap align-items-center justify-content-between gap-3">
                <div>
                    <h1 class="create-title mb-1">Editar Propiedad</h1>
                    <p class="create-subtitle mb-0">Actualiza la informacion comercial, SEO y multimedia usando el mismo
                        flujo visual de creacion.</p>
                </div>
                <div class="d-flex align-items-center flex-wrap gap-2">
                    <span class="badge badge-light text-primary px-3 py-2 rounded-pill">ID <?php echo e($propiedad->id); ?></span>
                    <span class="badge badge-light text-primary px-3 py-2 rounded-pill"><?php echo e($propiedad->referencia); ?></span>
                    <?php if($isAdmin): ?>
                        <a href="<?php echo e(route('asignar')); ?>" class="btn btn-outline-light">Asignar contacto</a>
                        <a href="<?php echo e(route('import.index')); ?>" class="btn btn-light text-dark border-0">Importar
                            contactos</a>
                    <?php endif; ?>
                </div>
            </div>
        </section>

        <div id="property-form-errors" class="alert alert-danger shadow-sm border-0 <?php echo e($errors->any() ? '' : 'd-none'); ?>"
            role="alert">
            <strong>Revisa los siguientes campos:</strong>
            <ul id="property-form-errors-list" class="mb-0 mt-2 pl-3">
                <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <li><?php echo e($error); ?></li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </ul>
        </div>

        <form action="<?php echo e(route('propiedades.update', $propiedad->id)); ?>" method="POST" enctype="multipart/form-data"
            novalidate>
            <?php echo csrf_field(); ?>
            <?php echo method_field('put'); ?>
            <input type="hidden" name="id" value="<?php echo e($propiedad->id); ?>">
            <input type="hidden" name="captada_por" value="<?php echo e($propiedad->captada_por ?: auth()->id()); ?>">
            <input type="hidden" name="foto_vendedor" value="<?php echo e($propiedad->foto_vendedor); ?>">
            <input type="hidden" name="metadescripcion" id="metadescripcion-sync" value="<?php echo e($metaDescription); ?>">

            <div class="row g-4">
                <div class="col-xl-8 property-form-sections">
                    <div class="card shadow-sm border-0 mb-4 property-section-main">
                        <div class="card-body p-4">
                            <h2 class="section-title">Informacion principal</h2>

                            <div class="form-group mb-2">
                                <label for="ia_instrucciones_propiedad" class="font-weight-bold">Instrucciones para IA
                                    (opcional)</label>
                                <input type="text" class="form-control" id="ia_instrucciones_propiedad" maxlength="220"
                                    placeholder="Ej: tono premium para inversionistas, enfocar rentabilidad y ubicacion">
                                <small class="form-text text-muted">Despues de completar caracteristicas, la IA puede
                                    generar titulo, descripcion y meta description.</small>
                            </div>

                            <div class="form-group mb-4">
                                <button type="button" class="btn btn-outline-primary" id="btn-generar-ia-propiedad">
                                    <span id="ia-propiedad-spinner" class="spinner-border spinner-border-sm mr-1 d-none"
                                        role="status" aria-hidden="true"></span>
                                    <span id="ia-propiedad-label">Regenerar textos con IA</span>
                                </button>
                            </div>

                            <div class="form-group mb-3">
                                <label for="titulo" class="font-weight-bold">Titulo <span
                                        class="text-danger">*</span></label>
                                <input type="text" class="form-control <?php $__errorArgs = ['titulo'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                    id="titulo" name="titulo" value="<?php echo e(old('titulo', $propiedad->titulo)); ?>"
                                    placeholder="Ej: Apartamento familiar en Naco" required minlength="10" maxlength="60">
                                <small class="form-text text-muted">Entre 10 y 60 caracteres.</small>
                            </div>

                            <div class="form-group mb-3">
                                <label for="descripcion_corta" class="font-weight-bold">Descripcion corta <span
                                        class="text-danger">*</span></label>
                                <input type="text" class="form-control <?php $__errorArgs = ['descripcion_corta'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                    id="descripcion_corta"
                                    value="<?php echo e(old('descripcion_corta', $propiedad->descripcion_corta)); ?>"
                                    name="descripcion_corta" placeholder="Resumen corto para listados y buscadores" required
                                    minlength="20" maxlength="160">
                                <small class="form-text text-muted">Entre 20 y 160 caracteres.</small>
                            </div>

                            <div class="form-group mb-3">
                                <label for="descripcion" class="font-weight-bold">Descripcion completa <span
                                        class="text-danger">*</span></label>
                                <textarea class="form-control <?php $__errorArgs = ['descripcion'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="descripcion" name="descripcion"
                                    rows="10" placeholder="Describe distribucion, entorno, acabados y beneficios" required><?php echo e(old('descripcion', $propiedad->descripcion)); ?></textarea>
                            </div>

                            <div class="form-group mb-0">
                                <label for="direccion" class="font-weight-bold">Direccion</label>
                                <textarea class="form-control <?php $__errorArgs = ['direccion'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="direccion" name="direccion" maxlength="200"
                                    rows="3" placeholder="Direccion referencial de la propiedad"><?php echo e(old('direccion', $propiedad->direccion)); ?></textarea>
                                <small class="form-text text-muted">Maximo 200 caracteres.</small>
                            </div>
                        </div>
                    </div>

                    <div class="card shadow-sm border-0 mb-4 property-section-commercial">
                        <div class="card-body p-4">
                            <h2 class="section-title">Datos comerciales</h2>

                            <div class="row">
                                <div class="col-md-6 form-group">
                                    <label for="provincia" class="font-weight-bold">Provincia <span
                                            class="text-danger">*</span></label>
                                    <select class="form-control <?php $__errorArgs = ['provincia'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" name="provincia"
                                        id="provincia" required>
                                        <option value="">Selecciona una provincia</option>
                                        <?php $__currentLoopData = $provincias; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $provincia): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($provincia->id); ?>"
                                                <?php echo e((string) old('provincia', $propiedad->provincia) === (string) $provincia->id ? 'selected' : ''); ?>>
                                                <?php echo e($provincia->provincia); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                </div>

                                <div class="col-md-6 form-group">
                                    <label for="sector_id" class="font-weight-bold">Sector <span
                                            class="text-danger">*</span></label>
                                    <select class="form-control <?php $__errorArgs = ['sector_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" name="sector_id"
                                        id="sector_id" required>
                                        <option value="">Selecciona un sector</option>
                                        <?php $__currentLoopData = $sectores; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sector): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($sector->id); ?>"
                                                data-provincia="<?php echo e($sector->provincia_id); ?>"
                                                <?php echo e((string) old('sector_id', $propiedad->sector_id) === (string) $sector->id ? 'selected' : ''); ?>>
                                                <?php echo e($sector->sector); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-3 form-group">
                                    <label for="tipomoneda" class="font-weight-bold">Moneda <span
                                            class="text-danger">*</span></label>
                                    <select class="form-control <?php $__errorArgs = ['tipomoneda'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                        name="tipomoneda" id="tipomoneda" required>
                                        <option value="">Selecciona</option>
                                        <option value="RD$"
                                            <?php echo e(old('tipomoneda', $propiedad->Moneda) === 'RD$' ? 'selected' : ''); ?>>RD$
                                        </option>
                                        <option value="US$"
                                            <?php echo e(old('tipomoneda', $propiedad->Moneda) === 'US$' ? 'selected' : ''); ?>>US$
                                        </option>
                                    </select>
                                </div>

                                <div class="col-md-5 form-group">
                                    <label for="precio" class="font-weight-bold">Precio <span
                                            class="text-danger">*</span></label>
                                    <input type="text" class="form-control monto <?php $__errorArgs = ['precio'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                        id="precio" name="precio" required placeholder="Ej: 12,500,000"
                                        value="<?php echo e(old('precio', $propiedad->precio)); ?>">
                                </div>

                                <div class="col-md-4 form-group">
                                    <label for="comision" class="font-weight-bold">Comision</label>
                                    <input type="number" step="0.01"
                                        class="form-control <?php $__errorArgs = ['comision'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="comision"
                                        name="comision" placeholder="Ej: 3.5"
                                        value="<?php echo e(old('comision', $propiedad->comision)); ?>">
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-4 form-group">
                                    <label for="tipo" class="font-weight-bold">Tipo de propiedad <span
                                            class="text-danger">*</span></label>
                                    <select class="form-control <?php $__errorArgs = ['tipo'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" name="tipo"
                                        id="tipo" required>
                                        <option value="">Selecciona</option>
                                        <?php $__currentLoopData = $tipos_propiedades; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tipos_propiedad): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($tipos_propiedad->id); ?>"
                                                <?php echo e((string) old('tipo', $propiedad->tipo) === (string) $tipos_propiedad->id ? 'selected' : ''); ?>>
                                                <?php echo e($tipos_propiedad->tipo); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                </div>

                                <div class="col-md-4 form-group">
                                    <label for="disponible_para" class="font-weight-bold">Disponible para <span
                                            class="text-danger">*</span></label>
                                    <select class="form-control <?php $__errorArgs = ['disponible_para'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                        name="disponible_para" id="disponible_para" required>
                                        <option value="">Selecciona</option>
                                        <?php $__currentLoopData = $disponibles_para; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $disponible_para): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($disponible_para->id); ?>"
                                                <?php echo e((string) old('disponible_para', $propiedad->disponible_para) === (string) $disponible_para->id ? 'selected' : ''); ?>>
                                                <?php echo e($disponible_para->disponible_para); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                </div>

                                <div class="col-md-4 form-group">
                                    <label for="estadopropiedad" class="font-weight-bold">Estado de propiedad <span
                                            class="text-danger">*</span></label>
                                    <select class="form-control <?php $__errorArgs = ['estadopropiedad'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                        name="estadopropiedad" id="estadopropiedad" required>
                                        <option value="">Selecciona</option>
                                        <?php $__currentLoopData = $estados_propiedad; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $estado_propiedad): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($estado_propiedad->id); ?>"
                                                <?php echo e((string) old('estadopropiedad', $propiedad->estado_id) === (string) $estado_propiedad->id ? 'selected' : ''); ?>>
                                                <?php echo e($estado_propiedad->estado); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-2 form-group">
                                    <label for="habitaciones" class="font-weight-bold">Hab <span
                                            class="text-danger">*</span></label>
                                    <select class="form-control <?php $__errorArgs = ['habitaciones'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                        name="habitaciones" id="habitaciones" required>
                                        <option value="">-</option>
                                        <?php for($i = 0; $i <= 5; $i++): ?>
                                            <option value="<?php echo e($i); ?>"
                                                <?php echo e((string) old('habitaciones', $propiedad->habitaciones) === (string) $i ? 'selected' : ''); ?>>
                                                <?php echo e($i); ?></option>
                                        <?php endfor; ?>
                                    </select>
                                </div>

                                <div class="col-md-2 form-group">
                                    <label for="banos" class="font-weight-bold">Banos <span
                                            class="text-danger">*</span></label>
                                    <select class="form-control <?php $__errorArgs = ['banos'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" name="banos"
                                        id="banos" required>
                                        <option value="">-</option>
                                        <?php $__currentLoopData = ['0', '1', '1.5', '2', '2.5', '3', '3.5', '4', '4.5', '5', '5.5']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $banio): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($banio); ?>"
                                                <?php echo e((string) old('banos', $propiedad->banos) === (string) $banio ? 'selected' : ''); ?>>
                                                <?php echo e($banio); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                </div>

                                <div class="col-md-2 form-group">
                                    <label for="parqueos" class="font-weight-bold">Parqueos <span
                                            class="text-danger">*</span></label>
                                    <select class="form-control <?php $__errorArgs = ['parqueos'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" name="parqueos"
                                        id="parqueos" required>
                                        <option value="">-</option>
                                        <?php for($i = 0; $i <= 5; $i++): ?>
                                            <option value="<?php echo e($i); ?>"
                                                <?php echo e((string) old('parqueos', $propiedad->parqueos) === (string) $i ? 'selected' : ''); ?>>
                                                <?php echo e($i); ?></option>
                                        <?php endfor; ?>
                                    </select>
                                </div>

                                <div class="col-md-3 form-group">
                                    <label for="metraje" class="font-weight-bold">Metraje <span
                                            class="text-danger">*</span></label>
                                    <input type="text" class="form-control <?php $__errorArgs = ['metraje'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                        id="metraje" name="metraje" placeholder="Ej: 185"
                                        value="<?php echo e(old('metraje', $propiedad->metraje)); ?>" required>
                                </div>

                                <div class="col-md-3 form-group">
                                    <label for="metraje_construccion" class="font-weight-bold">Metraje
                                        construccion</label>
                                    <input type="text"
                                        class="form-control <?php $__errorArgs = ['metraje_construccion'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                        id="metraje_construccion" name="metraje_construccion" placeholder="Ej: 160"
                                        value="<?php echo e(old('metraje_construccion', $propiedad->metraje_construccion)); ?>">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card shadow-sm border-0 mb-4 property-section-amenities">
                        <div class="card-body p-4">
                            <div class="d-flex align-items-center justify-content-between flex-wrap mb-3">
                                <h2 class="section-title mb-0">Amenidades y estado</h2>
                                <small class="text-muted">Selecciona solo las que apliquen</small>
                            </div>

                            <div class="d-flex flex-wrap gap-2 mb-3">
                                <label class="toggle-chip">
                                    <input type="checkbox" name="destacada" id="destacada"
                                        <?php echo e(old('destacada', $propiedad->destacada) ? 'checked' : ''); ?>>
                                    <span>Destacada</span>
                                </label>
                                <label class="toggle-chip">
                                    <input type="checkbox" name="vendida" id="vendida"
                                        <?php echo e(old('vendida', $propiedad->vendida) ? 'checked' : ''); ?>>
                                    <span>Vendida</span>
                                </label>
                                <label class="toggle-chip">
                                    <input type="checkbox" name="activa" id="activa"
                                        <?php echo e(old('activa', $propiedad->activa) ? 'checked' : ''); ?>>
                                    <span>Activa</span>
                                </label>
                                <label class="toggle-chip">
                                    <input type="checkbox" name="marcadeagua" id="marcadeagua"
                                        <?php echo e(old('marcadeagua', $propiedad->marcadeagua) ? 'checked' : ''); ?>>
                                    <span>Aplicar marca de agua del logo</span>
                                </label>
                                <?php if((bool) optional($inmobiliaria)->aprobacion && $isAdmin): ?>
                                    <label class="toggle-chip">
                                        <input type="checkbox" name="aprobada" id="aprobada"
                                            <?php echo e(old('aprobada', $propiedad->aprobada) ? 'checked' : ''); ?>>
                                        <span>Aprobada</span>
                                    </label>
                                <?php endif; ?>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-4 form-group mb-0">
                                    <label for="fechacierre" class="font-weight-bold">Fecha de cierre</label>
                                    <input type="date" class="form-control" id="fechacierre" name="fechacierre"
                                        value="<?php echo e(old('fechacierre', $propiedad->fechacierre)); ?>">
                                </div>
                            </div>

                            <div class="row">
                                <?php $__currentLoopData = $amenities; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <div class="col-sm-6 col-md-4 col-lg-3 mb-2">
                                        <label class="toggle-chip w-100 mb-0">
                                            <input type="checkbox" name="<?php echo e($key); ?>" id="<?php echo e($key); ?>"
                                                <?php echo e(old($key, data_get($propiedad, $key)) ? 'checked' : ''); ?>>
                                            <span><?php echo e($label); ?></span>
                                        </label>
                                    </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-4">
                    <div class="card shadow-sm border-0 mb-4 sticky-media-card">
                        <div class="card-body p-4">
                            <h2 class="section-title">Portada y galeria</h2>

                            <div class="form-group mb-4">
                                <label class="font-weight-bold d-block mb-2">Foto principal</label>
                                <div class="edit-dropzone edit-dropzone-cover" id="cover-dropzone" tabindex="0"
                                    role="button">
                                    <img src="<?php echo e($resolveImage($propiedad->foto_portada, optional($propiedad)->updated_at)); ?>"
                                        alt="Portada actual" id="cover-preview"
                                        class="dropzone-cover-preview <?php echo e($propiedad->foto_portada ? '' : 'd-none'); ?>">
                                    <div id="cover-empty"
                                        class="dropzone-empty-state <?php echo e($propiedad->foto_portada ? 'd-none' : ''); ?>">
                                        <strong><?php echo e($propiedad->foto_portada ? 'Reemplazar portada' : 'Selecciona una portada'); ?></strong>
                                        <span>JPG, PNG o WebP horizontal.</span>
                                    </div>
                                </div>
                                <input type="file" class="d-none" id="foto_portada" name="foto_portada"
                                    accept="image/*">
                                <small class="form-text text-muted d-block mt-2">Haz clic o arrastra una imagen para
                                    reemplazar la portada actual.</small>
                            </div>

                            <div class="form-group mb-3">
                                <label class="font-weight-bold d-block mb-2">Galeria (opcionales)</label>
                                <div class="gallery-slot-grid">
                                    <?php $__currentLoopData = $extraPhotos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $photoField): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <?php
                                            $photoValue = data_get($propiedad, $photoField);
                                            $removeField = 'ckfoto' . ($index + 1);
                                            $slotId = 'slot-' . ($index + 1);
                                            $previewId = 'preview-' . ($index + 1);
                                            $emptyId = 'empty-' . ($index + 1);
                                        ?>
                                        <div class="gallery-slot-card">
                                            <div class="small font-weight-bold text-muted mb-2">
                                                <?php echo e(strtoupper($photoField)); ?></div>
                                            <div class="edit-dropzone gallery-dropzone" id="<?php echo e($slotId); ?>"
                                                tabindex="0" role="button">
                                                <img src="<?php echo e($resolveImage($photoValue, optional($propiedad)->updated_at)); ?>"
                                                    alt="<?php echo e($photoField); ?>" id="<?php echo e($previewId); ?>"
                                                    class="gallery-preview-image <?php echo e($photoValue ? '' : 'd-none'); ?>">
                                                <div id="<?php echo e($emptyId); ?>"
                                                    class="dropzone-empty-state <?php echo e($photoValue ? 'd-none' : ''); ?>">
                                                    <strong><?php echo e($photoValue ? 'Reemplazar foto' : 'Agregar foto'); ?></strong>
                                                    <span><?php echo e($photoValue ? 'Puedes soltar una nueva imagen aqui.' : 'Slot disponible'); ?></span>
                                                </div>
                                            </div>
                                            <input type="file" class="d-none" id="<?php echo e($photoField); ?>"
                                                name="<?php echo e($photoField); ?>" accept="image/*">
                                            <?php if($photoValue): ?>
                                                <label
                                                    class="toggle-chip w-100 justify-content-center mt-2 mb-0 remove-chip">
                                                    <input type="checkbox" name="<?php echo e($removeField); ?>"
                                                        id="<?php echo e($removeField); ?>">
                                                    <span>Eliminar actual</span>
                                                </label>
                                            <?php endif; ?>
                                        </div>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </div>
                            </div>

                            <hr class="my-3">

                            <div class="form-group mb-0">
                                <label for="video1" class="font-weight-bold">Video de YouTube</label>
                                <input class="form-control" type="text" id="video1" name="video1"
                                    value="<?php echo e(old('video1', $propiedad->video1)); ?>"
                                    placeholder="https://www.youtube.com/watch?v=...">
                                <small class="form-text text-muted">Opcional: enlace completo del video</small>
                                <div id="video1-preview-wrapper" class="mt-3 d-none" aria-live="polite">
                                    <div class="rounded overflow-hidden border"
                                        style="position:relative; padding-top:56.25%; background:#f6f8fb;">
                                        <iframe id="video1-preview-frame" src=""
                                            title="Vista previa del video de YouTube" loading="lazy"
                                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                                            allowfullscreen referrerpolicy="strict-origin-when-cross-origin"
                                            style="position:absolute; inset:0; width:100%; height:100%; border:0;"></iframe>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-12">
                    <div class="card shadow-sm border-0 mb-4">
                        <div class="card-body p-4">
                            <h2 class="section-title">SEO de la propiedad</h2>
                            <div class="form-group mb-0">
                                <label for="metadescription" class="font-weight-bold">Meta description <span
                                        class="text-danger">*</span></label>
                                <textarea class="form-control <?php $__errorArgs = ['metadescription'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="metadescription"
                                    name="metadescription" minlength="20" maxlength="160" rows="4" required
                                    placeholder="Descripcion para buscadores (20-160 caracteres)"><?php echo e($metaDescription); ?></textarea>
                                <small class="form-text text-muted d-block mt-2">Entre 20 y 160 caracteres para
                                    buscadores.</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row g-4">
                <div class="col-12">
                    <div class="d-grid gap-2 gap-sm-3" style="grid-auto-flow: column; grid-auto-columns: 1fr;">
                        <button type="submit" class="btn btn-primary btn-lg">Guardar cambios</button>
                        <a href="<?php echo e(route('propiedades.index')); ?>" class="btn btn-light border">Cancelar</a>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <style>
        .modern-property-create {
            --brand-900: #12343b;
            --brand-700: #1c4f59;
            --brand-100: #eaf3f5;
            --accent-600: #b66a20;
            --neutral-200: #e5e7eb;
        }

        .create-hero {
            background: linear-gradient(130deg, var(--brand-900), var(--brand-700));
            color: #fff;
            border-radius: 1rem;
            padding: 1.5rem;
            box-shadow: 0 10px 20px rgba(18, 52, 59, 0.2);
        }

        .create-title {
            font-size: 1.8rem;
            font-weight: 700;
            letter-spacing: 0.01em;
        }

        .create-subtitle {
            opacity: 0.9;
            max-width: 760px;
        }

        .section-title {
            font-size: 1.1rem;
            font-weight: 700;
            color: var(--brand-900);
            margin-bottom: 1rem;
        }

        .property-form-sections {
            display: flex;
            flex-direction: column;
        }

        .property-section-commercial {
            order: 1;
        }

        .property-section-amenities {
            order: 2;
        }

        .property-section-main {
            order: 3;
        }

        .sticky-media-card {
            position: sticky;
            top: 1rem;
        }

        .toggle-chip {
            display: inline-flex;
            align-items: center;
            gap: 0.55rem;
            border: 1px solid var(--neutral-200);
            border-radius: 999px;
            padding: 0.4rem 0.75rem;
            cursor: pointer;
            background: #fff;
            transition: all 0.2s ease;
        }

        .toggle-chip:hover {
            border-color: #c3ccd6;
            transform: translateY(-1px);
        }

        .toggle-chip input {
            width: 1rem;
            height: 1rem;
        }

        .toggle-chip input:checked+span {
            font-weight: 600;
            color: var(--accent-600);
        }

        .edit-dropzone {
            border: 2px dashed #d4d9e0;
            border-radius: 0.75rem;
            padding: 1rem;
            background: #f8f9fa;
            cursor: pointer;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .edit-dropzone:hover,
        .edit-dropzone:focus,
        .edit-dropzone.is-dragover {
            background: #f5f7fa;
            border-color: #b66a20;
            outline: none;
        }

        .edit-dropzone-cover {
            min-height: 240px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .dropzone-cover-preview,
        .gallery-preview-image {
            width: 100%;
            height: 100%;
            object-fit: cover;
            border-radius: 0.6rem;
        }

        .dropzone-empty-state {
            min-height: 120px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            text-align: center;
            color: #6c757d;
            gap: 0.25rem;
            font-size: 0.9rem;
        }

        .dropzone-empty-state strong {
            color: #1c4f59;
        }

        .gallery-slot-grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 0.85rem;
        }

        .gallery-slot-card {
            border: 1px solid #e5e7eb;
            border-radius: 0.85rem;
            padding: 0.75rem;
            background: #fbfcfd;
        }

        .gallery-dropzone {
            min-height: 150px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .remove-chip {
            font-size: 0.85rem;
        }

        .ck-editor__editable_inline {
            min-height: 320px;
        }

        @media (max-width: 1199.98px) {
            .sticky-media-card {
                position: static;
            }
        }

        @media (max-width: 767.98px) {
            .gallery-slot-grid {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 575.98px) {
            .create-title {
                font-size: 1.45rem;
            }

            .d-grid[style*='grid-auto-flow: column'] {
                grid-auto-flow: row !important;
                grid-auto-columns: unset !important;
            }
        }
    </style>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const metaVisible = document.getElementById('metadescription');
            const metaHidden = document.getElementById('metadescripcion-sync');

            const extractYouTubeId = (value) => {
                const rawValue = (value || '').trim();
                if (!rawValue) {
                    return '';
                }

                const idPattern = /^[a-zA-Z0-9_-]{11}$/;
                if (idPattern.test(rawValue)) {
                    return rawValue;
                }

                try {
                    const parsedUrl = new URL(rawValue);
                    const hostname = parsedUrl.hostname.replace('www.', '');

                    if (hostname === 'youtu.be') {
                        return parsedUrl.pathname.split('/').filter(Boolean)[0] || '';
                    }

                    if (hostname === 'youtube.com' || hostname === 'm.youtube.com' || hostname ===
                        'youtube-nocookie.com') {
                        if (parsedUrl.pathname === '/watch') {
                            return parsedUrl.searchParams.get('v') || '';
                        }

                        const pathParts = parsedUrl.pathname.split('/').filter(Boolean);
                        if (pathParts[0] === 'embed' || pathParts[0] === 'shorts') {
                            return pathParts[1] || '';
                        }
                    }
                } catch (error) {
                    // Si no es URL valida, intentamos extraer un ID suelto.
                }

                const fallbackMatch = rawValue.match(
                    /(?:v=|\/embed\/|youtu\.be\/|\/shorts\/)([a-zA-Z0-9_-]{11})/
                );
                return fallbackMatch ? fallbackMatch[1] : '';
            };

            const refreshVideoPreview = () => {
                const videoInput = document.getElementById('video1');
                const previewWrapper = document.getElementById('video1-preview-wrapper');
                const previewFrame = document.getElementById('video1-preview-frame');

                if (!videoInput || !previewWrapper || !previewFrame) {
                    return;
                }

                const videoId = extractYouTubeId(videoInput.value);
                if (!videoId) {
                    previewFrame.src = '';
                    previewWrapper.classList.add('d-none');
                    return;
                }

                previewFrame.src = `https://www.youtube.com/embed/${videoId}`;
                previewWrapper.classList.remove('d-none');
            };

            const videoInput = document.getElementById('video1');
            if (videoInput) {
                videoInput.addEventListener('input', refreshVideoPreview);
                videoInput.addEventListener('blur', refreshVideoPreview);
                refreshVideoPreview();
            }

            if (metaVisible && metaHidden) {
                const syncMeta = () => {
                    metaHidden.value = metaVisible.value;
                };

                metaVisible.addEventListener('input', syncMeta);
                syncMeta();
            }

            const aiButton = document.getElementById('btn-generar-ia-propiedad');
            const aiInstructions = document.getElementById('ia_instrucciones_propiedad');
            const tituloField = document.getElementById('titulo');
            const descripcionField = document.getElementById('descripcion');
            const descripcionCortaField = document.getElementById('descripcion_corta');
            const provinciaSelect = document.getElementById('provincia');
            const sectorSelect = document.getElementById('sector_id');

            const requiredCommercialSelects = [{
                    id: 'provincia',
                    label: 'Provincia'
                },
                {
                    id: 'sector_id',
                    label: 'Sector'
                },
                {
                    id: 'tipomoneda',
                    label: 'Moneda'
                },
                {
                    id: 'tipo',
                    label: 'Tipo de propiedad'
                },
                {
                    id: 'disponible_para',
                    label: 'Disponible para'
                },
                {
                    id: 'estadopropiedad',
                    label: 'Estado de propiedad'
                },
                {
                    id: 'habitaciones',
                    label: 'Habitaciones'
                },
                {
                    id: 'banos',
                    label: 'Banos'
                },
                {
                    id: 'parqueos',
                    label: 'Parqueos'
                },
            ];
            const nonAmenityToggleIds = new Set(['destacada', 'vendida', 'activa', 'aprobada', 'marcadeagua']);

            const selectedText = (selectId) => {
                const select = document.getElementById(selectId);
                if (!select || select.selectedIndex < 0) {
                    return '';
                }

                return (select.options[select.selectedIndex]?.text || '').trim();
            };

            const getSelectedAmenities = () => Array.from(document.querySelectorAll(
                    '.toggle-chip input[type="checkbox"]:checked'))
                .filter((item) => !nonAmenityToggleIds.has(item.id))
                .map((item) => item.parentElement?.innerText?.trim())
                .filter(Boolean);

            const allSectorOptions = sectorSelect ? Array.from(sectorSelect.options).map((option) => ({
                value: option.value,
                text: option.text,
                provincia: option.dataset.provincia || ''
            })) : [];

            const refreshSectorOptions = () => {
                if (!provinciaSelect || !sectorSelect) {
                    return;
                }

                const provinciaValue = provinciaSelect.value;
                const currentValue = sectorSelect.value;
                let hasCurrent = false;

                sectorSelect.innerHTML = '';

                allSectorOptions.forEach((item) => {
                    if (item.value && provinciaValue && item.provincia !== provinciaValue) {
                        return;
                    }

                    const option = document.createElement('option');
                    option.value = item.value;
                    option.text = item.text;

                    if (item.provincia) {
                        option.dataset.provincia = item.provincia;
                    }

                    if (item.value && item.value === currentValue) {
                        option.selected = true;
                        hasCurrent = true;
                    }

                    sectorSelect.appendChild(option);
                });

                if (!hasCurrent) {
                    sectorSelect.value = '';
                }
            };

            provinciaSelect?.addEventListener('change', refreshSectorOptions);
            refreshSectorOptions();

            const validateAiPrerequisites = () => {
                const missingCommercialSelections = requiredCommercialSelects.filter((field) => {
                    const select = document.getElementById(field.id);
                    return !select || !String(select.value || '').trim();
                });

                const selectedAmenities = getSelectedAmenities();

                if (!missingCommercialSelections.length && selectedAmenities.length > 0) {
                    return {
                        ok: true,
                        selectedAmenities,
                    };
                }

                const warnings = [];
                if (missingCommercialSelections.length) {
                    warnings.push(
                        `<strong>Datos comerciales:</strong> ${missingCommercialSelections.map((item) => item.label).join(', ')}`
                    );
                }

                if (selectedAmenities.length === 0) {
                    warnings.push('<strong>Amenidades y estado:</strong> selecciona al menos una amenidad.');
                }

                if (window.Swal) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Completa el contexto antes de usar IA',
                        html: warnings.join('<br>'),
                        confirmButtonText: 'Entendido',
                    });
                }

                if (missingCommercialSelections.length) {
                    document.getElementById(missingCommercialSelections[0].id)?.focus();
                } else {
                    document.querySelector(
                        '.toggle-chip input[type="checkbox"]:not(#destacada):not(#vendida):not(#activa):not(#aprobada)'
                    )?.focus();
                }

                return {
                    ok: false,
                    selectedAmenities,
                };
            };

            const getEditorContent = () => {
                if (window.__propiedadDescripcionEditor) {
                    return window.__propiedadDescripcionEditor.getData() || '';
                }

                if (typeof CKEDITOR !== 'undefined' && CKEDITOR.instances && CKEDITOR.instances.descripcion) {
                    return CKEDITOR.instances.descripcion.getData() || '';
                }

                return descripcionField?.value || '';
            };

            const setEditorContent = (value) => {
                if (window.__propiedadDescripcionEditor) {
                    window.__propiedadDescripcionEditor.setData(value || '');
                }

                if (typeof CKEDITOR !== 'undefined' && CKEDITOR.instances && CKEDITOR.instances.descripcion) {
                    CKEDITOR.instances.descripcion.setData(value || '');
                }

                if (descripcionField) {
                    descripcionField.value = value || '';
                }
            };

            if (aiButton) {
                const endpoint = '<?php echo e(route('admin.ai.generate')); ?>';
                const csrf = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';

                aiButton.addEventListener('click', async () => {
                    const aiPrerequisites = validateAiPrerequisites();
                    if (!aiPrerequisites.ok) {
                        return;
                    }

                    const checkedAmenities = aiPrerequisites.selectedAmenities;

                    const contexto = {
                        referencia: '<?php echo e($propiedad->referencia); ?>',
                        titulo: tituloField?.value || '',
                        descripcion_actual: getEditorContent(),
                        descripcion_corta_actual: descripcionCortaField?.value || '',
                        metadescription_actual: metaVisible?.value || '',
                        provincia: selectedText('provincia'),
                        sector: selectedText('sector_id'),
                        tipo_propiedad: selectedText('tipo'),
                        disponible_para: selectedText('disponible_para'),
                        estado: selectedText('estadopropiedad'),
                        moneda: selectedText('tipomoneda'),
                        precio: document.getElementById('precio')?.value || '',
                        habitaciones: document.getElementById('habitaciones')?.value || '',
                        banos: document.getElementById('banos')?.value || '',
                        parqueos: document.getElementById('parqueos')?.value || '',
                        metraje: document.getElementById('metraje')?.value || '',
                        metraje_construccion: document.getElementById('metraje_construccion')
                            ?.value || '',
                        amenidades: checkedAmenities,
                    };

                    aiButton.disabled = true;
                    const aiSpinner = document.getElementById('ia-propiedad-spinner');
                    const aiLabel = document.getElementById('ia-propiedad-label');
                    if (aiSpinner) aiSpinner.classList.remove('d-none');
                    if (aiLabel) aiLabel.textContent = 'Generando...';

                    try {
                        const response = await fetch(endpoint, {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': csrf,
                                'Accept': 'application/json',
                            },
                            body: JSON.stringify({
                                type: 'inmueble',
                                instrucciones: aiInstructions?.value || '',
                                contexto,
                            }),
                        });

                        const result = await response.json();
                        if (!response.ok || !result.ok) {
                            throw new Error(result.message || 'No fue posible generar contenido.');
                        }

                        const data = result.data || {};
                        if (data.titulo_sugerido && tituloField) {
                            tituloField.value = data.titulo_sugerido;
                        }

                        if (data.descripcion) {
                            setEditorContent(data.descripcion);
                        }

                        if (data.descripcion_corta && descripcionCortaField) {
                            descripcionCortaField.value = data.descripcion_corta;
                        }

                        if (data.metadescription && metaVisible) {
                            metaVisible.value = data.metadescription;
                            if (metaHidden) {
                                metaHidden.value = data.metadescription;
                            }
                        }

                        if (window.Swal) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Textos regenerados',
                                text: 'Puedes ajustar el resultado antes de guardar.',
                                timer: 1800,
                                showConfirmButton: false,
                            });
                        }
                    } catch (error) {
                        if (window.Swal) {
                            Swal.fire('Error', error.message ||
                                'No fue posible generar contenido con IA.', 'error');
                        }
                    } finally {
                        aiButton.disabled = false;
                        if (aiSpinner) aiSpinner.classList.add('d-none');
                        if (aiLabel) aiLabel.textContent = 'Regenerar textos con IA';
                    }
                });
            }

            const propertyForm = document.querySelector('form[action*="propiedades.update"]') || document
                .querySelector('form');
            const coverDropzone = document.getElementById('cover-dropzone');

            const clearClientValidationErrors = () => {
                document.querySelectorAll('.js-client-invalid').forEach((element) => {
                    element.classList.remove('is-invalid', 'js-client-invalid');
                });

                document.querySelectorAll('.js-client-feedback').forEach((element) => {
                    element.remove();
                });
            };

            const showFormErrors = (errors) => {
                const errorsContainer = document.getElementById('property-form-errors');
                const errorsList = document.getElementById('property-form-errors-list');

                if (!errorsContainer || !errorsList) {
                    return;
                }

                errorsList.innerHTML = '';

                Object.values(errors).flat().forEach((message) => {
                    const item = document.createElement('li');
                    item.textContent = message;
                    errorsList.appendChild(item);
                });

                errorsContainer.classList.remove('d-none');
                errorsContainer.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            };

            const setFieldInvalid = (fieldName, message) => {
                if (!propertyForm) {
                    return;
                }

                const field = propertyForm.querySelector(`[name="${fieldName}"]`);

                if (!field) {
                    return;
                }

                field.classList.add('is-invalid', 'js-client-invalid');

                const feedback = document.createElement('div');
                feedback.className = 'invalid-feedback d-block js-client-feedback';
                feedback.textContent = message;
                field.insertAdjacentElement('afterend', feedback);
            };

            const setCoverInvalidState = (isInvalid, message = 'Revisa la portada de la propiedad.') => {
                if (!coverDropzone) {
                    return;
                }

                const feedbackId = 'foto-portada-feedback';
                const existingFeedback = document.getElementById(feedbackId);

                if (isInvalid) {
                    coverDropzone.classList.add('is-invalid', 'js-client-invalid');

                    if (!existingFeedback) {
                        const feedback = document.createElement('div');
                        feedback.id = feedbackId;
                        feedback.className = 'invalid-feedback d-block mt-2 js-client-feedback';
                        feedback.textContent = message;
                        coverDropzone.parentElement.appendChild(feedback);
                    }
                } else {
                    coverDropzone.classList.remove('is-invalid', 'js-client-invalid');
                    if (existingFeedback) {
                        existingFeedback.remove();
                    }
                }
            };

            const submitEditForm = async (event) => {
                if (!propertyForm) {
                    return;
                }

                event.preventDefault();
                clearClientValidationErrors();
                setCoverInvalidState(false);

                const errorsContainer = document.getElementById('property-form-errors');
                if (errorsContainer) {
                    errorsContainer.classList.add('d-none');
                }

                if (window.__propiedadDescripcionEditor) {
                    const descripcionInput = document.getElementById('descripcion');
                    if (descripcionInput) {
                        descripcionInput.value = window.__propiedadDescripcionEditor.getData();
                    }
                }

                if (metaVisible && metaHidden) {
                    metaHidden.value = metaVisible.value;
                }

                const submitButton = propertyForm.querySelector('button[type="submit"]');
                if (submitButton) {
                    submitButton.disabled = true;
                }

                try {
                    const formData = new FormData(propertyForm);
                    const response = await fetch(propertyForm.action, {
                        method: 'POST',
                        body: formData,
                        headers: {
                            Accept: 'application/json',
                            'X-Requested-With': 'XMLHttpRequest',
                        },
                    });

                    if (response.ok) {
                        if (response.redirected && response.url) {
                            window.location.href = response.url;
                            return;
                        }

                        window.location.reload();
                        return;
                    }

                    if (response.status === 422) {
                        const payload = await response.json();
                        const errors = payload.errors || {};

                        showFormErrors(errors);
                        Object.entries(errors).forEach(([fieldName, fieldErrors]) => {
                            if (fieldName === 'foto_portada') {
                                const coverError = Array.isArray(fieldErrors) && fieldErrors
                                    .length > 0 ?
                                    fieldErrors[0] :
                                    'Revisa la portada de la propiedad.';
                                setCoverInvalidState(true, coverError);
                                return;
                            }

                            if (Array.isArray(fieldErrors) && fieldErrors.length > 0) {
                                setFieldInvalid(fieldName, fieldErrors[0]);
                            }
                        });

                        return;
                    }

                    showFormErrors({
                        general: ['No fue posible actualizar la propiedad. Intenta nuevamente.']
                    });
                } catch (error) {
                    showFormErrors({
                        general: ['Error de conexion. Revisa tu red e intenta nuevamente.']
                    });
                } finally {
                    if (submitButton) {
                        submitButton.disabled = false;
                    }
                }
            };

            if (propertyForm) {
                propertyForm.addEventListener('submit', submitEditForm);
            }

            const bindDropzone = ({
                zoneId,
                inputId,
                previewId,
                emptyId,
                removeId
            }) => {
                const zone = document.getElementById(zoneId);
                const input = document.getElementById(inputId);
                const preview = previewId ? document.getElementById(previewId) : null;
                const empty = emptyId ? document.getElementById(emptyId) : null;
                const removeCheckbox = removeId ? document.getElementById(removeId) : null;

                if (!zone || !input) {
                    return;
                }

                const openPicker = () => input.click();

                zone.addEventListener('click', (event) => {
                    if (event.target.closest('label') || event.target.closest(
                            'input[type="checkbox"]')) {
                        return;
                    }
                    openPicker();
                });

                zone.addEventListener('keydown', (event) => {
                    if (event.key === 'Enter' || event.key === ' ') {
                        event.preventDefault();
                        openPicker();
                    }
                });

                ['dragenter', 'dragover'].forEach((eventName) => {
                    zone.addEventListener(eventName, (event) => {
                        event.preventDefault();
                        zone.classList.add('is-dragover');
                    });
                });

                ['dragleave', 'dragend', 'drop'].forEach((eventName) => {
                    zone.addEventListener(eventName, (event) => {
                        event.preventDefault();
                        zone.classList.remove('is-dragover');
                    });
                });

                zone.addEventListener('drop', (event) => {
                    const file = event.dataTransfer?.files?.[0];
                    if (!file) {
                        return;
                    }

                    const transfer = new DataTransfer();
                    transfer.items.add(file);
                    input.files = transfer.files;
                    input.dispatchEvent(new Event('change', {
                        bubbles: true
                    }));
                });

                input.addEventListener('change', () => {
                    const file = input.files?.[0];
                    if (!file || !preview) {
                        return;
                    }

                    const reader = new FileReader();
                    reader.onload = (loadEvent) => {
                        preview.src = loadEvent.target.result;
                        preview.classList.remove('d-none');
                        if (empty) {
                            empty.classList.add('d-none');
                        }
                        if (removeCheckbox) {
                            removeCheckbox.checked = false;
                        }
                    };
                    reader.readAsDataURL(file);
                });
            };

            bindDropzone({
                zoneId: 'cover-dropzone',
                inputId: 'foto_portada',
                previewId: 'cover-preview',
                emptyId: 'cover-empty',
            });

            [1, 2, 3, 4, 5, 6, 7, 8].forEach((index) => {
                bindDropzone({
                    zoneId: `slot-${index}`,
                    inputId: `foto${index}`,
                    previewId: `preview-${index}`,
                    emptyId: `empty-${index}`,
                    removeId: `ckfoto${index}`,
                });
            });

            if (typeof CKEDITOR !== 'undefined' && CKEDITOR.instances.descripcion) {
                return;
            }

            if (typeof ClassicEditor !== 'undefined') {
                ClassicEditor
                    .create(document.querySelector('#descripcion'), {
                        toolbar: ['heading', '|', 'bold', 'italic', 'link', 'bulletedList', 'numberedList',
                            'blockQuote'
                        ],
                        heading: {
                            options: [{
                                    model: 'paragraph',
                                    title: 'Parrafo',
                                    class: 'ck-heading_paragraph'
                                },
                                {
                                    model: 'heading1',
                                    view: 'h1',
                                    title: 'Encabezado 1',
                                    class: 'ck-heading_heading1'
                                },
                                {
                                    model: 'heading2',
                                    view: 'h2',
                                    title: 'Encabezado 2',
                                    class: 'ck-heading_heading2'
                                }
                            ]
                        }
                    })
                    .then((editor) => {
                        window.__propiedadDescripcionEditor = editor;
                        editor.editing.view.change((writer) => {
                            writer.setStyle('min-height', '320px', editor.editing.view.document
                                .getRoot());
                        });
                    })
                    .catch((error) => {
                        console.error('CKEditor 5 error:', error);
                    });
            }
        });
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('admin.layoutadmin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xampp3\htdocs\realestate_dev\resources\views\admin\propiedades\edit.blade.php ENDPATH**/ ?>