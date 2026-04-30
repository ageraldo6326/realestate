<div>
    <style>
        .catalog-shell {
            display: grid;
            gap: 1rem;
        }

        .catalog-hero {
            background: linear-gradient(135deg, #0f172a 0%, #1d4ed8 55%, #38bdf8 100%);
            border-radius: 1.25rem;
            color: #fff;
            padding: 1.5rem;
            box-shadow: 0 20px 45px rgba(15, 23, 42, 0.18);
        }

        .catalog-stat {
            background: rgba(255, 255, 255, 0.14);
            border: 1px solid rgba(255, 255, 255, 0.16);
            border-radius: 1rem;
            padding: 1rem;
        }

        .catalog-panel {
            border: 1px solid #dbe4f0;
            border-radius: 1.25rem;
            box-shadow: 0 14px 28px rgba(15, 23, 42, 0.06);
        }
    </style>

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

    <div class="catalog-shell">
        <section class="catalog-hero">
            <div class="row align-items-end">
                <div class="col-lg-8 mb-3 mb-lg-0">
                    <span class="badge badge-light text-primary px-3 py-2 rounded-pill mb-3">Catalogos del CRM</span>
                    <h2 class="h3 font-weight-bold mb-2">Gestion de disponible para con vistas dedicadas.</h2>
                    <p class="mb-0 text-white-50">Filtra por nombre o ID, crea nuevos registros y edita en pantallas separadas sin usar modales.</p>
                </div>
                <div class="col-lg-4">
                    <div class="catalog-stat">
                        <div class="text-uppercase small text-white-50">Registros encontrados</div>
                        <div class="h3 mb-0 font-weight-bold">{{ $disponiblespara->total() }}</div>
                    </div>
                </div>
            </div>
        </section>

        <section class="card catalog-panel">
            <div class="card-body p-4">
                <div class="d-flex flex-column flex-lg-row justify-content-between align-items-lg-center mb-4">
                    <div>
                        <h3 class="h5 mb-1">Listado de operaciones</h3>
                        <p class="text-muted mb-0">Gestiona las modalidades de publicacion para venta, alquiler o renta temporal.</p>
                    </div>
                    <a href="{{ route('disponiblepara.create') }}" class="btn btn-primary mt-3 mt-lg-0 px-4">
                        Nuevo registro
                    </a>
                </div>

                <div class="row mb-4">
                    <div class="col-lg-8">
                        <label class="small text-muted font-weight-semibold" for="filtro-disponible">Buscar</label>
                        <input id="filtro-disponible" type="text" class="form-control form-control-lg rounded-lg"
                            wire:model.debounce.350ms="criterio" placeholder="Ej. Venta o ID 4">
                    </div>
                    <div class="col-lg-4 d-flex align-items-end mt-3 mt-lg-0">
                        <button type="button" class="btn btn-outline-secondary" wire:click="clear">
                            Limpiar
                        </button>
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table align-middle mb-0">
                        <thead class="text-uppercase small text-muted">
                            <tr>
                                <th>ID</th>
                                <th>Disponible para</th>
                                <th class="d-none d-md-table-cell">Creado</th>
                                <th class="text-right">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($disponiblespara as $disponiblepara)
                                <tr>
                                    <td class="font-weight-semibold">{{ $disponiblepara->id }}</td>
                                    <td>{{ $disponiblepara->disponible_para }}</td>
                                    <td class="d-none d-md-table-cell text-muted small">{{ $disponiblepara->created_at }}</td>
                                    <td class="text-right">
                                        <a href="{{ route('disponiblepara.edit', $disponiblepara->id) }}"
                                            class="btn btn-outline-primary btn-sm mr-1">
                                            Editar
                                        </a>
                                        <button type="button" class="btn btn-outline-danger btn-sm"
                                            wire:click="$emit('generarBorrarDisponibleParaSweetAlert', {{ $disponiblepara->id }})">
                                            Borrar
                                        </button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center py-5 text-muted">No hay registros para mostrar.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="mt-4">
                    {{ $disponiblespara->links('pagination::bootstrap-4') }}
                </div>
            </div>
        </section>
    </div>
</div>
