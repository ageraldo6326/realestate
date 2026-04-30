@php
    $isEdit = ($mode ?? 'create') === 'edit';
    $tipoActual = $tipotarea ?? null;
@endphp

<div class="container-fluid px-3">
    <style>
        .task-type-shell {
            display: grid;
            gap: 1rem;
        }

        .task-type-hero {
            background: linear-gradient(135deg, #0f172a 0%, #1d4ed8 55%, #38bdf8 100%);
            border-radius: 1.25rem;
            color: #fff;
            padding: 1.5rem;
            box-shadow: 0 20px 45px rgba(15, 23, 42, 0.18);
        }

        .task-type-stat {
            background: rgba(255, 255, 255, 0.14);
            border: 1px solid rgba(255, 255, 255, 0.16);
            border-radius: 1rem;
            padding: 1rem;
        }

        .task-type-panel {
            border: 1px solid #dbe4f0;
            border-radius: 1.25rem;
            box-shadow: 0 14px 28px rgba(15, 23, 42, 0.06);
            overflow: hidden;
        }
    </style>

    <div class="task-type-shell">
        <section class="task-type-hero">
            <div class="row align-items-end">
                <div class="col-lg-8 mb-3 mb-lg-0">
                    <span class="badge badge-light text-primary px-3 py-2 rounded-pill mb-3">Catalogos del CRM</span>
                    <h1 class="h3 font-weight-bold mb-2">{{ $isEdit ? 'Editar tipo de tarea' : 'Crear tipo de tarea' }}</h1>
                    <p class="mb-0 text-white-50">Define categorias de tareas con color para mejorar seguimiento y visualizacion en el CRM.</p>
                </div>
                <div class="col-lg-4">
                    <div class="task-type-stat">
                        <div class="text-uppercase small text-white-50">Modo</div>
                        <div class="h4 mb-1 font-weight-bold">{{ $isEdit ? 'Edicion' : 'Alta' }}</div>
                        <div class="small text-white-50">{{ $isEdit ? 'Registro existente' : 'Nuevo registro' }}</div>
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

        <section class="card task-type-panel">
            <div class="card-body p-4">
                <div class="mb-4">
                    <h2 class="h5 mb-1">{{ $isEdit ? 'Actualizar tipo de tarea' : 'Registrar tipo de tarea' }}</h2>
                    <p class="text-muted mb-0">Usa nombres claros y un color distintivo para identificar la categoria rapidamente.</p>
                </div>

                <form action="{{ $action }}" method="POST" autocomplete="off" id="tipo-tarea-form">
                    @csrf
                    @if ($isEdit)
                        @method('PUT')
                    @endif

                    <div class="form-group mb-4">
                        <label for="todo_tipo" class="font-weight-semibold">Tipo de tarea</label>
                        <input type="text" id="todo_tipo" name="todo_tipo"
                            class="form-control form-control-lg rounded-lg @error('todo_tipo') is-invalid @enderror"
                            value="{{ old('todo_tipo', optional($tipoActual)->todo_tipo) }}"
                            placeholder="Ej. Llamada de seguimiento" maxlength="50" minlength="2" required>
                        @error('todo_tipo')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group mb-4" style="max-width: 220px;">
                        <label for="color" class="font-weight-semibold">Color</label>
                        <input type="color" id="color" name="color"
                            class="form-control form-control-lg rounded-lg @error('color') is-invalid @enderror"
                            value="{{ old('color', optional($tipoActual)->color ?? '#2563eb') }}" required>
                        @error('color')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-flex flex-column flex-md-row align-items-md-center">
                        <button type="submit" class="btn btn-primary px-4 mr-md-2 mb-2 mb-md-0" id="btn-submit-tipo-tarea">
                            {{ $isEdit ? 'Guardar cambios' : 'Guardar tipo de tarea' }}
                        </button>
                        <a href="{{ route('tipostareas.index') }}" class="btn btn-outline-secondary px-4">Cancelar</a>
                    </div>
                </form>
            </div>
        </section>
    </div>
</div>

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const form = document.getElementById('tipo-tarea-form');
            const submitButton = document.getElementById('btn-submit-tipo-tarea');

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
