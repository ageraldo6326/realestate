<div>
    <div class="container-fluid">
        <h1>Editar Venta</h1>
            <?php echo csrf_field(); ?>
        <div class="row">
            <div class="col-6">
            <div class="card card-body">
                <div class="row">
                    <h1>Id:<?php echo e($Id); ?></h1>
                    <div class="form-group">
                        <label for="id">Buscar Propiedad</label>
                        <input type="text" class="form-control bg-secondary fw-bold text-white" wire:model='criterio' name="criterio"
                            placeholder="Buscar por ID, titulo o zona">
                        
                            <?php if($criterio!=""): ?>
                            <div class="card">
                                <div class="card-body bg-primary">
                                    <table class="table mt-0 border table-hover bg-white">
                    
                                        <div class="col-12 shadow-lg mb-1 bg-white">
                    
                                            <thead class="bg-gradient-primary">
                                                <tr class="border-0 text-white font-weight-bold rounded-circle">
                                                    <th scope="col">Referencia</th>
                                                    <th scope="col" class="text-left">Foto</th>
                                                    <th scope="col">Titulo</th>
                                                    <th scope="col"></th>
                                                </tr>
                                            </thead>
                    
                                        </div>
                    
                                        <tbody>
                    
                                            <?php $__currentLoopData = $propiedades; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $propiedad): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <tr>
                                                <th scope="row" class="text-sm"><?php echo e($propiedad->referencia); ?></th>
                                                <td><img src="<?php echo e($propiedad->foto_portada); ?>" class="img-thumbnail " height="=200"
                                                        width="200" alt=""></td>
                                                <td class="text-sm"><?php echo e($propiedad->titulo); ?></td>
                                                <td>
                                                    <button class="btn btn-sm btn-info text-white fw-bold"
                                                        wire:click.prevent="buscarpropiedad('<?php echo e($propiedad->referencia); ?>')">Selecionar</button>
                                                </td>
                                            </tr>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <?php endif; ?>
                    </div>
                </div>
    
    
                <div class="row">

                    <div class="col-2">
                        <label for="id">ID Propiedad</label>
                        <input type="text" class="form-control" id="id" name="id" wire:model.lazy='id_propiedad'>
                        <?php $__errorArgs = ['id_propiedad'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="error text-danger"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>                    

                    <div class="col-3">
                    <label for="referencia">Referencia</label>
                    <input type="text" class="form-control" id="referencia" name="referencia" wire:model.lazy='refPropiedad'>
                    </div>

                    <div class="col-7">
                    <label for="referencia">Propiedad</label>
                    <input type="text" class="form-control" id="propiedad" name="propiedad" wire:model='tituloPropiedad'>
                    </div>

                </div>
    
                <div class="row">
                    <div class="col-4">
                        <label for="referencia">Tipo</label>
                        <input type="text" class="form-control" id="tipo" name="tipo" wire:model.lazy='tipoPropiedad'>
                    </div>

                    <div class="col-4">
                        <label for="referencia">Zona</label>
                        <input type="text" class="form-control" id="zona" name="zona" wire:model.lazy='zonaPropiedad'>
                    </div>

                    <div class="col-4">
                        <label for="referencia">Estado</label>
                        <input type="text" class="form-control" id="estado" name="estado" wire:model.lazy='estadoPropiedad'>
                    </div>

                </div>
    
                <div class="row">
                    <div class="col-4">
                        <label for="referencia">Fecha Creación</label>
                        <input type="date" required class="form-control" id="fechaPropiedadCreada" name="fechaPropiedadCreada"
                            wire:model.lazy='fechaPropiedadCreada'>
                    </div>
    
                    <div class="col-4">
                        <label for="referencia">Precio</label>
                        <input type="text" class="form-control monto" id="precio" name="precio" wire:model.lazy='precio'>
                    </div>
    
                    <div class="col-4">
                        <label for="referencia">Comisión</label>
                        <input type="number" class="form-control" id="comision" name="comision" wire:model.lazy='comision'>
                    </div>
                </div>
            </div>

                <div class="card card-body">
                    <div class="row">
                        <div class="form-group">
                            <label for="id">Buscar Vendedor</label>
                            <input type="text" class="form-control bg-secondary fw-bold text-white" wire:model='criterioVendedor'
                                name="criterioVendedor" placeholder="Buscar por ID, titulo o zona">
                            
                                <?php if($criterioVendedor!=""): ?>
                                <div class="card">
                                    <div class="card-body bg-primary">
                                        <table class="table mt-0 border table-hover bg-white">
                        
                                            <div class="col-12 shadow-lg mb-1 bg-white">
                        
                                                <thead class="bg-gradient-primary">
                                                    <tr class="border-0 text-white font-weight-bold rounded-circle">
                                                        <th scope="col">Id</th>
                                                        <th scope="col" class="text-left">Nombre</th>
                                                        <th scope="col" class="text-left">Telefono</th>
                                                        <th scope="col"></th>
                                                    </tr>
                                                </thead>
                        
                                            </div>
                        
                                            <tbody>
                        
                                                <?php $__currentLoopData = $vendedores; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $vendedor): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <tr>
                                                    <th scope="row" class="text-sm"><?php echo e($vendedor->id); ?></th>
                                                    <td class="text-sm"><?php echo e($vendedor->nombre); ?></td>
                                                    <td class="text-sm"><?php echo e($vendedor->telefono); ?></td>
                                                    <td>
                                                        <button class="btn btn-sm btn-info text-white fw-bold"
                                                            wire:click.prevent="buscarvendedor('<?php echo e($vendedor->id); ?>')">Selecionar</button>
                                                    </td>
                                                </tr>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <?php endif; ?>
                        </div>
                    </div>
                    
                    <div class="row"> 
                        <br>                       
                        <div class="col-2">
                            <label for="referencia">ID Vendedor</label>
                            <input type="text" class="form-control" id="id_vendedor" name="id_vendedor" wire:model.lazy='id_vendedor'>
                            <?php $__errorArgs = ['id_vendedor'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="error text-danger"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>                  
                        
                        <div class="col-10">
                            <label for="referencia">Nombre del Vendedor</label>
                            <input type="text" class="form-control" id="nombre_vendedor" name="nombre_vendedor" wire:model.lazy='nombre_vendedor'>
                        </div>  
                    </div>                
                </div>
    
    
            </div>

            <div class="col-6 card card-body">


                    <div class="row">
<div class="form-group">
                        <label for="id">Buscar Comprador</label>
                        <input type="text" class="form-control bg-secondary fw-bold text-white" wire:model='criterioComprador'
                            name="criterioVendedor" placeholder="Buscar por ID, titulo o zona">
                        
                            <?php if($criterioComprador!=""): ?>
                            <div class="card">
                                <div class="card-body bg-primary">
                                    <table class="table mt-0 border table-hover bg-white">
                    
                                        <div class="col-12 shadow-lg mb-1 bg-white">
                    
                                            <thead class="bg-gradient-primary">
                                                <tr class="border-0 text-white font-weight-bold rounded-circle">
                                                    <th scope="col">Id</th>
                                                    <th scope="col" class="text-left">Nombre Comprador</th>
                                                    <th scope="col" class="text-left">Telefono</th>
                                                    <th scope="col" class="text-left">>Creado en<</th>
                                                    <th scope="col"></th>
                                                </tr>
                                            </thead>
                    
                                        </div>
                    
                                        <tbody>
                    
                                            <?php $__currentLoopData = $compradores; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $comprador): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <tr>
                                                <th scope="row" class="text-sm"><?php echo e($comprador->id); ?></th>
                                                <td class="text-sm"><?php echo e($comprador->nombre); ?></td>
                                                <td class="text-sm"><?php echo e($comprador->telefono); ?></td>
                                                <td class="text-sm"><?php echo e($comprador->created_at->format('Y-m-d')); ?></td>
                                                
                                                <td>
                                                    <button class="btn btn-sm btn-info text-white fw-bold"
                                                        wire:click.prevent="buscarcomprador('<?php echo e($comprador->id); ?>')">Selecionar</button>
                                                </td>
                                            </tr>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <?php endif; ?>
                    </div>
                    </div>      
                        
                    <div class="row">
                        <div class="col-md-2">
                            <label for="referencia">ID Comprador</label>
                            <input type="text" class="form-control" id="id_comprador" name="id_comprador" wire:model.lazy='id_comprador'>
                            <?php $__errorArgs = ['id_comprador'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="error text-danger"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>                  
 
                        <div class="col-md-4">
                            <label for="referencia">Nombre del Comprador</label>
                            <input type="text" class="form-control" id="nombre_comprador" name="nombre_comprador" wire:model.lazy='nombre_comprador'>
                        </div>  
                        
                        <div class="col-md-3">
                            <label for="referencia">Medio</label>
                            <input type="text" class="form-control" id="medio_comprador" name="medio_comprador" wire:model.lazy='medio_comprador'>
                        </div> 

                        <div class="col-md-3">
                            <label for="referencia">>Creado en<</label>
                            <input type="date" class="form-control" id="fechacreadocomprador" name="fechacreadocomprador" wire:model.lazy='fechacreadocomprador'>
                        </div>                         
                    </div>                 
                        
                    <div class="row">

                        <div class="col-6">
                            <label for="referencia">Buscar Asesor</label>
                            <div class="mb-3">
                                <select class="form-select form-select-lg bg-primary fw-bold text-white" name="" id="" wire:model="criterioAsesor" wire:change='buscarasesor'>
                                    <option selected></option>
                                    <?php $__currentLoopData = $usuarios; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $usuario): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($usuario->email); ?>"><?php echo e($usuario->name); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>
                        </div> 
                    </div>
                    
                    <div class="row">
                        
                        <div class="col-6">
                            <label for="referencia">Email Asesor</label>
                            <input type="text" class="form-control" id="id_asesor" name="id_asesor" wire:model.lazy='id_asesor'>
                            <?php $__errorArgs = ['id_asesor'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="error text-danger"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>                  
                        
                        <div class="col-6">
                            <label for="referencia">Nombre del Asesor</label>
                            <input type="text" class="form-control" id="nombre_asesor" name="nombre_asesor" wire:model.lazy='nombre_asesor'>
                        </div>
                    
                    </div>    

                    <div class="row">
                        <div class="col-4">
                            <label for="referencia">Fecha del cierre</label>
                            <input type="date" class="form-control" id="fechaVentaCierre" name="fechaVentaCierre" wire:model.lazy='fechaVentaCierre'>
                            <?php $__errorArgs = ['fechaVentaCierre'];
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
                        <div class="col-3">
                        </div>
                        <div class="col-3">
                        </div>
                        <div class="col-md-3">
                            <button type="button" class="btn btn-success btn-block" wire:click="grabarventa(<?php echo e($Id); ?>)">Grabar</button>
                        </div>

                        
                        <div class="col-3">
                            <form method="GET" action="<?php echo e(route('registrarventa')); ?>">
                            <button class="btn btn-primary btn-block">Cancelar</button>
                            </form>
                        </div>
                        
                    </div>
 
            </div>
            </div>
        </div>
    </div>
</div>

<?php /**PATH D:\xampp3\htdocs\realestate_dev\resources\views\livewire\editar-venta.blade.php ENDPATH**/ ?>