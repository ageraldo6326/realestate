@extends('admin.layoutadmin')

@section('title', 'Editar Disponible Para')

@section('breadcrumb')
    <li class="breadcrumb-item">Catalogos</li>
    <li class="breadcrumb-item"><a href="{{ route('disponiblepara.index') }}">Disponible para</a></li>
    <li class="breadcrumb-item active">Editar</li>
@endsection

@section('page_title', 'Editar Disponible Para')

@section('content')
    @include('admin.disponiblepara._form', [
        'mode' => 'edit',
        'disponiblepara' => $disponiblepara,
        'action' => route('disponiblepara.update', $disponiblepara->id),
    ])
@endsection

