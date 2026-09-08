<?php
    $isEdit = ($mode ?? 'create') === 'edit';
    $usuarioActual = $usuario ?? null;
    $isProtectedSuperadmin = (bool) ($isProtectedSuperadmin ?? false);

    $currentPhoto = $usuarioActual
        ? $usuarioActual->resolvePhotoUrl(asset('vendor/adminlte/dist/img/AdminLTELogo.png'))
        : asset('vendor/adminlte/dist/img/AdminLTELogo.png');
    $approvalMode = old(
        'modo_aprobacion_propiedades',
        $isEdit
            ? (optional($usuarioActual)->requiere_aprobacion_propiedades === null
                ? 'system'
                : ((int) optional($usuarioActual)->requiere_aprobacion_propiedades === 1
                    ? 'required'
                    : 'skip'))
            : null,
    );
    $pageHeading = $isEdit ? 'Editar usuario' : 'Crear nuevo usuario';
    $pageSummary = $isEdit
        ? 'Actualiza perfil, permisos, estado, visibilidad y seguridad desde una vista dedicada.'
        : 'Registra un nuevo usuario con perfil, visibilidad, credenciales y foto en un flujo completo.';
    $submitLabel = $isEdit ? 'Guardar cambios' : 'Crear usuario';
    $submitIcon = $isEdit ? 'fa-save' : 'fa-user-plus';
    $cancelLabel = $isEdit ? 'Volver al listado' : 'Cancelar';

    $checkedRolAsesor = (int) old('rol', (int) optional($usuarioActual)->rol) === 0;
    $checkedRolAdmin = (int) old('rol', (int) optional($usuarioActual)->rol) === 1;
    $checkedMostrarSi = (int) old('mostrar', $isEdit ? (int) optional($usuarioActual)->mostrar : 1) === 1;
    $checkedMostrarNo = (int) old('mostrar', $isEdit ? (int) optional($usuarioActual)->mostrar : 1) === 0;
    $checkedEstadoActivo = (bool) old('estado', (int) optional($usuarioActual)->activo === 1);
    $checkedActivoSi = (int) old('activo', 1) === 1;
    $checkedActivoNo = (int) old('activo', 1) === 0;
?>

<div class="container-fluid px-3">
    <link rel="stylesheet" href="https://unpkg.com/dropzone@5/dist/min/dropzone.min.css">
    <style>
        .users-shell {
            display: grid;
            gap: 1rem;
        }

        .users-hero {
            background: linear-gradient(135deg, #0f172a 0%, #1d4ed8 55%, #38bdf8 100%);
            border-radius: 1.25rem;
            color: #fff;
            padding: 1.5rem;
            box-shadow: 0 20px 45px rgba(15, 23, 42, 0.18);
        }

        .users-stat {
            background: rgba(255, 255, 255, 0.14);
            border: 1px solid rgba(255, 255, 255, 0.16);
            border-radius: 1rem;
            padding: 1rem;
        }

        .users-panel {
            border: 1px solid #dbe4f0;
            border-radius: 1.25rem;
            box-shadow: 0 14px 28px rgba(15, 23, 42, 0.06);
            overflow: hidden;
        }

        .users-panel .card-body {
            padding: 1.5rem;
        }

        .users-avatar-preview {
            width: 100%;
            aspect-ratio: 1 / 1;
            object-fit: cover;
            border-radius: 1rem;
            border: 1px solid #dbe4f0;
            background: #f8fafc;
        }

        .users-dropzone {
            border: 2px dashed #cbd5e1;
            border-radius: 12px;
            background: #f8fafc;
            padding: 0.75rem;
        }

        .users-dropzone .dz-message {
            margin: 1rem 0;
            color: #475569;
            font-weight: 600;
            text-align: center;
        }

        .users-dropzone .dz-preview .dz-image {
            border-radius: 10px;
        }

        .users-switch-wrap {
            background: #f8fafc;
            border: 1px solid #dbe4f0;
            border-radius: 0.8rem;
            padding: 0.75rem 1rem;
        }

        .users-form-help {
            font-size: 0.875rem;
            color: #6b7280;
            margin-top: 0.25rem;
        }

        .users-option-grid {
            display: flex;
            flex-wrap: wrap;
            gap: 0.75rem;
        }

        .users-option {
            position: relative;
            margin: 0;
        }

        .users-option-input {
            position: absolute;
            opacity: 0;
            pointer-events: none;
        }

        .users-option-label {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-width: 140px;
            padding: 0.85rem 1rem;
            border-radius: 0.9rem;
            border: 1px solid #cbd5e1;
            background: #fff;
            color: #334155;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s ease;
            box-shadow: 0 8px 20px rgba(15, 23, 42, 0.04);
        }

        .users-option-input:checked+.users-option-label {
            border-color: #2563eb;
            background: #eff6ff;
            color: #1d4ed8;
            box-shadow: 0 12px 24px rgba(37, 99, 235, 0.12);
        }

        .users-option-input:focus+.users-option-label {
            outline: 0;
            box-shadow: 0 0 0 0.2rem rgba(37, 99, 235, 0.18);
        }

        .users-toggle {
            position: relative;
            display: inline-flex;
            align-items: center;
            gap: 0.85rem;
        }

        .users-toggle-input {
            position: absolute;
            opacity: 0;
            pointer-events: none;
        }

        .users-toggle-label {
            display: inline-flex;
            align-items: center;
            gap: 0.85rem;
            cursor: pointer;
            font-weight: 600;
            color: #334155;
            margin-bottom: 0;
        }

        .users-toggle-track {
            width: 3.3rem;
            height: 1.9rem;
            border-radius: 999px;
            background: #cbd5e1;
            position: relative;
            transition: background-color 0.2s ease;
        }

        .users-toggle-track::after {
            content: '';
            position: absolute;
            top: 0.2rem;
            left: 0.22rem;
            width: 1.5rem;
            height: 1.5rem;
            border-radius: 999px;
            background: #fff;
            box-shadow: 0 4px 10px rgba(15, 23, 42, 0.18);
            transition: transform 0.2s ease;
        }

        .users-toggle-input:checked+.users-toggle-label .users-toggle-track {
            background: #2563eb;
        }

        .users-toggle-input:checked+.users-toggle-label .users-toggle-track::after {
            transform: translateX(1.38rem);
        }

        .users-toggle-input:focus+.users-toggle-label .users-toggle-track {
            box-shadow: 0 0 0 0.2rem rgba(37, 99, 235, 0.18);
        }

        .users-select {
            height: calc(1.5em + 1.4rem + 2px);
            border-radius: 0.9rem;
            border-color: #cbd5e1;
            box-shadow: 0 8px 20px rgba(15, 23, 42, 0.04);
        }

        .users-password-strength {
            height: 6px;
            border-radius: 999px;
            background: #e2e8f0;
            margin-top: 0.65rem;
            overflow: hidden;
        }

        .users-password-strength-bar {
            height: 100%;
            width: 0;
            transition: width 0.25s ease, background-color 0.25s ease;
            background: #ef4444;
        }

        .users-password-requirements {
            list-style: none;
            padding: 0;
            margin: 0.75rem 0 0;
            font-size: 0.875rem;
        }

        .users-password-requirements li {
            color: #64748b;
            margin-bottom: 0.3rem;
        }

        .users-password-requirements li::before {
            content: '○';
            display: inline-block;
            margin-right: 0.5rem;
            color: #94a3b8;
        }

        .users-password-requirements li.met {
            color: #059669;
        }

        .users-password-requirements li.met::before {
            content: '✓';
            color: #059669;
        }

        .users-highlight {
            background: #f8fafc;
            border: 1px solid #dbe4f0;
            border-radius: 1rem;
            padding: 1rem;
        }

        .users-highlight+.users-highlight {
            margin-top: 1rem;
        }

        .users-form-actions {
            display: flex;
            flex-wrap: wrap;
            gap: 0.75rem;
        }

        .users-form-main {
            padding-bottom: 0;
        }

        .ck-editor__editable_inline {
            min-height: 220px;
        }

        @media (max-width: 767.98px) {
            .users-form-main {
                padding-bottom: 7.5rem;
            }

            .users-hero {
                padding: 1.25rem;
            }

            .users-panel .card-body {
                padding: 1.15rem;
            }

            .users-form-actions {
                position: fixed;
                left: 0;
                right: 0;
                bottom: 0;
                z-index: 1040;
                display: flex;
                flex-direction: column;
                align-items: stretch;
                width: 100vw;
                max-width: 100vw;
                box-sizing: border-box;
                margin: 0;
                padding: 0.9rem 1rem calc(0.9rem + env(safe-area-inset-bottom));
                background: rgba(255, 255, 255, 0.96);
                border-top: 1px solid #dbe4f0;
                box-shadow: 0 -12px 30px rgba(15, 23, 42, 0.12);
                backdrop-filter: blur(12px);
            }

            .users-form-actions .btn {
                display: block;
                width: 100%;
            }

            .users-form-actions .spinner-border {
                display: none !important;
            }

            .users-option-grid {
                flex-direction: column;
            }

            .users-option-label {
                width: 100%;
            }
        }
    </style>

    <div class="users-shell">
        <section class="users-hero">
            <div class="row align-items-end">
                <div class="col-lg-8 mb-3 mb-lg-0">
                    <span class="badge badge-light text-primary px-3 py-2 rounded-pill mb-3">Configuracion del CRM</span>
                    <h1 class="h3 font-weight-bold mb-2"><?php echo e($pageHeading); ?></h1>
                    <p class="mb-0 text-white-50"><?php echo e($pageSummary); ?></p>
                </div>
                <div class="col-lg-4">
                    <div class="users-stat">
                        <div class="text-uppercase small text-white-50">Modo</div>
                        <div class="h4 mb-1 font-weight-bold"><?php echo e($isEdit ? 'Edicion' : 'Alta'); ?></div>
                        <div class="small text-white-50">
                            <?php echo e($isEdit ? 'Se conservan restricciones y permisos del usuario.' : 'Se asigna rol, estado inicial y foto de perfil.'); ?>

                        </div>
                    </div>
                </div>
            </div>
        </section>

        <?php if(session('status')): ?>
            <div class="alert alert-success border-0 shadow-sm rounded-lg mb-0">
                <?php echo e(session('status')); ?>

            </div>
        <?php endif; ?>

        <?php if(session('error')): ?>
            <div class="alert alert-danger border-0 shadow-sm rounded-lg mb-0">
                <?php echo e(session('error')); ?>

            </div>
        <?php endif; ?>

        <?php if($errors->any()): ?>
            <div class="alert alert-danger border-0 shadow-sm rounded-lg mb-0">
                <div class="font-weight-bold mb-1">Revisa los campos obligatorios antes de continuar.</div>
                <ul class="mb-0 pl-3">
                    <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <li><?php echo e($error); ?></li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </ul>
            </div>
        <?php endif; ?>

        <form id="usuario-form-<?php echo e($mode); ?>" action="<?php echo e($action); ?>" method="post"
            enctype="multipart/form-data" novalidate>
            <?php echo csrf_field(); ?>
            <?php if($isEdit): ?>
                <?php echo method_field('put'); ?>
            <?php endif; ?>

            <div class="row">
                <div class="col-xl-8 mb-4 mb-xl-0 users-form-main">
                    <div class="card users-panel mb-4">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center mb-4">
                                <div>
                                    <h2 class="h5 mb-1">Perfil del usuario</h2>
                                    <p class="text-muted mb-0">Datos base, biografia, SEO y enlaces de contacto.</p>
                                </div>
                                <?php if($isEdit): ?>
                                    <span class="badge badge-light text-primary px-3 py-2 rounded-pill">ID
                                        <?php echo e($usuarioActual->id); ?></span>
                                <?php endif; ?>
                            </div>

                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="name" class="font-weight-semibold">Nombre <?php if(!$isEdit): ?>
                                            <span class="text-danger">*</span>
                                        <?php endif; ?>
                                    </label>
                                    <input type="text" id="name" name="name"
                                        class="form-control <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                        value="<?php echo e(old('name', optional($usuarioActual)->name)); ?>"
                                        placeholder="Nombre completo"
                                        <?php if($isEdit): ?> disabled <?php else: ?> required <?php endif; ?>>
                                    <div class="users-form-help">
                                        <?php echo e($isEdit ? 'El nombre se mantiene bloqueado en la edicion.' : 'Minimo 3 caracteres y maximo 255.'); ?>

                                    </div>
                                    <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <span class="invalid-feedback d-block"><?php echo e($message); ?></span>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="email" class="font-weight-semibold">Correo electronico <?php if(!$isEdit): ?>
                                            <span class="text-danger">*</span>
                                        <?php endif; ?>
                                    </label>
                                    <input type="email" id="email" name="email"
                                        class="form-control <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                        value="<?php echo e(old('email', optional($usuarioActual)->email)); ?>"
                                        placeholder="correo@empresa.com" autocomplete="new-email"
                                        <?php if($isEdit): ?> disabled <?php else: ?> required <?php endif; ?>>
                                    <div class="users-form-help">
                                        <?php echo e($isEdit ? 'El correo no se modifica desde esta vista.' : 'Debe ser unico en el sistema.'); ?>

                                    </div>
                                    <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <span class="invalid-feedback d-block"><?php echo e($message); ?></span>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="titulo" class="font-weight-semibold">Titulo o cargo</label>
                                    <input type="text" id="titulo" name="titulo"
                                        class="form-control <?php $__errorArgs = ['titulo'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                        value="<?php echo e(old('titulo', optional($usuarioActual)->titulo)); ?>"
                                        placeholder="Ej. Asesor senior" maxlength="60">
                                    <?php $__errorArgs = ['titulo'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <span class="invalid-feedback d-block"><?php echo e($message); ?></span>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="telefono" class="font-weight-semibold">Telefono <span
                                            class="text-danger">*</span></label>
                                    <input type="text" id="telefono" name="telefono"
                                        class="form-control <?php $__errorArgs = ['telefono'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                        value="<?php echo e(old('telefono', optional($usuarioActual)->telefono)); ?>"
                                        placeholder="Telefono de contacto" maxlength="255" required>
                                    <?php $__errorArgs = ['telefono'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <span class="invalid-feedback d-block"><?php echo e($message); ?></span>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>
                            </div>

                            <div class="form-group">
                                <div
                                    class="d-flex flex-column flex-lg-row justify-content-between align-items-lg-center mb-2">
                                    <label for="descripcion" class="mb-2 mb-lg-0 font-weight-semibold">Descripcion <span
                                            class="text-danger">*</span></label>
                                    <button type="button" class="btn btn-sm btn-outline-primary"
                                        id="btn-generar-ia-usuario-<?php echo e($mode); ?>">
                                        <span id="ia-usuario-spinner-<?php echo e($mode); ?>"
                                            class="spinner-border spinner-border-sm mr-1 d-none" role="status"
                                            aria-hidden="true"></span>
                                        <span id="ia-usuario-label-<?php echo e($mode); ?>"><i
                                                class="fas fa-magic mr-1"></i>Generar con IA</span>
                                    </button>
                                </div>
                                <textarea id="descripcion" name="descripcion" class="form-control <?php $__errorArgs = ['descripcion'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" required><?php echo e(old('descripcion', optional($usuarioActual)->descripcion)); ?></textarea>
                                <div class="users-form-help">Minimo 10 caracteres. Se usa en el perfil comercial y la
                                    vista publica.</div>
                                <?php $__errorArgs = ['descripcion'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <span class="invalid-feedback d-block"><?php echo e($message); ?></span>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>

                            <div class="form-group">
                                <label for="metadescription" class="font-weight-semibold">Meta description</label>
                                <textarea id="metadescription" name="metadescription" rows="3" maxlength="160"
                                    class="form-control <?php $__errorArgs = ['metadescription'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" placeholder="Resumen breve para buscadores"><?php echo e(old('metadescription', optional($usuarioActual)->metadescription)); ?></textarea>
                                <div class="users-form-help">Maximo 160 caracteres para SEO.</div>
                                <?php $__errorArgs = ['metadescription'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <span class="invalid-feedback d-block"><?php echo e($message); ?></span>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>

                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="facebook" class="font-weight-semibold">Facebook</label>
                                    <input type="text" id="facebook" name="facebook" maxlength="255"
                                        class="form-control <?php $__errorArgs = ['facebook'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                        value="<?php echo e(old('facebook', optional($usuarioActual)->facebook)); ?>"
                                        placeholder="URL o usuario">
                                    <?php $__errorArgs = ['facebook'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <span class="invalid-feedback d-block"><?php echo e($message); ?></span>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="instagram" class="font-weight-semibold">Instagram</label>
                                    <input type="text" id="instagram" name="instagram" maxlength="255"
                                        class="form-control <?php $__errorArgs = ['instagram'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                        value="<?php echo e(old('instagram', optional($usuarioActual)->instagram)); ?>"
                                        placeholder="URL o usuario">
                                    <?php $__errorArgs = ['instagram'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <span class="invalid-feedback d-block"><?php echo e($message); ?></span>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="whatsapp" class="font-weight-semibold">WhatsApp</label>
                                    <input type="text" id="whatsapp" name="whatsapp" maxlength="255"
                                        class="form-control <?php $__errorArgs = ['whatsapp'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                        value="<?php echo e(old('whatsapp', optional($usuarioActual)->whatsapp)); ?>"
                                        placeholder="Numero o enlace">
                                    <?php $__errorArgs = ['whatsapp'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <span class="invalid-feedback d-block"><?php echo e($message); ?></span>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="tiktok" class="font-weight-semibold">TikTok</label>
                                    <input type="text" id="tiktok" name="tiktok" maxlength="255"
                                        class="form-control <?php $__errorArgs = ['tiktok'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                        value="<?php echo e(old('tiktok', optional($usuarioActual)->tiktok)); ?>"
                                        placeholder="URL o usuario">
                                    <?php $__errorArgs = ['tiktok'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <span class="invalid-feedback d-block"><?php echo e($message); ?></span>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card users-panel mb-4">
                        <div class="card-body">
                            <h2 class="h5 mb-3">Acceso y configuracion</h2>

                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label class="font-weight-semibold d-block">Rol <span
                                            class="text-danger">*</span></label>
                                    <div class="users-option-grid">
                                        <div class="users-option">
                                            <input class="users-option-input" type="radio"
                                                id="rolAsesor-<?php echo e($mode); ?>" name="rol" value="0"
                                                <?php echo e($checkedRolAsesor ? 'checked' : ''); ?>>
                                            <label class="users-option-label"
                                                for="rolAsesor-<?php echo e($mode); ?>">Asesor</label>
                                        </div>
                                        <div class="users-option">
                                            <input class="users-option-input" type="radio"
                                                id="rolAdmin-<?php echo e($mode); ?>" name="rol" value="1"
                                                <?php echo e($checkedRolAdmin ? 'checked' : ''); ?>>
                                            <label class="users-option-label"
                                                for="rolAdmin-<?php echo e($mode); ?>">Administrador</label>
                                        </div>
                                    </div>
                                    <?php $__errorArgs = ['rol'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <span class="text-danger d-block mt-1"><?php echo e($message); ?></span>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>

                                <div class="form-group col-md-6">
                                    <label class="font-weight-semibold d-block">Mostrar en equipo <span
                                            class="text-danger">*</span></label>
                                    <div class="users-option-grid">
                                        <div class="users-option">
                                            <input class="users-option-input" type="radio"
                                                id="mostrarSi-<?php echo e($mode); ?>" name="mostrar" value="1"
                                                <?php echo e($checkedMostrarSi ? 'checked' : ''); ?>>
                                            <label class="users-option-label"
                                                for="mostrarSi-<?php echo e($mode); ?>">Mostrar</label>
                                        </div>
                                        <div class="users-option">
                                            <input class="users-option-input" type="radio"
                                                id="mostrarNo-<?php echo e($mode); ?>" name="mostrar" value="0"
                                                <?php echo e($checkedMostrarNo ? 'checked' : ''); ?>>
                                            <label class="users-option-label"
                                                for="mostrarNo-<?php echo e($mode); ?>">Ocultar</label>
                                        </div>
                                    </div>
                                    <?php $__errorArgs = ['mostrar'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <span class="text-danger d-block mt-1"><?php echo e($message); ?></span>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="orden" class="font-weight-semibold">Orden</label>
                                    <input type="number" id="orden" name="orden" min="0"
                                        max="9999" class="form-control <?php $__errorArgs = ['orden'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                        value="<?php echo e(old('orden', $isEdit ? optional($usuarioActual)->orden : 100)); ?>">
                                    <div class="users-form-help">Numero mayor = posicion posterior.</div>
                                    <?php $__errorArgs = ['orden'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <span class="invalid-feedback d-block"><?php echo e($message); ?></span>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>

                                <div class="form-group col-md-6">
                                    <?php if($isEdit): ?>
                                        <label class="font-weight-semibold d-block">Estado</label>
                                        <?php if($isProtectedSuperadmin): ?>
                                            <div class="small text-warning mb-2">Superadmin protegido: este usuario no
                                                puede desactivarse desde la UI.</div>
                                        <?php endif; ?>
                                        <div class="users-switch-wrap">
                                            <div class="users-toggle">
                                                <input class="users-toggle-input" type="checkbox"
                                                    id="estado-<?php echo e($mode); ?>" name="estado"
                                                    <?php echo e($checkedEstadoActivo ? 'checked' : ''); ?>

                                                    <?php if($isProtectedSuperadmin): ?> disabled <?php endif; ?>>
                                                <label class="users-toggle-label" for="estado-<?php echo e($mode); ?>">
                                                    <span class="users-toggle-track"></span>
                                                    <span>Usuario activo</span>
                                                </label>
                                            </div>
                                        </div>
                                        <?php if($isProtectedSuperadmin): ?>
                                            <input type="hidden" name="estado" value="1">
                                        <?php endif; ?>
                                    <?php else: ?>
                                        <label class="font-weight-semibold d-block">Estado inicial <span
                                                class="text-danger">*</span></label>
                                        <div class="users-option-grid">
                                            <div class="users-option">
                                                <input class="users-option-input" type="radio"
                                                    id="activoSi-<?php echo e($mode); ?>" name="activo" value="1"
                                                    <?php echo e($checkedActivoSi ? 'checked' : ''); ?>>
                                                <label class="users-option-label"
                                                    for="activoSi-<?php echo e($mode); ?>">Activo</label>
                                            </div>
                                            <div class="users-option">
                                                <input class="users-option-input" type="radio"
                                                    id="activoNo-<?php echo e($mode); ?>" name="activo" value="0"
                                                    <?php echo e($checkedActivoNo ? 'checked' : ''); ?>>
                                                <label class="users-option-label"
                                                    for="activoNo-<?php echo e($mode); ?>">Inactivo</label>
                                            </div>
                                        </div>
                                        <?php $__errorArgs = ['activo'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                            <span class="text-danger d-block mt-1"><?php echo e($message); ?></span>
                                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                    <?php endif; ?>
                                </div>
                            </div>

                            <div class="form-group">
                                <label
                                    for="<?php echo e($isEdit ? 'modo_aprobacion_propiedades' : 'requiere_aprobacion_propiedades'); ?>"
                                    class="font-weight-semibold">Aprobacion de propiedades</label>
                                <?php if($isEdit): ?>
                                    <select
                                        class="form-control users-select <?php $__errorArgs = ['modo_aprobacion_propiedades'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                        id="modo_aprobacion_propiedades" name="modo_aprobacion_propiedades">
                                        <option value="system" @selected($approvalMode === 'system')>Heredar configuracion del
                                            sistema</option>
                                        <option value="required" @selected($approvalMode === 'required')>Requiere revision de
                                            administrador</option>
                                        <option value="skip" @selected($approvalMode === 'skip')>Publicar sin revision
                                        </option>
                                    </select>
                                    <small class="text-muted">La preferencia del usuario puede reemplazar la
                                        configuracion global.</small>
                                    <?php $__errorArgs = ['modo_aprobacion_propiedades'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <span class="invalid-feedback d-block"><?php echo e($message); ?></span>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                <?php else: ?>
                                    <select
                                        class="form-control users-select <?php $__errorArgs = ['requiere_aprobacion_propiedades'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                        id="requiere_aprobacion_propiedades" name="requiere_aprobacion_propiedades">
                                        <option value="0" @selected((int) old('requiere_aprobacion_propiedades', 0) === 0)>No requiere</option>
                                        <option value="1" @selected((int) old('requiere_aprobacion_propiedades', 0) === 1)>Requiere aprobacion
                                        </option>
                                    </select>
                                    <?php $__errorArgs = ['requiere_aprobacion_propiedades'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <span class="invalid-feedback d-block"><?php echo e($message); ?></span>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                <?php endif; ?>
                            </div>

                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="new_password"
                                        class="font-weight-semibold"><?php echo e($isEdit ? 'Nueva clave' : 'Clave inicial'); ?>

                                        <?php if(!$isEdit): ?>
                                            <span class="text-danger">*</span>
                                        <?php endif; ?>
                                    </label>
                                    <input type="password" id="new_password" name="new_password"
                                        class="form-control <?php $__errorArgs = ['new_password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                        placeholder="<?php echo e($isEdit ? 'Nueva clave opcional' : 'Clave temporal segura'); ?>"
                                        autocomplete="new-password"
                                        <?php if(!$isEdit): ?> required <?php endif; ?>>
                                    <?php $__errorArgs = ['new_password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <span class="invalid-feedback d-block"><?php echo e($message); ?></span>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>

                                    <div class="users-password-strength">
                                        <div class="users-password-strength-bar"
                                            id="password-strength-bar-<?php echo e($mode); ?>"></div>
                                    </div>
                                    <ul class="users-password-requirements mb-0">
                                        <li id="req-length-<?php echo e($mode); ?>">Minimo 8 caracteres</li>
                                        <li id="req-upper-<?php echo e($mode); ?>">Contiene mayusculas</li>
                                        <li id="req-lower-<?php echo e($mode); ?>">Contiene minusculas</li>
                                        <li id="req-digit-<?php echo e($mode); ?>">Contiene numeros</li>
                                    </ul>
                                </div>

                                <div class="form-group col-md-6">
                                    <label for="new_password_confirmation" class="font-weight-semibold">Confirmar
                                        clave <?php if(!$isEdit): ?>
                                            <span class="text-danger">*</span>
                                        <?php endif; ?>
                                    </label>
                                    <input type="password" id="new_password_confirmation"
                                        name="new_password_confirmation"
                                        class="form-control <?php $__errorArgs = ['new_password_confirmation'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                        placeholder="Repite la clave" autocomplete="new-password"
                                        <?php if(!$isEdit): ?> required <?php endif; ?>>
                                    <div class="users-form-help">
                                        <?php echo e($isEdit ? 'Solo completa este bloque si quieres cambiar la clave actual.' : 'Debe coincidir con la clave inicial.'); ?>

                                    </div>
                                    <?php $__errorArgs = ['new_password_confirmation'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <span class="invalid-feedback d-block"><?php echo e($message); ?></span>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

                <div class="col-xl-4">
                    <div class="card users-panel mb-4">
                        <div class="card-body">
                            <h2 class="h5 mb-3">Foto de perfil</h2>
                            <img id="user-photo-preview-<?php echo e($mode); ?>" class="users-avatar-preview mb-3"
                                src="<?php echo e(old('fotourl') ? asset('vendor/adminlte/dist/img/AdminLTELogo.png') : $currentPhoto); ?>"
                                data-default-src="<?php echo e($currentPhoto); ?>" alt="Vista previa del usuario">

                            <div class="form-group mb-2">
                                <div id="user-photo-dropzone-<?php echo e($mode); ?>" class="users-dropzone"></div>
                                <input type="file" class="d-none" name="fotourl"
                                    id="fotourl-<?php echo e($mode); ?>" accept="image/*">
                                <?php $__errorArgs = ['fotourl'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <span class="text-danger d-block mt-2"><?php echo e($message); ?></span>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>

                            <div class="users-form-help">Formatos JPG, PNG o WebP. Maximo 4 MB. Resolucion minima
                                sugerida: 300x300 px.</div>
                        </div>
                    </div>

                    <div class="card users-panel">
                        <div class="card-body">
                            <h2 class="h5 mb-3">Resumen rapido</h2>

                            <div class="users-highlight">
                                <div class="small text-uppercase text-muted mb-2">Visibilidad</div>
                                <div class="font-weight-semibold">
                                    <?php echo e($isEdit ? 'Puedes ajustar la exposicion en el equipo sin salir de esta vista.' : 'Define si el asesor aparecera en la seccion de equipo.'); ?>

                                </div>
                            </div>

                            <div class="users-highlight">
                                <div class="small text-uppercase text-muted mb-2">Seguridad</div>
                                <div class="font-weight-semibold">
                                    <?php echo e($isEdit ? 'El cambio de clave es opcional y mantiene el resto del perfil.' : 'La clave inicial debe cumplir requisitos minimos de seguridad.'); ?>

                                </div>
                            </div>

                            <?php if($isProtectedSuperadmin): ?>
                                <div class="users-highlight border-warning">
                                    <div class="small text-uppercase text-warning mb-2">Proteccion activa</div>
                                    <div class="font-weight-semibold">Este usuario esta marcado como superadmin
                                        protegido. La vista respeta esa restriccion.</div>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>

            <div class="users-form-actions">
                <button type="submit" class="btn btn-primary px-4" id="submitBtn-<?php echo e($mode); ?>">
                    <i class="fas <?php echo e($submitIcon); ?> mr-2"></i><?php echo e($submitLabel); ?>

                </button>
                <span id="submit-spinner-<?php echo e($mode); ?>"
                    class="spinner-border spinner-border-sm align-self-center d-none" role="status"
                    aria-hidden="true"></span>
                <a href="<?php echo e(route('usuarios.index')); ?>" class="btn btn-light px-4"><?php echo e($cancelLabel); ?></a>
            </div>
        </form>
    </div>
</div>

<?php $__env->startPush('scripts'); ?>
    <script>
        window.Dropzone = window.Dropzone || {};
        window.Dropzone.autoDiscover = false;
    </script>
    <script src="https://unpkg.com/dropzone@5/dist/min/dropzone.min.js"></script>
    <script>
        window.addEventListener('load', () => {
            const mode = <?php echo json_encode($mode, 15, 512) ?>;
            const form = document.getElementById(`usuario-form-${mode}`);

            if (!form || form.dataset.bound === '1') {
                return;
            }

            form.dataset.bound = '1';

            const descripcionField = document.getElementById('descripcion');
            const metadescriptionField = document.getElementById('metadescription');
            const submitButton = document.getElementById(`submitBtn-${mode}`);
            const submitSpinner = document.getElementById(`submit-spinner-${mode}`);
            const passwordInput = document.getElementById('new_password');
            const preview = document.getElementById(`user-photo-preview-${mode}`);
            const photoInput = document.getElementById(`fotourl-${mode}`);
            const dropzoneTarget = document.getElementById(`user-photo-dropzone-${mode}`);
            const aiButton = document.getElementById(`btn-generar-ia-usuario-${mode}`);
            const aiSpinner = document.getElementById(`ia-usuario-spinner-${mode}`);
            const aiLabel = document.getElementById(`ia-usuario-label-${mode}`);

            let descripcionEditor = null;

            const getDescriptionValue = () => {
                if (descripcionEditor) {
                    return descripcionEditor.getData();
                }

                return descripcionField ? descripcionField.value : '';
            };

            const setDescriptionValue = (value) => {
                if (descripcionEditor) {
                    descripcionEditor.setData(value || '');
                }

                if (descripcionField) {
                    descripcionField.value = value || '';
                }
            };

            if (window.ClassicEditor && descripcionField) {
                ClassicEditor.create(descripcionField, {
                    toolbar: ['heading', '|', 'bold', 'italic', 'link', 'bulletedList', 'numberedList',
                        'blockQuote', 'undo', 'redo'
                    ],
                    heading: {
                        options: [{
                                model: 'paragraph',
                                title: 'Parrafo',
                                class: 'ck-heading_paragraph'
                            },
                            {
                                model: 'heading1',
                                view: 'h2',
                                title: 'Encabezado',
                                class: 'ck-heading_heading1'
                            },
                            {
                                model: 'heading2',
                                view: 'h3',
                                title: 'Subencabezado',
                                class: 'ck-heading_heading2'
                            }
                        ]
                    }
                }).then((editor) => {
                    descripcionEditor = editor;
                }).catch((error) => console.error('Error CKEditor:', error));
            }

            const requirementRules = {
                [`req-length-${mode}`]: /^.{8,}$/,
                [`req-upper-${mode}`]: /[A-Z]/,
                [`req-lower-${mode}`]: /[a-z]/,
                [`req-digit-${mode}`]: /\d/
            };

            if (passwordInput) {
                passwordInput.addEventListener('input', () => {
                    const password = passwordInput.value;
                    const strengthBar = document.getElementById(`password-strength-bar-${mode}`);
                    let metCount = 0;

                    Object.entries(requirementRules).forEach(([id, regex]) => {
                        const element = document.getElementById(id);

                        if (!element) {
                            return;
                        }

                        if (regex.test(password)) {
                            element.classList.add('met');
                            metCount++;
                        } else {
                            element.classList.remove('met');
                        }
                    });

                    if (strengthBar) {
                        const percentages = [0, 25, 55, 80, 100];
                        const colors = ['#e2e8f0', '#ef4444', '#f59e0b', '#22c55e', '#16a34a'];
                        strengthBar.style.width = `${percentages[metCount]}%`;
                        strengthBar.style.backgroundColor = colors[metCount];
                    }
                });
            }

            if (typeof Dropzone !== 'undefined' && photoInput && dropzoneTarget && dropzoneTarget.dataset
                .initialized !== '1') {
                dropzoneTarget.dataset.initialized = '1';

                const syncPreview = (file) => {
                    if (!preview) {
                        return;
                    }

                    if (!file) {
                        preview.src = preview.dataset.defaultSrc || '';
                        return;
                    }

                    const reader = new FileReader();
                    reader.onload = (event) => {
                        preview.src = event.target?.result || preview.dataset.defaultSrc || '';
                    };
                    reader.readAsDataURL(file);
                };

                const userDropzone = new Dropzone(dropzoneTarget, {
                    url: '#',
                    autoProcessQueue: false,
                    uploadMultiple: false,
                    maxFiles: 1,
                    acceptedFiles: 'image/*',
                    addRemoveLinks: true,
                    dictDefaultMessage: 'Arrastra una imagen aqui o haz clic para seleccionar.'
                });

                userDropzone.on('addedfile', (file) => {
                    if (userDropzone.files.length > 1) {
                        userDropzone.removeFile(userDropzone.files[0]);
                    }

                    const transfer = new DataTransfer();
                    transfer.items.add(file);
                    photoInput.files = transfer.files;
                    syncPreview(file);
                });

                userDropzone.on('removedfile', () => {
                    photoInput.value = '';
                    syncPreview(null);
                });
            }

            if (aiButton) {
                aiButton.addEventListener('click', async () => {
                    aiButton.disabled = true;
                    aiSpinner?.classList.remove('d-none');
                    if (aiLabel) {
                        aiLabel.innerHTML = 'Generando...';
                    }

                    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute(
                        'content') || '';

                    try {
                        const response = await fetch(<?php echo json_encode(route('admin.ai.generate'), 15, 512) ?>, {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': csrfToken,
                                'Accept': 'application/json',
                            },
                            body: JSON.stringify({
                                type: 'asesor',
                                contexto: {
                                    nombre: document.getElementById('name')?.value ||
                                        '',
                                    titulo: document.getElementById('titulo')?.value ||
                                        '',
                                    telefono: document.getElementById('telefono')
                                        ?.value || '',
                                    descripcion_actual: getDescriptionValue(),
                                }
                            })
                        });

                        const result = await response.json();

                        if (!response.ok || !result.ok) {
                            throw new Error(result.message || 'No fue posible generar contenido.');
                        }

                        const data = result.data || {};

                        if (data.descripcion) {
                            setDescriptionValue(data.descripcion);
                        }

                        if (metadescriptionField && data.metadescription) {
                            metadescriptionField.value = data.metadescription;
                        }

                        if (window.Swal) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Contenido generado',
                                text: 'Revisa el texto antes de guardar.',
                                timer: 2200,
                                showConfirmButton: false,
                            });
                        }
                    } catch (error) {
                        if (window.Swal) {
                            Swal.fire('Error', error.message ||
                                'No fue posible generar contenido con IA.', 'error');
                        }
                    } finally {
                        aiButton.disabled = false;
                        aiSpinner?.classList.add('d-none');
                        if (aiLabel) {
                            aiLabel.innerHTML = '<i class="fas fa-magic mr-1"></i>Generar con IA';
                        }
                    }
                });
            }

            form.addEventListener('submit', () => {
                if (descripcionEditor) {
                    descripcionField.value = descripcionEditor.getData();
                }

                if (submitButton) {
                    submitButton.disabled = true;
                }

                submitSpinner?.classList.remove('d-none');
            });
        });
    </script>
<?php $__env->stopPush(); ?>
<?php /**PATH D:\xampp3\htdocs\realestate_dev\resources\views\admin\usuarios\_form.blade.php ENDPATH**/ ?>