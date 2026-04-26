@extends('admin.layoutadmin')

@section('title', 'Editar usuario')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('usuarios.index') }}">Usuarios</a></li>
    <li class="breadcrumb-item active">Editar</li>
@endsection

@section('page_title', 'Editar usuario')

@section('content')
    <div class="container-fluid px-3">
        <link rel="stylesheet" href="https://unpkg.com/dropzone@5/dist/min/dropzone.min.css">
        <style>
            .dz-modern {
                border: 2px dashed #cbd5e1;
                border-radius: 12px;
                background: #f8fafc;
                padding: 1rem;
            }

            .dz-modern .dz-message {
                margin: 1rem 0;
                color: #475569;
                font-weight: 600;
                text-align: center;
            }

            .dz-modern .dz-preview .dz-image {
                border-radius: 10px;
            }
        </style>
        <div class="row justify-content-center">
            <div class="col-md-9">
                <div class="card">
                    <div class="card-header font-weight-600">Datos del usuario</div>
                    <div class="card-body">
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        <form action="{{ route('usuarios.update', $usuario->id) }}" method="post"
                            enctype="multipart/form-data">
                            @method('put')
                            @csrf
                            <div class="form-group">

                                <div class="form-group">
                                    <label for="nombre">Nombre</label>
                                    <input type="text" class="form-control" required id="nombre" name="nombre"
                                        placeholder="nombre" disabled value="{{ $usuario->name }}">
                                </div>

                                <div class="form-group">
                                    <label for="direccion">Correo</label>
                                    <input type="text" class="form-control" required id="email" name="email"
                                        disabled placeholder="correo" value="{{ $usuario->email }}">
                                </div>

                                <div class="form-group">
                                    <label for="titulo">Titulo o Cargo</label>
                                    <input type="text" class="form-control" required id="titulo" maxlength="60"
                                        name="titulo" placeholder="titulo" value="{{ $usuario->titulo }}">
                                </div>

                                <div class="form-group">
                                    <label for="titulo">Telefono</label>
                                    <input type="text" class="form-control" required id="telefono" maxlength="255"
                                        name="telefono" placeholder="telefono" value="{{ $usuario->telefono }}">
                                </div>

                                <div class="form-group">
                                    <label for="descripcion">Descripción</label>
                                    <textarea class="form-control" id="descripcion" maxlength="255" required name="descripcion" rows="3">{{ $usuario->descripcion }}</textarea>
                                </div>

                                <div class="form-group">
                                    <label for="direccion">Meta Description</label>
                                    <textarea class="form-control" id="metadescription" maxlength="120" required name="metadescription" rows="3">{{ $usuario->metadescription }}</textarea>
                                </div>

                                <div class="form-group">
                                    <label for="direccion">Facebook</label>
                                    <input type="text" class="form-control" id="facebook" name="facebook"
                                        maxlength="255" placeholder="Facebook" value="{{ $usuario->facebook }}">
                                </div>

                                <div class="form-group">
                                    <label for="direccion">Instagram</label>
                                    <input type="text" class="form-control" id="instagram" name="instagram"
                                        maxlength="255" placeholder="Instagram" value="{{ $usuario->instagram }}">
                                </div>

                                <div class="form-group">
                                    <label for="direccion">Whatsapp</label>
                                    <input type="text" class="form-control" id="whatsapp" name="whatsapp"
                                        maxlength="255" placeholder="Whatsapp" value="{{ $usuario->whatsapp }}">
                                </div>

                                <div class="form-group">
                                    <label for="direccion">Tiktok</label>
                                    <input type="text" class="form-control" id="tiktok" name="tiktok" maxlength="255"
                                        placeholder="Tiktok" value="{{ $usuario->tiktok }}">
                                </div>

                                <div class="form-group">
                                    <label for="descripcion">Activo?</label>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="estado" name="estado"
                                            @if ($usuario->activo == 1) checked @endif>
                                    </div>
                                </div>


                                <div class="form-group">
                                    <label for="fotourl">Foto</label>
                                    <div id="user-photo-dropzone" class="dz-modern"></div>
                                    <input type="file" class="d-none" name="fotourl" id="fotourl"
                                        accept="image/*">
                                </div>


                                <div class="form-group">
                                    <img class="img-fluid img-thumbnail" width="300px" src="{{ $usuario->foto }}"
                                        alt="">
                                </div>

                                <div class="form-group">
                                    <label for="rol">Rol</label>
                                    Asesor <input type="radio" name="rol" id="rol"
                                        class="form-control-radio p-1" value=1
                                        @if ($usuario->rol == 1) checked @endif>
                                    Administrador <input type="radio" name="rol" id="rol"
                                        class="form-control-radio p-1" value=0
                                        @if ($usuario->rol == 0) checked @endif>
                                </div>

                                <div class="form-group">
                                    <label for="rol">Mostrar</label>
                                    Mostrar <input type="radio" name="mostrar" id="mostrar"
                                        class="form-control-radio p-1" value=1
                                        @if ($usuario->mostrar == 1) checked @endif>
                                    No Mostrar <input type="radio" name="mostrar" id="mostrar"
                                        class="form-control-radio p-1" value=0
                                        @if ($usuario->mostrar == 0) checked @endif>
                                </div>

                                <div class="form-group">
                                    <label for="orden">Orden</label>
                                    <div>
                                        <input class="form-control" type="number" name="orden" id="orden"
                                            value="{{ $usuario->orden }}">
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label for="newPasswordInput" class="form-label">Nueva Clave</label>
                                    <input name="new_password" type="password"
                                        class="form-control @error('new_password') is-invalid @enderror"
                                        id="newPasswordInput" placeholder="Nueva clave">
                                    @error('new_password')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="confirmNewPasswordInput" class="form-label">Confirmar</label>
                                    <input name="new_password_confirmation" type="password" class="form-control"
                                        id="confirmNewPasswordInput" placeholder="Confirmar nueva clave">
                                </div>

                                <div class="form-group">
                                    <input type="submit" class="btn btn-success" name="submit" id="submit"
                                        value="Grabar">
                                </div>


                            </div>
                        </form>
                    </div>{{-- card-body --}}
                </div>{{-- card --}}
            </div>{{-- col-md-9 --}}
        </div>{{-- row --}}
    </div>{{-- container-fluid --}}

@endsection

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

            const input = document.getElementById('fotourl');
            const target = document.getElementById('user-photo-dropzone');

            if (!input || !target || target.dataset.initialized === '1') {
                return;
            }

            target.dataset.initialized = '1';

            const userDropzone = new Dropzone(target, {
                url: '#',
                autoProcessQueue: false,
                uploadMultiple: false,
                maxFiles: 1,
                acceptedFiles: 'image/*',
                addRemoveLinks: true,
                dictDefaultMessage: 'Arrastra una imagen aqui o haz clic para seleccionar.',
            });

            userDropzone.on('addedfile', (file) => {
                if (userDropzone.files.length > 1) {
                    userDropzone.removeFile(userDropzone.files[0]);
                }

                const dt = new DataTransfer();
                dt.items.add(file);
                input.files = dt.files;
                input.dispatchEvent(new Event('change', {
                    bubbles: true
                }));
            });

            userDropzone.on('removedfile', () => {
                input.value = '';
                input.dispatchEvent(new Event('change', {
                    bubbles: true
                }));
            });
        });
    </script>
@endpush
