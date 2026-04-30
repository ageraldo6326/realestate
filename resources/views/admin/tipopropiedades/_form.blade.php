@php
    $isEdit = ($mode ?? 'create') === 'edit';
    $tipoActual = $tipopropiedad ?? null;
@endphp

<div class="container-fluid px-3">
    <style>
        .types-shell {
            display: grid;
            gap: 1rem;
        }

        .types-hero {
            background: linear-gradient(135deg, #0f172a 0%, #1d4ed8 55%, #38bdf8 100%);
            border-radius: 1.25rem;
            color: #fff;
            padding: 1.5rem;
            box-shadow: 0 20px 45px rgba(15, 23, 42, 0.18);
        }

        .types-stat {
            background: rgba(255, 255, 255, 0.14);
            border: 1px solid rgba(255, 255, 255, 0.16);
            border-radius: 1rem;
            padding: 1rem;
        }

        .types-panel {
            border: 1px solid #dbe4f0;
            border-radius: 1.25rem;
            box-shadow: 0 14px 28px rgba(15, 23, 42, 0.06);
            overflow: hidden;
        }
    </style>

    <div class="types-shell">
        <section class="types-hero">
            <div class="row align-items-end">
                <div class="col-lg-8 mb-3 mb-lg-0">
                    <span class="badge badge-light text-primary px-3 py-2 rounded-pill mb-3">Catalogos del CRM</span>
                    <h1 class="h3 font-weight-bold mb-2">{{ $isEdit ? 'Editar tipo de propiedad' : 'Crear tipo de propiedad' }}</h1>
                    <p class="mb-0 text-white-50">
                        {{ $isEdit ? 'Actualiza el tipo manteniendo consistencia en captacion y publicacion.' : 'Registra una nueva tipologia para mantener estandar del catalogo inmobiliario.' }}
                    </p>
                </div>
                <div class="col-lg-4">
                    <div class="types-stat">
                        <div class="text-uppercase small text-white-50">Modo</div>
                        <div class="h4 mb-1 font-weight-bold">{{ $isEdit ? 'Edicion' : 'Alta' }}</div>
                        <div class="small text-white-50">{{ $isEdit ? 'ID ' . optional($tipoActual)->id : 'Nuevo registro' }}</div>
                    </div>
                </div>
            </div>
        </section>

        @if (session('error'))
            <div class="alert alert-danger border-0 shadow-sm rounded-lg mb-0">
                {{ session('error') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger border-0 shadow-sm rounded-lg mb-0">
                <div class="font-weight-bold mb-1">Revisa los campos requeridos antes de guardar.</div>
                <ul class="mb-0 pl-3">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <section class="card types-panel">
            <div class="card-body p-4">
                <div class="mb-4">
                    <h2 class="h5 mb-1">{{ $isEdit ? 'Actualizar tipo' : 'Registrar tipo' }}</h2>
                    <p class="text-muted mb-0">Usa un nombre claro y unico para facilitar filtros y reportes.</p>
                </div>

                <form action="{{ $action }}" method="POST" autocomplete="off" id="tipo-propiedad-form">
                    @csrf
                    @if ($isEdit)
                        @method('PUT')
                    @endif

                    <div class="form-group mb-4">
                        <label for="tipo" class="font-weight-semibold">Tipo de propiedad</label>
                        <input type="text"
                            class="form-control form-control-lg rounded-lg @error('tipo') is-invalid @enderror"
                            id="tipo" name="tipo" value="{{ old('tipo', optional($tipoActual)->tipo) }}"
                            placeholder="Ej. Apartamento, Casa, Penthouse" maxlength="100" minlength="2" required>
                        <small class="form-text text-muted mt-2">Maximo 100 caracteres. Evita duplicados.</small>
                        @error('tipo')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-flex flex-column flex-md-row align-items-md-center">
                        <button type="submit" class="btn btn-primary px-4 mr-md-2 mb-2 mb-md-0" id="btn-submit-tipo">
                            {{ $isEdit ? 'Guardar cambios' : 'Guardar tipo' }}
                        </button>
                        <a href="{{ route('tipopropiedades.index') }}" class="btn btn-outline-secondary px-4">Cancelar</a>
                    </div>
                </form>
            </div>
        </section>
    </div>
</div>

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const form = document.getElementById('tipo-propiedad-form');
            const submitButton = document.getElementById('btn-submit-tipo');
            const tipoInput = document.getElementById('tipo');

            if (tipoInput) {
                tipoInput.addEventListener('input', function() {
                    this.value = this.value.replace(/\s+/g, ' ').trimStart();
                });
            }

            if (!form || !submitButton) {
                return;
            }

            form.addEventListener('submit', () => {
                submitButton.setAttribute('disabled', 'disabled');
                submitButton.textContent = 'Guardando...';
            });
        });
    </script>
@endpush
