<div>
    <?php if(session('status')): ?>
    <div class="alert alert-success p-1">
        <?php echo e(session('status')); ?>

    </div>
    <?php endif; ?>  

    <div class="col-md-12">
        <button type="button" class="btn btn-primary my-1 p-o"
            wire:click='clear' data-toggle="modal"
            data-target="#modalForm">Nueva</button>
    </div>    
    
    <div class="card shadow p-2">
        <div class="m-0">
            <hr class="bg-primary m-0 h-100">
        </div> 
        <input type="text" class="form-control mt-1 shadow " wire:model='criterio' placeholder="Escribir tarea" >     
        <div class="row">
    
            <div class="col-12 ">
        
                <table class="table table-striped m-1">
        
                    <div class="col-12 mb-1">
        
                        <thead>
                            <tr">
                                <th>#</th>
                                <th>Tarea</th>
                                <th class="text-center">Color</th>
                                <th>Creado en</th>
                                <th class="text-center">Acción</th>
                            </tr>
                        </thead>
        
                    </div>
        
                    <tbody class="m-2">
                        <?php $__currentLoopData = $tareas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tarea): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <th scope="row"><?php echo e($tarea->id); ?></th>
                            <td><?php echo e($tarea->todo_tipo); ?></td>
                            <td class="w-25"><span class="card shadow w-100 text-center text-white"  style="background: <?php echo e($tarea->color); ?>"><?php echo e($tarea->color); ?></span></td>
                            <td><?php echo e($tarea->created_at); ?></td>

                            <td class="text-center">
                                <div class="btn-group" role="group" aria-label="Basic example">
                                    <button type="button" class="btn btn-secondary btn-success" wire:click='edit(<?php echo e($tarea->id); ?>)' data-toggle="modal"
                                        data-target="#modalForm">
                                            <i class="fa fa-edit"></i>
                                        </button>
                                    <button type="button" class="btn btn-secondary btn-danger" 
                                        wire:click="$emit('generarBorrarTareaSweetAlert',<?php echo e($tarea->id); ?>)" data-element-id="<?php echo e($tarea->id); ?>" 
                                        type="submit">
                                            <i class="fa fa-trash"></i>
                                    </button>
                                  </div>
                            </td>

                        </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>
                <?php echo e($tareas->links()); ?>

            </div>

            <?php echo $__env->make('components.modalheader', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            <div class="container">
                <div class="row">
            
                    <div class="col-12">
            
                        <?php if($errors->any()): ?>
                        <div class="alert alert-danger">
                            <ul>
                                <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <li><?php echo e($error); ?></li>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </ul>
                        </div>
                        <?php endif; ?>
            
                        <form>
            
                            <div class="form-group">
                                <label for="minititulo">Tarea</label>
                                <input type="text" class="form-control" wire:model.lazy='tarea' placeholder="Tarea" required maxlength="50">
                            </div>

                            <div class="form-group">
                                <label for="minititulo">Color</label>
                                <input type="color" class="form-control" wire:model.lazy='color' placeholder="Color" required maxlength="50">
                            </div>                            
                        
                        </form>
                    </div>
            
                </div>
            </div>            
            <?php echo $__env->make('components.modalfooter', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>             
        </div>               
    </div>
    
</div>
<?php /**PATH D:\xampp3\htdocs\realestate_dev\resources\views\livewire\buscar-tarea.blade.php ENDPATH**/ ?>