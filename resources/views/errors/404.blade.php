@extends('layout.layout-landing')

@section('seo_title', 'Página no encontrada')
@section('seo_description', 'La página solicitada no está disponible.')
@section('seo_robots', 'noindex, nofollow')

@section('content')
    <section class="py-5 bg-light" aria-labelledby="not-found-title">
        <div class="container py-5 text-center">
            <div class="display-1 fw-bold text-primary mb-3" aria-hidden="true">404</div>
            <h1 id="not-found-title" class="h2 mb-3">Página no encontrada</h1>
            <p class="text-muted mb-4">El enlace puede haber cambiado o el contenido ya no está disponible.</p>
            <a href="{{ route('home') }}" class="btn btn-primary px-4">Volver al inicio</a>
        </div>
    </section>
@endsection
