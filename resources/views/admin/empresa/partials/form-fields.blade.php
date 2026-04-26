@php
    $company = $inmobiliaria ?? null;
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
            </div>
        </div>

        @if (!is_null($company))
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-body p-4">
                    <h2 class="section-title">Publicacion</h2>
                    <div class="d-flex align-items-center justify-content-between">
                        <label for="aprobacion" class="mb-0 font-weight-bold">Requiere aprobacion</label>
                        <label class="switch mb-0">
                            <input type="checkbox" name="aprobacion" id="aprobacion"
                                @if (optional($company)->aprobacion == 'on') checked @endif>
                            <span class="slider round"></span>
                        </label>
                    </div>
                </div>
            </div>
        @endif

        <div class="card shadow-sm border-0">
            <div class="card-body p-4">
                <input type="submit" class="btn btn-success btn-block" name="submit" id="submit"
                    value="Guardar cambios">
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
                        acceptedFiles: 'image/*',
                        addRemoveLinks: true,
                        dictDefaultMessage: 'Arrastra una imagen aqui o haz clic para seleccionar.',
                    });

                    instance.on('addedfile', (file) => {
                        if (instance.files.length > 1) {
                            instance.removeFile(instance.files[0]);
                        }

                        const dt = new DataTransfer();
                        dt.items.add(file);
                        input.files = dt.files;
                        input.dispatchEvent(new Event('change', {
                            bubbles: true
                        }));
                    });

                    instance.on('removedfile', () => {
                        input.value = '';
                        input.dispatchEvent(new Event('change', {
                            bubbles: true
                        }));
                    });
                };

                bindDropzoneToInput('company-logo-dropzone', 'logo');
                bindDropzoneToInput('company-favicon-dropzone', 'favicon');
            });
        </script>
    @endpush
@endonce
