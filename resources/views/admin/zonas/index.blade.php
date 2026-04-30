@extends('admin.layoutadmin')

@section('title', 'Zonas')

@section('breadcrumb')
    <li class="breadcrumb-item">Catálogos</li>
    <li class="breadcrumb-item active">Zonas</li>
@endsection

@section('page_title', 'Zonas')

@section('content')
    <style>
        .zones-shell {
            display: grid;
            gap: 1rem;
        }

        .zones-hero {
            background: linear-gradient(135deg, #0f172a 0%, #1d4ed8 55%, #38bdf8 100%);
            border-radius: 1.25rem;
            color: #fff;
            padding: 1.5rem;
            box-shadow: 0 20px 45px rgba(15, 23, 42, 0.18);
        }

        .zones-stat {
            background: rgba(255, 255, 255, 0.14);
            border: 1px solid rgba(255, 255, 255, 0.16);
            border-radius: 1rem;
            padding: 1rem;
        }

        .zones-panel {
            border: 1px solid #dbe4f0;
            border-radius: 1.25rem;
            box-shadow: 0 14px 28px rgba(15, 23, 42, 0.06);
            overflow: hidden;
        }
    </style>

    <div class="container-fluid px-3">
        @if (session('status'))
            <div class="alert alert-success border-0 shadow-sm rounded-lg mb-3">
                {{ session('status') }}
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger border-0 shadow-sm rounded-lg mb-3">
                {{ session('error') }}
            </div>
        @endif

        <div class="zones-shell">
            <section class="zones-hero">
                <div class="row align-items-end">
                    <div class="col-lg-8 mb-3 mb-lg-0">
                        <span class="badge badge-light text-primary px-3 py-2 rounded-pill mb-3">Catalogos del CRM</span>
                        <h2 class="h3 font-weight-bold mb-2">Gestion de zonas con vistas dedicadas.</h2>
                        <p class="mb-0 text-white-50">Filtra por nombre o ID, crea nuevas zonas y edita registros sin usar modales.</p>
                    </div>
                    <div class="col-lg-4">
                        <div class="zones-stat">
                            <div class="text-uppercase small text-white-50">Zonas encontradas</div>
                            <div class="h3 mb-0 font-weight-bold">{{ $zonas->total() }}</div>
                        </div>
                    </div>
                </div>
            </section>

            <section class="card zones-panel">
                <div class="card-body p-4">
                    <div class="d-flex flex-column flex-lg-row justify-content-between align-items-lg-center mb-4">
                        <div>
                            <h3 class="h5 mb-1">Catalogo de zonas</h3>
                            <p class="text-muted mb-0">Gestiona zonas para clasificar propiedades y clientes.</p>
                        </div>
                        <a href="{{ route('zonas.create') }}" class="btn btn-primary mt-3 mt-lg-0 px-4">Nueva zona</a>
                    </div>

                    <form action="{{ route('zonas.index') }}" method="GET" class="mb-4" autocomplete="off">
                        <div class="row align-items-end">
                            <div class="col-lg-8 mb-3 mb-lg-0">
                                <label for="filtro-zona" class="small text-muted font-weight-semibold">Buscar por nombre o ID</label>
                                <input
                                    type="text"
                                    id="filtro-zona"
                                    name="q"
                                    value="{{ $filtro }}"
                                    class="form-control form-control-lg rounded-lg"
                                    maxlength="50"
                                    placeholder="Ej. Naco o 14"
                                >
                            </div>
                            <div class="col-lg-4 d-flex align-items-end mt-3 mt-lg-0">
                                <button type="submit" class="btn btn-outline-primary mr-2">Buscar</button>
                                <a href="{{ route('zonas.index') }}" class="btn btn-outline-secondary">Limpiar</a>
                            </div>
                        </div>
                    </form>

                    <div class="table-responsive">
                        <table class="table align-middle mb-0">
                            <thead class="text-uppercase small text-muted">
                                <tr>
                                    <th>ID</th>
                                    <th>Zona</th>
                                    <th class="text-right">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($zonas as $zona)
                                    <tr>
                                        <td class="font-weight-bold">{{ $zona->id }}</td>
                                        <td>
                                            <div class="font-weight-semibold">{{ $zona->zona }}</div>
                                        </td>
                                        <td class="text-right">
                                            <a href="{{ route('zonas.edit', $zona) }}" class="btn btn-sm btn-outline-primary mr-1">Editar</a>

                                            <form
                                                action="{{ route('zonas.destroy', $zona) }}"
                                                method="POST"
                                                class="d-inline js-form-delete-zona"
                                                data-zona="{{ $zona->zona }}"
                                            >
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline-danger">Eliminar</button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="text-center py-5 text-muted">No hay zonas registradas con ese criterio.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-4">
                        {{ $zonas->links('pagination::bootstrap-4') }}
                    </div>
                </div>
            </section>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const forms = document.querySelectorAll('.js-form-delete-zona');

            forms.forEach((form) => {
                form.addEventListener('submit', (event) => {
                    event.preventDefault();

                    const zona = form.dataset.zona || '';

                    Swal.fire({
                        title: 'Confirmar eliminacion',
                        text: zona ? `Se eliminara la zona "${zona}".` : 'Se eliminara la zona seleccionada.',
                        icon: 'warning',
                        showCancelButton: true,
                        cancelButtonText: 'Cancelar',
                        confirmButtonText: 'Eliminar',
                        cancelButtonColor: '#6c757d',
                        confirmButtonColor: '#dc3545',
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
