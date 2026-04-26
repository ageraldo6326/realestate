<div>
    <style>
        .venta-shell {
            display: grid;
            gap: 1.25rem;
        }

        .venta-panel {
            border: 1px solid #dbe4f0;
            border-radius: 1.25rem;
            box-shadow: 0 14px 28px rgba(15, 23, 42, .06);
        }

        .venta-panel .card-body {
            padding: 1.5rem;
        }

        .venta-section-title {
            font-size: .72rem;
            font-weight: 700;
            letter-spacing: .07em;
            text-transform: uppercase;
            color: #64748b;
            margin-bottom: 1rem;
        }

        .venta-search-results {
            position: absolute;
            z-index: 1000;
            width: 100%;
            background: #fff;
            border: 1px solid #dbe4f0;
            border-radius: .75rem;
            box-shadow: 0 12px 24px rgba(15, 23, 42, .12);
            overflow: hidden;
            max-height: 280px;
            overflow-y: auto;
        }

        .venta-search-results table {
            margin: 0;
        }

        .venta-search-results thead th {
            background: #f8fafc;
            font-size: .7rem;
            text-transform: uppercase;
            letter-spacing: .06em;
            color: #64748b;
            border-bottom: 1px solid #e9ecef;
            padding: .5rem .75rem;
        }

        .venta-search-results tbody tr:hover {
            background: #f0f7ff;
            cursor: pointer;
        }

        .venta-search-results tbody td {
            padding: .5rem .75rem;
            font-size: .875rem;
            vertical-align: middle;
        }

        .venta-selected-badge {
            display: flex;
            align-items: center;
            gap: .5rem;
            background: #f0f7ff;
            border: 1px solid #bfdbfe;
            border-radius: .75rem;
            padding: .5rem .875rem;
            font-size: .875rem;
        }

        .venta-selected-badge .badge-id {
            background: #1e3a8a;
            color: #fff;
            border-radius: .4rem;
            padding: .15rem .45rem;
            font-size: .72rem;
            font-weight: 700;
        }
    </style>

    <div class="venta-shell">
        <div class="row">

            {{-- ======================================
                 COLUMNA IZQUIERDA: Propiedad + Vendedor
            ====================================== --}}
            <div class="col-lg-6 mb-4 mb-lg-0">

                {{-- Panel Propiedad --}}
                <section class="card venta-panel mb-4">
                    <div class="card-body">
                        <p class="venta-section-title"><i class="fas fa-building mr-1"></i> Propiedad</p>

                        <div class="form-group position-relative">
                            <label class="small font-weight-semibold text-muted">Buscar propiedad</label>
                            <input type="search" class="form-control form-control-lg rounded-lg"
                                wire:model.debounce.400ms="criterio" placeholder="Referencia o título..."
                                autocomplete="off">
                            @if ($criterio != '')
                                <div class="venta-search-results mt-1">
                                    <table class="table mb-0">
                                        <thead>
                                            <tr>
                                                <th>Referencia</th>
                                                <th>Foto</th>
                                                <th>Título</th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse ($propiedades as $propiedad)
                                                <tr>
                                                    <td class="font-weight-bold text-primary">
                                                        {{ $propiedad->referencia }}</td>
                                                    <td>
                                                        <img src="{{ $propiedad->foto_portada }}"
                                                            alt="{{ $propiedad->titulo }}"
                                                            style="width:48px;height:48px;object-fit:cover;border-radius:.5rem;">
                                                    </td>
                                                    <td>{{ $propiedad->titulo }}</td>
                                                    <td>
                                                        <button class="btn btn-outline-primary btn-sm"
                                                            wire:click.prevent="buscarpropiedad('{{ $propiedad->referencia }}')">
                                                            Seleccionar
                                                        </button>
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="4" class="text-center text-muted py-3">Sin
                                                        resultados</td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            @endif
                        </div>

                        @if ($tituloPropiedad)
                            <div class="venta-selected-badge mb-3">
                                <span class="badge-id">{{ $refPropiedad }}</span>
                                <span class="font-weight-bold">{{ $tituloPropiedad }}</span>
                            </div>
                        @endif

                        <div class="form-row">
                            <div class="form-group col-5">
                                <label class="small text-muted">ID Propiedad</label>
                                <input type="text" class="form-control" wire:model.lazy="id_propiedad" readonly>
                                @error('id_propiedad')
                                    <span class="text-danger small">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group col-7">
                                <label class="small text-muted">Referencia</label>
                                <input type="text" class="form-control" wire:model.lazy="refPropiedad" readonly>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-4">
                                <label class="small text-muted">Tipo</label>
                                <input type="text" class="form-control" wire:model.lazy="tipoPropiedad" readonly>
                            </div>
                            <div class="form-group col-4">
                                <label class="small text-muted">Zona</label>
                                <input type="text" class="form-control" wire:model.lazy="zonaPropiedad" readonly>
                            </div>
                            <div class="form-group col-4">
                                <label class="small text-muted">Estado</label>
                                <input type="text" class="form-control" wire:model.lazy="estadoPropiedad" readonly>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-4">
                                <label class="small text-muted">Fecha creación</label>
                                <input type="text" class="form-control" wire:model.lazy="fechaPropiedadCreada"
                                    readonly>
                            </div>
                            <div class="form-group col-4">
                                <label class="small text-muted">Precio</label>
                                <input type="text" class="form-control monto" wire:model.lazy="precio">
                            </div>
                            <div class="form-group col-4">
                                <label class="small text-muted">Comisión %</label>
                                <input type="number" class="form-control" wire:model.lazy="comision">
                            </div>
                        </div>
                    </div>
                </section>

                {{-- Panel Vendedor --}}
                <section class="card venta-panel">
                    <div class="card-body">
                        <p class="venta-section-title"><i class="fas fa-user-tag mr-1"></i> Vendedor</p>

                        <div class="form-group position-relative">
                            <label class="small font-weight-semibold text-muted">Buscar vendedor</label>
                            <input type="search" class="form-control form-control-lg rounded-lg"
                                wire:model.debounce.400ms="criterioVendedor" placeholder="Nombre o ID del vendedor..."
                                autocomplete="off">
                            @if ($criterioVendedor != '')
                                <div class="venta-search-results mt-1">
                                    <table class="table mb-0">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Nombre</th>
                                                <th>Teléfono</th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse ($vendedores as $vendedor)
                                                <tr>
                                                    <td class="text-muted small">{{ $vendedor->id }}</td>
                                                    <td class="font-weight-bold">{{ $vendedor->nombre }}</td>
                                                    <td>{{ $vendedor->telefono }}</td>
                                                    <td>
                                                        <button class="btn btn-outline-primary btn-sm"
                                                            wire:click.prevent="buscarvendedor('{{ $vendedor->id }}')">
                                                            Seleccionar
                                                        </button>
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="4" class="text-center text-muted py-3">Sin
                                                        resultados</td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            @endif
                        </div>

                        @if ($nombre_vendedor)
                            <div class="venta-selected-badge mb-3">
                                <span class="badge-id">{{ $id_vendedor }}</span>
                                <span class="font-weight-bold">{{ $nombre_vendedor }}</span>
                            </div>
                        @endif

                        <div class="form-row">
                            <div class="form-group col-3">
                                <label class="small text-muted">ID</label>
                                <input type="text" class="form-control" wire:model.lazy="id_vendedor" readonly>
                                @error('id_vendedor')
                                    <span class="text-danger small">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group col-9">
                                <label class="small text-muted">Nombre</label>
                                <input type="text" class="form-control" wire:model.lazy="nombre_vendedor"
                                    readonly>
                            </div>
                        </div>
                    </div>
                </section>

            </div>

            {{-- ======================================
                 COLUMNA DERECHA: Comprador + Asesor + Cierre
            ====================================== --}}
            <div class="col-lg-6">

                {{-- Panel Comprador --}}
                <section class="card venta-panel mb-4">
                    <div class="card-body">
                        <p class="venta-section-title"><i class="fas fa-user-check mr-1"></i> Comprador</p>

                        <div class="form-group position-relative">
                            <label class="small font-weight-semibold text-muted">Buscar comprador</label>
                            <input type="search" class="form-control form-control-lg rounded-lg"
                                wire:model.debounce.400ms="criterioComprador"
                                placeholder="Nombre o ID del comprador..." autocomplete="off">
                            @if ($criterioComprador != '')
                                <div class="venta-search-results mt-1">
                                    <table class="table mb-0">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Nombre</th>
                                                <th>Teléfono</th>
                                                <th>Registrado</th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse ($compradores as $comprador)
                                                <tr>
                                                    <td class="text-muted small">{{ $comprador->id }}</td>
                                                    <td class="font-weight-bold">{{ $comprador->nombre }}</td>
                                                    <td>{{ $comprador->telefono }}</td>
                                                    <td class="text-muted small">
                                                        {{ $comprador->created_at->format('d/m/Y') }}</td>
                                                    <td>
                                                        <button class="btn btn-outline-primary btn-sm"
                                                            wire:click.prevent="buscarcomprador('{{ $comprador->id }}')">
                                                            Seleccionar
                                                        </button>
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="5" class="text-center text-muted py-3">Sin
                                                        resultados</td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            @endif
                        </div>

                        @if ($nombre_comprador)
                            <div class="venta-selected-badge mb-3">
                                <span class="badge-id">{{ $id_comprador }}</span>
                                <span class="font-weight-bold">{{ $nombre_comprador }}</span>
                                @if ($medio_comprador)
                                    <span class="small text-muted ml-2"><i
                                            class="fas fa-share-alt mr-1"></i>{{ $medio_comprador }}</span>
                                @endif
                            </div>
                        @endif

                        <div class="form-row">
                            <div class="form-group col-3">
                                <label class="small text-muted">ID</label>
                                <input type="text" class="form-control" wire:model.lazy="id_comprador" readonly>
                                @error('id_comprador')
                                    <span class="text-danger small">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group col-5">
                                <label class="small text-muted">Nombre</label>
                                <input type="text" class="form-control" wire:model.lazy="nombre_comprador"
                                    readonly>
                            </div>
                            <div class="form-group col-4">
                                <label class="small text-muted">Medio</label>
                                <input type="text" class="form-control" wire:model.lazy="medio_comprador">
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-6">
                                <label class="small text-muted">Registrado el</label>
                                <input type="date" class="form-control" wire:model.lazy="fechacreadocomprador">
                            </div>
                        </div>
                    </div>
                </section>

                {{-- Panel Asesor + Cierre --}}
                <section class="card venta-panel mb-4">
                    <div class="card-body">
                        <p class="venta-section-title"><i class="fas fa-user-tie mr-1"></i> Asesor y cierre</p>

                        <div class="form-group">
                            <label class="small font-weight-semibold text-muted">Asesor responsable</label>
                            <select class="form-control form-control-lg rounded-lg" wire:model="criterioAsesor"
                                wire:change="buscarasesor">
                                <option value="">Seleccionar asesor...</option>
                                @foreach ($usuarios as $usuario)
                                    <option value="{{ $usuario->email }}">{{ $usuario->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        @if ($nombre_asesor)
                            <div class="venta-selected-badge mb-3">
                                <i class="fas fa-user-tie text-primary"></i>
                                <span class="font-weight-bold">{{ $nombre_asesor }}</span>
                                <span class="small text-muted">{{ $id_asesor }}</span>
                            </div>
                        @endif

                        <div class="form-row">
                            <div class="form-group col-6">
                                <label class="small text-muted">Email asesor</label>
                                <input type="text" class="form-control" wire:model.lazy="id_asesor" readonly>
                                @error('id_asesor')
                                    <span class="text-danger small">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group col-6">
                                <label class="small text-muted">Nombre asesor</label>
                                <input type="text" class="form-control" wire:model.lazy="nombre_asesor" readonly>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="small font-weight-semibold text-muted">Fecha de cierre</label>
                            <input type="date" class="form-control form-control-lg rounded-lg"
                                wire:model.lazy="fechaVentaCierre">
                            @error('fechaVentaCierre')
                                <span class="text-danger small">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </section>

                {{-- Acciones --}}
                <div class="d-flex justify-content-end">
                    <a href="{{ route('registrarventa') }}" class="btn btn-outline-secondary px-4 mr-2">
                        Cancelar
                    </a>
                    <button type="button" class="btn btn-primary px-5" wire:click="grabarventa"
                        wire:loading.attr="disabled">
                        <span wire:loading.remove wire:target="grabarventa">
                            <i class="fas fa-save mr-1"></i> Guardar venta
                        </span>
                        <span wire:loading wire:target="grabarventa">
                            <i class="fas fa-spinner fa-spin mr-1"></i> Guardando...
                        </span>
                    </button>
                </div>

            </div>
        </div>
    </div>
</div>
