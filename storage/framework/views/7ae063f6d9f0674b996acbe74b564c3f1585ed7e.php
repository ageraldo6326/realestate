<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="noindex, nofollow">
    <title>Acceso — Alis CRM Inmobiliario</title>

    <link rel="shortcut icon" href="<?php echo e(asset('img/favicon.png')); ?>" type="image/x-icon">
    <!-- Inter font -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="/adminlte/plugins/fontawesome-free/css/all.min.css">

    <style>
        *,
        *::before,
        *::after {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #0f172a 0%, #1e3a5f 50%, #0f172a 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 1rem;
        }

        .login-wrapper {
            display: flex;
            width: 100%;
            max-width: 900px;
            min-height: 540px;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 25px 60px rgba(0, 0, 0, .5);
        }

        /* Panel izquierdo decorativo */
        .login-brand {
            flex: 1;
            background: linear-gradient(160deg, #1d4ed8 0%, #0f172a 100%);
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 3rem 2rem;
            position: relative;
            overflow: hidden;
        }

        .login-brand::before {
            content: '';
            position: absolute;
            top: -60px;
            right: -60px;
            width: 200px;
            height: 200px;
            border-radius: 50%;
            background: rgba(255, 255, 255, .05);
        }

        .login-brand::after {
            content: '';
            position: absolute;
            bottom: -40px;
            left: -40px;
            width: 150px;
            height: 150px;
            border-radius: 50%;
            background: rgba(255, 255, 255, .04);
        }

        .login-brand img {
            width: 72px;
            height: 72px;
            object-fit: contain;
            margin-bottom: 1.5rem;
            filter: drop-shadow(0 4px 12px rgba(0, 0, 0, .3));
        }

        .login-brand h1 {
            color: #fff;
            font-size: 1.6rem;
            font-weight: 700;
            text-align: center;
            margin-bottom: .5rem;
        }

        .login-brand p {
            color: #93c5fd;
            font-size: .85rem;
            text-align: center;
            line-height: 1.5;
            max-width: 200px;
        }

        .login-brand .features {
            margin-top: 2rem;
            list-style: none;
            width: 100%;
        }

        .login-brand .features li {
            display: flex;
            align-items: center;
            gap: .6rem;
            color: #bfdbfe;
            font-size: .78rem;
            margin-bottom: .6rem;
        }

        .login-brand .features li i {
            color: #60a5fa;
            width: 16px;
        }

        /* Panel derecho con el formulario */
        .login-form-panel {
            flex: 1;
            background: #fff;
            display: flex;
            flex-direction: column;
            justify-content: center;
            padding: 3rem 2.5rem;
        }

        .login-form-panel .form-header {
            margin-bottom: 2rem;
        }

        .login-form-panel .form-header h2 {
            font-size: 1.4rem;
            font-weight: 700;
            color: #0f172a;
            margin-bottom: .3rem;
        }

        .login-form-panel .form-header p {
            color: #64748b;
            font-size: .85rem;
        }

        .form-group {
            margin-bottom: 1.25rem;
        }

        .form-group label {
            display: block;
            font-size: .78rem;
            font-weight: 600;
            color: #475569;
            margin-bottom: .4rem;
            text-transform: uppercase;
            letter-spacing: .5px;
        }

        .input-wrapper {
            position: relative;
        }

        .input-wrapper i {
            position: absolute;
            left: .85rem;
            top: 50%;
            transform: translateY(-50%);
            color: #94a3b8;
            font-size: .85rem;
        }

        .form-control {
            width: 100%;
            padding: .65rem .85rem .65rem 2.4rem;
            border: 1.5px solid #e2e8f0;
            border-radius: 8px;
            font-size: .9rem;
            font-family: inherit;
            color: #1e293b;
            background: #f8fafc;
            transition: border-color .15s, box-shadow .15s;
            outline: none;
        }

        .form-control:focus {
            border-color: #2563eb;
            box-shadow: 0 0 0 3px rgba(37, 99, 235, .12);
            background: #fff;
        }

        .alert-error {
            background: #fef2f2;
            border: 1px solid #fecaca;
            border-radius: 8px;
            padding: .75rem 1rem;
            color: #dc2626;
            font-size: .83rem;
            display: flex;
            align-items: center;
            gap: .5rem;
            margin-bottom: 1.25rem;
        }

        .btn-login {
            width: 100%;
            padding: .75rem;
            background: #2563eb;
            color: #fff;
            border: none;
            border-radius: 8px;
            font-size: .9rem;
            font-weight: 600;
            font-family: inherit;
            cursor: pointer;
            transition: background .15s, transform .1s, box-shadow .15s;
            margin-top: .5rem;
        }

        .btn-login:hover {
            background: #1d4ed8;
            transform: translateY(-1px);
            box-shadow: 0 6px 16px rgba(37, 99, 235, .35);
        }

        .btn-login:active {
            transform: translateY(0);
        }

        .login-footer {
            margin-top: 1.5rem;
            text-align: center;
        }

        .login-footer a {
            color: #2563eb;
            font-size: .82rem;
            text-decoration: none;
            font-weight: 500;
        }

        .login-footer a:hover {
            text-decoration: underline;
        }

        /* Mobile: oculta el panel de marca */
        @media (max-width: 640px) {
            .login-brand {
                display: none;
            }

            .login-wrapper {
                max-width: 420px;
                border-radius: 12px;
            }

            .login-form-panel {
                padding: 2rem 1.5rem;
            }
        }
    </style>
</head>

<body>

    <div class="login-wrapper">
        <!-- Panel de marca (izquierdo) -->
        <div class="login-brand">
            <img src="<?php echo e(asset('assets/inmobiliaria/logo.png')); ?>" alt="Logo del sistema">
            <h1>Alis CRM</h1>
            <p>Sistema de gestión inmobiliaria</p>

            <ul class="features">
                <li><i class="fas fa-home"></i> Gestión de propiedades</li>
                <li><i class="fas fa-users"></i> CRM de contactos</li>
                <li><i class="fas fa-chart-bar"></i> Estadísticas y reportes</li>
                <li><i class="fas fa-calendar-alt"></i> Agenda y tareas</li>
            </ul>
        </div>

        <!-- Panel de formulario (derecho) -->
        <div class="login-form-panel">
            <div class="form-header">
                <h2>Bienvenido de vuelta</h2>
                <p>Ingresa tus credenciales para continuar</p>
            </div>

            <?php if(session('error')): ?>
                <div class="alert-error">
                    <i class="fas fa-exclamation-circle"></i>
                    <?php echo e(session('error')); ?>

                </div>
            <?php endif; ?>

            <form action="<?php echo e(route('loguearse')); ?>" method="POST">
                <?php echo csrf_field(); ?>
                <div class="form-group">
                    <label for="email">Correo electrónico</label>
                    <div class="input-wrapper">
                        <i class="fas fa-envelope"></i>
                        <input type="email" id="email" name="email" class="form-control"
                            placeholder="nombre@empresa.com" value="<?php echo e(old('email')); ?>" required autofocus>
                    </div>
                </div>

                <div class="form-group">
                    <label for="password">Contraseña</label>
                    <div class="input-wrapper">
                        <i class="fas fa-lock"></i>
                        <input type="password" id="password" name="password" class="form-control"
                            placeholder="••••••••" required>
                    </div>
                </div>

                <button type="submit" class="btn-login">
                    Iniciar sesión &nbsp;<i class="fas fa-arrow-right"></i>
                </button>
            </form>

            <div class="login-footer">
                <a href="<?php echo e(route('registro')); ?>">¿No tienes cuenta? Regístrate</a>
            </div>
        </div>
    </div>

</body>

</html>
<?php /**PATH D:\xampp3\htdocs\realestate_dev\resources\views\admin\login.blade.php ENDPATH**/ ?>