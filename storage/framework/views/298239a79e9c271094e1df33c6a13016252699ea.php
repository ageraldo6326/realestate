<div>
    <style>
        .clientes-shell {
            display: grid;
            gap: 1rem;
        }

        .clientes-panel {
            border: 1px solid #dbe4f0;
            border-radius: 1.25rem;
            box-shadow: 0 14px 28px rgba(15, 23, 42, .06);
        }

        .clientes-panel .table thead th {
            border-top: none;
            border-bottom: 2px solid #e9ecef;
            font-size: .72rem;
            letter-spacing: .06em;
        }

        .clientes-panel .table tbody tr:hover {
            background: #f8fafc;
        }

        .badge-nuevo {
            background: #ffc107;
            color: #212529;
        }

        .badge-contactado {
            background: #17a2b8;
            color: #fff;
        }

        .badge-activo {
            background: #28a745;
            color: #fff;
        }

        .badge-cierre {
            background: #007bff;
            color: #fff;
        }

        .badge-futuro {
            background: #343a40;
            color: #fff;
        }

        .badge-descartado {
            background: #6c757d;
            color: #fff;
        }

        .badge-noescliente {
            background: #e9ecef;
            color: #495057;
        }

        .badge-bajas {
            background: #ffc107;
            color: #212529;
        }

        .badge-medias {
            background: #0dcaf0;
            color: #212529;
        }

        .badge-altas {
            background: #28a745;
            color: #fff;
        }
    </style>

    <div class="clientes-shell">

        
        <section class="card clientes-panel">
            <div class="card-body p-4">
                <div class="d-flex flex-column flex-lg-row justify-content-between align-items-lg-center mb-4">
                    <div>
                        <h3 class="h5 mb-1">Buscar contactos</h3>
                        <p class="text-muted mb-0 small">Filtra por nombre, estatus o probabilidad de cierre.</p>
                    </div>
                    <a href="<?php echo e(route('clientes.create')); ?>" class="btn btn-primary mt-3 mt-lg-0 px-4">
                        <i class="fas fa-plus mr-1"></i> Nuevo contacto
                    </a>
                </div>

                <div class="row">
                    <div class="col-lg-6 mb-3">
                        <label class="small text-muted font-weight-semibold">Buscar</label>
                        <input type="search" class="form-control form-control-lg rounded-lg"
                            wire:model.debounce.350ms="criterio" placeholder="Nombre, teléfono o correo..."
                            autocomplete="off" autocorrect="off" spellcheck="false">
                    </div>
                    <div class="col-lg-3 mb-3">
                        <label class="small text-muted font-weight-semibold">Estatus</label>
                        <select class="form-control form-control-lg rounded-lg" wire:model="criterioestatus">
                            <option value="">Todos</option>
                            <option value="NUEVO">Nuevo</option>
                            <option value="CONTACTADO">Contactado</option>
                            <option value="ACTIVO">Activo</option>
                            <option value="FUTURO">Futuro</option>
                            <option value="CIERRE">Cierre</option>
                            <option value="DESCARTADO">Descartado</option>
                            <option value="NOESCLIENTE">No es cliente</option>
                        </select>
                    </div>
                    <div class="col-lg-3 mb-3">
                        <label class="small text-muted font-weight-semibold">Probabilidad</label>
                        <select class="form-control form-control-lg rounded-lg" wire:model="criterioprobabilidades">
                            <option value="">Todas</option>
                            <option value="BAJAS">Bajas</option>
                            <option value="MEDIAS">Medias</option>
                            <option value="ALTAS">Altas</option>
                            <option value="DESCONOCIDA">Desconocida</option>
                        </select>
                    </div>
                </div>
            </div>
        </section>

        
        <section class="card clientes-panel">
            <div class="card-body p-4">

                <div class="table-responsive">
                    <table class="table align-middle mb-0">
                        <thead class="text-uppercase small text-muted">
                            <tr>
                                <th>Contacto</th>
                                <th class="d-none d-md-table-cell">Teléfono</th>
                                <th>Estatus</th>
                                <th class="d-none d-lg-table-cell">Probabilidad</th>
                                <th class="text-right">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__empty_1 = true; $__currentLoopData = $clientes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cliente): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                <?php
                                    $statusClass = match ($cliente->estatus) {
                                        'NUEVO' => 'badge-nuevo',
                                        'CONTACTADO' => 'badge-contactado',
                                        'ACTIVO' => 'badge-activo',
                                        'CIERRE' => 'badge-cierre',
                                        'FUTURO' => 'badge-futuro',
                                        'DESCARTADO' => 'badge-descartado',
                                        default => 'badge-noescliente',
                                    };
                                    $probClass = match ($cliente->probabilidades) {
                                        'BAJAS' => 'badge-bajas',
                                        'MEDIAS' => 'badge-medias',
                                        'ALTAS' => 'badge-altas',
                                        default => 'badge-secondary',
                                    };
                                ?>
                                <tr>
                                    <td>
                                        <div class="font-weight-bold"><?php echo e($cliente->nombre); ?></div>
                                        <div class="small text-muted"><?php echo e($cliente->email ?: 'Sin correo'); ?></div>
                                    </td>
                                    <td class="d-none d-md-table-cell">
                                        <span class="text-muted"><?php echo e($cliente->telefono ?: '—'); ?></span>
                                    </td>
                                    <td>
                                        <span class="badge badge-pill <?php echo e($statusClass); ?> px-2 py-1">
                                            <?php echo e($cliente->estatus); ?>

                                        </span>
                                    </td>
                                    <td class="d-none d-lg-table-cell">
                                        <?php if($cliente->probabilidades): ?>
                                            <span class="badge badge-pill <?php echo e($probClass); ?> px-2 py-1">
                                                <?php echo e($cliente->probabilidades); ?>

                                            </span>
                                        <?php else: ?>
                                            <span class="text-muted">—</span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="text-right">
                                        <div class="d-flex justify-content-end">
                                            <a href="<?php echo e(route('clientes.edit', $cliente->id)); ?>"
                                                class="btn btn-outline-primary btn-sm mr-1">
                                                Editar
                                            </a>
                                            <button type="button" class="btn btn-outline-danger btn-sm"
                                                wire:click="$emit('generarBorrarSweetAlert', <?php echo e($cliente->id); ?>, 'Borrar Cliente ID ', 'borrarContacto')"
                                                data-element-id="<?php echo e($cliente->id); ?>">
                                                Borrar
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                <tr>
                                    <td colspan="5" class="text-center py-5 text-muted">
                                        No hay contactos para mostrar con el criterio actual.
                                    </td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>

                <div class="mt-4">
                    <?php echo e($clientes->links()); ?>

                </div>
            </div>
        </section>

    </div>

    <div>

        <?php echo $__env->make('components.modalheader', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

        <div class="row card card-body shadow">
            <div class="col-md-12">

                <div class="row">
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="titulo">Titulo</label>
                            <select class="form-control" name="titulo" id="titulo" required
                                wire:model.lazy="titulo">
                                <option value="">Titulo</option>
                                <option value="Señor">Señor</option>
                                <option value="Señora">Señora</option>
                                <option value="Señorita">Señorita</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-10">
                        <div class="form-group">
                            <label for="nombre">* Nombre</label>
                            <input type="text" wire:model.lazy="nombre" id="nombre" name="nombre" required
                                class="form-control">
                            <?php $__errorArgs = ['nombre'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <span class="error text-danger"><?php echo e($message); ?></span>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                    </div>
                </div>

                <div class="row">

                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="tipo_contacto">* Tipo Contacto</label>
                            <select class="form-control" name="tipo_contacto" id="tipo_contacto"
                                wire:model.lazy="tipo_contacto" required>
                                <option value="">Tipo</option>
                                <option value="PersonaFisica">Persona Fisica</option>
                                <option value="Empresa">Empresa</option>
                            </select>
                            <?php $__errorArgs = ['tipo_contacto'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <span class="error text-danger"><?php echo e($message); ?></span>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="telefono">* Telefono</label>
                            <input type="number" required class="form-control" wire:model.lazy="telefono"
                                <?php if($Id > 0): ?> disabled <?php endif; ?> wire:change="verificarContacto()">
                            <?php $__errorArgs = ['telefono'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <span class="error text-danger"><?php echo e($message); ?></span>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="email">Correo</label>
                            <input type="email" class="form-control" id="email" name="email"
                                placeholder="email" wire:model.lazy="email">
                        </div>
                    </div>
                    <?php if(session('TelefonoDuplicado')): ?>
                        <div class="alert alert-danger">
                            <?php echo e(session('TelefonoDuplicado')); ?>

                        </div>
                    <?php endif; ?>
                </div>

                <div class="row">
                    <div class="col-md-12 form-group">
                        <label for="" class="form-label">* Comentario</label>
                        <textarea class="form-control" name="comentario" id="comentario" rows="3" wire:model.lazy="comentario"></textarea>
                        <?php $__errorArgs = ['comentario'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <span class="error text-danger"><?php echo e($message); ?></span>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                </div>

                <div class="row">

                    <div class="form-group col-md-4">
                        <label for="contact_at">* Fecha de Contacto</label>
                        <input type="date" class="form-control" required id="contact_at" name="contact_at"
                            wire:model.lazy="contact_at">
                        <?php $__errorArgs = ['contact_at'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <span class="error text-danger"><?php echo e($message); ?></span>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    <div class="form-group col-md-4">
                        <label for="contact_at">* Estatus
                            <?php if($estatus == 'NUEVO'): ?>
                                <span class="fa fa-handshake text-warning mx-1"></span>
                            <?php endif; ?>
                            <?php if($estatus == 'CONTACTADO'): ?>
                                <span class="fa fa-comments text-info mx-1"></span>
                            <?php endif; ?>
                            <?php if($estatus == 'ACTIVO'): ?>
                                <span class="fa fa-people-carry text text-danger mx-1"></span>
                            <?php endif; ?>
                            <?php if($estatus == 'CIERRE'): ?>
                                <span class="fa fa-check-double text text-success mx-1"></span>
                            <?php endif; ?>
                            <?php if($estatus == 'FUTURO'): ?>
                                <span class="fa fa-business-time text text-dark mx-1"></span>
                            <?php endif; ?>
                            <?php if($estatus == 'DESCARTADO'): ?>
                                <span class="fa fa-ban text text-muted mx-1"></span>
                            <?php endif; ?>
                            <?php if($estatus == 'NOESCLIENTE'): ?>
                                <span class="fa fa-users text text-dark mx-1"></span>
                            <?php endif; ?>
                        </label>
                        <select class="form-control" aria-label="Default select example" name="estatus"
                            id="estatus" wire:model.lazy="estatus">
                            <option></option>
                            <option <?php if($Id == ''): ?> selected <?php else: ?> required <?php endif; ?> value="NUEVO">
                                NUEVO</option>
                            <option value="CONTACTADO">CONTACTADO</option>
                            <option value="ACTIVO">ACTIVO</option>
                            <option value="FUTURO">FUTURO</option>
                            <option value="CIERRE">CIERRE</option>
                            <option value="DESCARTADO">DESCARTADO</option>
                            <option value="NOESCLIENTE">NO ES CLIENTE POTENCIAL</option>
                        </select>
                        <?php $__errorArgs = ['estatus'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <span class="error text-danger"><?php echo e($message); ?></span>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    <div class="col-md-4">
                        <label for="contact_at">Probabilidades
                            <?php if($probabilidades == 'BAJAS'): ?>
                                <span class="fa fa-star text-warning mx-1">
                            <?php endif; ?>

                            <?php if($probabilidades == 'MEDIAS'): ?>
                                <span class="fa fa-star text-warning mx-1">
                                    <span class="fa fa-star text-warning mx-1">
                                        <span class="fa fa-star text-warning mx-1">
                            <?php endif; ?>

                            <?php if($probabilidades == 'ALTAS'): ?>
                                <span class="fa fa-star text-warning mx-0">
                                    <span class="fa fa-star text-warning mx-0">
                                        <span class="fa fa-star text-warning mx-0">
                                            <span class="fa fa-star text-warning mx-0">
                                                <span class="fa fa-star text-warning mx-0">
                            <?php endif; ?>
                        </label>
                        <select class="form-control" name="probabilidades" id="probabilidades"
                            wire:model.lazy="probabilidades">
                            <option selected></option>
                            <option value="BAJAS">BAJAS</option>
                            <option value="MEDIAS">MEDIAS</option>
                            <option value="ALTAS">ALTAS</option>
                            <option value="DESCONOCIDA">DESCONOCIDA</option>
                        </select>
                        <?php $__errorArgs = ['estatus'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <span class="error text-danger"><?php echo e($message); ?></span>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="tipo_contacto2">* Tipo Contacto</label>
                            <select class="form-control" name="tipo_contacto2" id="tipo_contacto2" required
                                wire:model.lazy="tipo_contacto2">
                                <option value="">Tipo</option>
                                <option value="Vendedor">Vendedor</option>
                                <option value="Comprador">Comprador</option>
                                <option value="Inquilino">Inquilino</option>
                            </select>
                            <?php $__errorArgs = ['tipo_contacto2'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <span class="error text-danger"><?php echo e($message); ?></span>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="medio">* Por donde supo de nosotros</label>
                            <select class="form-control" name="medio" id="medio" required
                                wire:model.lazy="medio">
                                <option value="">Tipo</option>
                                <option value="Facebook">Facebook</option>
                                <option value="Instagram">Instagram</option>
                                <option value="Letrero">Letrero</option>
                                <option value="Radio">Radio</option>
                                <option value="TV">TV</option>
                                <option value="Referido">Referido</option>
                                <option value="Otro">Otro</option>
                            </select>
                            <?php $__errorArgs = ['medio'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <span class="error text-danger"><?php echo e($message); ?></span>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                    </div>
                </div>

                <div class="row">

                    <div class="form-group col-md-4">
                        <label for="fecha">Fecha del cierre:</label>
                        <input type="date" id="fechacierre" wire:model.lazy="fechacierre" name="fechacierre"
                            class="form-control">
                    </div>

                    <div class="custom-control custom-checkbox col-md-4 my-auto">
                        <input type="checkbox" class="custom-control-input" id="activo" wire:model.lazy="activo">
                        <label class="custom-control-label" for="activo">Cliente Activo?</label>
                    </div>

                </div>

            </div>
        </div>


        <div class="row card card-body shadow">
            <div class="col-md-12">
                <div class="row col-md-12">
                    <h3 class="text-bold text-primary">QUE DESEA EL CLIENTE?</h3>
                </div>

                <div class="row">
                    <div class="col-md-4">

                        <div class="form-group">

                            <label for="zona_id">Zona</label>
                            <select class="form-control" name="zona_id" id="zona_id" wire:model.lazy="zona_id">
                                <option value="" selected></option>
                                <?php $__currentLoopData = $zonas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $zona): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($zona->id); ?>"><?php echo e($zona->zona); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                            </select>

                        </div>

                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="tipo">Tipo RD$</label>
                            <select class="form-control" name="tipo" id="tipo" wire:model.lazy="tipo">
                                <option value="" selected></option>
                                <?php $__currentLoopData = $tipos_propiedades; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tipos_propiedad): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($tipos_propiedad->id); ?>"><?php echo e($tipos_propiedad->tipo); ?>

                                    </option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="estadopropiedad">Estado RD$</label>
                            <select class="form-control" name="estadopropiedad" id="estadopropiedad"
                                wire:model.lazy="estadopropiedad">
                                <option value="" selected></option>
                                <?php $__empty_1 = true; $__currentLoopData = $estados_propiedad; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $estado_propiedad): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                    <option value="<?php echo e($estado_propiedad->id); ?>"><?php echo e($estado_propiedad->estado); ?>

                                    </option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                <?php endif; ?>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="precio_mini">Precio Min RD$</label>
                            <input type="text" class="form-control monto" id="precio_mini" name="precio_mini"
                                wire:model.lazy="precio_mini">
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="precio_max">Precio Max RD$</label>
                            <input type="text" class="form-control monto" id="precio_max" name="precio_max"
                                wire:model.lazy="precio_max">
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="tipo_en_dolar">Tipo US$</label>
                            <select class="form-control" name="tipo_en_dolar" id="tipo_en_dolar"
                                wire:model.lazy="tipo_en_dolares">
                                <option value="" selected></option>
                                <?php $__currentLoopData = $tipos_propiedades; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tipos_propiedad): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($tipos_propiedad->id); ?>"><?php echo e($tipos_propiedad->tipo); ?>

                                    </option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="estadopropiedad_en_dolar">Estado US$</label>
                            <select class="form-control" name="estadopropiedad_en_dolar"
                                id="estadopropiedad_en_dolar" wire:model.lazy="estadopropiedad_en_dolar">
                                <option value="" selected></option>
                                <?php $__empty_1 = true; $__currentLoopData = $estados_propiedad; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $estado_propiedad): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                    <option value="<?php echo e($estado_propiedad->id); ?>"><?php echo e($estado_propiedad->estado); ?>

                                    </option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                <?php endif; ?>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="precio">Precio Min US$</label>
                            <input type="text" class="form-control monto" id="precio_mini_dolar"
                                name="precio_mini_dolar" wire:model.lazy="precio_mini_dolar">
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="precio">Precio Max US$</label>
                            <input type="text" class="form-control monto" id="precio_max_dolar"
                                name="precio_max_dolar" wire:model.lazy="precio_max_dolar">
                        </div>
                    </div>
                </div>

                <div class="row">

                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="habitaciones">Hab</label>
                            <select class="form-control" name="habitaciones" id="habitaciones"
                                wire:model.lazy="habitaciones">
                                <option selected>Habitaciones</option>
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                                <option value="4">4</option>
                                <option value="5">5</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="habitaciones">Parqueos</label>
                            <select class="form-control" name="parqueos" id="parqueos" wire:model.lazy="parqueos">
                                <option selected>Parqueos</option>
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                                <option value="4">4</option>
                                <option value="5">5</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="habitaciones">Captadas Por</label>
                            <select class="form-control" name="captadas_por" id="captadas_por"
                                wire:model.lazy="captadas_por">
                                <option value="todos">TODOS</option>
                                <option value="mi">USUARIO</option>
                            </select>
                        </div>
                    </div>




                    <?php if($Id > 0): ?>
                        <div class="button-group mt-4">
                            <button class="btn btn-primary mb-2"
                                wire:click.prevent="updatePropuesta(<?php echo e($Id); ?>)">Crear propuesta</button>
                        </div>
                    <?php endif; ?>
                </div>

                <?php if(session('success')): ?>
                    <div class="alert alert-success">
                        <?php echo e(session('success')); ?>

                    </div>
                <?php endif; ?>

                <?php if(session('duplicado')): ?>
                    <div class="alert alert-danger">
                        <?php echo e(session('duplicado')); ?>

                    </div>
                <?php endif; ?>

                

            </div>
        </div>



        <?php if($Id != 0): ?>

            <div class="row">

                <div class="card card-body shadow">


                    <div class="col-md-12">

                        <div class="col-md-12">
                            <div class="my-3">
                                <label for="" class="form-label">Notas <?php if($id_nota != ''): ?>
                                        ID:<?php echo e($id_nota); ?>

                                    <?php endif; ?>
                                </label>
                                <textarea class="form-control" name="nota" id="nota" rows="3" wire:model="nota"></textarea>
                            </div>
                        </div>

                        <div class="row justify-content-end">
                            <div class="col-md-2">
                                <button type="button" class="btn btn-success btn-block m-1 p-1"
                                    <?php if($id_nota == ''): ?> wire:click='agregarnota' <?php else: ?> wire:click='actualizarnota(<?php echo e($id_nota); ?>)' <?php endif; ?>>
                                    <?php if($id_nota == ''): ?>
                                        Grabar
                                    <?php else: ?>
                                        Actualizar
                                    <?php endif; ?>
                                </button>
                            </div>
                            <div class="col-md-2">
                                <button type="button" class="btn btn-danger btn-block m-1 p-1"
                                    wire:click="limpiar_nota()">Cancelar
                                </button>
                            </div>
                        </div>

                        <div class="my-1">
                            <?php if(session('notaagregada')): ?>
                                <?php if(session('notaagregada') != ''): ?>
                                    <div class="alert alert-success p-1">
                                        <?php echo e(session('notaagregada')); ?>

                                    </div>
                                <?php endif; ?>
                            <?php endif; ?>

                            <?php if(session('borrarnota')): ?>
                                <?php if(session('borrarnota') != ''): ?>
                                    <div class="alert alert-danger p-1">
                                        <?php echo e(session('borrarnota')); ?>

                                    </div>
                                <?php endif; ?>
                            <?php endif; ?>

                            <?php if(session('editarnota')): ?>
                                <?php if(session('editarnota') != ''): ?>
                                    <div class="alert alert-warning p-1">
                                        <?php echo e(session('editarnota')); ?>

                                    </div>
                                <?php endif; ?>
                            <?php endif; ?>

                            <?php if(session('actualizarnota')): ?>
                                <?php if(session('actualizarnota') != ''): ?>
                                    <div class="alert alert-info p-1">
                                        <?php echo e(session('actualizarnota')); ?>

                                    </div>
                                <?php endif; ?>
                            <?php endif; ?>

                        </div>

                        <div class="col-md-12">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <h4 class="text-dark mb-0">Notas</h4>
                                <?php $__errorArgs = ['nota'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <span class="error text-danger p-2"><?php echo e($message); ?> ....</span>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>

                            <?php $__empty_1 = true; $__currentLoopData = $notas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $nota): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                <div class="card mb-1">
                                    <div class="card-body">


                                        <div class="w-100">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <h6 class="text-primary fw-bold mb-0">
                                                    <span class="text-dark ms-2">
                                                        <?php echo e($nota->nota); ?>

                                                    </span>
                                                </h6>
                                            </div>
                                            <div class="d-flex justify-content-between align-items-center">
                                                <div class="d-flex flex-row">
                                                    <i class="fas"
                                                        style="color: #aaa;"><?php echo e($nota->created_at); ?></i>
                                                    <i class="far fa-star mx-2" style="color: #aaa;"></i>
                                                    <i class="far fa-check-circle text-primary"></i>
                                                </div>
                                                <div class="btn-group">
                                                    <button type="button" class="btn btn-success"
                                                        @click="$dispatch('actualizar-valor', 'true')"
                                                        wire:click="editarnota(<?php echo e($nota->id); ?>)">
                                                        <i class="fa fa-edit"></i>
                                                    </button>
                                                    <button type="button" class="btn btn-danger"
                                                        wire:click="$emit('generarBorrarSweetAlert',<?php echo e($nota->id); ?>, 'Borrar Nota ID ', 'borrarnota')">
                                                        <i class="fa fa-trash"></i>
                                                    </button>
                                                </div>
                                            </div>

                                        </div>

                                    </div>
                                </div>

                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <?php endif; ?>

                        </div>

                    </div>

                </div>

            </div>
        <?php else: ?>
        <?php endif; ?>

        <?php if($Id != 0): ?>
            <div class="row card card-body shadow">
                <div class="row">
                    <div class="col-md-12 mb-3 table-responsive">

                        <div class="form-group">
                            <label for="nombre">Titulo de Tarea <?php if($id_tarea != ''): ?>
                                    ID:<?php echo e($id_tarea); ?>

                                <?php endif; ?>
                            </label>
                            <input type="text" class="form-control" wire:model.lazy="nombre_tarea"
                                placeholder="tarea" required>
                            <?php $__errorArgs = ['nombre_tarea'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <span class="error text-danger"><?php echo e($message); ?></span>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <div class="form-group">
                            <label for="descripcion">Descripción</label>
                            <textarea class="form-control" wire:model.lazy="descripcion_tarea" required rows="3"></textarea>
                            <?php $__errorArgs = ['descripcion_tarea'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <span class="error text-danger"><?php echo e($message); ?></span>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <div class="row">

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="Clientes">Tipo de Tarea</label>
                                    <select class="form-control" wire:model.lazy="tipo_tarea">
                                        <option selected>Tipo</option>
                                        <?php $__currentLoopData = $tipos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tipo): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($tipo->id); ?>"><?php echo e($tipo->todo_tipo); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                    <?php $__errorArgs = ['tipo_tarea'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <span class="error text-danger"><?php echo e($message); ?></span>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="fecha">Fecha*</label>
                                    <input type="datetime-local" class="form-control" placeholder="Fecha Limite"
                                        wire:model.lazy="fecha_tarea" required>
                                    <?php $__errorArgs = ['fecha_tarea'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <span class="error text-danger"><?php echo e($message); ?></span>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="Clientes">Estatus de la Tarea</label>
                                    <select class="form-control" wire:model.lazy="estatus_tarea">
                                        <option selected>Estatus</option>
                                        <?php $__currentLoopData = $estatuses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $estatus): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($estatus->id); ?>"><?php echo e($estatus->todo_estatus); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                    <?php $__errorArgs = ['estatus_tarea'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <span class="error text-danger"><?php echo e($message); ?></span>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>
                            </div>

                        </div>

                        <div class="row">

                            <div>
                                <?php if(session('agregartarea')): ?>
                                    <?php if(session('agregartarea') != ''): ?>
                                        <div class="alert alert-success">
                                            <?php echo e(session('agregartarea')); ?>

                                        </div>
                                    <?php endif; ?>
                                <?php endif; ?>

                                <?php if(session('actualizartarea')): ?>
                                    <?php if(session('actualizartarea') != ''): ?>
                                        <div class="alert alert-warning">
                                            <?php echo e(session('actualizartarea')); ?>

                                        </div>
                                    <?php endif; ?>
                                <?php endif; ?>

                                <?php if(session('editartarea')): ?>
                                    <?php if(session('editartarea') != ''): ?>
                                        <div class="alert alert-info">
                                            <?php echo e(session('editartarea')); ?>

                                        </div>
                                    <?php endif; ?>
                                <?php endif; ?>

                                <?php if(session('borrartarea')): ?>
                                    <?php if(session('borrartarea') != ''): ?>
                                        <div class="alert alert-danger">
                                            <?php echo e(session('borrartarea')); ?>

                                        </div>
                                    <?php endif; ?>
                                <?php endif; ?>
                            </div>
                        </div>

                        <div class="row">
                            <div class="row justify-content-end">
                                <div class="col-md-6">
                                    <a class="btn btn-success btn-block m-1 p-1"
                                        <?php if($id_tarea == ''): ?> wire:click='agregartarea' <?php else: ?> wire:click='actualizartarea(<?php echo e($id_tarea); ?>)' <?php endif; ?>
                                        role="button">
                                        <?php if($id_tarea == ''): ?>
                                            Grabar
                                        <?php else: ?>
                                            Actualizar
                                        <?php endif; ?>
                                    </a>
                                </div>
                                <div class="col-md-6">
                                    <a class="btn btn-danger btn-block m-1 p-1" href="#"
                                        wire:click="limpiar_tarea()" role="button">Cancelar</a>
                                </div>
                            </div>
                        </div>


                        <div class="row my-1">

                            <div class="col-md-12">

                                <div class="card shadow col-md-12">
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <h4 class="text-dark mb-0">Tareas</h4>
                                        <?php $__errorArgs = ['nota'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                            <span class="error text-danger p-2"><?php echo e($message); ?> ....</span>
                                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                    </div>

                                    <table class="table table-striped m-1">
                                        <thead>
                                            <tr>
                                                <th class="d-none d-md-table-cell">#</th>
                                                <th class="">Fecha</th>
                                                <th class="">Titulo</th>
                                                <th class="d-none d-md-table-cell">Descripción</th>
                                                <th class="d-none d-md-table-cell">Tipo</th>
                                                <th class="">Estatus</th>
                                                <th class="text-center">Acción</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $__empty_1 = true; $__currentLoopData = $tareas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tarea): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                                <tr>
                                                    <td class="d-none d-md-table-cell"><?php echo e($tarea->id); ?></td>
                                                    <td><?php echo e($tarea->fechaLimite); ?></td>
                                                    <td><?php echo e($tarea->nombre); ?></td>
                                                    <td class="d-none d-md-table-cell"><?php echo e($tarea->descripcion); ?></td>
                                                    <td class="d-none d-md-table-cell"><?php echo e($tarea->todo_tipo); ?></td>
                                                    <td><?php echo e($tarea->todo_estatus); ?></td>


                                                    <td class="text-center">
                                                        <div class="btn-group">
                                                            <button type="button" class="btn btn-success"
                                                                @click="$dispatch('actualizar-valor', 'true')"
                                                                wire:click="editartarea(<?php echo e($tarea->id); ?>)">
                                                                <i class="fa fa-edit"></i>
                                                            </button>
                                                            <button type="button" class="btn btn-danger"
                                                                wire:click="$emit('generarBorrarSweetAlert',<?php echo e($tarea->id); ?>, 'Borrar Tarea ID ', 'borrartarea')"
                                                                type="submit">
                                                                <i class="fa fa-trash"></i>
                                                            </button>
                                                        </div>
                                                    </td>

                                                </tr>


                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                            <?php endif; ?>
                                        </tbody>
                                    </table>
                                </div>

                            </div>

                        </div>

                    </div>
                </div>
            </div>
        <?php endif; ?>

        <?php echo $__env->make('components.modalfootercliente', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>


    </div>
<?php /**PATH D:\xampp3\htdocs\realestate_dev\resources\views\livewire\buscar-cliente.blade.php ENDPATH**/ ?>