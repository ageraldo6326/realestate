@extends('admin.layoutadmin')

@section('title', 'Editar enfoque')

@section('breadcrumb')
    <li class="breadcrumb-item">Contenido</li>
    <li class="breadcrumb-item"><a href="{{ route('enfoques.index') }}">Enfoques</a></li>
    <li class="breadcrumb-item active">Editar</li>
@endsection

@section('page_title', 'Editar enfoque')

@section('content')
    @include('admin.enfoques._form', [
        'mode' => 'edit',
        'action' => route('enfoques.update', $enfoque),
        'enfoque' => $enfoque,
    ])
@endsection

