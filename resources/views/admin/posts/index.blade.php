@extends('admin.layoutadmin')

@section('title', 'Posts')

@section('breadcrumb')
    <li class="breadcrumb-item">Contenido</li>
    <li class="breadcrumb-item active">Posts</li>
@endsection

@section('page_title', 'Blog / Posts')

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
                        <h2 class="h4 mb-2 font-weight-bold">Blog / Posts</h2>
                        <p class="mb-0 text-white-50">Gestiona publicaciones del blog con busqueda, SEO y formularios
                            separados de crear y editar.</p>
                    </div>
                    <div class="mt-3 mt-md-0 text-md-right">
                        <div class="text-uppercase small text-white-50">Registros encontrados</div>
                        <div class="h3 mb-0 font-weight-bold">{{ $posts->total() }}</div>
                    </div>
                </div>
            </section>

            <section class="card content-panel">
                <div class="card-body p-4">
                    <div class="d-flex flex-column flex-lg-row justify-content-between align-items-lg-center mb-4">
                        <div>
                            <h3 class="h5 mb-1">Listado de posts</h3>
                            <p class="text-muted mb-0">Busca por titulo, slug, contenido o ID.</p>
                        </div>
                        <a href="{{ route('posts.create') }}" class="btn btn-primary mt-3 mt-lg-0 px-4">Nuevo post</a>
                    </div>

                    <form method="GET" action="{{ route('posts.index') }}" class="row mb-4">
                        <div class="col-lg-8">
                            <label for="search" class="small text-muted font-weight-semibold">Buscar post</label>
                            <div class="input-group input-group-lg">
                                <input type="text" class="form-control" id="search" name="search"
                                    value="{{ $search }}" placeholder="Ej. mercado, inversion o consejos de venta">
                                <div class="input-group-append ml-2">
                                    <button class="btn btn-outline-primary" type="submit">Buscar</button>
                                    <a href="{{ route('posts.index') }}" class="btn btn-outline-secondary ml-2">Limpiar</a>
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
                                    <th>Post</th>
                                    <th class="text-right">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($posts as $post)
                                    <tr>
                                        <td class="font-weight-semibold">{{ $post->id }}</td>
                                        <td>
                                            @if ($post->foto)
                                                <img src="{{ asset(ltrim($post->foto, '/')) }}" class="content-thumb"
                                                    alt="{{ $post->titulo }}">
                                            @endif
                                        </td>
                                        <td>
                                            <div class="font-weight-semibold">{{ $post->titulo }}</div>
                                            <div class="small text-muted">Slug: {{ $post->slug ?: 'sin slug' }}</div>
                                            <div class="small text-muted">{{ $post->activo ? 'Publicado' : 'Borrador' }}
                                            </div>
                                        </td>
                                        <td class="text-right">
                                            <div class="content-actions">
                                                <a href="{{ route('posts.edit', $post) }}"
                                                    class="btn btn-outline-primary btn-sm">Editar</a>
                                                <form action="{{ route('posts.destroy', $post) }}" method="POST"
                                                    class="js-delete-form" data-name="{{ $post->titulo }}">
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
                                        <td colspan="4" class="text-center py-5 text-muted">No hay posts para mostrar con
                                            el criterio actual.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-4">{{ $posts->links('pagination::bootstrap-4') }}</div>
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
                        title: '¿Eliminar este post?',
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
