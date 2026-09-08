<?php $__env->startSection('title', 'Editar contacto'); ?>

<?php $__env->startSection('breadcrumb'); ?>
    <li class="breadcrumb-item"><a href="<?php echo e(route('clientes.index')); ?>">Contactos</a></li>
    <li class="breadcrumb-item active">Editar contacto</li>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('page_title', 'Editar contacto'); ?>

<?php $__env->startSection('content'); ?>

    <div class="container-fluid px-3">
        <div class="card border-0 shadow-sm mb-3 overflow-hidden">
            <div class="card-body py-3" style="background: linear-gradient(120deg, #0f172a, #1e3a8a); color: #ffffff;">
                <div class="d-flex flex-wrap align-items-center justify-content-between gap-3">
                    <div>
                        <h2 class="h4 mb-1 font-weight-bold">Editar contacto</h2>
                        <p class="mb-0" style="opacity: .85;">ID #<?php echo e($cliente->id); ?> &mdash; <?php echo e($cliente->nombre); ?></p>
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

        <form action="<?php echo e(route('clientes.update', $cliente->id)); ?>" method="post" novalidate>
            <?php echo method_field('PUT'); ?>
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
                                value="<?php echo e(old('nombre', $cliente->nombre)); ?>" placeholder="Nombre completo">
                        </div>

                        <div class="col-md-3 form-group">
                            <label for="titulo">Titulo</label>
                            <select class="form-control" name="titulo" id="titulo">
                                <option value="">Selecciona</option>
                                <option value="Señor" <?php if(old('titulo', $cliente->titulo) === 'Señor'): ?> selected <?php endif; ?>>Señor</option>
                                <option value="Señora" <?php if(old('titulo', $cliente->titulo) === 'Señora'): ?> selected <?php endif; ?>>Señora</option>
                                <option value="Señorita" <?php if(old('titulo', $cliente->titulo) === 'Señorita'): ?> selected <?php endif; ?>>Señorita</option>
                            </select>
                        </div>

                        <div class="col-md-3 form-group">
                            <label for="tipo_contacto">Tipo contacto</label>
                            <select class="form-control" name="tipo_contacto" id="tipo_contacto">
                                <option value="">Selecciona</option>
                                <option value="PersonaFisica" <?php if(old('tipo_contacto', $cliente->tipo_contacto) === 'PersonaFisica'): ?> selected <?php endif; ?>>Persona fisica</option>
                                <option value="Empresa" <?php if(old('tipo_contacto', $cliente->tipo_contacto) === 'Empresa'): ?> selected <?php endif; ?>>Empresa</option>
                            </select>
                        </div>

                        <div class="col-md-4 form-group">
                            <label for="telefono">Telefono</label>
                            <input type="number" class="form-control" id="telefono" name="telefono_display"
                                value="<?php echo e($cliente->telefono); ?>" placeholder="Numero principal" disabled>
                            <input type="hidden" name="telefono" value="<?php echo e($cliente->telefono); ?>">
                        </div>

                        <div class="col-md-4 form-group">
                            <label for="email">Correo</label>
                            <input type="email" class="form-control" id="email" name="email"
                                value="<?php echo e(old('email', $cliente->email)); ?>" placeholder="correo@dominio.com">
                        </div>

                        <div class="col-md-4 form-group">
                            <label for="contact_at">Fecha de contacto</label>
                            <input type="date" class="form-control" required id="contact_at" name="contact_at"
                                value="<?php echo e(old('contact_at', substr($cliente->contact_at, 0, 10))); ?>">
                        </div>

                        <div class="col-md-4 form-group">
                            <label for="tipo_contacto2">Perfil</label>
                            <select class="form-control" name="tipo_contacto2" id="tipo_contacto2">
                                <option value="">Selecciona</option>
                                <option value="Vendedor" <?php if(old('tipo_contacto2', $cliente->tipo_contacto2) === 'Vendedor'): ?> selected <?php endif; ?>>Vendedor</option>
                                <option value="Comprador" <?php if(old('tipo_contacto2', $cliente->tipo_contacto2) === 'Comprador'): ?> selected <?php endif; ?>>Comprador</option>
                                <option value="Inquilino" <?php if(old('tipo_contacto2', $cliente->tipo_contacto2) === 'Inquilino'): ?> selected <?php endif; ?>>Inquilino</option>
                            </select>
                        </div>

                        <div class="col-md-4 form-group">
                            <label for="medio">Origen del contacto</label>
                            <select class="form-control" name="medio" id="medio">
                                <option value="">Selecciona</option>
                                <option value="Facebook" <?php if(old('medio', $cliente->medio) === 'Facebook'): ?> selected <?php endif; ?>>Facebook</option>
                                <option value="Instagram" <?php if(old('medio', $cliente->medio) === 'Instagram'): ?> selected <?php endif; ?>>Instagram</option>
                                <option value="Letrero" <?php if(old('medio', $cliente->medio) === 'Letrero'): ?> selected <?php endif; ?>>Letrero</option>
                                <option value="Radio" <?php if(old('medio', $cliente->medio) === 'Radio'): ?> selected <?php endif; ?>>Radio</option>
                                <option value="TV" <?php if(old('medio', $cliente->medio) === 'TV'): ?> selected <?php endif; ?>>TV</option>
                                <option value="Referido" <?php if(old('medio', $cliente->medio) === 'Referido'): ?> selected <?php endif; ?>>Referido</option>
                                <option value="PaginaWeb" <?php if(old('medio', $cliente->medio) === 'PaginaWeb'): ?> selected <?php endif; ?>>Pagina web</option>
                                <option value="Otro" <?php if(old('medio', $cliente->medio) === 'Otro'): ?> selected <?php endif; ?>>Otro</option>
                            </select>
                        </div>

                        <div class="col-md-4 form-group d-flex align-items-end">
                            <div class="custom-control custom-switch mb-2">
                                <input class="custom-control-input" type="checkbox" name="activo" id="activo"
                                    value="1" <?php if(old('activo', $cliente->activo)): ?> checked <?php endif; ?>>
                                <label class="custom-control-label" for="activo">Marcar como activo</label>
                            </div>
                        </div>

                        <div class="col-12 form-group mb-0">
                            <label for="comentario">Comentario</label>
                            <textarea class="form-control" name="comentario" id="comentario" rows="3"
                                placeholder="Notas comerciales o necesidades del cliente"><?php echo e(old('comentario', $cliente->comentario)); ?></textarea>
                        </div>
                    </div>
                </div>
            </div>

            
            <div class="card border-0 shadow-sm mb-3">
                <div class="card-header bg-white border-0 pb-0">
                    <h3 class="h5 mb-0">Estatus CRM</h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4 form-group">
                            <label for="estatus">Estatus</label>
                            <select class="form-control" name="estatus" id="estatus">
                                <option value="">Selecciona</option>
                                <option value="NUEVO" <?php if(old('estatus', $cliente->estatus) === 'NUEVO'): ?> selected <?php endif; ?>>Nuevo</option>
                                <option value="CONTACTADO" <?php if(old('estatus', $cliente->estatus) === 'CONTACTADO'): ?> selected <?php endif; ?>>Contactado</option>
                                <option value="ACTIVO" <?php if(old('estatus', $cliente->estatus) === 'ACTIVO'): ?> selected <?php endif; ?>>Activo</option>
                                <option value="FUTURO" <?php if(old('estatus', $cliente->estatus) === 'FUTURO'): ?> selected <?php endif; ?>>Futuro</option>
                                <option value="CIERRE" <?php if(old('estatus', $cliente->estatus) === 'CIERRE'): ?> selected <?php endif; ?>>Cierre</option>
                                <option value="DESCARTADO" <?php if(old('estatus', $cliente->estatus) === 'DESCARTADO'): ?> selected <?php endif; ?>>Descartado</option>
                                <option value="NOESCLIENTE" <?php if(old('estatus', $cliente->estatus) === 'NOESCLIENTE'): ?> selected <?php endif; ?>>No es cliente potencial</option>
                            </select>
                        </div>

                        <div class="col-md-4 form-group">
                            <label for="probabilidades">Probabilidades</label>
                            <select class="form-control" name="probabilidades" id="probabilidades">
                                <option value="">Selecciona</option>
                                <option value="BAJAS" <?php if(old('probabilidades', $cliente->probabilidades) === 'BAJAS'): ?> selected <?php endif; ?>>Bajas</option>
                                <option value="MEDIAS" <?php if(old('probabilidades', $cliente->probabilidades) === 'MEDIAS'): ?> selected <?php endif; ?>>Medias</option>
                                <option value="ALTAS" <?php if(old('probabilidades', $cliente->probabilidades) === 'ALTAS'): ?> selected <?php endif; ?>>Altas</option>
                                <option value="DESCONOCIDA" <?php if(old('probabilidades', $cliente->probabilidades) === 'DESCONOCIDA'): ?> selected <?php endif; ?>>Desconocida</option>
                            </select>
                        </div>

                        <div class="col-md-4 form-group">
                            <label for="captadas_por">Buscar propiedades</label>
                            <select class="form-control" name="captadas_por" id="captadas_por">
                                <option value="">Todas</option>
                                <option value="mi" <?php if(old('captadas_por', $cliente->captadas_por) === 'mi'): ?> selected <?php endif; ?>>Solo mis propiedades</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>

            
            <div class="card border-0 shadow-sm mb-3">
                <div class="card-header bg-white border-0 pb-0">
                    <h3 class="h5 mb-0">Preferencias de negocio <span class="text-muted small">(RD$)</span></h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4 form-group">
                            <label for="zona_id">Zona</label>
                            <select class="form-control" name="zona_id" id="zona_id">
                                <option value="">Selecciona zona</option>
                                <?php $__currentLoopData = $zonas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $zona): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($zona->id); ?>" <?php if(old('zona_id', $cliente->zona_id) == $zona->id): ?> selected <?php endif; ?>><?php echo e($zona->zona); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>

                        <div class="col-md-4 form-group">
                            <label for="precio_mini">Precio minimo</label>
                            <input type="number" class="form-control" id="precio_mini" name="precio_mini"
                                value="<?php echo e(old('precio_mini', $cliente->precio_mini)); ?>" placeholder="Ej. 50000">
                        </div>

                        <div class="col-md-4 form-group">
                            <label for="precio_max">Precio maximo</label>
                            <input type="number" class="form-control" id="precio_max" name="precio_max"
                                value="<?php echo e(old('precio_max', $cliente->precio_max)); ?>" placeholder="Ej. 120000">
                        </div>

                        <div class="col-md-3 form-group">
                            <label for="habitaciones">Habitaciones</label>
                            <select class="form-control" name="habitaciones" id="habitaciones">
                                <option value="">Selecciona</option>
                                <?php $__currentLoopData = [1, 2, 3, 4, 5]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $num): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($num); ?>" <?php if(old('habitaciones', $cliente->habitaciones) == $num): ?> selected <?php endif; ?>><?php echo e($num); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>

                        <div class="col-md-3 form-group">
                            <label for="parqueos">Parqueos</label>
                            <select class="form-control" name="parqueos" id="parqueos">
                                <option value="">Selecciona</option>
                                <?php $__currentLoopData = [1, 2, 3, 4, 5]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $num): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($num); ?>" <?php if(old('parqueos', $cliente->parqueos) == $num): ?> selected <?php endif; ?>><?php echo e($num); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>

                        <div class="col-md-3 form-group">
                            <label for="tipo">Tipo de propiedad</label>
                            <select class="form-control" name="tipo" id="tipo">
                                <option value="">Selecciona</option>
                                <?php $__currentLoopData = $tipos_propiedades; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tipos_propiedad): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($tipos_propiedad->id); ?>" <?php if(old('tipo', $cliente->tipo) == $tipos_propiedad->id): ?> selected <?php endif; ?>><?php echo e($tipos_propiedad->tipo); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>

                        <div class="col-md-3 form-group">
                            <label for="estadopropiedad">Estado de propiedad</label>
                            <select class="form-control" name="estadopropiedad" id="estadopropiedad">
                                <option value="">Selecciona</option>
                                <?php $__currentLoopData = $estados_propiedad; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $estado_propiedad): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($estado_propiedad->id); ?>" <?php if(old('estadopropiedad', $cliente->estado) == $estado_propiedad->id): ?> selected <?php endif; ?>><?php echo e($estado_propiedad->estado); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>

                        <div class="col-12 mt-1">
                            <a href="<?php echo e(route('veropciones', $cliente->id)); ?>" target="_blank"
                                class="btn btn-outline-info btn-sm">
                                <i class="fas fa-search mr-1"></i> Ver opciones en RD$
                            </a>
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
                                value="<?php echo e(old('precio_mini_dolar', $cliente->precio_mini_dolar)); ?>" placeholder="Ej. 50000">
                        </div>

                        <div class="col-md-4 form-group">
                            <label for="precio_max_dolar">Precio maximo (US$)</label>
                            <input type="number" class="form-control" id="precio_max_dolar" name="precio_max_dolar"
                                value="<?php echo e(old('precio_max_dolar', $cliente->precio_max_dolar)); ?>" placeholder="Ej. 120000">
                        </div>

                        <div class="col-md-4 form-group">
                            <label for="estadopropiedad_en_dolar">Estado de propiedad (US$)</label>
                            <select class="form-control" name="estadopropiedad_en_dolar" id="estadopropiedad_en_dolar">
                                <option value="">Selecciona</option>
                                <?php $__currentLoopData = $estados_propiedad; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $estado_propiedad): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($estado_propiedad->id); ?>" <?php if(old('estadopropiedad_en_dolar', $cliente->estado_en_dolares) == $estado_propiedad->id): ?> selected <?php endif; ?>><?php echo e($estado_propiedad->estado); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>

                        <div class="col-md-4 form-group">
                            <label for="tipo_en_dolares">Tipo de propiedad (US$)</label>
                            <select class="form-control" name="tipo_en_dolares" id="tipo_en_dolares">
                                <option value="">Selecciona</option>
                                <?php $__currentLoopData = $tipos_propiedades; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tipos_propiedad): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($tipos_propiedad->id); ?>" <?php if(old('tipo_en_dolares', $cliente->tipo_en_dolares) == $tipos_propiedad->id): ?> selected <?php endif; ?>><?php echo e($tipos_propiedad->tipo); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>

                        <div class="col-12 mt-1">
                            <a href="<?php echo e(route('veropcionesendolares', $cliente->id)); ?>" target="_blank"
                                class="btn btn-outline-success btn-sm">
                                <i class="fas fa-search mr-1"></i> Ver opciones en US$
                            </a>
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
                            placeholder="Experiencia, observaciones o mensaje del cliente"><?php echo e(old('testimonio', $cliente->testimonio)); ?></textarea>
                    </div>
                </div>
            </div>

            <div class="d-flex justify-content-between pb-3">
                <a href="<?php echo e(route('clientes.index')); ?>" class="btn btn-secondary px-4">
                    <i class="fas fa-times mr-1"></i> Cancelar
                </a>
                <button type="submit" class="btn btn-success px-4">
                    <i class="fas fa-save mr-1"></i> Guardar cambios
                </button>
            </div>
        </form>
    </div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layoutadmin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xampp3\htdocs\realestate_dev\resources\views\admin\clientes\edit.blade.php ENDPATH**/ ?>