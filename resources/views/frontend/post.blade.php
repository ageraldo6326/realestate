@extends('layout.layout-landing')

@section('seo_title', $post->titulo . ' — ' . ($inmo->titulo ?? 'Portal Inmobiliario'))
@section('seo_description', Str::limit(strip_tags($post->contenido), 160))

@section('extra_styles')
<style>
    .page-hero { background: linear-gradient(135deg, var(--clr-dark) 0%, var(--clr-dark-2) 100%); padding: 3rem 0 2.5rem; }
    .page-hero .page-hero-title { font-family: var(--ff-head); font-size: clamp(1.8rem,4vw,2.4rem); color: var(--clr-white); font-weight: 700; margin-bottom: .5rem; }
    .page-hero .breadcrumb { background: transparent; padding: 0; margin: 0; font-size: .85rem; }
    .page-hero .breadcrumb-item a { color: var(--clr-accent); text-decoration: none; }
    .page-hero .breadcrumb-item.active { color: rgba(255,255,255,.7); }
    .page-hero .breadcrumb-item + .breadcrumb-item::before { color: rgba(255,255,255,.4); }
    .post-section { padding: 4rem 0; background: var(--clr-bg); }
    .post-card {
        background: var(--clr-white);
        border-radius: var(--radius);
        border: 1px solid var(--clr-border);
        box-shadow: var(--shadow-sm);
        overflow: hidden;
    }
    .post-hero-img { width: 100%; max-height: 420px; object-fit: cover; display: block; }
    .post-body { padding: 2.5rem 3rem; }
    .post-meta { display: flex; align-items: center; gap: 1.5rem; margin-bottom: 1.5rem; flex-wrap: wrap; }
    .post-meta-item { font-size: .8rem; color: var(--clr-gray); display: flex; align-items: center; gap: .4rem; }
    .post-meta-item i { color: var(--clr-accent); }
    .post-title { font-family: var(--ff-head); font-size: clamp(1.5rem,3vw,2rem); font-weight: 700; color: var(--clr-dark); margin-bottom: 1.5rem; line-height: 1.3; }
    .post-content { font-size: 1rem; line-height: 1.85; color: #374151; }
    .post-content h2, .post-content h3 { font-family: var(--ff-head); color: var(--clr-dark); margin-top: 2rem; margin-bottom: .75rem; }
    .post-content img { max-width: 100%; border-radius: var(--radius-sm); margin: 1rem 0; }
    .post-content a { color: var(--clr-accent); }
    .post-footer { padding: 1.25rem 3rem; border-top: 1px solid var(--clr-border); }
    @media (max-width: 768px) {
        .post-body, .post-footer { padding: 1.5rem; }
    }
</style>
@endsection

@section('content')

@php
    $postPlaceholder = asset('assets/post-1.jpg');
@endphp

<section class="page-hero" aria-label="Artículo">
    <div class="container">
        <h1 class="page-hero-title">{{ $post->titulo }}</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Inicio</a></li>
                <li class="breadcrumb-item"><a href="{{ route('blog') }}">Novedades</a></li>
                <li class="breadcrumb-item active">Artículo</li>
            </ol>
        </nav>
    </div>
</section>

<section class="post-section">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <article class="post-card">
                    <img class="post-hero-img"
                         loading="eager"
                        src="{{ !empty($post->foto) ? asset('assets/'.$post->foto) : $postPlaceholder }}"
                        onerror="this.onerror=null;this.src='{{ $postPlaceholder }}';"
                         alt="{{ $post->titulo }}"
                         title="{{ $post->titulo }}">
                    <div class="post-body">
                        <div class="post-meta">
                            <span class="post-meta-item">
                                <i class="far fa-calendar-alt"></i>
                                <time datetime="{{ $post->created_at->format('Y-m-d') }}">{{ $post->created_at->format('d/m/Y') }}</time>
                            </span>
                            @if($post->autor)
                            <span class="post-meta-item">
                                <i class="fas fa-user"></i>
                                {{ $post->autor }}
                            </span>
                            @endif
                        </div>
                        <h2 class="post-title">{{ $post->titulo }}</h2>
                        <div class="post-content">
                            {!! $post->contenido !!}
                        </div>
                    </div>
                    <div class="post-footer">
                        <a href="{{ route('blog') }}" class="btn-primary-solid">
                            <i class="fas fa-arrow-left"></i> Volver a Novedades
                        </a>
                    </div>
                </article>
            </div>
        </div>
    </div>
</section>

@endsection