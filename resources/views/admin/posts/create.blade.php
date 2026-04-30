@extends('admin.layoutadmin')

@section('title', 'Nuevo post')

@section('breadcrumb')
    <li class="breadcrumb-item">Contenido</li>
    <li class="breadcrumb-item"><a href="{{ route('posts.index') }}">Posts</a></li>
    <li class="breadcrumb-item active">Crear</li>
@endsection

@section('page_title', 'Nuevo post')

@section('content')
    @include('admin.posts._form', [
        'mode' => 'create',
        'action' => route('posts.store'),
    ])
@endsection

