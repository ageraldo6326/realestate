@extends('admin.layoutadmin')

@section('title', 'Portadas')

@section('breadcrumb')
    <li class="breadcrumb-item">Contenido</li>
    <li class="breadcrumb-item active">Portadas</li>
@endsection

@section('page_title', 'Portadas')

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

            .content-thumb {
                width: 108px;
                height: 72px;
                object-fit: cover;
                border-radius: 0.75rem;
                background: #e2e8f0;
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
                        <h2 class="h4 mb-2 font-weight-bold">Portadas del portal</h2>
                        <p class="mb-0 text-white-50">Administra los bloques principales del home con vistas separadas para
                            crear y editar sin modales.</p>
                    </div>
                    <div class="mt-3 mt-md-0 text-md-right">
                        <div class="text-uppercase small text-white-50">Registros encontrados</div>
                        <div class="h3 mb-0 font-weight-bold">{{ $portadas->total() }}</div>
                    </div>
                </div>
            </section>

            <section class="card content-panel">
                <div class="card-body p-4">
                    <div class="d-flex flex-column flex-lg-row justify-content-between align-items-lg-center mb-4">
                        <div>
                            <h3 class="h5 mb-1">Listado de portadas</h3>
                            <p class="text-muted mb-0">Busca por ID, mini titulo o titulo principal.</p>
                        </div>
                        <a href="{{ route('portadas.create') }}" class="btn btn-primary mt-3 mt-lg-0 px-4">Nueva portada</a>
                    </div>

                    <form method="GET" action="{{ route('portadas.index') }}" class="row mb-4">
                        <div class="col-lg-8">
                            <label for="search" class="small text-muted font-weight-semibold">Buscar portada</label>
                            <div class="input-group input-group-lg">
                                <input type="text" class="form-control rounded-left-lg" id="search" name="search"
                                    value="{{ $search }}" placeholder="Ej. Inicio, inversion o ID 4">
                                <div class="input-group-append ml-2">
                                    <button class="btn btn-outline-primary" type="submit">Buscar</button>
                                    <a href="{{ route('portadas.index') }}"
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
                                    <th>Imagen</th>
                                    <th>Contenido</th>
                                    <th class="text-right">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($portadas as $portada)
                                    <tr>
                                        <td class="font-weight-semibold">{{ $portada->id }}</td>
                                        <td>
                                            @if ($portada->foto)
                                                <img src="{{ asset(ltrim($portada->foto, '/')) }}" class="content-thumb"
                                                    alt="{{ $portada->titulo }}">
                                            @endif
                                        </td>
                                        <td>
                                            <div class="font-weight-semibold">{{ $portada->titulo }}</div>
                                            <div class="small text-muted">{{ $portada->minititulo ?: 'Sin mini titulo' }}
                                            </div>
                                        </td>
                                        <td class="text-right">
                                            <div class="content-actions">
                                                <a href="{{ route('portadas.edit', $portada) }}"
                                                    class="btn btn-outline-primary btn-sm">Editar</a>
                                                <form action="{{ route('portadas.destroy', $portada) }}" method="POST"
                                                    class="js-delete-form" data-name="{{ $portada->titulo }}">
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
                                        <td colspan="4" class="text-center py-5 text-muted">No hay portadas para mostrar
                                            con el criterio actual.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-4">{{ $portadas->links('pagination::bootstrap-4') }}</div>
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
                        title: '¿Eliminar esta portada?',
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
