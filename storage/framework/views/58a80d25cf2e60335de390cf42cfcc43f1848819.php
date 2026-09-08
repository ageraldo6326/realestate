<!doctype html>
<html class="no-js" lang="zxx">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Alis CRM Inmobiliario</title>
    <meta name="robots" content="noindex, follow" />
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Place favicon.png in the root directory -->
    <link rel="shortcut icon" href="img/favicon.png" type="image/x-icon" />
    <!-- Font Icons css -->
    <link rel="stylesheet" href="css/font-icons.css">
    <!-- plugins css -->
    <link rel="stylesheet" href="<?php echo e(asset('css/plugins.css')); ?>">
    <!-- Main Stylesheet -->
    <link rel="stylesheet" href="<?php echo e(asset('css/style.css')); ?>">
    <!-- Responsive css -->
    <link rel="stylesheet" href="<?php echo e(asset('css/responsive.css')); ?>">
</head>

<body>
    <!--[if lte IE 9]>
        <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="https://browsehappy.com/">upgrade your browser</a> to improve your experience and security.</p>
    <![endif]-->

    <!-- Add your site or application content here -->

    <!-- Body main wrapper start -->
    <div class="body-wrapper">
        <!-- LOGIN AREA START (Register) -->
        <div class="ltn__login-area pb-110">
            <div class="row">
                <div class="col-12">
                    <img src="<?php echo e(asset('img/header_image.jpg')); ?>" alt="">
                </div>
            </div>
            <div class="container">
                <div class="row">
                    <div class="col-lg-6 offset-lg-3">
                        <div class="account-login-inner">
                            <form action="<?php echo e(route('registrarse')); ?>" method="post"
                                class="ltn__form-box contact-form-box">
                                <?php echo csrf_field(); ?>
                                <input type="text" placeholder="Nombre" id="name" name="name">
                                <input type="text" placeholder="Correo" id="email" name="email">
                                <input type="password" placeholder="Clave" id="password" name="password">
                                <input type="password" placeholder="Repetir clave">
                                <div class="mb-3" style="text-align: left;">
                                    <label for="requiere_aprobacion_propiedades"
                                        style="display:block; font-weight: 600; margin-bottom: 6px;">Aprobacion de
                                        propiedades</label>
                                    <label style="display:inline-flex; align-items:center; gap:8px; cursor:pointer;">
                                        <input type="checkbox" id="requiere_aprobacion_propiedades"
                                            name="requiere_aprobacion_propiedades" value="1">
                                        Requiere aprobacion antes de publicar
                                    </label>
                                </div>
                                <div class="btn-wrapper text-center">
                                    <button class="theme-btn-1 btn reverse-color btn-block" type="submit">CREAR
                                        USUARIO</button>
                                </div>
                                <div>
                                    <a href="<?php echo e(route('login')); ?>" class="text-center">Ya estoy registrado</a>
                                </div>
                            </form>

                        </div>
                        <?php $__errorArgs = ['nombre_apellido'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <p class="error-message"><?php echo e($message); ?></p>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                </div>
            </div>
        </div>
        <!-- LOGIN AREA END -->


    </div>
    <!-- Body main wrapper end -->

    <!-- All JS Plugins -->
    <script src="<?php echo e(asset('js/plugins.js')); ?>"></script>
    <!-- Main JS -->
    <script src="<?php echo e(asset('js/main.js')); ?>"></script>

</body>

</html>
<?php /**PATH D:\xampp3\htdocs\realestate_dev\resources\views\admin\register.blade.php ENDPATH**/ ?>