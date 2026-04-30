@extends('admin.layoutadmin')

@section('title', 'Testimonios')

@section('breadcrumb')
    <li class="breadcrumb-item">Contenido</li>
    <li class="breadcrumb-item active">Testimonios</li>
@endsection

@section('page_title', 'Testimonios')

@section('content')
    <div class="container-fluid px-3">
        <style>
            .content-shell {
                display: grid;
                gap: 1rem;
            }

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

            .content-avatar {
                width: 56px;
                height: 56px;
                object-fit: cover;
                border-radius: 999px;
                border: 2px solid #e2e8f0;
            }

            .content-actions {
                display: flex;
                justify-content: flex-end;
                flex-wrap: wrap;
                gap: 0.5rem;
            }
        </style>

        <div class="content-shell">
            @if (session('status'))
                <div class="alert alert-success border-0 shadow-sm rounded-lg mb-0">{{ session('status') }}</div>
            @endif

            @if (session('error'))
                <div class="alert alert-danger border-0 shadow-sm rounded-lg mb-0">{{ session('error') }}</div>
            @endif

            <section class="content-hero">
                <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center">
                    <div>
                        <h2 class="h4 mb-2 font-weight-bold">Testimonios</h2>
                        <p class="mb-0 text-white-50">Administra testimonios del portal con vistas dedicadas para crear y
                            editar.</p>
                    </div>
                    <div class="mt-3 mt-md-0 text-md-right">
                        <div class="text-uppercase small text-white-50">Registros encontrados</div>
                        <div class="h3 mb-0 font-weight-bold">{{ $testimonios->total() }}</div>
                    </div>
                </div>
            </section>

            <section class="card content-panel">
                <div class="card-body p-4">
                    <div class="d-flex flex-column flex-lg-row justify-content-between align-items-lg-center mb-4">
                        <div>
                            <h3 class="h5 mb-1">Listado de testimonios</h3>
                            <p class="text-muted mb-0">Busca por cliente, mensaje o ID.</p>
                        </div>
                        <a href="{{ route('testimonios.create') }}" class="btn btn-primary mt-3 mt-lg-0 px-4">Nuevo
                            testimonio</a>
                    </div>

                    <form method="GET" action="{{ route('testimonios.index') }}" class="row mb-4">
                        <div class="col-lg-8">
                            <label for="search" class="small text-muted font-weight-semibold">Buscar testimonio</label>
                            <div class="input-group input-group-lg">
                                <input type="text" class="form-control" id="search" name="search"
                                    value="{{ $search }}" placeholder="Ej. Maria Perez o cliente satisfecho">
                                <div class="input-group-append ml-2">
                                    <button class="btn btn-outline-primary" type="submit">Buscar</button>
                                    <a href="{{ route('testimonios.index') }}"
                                        class="btn btn-outline-secondary ml-2">Limpiar</a>
                                </div>
                            </div>
                        </div>
                    </form>

                    <div class="table-responsive">
                        <table class="table align-middle mb-0">
                            <thead class="text-uppercase small text-muted">
                                <tr>
                                    <th>ID</th>
                                    <th>Cliente</th>
                                    <th class="d-none d-md-table-cell">Testimonio</th>
                                    <th class="text-right">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($testimonios as $testimonio)
                                    <tr>
                                        <td class="font-weight-semibold">{{ $testimonio->id }}</td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                @if ($testimonio->cliente_foto)
                                                    <img src="{{ asset(ltrim($testimonio->cliente_foto, '/')) }}"
                                                        class="content-avatar mr-3" alt="{{ $testimonio->cliente }}">
                                                @endif
                                                <div>
                                                    <div class="font-weight-semibold">{{ $testimonio->cliente }}</div>
                                                    <div class="small text-muted">
                                                        {{ $testimonio->activo ? 'Visible' : 'Oculto' }}</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="d-none d-md-table-cell text-muted">
                                            {{ \Illuminate\Support\Str::limit(strip_tags($testimonio->testimonio), 90) }}
                                        </td>
                                        <td class="text-right">
                                            <div class="content-actions">
                                                <a href="{{ route('testimonios.edit', $testimonio) }}"
                                                    class="btn btn-outline-primary btn-sm">Editar</a>
                                                <form action="{{ route('testimonios.destroy', $testimonio) }}"
                                                    method="POST" class="js-delete-form"
                                                    data-name="{{ $testimonio->cliente }}">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                        class="btn btn-outline-danger btn-sm">Eliminar</button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center py-5 text-muted">No hay testimonios para
                                            mostrar con el criterio actual.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-4">{{ $testimonios->links('pagination::bootstrap-4') }}</div>
                </div>
            </section>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            document.querySelectorAll('.js-delete-form').forEach((form) => {
                form.addEventListener('submit', (event) => {
                    event.preventDefault();

                    Swal.fire({
                        title: '¿Eliminar este testimonio?',
                        text: form.dataset.name || 'Esta accion no se puede deshacer.',
                        showCancelButton: true,
                        cancelButtonText: 'Cancelar',
                        confirmButtonText: 'Eliminar',
                        cancelButtonColor: '#6c757d',
                        confirmButtonColor: '#dc3545',
                        icon: 'warning',
                    }).then((result) => {
                        if (result.isConfirmed) {
                            form.submit();
                        }
                    });
                });
            });
        });
    </script>
@endpush
