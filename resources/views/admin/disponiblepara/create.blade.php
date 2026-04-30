@extends('admin.layoutadmin')

@section('title', 'Nuevo Disponible Para')

@section('breadcrumb')
    <li class="breadcrumb-item">Catalogos</li>
    <li class="breadcrumb-item"><a href="{{ route('disponiblepara.index') }}">Disponible para</a></li>
    <li class="breadcrumb-item active">Nuevo</li>
@endsection

@section('page_title', 'Nuevo Disponible Para')

@section('content')
    @include('admin.disponiblepara._form', [
        'mode' => 'create',
        'disponiblepara' => null,
        'action' => route('disponiblepara.store'),
    ])
@endsection