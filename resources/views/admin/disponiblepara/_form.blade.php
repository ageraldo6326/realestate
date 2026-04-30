<style>
    .disponible-shell {
        display: grid;
        gap: 1rem;
    }

    .disponible-hero {
        background: linear-gradient(135deg, #0f172a 0%, #1d4ed8 55%, #38bdf8 100%);
        border-radius: 1.25rem;
        color: #fff;
        padding: 1.5rem;
        box-shadow: 0 20px 45px rgba(15, 23, 42, 0.18);
    }

    .disponible-stat {
        background: rgba(255, 255, 255, 0.14);
        border: 1px solid rgba(255, 255, 255, 0.16);
        border-radius: 1rem;
        padding: 1rem;
    }

    .disponible-para-panel {
        border: 1px solid #dbe4f0;
        border-radius: 1.25rem;
        box-shadow: 0 14px 28px rgba(15, 23, 42, 0.06);
        overflow: hidden;
    }

    .disponible-para-panel .card-body {
        padding: 1.5rem;
    }
</style>

<div class="container-fluid px-3">
    @php
        $currentDisponiblePara = $mode === 'edit' ? ($disponiblepara ?? null) : null;
    @endphp

    @if (session('error'))
        <div class="alert alert-danger border-0 shadow-sm rounded-lg mb-3">
            {{ session('error') }}
        </div>
    @endif

    @if (session('status'))
        <div class="alert alert-success border-0 shadow-sm rounded-lg mb-3">
            {{ session('status') }}
        </div>
    @endif

    <div class="disponible-shell">
        <section class="disponible-hero">
            <div class="row align-items-end">
                <div class="col-lg-8 mb-3 mb-lg-0">
                    <span class="badge badge-light text-primary px-3 py-2 rounded-pill mb-3">Catalogos del CRM</span>
                    <h1 class="h3 font-weight-bold mb-2">
                        {{ $mode === 'edit' ? 'Editar disponible para' : 'Crear disponible para' }}
                    </h1>
                    <p class="mb-0 text-white-50">Usa vistas dedicadas para alta y edicion, con validaciones claras y flujo consistente con Usuarios.</p>
                </div>
                <div class="col-lg-4">
                    <div class="disponible-stat">
                        <div class="text-uppercase small text-white-50">Modo</div>
                        <div class="h4 mb-1 font-weight-bold">{{ $mode === 'edit' ? 'Edicion' : 'Alta' }}</div>
                        <div class="small text-white-50">{{ $mode === 'edit' ? 'Registro existente' : 'Nuevo registro' }}</div>
                    </div>
                </div>
            </div>
        </section>

        <section class="card disponible-para-panel">
            <div class="card-body p-4">
                <div class="mb-4">
                    <h2 class="h5 mb-1">{{ $mode === 'edit' ? 'Actualizar disponible para' : 'Registrar disponible para' }}</h2>
                    <p class="text-muted mb-0">Configura como se publica la propiedad: venta, alquiler o modalidad especial.</p>
                </div>

                <form action="{{ $action }}" method="POST" autocomplete="off">
                    @csrf
                    @if ($mode === 'edit')
                        @method('PUT')
                    @endif

                    <div class="form-group mb-4">
                        <label for="disponible_para" class="font-weight-semibold">Disponible para</label>
                        <input type="text"
                            class="form-control form-control-lg rounded-lg @error('disponible_para') is-invalid @enderror"
                            id="disponible_para" name="disponible_para"
                            value="{{ old('disponible_para', optional($currentDisponiblePara)->disponible_para) }}"
                            placeholder="Ej. Venta, Alquiler, Alquiler vacacional" maxlength="50" minlength="2" required>
                        @error('disponible_para')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-flex flex-column flex-md-row align-items-md-center">
                        <button type="submit" class="btn btn-primary px-4 mr-md-2 mb-2 mb-md-0" id="btn-submit-disponible-para">
                            {{ $mode === 'edit' ? 'Guardar cambios' : 'Guardar disponible para' }}
                        </button>
                        <a href="{{ route('disponiblepara.index') }}" class="btn btn-outline-secondary px-4">Cancelar</a>
                    </div>
                </form>
            </div>
        </section>
    </div>
</div>

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const form = document.querySelector('form[action="{{ $action }}"]');
            const submitButton = document.getElementById('btn-submit-disponible-para');

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
