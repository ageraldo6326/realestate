@php
    $isEdit = ($mode ?? 'create') === 'edit';
    $postActual = $post ?? null;
    $currentImage = $postActual && $postActual->foto ? asset(ltrim($postActual->foto, '/')) : null;
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
        margin: 2.4rem 0;
        color: #334155;
        font-weight: 600;
        text-align: center;
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
            <h2 class="h4 mb-2 font-weight-bold">{{ $isEdit ? 'Editar post' : 'Nuevo post' }}</h2>
            <p class="mb-0 text-white-50">Gestiona publicaciones del blog con contenido enriquecido, SEO, estado y una
                imagen destacada desde una vista dedicada.</p>
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
            id="post-form-{{ $mode }}">
            @csrf
            @if ($isEdit)
                @method('PUT')
            @endif

            <div class="row">
                <div class="col-xl-8">
                    <div class="card content-form-panel mb-4">
                        <div class="card-body">
                            <div class="form-group">
                                <label for="titulo" class="content-form-label">Titulo</label>
                                <input type="text"
                                    class="form-control content-form-control @error('titulo') is-invalid @enderror"
                                    id="titulo" name="titulo"
                                    value="{{ old('titulo', optional($postActual)->titulo) }}" maxlength="60" required>
                            </div>

                            <div class="form-group">
                                <label for="ia_instrucciones_post" class="content-form-label">Apoyo IA</label>
                                <input type="text" class="form-control content-form-control"
                                    id="ia_instrucciones_post" maxlength="220"
                                    placeholder="Ej. tono cercano para inversionistas primerizos">
                                <small class="form-text text-muted">Genera una propuesta de contenido y metadescripcion
                                    sin salir del formulario.</small>
                            </div>

                            <div class="form-group">
                                <button type="button" class="btn btn-outline-primary" id="btn-generar-ia-post">
                                    <span id="ia-post-spinner" class="spinner-border spinner-border-sm mr-1 d-none"
                                        role="status" aria-hidden="true"></span>
                                    <span
                                        id="ia-post-label">{{ $isEdit ? 'Regenerar con IA' : 'Generar contenido con IA' }}</span>
                                </button>
                            </div>

                            <div class="form-group mb-0">
                                <label for="contenido-editor" class="content-form-label">Contenido</label>
                                <textarea class="form-control content-form-control @error('contenido') is-invalid @enderror" id="contenido-editor"
                                    name="contenido" rows="12">{{ old('contenido', optional($postActual)->contenido) }}</textarea>
                            </div>
                        </div>
                    </div>

                    <div class="card content-form-panel mb-4">
                        <div class="card-body">
                            <div class="form-group mb-0">
                                <label for="metadescription" class="content-form-label">Meta description</label>
                                <textarea class="form-control content-form-control @error('metadescription') is-invalid @enderror" id="metadescription"
                                    name="metadescription" rows="4">{{ old('metadescription', optional($postActual)->metadescription) }}</textarea>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-4">
                    <div class="card content-form-panel mb-4">
                        <div class="card-body">
                            <label class="content-form-label d-block">Imagen destacada</label>
                            <input type="file" class="d-none" id="foto" name="foto" accept="image/*">
                            <div id="post-dropzone-{{ $mode }}"
                                class="content-dropzone @error('foto') is-invalid @enderror"></div>
                            <small class="form-text text-muted mt-2">La zona amplia facilita revisar rapido si el post
                                ya tiene la portada correcta.</small>
                            @error('foto')
                                <span class="invalid-feedback d-block">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    @if ($currentImage)
                        <div class="content-preview-card mb-4">
                            <div class="small text-muted font-weight-semibold mb-2">Imagen actual</div>
                            <img src="{{ $currentImage }}" alt="Imagen actual del post">
                        </div>
                    @endif

                    <div class="card content-form-panel mb-4">
                        <div class="card-body">
                            <div class="custom-control custom-switch">
                                <input class="custom-control-input" type="checkbox" id="activo" name="activo"
                                    value="1"
                                    {{ old('activo', optional($postActual)->activo ?? false) ? 'checked' : '' }}>
                                <label class="custom-control-label" for="activo">Publicar este post</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="content-submit-row">
                <a href="{{ route('posts.index') }}" class="btn btn-outline-secondary px-4">Cancelar</a>
                <button type="submit" class="btn btn-primary px-4 js-submit-button"
                    data-loading-text="Guardando...">{{ $isEdit ? 'Guardar cambios' : 'Guardar post' }}</button>
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
            const textareaSelector = '#contenido-editor';
            const titleField = document.getElementById('titulo');
            const metaField = document.getElementById('metadescription');
            const instructionsField = document.getElementById('ia_instrucciones_post');
            const button = document.getElementById('btn-generar-ia-post');

            window.AdminCkeditor?.ensure(textareaSelector, (value) => {
                const textarea = document.querySelector(textareaSelector);
                if (textarea) {
                    textarea.value = value;
                }
            });

            const target = document.getElementById('post-dropzone-{{ $mode }}');
            const input = document.getElementById('foto');

            if (target && input && typeof Dropzone !== 'undefined' && target.dataset.initialized !== '1') {
                target.dataset.initialized = '1';

                const dropzone = new Dropzone(target, {
                    url: window.location.href,
                    autoProcessQueue: false,
                    uploadMultiple: false,
                    maxFiles: 1,
                    acceptedFiles: 'image/*',
                    addRemoveLinks: true,
                    dictDefaultMessage: 'Suelta la portada aqui o haz clic para cargarla',
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

                dropzone.on('removedfile', () => syncInput(null));
            }

            const getContent = () => {
                const editor = window.AdminCkeditor?.get(textareaSelector);
                return editor ? editor.getData() : (document.querySelector(textareaSelector)?.value || '');
            };

            const setContent = async (value) => {
                const textarea = document.querySelector(textareaSelector);
                if (textarea) {
                    textarea.value = value || '';
                }
                await window.AdminCkeditor?.setData(textareaSelector, value || '');
            };

            button?.addEventListener('click', async () => {
                const endpoint = '{{ route('admin.ai.generate') }}';
                const csrf = document.querySelector('meta[name="csrf-token"]')?.getAttribute(
                    'content') || '';
                const spinner = document.getElementById('ia-post-spinner');
                const label = document.getElementById('ia-post-label');

                button.disabled = true;
                spinner?.classList.remove('d-none');
                if (label) {
                    label.textContent = 'Generando...';
                }

                try {
                    const response = await fetch(endpoint, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': csrf,
                            'Accept': 'application/json',
                        },
                        body: JSON.stringify({
                            type: 'post',
                            instrucciones: instructionsField?.value || '',
                            contexto: {
                                titulo: titleField?.value || '',
                                contenido_actual: getContent(),
                                metadescription_actual: metaField?.value || '',
                            },
                        }),
                    });

                    const result = await response.json();
                    if (!response.ok || !result.ok) {
                        throw new Error(result.message || 'No fue posible generar contenido.');
                    }

                    const data = result.data || {};

                    if (data.titulo_sugerido && !(titleField?.value || '')) {
                        titleField.value = data.titulo_sugerido;
                    }

                    if (data.descripcion) {
                        await setContent(data.descripcion);
                    }

                    if (data.metadescription && metaField) {
                        metaField.value = data.metadescription;
                    }

                    if (window.Swal) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Contenido generado',
                            text: 'Puedes revisarlo y ajustarlo antes de guardar.',
                            timer: 1800,
                            showConfirmButton: false,
                        });
                    }
                } catch (error) {
                    if (window.Swal) {
                        Swal.fire('Error', error.message || 'No fue posible generar contenido con IA.',
                            'error');
                    }
                } finally {
                    button.disabled = false;
                    spinner?.classList.add('d-none');
                    if (label) {
                        label.textContent =
                            '{{ $isEdit ? 'Regenerar con IA' : 'Generar contenido con IA' }}';
                    }
                }
            });

            const form = document.getElementById('post-form-{{ $mode }}');
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
