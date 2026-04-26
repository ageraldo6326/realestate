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
            max-width: 760px;
        }
    </style>

    @if (session('status'))
        <div class="alert alert-success border-0 shadow-sm rounded-lg mb-3">
            {{ session('status') }}
        </div>
    @endif

    <div class="catalog-shell">
        <section class="catalog-hero">
            <h2 class="h4 mb-2 font-weight-bold">Tipos de tarea</h2>
            <p class="mb-0 text-white-50">Configura categorias para organizar tareas en agenda y seguimiento comercial.</p>
        </section>

        <section class="card catalog-panel">
            <div class="card-body p-4">
                <div class="d-flex flex-column flex-lg-row justify-content-between align-items-lg-center mb-4">
                    <div>
                        <h3 class="h5 mb-1">Listado de tipos</h3>
                        <p class="text-muted mb-0">Crea tipos de tarea con color de identificacion para reportes y tableros.</p>
                    </div>
                    <button type="button" class="btn btn-primary mt-3 mt-lg-0 px-4" wire:click="clear" data-toggle="modal"
                        data-target="#modalForm">
                        Nuevo tipo
                    </button>
                </div>

                <div class="row mb-4">
                    <div class="col-lg-8">
                        <label class="small text-muted font-weight-semibold">Buscar</label>
                        <input type="text" class="form-control form-control-lg rounded-lg" wire:model.debounce.350ms="criterio"
                            placeholder="Ej. Llamada, Visita o ID 2">
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table align-middle mb-0">
                        <thead class="text-uppercase small text-muted">
                            <tr>
                                <th>ID</th>
                                <th>Tipo</th>
                                <th>Color</th>
                                <th class="text-right">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($tipostareas as $tipotarea)
                                <tr>
                                    <td class="font-weight-semibold">{{ $tipotarea->id }}</td>
                                    <td>{{ $tipotarea->todo_tipo }}</td>
                                    <td>
                                        <span class="badge badge-light" style="border: 1px solid #d1d5db;">
                                            <span class="d-inline-block rounded-circle mr-1"
                                                style="width: 12px; height: 12px; background: {{ $tipotarea->color }};"></span>
                                            {{ $tipotarea->color }}
                                        </span>
                                    </td>
                                    <td class="text-right">
                                        <button type="button" class="btn btn-outline-primary btn-sm mr-1"
                                            wire:click="edit({{ $tipotarea->id }})" data-toggle="modal" data-target="#modalForm">
                                            Editar
                                        </button>
                                        <button type="button" class="btn btn-outline-danger btn-sm"
                                            wire:click="edit({{ $tipotarea->id }})" data-toggle="modal" data-target="#modalFormDelete">
                                            Borrar
                                        </button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center py-5 text-muted">No hay tipos de tarea para mostrar.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="mt-4">
                    {{ $tipostareas->links('pagination::bootstrap-4') }}
                </div>
            </div>
        </section>
    </div>

    <div class="modal fade catalog-modal" id="modalForm" wire:ignore.self tabindex="-1" data-backdrop="static">
        <div class="modal-dialog modal-dialog-scrollable">
            <div class="modal-content border-0 shadow-lg">
                <div class="modal-header border-0 pb-0 px-4 pt-4">
                    <div>
                        <div class="text-uppercase small text-muted">{{ $Id ? 'Edicion' : 'Nuevo tipo' }}</div>
                        <h4 class="modal-title mb-0">{{ $Id ? 'Editar tipo de tarea' : 'Registrar tipo de tarea' }}</h4>
                    </div>
                    <button type="button" class="close" wire:click="clear" data-dismiss="modal" aria-label="Cerrar">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body px-4 pb-3">
                    <div class="form-group mb-3">
                        <label>Tipo de tarea</label>
                        <input type="text" class="form-control" wire:model.lazy="todo_tipo" placeholder="Ej. Seguimiento telefonico">
                        @error('todo_tipo')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="form-group mb-0" style="max-width: 200px;">
                        <label>Color</label>
                        <input type="color" class="form-control" wire:model="color">
                        @error('color')
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

    <div class="modal fade catalog-modal" id="modalFormDelete" wire:ignore.self tabindex="-1" data-backdrop="static">
        <div class="modal-dialog">
            <div class="modal-content border-0 shadow-lg">
                <div class="modal-header border-0 pb-0 px-4 pt-4">
                    <h4 class="modal-title mb-0">Eliminar tipo de tarea</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body px-4 pb-3">
                    <p class="mb-1">Se eliminara el tipo de tarea seleccionado:</p>
                    <p class="font-weight-bold mb-0">{{ $todo_tipo }}</p>
                </div>
                <div class="modal-footer border-0 px-4 pb-4 pt-0">
                    <button type="button" class="btn btn-light px-4" data-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-danger px-4" wire:click.prevent="delete({{ $Id }})" data-dismiss="modal">
                        Eliminar
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('close-modal', () => {
            $('#modalForm').modal('hide');
            $('#modalFormDelete').modal('hide');
        });
    </script>
</div>
