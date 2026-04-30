@php
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
@endphp

<link rel="stylesheet" href="https://unpkg.com/dropzone@5/dist/min/dropzone.min.css">

<div class="row g-4">
    <div class="col-xl-8">
        <div class="card shadow-sm border-0 mb-4">
            <div class="card-body p-4">
                <h2 class="section-title">Informacion general</h2>

                <div class="row">
                    <div class="col-md-6 form-group mb-3">
                        <label for="nombre" class="font-weight-bold">Nombre <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('nombre') is-invalid @enderror" id="nombre"
                            name="nombre" placeholder="Nombre comercial"
                            value="{{ old('nombre', optional($company)->nombre) }}" required>
                    </div>

                    <div class="col-md-6 form-group mb-3">
                        <label for="correo" class="font-weight-bold">Correo <span class="text-danger">*</span></label>
                        <input type="email" class="form-control @error('correo') is-invalid @enderror" id="correo"
                            name="correo" placeholder="correo@empresa.com"
                            value="{{ old('correo', optional($company)->correo) }}" required>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 form-group mb-3">
                        <label for="telefono" class="font-weight-bold">Telefono <span
                                class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('telefono') is-invalid @enderror"
                            id="telefono" name="telefono" placeholder="Telefono principal"
                            value="{{ old('telefono', optional($company)->telefono) }}" required>
                    </div>

                    <div class="col-md-6 form-group mb-3">
                        <label for="titulo" class="font-weight-bold">Titulo del sitio</label>
                        <input type="text" class="form-control @error('titulo') is-invalid @enderror" id="titulo"
                            name="titulo" placeholder="Titulo para encabezado y SEO"
                            value="{{ old('titulo', optional($company)->titulo) }}">
                    </div>
                </div>

                <div class="form-group mb-3">
                    <label for="direccion" class="font-weight-bold">Direccion <span class="text-danger">*</span></label>
                    <textarea class="form-control @error('direccion') is-invalid @enderror" id="direccion" name="direccion" rows="3"
                        required>{{ old('direccion', optional($company)->direccion) }}</textarea>
                </div>

                <div class="form-group mb-3">
                    <label for="quienessomos" class="font-weight-bold">Quienes somos</label>
                    <textarea class="form-control @error('quienessomos') is-invalid @enderror" id="quienessomos" name="quienessomos"
                        rows="5">{{ old('quienessomos', optional($company)->quienessomos) }}</textarea>
                </div>

                <div class="form-group mb-0">
                    <label for="metadescription" class="font-weight-bold">Meta Description</label>
                    <textarea class="form-control @error('metadescription') is-invalid @enderror" id="metadescription"
                        name="metadescription" rows="3">{{ old('metadescription', optional($company)->metadescription) }}</textarea>
                </div>
            </div>
        </div>

        <div class="card shadow-sm border-0 mb-4">
            <div class="card-body p-4">
                <h2 class="section-title">Redes y contacto</h2>

                <div class="row">
                    <div class="col-md-6 form-group mb-3">
                        <label for="facebook" class="font-weight-bold">Facebook</label>
                        <input type="text" class="form-control @error('facebook') is-invalid @enderror"
                            id="facebook" name="facebook" placeholder="https://facebook.com/..."
                            value="{{ old('facebook', optional($company)->facebook) }}">
                    </div>

                    <div class="col-md-6 form-group mb-3">
                        <label for="instagram" class="font-weight-bold">Instagram</label>
                        <input type="text" class="form-control @error('instagram') is-invalid @enderror"
                            id="instagram" name="instagram" placeholder="https://instagram.com/..."
                            value="{{ old('instagram', optional($company)->instagram) }}">
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 form-group mb-3">
                        <label for="tiktok" class="font-weight-bold">TikTok</label>
                        <input type="text" class="form-control @error('tiktok') is-invalid @enderror" id="tiktok"
                            name="tiktok" placeholder="https://tiktok.com/..."
                            value="{{ old('tiktok', optional($company)->tiktok) }}">
                    </div>

                    <div class="col-md-6 form-group mb-0">
                        <label for="whatsapp" class="font-weight-bold">WhatsApp</label>
                        <input type="text" class="form-control @error('whatsapp') is-invalid @enderror"
                            id="whatsapp" name="whatsapp" placeholder="Ej: 8090000000"
                            value="{{ old('whatsapp', optional($company)->whatsapp) }}">
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
                    <span class="brand-theme-chip">{{ $themeSourceLabel }}</span>
                </div>

                <div class="brand-status-list mb-4">
                    <div class="brand-status-item">
                        <div>
                            <strong>Paleta activa</strong>
                            <small class="d-block text-muted">Aplicada en inicio, propiedades, agentes, quienes somos,
                                novedades y contacto.</small>
                        </div>
                        <div class="d-flex align-items-center">
                            @foreach ($themeFields as $field => $label)
                                <span class="rounded-circle border ml-2" title="{{ $label }}"
                                    style="width:22px;height:22px;background:{{ old($field, $currentTheme[$field]) }};"></span>
                            @endforeach
                        </div>
                    </div>
                    <div class="brand-status-item">
                        <div>
                            <strong>Version anterior</strong>
                            <small
                                class="d-block text-muted">{{ $hasPreviousTheme ? 'Disponible para restaurar.' : 'Aun no existe historial previo guardado.' }}</small>
                        </div>
                        <span
                            class="badge badge-{{ $hasPreviousTheme ? 'success' : 'secondary' }}">{{ $hasPreviousTheme ? 'Disponible' : 'Sin historial' }}</span>
                    </div>
                </div>

                <h3 class="h6 font-weight-bold mb-3">Colores detectados del logo</h3>
                @if ($logoPalette)
                    <div class="brand-swatch-grid mb-4">
                        @foreach ($logoPalette as $index => $color)
                            <div class="brand-swatch-card">
                                <div class="brand-swatch-preview" style="background: {{ $color }};"></div>
                                <div class="brand-swatch-meta">
                                    <span class="brand-swatch-label">Logo {{ $index + 1 }}</span>
                                    <span class="brand-swatch-value">{{ strtoupper($color) }}</span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="alert alert-light border mb-4">Aun no hay colores detectados del logo. Se guardaran
                        automaticamente cuando subas o reemplaces el logo.</div>
                @endif

                <div class="d-flex justify-content-end mb-4">
                    <button type="button" class="btn btn-outline-primary btn-sm" id="apply-logo-palette"
                        @if (!$logoSuggestedTheme) disabled @endif
                        @if ($logoSuggestedTheme) data-primary="{{ $logoSuggestedTheme['theme_color_primary'] }}"
                            data-secondary="{{ $logoSuggestedTheme['theme_color_secondary'] }}"
                            data-accent="{{ $logoSuggestedTheme['theme_color_accent'] }}"
                            data-neutral="{{ $logoSuggestedTheme['theme_color_neutral'] }}" @endif>
                        Usar sugerencia del logo
                    </button>
                </div>

                <div class="row">
                    @foreach ($themeFields as $field => $label)
                        <div class="col-md-6 form-group mb-3">
                            <label for="{{ $field }}" class="font-weight-bold">{{ $label }}</label>
                            <div class="brand-color-input">
                                <input type="color" value="{{ old($field, $currentTheme[$field]) }}"
                                    data-sync-color="{{ $field }}">
                                <input type="text" class="form-control @error($field) is-invalid @enderror"
                                    id="{{ $field }}" name="{{ $field }}" maxlength="7"
                                    value="{{ old($field, $currentTheme[$field]) }}">
                            </div>
                            @error($field)
                                <span class="invalid-feedback d-block">{{ $message }}</span>
                            @enderror
                        </div>
                    @endforeach
                </div>

                <div class="alert alert-light border mb-0">
                    <strong>Default actual:</strong>
                    <span class="d-block mt-1">Primario {{ strtoupper($defaultTheme['theme_color_primary']) }},
                        Secundario {{ strtoupper($defaultTheme['theme_color_secondary']) }}, Acento
                        {{ strtoupper($defaultTheme['theme_color_accent']) }}, Neutro
                        {{ strtoupper($defaultTheme['theme_color_neutral']) }}.</span>
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
                    <input class="d-none @error('logo') is-invalid @enderror" type="file" id="logo"
                        name="logo" accept="image/*">
                </div>

                @if (optional($company)->logo)
                    <div class="preview-box mb-3">
                        <span class="preview-label">Logo actual</span>
                        <img src="{{ $company->logo }}" class="img-fluid rounded" alt="Logo de empresa">
                    </div>
                @endif

                <div class="form-group mb-3">
                    <label for="favicon" class="font-weight-bold">Favicon</label>
                    <div id="company-favicon-dropzone" class="company-dropzone" role="button" tabindex="0"
                        aria-label="Cargar favicon">
                        <div class="company-dropzone-placeholder">
                            Arrastra el favicon aqui o haz clic para seleccionar.
                        </div>
                    </div>
                    <input class="d-none @error('favicon') is-invalid @enderror" type="file" id="favicon"
                        name="favicon" accept="image/*">
                </div>

                @if (optional($company)->favicon)
                    <div class="preview-box">
                        <span class="preview-label">Favicon actual</span>
                        <img src="{{ $company->favicon }}" class="img-fluid rounded" alt="Favicon de empresa">
                    </div>
                @endif

                <hr>

                <h3 class="h6 font-weight-bold mb-3">Si subes un logo nuevo</h3>
                <label class="brand-theme-radio {{ $logoBehavior === 'keep_current' ? 'active' : '' }} mb-3"
                    for="theme_logo_behavior_keep">
                    <div class="custom-control custom-radio">
                        <input class="custom-control-input" type="radio" name="theme_logo_behavior"
                            id="theme_logo_behavior_keep" value="keep_current" @checked($logoBehavior === 'keep_current')>
                        <span class="custom-control-label font-weight-bold">Mantener colores actuales</span>
                    </div>
                    <div class="brand-muted mt-2">Se actualizan solo los colores sugeridos del logo, sin tocar la
                        paleta activa.</div>
                </label>

                <label class="brand-theme-radio {{ $logoBehavior === 'apply_logo_palette' ? 'active' : '' }} mb-0"
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
                        @if ($company) formaction="{{ route('inmobiliaria.restore-default', $company->id) }}" @endif
                        formmethod="POST" formnovalidate data-skip-loading="1" @disabled(!$company)>
                        Volver a default
                    </button>

                    <button type="submit" class="btn btn-outline-primary btn-block"
                        @if ($company) formaction="{{ route('inmobiliaria.restore-previous', $company->id) }}" @endif
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
                            value="1" @if ((bool) old('aprobacion', optional($company)->aprobacion ?? true)) checked @endif>
                        <label for="aprobacion" class="custom-control-label"></label>
                    </div>
                </div>
            </div>
        </div>

        <div class="card shadow-sm border-0">
            <div class="card-body p-4">
                <button type="submit" class="btn btn-success btn-block" id="submit"
                    data-loading-text="Guardando configuracion...">
                    {{ $submitLabel }}
                </button>
            </div>
        </div>
    </div>
</div>

@once
    @push('scripts')
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
    @endpush
@endonce
