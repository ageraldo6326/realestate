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

    $coverPreview = $resolveImage($foto);
    $videoPreview = $video ? 'https://www.youtube.com/embed/' . $video : null;
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
            width: 108px;
            height: 68px;
            object-fit: cover;
            border-radius: 0.75rem;
            background: #e2e8f0;
        }
        .content-modal .modal-dialog { max-width: 1180px; }
        .media-preview {
            width: 100%;
            max-width: 340px;
            border-radius: 1rem;
            border: 1px solid #dbe4f0;
            object-fit: cover;
            background: #f8fafc;
        }
    </style>

    @if (session('status'))
        <div class="alert alert-success border-0 shadow-sm rounded-lg mb-3">{{ session('status') }}</div>
    @endif

    <div class="content-shell">
        <section class="content-hero">
            <h2 class="h4 mb-2 font-weight-bold">Portadas del portal</h2>
            <p class="mb-0 text-white-50">Administra el contenido principal de la home con titulo, descripcion, llamada a la accion e imagen destacada.</p>
        </section>

        <section class="card content-panel">
            <div class="card-body p-4">
                <div class="d-flex flex-column flex-lg-row justify-content-between align-items-lg-center mb-4">
                    <div>
                        <h3 class="h5 mb-1">Listado de portadas</h3>
                        <p class="text-muted mb-0">Busca por titulo y edita cada portada sin salir del listado.</p>
                    </div>
                    <button type="button" class="btn btn-primary mt-3 mt-lg-0 px-4" wire:click="clear" data-toggle="modal" data-target="#modalForm">
                        Nueva portada
                    </button>
                </div>

                <div class="row mb-4">
                    <div class="col-lg-8">
                        <label class="small text-muted font-weight-semibold">Buscar</label>
                        <input type="text" class="form-control form-control-lg rounded-lg" wire:model.debounce.350ms="criterio" placeholder="Ej. Inversion, Inicio o ID 4">
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table align-middle mb-0">
                        <thead class="text-uppercase small text-muted">
                            <tr>
                                <th>ID</th>
                                <th>Imagen</th>
                                <th>Titulo</th>
                                <th class="text-right">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($portadas as $portada)
                                <tr>
                                    <td class="font-weight-semibold">{{ $portada->id }}</td>
                                    <td>
                                        <img src="{{ asset('assets/' . $portada->foto) }}" class="content-thumb" alt="{{ $portada->titulo }}">
                                    </td>
                                    <td>{{ $portada->titulo }}</td>
                                    <td class="text-right">
                                        <button type="button" class="btn btn-outline-primary btn-sm mr-1" wire:click="edit({{ $portada->id }})" data-toggle="modal" data-target="#modalForm">Editar</button>
                                        <button type="button" class="btn btn-outline-danger btn-sm" wire:click="$emit('generarBorrarPortadaSweetAlert', {{ $portada->id }})">Borrar</button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center py-5 text-muted">No hay portadas para mostrar.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="mt-4">{{ $portadas->links() }}</div>
            </div>
        </section>
    </div>

    <div class="modal fade content-modal" id="modalForm" wire:ignore.self tabindex="-1" data-backdrop="static">
        <div class="modal-dialog modal-dialog-scrollable">
            <div class="modal-content border-0 shadow-lg">
                <div class="modal-header border-0 pb-0 px-4 pt-4">
                    <div>
                        <div class="text-uppercase small text-muted">{{ $Id ? 'Edicion' : 'Nueva portada' }}</div>
                        <h4 class="modal-title mb-0">{{ $Id ? 'Editar portada' : 'Registrar portada' }}</h4>
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
                        <div class="col-xl-7">
                            <div class="card content-panel mb-4">
                                <div class="card-body p-4">
                                    <div class="form-group">
                                        <label>Mini titulo</label>
                                        <input type="text" class="form-control" wire:model.lazy="minititulo" maxlength="60" placeholder="Texto breve superior">
                                    </div>
                                    <div class="form-group">
                                        <label>Titulo principal</label>
                                        <input type="text" class="form-control" wire:model.lazy="titulo" maxlength="60" placeholder="Titulo principal de portada">
                                    </div>
                                    <div class="form-group mb-0" wire:ignore>
                                        <label>Descripcion</label>
                                        <textarea class="form-control" id="descripcion-portada" rows="8">{{ $descripcion }}</textarea>
                                    </div>
                                </div>
                            </div>

                            <div class="card content-panel">
                                <div class="card-body p-4">
                                    <h5 class="mb-3">Llamados a la accion</h5>
                                    <div class="form-group">
                                        <label>Texto del boton</label>
                                        <input type="text" maxlength="100" class="form-control" wire:model.lazy="enlace1" placeholder="Escriba el texto del boton">
                                    </div>
                                    <div class="form-group mb-0">
                                        <label>Enlace del boton</label>
                                        <input type="text" maxlength="100" class="form-control" wire:model.lazy="url1" placeholder="https://... o /ruta-interna">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-5">
                            <div class="card content-panel mb-4">
                                <div class="card-body p-4" x-data="{ isUploading: false, progress: 0 }"
                                    x-on:livewire-upload-start="isUploading = true"
                                    x-on:livewire-upload-finish="isUploading = false"
                                    x-on:livewire-upload-error="isUploading = false"
                                    x-on:livewire-upload-progress="progress = $event.detail.progress">
                                    <h5 class="mb-3">Imagen principal</h5>
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
                                    @if ($coverPreview)
                                        <img class="media-preview mb-3" src="{{ $coverPreview }}" alt="Preview portada">
                                        <div>
                                            <button type="button" class="btn btn-sm btn-outline-danger" wire:click="borrar_foto">Quitar imagen</button>
                                        </div>
                                    @else
                                        <div class="text-muted small">Sin imagen seleccionada.</div>
                                    @endif
                                </div>
                            </div>

                            <div class="card content-panel">
                                <div class="card-body p-4">
                                    <h5 class="mb-3">Video</h5>
                                    <div class="form-group">
                                        <label>ID de video de YouTube</label>
                                        <input class="form-control" maxlength="100" type="text" wire:model.lazy="video" placeholder="Ej. dQw4w9WgXcQ">
                                    </div>
                                    @if ($videoPreview)
                                        <div class="embed-responsive embed-responsive-16by9 rounded-lg overflow-hidden shadow-sm">
                                            <iframe class="embed-responsive-item" src="{{ $videoPreview }}" allowfullscreen></iframe>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer border-0 px-4 pb-4 pt-0">
                    <button type="button" class="btn btn-light px-4" wire:click="clear" data-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-primary px-4" @if ($Id == 0) wire:click.prevent="store" @else wire:click.prevent="update({{ $Id }})" @endif>
                        {{ $Id ? 'Actualizar portada' : 'Guardar portada' }}
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('livewire:load', () => {
            const selector = '#descripcion-portada';
            const ensurePortadaEditor = () => window.AdminCkeditor?.ensure(selector, (value) => {
                @this.set('descripcion', value);
            });

            ensurePortadaEditor();

            window.livewire.on('editarDescripcion', (value) => {
                window.AdminCkeditor?.setData(selector, value || '');
            });

            window.livewire.on('limpiarDescripcion', () => {
                window.AdminCkeditor?.clear(selector);
            });

            window.addEventListener('close-modal', () => {
                $('#modalForm').modal('hide');
            });

            $('#modalForm').on('shown.bs.modal', () => {
                ensurePortadaEditor();
            });
        });
    </script>
</div>
