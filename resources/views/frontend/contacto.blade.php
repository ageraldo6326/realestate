@extends('layout.layout-landing')

@section('seo_title', 'Contacto — ' . ($inmo->titulo ?? 'Portal Inmobiliario'))
@section('seo_description', 'Contáctanos para más información sobre nuestras propiedades. Estamos aquí para ayudarte.')

@section('extra_styles')
<style>
    .page-hero { background: linear-gradient(135deg, var(--clr-dark) 0%, var(--clr-dark-2) 100%); padding: 3rem 0 2.5rem; }
    .page-hero .page-hero-title { font-family: var(--ff-head); font-size: clamp(1.8rem,4vw,2.4rem); color: var(--clr-white); font-weight: 700; margin-bottom: .5rem; }
    .page-hero .breadcrumb { background: transparent; padding: 0; margin: 0; font-size: .85rem; }
    .page-hero .breadcrumb-item a { color: var(--clr-accent); text-decoration: none; }
    .page-hero .breadcrumb-item.active { color: rgba(255,255,255,.7); }
    .page-hero .breadcrumb-item + .breadcrumb-item::before { color: rgba(255,255,255,.4); }
    .contact-section { padding: 4rem 0; background: var(--clr-bg); }
    .contact-info-card {
        background: var(--clr-white);
        border-radius: var(--radius);
        border: 1px solid var(--clr-border);
        box-shadow: var(--shadow-sm);
        padding: 2rem 1.5rem;
        text-align: center;
        transition: var(--transition);
        height: 100%;
    }
    .contact-info-card:hover { box-shadow: var(--shadow-md); transform: translateY(-3px); }
    .contact-icon {
        width: 60px; height: 60px;
        background: linear-gradient(135deg, var(--clr-accent), #e8c974);
        border-radius: 50%;
        display: flex; align-items: center; justify-content: center;
        margin: 0 auto 1.25rem;
        font-size: 1.3rem; color: var(--clr-dark);
    }
    .contact-info-card h3 { font-family: var(--ff-head); font-size: 1rem; font-weight: 700; color: var(--clr-dark); margin-bottom: .5rem; }
    .contact-info-card p { font-size: .9rem; color: var(--clr-gray); margin: 0; line-height: 1.6; }
    .contact-info-card a { color: var(--clr-accent); text-decoration: none; }
    .contact-info-card a:hover { text-decoration: underline; }
</style>
@endsection

@section('content')

<section class="page-hero" aria-label="Contacto">
    <div class="container">
        <h1 class="page-hero-title">Contáctanos</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Inicio</a></li>
                <li class="breadcrumb-item active">Contacto</li>
            </ol>
        </nav>
    </div>
</section>

<section class="contact-section">
    <div class="container">
        <div class="text-center mb-5">
            <span class="section-badge">CONTACTO</span>
            <h2 class="section-title">¿Cómo podemos ayudarte?</h2>
            <p class="section-subtitle">Nuestro equipo está listo para resolver tus dudas y ayudarte a encontrar la propiedad ideal.</p>
        </div>

        <div class="row g-4 justify-content-center">
            @if(isset($inmobiliaria->correo) && $inmobiliaria->correo)
            <div class="col-lg-4 col-md-6">
                <div class="contact-info-card">
                    <div class="contact-icon"><i class="fas fa-envelope"></i></div>
                    <h3>Correo Electrónico</h3>
                    <p><a href="mailto:{{ $inmobiliaria->correo }}">{{ $inmobiliaria->correo }}</a></p>
                </div>
            </div>
            @endif
            @if(isset($inmobiliaria->telefono) && $inmobiliaria->telefono)
            <div class="col-lg-4 col-md-6">
                <div class="contact-info-card">
                    <div class="contact-icon"><i class="fas fa-phone"></i></div>
                    <h3>Teléfono</h3>
                    <p><a href="tel:{{ $inmobiliaria->telefono }}">{{ $inmobiliaria->telefono }}</a></p>
                </div>
            </div>
            @endif
            @if(isset($inmobiliaria->direccion) && $inmobiliaria->direccion)
            <div class="col-lg-4 col-md-6">
                <div class="contact-info-card">
                    <div class="contact-icon"><i class="fas fa-location-dot"></i></div>
                    <h3>Dirección</h3>
                    <p>{{ $inmobiliaria->direccion }}</p>
                </div>
            </div>
            @endif
        </div>
    </div>
</section>

@endsection