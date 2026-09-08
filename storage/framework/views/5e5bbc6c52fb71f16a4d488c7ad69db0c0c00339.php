<div>
    <style>
        .assign-shell {
            display: grid;
            gap: 1rem;
        }

        .assign-hero {
            background: linear-gradient(135deg, #0f172a 0%, #0f766e 52%, #22c55e 100%);
            color: #fff;
            border-radius: 1.25rem;
            box-shadow: 0 20px 40px rgba(15, 23, 42, 0.14);
            overflow: hidden;
        }

        .assign-stat {
            border: 1px solid rgba(255, 255, 255, 0.18);
            background: rgba(255, 255, 255, 0.12);
            border-radius: 1rem;
            padding: 1rem;
            min-height: 100%;
        }

        .assign-panel {
            border: 1px solid #e2e8f0;
            border-radius: 1.25rem;
            box-shadow: 0 16px 35px rgba(15, 23, 42, 0.06);
        }

        .assign-search,
        .assign-select {
            min-height: 3.1rem;
            border-radius: 0.9rem;
            border-color: #d8e2ec;
        }

        .assign-table {
            margin-bottom: 0;
        }

        .assign-table thead th {
            border-top: 0;
            border-bottom: 1px solid #e5e7eb;
            color: #64748b;
            font-size: 0.76rem;
            letter-spacing: 0.08em;
            text-transform: uppercase;
            white-space: nowrap;
        }

        .assign-table tbody td {
            vertical-align: middle;
            border-color: #eef2f7;
        }

        .contact-name {
            font-weight: 700;
            color: #0f172a;
        }

        .contact-meta {
            color: #64748b;
            font-size: 0.88rem;
        }

        .assign-badge {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 999px;
            padding: 0.4rem 0.75rem;
            font-size: 0.75rem;
            font-weight: 700;
            letter-spacing: 0.04em;
            white-space: nowrap;
        }

        .assign-badge-status-nuevo,
        .assign-badge-prob-bajas {
            background: #fff7ed;
            color: #c2410c;
        }

        .assign-badge-status-contactado,
        .assign-badge-prob-medias {
            background: #eff6ff;
            color: #1d4ed8;
        }

        .assign-badge-status-activo,
        .assign-badge-prob-altas {
            background: #ecfdf5;
            color: #047857;
        }

        .assign-badge-status-futuro,
        .assign-badge-prob-desconocida,
        .assign-badge-status-noescliente {
            background: #f8fafc;
            color: #475569;
        }

        .assign-badge-status-cierre {
            background: #f0fdf4;
            color: #15803d;
        }

        .assign-badge-status-descartado {
            background: #fef2f2;
            color: #b91c1c;
        }

        .assign-owner {
            display: flex;
            flex-direction: column;
            gap: 0.15rem;
        }

        .assign-owner-label {
            font-size: 0.76rem;
            color: #94a3b8;
            text-transform: uppercase;
            letter-spacing: 0.08em;
        }

        .assign-owner-name {
            font-weight: 600;
            color: #0f172a;
        }

        .assign-actions {
            display: flex;
            justify-content: center;
            gap: 0.55rem;
        }

        .assign-action-btn {
            min-width: 2.8rem;
            min-height: 2.8rem;
            border-radius: 0.9rem;
        }

        .assign-primary-action {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            border-radius: 0.9rem;
            padding: 0.75rem 1rem;
            font-weight: 600;
        }

        .assign-modal .modal-content {
            border: 0;
            border-radius: 1.3rem;
            overflow: hidden;
            box-shadow: 0 24px 60px rgba(15, 23, 42, 0.18);
        }

        .assign-modal-hero {
            background: linear-gradient(135deg, #0f172a 0%, #14532d 100%);
            color: #fff;
            padding: 1.25rem 1.5rem;
        }

        .assign-modal-hero .close {
            color: #fff;
            opacity: 0.8;
            text-shadow: none;
        }

        .assign-modal-body {
            padding: 1.5rem;
            background: #f8fafc;
        }

        .assign-contact-card {
            background: #fff;
            border: 1px solid #e2e8f0;
            border-radius: 1rem;
            padding: 1rem;
            margin-bottom: 1rem;
        }

        .assign-contact-card small {
            display: block;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            color: #64748b;
            margin-bottom: 0.35rem;
        }

        .assign-contact-current {
            display: inline-flex;
            align-items: center;
            gap: 0.45rem;
            padding: 0.45rem 0.7rem;
            border-radius: 999px;
            background: #f1f5f9;
            color: #0f172a;
            font-weight: 600;
            margin-top: 0.75rem;
        }

        .assign-modal .form-control {
            min-height: 3rem;
            border-radius: 0.9rem;
            border-color: #d8e2ec;
        }

        @media (max-width: 767.98px) {
            .assign-actions {
                justify-content: flex-start;
            }

            .assign-table thead {
                display: none;
            }

            .assign-table,
            .assign-table tbody,
            .assign-table tr,
            .assign-table td {
                display: block;
                width: 100%;
            }

            .assign-table tr {
                border-bottom: 1px solid #e5e7eb;
                padding: 0.85rem 0;
            }

            .assign-table td {
                border: 0;
                padding: 0.3rem 0.75rem;
            }
        }
    </style>

    <div class="assign-shell">
        <section class="assign-hero">
            <div class="card-body p-4 p-lg-5">
                <div class="row align-items-center">
                    <div class="col-lg-7 mb-4 mb-lg-0">
                        <p class="text-uppercase mb-2" style="letter-spacing:.14em; opacity:.78; font-size:.78rem;">CRM Comercial</p>
                        <h2 class="mb-2 font-weight-bold">Asignación de contactos</h2>
                        <p class="mb-0" style="opacity:.88; max-width:42rem;">Filtra contactos por estatus o probabilidad, identifica rápido quién los captó y reasígnalos desde un modal más claro.</p>
                    </div>
                    <div class="col-lg-5">
                        <div class="row">
                            <div class="col-6 mb-3">
                                <div class="assign-stat">
                                    <div class="small text-uppercase" style="opacity:.76; letter-spacing:.08em;">Total visible</div>
                                    <div class="h3 mb-0 font-weight-bold"><?php echo e($clientes->total()); ?></div>
                                </div>
                            </div>
                            <div class="col-6 mb-3">
                                <div class="assign-stat">
                                    <div class="small text-uppercase" style="opacity:.76; letter-spacing:.08em;">En página</div>
                                    <div class="h3 mb-0 font-weight-bold"><?php echo e($clientes->count()); ?></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="card assign-panel">
            <div class="card-body p-4">
                <div class="row align-items-end">
                    <div class="col-lg-6 mb-3">
                        <label for="criterio" class="small text-muted font-weight-bold text-uppercase mb-2">Buscar contacto</label>
                        <input type="text" class="form-control assign-search" wire:model.debounce.350ms="criterio" id="criterio" name="criterio" placeholder="Nombre o ID del contacto">
                    </div>
                    <div class="col-lg-3 mb-3">
                        <label for="criterioestatus" class="small text-muted font-weight-bold text-uppercase mb-2">Estatus</label>
                        <select class="form-control assign-select" name="criterioestatus" id="criterioestatus" wire:model="criterioestatus">
                            <option value="">Todos los estatus</option>
                            <option value="NUEVO">NUEVO</option>
                            <option value="CONTACTADO">CONTACTADO</option>
                            <option value="ACTIVO">ACTIVO</option>
                            <option value="FUTURO">FUTURO</option>
                            <option value="CIERRE">CIERRE</option>
                            <option value="DESCARTADO">DESCARTADO</option>
                            <option value="NOESCLIENTE">NO ES CLIENTE POTENCIAL</option>
                        </select>
                    </div>
                    <div class="col-lg-3 mb-3">
                        <label for="criterioprobabilidades" class="small text-muted font-weight-bold text-uppercase mb-2">Probabilidad</label>
                        <select class="form-control assign-select" name="criterioprobabilidades" id="criterioprobabilidades" wire:model="criterioprobabilidades">
                            <option value="">Todas las probabilidades</option>
                            <option value="BAJAS">BAJAS</option>
                            <option value="MEDIAS">MEDIAS</option>
                            <option value="ALTAS">ALTAS</option>
                            <option value="DESCONOCIDA">DESCONOCIDA</option>
                        </select>
                    </div>
                </div>
            </div>
        </section>

        <?php if(isset($clientes)): ?>
            <section class="card assign-panel">
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table assign-table">
                            <thead>
                                <tr>
                                    <th class="pl-4">Contacto</th>
                                    <th>Estatus</th>
                                    <th>Probabilidad</th>
                                    <th class="d-none d-lg-table-cell">Teléfono</th>
                                    <th class="d-none d-xl-table-cell">Captado por</th>
                                    <th>Asignado a</th>
                                    <th class="text-center pr-4">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__empty_1 = true; $__currentLoopData = $clientes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cliente): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                    <?php
                                        $statusClass = 'assign-badge-status-' . 
                                            Illuminate\Support\Str::of($cliente->estatus ?: 'sin-estatus')->lower()->replace(' ', '')->replace('-', '');
                                        $probabilityClass = 'assign-badge-prob-' . 
                                            Illuminate\Support\Str::of($cliente->probabilidades ?: 'desconocida')->lower()->replace(' ', '')->replace('-', '');
                                    ?>
                                    <tr>
                                        <td class="pl-4">
                                            <div class="contact-name"><?php echo e($cliente->nombre); ?></div>
                                            <div class="contact-meta">ID #<?php echo e($cliente->id); ?></div>
                                            <div class="contact-meta d-lg-none"><?php echo e($cliente->telefono ?: 'Sin teléfono'); ?></div>
                                        </td>
                                        <td>
                                            <span class="assign-badge <?php echo e($statusClass); ?>"><?php echo e($cliente->estatus ?: 'SIN ESTATUS'); ?></span>
                                        </td>
                                        <td>
                                            <span class="assign-badge <?php echo e($probabilityClass); ?>"><?php echo e($cliente->probabilidades ?: 'DESCONOCIDA'); ?></span>
                                        </td>
                                        <td class="d-none d-lg-table-cell">
                                            <span class="contact-meta"><?php echo e($cliente->telefono ?: 'Sin teléfono'); ?></span>
                                        </td>
                                        <td class="d-none d-xl-table-cell">
                                            <div class="assign-owner">
                                                <span class="assign-owner-label">Captador</span>
                                                <span class="assign-owner-name"><?php echo e($cliente->captador_name ?: 'Sin asignar'); ?></span>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="assign-owner">
                                                <span class="assign-owner-label">Asesor</span>
                                                <span class="assign-owner-name"><?php echo e($cliente->asignado_name ?: 'Sin asignar'); ?></span>
                                            </div>
                                        </td>
                                        <td class="text-center pr-4">
                                            <div class="assign-actions">
                                                <button type="button" class="btn btn-light border assign-action-btn text-danger"
                                                    wire:click="$emit('generarBorrarSweetAlert',<?php echo e($cliente->id); ?>, 'Borrar Cliente ID ', 'borrarContacto')"
                                                    data-element-id="<?php echo e($cliente->id); ?>" title="Eliminar contacto">
                                                    <i class="fa fa-trash"></i>
                                                </button>
                                                <button type="button" class="btn btn-success assign-primary-action"
                                                    wire:click="asignarContacto(<?php echo e($cliente->id); ?>)" data-toggle="modal"
                                                    data-target="#modalAsignar">
                                                    <i class="fa fa-user-check"></i>
                                                    <span>Asignar</span>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                    <tr>
                                        <td colspan="7" class="text-center py-5 text-muted">
                                            No hay contactos que coincidan con los filtros actuales.
                                        </td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-footer bg-white border-0 pt-3">
                    <?php echo e($clientes->links()); ?>

                </div>
            </section>
        <?php endif; ?>

    <?php echo $__env->make('components.modalheader', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

    <div class="row card card-body shadow">
        <div class="col-md-12">

            <div class="row">
                <div class="col-md-2">
                    <div class="form-group">
                        <label for="titulo">Titulo</label>
                        <select class="form-control" name="titulo" id="titulo" required wire:model.lazy="titulo">
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
                        <input type="text" wire:model.lazy="nombre" id="nombre" name="nombre" required class="form-control">
                        <?php $__errorArgs = ['nombre'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="error text-danger"><?php echo e($message); ?></span> <?php unset($message);
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
                        <select class="form-control" name="tipo_contacto" id="tipo_contacto" wire:model.lazy="tipo_contacto"
                            required>
                            <option value="">Tipo</option>
                            <option value="PersonaFisica">Persona Fisica</option>
                            <option value="Empresa">Empresa</option>
                        </select>
                        <?php $__errorArgs = ['tipo_contacto'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="error text-danger"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                </div>
            
                <div class="col-md-3">                                
                    <div class="form-group">
                        <label for="telefono">* Telefono</label>
                        <input type="number" required class="form-control" wire:model.lazy="telefono" <?php if($Id>0): ?> disabled <?php endif; ?> wire:change="verificarContacto()" >
                        <?php $__errorArgs = ['telefono'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="error text-danger"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>                                   
                </div>
            
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="email">Correo</label>
                        <input type="email" class="form-control" id="email" name="email" placeholder="email"
                            wire:model.lazy="email">
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
                    <textarea class="form-control" name="comentario" id="comentario" rows="3"
                        wire:model.lazy="comentario"></textarea>
                    <?php $__errorArgs = ['comentario'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="error text-danger"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>                    
            </div>

            <div class="row">

                <div class="form-group col-md-4">
                    <label for="contact_at">* Fecha de Contacto</label>
                    <input type="date" class="form-control" required id="contact_at" name="contact_at" wire:model.lazy="contact_at">
                    <?php $__errorArgs = ['contact_at'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="error text-danger"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>
                
                <div class="form-group col-md-4">
                    <label for="contact_at">* Estatus 
                    <?php if($estatus=="NUEVO"): ?>
                    <span class="fa fa-handshake text-warning mx-1"></span>
                    <?php endif; ?>
                    <?php if($estatus=="CONTACTADO"): ?>
                    <span class="fa fa-comments text-info mx-1"></span>
                    <?php endif; ?>
                    <?php if($estatus=="ACTIVO"): ?>
                    <span class="fa fa-people-carry text text-danger mx-1"></span>
                    <?php endif; ?>
                    <?php if($estatus=="CIERRE"): ?>
                    <span class="fa fa-check-double text text-success mx-1"></span>
                    <?php endif; ?>
                    <?php if($estatus=="FUTURO"): ?>
                    <span class="fa fa-business-time text text-dark mx-1"></span>
                    <?php endif; ?>
                    <?php if($estatus=="DESCARTADO"): ?>
                    <span class="fa fa-ban text text-muted mx-1"></span>
                    <?php endif; ?>
                    <?php if($estatus=="NOESCLIENTE"): ?>
                    <span class="fa fa-users text text-dark mx-1"></span>
                    <?php endif; ?>
                    </label>
                    <select class="form-control" aria-label="Default select example" name="estatus" id="estatus" wire:model.lazy="estatus">
                        <option></option>
                        <option <?php if($Id==""): ?> selected <?php else: ?> required <?php endif; ?> value="NUEVO">NUEVO</option>
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
$message = $__bag->first($__errorArgs[0]); ?> <span class="error text-danger"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>
                
                <div class="col-md-4">
                    <label for="contact_at">Probabilidades
                    <?php if($probabilidades=="BAJAS"): ?>
                        <span class="fa fa-star text-warning mx-1">
                    <?php endif; ?>

                    <?php if($probabilidades=="MEDIAS"): ?>
                        <span class="fa fa-star text-warning mx-1">
                        <span class="fa fa-star text-warning mx-1">
                        <span class="fa fa-star text-warning mx-1">
                    <?php endif; ?>   
                    
                    <?php if($probabilidades=="ALTAS"): ?>
                        <span class="fa fa-star text-warning mx-0">
                        <span class="fa fa-star text-warning mx-0">
                        <span class="fa fa-star text-warning mx-0">
                        <span class="fa fa-star text-warning mx-0">
                        <span class="fa fa-star text-warning mx-0">                                          
                    <?php endif; ?>  
                    </label>                                   
                    <select class="form-control" name="probabilidades" id="probabilidades" wire:model.lazy="probabilidades">
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
$message = $__bag->first($__errorArgs[0]); ?> <span class="error text-danger"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>   

            </div>    
            
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="tipo_contacto2">* Tipo Contacto</label>
                        <select class="form-control" name="tipo_contacto2" id="tipo_contacto2" required wire:model.lazy="tipo_contacto2">
                            <option value="">Tipo</option>
                            <option value="Vendedor">Vendedor</option>
                            <option value="Comprador">Comprador</option>
                            <option value="Inquilino">Inquilino</option>
                        </select>
                        <?php $__errorArgs = ['tipo_contacto2'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="error text-danger"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                </div>
                    
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="medio">* Por donde supo de nosotros</label>
                        <select class="form-control" name="medio" id="medio" required wire:model.lazy="medio">
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
$message = $__bag->first($__errorArgs[0]); ?> <span class="error text-danger"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                </div>                                
            </div>
    
            <div class="row">                               

                    <div class="form-group col-md-4">
                        <label for="fecha">Fecha del cierre:</label>
                        <input type="date" id="fechacierre" wire:model.lazy="fechacierre" name="fechacierre" class="form-control">
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
                            <option value="<?php echo e($estado_propiedad->id); ?>"><?php echo e($estado_propiedad->estado); ?></option>
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
                        <input type="text" class="form-control monto" id="precio_mini" name="precio_mini"  wire:model.lazy="precio_mini">
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label for="precio_max">Precio Max RD$</label>
                        <input type="text" class="form-control monto" id="precio_max" name="precio_max"  wire:model.lazy="precio_max">
                    </div>
                </div>
            </div>

            <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="tipo_en_dolar">Tipo US$</label>
                            <select class="form-control" name="tipo_en_dolar" id="tipo_en_dolar" wire:model.lazy="tipo_en_dolares">
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
                            <select class="form-control" name="estadopropiedad_en_dolar" id="estadopropiedad_en_dolar"
                                wire:model.lazy="estadopropiedad_en_dolar">
                                <option value="" selected></option>
                                <?php $__empty_1 = true; $__currentLoopData = $estados_propiedad; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $estado_propiedad): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                <option value="<?php echo e($estado_propiedad->id); ?>"><?php echo e($estado_propiedad->estado); ?></option>
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
                        <input type="text" class="form-control monto" id="precio_mini_dolar" name="precio_mini_dolar"
                             wire:model.lazy="precio_mini_dolar">
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label for="precio">Precio Max US$</label>
                        <input type="text" class="form-control monto" id="precio_max_dolar" name="precio_max_dolar" 
                            wire:model.lazy="precio_max_dolar">
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
                        <select class="form-control" name="captadas_por" id="captadas_por" wire:model.lazy="captadas_por">
                            <option value="todos">TODOS</option>
                            <option value="mi">USUARIO</option>
                        </select>
                    </div>
                </div>

          
                    

                <?php if($Id>0): ?>
                    <div class="button-group mt-4">
                        <button class="btn btn-primary mb-2" wire:click.prevent="updatePropuesta(<?php echo e($Id); ?>)">Crear propuesta</button>
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

    

        <?php if($Id!=0): ?>

        <div class="row">

            <div class="card card-body shadow">


                <div class="col-md-12"> 
                    
                        <div class="col-md-12">
                            <div class="my-3">
                                <label for="" class="form-label">Notas <?php if($id_nota!=""): ?> ID:<?php echo e($id_nota); ?> <?php endif; ?></label>
                                <textarea class="form-control" name="nota" id="nota" rows="3" wire:model="nota"></textarea>
                            </div>
                        </div>

                        <div class="row justify-content-end">
                            <div class="col-md-2">
                                <button type="button" 
                                class="btn btn-success btn-block m-1 p-1" 
                                <?php if($id_nota==""): ?> wire:click='agregarnota' <?php else: ?> wire:click='actualizarnota(<?php echo e($id_nota); ?>)' <?php endif; ?>>
                                <?php if($id_nota==""): ?> Grabar <?php else: ?> Actualizar <?php endif; ?>
                                </button>
                            </div>
                            <div class="col-md-2">
                                <button type="button" 
                                class="btn btn-danger btn-block m-1 p-1" 
                                wire:click="limpiar_nota()">Cancelar
                                </button>
                            </div>
                        </div> 
                        
                        <div class="my-1">
                            <?php if(session('notaagregada')): ?>
                                <?php if(session('notaagregada')!=''): ?>
                                    <div class="alert alert-success p-1">
                                        <?php echo e(session('notaagregada')); ?>

                                    </div>
                                <?php endif; ?>
                            <?php endif; ?>   
                            
                            <?php if(session('borrarnota')): ?>
                                <?php if(session('borrarnota')!=''): ?>
                                    <div class="alert alert-danger p-1">
                                        <?php echo e(session('borrarnota')); ?>

                                    </div>
                                <?php endif; ?>
                            <?php endif; ?>        
                            
                            <?php if(session('editarnota')): ?>
                                <?php if(session('editarnota')!=''): ?>
                                    <div class="alert alert-warning p-1">
                                        <?php echo e(session('editarnota')); ?>

                                    </div>
                                <?php endif; ?>
                            <?php endif; ?>  
                            
                            <?php if(session('actualizarnota')): ?>
                                <?php if(session('actualizarnota')!=''): ?>
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
$message = $__bag->first($__errorArgs[0]); ?> <span class="error text-danger p-2"><?php echo e($message); ?> ....</span> <?php unset($message);
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
                                                        <i class="fas" style="color: #aaa;"><?php echo e($nota->created_at); ?></i>
                                                        <i class="far fa-star mx-2" style="color: #aaa;"></i>
                                                        <i class="far fa-check-circle text-primary"></i>
                                                    </div>
                                                    <div class="btn-group">
                                                        <button 
                                                        type="button" class="btn btn-success" 
                                                        @click="$dispatch('actualizar-valor', 'true')" 
                                                        wire:click="editarnota(<?php echo e($nota->id); ?>)">
                                                        <i class="fa fa-edit"></i>
                                                        </button> 
                                                        <button 
                                                        type="button" class="btn btn-danger" 
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
                   
        <?php if($Id!=0): ?>
        <div class="row card card-body shadow">
            <div class="row" >
                <div class="col-md-12 mb-3 table-responsive">
                
                        <div class="form-group">
                            <label for="nombre">Titulo de Tarea <?php if($id_tarea!=""): ?> ID:<?php echo e($id_tarea); ?> <?php endif; ?></label>
                            <input type="text" class="form-control" wire:model.lazy="nombre_tarea" placeholder="tarea" required>
                            <?php $__errorArgs = ['nombre_tarea'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="error text-danger"><?php echo e($message); ?></span> <?php unset($message);
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
$message = $__bag->first($__errorArgs[0]); ?> <span class="error text-danger"><?php echo e($message); ?></span> <?php unset($message);
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
$message = $__bag->first($__errorArgs[0]); ?> <span class="error text-danger"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>      
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="fecha">Fecha*</label>
                                    <input type="datetime-local" class="form-control" placeholder="Fecha Limite" wire:model.lazy="fecha_tarea" required>
                                    <?php $__errorArgs = ['fecha_tarea'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="error text-danger"><?php echo e($message); ?></span> <?php unset($message);
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
$message = $__bag->first($__errorArgs[0]); ?> <span class="error text-danger"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>                                            
                            </div>

                        </div>

                        <div class="row">

                            <div>
                                <?php if(session('agregartarea')): ?>
                                    <?php if(session('agregartarea')!=''): ?>
                                        <div class="alert alert-success">
                                            <?php echo e(session('agregartarea')); ?>

                                        </div>
                                    <?php endif; ?>
                                <?php endif; ?>   
            
                                <?php if(session('actualizartarea')): ?>
                                    <?php if(session('actualizartarea')!=''): ?>
                                        <div class="alert alert-warning">
                                            <?php echo e(session('actualizartarea')); ?>

                                        </div>
                                    <?php endif; ?>
                                <?php endif; ?>   
                                
                                <?php if(session('editartarea')): ?>
                                    <?php if(session('editartarea')!=''): ?>
                                        <div class="alert alert-info">
                                            <?php echo e(session('editartarea')); ?>

                                        </div>
                                    <?php endif; ?>
                                <?php endif; ?>                            
                                
                                <?php if(session('borrartarea')): ?>
                                    <?php if(session('borrartarea')!=''): ?>
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
                                    <a class="btn btn-success btn-block m-1 p-1"  <?php if($id_tarea==""): ?> wire:click='agregartarea' <?php else: ?> wire:click='actualizartarea(<?php echo e($id_tarea); ?>)' <?php endif; ?> role="button"><?php if($id_tarea==""): ?> Grabar <?php else: ?> Actualizar <?php endif; ?></a>
                                </div>
                                <div class="col-md-6">
                                    <a class="btn btn-danger btn-block m-1 p-1" href="#" wire:click="limpiar_tarea()" role="button">Cancelar</a>
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
$message = $__bag->first($__errorArgs[0]); ?> <span class="error text-danger p-2"><?php echo e($message); ?> ....</span> <?php unset($message);
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

                        
                                                <td class="text-center" >
                                                    <div class="btn-group">
                                                        <button 
                                                            type="button" class="btn btn-success" 
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
    

    <!-- Modal -->
    <div class="modal fade assign-modal" id="modalAsignar" tabindex="-1" wire:ignore.self data-backdrop="static">
        <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="assign-modal-hero">
                <div class="d-flex align-items-start justify-content-between gap-3">
                    <div>
                        <p class="mb-2 text-uppercase" style="letter-spacing:.12em; font-size:.72rem; opacity:.76;">Reasignación</p>
                        <h5 class="modal-title mb-1" id="exampleModalLabel">Asignar contacto a otro asesor</h5>
                        <p class="mb-0" style="opacity:.82;">Confirma el contacto y selecciona el usuario responsable.</p>
                    </div>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            </div>
            <div class="assign-modal-body">
                <div class="assign-contact-card">
                    <small>Contacto seleccionado</small>
                    <div class="h5 mb-1"><?php if($contacto_actual): ?> <?php echo e($contacto_actual->nombre); ?> <?php else: ?> Selecciona un contacto <?php endif; ?></div>
                    <div class="text-muted"><?php if($contacto_actual): ?> Tel. <?php echo e($contacto_actual->telefono ?: 'Sin teléfono'); ?> <?php endif; ?></div>
                    <?php if($contacto_actual): ?>
                        <div class="assign-contact-current">
                            <i class="fa fa-user"></i>
                            <span>Asignado actualmente a: <?php echo e(optional($contacto_actual->user2)->name ?? 'Sin asignar'); ?></span>
                        </div>
                    <?php endif; ?>
                </div>

                <div class="form-group mb-0">
                    <label for="assign-user" class="small text-muted font-weight-bold text-uppercase mb-2">Nuevo responsable</label>
                    <select class="form-control" id="assign-user" wire:model="asignado_a" required>
                        <option value="">Selecciona un asesor</option>
                        <?php $__currentLoopData = $usuarios; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $usuario): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($usuario->id); ?>"><?php echo e($usuario->name); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>
            </div>

            <div class="modal-footer bg-white border-0 px-4 pb-4 pt-0">
                <button type="button" class="btn btn-light border" data-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-success px-4" wire:click.prevent="asignar()" <?php if(!$asignado_a): ?> disabled <?php endif; ?>>Guardar asignación</button>
            </div>
        </div>
        </div>
    </div>

    <script>   
        document.addEventListener('close-modal-asignar', event => {
            $('#modalAsignar').modal('hide');
            console.log('close-modal-asignar');
        });  
    
    </script> 
    
</div>

<?php /**PATH D:\xampp3\htdocs\realestate_dev\resources\views\livewire\asignar-contacto.blade.php ENDPATH**/ ?>