

<?php $__env->startSection('title', 'Nuevo contacto'); ?>

<?php $__env->startSection('breadcrumb'); ?>
    <li class="breadcrumb-item"><a href="<?php echo e(route('clientes.index')); ?>">Contactos</a></li>
    <li class="breadcrumb-item active">Nuevo contacto</li>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('page_title', 'Nuevo contacto'); ?>

<?php $__env->startSection('content'); ?>

    <div class="container-fluid px-3">
        <div class="card border-0 shadow-sm mb-3 overflow-hidden">
            <div class="card-body py-3" style="background: linear-gradient(120deg, #0f172a, #1e3a8a); color: #ffffff;">
                <div class="d-flex flex-wrap align-items-center justify-content-between gap-3">
                    <div>
                        <h2 class="h4 mb-1 font-weight-bold">Registrar contacto</h2>
                        <p class="mb-0" style="opacity: .85;">Captura datos comerciales y preferencias para dar seguimiento
                            desde el CRM.</p>
                    </div>
                    <a href="<?php echo e(route('clientes.index')); ?>" class="btn btn-light btn-sm">
                        <i class="fas fa-arrow-left mr-1"></i> Volver al listado
                    </a>
                </div>
            </div>
        </div>

        <?php if(session('existe')): ?>
            <div class="alert alert-warning border-0 shadow-sm"><?php echo e(session('existe')); ?></div>
        <?php endif; ?>

        <?php if($errors->any()): ?>
            <div class="alert alert-danger border-0 shadow-sm">
                <div class="font-weight-bold mb-1">No se pudo guardar el contacto:</div>
                <ul class="mb-0 pl-3">
                    <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <li><?php echo e($error); ?></li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </ul>
            </div>
        <?php endif; ?>

        <form action="<?php echo e(route('clientes.store')); ?>" method="post" novalidate>
            <?php echo csrf_field(); ?>

            <div class="card border-0 shadow-sm mb-3">
                <div class="card-header bg-white border-0 pb-0">
                    <h3 class="h5 mb-0">Datos del contacto</h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 form-group">
                            <label for="nombre">Nombre</label>
                            <input type="text" required class="form-control" id="nombre" name="nombre"
                                value="<?php echo e(old('nombre')); ?>" placeholder="Nombre completo">
                        </div>

                        <div class="col-md-3 form-group">
                            <label for="titulo">Titulo</label>
                            <select class="form-control" name="titulo" id="titulo" required>
                                <option value="">Selecciona</option>
                                <option value="Señor" @selected(old('titulo') === 'Señor')>Señor</option>
                                <option value="Señora" @selected(old('titulo') === 'Señora')>Señora</option>
                                <option value="Señorita" @selected(old('titulo') === 'Señorita')>Señorita</option>
                            </select>
                        </div>

                        <div class="col-md-3 form-group">
                            <label for="tipo_contacto">Tipo contacto</label>
                            <select class="form-control" name="tipo_contacto" id="tipo_contacto" required>
                                <option value="">Selecciona</option>
                                <option value="PersonaFisica" @selected(old('tipo_contacto') === 'PersonaFisica')>Persona fisica</option>
                                <option value="Empresa" @selected(old('tipo_contacto') === 'Empresa')>Empresa</option>
                            </select>
                        </div>

                        <div class="col-md-4 form-group">
                            <label for="telefono">Telefono</label>
                            <input type="number" required class="form-control" id="telefono" name="telefono"
                                value="<?php echo e(old('telefono')); ?>" placeholder="Numero principal">
                        </div>

                        <div class="col-md-4 form-group">
                            <label for="correo">Correo</label>
                            <input type="email" class="form-control" id="correo" name="correo"
                                value="<?php echo e(old('correo')); ?>" placeholder="correo@dominio.com">
                        </div>

                        <div class="col-md-4 form-group">
                            <label for="contact_at">Fecha de contacto</label>
                            <input type="date" class="form-control" required id="contact_at" name="contact_at"
                                value="<?php echo e(old('contact_at')); ?>">
                        </div>

                        <div class="col-md-4 form-group">
                            <label for="tipo_contacto2">Perfil</label>
                            <select class="form-control" name="tipo_contacto2" id="tipo_contacto2" required>
                                <option value="">Selecciona</option>
                                <option value="Vendedor" @selected(old('tipo_contacto2') === 'Vendedor')>Vendedor</option>
                                <option value="Comprador" @selected(old('tipo_contacto2') === 'Comprador')>Comprador</option>
                                <option value="Inquilino" @selected(old('tipo_contacto2') === 'Inquilino')>Inquilino</option>
                            </select>
                        </div>

                        <div class="col-md-4 form-group">
                            <label for="medio">Origen del contacto</label>
                            <select class="form-control" name="medio" id="medio" required>
                                <option value="">Selecciona</option>
                                <option value="Facebook" @selected(old('medio') === 'Facebook')>Facebook</option>
                                <option value="Instagram" @selected(old('medio') === 'Instagram')>Instagram</option>
                                <option value="Letrero" @selected(old('medio') === 'Letrero')>Letrero</option>
                                <option value="Radio" @selected(old('medio') === 'Radio')>Radio</option>
                                <option value="TV" @selected(old('medio') === 'TV')>TV</option>
                                <option value="Referido" @selected(old('medio') === 'Referido')>Referido</option>
                                <option value="PaginaWeb" @selected(old('medio') === 'PaginaWeb')>Pagina web</option>
                                <option value="Otro" @selected(old('medio') === 'Otro')>Otro</option>
                            </select>
                        </div>

                        <div class="col-md-4 form-group d-flex align-items-end">
                            <div class="custom-control custom-switch mb-2">
                                <input class="custom-control-input" type="checkbox" name="activo" id="activo"
                                    value="1" @checked(old('activo'))>
                                <label class="custom-control-label" for="activo">Marcar como activo</label>
                            </div>
                        </div>

                        <div class="col-12 form-group mb-0">
                            <label for="comentario">Comentario</label>
                            <textarea class="form-control" name="comentario" id="comentario" rows="3"
                                placeholder="Notas comerciales o necesidades del cliente"><?php echo e(old('comentario')); ?></textarea>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card border-0 shadow-sm mb-3">
                <div class="card-header bg-white border-0 pb-0">
                    <h3 class="h5 mb-0">Preferencias de negocio</h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4 form-group">
                            <label for="zona_id">Zona</label>
                            <select class="form-control" name="zona_id" id="zona_id">
                                <option value="">Selecciona zona</option>
                                <?php $__currentLoopData = $zonas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $zona): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($zona->id); ?>" @selected(old('zona_id') == $zona->id)><?php echo e($zona->zona); ?>

                                    </option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>

                        <div class="col-md-4 form-group">
                            <label for="precio_mini">Precio minimo</label>
                            <input type="number" class="form-control" id="precio_mini" name="precio_mini"
                                value="<?php echo e(old('precio_mini')); ?>" placeholder="Ej. 50000">
                        </div>

                        <div class="col-md-4 form-group">
                            <label for="precio_max">Precio maximo</label>
                            <input type="number" class="form-control" id="precio_max" name="precio_max"
                                value="<?php echo e(old('precio_max')); ?>" placeholder="Ej. 120000">
                        </div>

                        <div class="col-md-3 form-group">
                            <label for="habitaciones">Habitaciones</label>
                            <select class="form-control" name="habitaciones" id="habitaciones">
                                <option value="">Selecciona</option>
                                <option value="1" @selected(old('habitaciones') == '1')>1</option>
                                <option value="2" @selected(old('habitaciones') == '2')>2</option>
                                <option value="3" @selected(old('habitaciones') == '3')>3</option>
                                <option value="4" @selected(old('habitaciones') == '4')>4</option>
                                <option value="5" @selected(old('habitaciones') == '5')>5</option>
                            </select>
                        </div>

                        <div class="col-md-3 form-group">
                            <label for="parqueos">Parqueos</label>
                            <select class="form-control" name="parqueos" id="parqueos">
                                <option value="">Selecciona</option>
                                <option value="1" @selected(old('parqueos') == '1')>1</option>
                                <option value="2" @selected(old('parqueos') == '2')>2</option>
                                <option value="3" @selected(old('parqueos') == '3')>3</option>
                                <option value="4" @selected(old('parqueos') == '4')>4</option>
                                <option value="5" @selected(old('parqueos') == '5')>5</option>
                            </select>
                        </div>

                        <div class="col-md-3 form-group">
                            <label for="tipo">Tipo de propiedad</label>
                            <select class="form-control" name="tipo" id="tipo">
                                <option value="">Selecciona</option>
                                <?php $__currentLoopData = $tipos_propiedades; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tipos_propiedad): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($tipos_propiedad->id); ?>" @selected(old('tipo') == $tipos_propiedad->id)>
                                        <?php echo e($tipos_propiedad->tipo); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>

                        <div class="col-md-3 form-group">
                            <label for="estadopropiedad">Estado de propiedad</label>
                            <select class="form-control" name="estadopropiedad" id="estadopropiedad">
                                <option value="">Selecciona</option>
                                <?php $__currentLoopData = $estados_propiedad; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $estado_propiedad): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($estado_propiedad->id); ?>" @selected(old('estadopropiedad') == $estado_propiedad->id)>
                                        <?php echo e($estado_propiedad->estado); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card border-0 shadow-sm mb-3">
                <div class="card-header bg-white border-0 pb-0">
                    <h3 class="h5 mb-0">Preferencias de negocio <span class="text-muted small">(US$)</span></h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4 form-group">
                            <label for="precio_mini_dolar">Precio minimo (US$)</label>
                            <input type="number" class="form-control" id="precio_mini_dolar" name="precio_mini_dolar"
                                value="<?php echo e(old('precio_mini_dolar')); ?>" placeholder="Ej. 50000">
                        </div>

                        <div class="col-md-4 form-group">
                            <label for="precio_max_dolar">Precio maximo (US$)</label>
                            <input type="number" class="form-control" id="precio_max_dolar" name="precio_max_dolar"
                                value="<?php echo e(old('precio_max_dolar')); ?>" placeholder="Ej. 120000">
                        </div>

                        <div class="col-md-4 form-group">
                            <label for="estadopropiedad_en_dolar">Estado de propiedad (US$)</label>
                            <select class="form-control" name="estadopropiedad_en_dolar" id="estadopropiedad_en_dolar">
                                <option value="">Selecciona</option>
                                <?php $__currentLoopData = $estados_propiedad; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $estado_propiedad): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($estado_propiedad->id); ?>"
                                        <?php if(old('estadopropiedad_en_dolar') == $estado_propiedad->id): ?> selected <?php endif; ?>><?php echo e($estado_propiedad->estado); ?>

                                    </option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>

                        <div class="col-md-4 form-group">
                            <label for="tipo_en_dolares">Tipo de propiedad (US$)</label>
                            <select class="form-control" name="tipo_en_dolares" id="tipo_en_dolares">
                                <option value="">Selecciona</option>
                                <?php $__currentLoopData = $tipos_propiedades; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tipos_propiedad): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($tipos_propiedad->id); ?>"
                                        <?php if(old('tipo_en_dolares') == $tipos_propiedad->id): ?> selected <?php endif; ?>><?php echo e($tipos_propiedad->tipo); ?>

                                    </option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card border-0 shadow-sm mb-3">
                <div class="card-header bg-white border-0 pb-0">
                    <h3 class="h5 mb-0">Testimonio</h3>
                </div>
                <div class="card-body">
                    <div class="form-group mb-0">
                        <label for="testimonio">Detalle</label>
                        <textarea class="form-control" name="testimonio" id="testimonio" rows="3"
                            placeholder="Experiencia, observaciones o mensaje del cliente"><?php echo e(old('testimonio')); ?></textarea>
                    </div>
                </div>
            </div>

            <div class="d-flex justify-content-end pb-3">
                <button type="submit" class="btn btn-success px-4">
                    <i class="fas fa-save mr-1"></i> Guardar contacto
                </button>
            </div>
        </form>
    </div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layoutadmin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xampp3\htdocs\realestate_dev\resources\views\admin\clientes\create.blade.php ENDPATH**/ ?>