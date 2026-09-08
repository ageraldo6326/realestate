

<?php $__env->startSection('content'); ?>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <h1>CLIENTE</h1>
            <?php if($errors->any()): ?>
            <div class="alert alert-danger">
                <ul>
                    <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <li><?php echo e($error); ?></li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </ul>
            </div>
            <?php endif; ?>
            <form action="<?php echo e(route("clientes.update",$cliente->id)); ?>" method="post" enctype="multipart/form-data">
                <?php echo method_field("put"); ?>
                <?php echo csrf_field(); ?>
                <div class="form-group">

                    <div class="form-group">
                        <label for="nombre">Nombre</label>
                        <input type="text" required class="form-control" id="nombre" name="nombre" disabled placeholder="nombre"
                            value="<?php echo e($cliente->nombre); ?>">
                    </div>

                    <div class="form-group">
                        <label for="titulo">Titulo</label>
                        <select class="form-control" name="titulo" id="titulo" disabled>
                            <option value="">Titulo</option>
                            <option <?php if($cliente->titulo=="Señor"): ?> selected <?php endif; ?> value="Señor">Señor</option>
                            <option <?php if($cliente->titulo=="Señora"): ?> selected <?php endif; ?> value="Señora">Señora</option>
                            <option <?php if($cliente->titulo=="Señorita"): ?> selected <?php endif; ?> value="Señorita">Señorita
                            </option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="tipo_contacto">Tipo Contacto</label>
                        <select class="form-control" name="tipo_contacto" id="tipo_contacto" disabled>
                            <option value="">Tipo</option>
                            <option <?php if($cliente->tipo_contacto=="PersonaFisica"): ?> selected <?php endif; ?>
                                value="PersonaFisica">Persona Fisica</option>
                            <option <?php if($cliente->tipo_contacto=="Empresa"): ?> selected <?php endif; ?> value="Empresa">Empresa
                            </option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="telefono">Telefono</label>
                        <input type="number" required class="form-control" id="telefono" disabled name="telefono"
                            placeholder="telefono" value="<?php echo e($cliente->telefono); ?>">
                    </div>

                    <div class="form-group">
                        <label for="correo">Correo</label>
                        <input type="email" class="form-control" id="email" name="email" disabled placeholder="correo"
                            value="<?php echo e($cliente->email); ?>">
                    </div>

                    <div class="form-group">
                        <label for="" class="form-label">Comentario</label>
                        <textarea disabled class="form-control" name="comentario" id="comentario"
                            rows="3"><?php echo e($cliente->comentario); ?></textarea>
                    </div>

                    <div class="form-group col-4">
                        <label for="contact_at">Fecha de Contacto</label>
                        <input type="date" class="form-control" required id="contact_at" disabled name="contact_at"
                            value="<?php echo e(substr($cliente->contact_at,0,10)); ?>">
                    </div>

                    <div class="form-group">
                        <input disabled clase="form-control" type="checkbox" <?php if($cliente->activo==1): ?> checked <?php endif; ?>
                        name="activo" id="activo">
                        <label for="activo">Activo?</label>
                    </div>

                    <div class="form-group">
                        <label for="tipo_contacto2">Tipo Contacto</label>
                        <select class="form-control" name="tipo_contacto2" id="tipo_contacto2" disabled>
                            <option value="">Tipo</option>
                            <option <?php if($cliente->tipo_contacto2=="Vendedor"): ?> selected <?php endif; ?> value="Vendedor">Vendedor
                            </option>
                            <option <?php if($cliente->tipo_contacto2=="Comprador"): ?> selected <?php endif; ?>
                                value="Comprador">Comprador</option>
                            <option <?php if($cliente->tipo_contacto2=="Inquilino"): ?> selected <?php endif; ?>
                                value="Inquilino">Inquilino</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="medio">Por donde supo de nosotros</label>
                        <select class="form-control" name="medio" id="medio" disabled>
                            <option value="">Tipo</option>
                            <option <?php if($cliente->medio=="Facebook"): ?> selected <?php endif; ?> value="Facebook">Facebook</option>
                            <option <?php if($cliente->medio=="Instagram"): ?> selected <?php endif; ?> value="Instagram">Instagram
                            </option>
                            <option <?php if($cliente->medio=="Letrero"): ?> selected <?php endif; ?> value="Letrero">Letrero</option>
                            <option <?php if($cliente->medio=="Radio"): ?> selected <?php endif; ?> value="Radio">Radio</option>
                            <option <?php if($cliente->medio=="TV"): ?> selected <?php endif; ?> value="TV">TV</option>
                            <option <?php if($cliente->medio=="Referido"): ?> selected <?php endif; ?> value="Referido">Referido</option>
                            <option <?php if($cliente->medio=="Otro"): ?> selected <?php endif; ?> value="Otro">Otro</option>
                        </select>
                    </div>


                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <h3 class="text-bold text-primary">NEGOCIO</h3>
                                

                                <div class="col-3">
                                    <div class="form-group">
                                        <label for="precio">Precio Min</label>
                                        <input type="number" class="form-control" disabled id="precio_mini" name="precio_mini"
                                            placeholder="Precio" value="<?php echo e($cliente->precio_mini); ?>">
                                    </div>
                                </div>

                                <div class="col-3">
                                    <div class="form-group">
                                        <label for="precio">Precio Max</label>
                                        <input type="number" class="form-control" disabled id="precio" name="precio_max"
                                            placeholder="Precio" value="<?php echo e($cliente->precio_max); ?>">
                                    </div>
                                </div>

                            </div>
                            <div class="row">

                                <div class="col-3">
                                    <div class="form-group">
                                        <label for="habitaciones">Hab</label>
                                        <select class="form-control" name="habitaciones" disabled id="habitaciones">
                                            <option selected>Habitaciones</option>
                                            <option <?php if($cliente->habitaciones==1): ?> selected <?php endif; ?> value="1">1</option>
                                            <option <?php if($cliente->habitaciones==2): ?> selected <?php endif; ?> value="2">2</option>
                                            <option <?php if($cliente->habitaciones==3): ?> selected <?php endif; ?> value="3">3</option>
                                            <option <?php if($cliente->habitaciones==4): ?> selected <?php endif; ?> value="4">4</option>
                                            <option <?php if($cliente->habitaciones==5): ?> selected <?php endif; ?> value="5">5</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-3">
                                    <div class="form-group">
                                        <label for="habitaciones">Parqueos</label>
                                        <select class="form-control" name="parqueos" disabled id="parqueos">
                                            <option selected>Parqueos</option>
                                            <option <?php if($cliente->parqueos==1): ?> selected <?php endif; ?> value="1">1</option>
                                            <option <?php if($cliente->parqueos==2): ?> selected <?php endif; ?> value="2">2</option>
                                            <option <?php if($cliente->parqueos==3): ?> selected <?php endif; ?> value="3">3</option>
                                            <option <?php if($cliente->parqueos==4): ?> selected <?php endif; ?> value="4">4</option>
                                            <option <?php if($cliente->parqueos==5): ?> selected <?php endif; ?> value="5">5</option>
                                        </select>
                                    </div>
                                </div>

                                

                                

                                
                            </div>
                        </div>
                    </div>


                    <div class="form-group">
                        <label for="" class="form-label">Testimonio</label>
                        <textarea class="form-control" name="testimonio" id="testimonio" rows="3" disabled></textarea>
                    </div>


                    

                </div>
            </form>
        </div>
    </div>
</div>


<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layoutadmin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xampp3\htdocs\realestate_dev\resources\views\admin\clientes\show.blade.php ENDPATH**/ ?>