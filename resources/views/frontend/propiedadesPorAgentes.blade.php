@extends('layout.layout-landing')

@section('seo_title', 'Propiedades del Agente — ' . ($inmo->titulo ?? 'Portal Inmobiliario'))
@section('seo_description', 'Explora el portafolio de propiedades de nuestros agentes especializados.')

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
    .pagination .page-link { color: var(--clr-dark); border-radius: var(--radius-sm)!important; margin: 0 2px; border: 1.5px solid var(--clr-border); font-size: .85rem; }
    .pagination .page-item.active .page-link { background: var(--clr-accent); border-color: var(--clr-accent); color: var(--clr-dark); font-weight: 600; }
</style>
@endsection

@section('content')

<section class="page-hero" aria-label="Propiedades por Agente">
    <div class="container">
        <h1 class="page-hero-title">Propiedades del Agente</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Inicio</a></li>
                <li class="breadcrumb-item"><a href="{{ route('equipo') }}">Agentes</a></li>
                <li class="breadcrumb-item active">Propiedades</li>
            </ol>
        </nav>
    </div>
</section>

<section class="listings-section">
    <div class="container">
        @livewire('propiedades-por-agentes', ['id_agente' => $id_agente])
    </div>
</section>

@endsection