@extends('layout.layout-landing')

@section('seo_title', 'Propiedades en ' . ($zona->zona ?? '') . ' — ' . ($inmo->titulo ?? 'Portal Inmobiliario'))
@section('seo_description', 'Descubre propiedades disponibles en ' . ($zona->zona ?? '') . '. Encuentra tu hogar ideal.')

@section('extra_styles')
<style>
    .page-hero { background: linear-gradient(135deg, var(--clr-dark) 0%, var(--clr-dark-2) 100%); padding: 3rem 0 2.5rem; }
    .page-hero .page-hero-title { font-family: var(--ff-head); font-size: clamp(1.8rem,4vw,2.4rem); color: var(--clr-white); font-weight: 700; margin-bottom: .5rem; }
    .page-hero .breadcrumb { background: transparent; padding: 0; margin: 0; font-size: .85rem; }
    .page-hero .breadcrumb-item a { color: var(--clr-accent); text-decoration: none; }
    .page-hero .breadcrumb-item.active { color: rgba(255,255,255,.7); }
    .page-hero .breadcrumb-item + .breadcrumb-item::before { color: rgba(255,255,255,.4); }
    .listings-section { padding: 3rem 0 4rem; background: var(--clr-bg); }
    .empty-state { text-align: center; padding: 4rem 2rem; color: var(--clr-gray); }
    .empty-state i { font-size: 3rem; margin-bottom: 1rem; color: var(--clr-accent); display: block; }
</style>
@endsection

@section('content')

<section class="page-hero" aria-label="Propiedades por Zona">
    <div class="container">
        <h1 class="page-hero-title">{{ $zona->zona ?? 'Propiedades' }}</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Inicio</a></li>
                <li class="breadcrumb-item"><a href="{{ route('listapropiedades') }}">Propiedades</a></li>
                <li class="breadcrumb-item active">{{ $zona->zona ?? '' }}</li>
            </ol>
        </nav>
    </div>
</section>

<section class="listings-section">
    <div class="container">
        @livewire('buscar-propiedades-por-zonas', ['zona_id' => $zona_id, 'zona' => $zona])
    </div>
</section>

@endsection