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

        .catalog-panel {
            border: 1px solid #dbe4f0;
            border-radius: 1.25rem;
            box-shadow: 0 14px 28px rgba(15, 23, 42, 0.06);
        }

        .catalog-modal .modal-dialog {
            max-width: 680px;
        }
    </style>

    @if (session('status'))
        <div class="alert alert-success border-0 shadow-sm rounded-lg mb-3">
            {{ session('status') }}
        </div>
    @endif

    <div class="catalog-shell">
        <section class="catalog-hero">
            <h2 class="h4 mb-2 font-weight-bold">Zonas comerciales</h2>
            <p class="mb-0 text-white-50">Administra zonas de ubicacion para clasificar propiedades de forma consistente.</p>
        </section>

        <section class="card catalog-panel">
            <div class="card-body p-4">
                <div class="d-flex flex-column flex-lg-row justify-content-between align-items-lg-center mb-4">
                    <div>
                        <h3 class="h5 mb-1">Listado de zonas</h3>
                        <p class="text-muted mb-0">Busca por nombre o ID y edita sin salir de la pantalla.</p>
                    </div>
                    <button type="button" class="btn btn-primary mt-3 mt-lg-0 px-4" wire:click="clear" data-toggle="modal"
                        data-target="#modalForm">
                        Nueva zona
                    </button>
                </div>

                <div class="row mb-4">
                    <div class="col-lg-8">
                        <label class="small text-muted font-weight-semibold">Buscar</label>
                        <input type="text" class="form-control form-control-lg rounded-lg" wire:model.debounce.350ms="criterio"
                            placeholder="Ej. Naco o ID 12">
                    </div>
                </div>

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
                                    <td class="font-weight-semibold">{{ $zona->id }}</td>
                                    <td>{{ $zona->zona }}</td>
                                    <td class="text-right">
                                        <button type="button" class="btn btn-outline-primary btn-sm mr-1"
                                            wire:click="edit({{ $zona->id }})" data-toggle="modal" data-target="#modalForm">
                                            Editar
                                        </button>
                                        <button type="button" class="btn btn-outline-danger btn-sm"
                                            wire:click="$emit('generarBorrarZonaSweetAlert', {{ $zona->id }})">
                                            Borrar
                                        </button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="text-center py-5 text-muted">No hay zonas para mostrar.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="mt-4">
                    {{ $zonas->links() }}
                </div>
            </div>
        </section>
    </div>

    <div class="modal fade catalog-modal" id="modalForm" wire:ignore.self tabindex="-1" data-backdrop="static">
        <div class="modal-dialog modal-dialog-scrollable">
            <div class="modal-content border-0 shadow-lg">
                <div class="modal-header border-0 pb-0 px-4 pt-4">
                    <div>
                        <div class="text-uppercase small text-muted">{{ $Id ? 'Edicion' : 'Nueva zona' }}</div>
                        <h4 class="modal-title mb-0">{{ $Id ? 'Editar zona' : 'Registrar zona' }}</h4>
                    </div>
                    <button type="button" class="close" wire:click="clear" data-dismiss="modal" aria-label="Cerrar">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body px-4 pb-3">
                    <div class="form-group mb-0">
                        <label>Zona</label>
                        <input type="text" class="form-control" wire:model.lazy="zona" placeholder="Nombre de zona">
                        @error('zona')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>

                <div class="modal-footer border-0 px-4 pb-4 pt-0">
                    <button type="button" class="btn btn-light px-4" wire:click="clear" data-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-primary px-4"
                        @if ($Id == 0) wire:click.prevent="store" @else wire:click.prevent="update({{ $Id }})" @endif>
                        {{ $Id ? 'Actualizar' : 'Guardar' }}
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('close-modal', () => {
            $('#modalForm').modal('hide');
        });
    </script>
</div>
