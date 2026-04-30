@extends('admin.layoutadmin')

@section('title', 'Editar usuario')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('usuarios.index') }}">Usuarios</a></li>
    <li class="breadcrumb-item active">Editar</li>
@endsection

@section('page_title', 'Editar usuario')

@section('content')
    @php
        $isProtectedSuperadmin = $usuario->isConfiguredSuperadmin() && !\App\Models\User::superadminMutationsAllowed();
    @endphp

    @include('admin.usuarios._form', [
        'mode' => 'edit',
        'usuario' => $usuario,
        'isProtectedSuperadmin' => $isProtectedSuperadmin,
        'action' => route('usuarios.update', $usuario->id),
    ])

@endsection
