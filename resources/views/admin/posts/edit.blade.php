@extends('admin.layoutadmin')

@section('title', 'Editar post')

@section('breadcrumb')
    <li class="breadcrumb-item">Contenido</li>
    <li class="breadcrumb-item"><a href="{{ route('posts.index') }}">Posts</a></li>
    <li class="breadcrumb-item active">Editar</li>
@endsection

@section('page_title', 'Editar post')

@section('content')
    @include('admin.posts._form', [
        'mode' => 'edit',
        'action' => route('posts.update', $post),
        'post' => $post,
    ])
@endsection

