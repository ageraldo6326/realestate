<?php
    $company = $inmobiliaria ?? null;
    $submitLabel = $submitLabel ?? 'Guardar cambios';
    $brandingService = app(\App\Services\Branding\CompanyBrandingService::class);
    $currentTheme = $brandingService->resolveTheme($company);
    $defaultTheme = $brandingService->getDefaultTheme();
    $logoPalette = $brandingService->resolveLogoPalette($company);
    $logoSuggestedTheme = $logoPalette ? $brandingService->buildThemeFromPalette($logoPalette) : null;
    $hasPreviousTheme = $brandingService->hasPreviousTheme($company);
    $themeSourceLabel = $brandingService->getSourceLabel($currentTheme['theme_source'] ?? null);
    $logoBehavior = old('theme_logo_behavior', $company ? 'keep_current' : 'apply_logo_palette');
    $themeFields = [
        'theme_color_primary' => 'Primario',
        'theme_color_secondary' => 'Secundario',
        'theme_color_accent' => 'Acento',
        'theme_color_neutral' => 'Neutro',
    ];
?>

<link rel="stylesheet" href="https://unpkg.com/dropzone@5/dist/min/dropzone.min.css">

<div class="row g-4">
    <div class="col-xl-8">
        <div class="card shadow-sm border-0 mb-4">
            <div class="card-body p-4">
                <h2 class="section-title">Informacion general</h2>

                <div class="row">
                    <div class="col-md-6 form-group mb-3">
                        <label for="nombre" class="font-weight-bold">Nombre <span class="text-danger">*</span></label>
                        <input type="text" class="form-control <?php $__errorArgs = ['nombre'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="nombre"
                            name="nombre" placeholder="Nombre comercial"
                            value="<?php echo e(old('nombre', optional($company)->nombre)); ?>" required>
                    </div>

                    <div class="col-md-6 form-group mb-3">
                        <label for="correo" class="font-weight-bold">Correo <span class="text-danger">*</span></label>
                        <input type="email" class="form-control <?php $__errorArgs = ['correo'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="correo"
                            name="correo" placeholder="correo@empresa.com"
                            value="<?php echo e(old('correo', optional($company)->correo)); ?>" required>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 form-group mb-3">
                        <label for="telefono" class="font-weight-bold">Telefono <span
                                class="text-danger">*</span></label>
                        <input type="text" class="form-control <?php $__errorArgs = ['telefono'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                            id="telefono" name="telefono" placeholder="Telefono principal"
                            value="<?php echo e(old('telefono', optional($company)->telefono)); ?>" required>
                    </div>

                    <div class="col-md-6 form-group mb-3">
                        <label for="titulo" class="font-weight-bold">Titulo del sitio</label>
                        <input type="text" class="form-control <?php $__errorArgs = ['titulo'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="titulo"
                            name="titulo" placeholder="Titulo para encabezado y SEO"
                            value="<?php echo e(old('titulo', optional($company)->titulo)); ?>">
                    </div>
                </div>

                <div class="form-group mb-3">
                    <label for="direccion" class="font-weight-bold">Direccion <span class="text-danger">*</span></label>
                    <textarea class="form-control <?php $__errorArgs = ['direccion'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="direccion" name="direccion" rows="3"
                        required><?php echo e(old('direccion', optional($company)->direccion)); ?></textarea>
                </div>

                <div class="form-group mb-3">
                    <label for="quienessomos" class="font-weight-bold">Quienes somos</label>
                    <textarea class="form-control <?php $__errorArgs = ['quienessomos'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="quienessomos" name="quienessomos"
                        rows="5"><?php echo e(old('quienessomos', optional($company)->quienessomos)); ?></textarea>
                </div>

                <div class="form-group mb-0">
                    <label for="metadescription" class="font-weight-bold">Meta Description</label>
                    <textarea class="form-control <?php $__errorArgs = ['metadescription'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="metadescription"
                        name="metadescription" rows="3"><?php echo e(old('metadescription', optional($company)->metadescription)); ?></textarea>
                </div>
            </div>
        </div>

        <div class="card shadow-sm border-0 mb-4">
            <div class="card-body p-4">
                <h2 class="section-title">Redes y contacto</h2>

                <div class="row">
                    <div class="col-md-6 form-group mb-3">
                        <label for="facebook" class="font-weight-bold">Facebook</label>
                        <input type="text" class="form-control <?php $__errorArgs = ['facebook'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                            id="facebook" name="facebook" placeholder="https://facebook.com/..."
                            value="<?php echo e(old('facebook', optional($company)->facebook)); ?>">
                    </div>

                    <div class="col-md-6 form-group mb-3">
                        <label for="instagram" class="font-weight-bold">Instagram</label>
                        <input type="text" class="form-control <?php $__errorArgs = ['instagram'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                            id="instagram" name="instagram" placeholder="https://instagram.com/..."
                            value="<?php echo e(old('instagram', optional($company)->instagram)); ?>">
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 form-group mb-3">
                        <label for="tiktok" class="font-weight-bold">TikTok</label>
                        <input type="text" class="form-control <?php $__errorArgs = ['tiktok'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="tiktok"
                            name="tiktok" placeholder="https://tiktok.com/..."
                            value="<?php echo e(old('tiktok', optional($company)->tiktok)); ?>">
                    </div>

                    <div class="col-md-6 form-group mb-0">
                        <label for="whatsapp" class="font-weight-bold">WhatsApp</label>
                        <input type="text" class="form-control <?php $__errorArgs = ['whatsapp'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                            id="whatsapp" name="whatsapp" placeholder="Ej: 8090000000"
                            value="<?php echo e(old('whatsapp', optional($company)->whatsapp)); ?>">
                    </div>
                </div>
            </div>
        </div>

        <div class="card shadow-sm border-0 mb-4">
            <div class="card-body p-4">
                <div class="d-flex flex-wrap justify-content-between align-items-start mb-3">
                    <div>
                        <h2 class="section-title mb-1">Identidad de color</h2>
                        <p class="brand-muted mb-0">La paleta del frontend puede venir del logo o ajustarse manualmente
                            sin perder el acceso a default y version anterior.</p>
                    </div>
                    <span class="brand-theme-chip"><?php echo e($themeSourceLabel); ?></span>
                </div>

                <div class="brand-status-list mb-4">
                    <div class="brand-status-item">
                        <div>
                            <strong>Paleta activa</strong>
                            <small class="d-block text-muted">Aplicada en inicio, propiedades, agentes, quienes somos,
                                novedades y contacto.</small>
                        </div>
                        <div class="d-flex align-items-center">
                            <?php $__currentLoopData = $themeFields; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $field => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <span class="rounded-circle border ml-2" title="<?php echo e($label); ?>"
                                    style="width:22px;height:22px;background:<?php echo e(old($field, $currentTheme[$field])); ?>;"></span>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    </div>
                    <div class="brand-status-item">
                        <div>
                            <strong>Version anterior</strong>
                            <small
                                class="d-block text-muted"><?php echo e($hasPreviousTheme ? 'Disponible para restaurar.' : 'Aun no existe historial previo guardado.'); ?></small>
                        </div>
                        <span
                            class="badge badge-<?php echo e($hasPreviousTheme ? 'success' : 'secondary'); ?>"><?php echo e($hasPreviousTheme ? 'Disponible' : 'Sin historial'); ?></span>
                    </div>
                </div>

                <h3 class="h6 font-weight-bold mb-3">Colores detectados del logo</h3>
                <?php if($logoPalette): ?>
                    <div class="brand-swatch-grid mb-4">
                        <?php $__currentLoopData = $logoPalette; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $color): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="brand-swatch-card">
                                <div class="brand-swatch-preview" style="background: <?php echo e($color); ?>;"></div>
                                <div class="brand-swatch-meta">
                                    <span class="brand-swatch-label">Logo <?php echo e($index + 1); ?></span>
                                    <span class="brand-swatch-value"><?php echo e(strtoupper($color)); ?></span>
                                </div>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                <?php else: ?>
                    <div class="alert alert-light border mb-4">Aun no hay colores detectados del logo. Se guardaran
                        automaticamente cuando subas o reemplaces el logo.</div>
                <?php endif; ?>

                <div class="d-flex justify-content-end mb-4">
                    <button type="button" class="btn btn-outline-primary btn-sm" id="apply-logo-palette"
                        <?php if(!$logoSuggestedTheme): ?> disabled <?php endif; ?>
                        <?php if($logoSuggestedTheme): ?> data-primary="<?php echo e($logoSuggestedTheme['theme_color_primary']); ?>"
                            data-secondary="<?php echo e($logoSuggestedTheme['theme_color_secondary']); ?>"
                            data-accent="<?php echo e($logoSuggestedTheme['theme_color_accent']); ?>"
                            data-neutral="<?php echo e($logoSuggestedTheme['theme_color_neutral']); ?>" <?php endif; ?>>
                        Usar sugerencia del logo
                    </button>
                </div>

                <div class="row">
                    <?php $__currentLoopData = $themeFields; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $field => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="col-md-6 form-group mb-3">
                            <label for="<?php echo e($field); ?>" class="font-weight-bold"><?php echo e($label); ?></label>
                            <div class="brand-color-input">
                                <input type="color" value="<?php echo e(old($field, $currentTheme[$field])); ?>"
                                    data-sync-color="<?php echo e($field); ?>">
                                <input type="text" class="form-control <?php $__errorArgs = [$field];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                    id="<?php echo e($field); ?>" name="<?php echo e($field); ?>" maxlength="7"
                                    value="<?php echo e(old($field, $currentTheme[$field])); ?>">
                            </div>
                            <?php $__errorArgs = [$field];
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
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>

                <div class="alert alert-light border mb-0">
                    <strong>Default actual:</strong>
                    <span class="d-block mt-1">Primario <?php echo e(strtoupper($defaultTheme['theme_color_primary'])); ?>,
                        Secundario <?php echo e(strtoupper($defaultTheme['theme_color_secondary'])); ?>, Acento
                        <?php echo e(strtoupper($defaultTheme['theme_color_accent'])); ?>, Neutro
                        <?php echo e(strtoupper($defaultTheme['theme_color_neutral'])); ?>.</span>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-4">
        <div class="card shadow-sm border-0 mb-4">
            <div class="card-body p-4">
                <h2 class="section-title">Identidad visual</h2>

                <div class="form-group mb-3">
                    <label for="logo" class="font-weight-bold">Logo</label>
                    <div id="company-logo-dropzone" class="company-dropzone" role="button" tabindex="0"
                        aria-label="Cargar logo">
                        <div class="company-dropzone-placeholder">
                            Arrastra el logo aqui o haz clic para seleccionar.
                        </div>
                    </div>
                    <input class="d-none <?php $__errorArgs = ['logo'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" type="file" id="logo"
                        name="logo" accept="image/*">
                </div>

                <?php if($companyLogoUrl = optional($company)->publicLogoUrl()): ?>
                    <div class="preview-box mb-3">
                        <span class="preview-label">Logo actual</span>
                        <img src="<?php echo e($companyLogoUrl); ?>" class="img-fluid rounded" alt="Logo de empresa">
                    </div>
                <?php endif; ?>

                <div class="form-group mb-3">
                    <label for="favicon" class="font-weight-bold">Favicon</label>
                    <div id="company-favicon-dropzone" class="company-dropzone" role="button" tabindex="0"
                        aria-label="Cargar favicon">
                        <div class="company-dropzone-placeholder">
                            Arrastra el favicon aqui o haz clic para seleccionar.
                        </div>
                    </div>
                    <input class="d-none <?php $__errorArgs = ['favicon'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" type="file" id="favicon"
                        name="favicon" accept="image/*">
                </div>

                <?php if($companyFaviconUrl = optional($company)->publicFaviconUrl()): ?>
                    <div class="preview-box">
                        <span class="preview-label">Favicon actual</span>
                        <img src="<?php echo e($companyFaviconUrl); ?>" class="img-fluid rounded" alt="Favicon de empresa">
                    </div>
                <?php endif; ?>

                <hr>

                <h3 class="h6 font-weight-bold mb-3">Si subes un logo nuevo</h3>
                <label class="brand-theme-radio <?php echo e($logoBehavior === 'keep_current' ? 'active' : ''); ?> mb-3"
                    for="theme_logo_behavior_keep">
                    <div class="custom-control custom-radio">
                        <input class="custom-control-input" type="radio" name="theme_logo_behavior"
                            id="theme_logo_behavior_keep" value="keep_current" @checked($logoBehavior === 'keep_current')>
                        <span class="custom-control-label font-weight-bold">Mantener colores actuales</span>
                    </div>
                    <div class="brand-muted mt-2">Se actualizan solo los colores sugeridos del logo, sin tocar la
                        paleta activa.</div>
                </label>

                <label class="brand-theme-radio <?php echo e($logoBehavior === 'apply_logo_palette' ? 'active' : ''); ?> mb-0"
                    for="theme_logo_behavior_apply">
                    <div class="custom-control custom-radio">
                        <input class="custom-control-input" type="radio" name="theme_logo_behavior"
                            id="theme_logo_behavior_apply" value="apply_logo_palette" @checked($logoBehavior === 'apply_logo_palette')>
                        <span class="custom-control-label font-weight-bold">Aplicar paleta del nuevo logo</span>
                    </div>
                    <div class="brand-muted mt-2">El sistema aplica los colores detectados y conserva la version previa
                        para poder volver atras.</div>
                </label>
            </div>
        </div>

        <div class="card shadow-sm border-0 mb-4">
            <div class="card-body p-4">
                <h2 class="section-title">Restauracion</h2>
                <p class="brand-muted mb-3">Estas acciones restauran la identidad grafica sin depender de editar
                    manualmente los campos.</p>

                <div class="brand-restore-actions">
                    <button type="submit" class="btn btn-outline-dark btn-block"
                        <?php if($company): ?> formaction="<?php echo e(route('inmobiliaria.restore-default', $company->id)); ?>" <?php endif; ?>
                        formmethod="POST" formnovalidate data-skip-loading="1" @disabled(!$company)>
                        Volver a default
                    </button>

                    <button type="submit" class="btn btn-outline-primary btn-block"
                        <?php if($company): ?> formaction="<?php echo e(route('inmobiliaria.restore-previous', $company->id)); ?>" <?php endif; ?>
                        formmethod="POST" formnovalidate data-skip-loading="1" @disabled(!$company || !$hasPreviousTheme)>
                        Volver a version anterior
                    </button>
                </div>
            </div>
        </div>

        <div class="card shadow-sm border-0 mb-4">
            <div class="card-body p-4">
                <h2 class="section-title">Publicacion</h2>
                <div class="d-flex align-items-center justify-content-between">
                    <label for="aprobacion" class="mb-0 font-weight-bold">Requiere aprobacion</label>
                    <div class="custom-control custom-switch mb-0">
                        <input type="hidden" name="aprobacion" value="0">
                        <input type="checkbox" class="custom-control-input" name="aprobacion" id="aprobacion"
                            value="1" <?php if((bool) old('aprobacion', optional($company)->aprobacion ?? true)): ?> checked <?php endif; ?>>
                        <label for="aprobacion" class="custom-control-label"></label>
                    </div>
                </div>
            </div>
        </div>

        <div class="card shadow-sm border-0">
            <div class="card-body p-4">
                <button type="submit" class="btn btn-success btn-block" id="submit"
                    data-loading-text="Guardando configuracion...">
                    <?php echo e($submitLabel); ?>

                </button>
            </div>
        </div>
    </div>
</div>

<?php if (! $__env->hasRenderedOnce('84df54e8-466f-441e-acbd-0b374cb9cd87')): $__env->markAsRenderedOnce('84df54e8-466f-441e-acbd-0b374cb9cd87'); ?>
    <?php $__env->startPush('scripts'); ?>
        <script>
            window.Dropzone = window.Dropzone || {};
            window.Dropzone.autoDiscover = false;
        </script>
        <script src="https://unpkg.com/dropzone@5/dist/min/dropzone.min.js"></script>
        <script>
            document.addEventListener('DOMContentLoaded', () => {
                if (typeof Dropzone === 'undefined') {
                    return;
                }

                Dropzone.autoDiscover = false;

                const bindDropzoneToInput = (dropzoneId, inputId) => {
                    const target = document.getElementById(dropzoneId);
                    const input = document.getElementById(inputId);

                    if (!target || !input || target.dataset.initialized === '1') {
                        return;
                    }

                    const openFileDialog = () => input.click();
                    target.addEventListener('click', openFileDialog);
                    target.addEventListener('keydown', (event) => {
                        if (event.key === 'Enter' || event.key === ' ') {
                            event.preventDefault();
                            openFileDialog();
                        }
                    });

                    target.dataset.initialized = '1';

                    // Limpia placeholder para que Dropzone renderice su mensaje interno.
                    target.innerHTML = '';

                    const instance = new Dropzone(target, {
                        url: '#',
                        autoProcessQueue: false,
                        uploadMultiple: false,
                        maxFiles: 1,
                        clickable: false,
                        acceptedFiles: 'image/*',
                        addRemoveLinks: true,
                        dictDefaultMessage: 'Arrastra una imagen aqui o haz clic para seleccionar.',
                    });

                    input.addEventListener('change', () => {
                        const file = input.files && input.files[0] ? input.files[0] : null;

                        instance.removeAllFiles(true);

                        if (!file) {
                            return;
                        }

                        instance.addFile(file);
                    });

                    instance.on('addedfile', (file) => {
                        if (instance.files.length > 1) {
                            instance.removeFile(instance.files[0]);
                        }

                        const dt = new DataTransfer();
                        dt.items.add(file);
                        input.files = dt.files;
                    });

                    instance.on('removedfile', () => {
                        input.value = '';
                    });
                };

                bindDropzoneToInput('company-logo-dropzone', 'logo');
                bindDropzoneToInput('company-favicon-dropzone', 'favicon');

                document.querySelectorAll('[data-sync-color]').forEach((picker) => {
                    const targetId = picker.dataset.syncColor;
                    const textInput = document.getElementById(targetId);

                    if (!textInput) {
                        return;
                    }

                    picker.addEventListener('input', () => {
                        textInput.value = picker.value.toLowerCase();
                    });

                    textInput.addEventListener('input', () => {
                        const value = textInput.value.trim().toLowerCase();

                        if (/^#[0-9a-f]{6}$/.test(value)) {
                            picker.value = value;
                        }
                    });
                });

                const applyLogoPaletteButton = document.getElementById('apply-logo-palette');

                if (applyLogoPaletteButton) {
                    applyLogoPaletteButton.addEventListener('click', () => {
                        const palette = {
                            theme_color_primary: applyLogoPaletteButton.dataset.primary,
                            theme_color_secondary: applyLogoPaletteButton.dataset.secondary,
                            theme_color_accent: applyLogoPaletteButton.dataset.accent,
                            theme_color_neutral: applyLogoPaletteButton.dataset.neutral,
                        };

                        Object.entries(palette).forEach(([field, value]) => {
                            if (!value) {
                                return;
                            }

                            const textInput = document.getElementById(field);
                            const picker = document.querySelector(`[data-sync-color="${field}"]`);

                            if (textInput) {
                                textInput.value = value;
                            }

                            if (picker) {
                                picker.value = value;
                            }
                        });

                        const applyRadio = document.getElementById('theme_logo_behavior_apply');

                        if (applyRadio) {
                            applyRadio.checked = true;
                            applyRadio.dispatchEvent(new Event('change', {
                                bubbles: true
                            }));
                        }
                    });
                }

                document.querySelectorAll('input[name="theme_logo_behavior"]').forEach((radio) => {
                    radio.addEventListener('change', () => {
                        document.querySelectorAll('.brand-theme-radio').forEach((card) => card.classList
                            .remove('active'));
                        radio.closest('.brand-theme-radio')?.classList.add('active');
                    });
                });
            });
        </script>
    <?php $__env->stopPush(); ?>
<?php endif; ?>
<?php /**PATH D:\xampp3\htdocs\realestate_dev\resources\views\admin\empresa\partials\form-fields.blade.php ENDPATH**/ ?>