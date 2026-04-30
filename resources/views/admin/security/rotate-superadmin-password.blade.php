@extends('admin.layoutadmin')

@section('title', 'Rotar clave superadmin')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item active">Seguridad</li>
@endsection

@section('page_title', 'Rotacion obligatoria de clave')

@section('content')
    <div class="container-fluid px-3">
        @if (session('warning'))
            <div class="alert alert-warning">{{ session('warning') }}</div>
        @endif

        <div class="row justify-content-center">
            <div class="col-lg-6 col-xl-5">
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-white border-0 pb-0">
                        <h3 class="h5 mb-1">Cambia la clave inicial del superadmin</h3>
                        <p class="text-muted mb-0">Por seguridad, debes definir una clave nueva para continuar en el panel.
                        </p>
                    </div>
                    <div class="card-body">
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul class="mb-0 pl-3">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form method="POST" action="{{ route('admin.superadmin.password.update') }}" autocomplete="off">
                            @csrf

                            <div class="form-group">
                                <label for="new_password">Nueva clave</label>
                                <input id="new_password" type="password" name="new_password" class="form-control" required
                                    minlength="8" autofocus>
                            </div>

                            <div class="form-group">
                                <label for="new_password_confirmation">Confirmar nueva clave</label>
                                <input id="new_password_confirmation" type="password" name="new_password_confirmation"
                                    class="form-control" required minlength="8">
                            </div>

                            <button type="submit" class="btn btn-primary btn-block">
                                Actualizar clave y continuar
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
