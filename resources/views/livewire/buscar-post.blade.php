@php
    $resolveImage = function ($value) {
        if (!$value) {
            return null;
        }

        if (is_object($value) && method_exists($value, 'temporaryUrl')) {
            return $value->temporaryUrl();
        }

        return asset('assets/' . ltrim($value, '/'));
    };

    $photoPreview = $resolveImage($foto);
@endphp

<div>
    <style>
        .content-shell { display: grid; gap: 1rem; }
        .content-hero {
            background: linear-gradient(135deg, #0f172a 0%, #1d4ed8 55%, #38bdf8 100%);
            border-radius: 1.25rem;
            color: #fff;
            padding: 1.5rem;
            box-shadow: 0 20px 45px rgba(15, 23, 42, 0.18);
        }
        .content-panel {
            border: 1px solid #dbe4f0;
            border-radius: 1.25rem;
            box-shadow: 0 14px 28px rgba(15, 23, 42, 0.06);
        }
        .content-thumb {
            width: 108px; height: 68px; object-fit: cover; border-radius: 0.75rem; background: #e2e8f0;
        }
        .content-modal .modal-dialog { max-width: 1180px; }
        .media-preview {
            width: 100%; max-width: 340px; border-radius: 1rem; border: 1px solid #dbe4f0; object-fit: cover; background: #f8fafc;
        }
    </style>

    @if (session('status'))
        <div class="alert alert-success border-0 shadow-sm rounded-lg mb-3">{{ session('status') }}</div>
    @endif

    <div class="content-shell">
        <section class="content-hero">
            <h2 class="h4 mb-2 font-weight-bold">Blog / Posts</h2>
            <p class="mb-0 text-white-50">Gestiona el contenido editorial del portal con SEO, imagen destacada y activacion por post.</p>
        </section>

        <section class="card content-panel">
            <div class="card-body p-4">
                <div class="d-flex flex-column flex-lg-row justify-content-between align-items-lg-center mb-4">
                    <div>
                        <h3 class="h5 mb-1">Listado de posts</h3>
                        <p class="text-muted mb-0">Busca por titulo y administra publicaciones desde un solo modal.</p>
                    </div>
                    <button type="button" class="btn btn-primary mt-3 mt-lg-0 px-4" wire:click="clear" data-toggle="modal" data-target="#modalForm">
                        Nuevo post
                    </button>
                </div>

                <div class="row mb-4">
                    <div class="col-lg-8">
                        <label class="small text-muted font-weight-semibold">Buscar</label>
                        <input type="text" class="form-control form-control-lg rounded-lg" wire:model.debounce.350ms="criterio" placeholder="Ej. Inversion, Mercado o ID 8">
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table align-middle mb-0">
                        <thead class="text-uppercase small text-muted">
                            <tr>
                                <th>ID</th>
                                <th>Imagen</th>
                                <th>Titulo</th>
                                <th class="d-none d-md-table-cell">Creado</th>
                                <th class="text-right">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($posts as $post)
                                <tr>
                                    <td class="font-weight-semibold">{{ $post->id }}</td>
                                    <td>@if ($post->foto)<img src="{{ asset('assets/' . $post->foto) }}" class="content-thumb" alt="{{ $post->titulo }}">@endif</td>
                                    <td>{{ $post->titulo }}</td>
                                    <td class="d-none d-md-table-cell text-muted small">{{ $post->created_at }}</td>
                                    <td class="text-right">
                                        <button type="button" class="btn btn-outline-primary btn-sm mr-1" wire:click="edit({{ $post->id }})" data-toggle="modal" data-target="#modalForm">Editar</button>
                                        <button type="button" class="btn btn-outline-danger btn-sm" wire:click="$emit('generarBorrarPostSweetAlert', {{ $post->id }})">Borrar</button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center py-5 text-muted">No hay posts para mostrar.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="mt-4">{{ $posts->links() }}</div>
            </div>
        </section>
    </div>

    <div class="modal fade content-modal" id="modalForm" wire:ignore.self tabindex="-1" data-backdrop="static">
        <div class="modal-dialog modal-dialog-scrollable">
            <div class="modal-content border-0 shadow-lg">
                <div class="modal-header border-0 pb-0 px-4 pt-4">
                    <div>
                        <div class="text-uppercase small text-muted">{{ $Id ? 'Edicion' : 'Nuevo post' }}</div>
                        <h4 class="modal-title mb-0">{{ $Id ? 'Editar post' : 'Registrar post' }}</h4>
                    </div>
                    <button type="button" class="close" wire:click="clear" data-dismiss="modal" aria-label="Cerrar"><span aria-hidden="true">&times;</span></button>
                </div>

                <div class="modal-body px-4 pb-3">
                    @if ($errors->any())
                        <div class="alert alert-danger rounded-lg border-0 shadow-sm">
                            <div class="font-weight-bold mb-1">Revisa los campos requeridos.</div>
                            <ul class="mb-0 pl-3">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <div class="row">
                        <div class="col-xl-8">
                            <div class="card content-panel mb-4">
                                <div class="card-body p-4">
                                    <div class="form-group">
                                        <label>Titulo</label>
                                        <input type="text" class="form-control" wire:model.lazy="titulo" maxlength="60" placeholder="Titulo del post">
                                    </div>
                                    <div class="form-group mb-0" wire:ignore>
                                        <label>Contenido</label>
                                        <textarea class="form-control" id="contenido-post" rows="10">{{ $contenido }}</textarea>
                                    </div>
                                </div>
                            </div>

                            <div class="card content-panel">
                                <div class="card-body p-4">
                                    <div class="form-group mb-3">
                                        <label>Meta description</label>
                                        <textarea class="form-control" wire:model.lazy="metadescription" rows="3" placeholder="Resumen SEO del contenido"></textarea>
                                    </div>
                                    <div class="form-group mb-0">
                                        <label>Activo</label>
                                        <div class="custom-control custom-switch mt-2">
                                            <input class="custom-control-input" type="checkbox" id="postActivo" wire:model.lazy="activo">
                                            <label class="custom-control-label" for="postActivo">Publicacion activa</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-4">
                            <div class="card content-panel">
                                <div class="card-body p-4" x-data="{ isUploading: false, progress: 0 }"
                                    x-on:livewire-upload-start="isUploading = true"
                                    x-on:livewire-upload-finish="isUploading = false"
                                    x-on:livewire-upload-error="isUploading = false"
                                    x-on:livewire-upload-progress="progress = $event.detail.progress">
                                    <h5 class="mb-3">Imagen destacada</h5>
                                    <input type="file" class="form-control-file mb-3" wire:model="foto" accept="image/*">
                                    @error('foto')
                                        <span class="text-danger d-block mb-2">{{ $message }}</span>
                                    @enderror
                                    <div x-show="isUploading" class="mb-3">
                                        <div class="small text-muted mb-1" x-text="'Subiendo: ' + progress + '%' "></div>
                                        <div class="progress" style="height: 8px;">
                                            <div class="progress-bar" role="progressbar" x-bind:style="`width: ${progress}%`"></div>
                                        </div>
                                    </div>
                                    @if ($photoPreview)
                                        <img class="media-preview mb-3" src="{{ $photoPreview }}" alt="Imagen post">
                                        <div>
                                            <button type="button" class="btn btn-sm btn-outline-danger" wire:click="borrar_foto">Quitar imagen</button>
                                        </div>
                                    @else
                                        <div class="text-muted small">Sin imagen seleccionada.</div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer border-0 px-4 pb-4 pt-0">
                    <button type="button" class="btn btn-light px-4" wire:click="clear" data-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-primary px-4" @if ($Id == 0) wire:click.prevent="store" @else wire:click.prevent="update({{ $Id }})" @endif>
                        {{ $Id ? 'Actualizar post' : 'Guardar post' }}
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('livewire:load', () => {
            const selector = '#contenido-post';
            const ensurePostEditor = () => window.AdminCkeditor?.ensure(selector, (value) => {
                @this.set('contenido', value);
            });

            ensurePostEditor();

            window.livewire.on('editarContenido', (value) => {
                window.AdminCkeditor?.setData(selector, value || '');
            });

            window.livewire.on('limpiarContenido', () => {
                window.AdminCkeditor?.clear(selector);
            });

            window.addEventListener('close-modal', () => {
                $('#modalForm').modal('hide');
            });

            $('#modalForm').on('shown.bs.modal', () => {
                ensurePostEditor();
            });
        });
    </script>
</div>
