@extends('admin.layoutadmin')

@section('title', 'Nuevo Estado')

@section('breadcrumb')
    <li class="breadcrumb-item">Catálogos</li>
    <li class="breadcrumb-item"><a href="{{ route('estados.index') }}">Estados</a></li>
    <li class="breadcrumb-item active">Nuevo</li>
@endsection

@section('page_title', 'Nuevo Estado')

@section('content')
    <style>
        .estados-panel {
            border: 1px solid #dbe4f0;
            border-radius: 1.25rem;
            box-shadow: 0 14px 28px rgba(15, 23, 42, 0.06);
            overflow: hidden;
        }

        .estados-panel .card-body {
            padding: 1.5rem;
        }
    </style>

    <div class="container-fluid px-3">
        @if (session('error'))
            <div class="alert alert-danger border-0 shadow-sm rounded-lg mb-3">
                {{ session('error') }}
            </div>
        @endif

        <div class="card estados-panel">
            <div class="card-body p-4">
                <div class="mb-4">
                    <h2 class="h5 mb-1">Registrar estado</h2>
                    <p class="text-muted mb-0">Completa el nombre del estado para usarlo en el catálogo de propiedades.</p>
                </div>

                <form action="{{ route('estados.store') }}" method="POST" autocomplete="off">
                    @csrf

                    <div class="form-group mb-4">
                        <label for="estado" class="font-weight-semibold">Nombre del estado</label>
                        <input type="text" class="form-control form-control-lg rounded-lg @error('estado') is-invalid @enderror"
                            id="estado" name="estado" value="{{ old('estado') }}"
                            placeholder="Ej. Disponible" maxlength="50" minlength="2" required>
                        @error('estado')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-flex flex-column flex-md-row align-items-md-center">
                        <button type="submit" class="btn btn-primary px-4 mr-md-2 mb-2 mb-md-0" id="btn-submit-estado">
                            Guardar estado
                        </button>
                        <a href="{{ route('estados.index') }}" class="btn btn-outline-secondary px-4">Cancelar</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const form = document.querySelector('form[action="{{ route('estados.store') }}"]');
            const submitButton = document.getElementById('btn-submit-estado');

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
