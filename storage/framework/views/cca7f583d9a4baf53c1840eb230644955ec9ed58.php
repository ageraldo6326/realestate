<div>


    <h1>CONTACTOS 2</h1>

    <div class="card card-solid">
        <div class="card-body pb-0">

            <div class="m-md-3 col-12 text-end">
                <button type="button" class="btn btn-primary" data-toggle="modal" wire:click='clear2' data-target="#modalForm" >Nuevo</button>
            </div>

            <div class="row">
                <div class="input-group my-3">
                    <input type="text" class="form-control" wire:model='criterio' name="criterio" placeholder="Buscar...">
                </div>             
            </div>

            <div class="row">
            
                <div class="col-md-3">
                    <div class="mb-3">
                        <label for="" class="form-label">Estatus</label>
                        <select class="form-select form-select-lg" name="criterioestatus" id="criterioestatus"  wire:model='criterioestatus'>
                            <option value=""></option>
                            <option value="NUEVO">NUEVO</option>
                            <option value="CONTACTADO">CONTACTADO</option>
                            <option value="ACTIVO">ACTIVO</option>
                            <option value="FUTURO">FUTURO</option>
                            <option value="CIERRE">CIERRE</option>
                            <option value="DESCARTADO">DESCARTADO</option>
                            <option value="NOESCLIENTE">NO ES CLIENTE POTENCIAL</option>
                        </select>
                    </div>
                </div>
            
                <div class="col-md-3 mb-3">
                    <label for="" class="form-label">Probabilidades</label>
                    <select class="form-select form-select-lg" name="criterioprobabilidades" id="criterioprobabilidades"
                        wire:model='criterioprobabilidades'>
                        <option selected></option>
                        <option value="BAJAS">BAJAS</option>
                        <option value="MEDIAS">MEDIAS</option>
                        <option value="ALTAS">ALTAS</option>
                        <option value="DESCONOCIDA">DESCONOCIDA</option>
                    </select>
                </div>
            
            </div>

        </div>
    </div>
 
         
            <div class="row">
                <?php if(isset($clientes)): ?>
                <?php $__empty_1 = true; $__currentLoopData = $clientes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cliente): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>

                <div class="col-12 col-sm-6 col-md-4 d-flex align-items-stretch flex-column">
                    <div class="card bg-light d-flex flex-fill">
                        <div class="card-header text-muted border-bottom-0">
                            <?php echo e($cliente->tipo_cliente); ?>

                        </div>
                        <div class="card-body pt-0">
                            <div class="row">
                                <div class="col-md-7">
                                    <h2 class="lead"><b>ID:<?php echo e($cliente->id); ?> <?php echo e($cliente->nombre); ?></b>
                                    <?php if($cliente->probabilidades=="BAJAS"): ?>
                                        <span class="fa fa-star text-warning text-ms mx-1">
                                    <?php endif; ?>

                                    <?php if($cliente->probabilidades=="MEDIAS"): ?>
                                        <span class="fa fa-star text-warning text-sm mx-1">
                                        <span class="fa fa-star text-warning text-sm mx-1">
                                        <span class="fa fa-star text-warning text-sm mx-1">
                                    <?php endif; ?>   
                                    
                                    <?php if($cliente->probabilidades=="ALTAS"): ?>
                                        <span class="fa fa-star text-warning text-sm mx-1">
                                        <span class="fa fa-star text-warning text-sm mx-1">
                                        <span class="fa fa-star text-warning text-sm mx-1">
                                        <span class="fa fa-star text-warning text-sm mx-1">
                                        <span class="fa fa-star text-warning text-sm mx-1">                                          
                                    <?php endif; ?>                                     
                                    </span></h2>
                                    <p class="text-muted text-lg"><b>Estatus: </b> <?php echo e($cliente->estatus); ?> 
                                    <?php if($cliente->estatus=="NUEVO"): ?>
                                        <span class="fa fa-handshake text-warning mx-1"></span>
                                    <?php endif; ?>       
                                    <?php if($cliente->estatus=="CONTACTADO"): ?>
                                        <span class="fa fa-comments text-info mx-1"></span>
                                    <?php endif; ?>              
                                    <?php if($cliente->estatus=="ACTIVO"): ?>
                                        <span class="fa fa-people-carry text text-danger mx-1"></span>
                                    <?php endif; ?>   
                                    <?php if($cliente->estatus=="CIERRE"): ?>
                                        <span class="fa fa-check-double text text-success mx-1"></span>
                                    <?php endif; ?>                                     
                                    <?php if($cliente->estatus=="FUTURO"): ?>
                                        <span class="fa fa-business-time text text-dark mx-1"></span>
                                    <?php endif; ?>
                                    <?php if($cliente->estatus=="DESCARTADO"): ?>
                                        <span class="fa fa-ban text text-muted mx-1"></span>
                                    <?php endif; ?>    
                                    <?php if($cliente->estatus=="NOESCLIENTE"): ?>
                                        <span class="fa fa-users text text-dark mx-1"></span>
                                    <?php endif; ?>                                                                                                                                                                                                 
                                    </p>

                                    <ul class="ml-4 mb-0 fa-ul text-muted">
                                        <li class="small"><span class="fa-li"><i class="fas fa-lg fa-mail-bulk"></i></span>
                                            Correo: <?php echo e($cliente->email); ?></li>
                                        <li class="small"><span class="fa-li"><i class="fas fa-lg fa-phone"></i></span>
                                            Telf #: <?php echo e($cliente->telefono); ?></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <div class="text-right">
                                <button class="btn btn-primary text-light text-md"  wire:click="edit(<?php echo e($cliente->id); ?>)" data-toggle="modal" data-target="#modalForm">Ver Contacto</button>
                            </div>
                        </div>
                    </div>
                </div>

                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>

                <?php endif; ?>
                <?php endif; ?>

            </div>


        <div class="card-footer">
            <nav aria-label="Contacts Page Navigation">
                <?php echo e($clientes->links('pagination::bootstrap-4')); ?>

            </nav>
        </div>
    

    <?php echo $__env->make('components.modalheader', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

    

    <div class="container-fluid">
        <div class="row">
            <div class="col-md-6">

                <div class="mb-3">
                        <form wire:submit.prevent="submit">

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
                    
                            <div class="form-group">
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
                                    <select class="form-select" aria-label="Default select example" name="estatus" id="estatus" wire:model.lazy="estatus">
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
                                
                                <div class="form-group col-4">
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
                                    <select class="form-select" aria-label="Default select example" name="probabilidades" id="probabilidades" wire:model.lazy="probabilidades">
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

                            <div class="form-group">

                                <div class="col-md-4 m-1">
                                    <input clase="form-control" type="checkbox" wire:model.lazy="activo">
                                    <label for="activo">Activo?</label>
                                </div>                                

                                <div class="col-md-4">
                                    <label for="fecha">Fecha del cierre:</label>
                                    <input type="date" id="fechacierre" wire:model.lazy="fechacierre" name="fechacierre" class="form-control">
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
                    
                            
                            
                            <div class="card">
                                <div class="card-body">
                                    <div class="row">
                                        <h3 class="text-bold text-primary">NEGOCIO</h3>
                                        <div class="col-md-4">
                    
                                            <div class="form-group">
                                                <label for="Zona">Zona</label>
                                                <select class="form-control" name="zona_id" id="zona_id" wire:model.lazy="zona_id">
                                                    <option selected>Zona</option>
                                                    <?php $__currentLoopData = $zonas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $zona): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <option value="<?php echo e($zona->id); ?>"><?php echo e($zona->zona); ?></option>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    
                                                </select>
                                            </div>
                                        </div>
                    
                                        <div class="row">

                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="tipo">Tipo</label>
                                                    <select class="form-control" name="tipo" id="tipo" wire:model.lazy="tipo">
                                                        <option selected>Tipo</option>
                                                        <?php $__currentLoopData = $tipos_propiedades; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tipos_propiedad): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <option value="<?php echo e($tipos_propiedad->id); ?>"><?php echo e($tipos_propiedad->tipo); ?>

                                                        </option>
                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                    </select>
                                                </div>
                                            </div>
                        
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="estadopropiedad">Estado</label>
                                                    <select class="form-control" name="estadopropiedad" id="estadopropiedad"
                                                        wire:model.lazy="estadopropiedad">
                                                        <option selected>Estado Propiedad</option>
                                                        <?php $__empty_1 = true; $__currentLoopData = $estados_propiedad; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $estado_propiedad): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                                        <option value="<?php echo e($estado_propiedad->id); ?>"><?php echo e($estado_propiedad->estado); ?></option>
                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        
                                                        <?php endif; ?>
                                                    </select>
                                                </div>
                                            </div>
                                                                                        
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="precio_mini">Precio Min RD$</label>
                                                    <input type="text" class="form-control monto" id="precio_mini" name="precio_mini" placeholder="Precio" wire:model.lazy="precio_mini">
                                                </div>
                                            </div>
                        
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="precio_max">Precio Max RD$</label>
                                                    <input type="text" class="form-control monto" id="precio_max" name="precio_max" placeholder="Precio" wire:model.lazy="precio_max">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="tipo_en_dolar">Tipo US$</label>
                                                <select class="form-control" name="tipo_en_dolar" id="tipo_en_dolar" wire:model.lazy="tipo_en_dolares">
                                                    <option selected>Tipo</option>
                                                    <?php $__currentLoopData = $tipos_propiedades; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tipos_propiedad): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <option value="<?php echo e($tipos_propiedad->id); ?>"><?php echo e($tipos_propiedad->tipo); ?>

                                                    </option>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                </select>
                                            </div>
                                        </div>
                    
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="estadopropiedad_en_dolar">Estado US$</label>
                                                <select class="form-control" name="estadopropiedad_en_dolar" id="estadopropiedad_en_dolar"
                                                    wire:model.lazy="estadopropiedad_en_dolar">
                                                    <option selected>Estado Propiedad</option>
                                                    <?php $__empty_1 = true; $__currentLoopData = $estados_propiedad; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $estado_propiedad): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                                    <option value="<?php echo e($estado_propiedad->id); ?>"><?php echo e($estado_propiedad->estado); ?></option>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    
                                                    <?php endif; ?>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="precio">Precio Min US$</label>
                                                <input type="text" class="form-control monto" id="precio_mini_dolar" name="precio_mini_dolar"
                                                    placeholder="Precio" wire:model.lazy="precio_mini_dolar">
                                            </div>
                                        </div>
                    
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="precio">Precio Max US$</label>
                                                <input type="text" class="form-control monto" id="precio_max_dolar" name="precio_max_dolar" placeholder="Precio"
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
                                            <div class="button-group">
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
                                        <div class="modal-footer">
                                            <form>            
                                                <button type="button" class="btn btn-primary close-modal" <?php if($grabar==0): ?> hidden <?php endif; ?> <?php if($Id==0): ?> wire:click.prevent='store' <?php else: ?> wire:click.prevent='update(<?php echo e($Id); ?>)' <?php endif; ?>> <?php if($Id==0): ?> Grabar <?php else: ?> Actualizar <?php endif; ?> </button>                                                
                                                <?php if($Id==0): ?>
                                                <button type="button" class="btn btn-warning" wire:click='clear'>Cancelar</button>
                                                <?php endif; ?>                                                
                                                <button type="button" class="btn btn-info close-modal text-white" wire:click="limpiar_tarea()" wire:click='salir()' data-bs-dismiss="modal">Salir</button>
                                                <?php if($Id!=0): ?>
                                                    <button type="button" class="btn btn-danger" wire:click="borrarConfirmacion(<?php echo e($telefono); ?>)">Borrar</button>
                                                <?php endif; ?>
                                            </form>
                                        </div>                                        
                    
                                    </div>
                                </div>
                            </div>
                    
                
                    
                        </form>
                    </div> 

                <div>
                    <?php if(session('notaagregada')): ?>
                        <?php if(session('notaagregada')!=''): ?>
                            <div class="alert alert-success">
                                <?php echo e(session('notaagregada')); ?>

                            </div>
                        <?php endif; ?>
                    <?php endif; ?>   
                    
                    <?php if(session('borrarnota')): ?>
                        <?php if(session('borrarnota')!=''): ?>
                            <div class="alert alert-danger">
                                <?php echo e(session('borrarnota')); ?>

                            </div>
                        <?php endif; ?>
                    <?php endif; ?>                   
                </div>

                <section style="background-color: #f7f6f6;">
                    <div class="container my-1 py-1 text-dark">
                        <div class="row d-flex justify-content-center">
                            <div class="col-md-12">
                                <div class="d-flex justify-content-between align-items-center mb-4">
                                    <h4 class="text-dark mb-0">Historial</h4>
                
                                </div>
                
                                <?php $__empty_1 = true; $__currentLoopData = $notas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $nota): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                
                                <div class="card mb-3">
                                    <div class="card-body">
                                        <div class="d-flex flex-start">
                                            <img class="rounded-circle shadow-1-strong me-3" src="<?php echo e(Auth::user()->foto); ?>" alt="avatar"
                                                width="40" height="40" />
                                            <div class="w-100">
                                                <div class="d-flex justify-content-between align-items-center mb-3">
                                                    <h6 class="text-primary fw-bold mb-0">
                                                        <span class="text-dark ms-2"><?php echo e($nota->nota); ?>

                                                        </span>
                                                    </h6>
                                                    <p class="mb-0"></p>
                                                </div>
                                                <div class="d-flex justify-content-between align-items-center">
                                                    <p class="small mb-0" style="color: #aaa;">
                                                        <a href="#!" class="link-grey" wire:click="borrarnota(<?php echo e($nota->id); ?>)">Borrar</a>
                                                        •
                                                    </p>
                                                    <div class="d-flex flex-row">
                                                        <i class="fas" style="color: #aaa;"><?php echo e($nota->created_at); ?></i>
                                                        <i class="far fa-star mx-2" style="color: #aaa;"></i>
                                                        <i class="far fa-check-circle text-primary"></i>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                
                                <?php endif; ?>
                
                            </div>
                        </div>
                    </section>                

            </div>
            <div class="col-md-6">
                

                    <div x-data="{
                            open : <?php if ((object) ('open') instanceof \Livewire\WireDirective) : ?>window.Livewire.find('<?php echo e($_instance->id); ?>').entangle('<?php echo e('open'->value()); ?>')<?php echo e('open'->hasModifier('defer') ? '.defer' : ''); ?><?php else : ?>window.Livewire.find('<?php echo e($_instance->id); ?>').entangle('<?php echo e('open'); ?>')<?php endif; ?>, 
                            nota : <?php if ((object) ('nota') instanceof \Livewire\WireDirective) : ?>window.Livewire.find('<?php echo e($_instance->id); ?>').entangle('<?php echo e('nota'->value()); ?>')<?php echo e('nota'->hasModifier('defer') ? '.defer' : ''); ?><?php else : ?>window.Livewire.find('<?php echo e($_instance->id); ?>').entangle('<?php echo e('nota'); ?>')<?php endif; ?>
                        }"
                    >
                        <?php if($Id>0): ?>
                        <a class="btn btn-primary" @click="[open = ! open, nota= '']" x-show="! open" x-on:actualizar-valor.window="open = $event.detail"><span
                                class="fa fa-plus text text-white mr-2"></span>Agregar tarea</a>
                        <?php endif; ?>
                        
                        <div class="row" x-show="open">
                            <div class="mb-3">
                                <div class="form-group">
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
                                                <select class="form-control form-control-sm" wire:model.lazy="tipo_tarea">
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
                                                <select class="form-control form-control-sm" wire:model.lazy="estatus_tarea">
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
                                

                                
                                </div>


                            </div>
                        </div>

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

                        <div class="row justify-content-end" x-show="open">
                            <div class="col-md-3">
                                <a class="btn btn-success btn-block m-1 p-1" @click="open = ! open"  <?php if($id_tarea==""): ?> wire:click='agregartarea' <?php else: ?> wire:click='actualizartarea(<?php echo e($id_tarea); ?>)' <?php endif; ?> role="button"><?php if($id_tarea==""): ?> Grabar <?php else: ?> Actualizar <?php endif; ?></a>
                            </div>
                            <div class="col-md-3">
                                <a class="btn btn-danger btn-block m-1 p-1" href="#" wire:click="limpiar_tarea()" @click="open = ! open" role="button">Cancelar</a>
                            </div>
                        </div>
                    </div>                



        

                <section style="background-color: #f7f6f6;">
                    <div class="container my-1 py-1 text-dark">
                        <div class="row d-flex justify-content-center">
                            <div class="col-md-12">

                                <div class="d-flex justify-content-between align-items-center mb-4">
                                    <h4 class="text-dark mb-0">Tareas</h4>                
                                </div>
                
                                <?php $__empty_1 = true; $__currentLoopData = $tareas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tarea): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                
                                    <div class="card text-dark bg-white mb-3" style="max-width: 100%;">
                                    <div class="card-header fw-bold"><?php echo e($tarea->nombre); ?></div>
                                        <div class="card-body">
                                            <h5 class="card-title"><?php echo e($tarea->fechaLimite); ?></h5>
                                            <p class="card-text"><?php echo e($tarea->descripcion); ?></p>
                                            <div class="container">
                                                <div class="row justify-content-end">
                                                    <div class="col-md-2 m-1">
                                                        <a href="#" class="btn btn-warning btn-block" @click="$dispatch('actualizar-valor', 'true')" wire:click="editartarea(<?php echo e($tarea->id); ?>)">Editar</a>
                                                    </div>
                                                    <div class="col-md-2 m-1">
                                                        <a href="#" class="btn btn-danger btn-block" wire:click="borrartarea(<?php echo e($tarea->id); ?>)">Eliminar</a>
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
                </section>                

            </div>


            

            </div>
        </div>

    <?php echo $__env->make('components.modalfootercliente', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

    <?php echo $__env->make('components.modalheaderdelete', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

    <div class="mb-3">
        <label for="" class="form-label">Zona</label>
        <input type="text" disabled class="form-control" wire:model.lazy='zonaName' aria-describedby="helpId"
            placeholder="zona">
    </div>

    <?php echo $__env->make('components.modalfooterdelete', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>


</div>

<?php /**PATH D:\xampp3\htdocs\realestate_dev\resources\views\livewire\00clientes.blade.php ENDPATH**/ ?>