

<?php $__env->startSection('content'); ?>
    <?php
        $isAdmin =
            auth()->check() &&
            auth()
                ->user()
                ->hasAnyRole(['admin', 'superadmin']);
    ?>
    <div class="container">
        <div class="row">

            <div class="col-md-12">

                <?php if($errors->any()): ?>
                    <div class="alert alert-danger">
                        <ul>
                            <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <li><?php echo e($error); ?></li>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </ul>
                    </div>
                <?php endif; ?>

                <form action="<?php echo e(route('updatependientes', $propiedad->id)); ?>" method="POST" enctype="multipart/form-data">
                    <?php echo csrf_field(); ?>
                    <?php echo method_field('put'); ?>
                    <input type="hidden" name="id" value="<?php echo e($propiedad->id); ?>">
                    <div class="mb-3">
                        <label for="formFile" class="form-label">Foto Principal</label>
                        <input class="form-control" type="file" id="foto_portada" name="foto_portada"
                            value="<?php echo e($propiedad->foto_portada); ?>">
                    </div>

                    <div class="row">
                        <div class="form-group col-md-4">
                            <label for="titulo">Imagen de Portada</label>
                            <img src="<?php echo e($propiedad->foto_portada); ?>" class="img-fluid rounded-top" alt="">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="titulo">Titulo</label>
                        <input type="text" class="form-control" id="titulo" name="titulo"
                            value="<?php echo e($propiedad->titulo); ?>" placeholder="Titulo" required maxlength="60">
                    </div>

                    <div class="form-group">
                        <label for="descripcion_corta">Descripción corta</label>
                        <input type="text" class="form-control" id="descripcion_corta"
                            value="<?php echo e($propiedad->descripcion_corta); ?>" name="descripcion_corta"
                            placeholder="Descripción corta" required maxlength="160">
                    </div>

                    <div class="form-group">
                        <label for="descripcion">Descripción</label>
                        <textarea class="form-control" placeholder="Descripción" id="descripcion" name="descripcion" style="height: 100px"><?php echo e($propiedad->descripcion); ?></textarea>
                    </div>

                    <div class="form-group">
                        <label for="descripcion">Dirección</label>
                        <textarea class="form-control" placeholder="Dirección" id="direccion" name="direccion" style="height: 100px"><?php echo e($propiedad->direccion); ?></textarea>
                    </div>

                    <div class="form-group">
                        <label for="metadescription">Meta Description</label>
                        <textarea class="form-control" placeholder="Meta Description" id="metadescription" name="metadescription"
                            maxlength="160" style="height: 100px"><?php echo e($propiedad->metadescription); ?></textarea>
                    </div>


                    <div class="card">
                        <div class="card-body">
                            <div class="row">

                                <div class="mb-3 col-md-3">
                                    <label for="formFile" class="form-label">Foto 1</label>
                                    <input class="form-control" type="file" id="foto1" name="foto1"
                                        value="<?php echo e($propiedad->foto1); ?>">

                                    <div class="form-group col-md-12">
                                        <label for="titulo">Foto 1</label>
                                        <img src="<?php echo e($propiedad->foto1); ?>" class="img-fluid rounded-top" alt="">
                                    </div>

                                    <div class="form-group col-md-12">
                                        <input type="checkbox" name="ckfoto1" id="ckfoto1"> Eliminar?
                                    </div>

                                </div>

                                <div class="mb-3 col-md-3">
                                    <label for="formFile" class="form-label">Foto 2</label>
                                    <input class="form-control" type="file" id="foto2" name="foto2"
                                        value="<?php echo e($propiedad->foto2); ?>">

                                    <div class="form-group col-md-12">
                                        <label for="titulo">Foto 2</label>
                                        <img src="<?php echo e($propiedad->foto2); ?>" class="img-fluid rounded-top" alt="">
                                    </div>

                                    <div class="form-group col-md-12">
                                        <input type="checkbox" name="ckfoto2" id="ckfoto2"> Eliminar?
                                    </div>
                                </div>

                                <div class="mb-3 col-md-3">
                                    <label for="formFile" class="form-label">Foto 3</label>
                                    <input class="form-control" type="file" id="foto3" name="foto3"
                                        value="<?php echo e($propiedad->foto3); ?>">

                                    <div class="form-group col-md-12">
                                        <label for="titulo">Foto 3</label>
                                        <img src="<?php echo e($propiedad->foto3); ?>" class="img-fluid rounded-top" alt="">
                                    </div>

                                    <div class="form-group col-md-12">
                                        <input type="checkbox" name="ckfoto3" id="ckfoto3"> Eliminar?
                                    </div>
                                </div>

                                <div class="mb-3 col-md-3">
                                    <label for="formFile" class="form-label">Foto 4</label>
                                    <input class="form-control" type="file" id="foto4" name="foto4"
                                        value="<?php echo e($propiedad->foto4); ?>">

                                    <div class="form-group col-md-12">
                                        <label for="titulo">Foto 4</label>
                                        <img src="<?php echo e($propiedad->foto4); ?>" class="img-fluid rounded-top" alt="">
                                    </div>

                                    <div class="form-group col-md-12">
                                        <input type="checkbox" name="ckfoto4" id="ckfoto4"> Eliminar?
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-body">
                            <div class="row">

                                <div class="mb-3 col-md-3">
                                    <label for="formFile" class="form-label">Foto 5</label>
                                    <input class="form-control" type="file" id="foto5" name="foto5"
                                        value="<?php echo e($propiedad->foto5); ?>">

                                    <div class="form-group col-md-12">
                                        <label for="titulo">Foto 5</label>
                                        <img src="<?php echo e($propiedad->foto5); ?>" class="img-fluid rounded-top" alt="">
                                    </div>

                                    <div class="form-group col-md-12">
                                        <input type="checkbox" name="ckfoto5" id="ckfoto5"> Eliminar?
                                    </div>

                                </div>

                                <div class="mb-3 col-md-3">
                                    <label for="formFile" class="form-label">Foto 6</label>
                                    <input class="form-control" type="file" id="foto6" name="foto6"
                                        value="<?php echo e($propiedad->foto6); ?>">

                                    <div class="form-group col-md-12">
                                        <label for="titulo">Foto 6</label>
                                        <img src="<?php echo e($propiedad->foto6); ?>" class="img-fluid rounded-top" alt="">
                                    </div>

                                    <div class="form-group col-md-12">
                                        <input type="checkbox" name="ckfoto6" id="ckfoto6"> Eliminar?
                                    </div>
                                </div>

                                <div class="mb-3 col-md-3">
                                    <label for="formFile" class="form-label">Foto 7</label>
                                    <input class="form-control" type="file" id="foto7" name="foto7"
                                        value="<?php echo e($propiedad->foto7); ?>">

                                    <div class="form-group col-md-12">
                                        <label for="titulo">Foto 7</label>
                                        <img src="<?php echo e($propiedad->foto7); ?>" class="img-fluid rounded-top" alt="">
                                    </div>

                                    <div class="form-group col-md-12">
                                        <input type="checkbox" name="ckfoto7" id="ckfoto7"> Eliminar?
                                    </div>
                                </div>

                                <div class="mb-3 col-md-3">
                                    <label for="formFile" class="form-label">Foto 8</label>
                                    <input class="form-control" type="file" id="foto8" name="foto8"
                                        value="<?php echo e($propiedad->foto8); ?>">

                                    <div class="form-group col-md-12">
                                        <label for="titulo">Foto 8</label>
                                        <img src="<?php echo e($propiedad->foto8); ?>" class="img-fluid rounded-top" alt="">
                                    </div>

                                    <div class="form-group col-md-12">
                                        <input type="checkbox" name="ckfoto8" id="ckfoto8"> Eliminar?
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>


                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="mb-3 col-md-3">
                                    <label for="formFile" class="form-label">Video 1</label>
                                    <input class="form-control" type="text" id="video1" name="video1"
                                        value="<?php echo e($propiedad->video1); ?>">
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



                    <div class="row">

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="provincia">Provincia</label>
                                <select class="form-control select2" name="provincia" id="provincia" required>
                                    <option value="">Selecciona una provincia</option>
                                    <?php $__currentLoopData = $provincias; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $provinciaItem): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($provinciaItem->id); ?>"
                                            <?php echo e((string) old('provincia', $propiedad->provincia) === (string) $provinciaItem->id ? 'selected' : ''); ?>>
                                            <?php echo e($provinciaItem->provincia); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="sector_id">Sector</label>
                                <select class="form-control select2 sector-select2" name="sector_id" id="sector_id"
                                    required>
                                    <option value="">Selecciona un sector</option>
                                    <?php $__currentLoopData = $sectores; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sector): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($sector->id); ?>" data-provincia="<?php echo e($sector->provincia_id); ?>"
                                            <?php echo e((string) old('sector_id', $propiedad->sector_id) === (string) $sector->id ? 'selected' : ''); ?>>
                                            <?php echo e($sector->sector); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-1">
                            <div class="form-group">
                                <label for="Moneda">Moneda</label>
                                <select class="form-control" name="tipomoneda" id="tipomoneda" required>
                                    <option <?php if($propiedad->Moneda == 'RD$'): ?> selected <?php endif; ?> value="RD$">RD$</option>
                                    <option <?php if($propiedad->Moneda == 'US$'): ?> selected <?php endif; ?> value="US$">US$</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="precio">Precio</label>
                                <input type="number" class="form-control" id="precio" name="precio" required
                                    placeholder="Precio" value="<?php echo e($propiedad->precio); ?>">
                            </div>
                        </div>

                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="comision"><span class="bold text-info text-sm mx-1"></span>Comisión</label>
                                <input type="text" class="form-control" id="comision" name="comision"
                                    placeholder="Comision" value="<?php echo e($propiedad->comision); ?>">
                            </div>
                        </div>

                        <?php if((bool) optional($inmobiliaria)->aprobacion && Auth::user()->rol == 0): ?>
                            <div class="row">

                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label for="tipo">Tipo</label>
                                        <select class="form-control" name="tipo" id="tipo" required>
                                            <option value="" selected>Tipo</option>
                                            <?php $__currentLoopData = $tipos_propiedades; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tipos_propiedad): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option <?php if($propiedad->tipo == $tipos_propiedad->id): ?> selected <?php endif; ?>
                                                    value="<?php echo e($tipos_propiedad->id); ?>"><?php echo e($tipos_propiedad->tipo); ?>

                                                </option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-1">
                                    <div class="form-group">
                                        <label for="habitaciones">Hab</label>
                                        <select class="form-control" name="habitaciones" id="habitaciones" required>
                                            <option value="" selected>Habitaciones</option>
                                            <option <?php if($propiedad->habitaciones == 1): ?> selected <?php endif; ?> value="1">1
                                            </option>
                                            <option <?php if($propiedad->habitaciones == 2): ?> selected <?php endif; ?> value="2">2
                                            </option>
                                            <option <?php if($propiedad->habitaciones == 3): ?> selected <?php endif; ?> value="3">3
                                            </option>
                                            <option <?php if($propiedad->habitaciones == 4): ?> selected <?php endif; ?> value="4">4
                                            </option>
                                            <option <?php if($propiedad->habitaciones == 5): ?> selected <?php endif; ?> value="5">5
                                            </option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-1">
                                    <div class="form-group">
                                        <label for="habitaciones">Baños</label>
                                        <select class="form-control" name="banos" id="banos" required>
                                            <option value="" selected>Baños</option>
                                            <option <?php if($propiedad->banos == 1): ?> selected <?php endif; ?> value="1">1
                                            </option>
                                            <option <?php if($propiedad->banos == 1.5): ?> selected <?php endif; ?> value="1.5">1.5
                                            </option>
                                            <option <?php if($propiedad->banos == 2): ?> selected <?php endif; ?> value="2">2
                                            </option>
                                            <option <?php if($propiedad->banos == 2.5): ?> selected <?php endif; ?> value="2.5">2.5
                                            </option>
                                            <option <?php if($propiedad->banos == 3): ?> selected <?php endif; ?> value="3">3
                                            </option>
                                            <option <?php if($propiedad->banos == 3.5): ?> selected <?php endif; ?> value="3.5">3.5
                                            </option>
                                            <option <?php if($propiedad->banos == 4): ?> selected <?php endif; ?> value="4">4
                                            </option>
                                            <option <?php if($propiedad->banos == 4.5): ?> selected <?php endif; ?> value="4.5">4.5
                                            </option>
                                            <option <?php if($propiedad->banos == 5): ?> selected <?php endif; ?> value="5">5
                                            </option>
                                            <option <?php if($propiedad->banos == 5.5): ?> selected <?php endif; ?> value="5.5">5.5
                                            </option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-1">
                                    <div class="form-group">
                                        <label for="habitaciones">Parqueos</label>
                                        <select class="form-control" name="parqueos" id="parqueos" required>
                                            <option value="" selected>Parqueos</option>
                                            <option <?php if($propiedad->parqueos == 1): ?> selected <?php endif; ?> value="1">1
                                            </option>
                                            <option <?php if($propiedad->parqueos == 2): ?> selected <?php endif; ?> value="2">2
                                            </option>
                                            <option <?php if($propiedad->parqueos == 3): ?> selected <?php endif; ?> value="3">3
                                            </option>
                                            <option <?php if($propiedad->parqueos == 4): ?> selected <?php endif; ?> value="4">4
                                            </option>
                                            <option <?php if($propiedad->parqueos == 5): ?> selected <?php endif; ?> value="5">5
                                            </option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label for="disponiblepara">Disponible para</label>
                                        <select class="form-control" name="disponible_para" id="disponible_para"
                                            required>
                                            <option value="" selected>Disponible para</option>
                                            <?php $__empty_1 = true; $__currentLoopData = $disponibles_para; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $disponible_para): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                                <option <?php if($propiedad->disponible_para == $disponible_para->id): ?> selected <?php endif; ?>
                                                    value="<?php echo e($disponible_para->id); ?>">
                                                    <?php echo e($disponible_para->disponible_para); ?></option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                            <?php endif; ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label for="estadopropiedad">Estado de la Propiedad</label>
                                        <select class="form-control" name="estadopropiedad" id="estadopropiedad"
                                            required>
                                            <option value="" selected>Estado Propiedad</option>
                                            <?php $__empty_1 = true; $__currentLoopData = $estados_propiedad; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $estado_propiedad): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                                <option <?php if($propiedad->estado_id == $estado_propiedad->id): ?> selected <?php endif; ?>
                                                    value="<?php echo e($estado_propiedad->id); ?>"><?php echo e($estado_propiedad->estado); ?>

                                                </option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                            <?php endif; ?>
                                        </select>
                                    </div>
                                </div>

                            </div>


                            <div class="row">

                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label for="metraje">Metraje</label>
                                        <input type="text" class="form-control" id="metraje" name="metraje"
                                            placeholder="Metraje" value="<?php echo e($propiedad->metraje); ?>" required>
                                    </div>
                                </div>

                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label for="metrajedeconstruccion">Metraje Construcción</label>
                                        <input type="text" class="form-control" id="metraje_construccion"
                                            name="metraje_construccion" placeholder="Metraje de Construcción"
                                            value="<?php echo e($propiedad->metraje_construccion); ?>">
                                    </div>
                                </div>

                                <div class="col-md-2">
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input"
                                            <?php if($propiedad->destacada == 1): ?> checked <?php endif; ?> id="destacada"
                                            name="destacada">
                                        <label for="exampleCheck1">Destacada?</label>
                                    </div>
                                </div>

                                <div class="col-md-2">
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input"
                                            <?php if($propiedad->vendida == 1): ?> checked <?php endif; ?> id="vendida"
                                            name="vendida">
                                        <label for="exampleCheck1">Vendida?</label>
                                    </div>
                                </div>

                                <div class="col-md-2">
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input"
                                            <?php if($propiedad->activa == 1): ?> checked <?php endif; ?> id="activa"
                                            name="activa">
                                        <label for="exampleCheck1">Activa?</label>
                                    </div>
                                </div>

                                <?php if((bool) optional($inmobiliaria)->aprobacion && $isAdmin): ?>
                                    <div class="col-md-2">
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input"
                                                <?php if($propiedad->aprobada == 1): ?> checked <?php endif; ?> id="aprobada"
                                                name="aprobada">
                                            <label for="aprobada">Aprobada?</label>
                                        </div>
                                    </div>
                                <?php endif; ?>



                            </div>

                            <div class="card">
                                <div class="card-body">
                                    

                                    <div class="row">


                                        <div class="col-md-2">
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input"
                                                    <?php if($propiedad->lobby == 1): ?> checked <?php endif; ?> id="lobby"
                                                    name="lobby">
                                                <label for="exampleCheck1">Lobby?</label>
                                            </div>
                                        </div>

                                        <div class="col-md-2">
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input"
                                                    <?php if($propiedad->plantaelectrica == 1): ?> checked <?php endif; ?> id="plantaelectrica"
                                                    name="plantaelectrica">
                                                <label for="exampleCheck1">Planta electrica?</label>
                                            </div>
                                        </div>

                                        <div class="col-md-2">
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input"
                                                    <?php if($propiedad->camaravigilancia == 1): ?> checked <?php endif; ?>
                                                    id="camaravigilancia" name="camaravigilancia">
                                                <label for="exampleCheck1">Camara vigilancia?</label>
                                            </div>
                                        </div>

                                        <div class="col-md-2">
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input"
                                                    <?php if($propiedad->escaleraemergencia == 1): ?> checked <?php endif; ?>
                                                    id="escaleraemergencia" name="escaleraemergencia">
                                                <label for="exampleCheck1">Escalera emergencia?</label>
                                            </div>
                                        </div>

                                        <div class="col-md-2">
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input"
                                                    <?php if($propiedad->maderapreciosa == 1): ?> checked <?php endif; ?> id="maderapreciosa"
                                                    name="maderapreciosa">
                                                <label for="exampleCheck1">Madera preciosa?</label>
                                            </div>
                                        </div>

                                        <div class="col-md-2">
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input"
                                                    <?php if($propiedad->balcon == 1): ?> checked <?php endif; ?> id="balcon"
                                                    name="balcon">
                                                <label for="exampleCheck1">Balcon?</label>
                                            </div>
                                        </div>

                                    </div>

                                    



                                    

                                    <div class="row">

                                        <div class="col-md-2">
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input"
                                                    <?php if($propiedad->walkincloset == 1): ?> checked <?php endif; ?> id="walkincloset"
                                                    name="walkincloset">
                                                <label for="exampleCheck1">Walk in closet?</label>
                                            </div>
                                        </div>

                                        <div class="col-md-2">
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input"
                                                    <?php if($propiedad->jacuzzi == 1): ?> checked <?php endif; ?> id="jacuzzi"
                                                    name="jacuzzi">
                                                <label for="exampleCheck1">Jacuzzi?</label>
                                            </div>
                                        </div>

                                        <div class="col-md-2">
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input"
                                                    <?php if($propiedad->areainfantil == 1): ?> checked <?php endif; ?> id="areainfantil"
                                                    name="areainfantil">
                                                <label for="exampleCheck1">Area infantil?</label>
                                            </div>
                                        </div>

                                        <div class="col-md-2">
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input"
                                                    <?php if($propiedad->banovisitas == 1): ?> checked <?php endif; ?> id="banovisitas"
                                                    name="banovisitas">
                                                <label for="exampleCheck1">Baño visitas?</label>
                                            </div>
                                        </div>

                                        <div class="col-md-2">
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input"
                                                    <?php if($propiedad->cisterna == 1): ?> checked <?php endif; ?> id="cisterna"
                                                    name="cisterna">
                                                <label for="exampleCheck1">Cisterna?</label>
                                            </div>
                                        </div>

                                        <div class="col-md-2">
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input"
                                                    <?php if($propiedad->inversorareacomun == 1): ?> checked <?php endif; ?>
                                                    id="inversorareacomun" name="inversorareacomun">
                                                <label for="exampleCheck1">Inversor área común?</label>
                                            </div>
                                        </div>

                                    </div>
                                    


                                    

                                    <div class="row">

                                        <div class="col-md-2">
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input"
                                                    <?php if($propiedad->gascomun == 1): ?> checked <?php endif; ?> id="gascomun"
                                                    name="gascomun">
                                                <label for="exampleCheck1">Gas común?</label>
                                            </div>
                                        </div>

                                        <div class="col-md-2">
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input"
                                                    <?php if($propiedad->gazebo == 1): ?> checked <?php endif; ?> id="gazebo"
                                                    name="gazebo">
                                                <label for="exampleCheck1">Gazebo?</label>
                                            </div>
                                        </div>

                                        <div class="col-md-2">
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input"
                                                    <?php if($propiedad->pozo == 1): ?> checked <?php endif; ?> id="pozo"
                                                    name="pozo">
                                                <label for="exampleCheck1">Pozo?</label>
                                            </div>
                                        </div>

                                        <div class="col-md-2">
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input"
                                                    <?php if($propiedad->piscina == 1): ?> checked <?php endif; ?> id="piscina"
                                                    name="piscina">
                                                <label for="exampleCheck1">Piscina?</label>
                                            </div>
                                        </div>

                                        <div class="col-md-2">
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input"
                                                    <?php if($propiedad->familyroom == 1): ?> checked <?php endif; ?> id="familyroom"
                                                    name="familyroom">
                                                <label for="exampleCheck1">Family room?</label>
                                            </div>
                                        </div>

                                        <div class="col-md-2">
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input"
                                                    <?php if($propiedad->cuartodeservicio == 1): ?> checked <?php endif; ?>
                                                    id="cuartodeservicio" name="cuartodeservicio">
                                                <label for="exampleCheck1">Cuarto de servicio?</label>
                                            </div>
                                        </div>

                                    </div>
                                    

                                    

                                    <div class="row">

                                        <div class="col-md-2">
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input"
                                                    <?php if($propiedad->patio == 1): ?> checked <?php endif; ?> id="patio"
                                                    name="patio">
                                                <label for="exampleCheck1">Patio?</label>
                                            </div>
                                        </div>

                                        <div class="col-md-2">
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input"
                                                    <?php if($propiedad->portonelectrico == 1): ?> checked <?php endif; ?> id="portonelectrico"
                                                    name="portonelectrico">
                                                <label for="exampleCheck1">Portón elèctrico?</label>
                                            </div>
                                        </div>

                                        <div class="col-md-2">
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input"
                                                    <?php if($propiedad->seguridad24horas == 1): ?> checked <?php endif; ?>
                                                    id="seguridad24horas" name="seguridad24horas">
                                                <label for="exampleCheck1">Seguridad 24 horas?</label>
                                            </div>
                                        </div>

                                        <div class="col-md-2">
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input"
                                                    <?php if($propiedad->ascensor == 1): ?> checked <?php endif; ?> id="ascensor"
                                                    name="ascensor">
                                                <label for="exampleCheck1">Ascensor?</label>
                                            </div>
                                        </div>

                                        <div class="col-md-2">
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input"
                                                    <?php if($propiedad->parqueostechados == 1): ?> checked <?php endif; ?>
                                                    id="parqueostechados" name="parqueostechados">
                                                <label for="exampleCheck1">Parqueos techados?</label>
                                            </div>
                                        </div>

                                        <div class="col-md-2">
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input"
                                                    <?php if($propiedad->preinstalacionairetinacoinversor == 1): ?> checked <?php endif; ?>
                                                    id="preinstalacionairetinacoinversor"
                                                    name="preinstalacionairetinacoinversor">
                                                <label for="exampleCheck1">Pre-instalacion aire/tinaco/inversor?</label>
                                            </div>
                                        </div>

                                    </div>
                                    


                                    

                                    <div class="row">

                                        <div class="col-md-2">
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input"
                                                    <?php if($propiedad->terraza == 1): ?> checked <?php endif; ?> id="terraza"
                                                    name="terraza">
                                                <label for="exampleCheck1">Terraza?</label>
                                            </div>
                                        </div>

                                        <div class="col-md-2">
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input"
                                                    <?php if($propiedad->estudio == 1): ?> checked <?php endif; ?> id="estudio"
                                                    name="estudio">
                                                <label for="exampleCheck1">Estudio?</label>
                                            </div>
                                        </div>

                                        <div class="col-md-2">
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input"
                                                    <?php if($propiedad->gimnasio == 1): ?> checked <?php endif; ?> id="gimnasio"
                                                    name="gimnasio">
                                                <label for="exampleCheck1">Gimnasio?</label>
                                            </div>
                                        </div>

                                        <div class="col-md-2">
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input"
                                                    <?php if($propiedad->controldeacceso == 1): ?> checked <?php endif; ?> id="controldeacceso"
                                                    name="controldeacceso">
                                                <label for="exampleCheck1">Control de acceso?</label>
                                            </div>
                                        </div>

                                    </div>
                                    
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary m-3" value="grabar"
                                name="grabar">Grabar</button>
                </form>
            </div>

        </div>
    </div>


    <script>
        // Replace the <textarea id="editor1"> with a CKEditor 4
        // instance, using default configuration.
        CKEDITOR.replace('descripcion');

        (function() {
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
                    // Si no es URL valida, intentamos extraer el ID.
                }

                const fallbackMatch = rawValue.match(/(?:v=|\/embed\/|youtu\.be\/|\/shorts\/)([a-zA-Z0-9_-]{11})/);
                return fallbackMatch ? fallbackMatch[1] : '';
            };

            const videoInput = document.getElementById('video1');
            const previewWrapper = document.getElementById('video1-preview-wrapper');
            const previewFrame = document.getElementById('video1-preview-frame');

            if (!videoInput || !previewWrapper || !previewFrame) {
                return;
            }

            const refreshVideoPreview = () => {
                const videoId = extractYouTubeId(videoInput.value);
                if (!videoId) {
                    previewFrame.src = '';
                    previewWrapper.classList.add('d-none');
                    return;
                }

                previewFrame.src = `https://www.youtube.com/embed/${videoId}`;
                previewWrapper.classList.remove('d-none');
            };

            videoInput.addEventListener('input', refreshVideoPreview);
            videoInput.addEventListener('blur', refreshVideoPreview);
            refreshVideoPreview();

            const provinciaSelect = document.getElementById('provincia');
            const sectorSelect = document.getElementById('sector_id');
            const monedaSelect = document.getElementById('tipomoneda');

            const getSelectTargetHeight = () => Math.max(monedaSelect?.offsetHeight || 0, 38);

            const applyProvinciaSelect2Height = () => {
                if (!(window.jQuery && window.jQuery.fn && window.jQuery.fn.select2) || !provinciaSelect) {
                    return;
                }

                const targetHeight = getSelectTargetHeight();
                const renderedLineHeight = Math.max(targetHeight - 2, 36);
                const container = window.jQuery(provinciaSelect).next('.select2-container');

                container.find('.select2-selection--single').css({
                    height: `${targetHeight}px`
                });
                container.find('.select2-selection__rendered').css({
                    lineHeight: `${renderedLineHeight}px`,
                    paddingLeft: '12px',
                    paddingRight: '28px'
                });
                container.find('.select2-selection__arrow').css({
                    height: `${targetHeight}px`
                });
            };

            const applySectorSelect2Height = () => {
                if (!(window.jQuery && window.jQuery.fn && window.jQuery.fn.select2) || !sectorSelect) {
                    return;
                }

                const provinciaContainer = window.jQuery(provinciaSelect).next('.select2-container');
                const provinciaSelection = provinciaContainer.find('.select2-selection--single');
                const provinciaVisualHeight = provinciaSelection.length ? provinciaSelection.outerHeight() :
                    getSelectTargetHeight();
                const container = window.jQuery(sectorSelect).next('.select2-container');
                const targetHeight = Math.max(Number(provinciaVisualHeight) || 0, 38);
                const renderedLineHeight = Math.max(targetHeight - 2, 36);
                container.find('.select2-selection--single').css({
                    height: `${targetHeight}px`
                });
                container.find('.select2-selection__rendered').css({
                    lineHeight: `${renderedLineHeight}px`,
                    paddingLeft: '12px',
                    paddingRight: '28px'
                });
                container.find('.select2-selection__arrow').css({
                    height: `${targetHeight}px`
                });
            };

            const refreshSectorOptions = () => {
                if (!provinciaSelect || !sectorSelect) {
                    return;
                }

                const provinciaValue = provinciaSelect.value;
                const currentValue = sectorSelect.value;
                let hasCurrent = false;

                Array.from(sectorSelect.options).forEach((option) => {
                    if (!option.value) {
                        option.hidden = false;
                        return;
                    }

                    const matches = !provinciaValue || option.dataset.provincia === provinciaValue;
                    option.hidden = !matches;

                    if (!matches && option.selected) {
                        option.selected = false;
                    }

                    if (matches && option.value === currentValue) {
                        hasCurrent = true;
                    }
                });

                if (!hasCurrent) {
                    sectorSelect.value = '';
                }

                if (window.jQuery && window.jQuery.fn && window.jQuery.fn.select2) {
                    window.jQuery(sectorSelect).trigger('change.select2');
                }
            };

            if (window.jQuery && window.jQuery.fn && window.jQuery.fn.select2) {
                if (!window.jQuery(provinciaSelect).hasClass('select2-hidden-accessible')) {
                    window.jQuery(provinciaSelect).select2({
                        width: '100%',
                        placeholder: 'Selecciona una provincia'
                    });
                }

                if (!window.jQuery(sectorSelect).hasClass('select2-hidden-accessible')) {
                    window.jQuery(sectorSelect).select2({
                        width: '100%',
                        placeholder: 'Selecciona un sector'
                    });
                }

                applyProvinciaSelect2Height();
                applySectorSelect2Height();
                window.jQuery(provinciaSelect).on('change.select2', applySectorSelect2Height);
            }

            provinciaSelect?.addEventListener('change', () => {
                refreshSectorOptions();
            });
            refreshSectorOptions();
        })();
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layoutadmin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xampp3\htdocs\realestate_dev\resources\views\admin\propiedades\editPendientes.blade.php ENDPATH**/ ?>