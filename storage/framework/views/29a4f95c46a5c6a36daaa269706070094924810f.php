<div>
    <div>
        <div class="card shadow">
            <div class="card-body pb-0">
                <?php if(session('status')): ?>
                <div class="alert alert-success p-1">
                    <?php echo e(session('status')); ?>

                </div>
                <?php endif; ?> 
    
                <div class="col-12">
                    <button type="button" class="btn btn-primary " data-toggle="modal" wire:click='clear' data-target="#modalForm" >Nuevo</button>
                </div>
    
                <div class="row">
                    <div class="col-md-12 mb-3 ">
                        <div class="input-group my-3">
                            <input type="text" class="form-control" wire:model='criterio' name="criterio" placeholder="Buscar...">
                        </div> 
                    </div>            
                </div>
    
                <div class="row">
                
                    <div class="col-sm-12 col-md-3 mb-3 ">
                        <div class="form-group">
                            <label for="" class="form-label">Tipo <?php echo e($tipo); ?></label>
                            <select class="form-control" wire:model='tipo'>
                                <option value=""></option>
                                <?php $__currentLoopData = $tipos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tipo): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                                    <option value="<?php echo e($tipo->id); ?>"><?php echo e($tipo->todo_tipo); ?></option>

                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>
                    </div>
                
                    <div class="col-sm-12 col-md-3 mb-3 ">
                        <div class="form-group">
                            <label for="" class="form-label">Estatus</label>
                            <select class="form-control" 
                                wire:model='estatus'>
                                <option value="" selected></option>
                                <?php $__currentLoopData = $estatuses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $estatus): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($estatus->id); ?>"><?php echo e($estatus->todo_estatus); ?></option>                                
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>
                    </div>

                    <div class="col-sm-12 col-md-3 mb-3 ">
                    <div class="form-group">
                        <label for="" class="form-label">Fecha Limite de Inicio</label>
                        <input type="date" class="form-control" wire:model='fecha_inicio' placeholder="Fecha" />
                    </div>
                    </div>
                    
                    <div class="col-sm-12 col-md-3 mb-3 ">
                    <div class="form-group">
                        <label for="" class="form-label">Fecha Limite de Fin</label>
                        <input type="date" class="form-control" wire:model='fecha_fin' placeholder="Fecha" />
                    </div>
                    </div>                     

                    
                
                </div>
    
            </div>
        </div>
     
             
        <div class="row">
        <?php if(isset($tareas)): ?>
          <div class="card shadow col-md-12 table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th class="d-none d-md-table-cell">#</th>
                        <th>Tarea</th>
                        <th class="">Cliente</th>
                        <th class="">Tipo</th>
                        <th class="d-none d-sm-table-cell">Estatus</th>
                        <th class="d-none d-sm-table-cell">Fecha Limite</th>
                        <th class="text-center">Acción</th>
                    </tr>
                </thead>
                <tbody>            

                    <?php $__empty_1 = true; $__currentLoopData = $tareas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tarea): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>

                    <tr>
                        <td class="d-none d-md-table-cell"><?php echo e($tarea->id); ?></td>
                        <td><?php echo e($tarea->nombre); ?></td>
                        <td><?php echo e($tarea->cliente); ?></td>
                        <td><?php echo e($tarea->todo_tipo); ?></td>
                        <td class="d-none d-sm-table-cell"><?php echo e($tarea->todo_estatus); ?></td>
                        <td class="d-none d-sm-table-cell"><?php echo e($tarea->fechaLimite); ?></td>

                        <td class="text-center">
                            <div class="btn-group" role="group" aria-label="Basic example">
                                <button type="button" class="btn  btn-success" wire:click='edit(<?php echo e($tarea->id); ?>)' data-toggle="modal"
                                    data-target="#modalForm">
                                        <i class="fa fa-edit"></i>
                                    </button>
                                <button type="button" class="btn btn-danger" 
                                    wire:click="$emit('generarBorrarTareaProgamadaSweetAlert',<?php echo e($tarea->id); ?>, 'Borrar Cliente ID ', 'borrarContacto')" data-element-id="<?php echo e($tarea->id); ?>" 
                                    type="submit">
                                        <i class="fa fa-trash"></i>
                                </button>
                                <button type="button" class="btn btn-secondary" 
                                    wire:click="verTarea(<?php echo e($tarea->id); ?>)" data-toggle="modal"
                                    data-target="#verTarea" data-element-id="<?php echo e($tarea->id); ?>" 
                                    type="button">
                                        <i class="fa fa-eye"></i>
                                </button>                                
                              </div>
                        </td>

                    </tr>

                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                </tbody>
            </table>
            <?php echo e($tareas->links()); ?>

        </div>
        <?php endif; ?>
        
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

        <!-- Modal -->
        <div class="modal fade" id="verTarea" wire:ignore.self  tabindex="-1" data-backdrop="static">
            <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg-info">
                <h5 class="modal-title" id="exampleModalLabel">ID : <?php echo e($Id); ?></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                </div>
                <div class="modal-body">
                    <h5 class="text-bold text-primary">TAREA</h5>
                    <p><?php echo e($nombre); ?></p>
                    <h5 class="text-bold text-primary">DESCRIPCION</h5>
                    <p><?php echo e($descripcion); ?></p>
                    <h5 class="text-bold text-primary">TIPO</h5>
                    <p><?php echo e($todo_tipo); ?></p>
                    <h5 class="text-bold text-primary">FECHA LIMITE</h5>
                    <p><?php echo e($fechaLimite); ?></p>
                    <h5 class="text-bold text-primary">CLIENTE</h5>
                    <p><?php echo e($cliente_nombre); ?></p>
                    <h5 class="text-bold text-primary">ESTATUS</h5>
                    <p><?php echo e($todo_estatus); ?></p>


                </div>
                <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal" wire:click="clear">Close</button>
                </div>
            </div>
            </div>
        </div>

</div>
<?php /**PATH D:\xampp3\htdocs\realestate_dev\resources\views\livewire\buscar-tarea-programada.blade.php ENDPATH**/ ?>