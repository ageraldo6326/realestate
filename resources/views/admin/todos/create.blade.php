@extends('admin.layoutadmin')

@section('title', 'Crear tarea')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('todo.index') }}">Tareas</a></li>
    <li class="breadcrumb-item active">Nueva tarea</li>
@endsection

@section('page_title', 'Crear tarea programada')

@section('page_actions')
    <a href="{{ route('todo.index') }}" class="btn btn-outline-secondary btn-sm">
        <i class="fas fa-arrow-left mr-1"></i> Volver al listado
    </a>
@endsection

@section('content')
    <div class="container-fluid px-3">
        <div class="card border-0 shadow-sm overflow-hidden mb-3">
            <div class="card-body py-4" style="background: linear-gradient(135deg, #0f172a, #2563eb); color: #ffffff;">
                <div class="d-flex flex-wrap align-items-center justify-content-between gap-3">
                    <div>
                        <p class="text-uppercase small mb-2" style="letter-spacing:.14em; opacity:.75;">Planificación operativa</p>
                        <h2 class="h4 font-weight-bold mb-1">Registra una nueva tarea de seguimiento</h2>
                        <p class="mb-0" style="opacity:.85; max-width:44rem;">Define el tipo, responsable y fecha límite para mantener trazabilidad en la gestión de clientes.</p>
                    </div>
                    <span class="badge badge-light px-3 py-2">Formulario CRM</span>
                </div>
            </div>
        </div>

        @if (isset($errors) && $errors->any())
            <div class="alert alert-danger border-0 shadow-sm">
                <h3 class="h6 mb-2">Hay errores en el formulario</h3>
                <ul class="mb-0 pl-3">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="row">
            <div class="col-12 col-xl-8 mb-3">
                <div class="card border-0 shadow-sm">
                    <div class="card-body p-4">
                        <form action="{{ route('todo.store') }}" method="post" enctype="multipart/form-data" novalidate>
                            @csrf

                            <div class="form-group mb-3">
                                <label for="nombre" class="font-weight-600">Tarea</label>
                                <input
                                    type="text"
                                    class="form-control @error('nombre') is-invalid @enderror"
                                    id="nombre"
                                    name="nombre"
                                    placeholder="Ej. Llamar cliente por actualización de propuesta"
                                    required
                                    value="{{ old('nombre') }}"
                                >
                                @error('nombre')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group mb-3">
                                <label for="descripcion" class="font-weight-600">Descripción</label>
                                <textarea
                                    class="form-control @error('descripcion') is-invalid @enderror"
                                    id="descripcion"
                                    name="descripcion"
                                    rows="4"
                                    placeholder="Describe el objetivo de la tarea y contexto necesario"
                                    required
                                >{{ old('descripcion') }}</textarea>
                                @error('descripcion')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="row">
                                <div class="col-12 col-md-6">
                                    <div class="form-group mb-3">
                                        <label for="todo_tipo" class="font-weight-600">Tipo de tarea</label>
                                        <select class="form-control select2 form-control-sm @error('todo_tipo') is-invalid @enderror" name="todo_tipo" id="todo_tipo" required>
                                            <option value="" disabled {{ old('todo_tipo') ? '' : 'selected' }}>Selecciona un tipo</option>
                                            @foreach ($tipos as $tipo)
                                                <option value="{{ $tipo->id }}" {{ old('todo_tipo') == $tipo->id ? 'selected' : '' }}>{{ $tipo->todo_tipo }}</option>
                                            @endforeach
                                        </select>
                                        @error('todo_tipo')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-12 col-md-6">
                                    <div class="form-group mb-3">
                                        <label for="todo_estatus" class="font-weight-600">Estatus inicial</label>
                                        <select class="form-control select2 form-control-sm @error('todo_estatus') is-invalid @enderror" name="todo_estatus" id="todo_estatus" required>
                                            <option value="" disabled {{ old('todo_estatus') ? '' : 'selected' }}>Selecciona un estatus</option>
                                            @foreach ($estatuses as $estatus)
                                                <option value="{{ $estatus->id }}" {{ old('todo_estatus') == $estatus->id ? 'selected' : '' }}>{{ $estatus->todo_estatus }}</option>
                                            @endforeach
                                        </select>
                                        @error('todo_estatus')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-12 col-md-6">
                                    <div class="form-group mb-3">
                                        <label for="cliente_id" class="font-weight-600">Cliente</label>
                                        <select class="form-control select2 form-control-sm @error('cliente_id') is-invalid @enderror" name="cliente_id" id="cliente_id" required>
                                            <option value="0" {{ old('cliente_id', '0') == '0' ? 'selected' : '' }}>Empresa</option>
                                            @foreach ($clientes as $cliente)
                                                <option value="{{ $cliente->id }}" {{ old('cliente_id') == $cliente->id ? 'selected' : '' }}>{{ $cliente->nombre }}</option>
                                            @endforeach
                                        </select>
                                        @error('cliente_id')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-12 col-md-6">
                                    <div class="form-group mb-3">
                                        <label for="fechaLimite" class="font-weight-600">Fecha límite</label>
                                        <input
                                            type="datetime-local"
                                            class="form-control @error('fechaLimite') is-invalid @enderror"
                                            id="fechaLimite"
                                            name="fechaLimite"
                                            required
                                            value="{{ old('fechaLimite') }}"
                                        >
                                        @error('fechaLimite')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="d-flex flex-wrap gap-2 mt-2">
                                <button type="submit" class="btn btn-success">
                                    <i class="fas fa-save mr-1"></i> Guardar tarea
                                </button>
                                <a href="{{ route('todo.index') }}" class="btn btn-outline-secondary">Cancelar</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-12 col-xl-4 mb-3">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body p-4">
                        <h3 class="h6 text-uppercase text-muted mb-3">Recomendaciones</h3>
                        <div class="mb-3 pb-3 border-bottom">
                            <div class="font-weight-600">Sé específico en el nombre</div>
                            <p class="text-muted small mb-0">Un título claro acelera la priorización y evita tareas duplicadas.</p>
                        </div>
                        <div class="mb-3 pb-3 border-bottom">
                            <div class="font-weight-600">Define el estatus correcto</div>
                            <p class="text-muted small mb-0">Comienza en pendiente para facilitar seguimiento y reportes.</p>
                        </div>
                        <div>
                            <div class="font-weight-600">Asocia un cliente cuando aplique</div>
                            <p class="text-muted small mb-0">Te ayudará a mantener historial completo dentro del CRM.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection