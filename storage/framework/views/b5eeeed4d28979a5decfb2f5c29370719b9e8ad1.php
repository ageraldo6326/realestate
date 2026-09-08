<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">



    <!-- Place favicon.png in the root directory -->
    <link rel="shortcut icon" href="<?php echo e($inmobiliaria->publicFaviconUrl()); ?>" type="image/x-icon" />
    <!-- Font Icons css -->
    <link rel="stylesheet" href="/css/font-icons.css">
    <!-- plugins css -->
    <link rel="stylesheet" href="/css/plugins.css">
    <!-- Main Stylesheet -->
    
    <!-- Responsive css -->
    <link rel="stylesheet" href="/css/responsive.css">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <style>
        /* Estilos adicionales para centrar el div */
        .container-centered {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            /* Asegura que el contenedor ocupe el 100% de la altura de la pantalla */
        }
    </style>
    <title><?php echo e($propiedad->referencia); ?></title>
</head>
<body class="bg-secondary">

<div class="container bg-white">
    <div class="row">

        <div class="col-md-12">

            <?php if($errors->any()): ?>
            <div class="alert alert-danger">
                <ul>
                    <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <li><?php echo e($error); ?></li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </ul>
            </div>
            <?php endif; ?>


                <div class="row mt-3">
                        <div class="form-group">
                            <h1><?php echo e($propiedad->titulo); ?></h1>
                            <h4><?php echo e($propiedad->referencia); ?></h4>
                        </div>
                    
                        <div id="carouselExample2<?php echo e($propiedad->id); ?>" class="carousel slide" data-ride="carousel" style="max-width: 200rem">
                            <div class="carousel-inner">
                                <?php if($propiedad->foto_portada!=""): ?>
                                <div class="carousel-item active">
                                    <img src="<?php echo e(asset('assets/'.$propiedad->foto_portada)); ?>" class="d-block w-100 rounded-2" alt="...">
                                </div>
                                <?php endif; ?>
                                <?php if($propiedad->foto1!=""): ?>
                                <div class="carousel-item">
                                    <img src="<?php echo e(asset('assets/'.$propiedad->foto1)); ?>" class="d-block w-100 rounded-2" alt="...">
                                </div>
                                <?php endif; ?>
                                <?php if($propiedad->foto2!=""): ?>
                                <div class="carousel-item">
                                    <img src="<?php echo e(asset('assets/'.$propiedad->foto2)); ?>" class="d-block w-100 rounded-2" alt="...">
                                </div>
                                <?php endif; ?>
                                <?php if($propiedad->foto3!=""): ?>
                                <div class="carousel-item">
                                    <img src="<?php echo e(asset('assets/'.$propiedad->foto3)); ?>" class="d-block w-100 rounded-2" alt="...">
                                </div>
                                <?php endif; ?>
                                <?php if($propiedad->foto4!=""): ?>
                                <div class="carousel-item">
                                    <img src="<?php echo e(asset('assets/'.$propiedad->foto4)); ?>" class="d-block w-100 rounded-2" alt="...">
                                </div>
                                <?php endif; ?> 
                                <?php if($propiedad->foto5!=""): ?>
                                <div class="carousel-item">
                                    <img src="<?php echo e(asset('assets/'.$propiedad->foto5)); ?>" class="d-block w-100 rounded-2" alt="...">
                                </div>
                                <?php endif; ?>   
                                <?php if($propiedad->foto6!=""): ?>
                                <div class="carousel-item">
                                    <img src="<?php echo e(asset('assets/'.$propiedad->foto6)); ?>" class="d-block w-100 rounded-2" alt="...">
                                </div>
                                <?php endif; ?>  
                                <?php if($propiedad->foto7!=""): ?>
                                <div class="carousel-item">
                                    <img src="<?php echo e(asset('assets/'.$propiedad->foto7)); ?>" class="d-block w-100 rounded-2" alt="...">
                                </div>
                                <?php endif; ?> 
                                <?php if($propiedad->foto8!=""): ?>
                                <div class="carousel-item">
                                    <img src="<?php echo e(asset('assets/'.$propiedad->foto8)); ?>" class="d-block w-100 rounded-2" alt="...">
                                </div>
                                <?php endif; ?>                                                                                                                 
                            </div>
                            <button class="carousel-control-prev" type="button" data-target="#carouselExample2<?php echo e($propiedad->id); ?>" data-slide="prev">
                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">Previous</span>
                            </button>
                            <button class="carousel-control-next" type="button" data-target="#carouselExample2<?php echo e($propiedad->id); ?>" data-slide="next">
                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">Next</span>
                            </button>
                        


                        </div>     
                </div>

                <div class="mt-3">
                    <h2>Descripción</h2>
                    <p class="text-justify"><?php echo $propiedad->descripcion; ?></p>
                </div>


                



                <div class="row">
                    <div class="form-group">
                        <h2>Caracteristicas</h2>
                    </div>                              

                    <div class="col-md-4">
              
                        <div class="form-group">
                            <label for="Zona">Zona</label>
                            <select class="form-control" name="zona_id" id="zona_id" disabled>
                                <option value="" selected>Zona</option>
                                <?php $__currentLoopData = $zonas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $zona): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option <?php if($propiedad->zona_id==$zona->id): ?> selected <?php endif; ?> value="<?php echo e($zona->id); ?>"><?php echo e($zona->zona); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                            </select>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="provincia">Provincia</label>
                            <select class="form-control" name="provincia" id="provincia" disabled>
                                <option value="" selected>Provincia</option>
                                <?php $__currentLoopData = $provincias; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $provincia): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option <?php if($propiedad->provincia==$provincia->id): ?> selected <?php endif; ?> value="<?php echo e($provincia->id); ?>"> <?php echo e($provincia->provincia); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-1">
                        <div class="form-group">
                            <label for="Moneda">Moneda</label>
                            <select class="form-control" name="tipomoneda" id="tipomoneda" disabled>
                                <option <?php if($propiedad->Moneda=='RD$'): ?> selected <?php endif; ?> value="RD$">RD$</option>
                                <option <?php if($propiedad->Moneda=='US$'): ?> selected <?php endif; ?> value="US$">US$</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="">
                            <label for="precio">Precio</label>
                            <input type="text" class="form-control" id="precio" name="precio" disabled
                                placeholder="Precio" value="<?php echo e(number_format($propiedad->precio)); ?>">
                        </div>
                    </div>
                  

                </div>
                <div class="row">

                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="tipo">Tipo</label>
                            <select class="form-control" name="tipo" id="tipo" disabled>
                                <option value="" selected>Tipo</option>
                                <?php $__currentLoopData = $tipos_propiedades; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tipos_propiedad): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option <?php if($propiedad->tipo==$tipos_propiedad->id): ?> selected <?php endif; ?> value="<?php echo e($tipos_propiedad->id); ?>"><?php echo e($tipos_propiedad->tipo); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-1">
                        <div class="form-group">
                            <label for="habitaciones">Hab</label>
                            <select class="form-control" name="habitaciones" id="habitaciones" disabled>
                                <option value="" selected>Habitaciones</option>
                                <option <?php if($propiedad->habitaciones==1): ?> selected <?php endif; ?> value="1">1</option>
                                <option <?php if($propiedad->habitaciones==2): ?> selected <?php endif; ?> value="2">2</option>
                                <option <?php if($propiedad->habitaciones==3): ?> selected <?php endif; ?> value="3">3</option>
                                <option <?php if($propiedad->habitaciones==4): ?> selected <?php endif; ?> value="4">4</option>
                                <option <?php if($propiedad->habitaciones==5): ?> selected <?php endif; ?> value="5">5</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-1">
                        <div class="form-group">
                            <label for="habitaciones">Baños</label>
                            <select class="form-control" name="banos" id="banos" disabled>
                                <option value="" selected>Baños</option>
                                <option <?php if($propiedad->banos==1): ?> selected <?php endif; ?> value="1">1</option>
                                <option <?php if($propiedad->banos==1.5): ?> selected <?php endif; ?> value="1.5">1.5</option>
                                <option <?php if($propiedad->banos==2): ?> selected <?php endif; ?> value="2">2</option>
                                <option <?php if($propiedad->banos==2.5): ?> selected <?php endif; ?> value="2.5">2.5</option>
                                <option <?php if($propiedad->banos==3): ?> selected <?php endif; ?> value="3">3</option>
                                <option <?php if($propiedad->banos==3.5): ?> selected <?php endif; ?> value="3.5">3.5</option>
                                <option <?php if($propiedad->banos==4): ?> selected <?php endif; ?> value="4">4</option>
                                <option <?php if($propiedad->banos==4.5): ?> selected <?php endif; ?> value="4.5">4.5</option>
                                <option <?php if($propiedad->banos==5): ?> selected <?php endif; ?> value="5">5</option>
                                <option <?php if($propiedad->banos==5.5): ?> selected <?php endif; ?> value="5.5">5.5</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-1">
                        <div class="form-group">
                            <label for="habitaciones">Parqueos</label>
                            <select class="form-control" name="parqueos" id="parqueos" disabled>
                                <option value="" selected>Parqueos</option>
                                <option <?php if($propiedad->parqueos==1): ?> selected <?php endif; ?> value="1">1</option>
                                <option <?php if($propiedad->parqueos==2): ?> selected <?php endif; ?> value="2">2</option>
                                <option <?php if($propiedad->parqueos==3): ?> selected <?php endif; ?> value="3">3</option>
                                <option <?php if($propiedad->parqueos==4): ?> selected <?php endif; ?> value="4">4</option>
                                <option <?php if($propiedad->parqueos==5): ?> selected <?php endif; ?> value="5">5</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="disponiblepara">Disponible para</label>
                            <select class="form-control" name="disponible_para" id="disponible_para" disabled>
                                <option value="" selected>Disponible para</option>
                                <?php $__empty_1 = true; $__currentLoopData = $disponibles_para; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $disponible_para): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                <option <?php if($propiedad->disponible_para==$disponible_para->id): ?> selected <?php endif; ?>
                                    value="<?php echo e($disponible_para->id); ?>"><?php echo e($disponible_para->disponible_para); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>

                                <?php endif; ?>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="estadopropiedad">Estado de la Propiedad</label>
                            <select class="form-control" name="estadopropiedad" id="estadopropiedad" disabled>
                                <option value="" selected>Estado Propiedad</option>
                                <?php $__empty_1 = true; $__currentLoopData = $estados_propiedad; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $estado_propiedad): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                <option <?php if($propiedad->estado_id==$estado_propiedad->id): ?> selected <?php endif; ?> value="<?php echo e($estado_propiedad->id); ?>"><?php echo e($estado_propiedad->estado); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>

                                <?php endif; ?>
                            </select>
                        </div>
                    </div>

                </div>


                <div class="row">

                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="metraje">Metraje</label>
                            <input type="text" class="form-control" id="metraje" name="metraje" placeholder="Metraje"
                                value="<?php echo e($propiedad->metraje); ?>" readonly>
                        </div>
                    </div>

                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="metrajedeconstruccion">Metraje Construcción</label>
                            <input type="text" class="form-control" id="metraje_construccion"
                                name="metraje_construccion" placeholder="Metraje de Construcción"
                                value="<?php echo e($propiedad->metraje_construccion); ?>" readonly>
                        </div>
                    </div>



                </div>

                <div class="form-group">
                    <h2>Amenidades</h2>
                </div>                  

                <div class="card mb-5">
                    
                    <div class="card-body">
                       
                        

                        <div class="row">


                            <div class="col-md-2">
                                <div class="form-check">
                                    <input type="checkbox" disabled class="form-check-input" <?php if($propiedad->lobby==1): ?> checked
                                    <?php endif; ?> id="lobby" name="lobby">
                                    <label for="exampleCheck1">Lobby?</label>
                                </div>
                            </div>

                            <div class="col-md-2">
                                <div class="form-check">
                                    <input type="checkbox" disabled class="form-check-input" <?php if($propiedad->plantaelectrica==1): ?>
                                    checked <?php endif; ?> id="plantaelectrica" name="plantaelectrica">
                                    <label for="exampleCheck1">Planta electrica?</label>
                                </div>
                            </div>

                            <div class="col-md-2">
                                <div class="form-check">
                                    <input type="checkbox" disabled class="form-check-input" <?php if($propiedad->camaravigilancia==1): ?> checked <?php endif; ?> id="camaravigilancia"
                                    name="camaravigilancia">
                                    <label for="exampleCheck1">Camara vigilancia?</label>
                                </div>
                            </div>

                            <div class="col-md-2">
                                <div class="form-check">
                                    <input type="checkbox" disabled class="form-check-input" <?php if($propiedad->escaleraemergencia==1): ?> checked <?php endif; ?> id="escaleraemergencia"
                                    name="escaleraemergencia">
                                    <label for="exampleCheck1">Escalera emergencia?</label>
                                </div>
                            </div>

                            <div class="col-md-2">
                                <div class="form-check">
                                    <input type="checkbox" disabled class="form-check-input" <?php if($propiedad->maderapreciosa==1): ?>
                                    checked <?php endif; ?> id="maderapreciosa" name="maderapreciosa">
                                    <label for="exampleCheck1">Madera preciosa?</label>
                                </div>
                            </div>

                            <div class="col-md-2">
                                <div class="form-check">
                                    <input type="checkbox" disabled class="form-check-input" <?php if($propiedad->balcon==1): ?> checked
                                    <?php endif; ?> id="balcon" name="balcon">
                                    <label for="exampleCheck1">Balcon?</label>
                                </div>
                            </div>

                        </div>

                        



                        

                        <div class="row">

                            <div class="col-md-2">
                                <div class="form-check">
                                    <input type="checkbox" disabled class="form-check-input" <?php if($propiedad->walkincloset==1): ?>
                                    checked <?php endif; ?> id="walkincloset" name="walkincloset">
                                    <label for="exampleCheck1">Walk in closet?</label>
                                </div>
                            </div>

                            <div class="col-md-2">
                                <div class="form-check">
                                    <input type="checkbox" disabled class="form-check-input" <?php if($propiedad->jacuzzi==1): ?> checked
                                    <?php endif; ?> id="jacuzzi" name="jacuzzi">
                                    <label for="exampleCheck1">Jacuzzi?</label>
                                </div>
                            </div>

                            <div class="col-md-2">
                                <div class="form-check">
                                    <input type="checkbox" disabled class="form-check-input" <?php if($propiedad->areainfantil==1): ?>
                                    checked <?php endif; ?> id="areainfantil" name="areainfantil">
                                    <label for="exampleCheck1">Area infantil?</label>
                                </div>
                            </div>

                            <div class="col-md-2">
                                <div class="form-check">
                                    <input type="checkbox" disabled class="form-check-input" <?php if($propiedad->banovisitas==1): ?>
                                    checked <?php endif; ?> id="banovisitas" name="banovisitas">
                                    <label for="exampleCheck1">Baño visitas?</label>
                                </div>
                            </div>

                            <div class="col-md-2">
                                <div class="form-check">
                                    <input type="checkbox" disabled class="form-check-input" <?php if($propiedad->cisterna==1): ?>
                                    checked <?php endif; ?> id="cisterna" name="cisterna">
                                    <label for="exampleCheck1">Cisterna?</label>
                                </div>
                            </div>

                            <div class="col-md-2">
                                <div class="form-check">
                                    <input type="checkbox" disabled class="form-check-input" <?php if($propiedad->inversorareacomun==1): ?> checked <?php endif; ?> id="inversorareacomun"
                                    name="inversorareacomun">
                                    <label for="exampleCheck1">Inversor área común?</label>
                                </div>
                            </div>

                        </div>
                        


                        

                        <div class="row">

                            <div class="col-md-2">
                                <div class="form-check">
                                    <input type="checkbox" disabled class="form-check-input" <?php if($propiedad->gascomun==1): ?>
                                    checked <?php endif; ?> id="gascomun" name="gascomun">
                                    <label for="exampleCheck1">Gas común?</label>
                                </div>
                            </div>

                            <div class="col-md-2">
                                <div class="form-check">
                                    <input type="checkbox" disabled class="form-check-input" <?php if($propiedad->gazebo==1): ?> checked
                                    <?php endif; ?> id="gazebo" name="gazebo">
                                    <label for="exampleCheck1">Gazebo?</label>
                                </div>
                            </div>

                            <div class="col-md-2">
                                <div class="form-check">
                                    <input type="checkbox" disabled class="form-check-input" <?php if($propiedad->pozo==1): ?> checked
                                    <?php endif; ?> id="pozo" name="pozo">
                                    <label for="exampleCheck1">Pozo?</label>
                                </div>
                            </div>

                            <div class="col-md-2">
                                <div class="form-check">
                                    <input type="checkbox" disabled class="form-check-input" <?php if($propiedad->piscina==1): ?> checked
                                    <?php endif; ?> id="piscina" name="piscina">
                                    <label for="exampleCheck1">Piscina?</label>
                                </div>
                            </div>

                            <div class="col-md-2">
                                <div class="form-check">
                                    <input type="checkbox" disabled class="form-check-input" <?php if($propiedad->familyroom==1): ?>
                                    checked <?php endif; ?> id="familyroom" name="familyroom">
                                    <label for="exampleCheck1">Family room?</label>
                                </div>
                            </div>

                            <div class="col-md-2">
                                <div class="form-check">
                                    <input type="checkbox" disabled class="form-check-input" <?php if($propiedad->cuartodeservicio==1): ?> checked <?php endif; ?> id="cuartodeservicio"
                                    name="cuartodeservicio">
                                    <label for="exampleCheck1">Cuarto de servicio?</label>
                                </div>
                            </div>

                        </div>
                        

                        

                        <div class="row">

                            <div class="col-md-2">
                                <div class="form-check">
                                    <input type="checkbox" disabled class="form-check-input" <?php if($propiedad->patio==1): ?> checked
                                    <?php endif; ?> id="patio" name="patio">
                                    <label for="exampleCheck1">Patio?</label>
                                </div>
                            </div>

                            <div class="col-md-2">
                                <div class="form-check">
                                    <input type="checkbox" disabled class="form-check-input" <?php if($propiedad->portonelectrico==1): ?>
                                    checked <?php endif; ?> id="portonelectrico" name="portonelectrico">
                                    <label for="exampleCheck1">Portón elèctrico?</label>
                                </div>
                            </div>

                            <div class="col-md-2">
                                <div class="form-check">
                                    <input type="checkbox" disabled class="form-check-input" <?php if($propiedad->seguridad24horas==1): ?> checked <?php endif; ?> id="seguridad24horas"
                                    name="seguridad24horas">
                                    <label for="exampleCheck1">Seguridad 24 horas?</label>
                                </div>
                            </div>

                            <div class="col-md-2">
                                <div class="form-check">
                                    <input type="checkbox" disabled class="form-check-input" <?php if($propiedad->ascensor==1): ?>
                                    checked <?php endif; ?> id="ascensor" name="ascensor">
                                    <label for="exampleCheck1">Ascensor?</label>
                                </div>
                            </div>

                            <div class="col-md-2">
                                <div class="form-check">
                                    <input type="checkbox" disabled class="form-check-input" <?php if($propiedad->parqueostechados==1): ?> checked <?php endif; ?> id="parqueostechados"
                                    name="parqueostechados">
                                    <label for="exampleCheck1">Parqueos techados?</label>
                                </div>
                            </div>

                            <div class="col-md-2">
                                <div class="form-check">
                                    <input type="checkbox" disabled class="form-check-input" <?php if($propiedad->preinstalacionairetinacoinversor==1): ?> checked <?php endif; ?>
                                    id="preinstalacionairetinacoinversor" name="preinstalacionairetinacoinversor">
                                    <label for="exampleCheck1">Pre-instalacion aire/tinaco/inversor?</label>
                                </div>
                            </div>

                        </div>
                        


                        

                        <div class="row">

                            <div class="col-md-2">
                                <div class="form-check">
                                    <input type="checkbox" disabled class="form-check-input" <?php if($propiedad->terraza==1): ?> checked
                                    <?php endif; ?> id="terraza" name="terraza">
                                    <label for="exampleCheck1">Terraza?</label>
                                </div>
                            </div>

                            <div class="col-md-2">
                                <div class="form-check">
                                    <input type="checkbox" disabled class="form-check-input" <?php if($propiedad->estudio==1): ?> checked
                                    <?php endif; ?> id="estudio" name="estudio">
                                    <label for="exampleCheck1">Estudio?</label>
                                </div>
                            </div>

                            <div class="col-md-2">
                                <div class="form-check">
                                    <input type="checkbox" disabled class="form-check-input" <?php if($propiedad->gimnasio==1): ?>
                                    checked <?php endif; ?> id="gimnasio" name="gimnasio">
                                    <label for="exampleCheck1">Gimnasio?</label>
                                </div>
                            </div>

                            <div class="col-md-2">
                                <div class="form-check">
                                    <input type="checkbox" disabled class="form-check-input" <?php if($propiedad->controldeacceso==1): ?>
                                    checked <?php endif; ?> id="controldeacceso" name="controldeacceso">
                                    <label for="exampleCheck1">Control de acceso?</label>
                                </div>
                            </div>

                        </div>
                        
                    </div>
                </div>

        </div>

    </div>
</div>
<!-- jQuery, Popper.js, and Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>



</body>

</html>
<?php /**PATH D:\xampp3\htdocs\realestate_dev\resources\views\admin\propiedades\vercualquierpropiedad.blade.php ENDPATH**/ ?>