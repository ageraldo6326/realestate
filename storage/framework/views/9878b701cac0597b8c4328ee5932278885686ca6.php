<div>
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <?php if(session('status')): ?>
                <div class="alert alert-success">
                    <?php echo e(session('status')); ?>

                </div>
                <?php endif; ?>
                <h1>Tareas</h1>
                <div class="m-3 col-md-12 text-end">
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modalForm">Nuevo</button>
                </div>
                <div class="input-group my-3">
                    <input type="text" class="form-control" wire:model='criterio' name="criterio" placeholder="Buscar...">
                </div>

            <div class="row ">
            
                <div class="col-md-3">
                    <div class="mb-3">
                        <label for="" class="form-label">Estatus</label>
                        <select class="form-select form-select-lg" name="estatus" id="estatus"
                            wire:model='estatus'>
                            <option value=""></option>
                            <?php $__currentLoopData = $estatuses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $estatus): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($estatus->id); ?>"><?php echo e($estatus->todo_estatus); ?></option> 
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
                </div>
            
                <div class="col-md-3 mb-4 m-md-0">
                    <label for="" class="form-label">Tipo</label>
                    <select class="form-select form-select-lg" name="tipo" id="tipo"
                        wire:model='tipo'>
                        <option selected></option>
                            <?php $__currentLoopData = $tipos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tipo): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($tipo->id); ?>"><?php echo e($tipo->todo_tipo); ?></option> 
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>                        
                    </select>
                </div>
            
            </div>    

                <table class="table table-striped mt-md-1">
                    <thead>
                        <tr>
                            <th scope="col" class="d-none d-md-table-cell">N</th>
                            <th scope="col">Tarea</th>
                            <th scope="col">Cliente</th>
                            <th scope="col" class="d-none d-md-table-cell">Tipo</th>
                            <th scope="col">Estatus</th>
                            <th scope="col">Fec Limite</th>
                            <th scope="col" class="text-center">Acción</th>
                            <th></th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__currentLoopData = $todos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $todo): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td scope="row" class="d-none d-md-table-cell"><?php echo e($todo->id); ?></td>
                            <td><?php echo e($todo->nombre); ?></td>
                            <td><?php if($todo->cliente==''): ?> Empresa <?php else: ?> <?php echo e($todo->cliente); ?> <?php endif; ?> </td>
                            <td class="d-none d-md-table-cell"><?php echo e($todo->todo_tipo); ?></td>
                            <td><?php echo e($todo->todo_estatus); ?></td>
                            <td><?php echo e($todo->fechaLimite); ?></td>
                            <td>
                                <div class="row">
                                        <div class="col-md-6">
                                            <button type="button" class="btn btn-primary btn-sm btn-block m-1 rounded" wire:click='edit(<?php echo e($todo->id); ?>)' data-toggle="modal" data-target="#modalForm">Editar</button>
                                        </div>
                                        <div class="col-md-6">
                                            <button type="button" class="btn btn-danger btn-sm btn-block m-1 rounded" wire:click='edit(<?php echo e($todo->id); ?>)'  data-toggle="modal" data-target="#modalFormDelete">Eliminar</button>
                                        </div>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    
                    </tbody>
                </table>
                <?php echo e($todos->links('pagination::bootstrap-4')); ?>

            </div>
        </div>
    </div>

    <?php echo $__env->make('components.modalheader', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    
    <div class="mb-3">


        <div class="form-group">
             <div>
                ID : <?php echo e($Id); ?>

            </div>           
            <div class="form-group">
                <label for="nombre">Tarea</label>
                <input type="text" class="form-control" wire:model.lazy="nombre" placeholder="tarea" required>
                <?php $__errorArgs = ['nombre'];
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
                <textarea class="form-control" wire:model.lazy="descripcion" required rows="3"></textarea>
                <?php $__errorArgs = ['descripcion'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="error text-danger"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>
        
            <div class="form-group">
                <label for="Clientes">Tipo de Tarea</label>
                <select class="form-control form-control-sm" wire:model.lazy="todo_tipo">
                    <option selected>Tipo</option>
                    <?php $__currentLoopData = $tipos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tipo): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($tipo->id); ?>"><?php echo e($tipo->todo_tipo); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>        
                </select>
                <?php $__errorArgs = ['todo_tipo'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="error text-danger"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>
        
            <div class="form-group">
                <label for="fecha">Fecha</label>
                <input type="datetime-local" class="form-control"  placeholder="Fecha Limite" wire:model.lazy="fechaLimite" required >
                <?php $__errorArgs = ['fechaLimite'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="error text-danger"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>
        
            <div class="form-group">
                <label for="Clientes">Cliente</label>
                <select class="form-control form-control-sm" wire:model.lazy="cliente_id">
                    <option selected>Cliente</option>
                    <?php $__currentLoopData = $clientes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cliente): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($cliente->id); ?>"><?php echo e($cliente->nombre); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>        
                </select>
                <?php $__errorArgs = ['cliente_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="error text-danger"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>
        
        
            <div class="form-group">
                <label for="Clientes">Estatus de la Tarea</label>
                <select class="form-control form-control-sm" wire:model.lazy="todo_estatus">
                    <option selected>Estatus</option>
                    <?php $__currentLoopData = $estatuses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $estatus): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($estatus->id); ?>"><?php echo e($estatus->todo_estatus); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>        
                </select>
                <?php $__errorArgs = ['todo_estatus'];
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
    
    <?php echo $__env->make('components.modalfooter', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    
    <?php echo $__env->make('components.modalheaderdelete', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    
    <div class="mb-3">
        <label for="" class="form-label">Tarea</label>
        <input type="text" disabled class="form-control" wire:model.lazy='nombre'>
    </div>
    
    <?php echo $__env->make('components.modalfooterdelete', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>    
</div>
<?php /**PATH D:\xampp3\htdocs\realestate_dev\resources\views\livewire\tarea-componente.blade.php ENDPATH**/ ?>