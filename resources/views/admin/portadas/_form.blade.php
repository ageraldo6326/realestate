@php
    $isEdit = ($mode ?? 'create') === 'edit';
    $portadaActual = $portada ?? null;
    $currentImage = $portadaActual && $portadaActual->foto ? asset(ltrim($portadaActual->foto, '/')) : null;
@endphp

<link rel="stylesheet" href="https://unpkg.com/dropzone@5/dist/min/dropzone.min.css">

<style>
    .content-form-shell {
        display: grid;
        gap: 1rem;
    }

    .content-form-hero {
        background: linear-gradient(135deg, #0f172a 0%, #1d4ed8 55%, #38bdf8 100%);
        border-radius: 1.25rem;
        color: #fff;
        padding: 1.5rem;
        box-shadow: 0 20px 45px rgba(15, 23, 42, 0.18);
    }

    .content-form-panel {
        border: 1px solid #dbe4f0;
        border-radius: 1.25rem;
        box-shadow: 0 14px 28px rgba(15, 23, 42, 0.06);
        overflow: hidden;
    }

    .content-form-panel .card-body {
        padding: 1.5rem;
    }

    .content-form-label {
        font-size: 0.82rem;
        font-weight: 700;
        letter-spacing: 0.04em;
        text-transform: uppercase;
        color: #64748b;
    }

    .content-form-control {
        border-radius: 0.9rem;
        border-color: #cbd5e1;
        min-height: calc(1.5em + 1rem + 2px);
        box-shadow: 0 8px 20px rgba(15, 23, 42, 0.04);
    }

    .ck-editor__editable_inline {
        min-height: 8rem;
    }

    .content-dropzone {
        min-height: 230px;
        border: 2px dashed #93c5fd;
        border-radius: 1rem;
        background: linear-gradient(180deg, #f8fbff 0%, #eef6ff 100%);
        padding: 1rem;
    }

    .content-dropzone.dz-drag-hover,
    .content-dropzone:hover {
        border-color: #2563eb;
        background: #eff6ff;
    }

    .content-dropzone .dz-message {
        margin: 2.5rem 0;
        color: #334155;
        font-weight: 600;
        text-align: center;
    }

    .content-dropzone .dz-preview .dz-image {
        border-radius: 0.85rem;
    }

    .content-preview-card {
        border: 1px solid #dbe4f0;
        border-radius: 1rem;
        padding: 0.85rem;
        background: #fff;
    }

    .content-preview-card img {
        width: 100%;
        max-height: 220px;
        object-fit: cover;
        border-radius: 0.85rem;
        border: 1px solid #dbe4f0;
    }

    .content-submit-row {
        display: flex;
        flex-wrap: wrap;
        gap: 0.75rem;
        justify-content: flex-end;
    }
</style>

<div class="container-fluid px-3">
    <div class="content-form-shell">
        <section class="content-form-hero">
            <h2 class="h4 mb-2 font-weight-bold">{{ $isEdit ? 'Editar portada' : 'Nueva portada' }}</h2>
            <p class="mb-0 text-white-50">Gestiona titulares, descripcion, llamados a la accion e imagen destacada desde
                una vista dedicada.</p>
        </section>

        @if (session('error'))
            <div class="alert alert-danger border-0 shadow-sm rounded-lg mb-0">{{ session('error') }}</div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger border-0 shadow-sm rounded-lg mb-0">
                <div class="font-weight-bold mb-2">Revisa los campos obligatorios.</div>
                <ul class="mb-0 pl-3">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ $action }}" method="POST" enctype="multipart/form-data"
            id="portada-form-{{ $mode }}">
            @csrf
            @if ($isEdit)
                @method('PUT')
            @endif

            <div class="row">
                <div class="col-xl-8">
                    <div class="card content-form-panel mb-4">
                        <div class="card-body">
                            <div class="form-group">
                                <label for="minititulo" class="content-form-label">Mini titulo</label>
                                <input type="text"
                                    class="form-control content-form-control @error('minititulo') is-invalid @enderror"
                                    id="minititulo" name="minititulo"
                                    value="{{ old('minititulo', optional($portadaActual)->minititulo) }}"
                                    maxlength="100" required>
                            </div>

                            <div class="form-group">
                                <label for="titulo" class="content-form-label">Titulo principal</label>
                                <input type="text"
                                    class="form-control content-form-control @error('titulo') is-invalid @enderror"
                                    id="titulo" name="titulo"
                                    value="{{ old('titulo', optional($portadaActual)->titulo) }}" maxlength="100"
                                    required>
                            </div>

                            <div class="form-group mb-0">
                                <label for="portada-descripcion" class="content-form-label">Descripcion</label>
                                <textarea class="form-control content-form-control @error('descripcion') is-invalid @enderror" id="portada-descripcion"
                                    name="descripcion" rows="9">{{ old('descripcion', optional($portadaActual)->descripcion) }}</textarea>
                            </div>
                        </div>
                    </div>

                    <div class="card content-form-panel mb-4">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="enlace1" class="content-form-label">Texto boton 1</label>
                                        <input type="text"
                                            class="form-control content-form-control @error('enlace1') is-invalid @enderror"
                                            id="enlace1" name="enlace1"
                                            value="{{ old('enlace1', optional($portadaActual)->enlace1) }}"
                                            maxlength="100">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="url1" class="content-form-label">Enlace boton 1</label>
                                        <input type="text"
                                            class="form-control content-form-control @error('url1') is-invalid @enderror"
                                            id="url1" name="url1"
                                            value="{{ old('url1', optional($portadaActual)->url1) }}" maxlength="100">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group mb-md-0">
                                        <label for="enlace2" class="content-form-label">Texto boton 2</label>
                                        <input type="text"
                                            class="form-control content-form-control @error('enlace2') is-invalid @enderror"
                                            id="enlace2" name="enlace2"
                                            value="{{ old('enlace2', optional($portadaActual)->enlace2) }}"
                                            maxlength="100">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group mb-0">
                                        <label for="url2" class="content-form-label">Enlace boton 2</label>
                                        <input type="text"
                                            class="form-control content-form-control @error('url2') is-invalid @enderror"
                                            id="url2" name="url2"
                                            value="{{ old('url2', optional($portadaActual)->url2) }}" maxlength="100">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-4">
                    <div class="card content-form-panel mb-4">
                        <div class="card-body">
                            <div class="form-group mb-0">
                                <label class="content-form-label d-block">Imagen principal</label>
                                <input type="file" class="d-none" id="foto" name="foto" accept="image/*">
                                <div id="portada-dropzone-{{ $mode }}"
                                    class="content-dropzone @error('foto') is-invalid @enderror"></div>
                                <small class="form-text text-muted mt-2">Arrastra una imagen o haz clic para
                                    seleccionarla. El area se mantiene grande para revisar rapido el contenido.</small>
                                @error('foto')
                                    <span class="invalid-feedback d-block">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>

                    @if ($currentImage)
                        <div class="content-preview-card mb-4">
                            <div class="small text-muted font-weight-semibold mb-2">Imagen actual</div>
                            <img src="{{ $currentImage }}" alt="Imagen actual de portada">
                        </div>
                    @endif

                    <div class="card content-form-panel mb-4">
                        <div class="card-body">
                            <div class="form-group mb-0">
                                <label for="video" class="content-form-label">Video de YouTube</label>
                                <input type="text"
                                    class="form-control content-form-control @error('video') is-invalid @enderror"
                                    id="video" name="video"
                                    value="{{ old('video', optional($portadaActual)->video) }}" maxlength="100"
                                    placeholder="URL completa o ID del video">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="content-submit-row">
                <a href="{{ route('portadas.index') }}" class="btn btn-outline-secondary px-4">Cancelar</a>
                <button type="submit" class="btn btn-primary px-4 js-submit-button"
                    data-loading-text="Guardando...">{{ $isEdit ? 'Guardar cambios' : 'Guardar portada' }}</button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
    <script>
        window.Dropzone = window.Dropzone || {};
        window.Dropzone.autoDiscover = false;
    </script>
    <script src="https://unpkg.com/dropzone@5/dist/min/dropzone.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const textareaSelector = '#portada-descripcion';
            window.AdminCkeditor?.ensure(textareaSelector, (value) => {
                const textarea = document.querySelector(textareaSelector);
                if (textarea) {
                    textarea.value = value;
                }
            });

            const bindDropzone = (dropzoneId, inputId, message) => {
                const target = document.getElementById(dropzoneId);
                const input = document.getElementById(inputId);

                if (!target || !input || typeof Dropzone === 'undefined' || target.dataset.initialized ===
                    '1') {
                    return;
                }

                target.dataset.initialized = '1';

                const dropzone = new Dropzone(target, {
                    url: window.location.href,
                    autoProcessQueue: false,
                    uploadMultiple: false,
                    maxFiles: 1,
                    acceptedFiles: 'image/*',
                    addRemoveLinks: true,
                    dictDefaultMessage: message,
                });

                const syncInput = (file) => {
                    const transfer = new DataTransfer();
                    if (file) {
                        transfer.items.add(file);
                    }
                    input.files = transfer.files;
                };

                dropzone.on('addedfile', (file) => {
                    if (dropzone.files.length > 1) {
                        dropzone.removeFile(dropzone.files[0]);
                    }
                    syncInput(file);
                });

                dropzone.on('removedfile', () => {
                    syncInput(null);
                });
            };

            bindDropzone('portada-dropzone-{{ $mode }}', 'foto',
                'Suelta la imagen aqui o haz clic para cargar la portada');

            const form = document.getElementById('portada-form-{{ $mode }}');
            const submitButton = form?.querySelector('.js-submit-button');

            form?.addEventListener('submit', async () => {
                const editor = window.AdminCkeditor?.get(textareaSelector);
                const textarea = document.querySelector(textareaSelector);

                if (editor && textarea) {
                    textarea.value = editor.getData();
                }

                if (submitButton) {
                    submitButton.disabled = true;
                    submitButton.textContent = submitButton.dataset.loadingText || 'Guardando...';
                }
            });
        });
    </script>
@endpush
