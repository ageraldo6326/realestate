<div>
    <style>
        .tasks-shell {
            display: grid;
            gap: 1rem;
        }

        .tasks-hero {
            background: linear-gradient(135deg, #0f172a 0%, #1d4ed8 55%, #38bdf8 100%);
            border-radius: 1.25rem;
            color: #fff;
            padding: 1.5rem;
            box-shadow: 0 20px 45px rgba(15, 23, 42, 0.18);
        }

        .tasks-stat {
            background: rgba(255, 255, 255, 0.14);
            border: 1px solid rgba(255, 255, 255, 0.16);
            border-radius: 1rem;
            padding: 1rem;
        }

        .tasks-panel {
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

    <div class="tasks-shell">
        <section class="tasks-hero">
            <div class="row align-items-end">
                <div class="col-lg-8 mb-3 mb-lg-0">
                    <span class="badge badge-light text-primary px-3 py-2 rounded-pill mb-3">Catalogos del CRM</span>
                    <h2 class="h3 font-weight-bold mb-2">Gestion de tipos de tarea con vistas dedicadas.</h2>
                    <p class="mb-0 text-white-50">Filtra por nombre o ID, crea nuevos tipos y edita en pantallas separadas sin usar modales.</p>
                </div>
                <div class="col-lg-4">
                    <div class="tasks-stat">
                        <div class="text-uppercase small text-white-50">Tipos encontrados</div>
                        <div class="h3 mb-0 font-weight-bold">{{ $tipostareas->total() }}</div>
                    </div>
                </div>
            </div>
        </section>

        <section class="card tasks-panel">
            <div class="card-body p-4">
                <div class="d-flex flex-column flex-lg-row justify-content-between align-items-lg-center mb-4">
                    <div>
                        <h3 class="h5 mb-1">Listado de tipos de tarea</h3>
                        <p class="text-muted mb-0">Administra categorias para agenda y seguimiento comercial.</p>
                    </div>
                    <a href="{{ route('tipostareas.create') }}" class="btn btn-primary mt-3 mt-lg-0 px-4">Nuevo tipo</a>
                </div>

                <div class="row mb-4">
                    <div class="col-lg-8">
                        <label for="filtro-tipo-tarea" class="small text-muted font-weight-semibold">Buscar tipo</label>
                        <input id="filtro-tipo-tarea" type="text" class="form-control form-control-lg rounded-lg"
                            wire:model.debounce.350ms="criterio" placeholder="Ej. Llamada o ID 2" maxlength="50">
                    </div>
                    <div class="col-lg-4 d-flex align-items-end mt-3 mt-lg-0">
                        <button type="button" class="btn btn-outline-secondary" wire:click="limpiar">Limpiar</button>
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
                                    <td class="font-weight-bold">{{ $tipotarea->id }}</td>
                                    <td>
                                        <div class="font-weight-semibold">{{ $tipotarea->todo_tipo }}</div>
                                    </td>
                                    <td>
                                        <span class="badge badge-light" style="border: 1px solid #d1d5db;">
                                            <span class="d-inline-block rounded-circle mr-1"
                                                style="width: 12px; height: 12px; background: {{ $tipotarea->color }};"></span>
                                            {{ $tipotarea->color }}
                                        </span>
                                    </td>
                                    <td class="text-right">
                                        <div class="d-flex justify-content-end">
                                            <a href="{{ route('tipostareas.edit', $tipotarea->id) }}"
                                                class="btn btn-outline-primary btn-sm mr-1">Editar</a>
                                            <button type="button" class="btn btn-outline-danger btn-sm"
                                                wire:click="$emit('generarBorrarTipoTareaSweetAlert', {{ $tipotarea->id }}, @js($tipotarea->todo_tipo))">
                                                Eliminar
                                            </button>
                                        </div>
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
</div>
