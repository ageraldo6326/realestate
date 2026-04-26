@php
    $resolveAvatar = function ($foto) {
        if (!$foto) {
            return asset('vendor/adminlte/dist/img/AdminLTELogo.png');
        }

        if (\Illuminate\Support\Str::startsWith($foto, ['http://', 'https://', '//', 'data:'])) {
            return $foto;
        }

        return asset('assets/' . ltrim($foto, '/'));
    };

    $isCurrentPhotoUpload = $foto && !is_string($foto);
@endphp

<div>
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
        }

        .users-avatar {
            width: 42px;
            height: 42px;
            object-fit: cover;
            border-radius: 999px;
            border: 2px solid #e2e8f0;
        }

        .users-modal .modal-dialog {
            max-width: 1100px;
        }

        .users-upload-preview {
            width: 100%;
            max-width: 260px;
            aspect-ratio: 1 / 1;
            object-fit: cover;
            border-radius: 1rem;
            border: 1px solid #dbe4f0;
            background: #f8fafc;
        }

        .users-switch-wrap {
            background: #f8fafc;
            border: 1px solid #dbe4f0;
            border-radius: 0.8rem;
            padding: 0.75rem 1rem;
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
    </style>

    @if (session('status'))
        <div class="alert alert-success border-0 shadow-sm rounded-lg mb-3">
            {{ session('status') }}
        </div>
    @endif

    <div class="users-shell">
        <section class="users-hero">
            <div class="row align-items-end">
                <div class="col-lg-8 mb-3 mb-lg-0">
                    <span class="badge badge-light text-primary px-3 py-2 rounded-pill mb-3">Configuracion del CRM</span>
                    <h2 class="h3 font-weight-bold mb-2">Gestion de usuarios con panel modernizado y flujo de edicion
                        unificado.</h2>
                    <p class="mb-0 text-white-50">Filtra por nombre o ID, revisa estado y edita perfil, rol, visibilidad
                        y credenciales desde un solo modal.</p>
                </div>
                <div class="col-lg-4">
                    <div class="users-stat">
                        <div class="text-uppercase small text-white-50">Usuarios encontrados</div>
                        <div class="h3 mb-0 font-weight-bold">{{ $usuarios->total() }}</div>
                    </div>
                </div>
            </div>
        </section>

        <section class="card users-panel">
            <div class="card-body p-4">
                <div class="d-flex flex-column flex-lg-row justify-content-between align-items-lg-center mb-4">
                    <div>
                        <h3 class="h5 mb-1">Listado de usuarios</h3>
                        <p class="text-muted mb-0">La edicion se realiza en modal para mantener el contexto de busqueda.
                        </p>
                    </div>
                    <button type="button" class="btn btn-primary mt-3 mt-lg-0 px-4" wire:click="clear"
                        data-toggle="modal" data-target="#modalForm">
                        Nuevo usuario
                    </button>
                </div>

                <div class="row mb-4">
                    <div class="col-lg-8">
                        <label class="small text-muted font-weight-semibold">Buscar usuario</label>
                        <input id="user-search-input" name="user_search_filter" type="search"
                            class="form-control form-control-lg rounded-lg" wire:model.debounce.350ms="criterio"
                            placeholder="Ej. Maria Perez o ID 25" autocomplete="new-password" autocorrect="off"
                            autocapitalize="off" spellcheck="false" readonly
                            onfocus="this.removeAttribute('readonly');">
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table align-middle mb-0">
                        <thead class="text-uppercase small text-muted">
                            <tr>
                                <th>Usuario</th>
                                <th class="d-none d-md-table-cell">Contacto</th>
                                <th class="d-none d-lg-table-cell">Estado</th>
                                <th class="text-right">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($usuarios as $usuario)
                                @php
                                    $userIsAdmin = (int) $usuario->rol === 1;
                                @endphp
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <img src="{{ $resolveAvatar($usuario->foto) }}" alt="{{ $usuario->name }}"
                                                class="users-avatar mr-3">
                                            <div>
                                                <div class="font-weight-bold">{{ $usuario->name }}</div>
                                                <div class="small text-muted">ID: {{ $usuario->id }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="d-none d-md-table-cell">
                                        <div class="font-weight-semibold">{{ $usuario->email ?: 'Sin correo' }}</div>
                                        <div class="small text-muted">{{ $usuario->telefono ?: 'Sin telefono' }}</div>
                                    </td>
                                    <td class="d-none d-lg-table-cell">
                                        <span
                                            class="badge badge-pill {{ (int) $usuario->activo === 1 ? 'badge-success' : 'badge-secondary' }} mr-2">
                                            {{ (int) $usuario->activo === 1 ? 'Activo' : 'Inactivo' }}
                                        </span>
                                        <span
                                            class="badge badge-pill {{ $userIsAdmin ? 'badge-info' : 'badge-light' }}">
                                            {{ $userIsAdmin ? 'Administrador' : 'Asesor' }}
                                        </span>
                                    </td>
                                    <td class="text-right">
                                        <div class="d-flex justify-content-end">
                                            <button type="button" class="btn btn-outline-primary btn-sm mr-1"
                                                wire:click="edit({{ $usuario->id }})" data-toggle="modal"
                                                data-target="#modalForm">
                                                Editar
                                            </button>
                                            <button type="button" class="btn btn-outline-danger btn-sm"
                                                wire:click="$emit('generarBorrarUsuarioSweetAlert', {{ $usuario->id }})"
                                                data-element-id="{{ $usuario->id }}">
                                                Borrar
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center py-5 text-muted">
                                        No hay usuarios para mostrar con el criterio actual.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="mt-4">
                    {{ $usuarios->links() }}
                </div>
            </div>
        </section>
    </div>

    <div class="modal fade users-modal" id="modalForm" wire:ignore.self tabindex="-1" data-backdrop="static">
        <div class="modal-dialog modal-dialog-scrollable">
            <div class="modal-content border-0 shadow-lg">
                <div class="modal-header border-0 pb-0 px-4 pt-4">
                    <div>
                        <div class="text-uppercase small text-muted">{{ $Id ? 'Edicion de usuario' : 'Nuevo usuario' }}
                        </div>
                        <h4 class="modal-title mb-0">{{ $Id ? $name : 'Registrar usuario' }}</h4>
                    </div>
                    <button type="button" class="close" wire:click="clear" data-dismiss="modal" aria-label="Cerrar">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body px-4 pb-3" autocomplete="off">
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
                            <div class="card users-panel mb-4">
                                <div class="card-body p-4">
                                    <div class="form-row">
                                        <div class="form-group col-md-6">
                                            <label>Nombre</label>
                                            <input type="text" class="form-control" wire:model.lazy="name"
                                                autocomplete="off" @if ($Id) disabled @endif
                                                placeholder="Nombre completo">
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label>Correo</label>
                                            <input type="email" class="form-control" wire:model.lazy="email"
                                                autocomplete="off" @if ($Id) disabled @endif
                                                placeholder="correo@empresa.com">
                                        </div>
                                    </div>

                                    <div class="form-row">
                                        <div class="form-group col-md-6">
                                            <label>Titulo o cargo</label>
                                            <input type="text" class="form-control" wire:model.lazy="titulo"
                                                maxlength="60" placeholder="Ej. Asesor senior">
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label>* Telefono</label>
                                            <input type="text" class="form-control" wire:model.lazy="telefono"
                                                maxlength="255" placeholder="Telefono de contacto">
                                        </div>
                                    </div>

                                    <div class="form-group" wire:ignore>
                                        <label>* Descripcion</label>
                                        <textarea class="form-control" rows="4" id="descripcion-usuario"></textarea>
                                    </div>

                                    <div class="form-group">
                                        <label>Meta description</label>
                                        <textarea class="form-control" wire:model.lazy="metadescription" rows="3" maxlength="120"
                                            placeholder="Resumen breve para SEO."></textarea>
                                    </div>

                                    <div class="form-row">
                                        <div class="form-group col-md-6">
                                            <label>Facebook</label>
                                            <input type="text" class="form-control" wire:model.lazy="facebook"
                                                maxlength="255" placeholder="URL o usuario">
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label>Instagram</label>
                                            <input type="text" class="form-control" wire:model.lazy="instagram"
                                                maxlength="255" placeholder="URL o usuario">
                                        </div>
                                    </div>

                                    <div class="form-row">
                                        <div class="form-group col-md-6">
                                            <label>Whatsapp</label>
                                            <input type="text" class="form-control" wire:model.lazy="whatsapp"
                                                maxlength="255" placeholder="Numero o enlace">
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label>Tiktok</label>
                                            <input type="text" class="form-control" wire:model.lazy="tiktok"
                                                maxlength="255" placeholder="URL o usuario">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="card users-panel mb-4">
                                <div class="card-body p-4">
                                    <h5 class="mb-3">Acceso y seguridad</h5>

                                    <div class="form-row">
                                        <div class="form-group col-md-6">
                                            <label>Rol</label>
                                            <div class="d-flex">
                                                <div class="custom-control custom-radio mr-4">
                                                    <input class="custom-control-input" type="radio" id="rolAsesor"
                                                        wire:model.lazy="rol" value="0">
                                                    <label class="custom-control-label" for="rolAsesor">Asesor</label>
                                                </div>
                                                <div class="custom-control custom-radio">
                                                    <input class="custom-control-input" type="radio" id="rolAdmin"
                                                        wire:model.lazy="rol" value="1">
                                                    <label class="custom-control-label"
                                                        for="rolAdmin">Administrador</label>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group col-md-6">
                                            <label>Visibilidad</label>
                                            <div class="d-flex">
                                                <div class="custom-control custom-radio mr-4">
                                                    <input class="custom-control-input" type="radio" id="mostrarSi"
                                                        wire:model.lazy="mostrar" value="1">
                                                    <label class="custom-control-label"
                                                        for="mostrarSi">Mostrar</label>
                                                </div>
                                                <div class="custom-control custom-radio">
                                                    <input class="custom-control-input" type="radio" id="mostrarNo"
                                                        wire:model.lazy="mostrar" value="0">
                                                    <label class="custom-control-label" for="mostrarNo">No
                                                        mostrar</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-row">
                                        <div class="form-group col-md-6">
                                            <label>Orden</label>
                                            <input class="form-control" type="number" wire:model.lazy="orden">
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label>Estado</label>
                                            <div class="users-switch-wrap">
                                                <div class="custom-control custom-switch">
                                                    <input class="custom-control-input" type="checkbox"
                                                        id="activoSwitch" wire:model.lazy="activo" value="1">
                                                    <label class="custom-control-label" for="activoSwitch">Usuario
                                                        activo</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-row">
                                        <div class="form-group col-md-6">
                                            <label>{{ $Id ? 'Nueva clave' : '* Clave inicial' }}</label>
                                            <input type="password" autocomplete="off" wire:model="new_password"
                                                class="form-control @error('new_password') is-invalid @enderror"
                                                placeholder="{{ $Id ? 'Nueva clave (opcional)' : 'Clave temporal' }}">
                                            @error('new_password')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label>Confirmar clave</label>
                                            <input wire:model="new_password_confirmation" autocomplete="off"
                                                type="password" class="form-control"
                                                placeholder="Confirmar nueva clave">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-4">
                            <div class="card users-panel mb-4">
                                <div class="card-body p-4" x-data="{ isUploading: false, progress: 0 }"
                                    x-on:livewire-upload-start="isUploading = true"
                                    x-on:livewire-upload-finish="isUploading = false"
                                    x-on:livewire-upload-error="isUploading = false"
                                    x-on:livewire-upload-progress="progress = $event.detail.progress">

                                    <h5 class="mb-3">Foto de perfil</h5>

                                    <div class="form-group mb-2">
                                        <div id="user-modal-dropzone" class="users-dropzone"></div>
                                        <input type="file" id="user-modal-photo-input" class="d-none"
                                            wire:model="foto" accept="image/*">
                                        @error('foto')
                                            <span class="text-danger d-block">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div x-show="isUploading" class="mb-3">
                                        <div class="small text-muted mb-1"
                                            x-text="'Subiendo: ' + progress + '%'\"></div>
                                        <div class="progress"
                                            style="height: 8px;">
                                            <div class="progress-bar" role="progressbar"
                                                x-bind:style="`width: ${progress}%`"></div>
                                        </div>
                                    </div>

                                    @if ($foto)
                                        @if ($isCurrentPhotoUpload)
                                            <img class="users-upload-preview mb-3" src="{{ $foto->temporaryUrl() }}"
                                                alt="Preview">
                                        @else
                                            <img class="users-upload-preview mb-3" src="{{ $resolveAvatar($foto) }}"
                                                alt="Foto actual">
                                        @endif

                                        <button type="button" class="btn btn-sm btn-outline-danger"
                                            wire:click="borrar_foto">
                                            Quitar foto
                                        </button>
                                    @else
                                        <div class="text-muted small">Sin foto cargada.</div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer border-0 px-4 pb-4 pt-0">
                    <button type="button" class="btn btn-light px-4" wire:click="clear" data-dismiss="modal">
                        Cancelar
                    </button>
                    <button type="button" class="btn btn-primary px-4" wire:loading.attr="disabled"
                        @if ($Id == 0) wire:click.prevent="store" @else wire:click.prevent="update({{ $Id }})" @endif>
                        <span wire:loading.remove
                            wire:target="store,update">{{ $Id ? 'Actualizar usuario' : 'Guardar usuario' }}</span>
                        <span wire:loading wire:target="store,update">Guardando...</span>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
        window.Dropzone = window.Dropzone || {};
        window.Dropzone.autoDiscover = false;
    </script>
    <script src="https://unpkg.com/dropzone@5/dist/min/dropzone.min.js"></script>
    <script>
        let userDescriptionEditor;
        let userPhotoDropzone;

        const ensureUserDescriptionEditor = () => {
            userDescriptionEditor = window.AdminCkeditor?.get('#descripcion-usuario') || userDescriptionEditor;

            if (userDescriptionEditor) {
                return;
            }

            window.AdminCkeditor?.ensure('#descripcion-usuario', (value) => {
                @this.set('descripcion', value);
            }).then((editor) => {
                if (editor) {
                    userDescriptionEditor = editor;
                }
            });
        };

        const ensureUserPhotoDropzone = () => {
            if (typeof Dropzone === 'undefined') {
                return;
            }

            const input = document.getElementById('user-modal-photo-input');
            const target = document.getElementById('user-modal-dropzone');

            if (!input || !target || userPhotoDropzone) {
                return;
            }

            Dropzone.autoDiscover = false;

            userPhotoDropzone = new Dropzone(target, {
                url: '#',
                autoProcessQueue: false,
                uploadMultiple: false,
                maxFiles: 1,
                acceptedFiles: 'image/*',
                addRemoveLinks: true,
                dictDefaultMessage: 'Arrastra una imagen aqui o haz clic para seleccionar.',
            });

            userPhotoDropzone.on('addedfile', (file) => {
                if (userPhotoDropzone.files.length > 1) {
                    userPhotoDropzone.removeFile(userPhotoDropzone.files[0]);
                }

                const dt = new DataTransfer();
                dt.items.add(file);
                input.files = dt.files;
                input.dispatchEvent(new Event('change', {
                    bubbles: true
                }));
            });

            userPhotoDropzone.on('removedfile', () => {
                input.value = '';
                input.dispatchEvent(new Event('change', {
                    bubbles: true
                }));
                @this.set('foto', '');
            });
        };

        document.addEventListener('livewire:load', () => {
            ensureUserDescriptionEditor();
            ensureUserPhotoDropzone();
            const searchInput = document.getElementById('user-search-input');

            window.livewire.on('editarDescripcion', (value) => {
                ensureUserDescriptionEditor();
                if (userDescriptionEditor) {
                    userDescriptionEditor.setData(value || '');
                }
            });

            window.livewire.on('limpiarDescripcion', () => {
                ensureUserDescriptionEditor();
                if (userDescriptionEditor) {
                    userDescriptionEditor.setData('');
                }

                if (userPhotoDropzone) {
                    userPhotoDropzone.removeAllFiles(true);
                }
            });

            window.addEventListener('close-modal', () => {
                $('#modalForm').modal('hide');
            });

            $('#modalForm').on('shown.bs.modal', () => {
                ensureUserDescriptionEditor();
                ensureUserPhotoDropzone();

                // Guard against browser autofill pushing profile values into the search box.
                if (searchInput) {
                    const criterioActual = @this.get('criterio') || '';
                    if (searchInput.value !== criterioActual) {
                        searchInput.value = criterioActual;
                    }
                }
            });
        });
    </script>
</div>
