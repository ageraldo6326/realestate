@extends('admin.layoutadmin')

@section('title', 'Tareas')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">CRM</a></li>
    <li class="breadcrumb-item active">Tareas</li>
@endsection

@section('page_title', 'Tareas programadas')

@section('page_actions')
    <div class="d-flex flex-wrap gap-2">
        <a href="{{ route('calendario') }}" class="btn btn-outline-primary btn-sm">
            <i class="fas fa-calendar-alt mr-1"></i> Calendario
        </a>
        <a href="{{ route('todo.create') }}" class="btn btn-primary btn-sm">
            <i class="fas fa-plus mr-1"></i> Nueva tarea
        </a>
    </div>
@endsection

@section('content')
    @php
        $tareasCollection = collect($tareas);
        $now = \Carbon\Carbon::now();
        $pendingKeywords = ['pendiente', 'programada', 'abierta'];
        $completedKeywords = ['completada', 'cerrada', 'finalizada'];
        $pendientes = $tareasCollection->filter(function ($tarea) use ($pendingKeywords) {
            return in_array(mb_strtolower((string) $tarea->todo_estatus), $pendingKeywords, true);
        })->count();
        $completadas = $tareasCollection->filter(function ($tarea) use ($completedKeywords) {
            return in_array(mb_strtolower((string) $tarea->todo_estatus), $completedKeywords, true);
        })->count();
        $vencidas = $tareasCollection->filter(function ($tarea) use ($now) {
            return \Carbon\Carbon::parse($tarea->fechaLimite)->lt($now);
        })->count();
        $proximaTarea = $tareasCollection->sortBy('fechaLimite')->first();
    @endphp

    <div class="container-fluid px-3">
        <div class="card border-0 shadow-sm overflow-hidden mb-3">
            <div class="card-body py-4" style="background: linear-gradient(135deg, #1d4ed8, #0f766e); color: #ffffff;">
                <div class="d-flex flex-wrap align-items-center justify-content-between gap-3">
                    <div>
                        <p class="text-uppercase small mb-2" style="letter-spacing:.14em; opacity:.75;">Productividad comercial</p>
                        <h2 class="h4 font-weight-bold mb-1">Control operativo de tareas y seguimientos</h2>
                        <p class="mb-0" style="opacity:.82; max-width:44rem;">Revisa prioridades, vencimientos y tareas completadas sin perder el contexto de cada cliente.</p>
                    </div>
                    @if ($proximaTarea)
                        <div class="rounded px-3 py-2" style="background: rgba(255,255,255,.14); min-width: 220px;">
                            <div class="small text-uppercase" style="opacity:.75; letter-spacing:.08em;">Próxima tarea</div>
                            <div class="font-weight-bold">{{ $proximaTarea->nombre }}</div>
                            <div class="small">{{ \Carbon\Carbon::parse($proximaTarea->fechaLimite)->format('d/m/Y h:i A') }}</div>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        @if (session('status'))
            <div class="alert alert-success shadow-sm border-0">{{ session('status') }}</div>
        @endif

        <div class="row">
            <div class="col-12 col-md-6 col-xl-3 mb-3">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body">
                        <span class="text-muted small text-uppercase">Total</span>
                        <div class="d-flex align-items-center justify-content-between mt-2">
                            <h3 class="h2 mb-0">{{ $tareasCollection->count() }}</h3>
                            <span class="badge badge-light">Agenda</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-6 col-xl-3 mb-3">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body">
                        <span class="text-muted small text-uppercase">Pendientes</span>
                        <div class="d-flex align-items-center justify-content-between mt-2">
                            <h3 class="h2 mb-0">{{ $pendientes }}</h3>
                            <span class="badge badge-warning">Seguimiento</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-6 col-xl-3 mb-3">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body">
                        <span class="text-muted small text-uppercase">Completadas</span>
                        <div class="d-flex align-items-center justify-content-between mt-2">
                            <h3 class="h2 mb-0">{{ $completadas }}</h3>
                            <span class="badge badge-success">Cierre</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-6 col-xl-3 mb-3">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body">
                        <span class="text-muted small text-uppercase">Vencidas</span>
                        <div class="d-flex align-items-center justify-content-between mt-2">
                            <h3 class="h2 mb-0">{{ $vencidas }}</h3>
                            <span class="badge badge-danger">Atención</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card border-0 shadow-sm">
            <div class="card-body p-0">
                @if ($tareasCollection->isEmpty())
                    <div class="text-center py-5 px-4">
                        <div class="mb-3"><i class="fas fa-calendar-check text-muted" style="font-size: 2rem;"></i></div>
                        <h3 class="h5 mb-1">No hay tareas registradas</h3>
                        <p class="text-muted mb-3">Crea la primera tarea para comenzar el seguimiento comercial.</p>
                        <a href="{{ route('todo.create') }}" class="btn btn-primary btn-sm">Crear tarea</a>
                    </div>
                @else
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead style="background:#f8fafc;">
                                <tr>
                                    <th class="border-0 pl-4">Tarea</th>
                                    <th class="border-0">Cliente</th>
                                    <th class="border-0">Tipo</th>
                                    <th class="border-0">Estatus</th>
                                    <th class="border-0">Fecha límite</th>
                                    <th class="border-0 text-right pr-4">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($tareasCollection as $tarea)
                                    @php
                                        $deadline = \Carbon\Carbon::parse($tarea->fechaLimite);
                                        $isOverdue = $deadline->lt($now);
                                    @endphp
                                    <tr>
                                        <td class="pl-4">
                                            <div class="font-weight-bold text-dark">{{ $tarea->nombre }}</div>
                                            <div class="text-muted small">#{{ $tarea->id }} · {{ \Illuminate\Support\Str::limit($tarea->descripcion, 90) }}</div>
                                        </td>
                                        <td>{{ $tarea->cliente ?: 'Sin cliente' }}</td>
                                        <td><span class="badge badge-light border">{{ $tarea->todo_tipo }}</span></td>
                                        <td>
                                            <span class="badge {{ $isOverdue ? 'badge-danger' : 'badge-secondary' }}">{{ $tarea->todo_estatus }}</span>
                                        </td>
                                        <td>
                                            <div class="font-weight-600">{{ $deadline->format('d/m/Y') }}</div>
                                            <div class="small text-muted">{{ $deadline->format('h:i A') }}</div>
                                        </td>
                                        <td class="text-right pr-4">
                                            <a href="{{ route('todo.edit', $tarea->id) }}" class="btn btn-outline-primary btn-sm">
                                                <i class="fas fa-pen mr-1"></i> Editar
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection

