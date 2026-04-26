<!doctype html>
<html class="no-js" lang="zxx">

<head>

    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    @if (isset($inmo->titulo))
        <title>{{ $inmo->titulo }}</title>    
    @else
        <title>Configurar Titulo</title>
    @endif
    
    <meta name="keywords" content="{{ $inmo->palabrasclaves }}" />
    @if (isset($inmo->metadescription)) 
        <meta name="description" content="{{ $inmo->metadescription }}">
    @endif
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link rel="canonical" href="{{ preg_replace('/^http:/i', 'https:', url()->current()) }}" />

    <!-- Place favicon.png in the root directory -->
    <link rel="shortcut icon" href="{{'assets/'.$inmo->favicon}}" type="image/x-icon" />
    <!-- Font Icons css -->
    <link rel="stylesheet" href="/css/font-icons.css">
    <!-- plugins css -->
    <link rel="stylesheet" href="/css/plugins.css">
    <!-- Main Stylesheet -->
    <link rel="stylesheet" href="/css/style.css">
    <!-- Responsive css -->
    <link rel="stylesheet" href="/css/responsive.css">
</head>

<body>
    <!--[if lte IE 9]>
        <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="https://browsehappy.com/">upgrade your browser</a> to improve your experience and security.</p>
    <![endif]-->

    <!-- Add your site or application content here -->

<!-- Body main wrapper start -->
<div class="body-wrapper">

    <!-- HEADER AREA START (header-5) -->
    <header class="ltn__header-area ltn__header-5 ltn__header-transparent--- gradient-color-4---">
        <!-- ltn__header-top-area start -->
        <div class="ltn__header-top-area section-bg-6 top-area-color-white---">
            <div class="container">
                <div class="row">
                    <div class="col-md-7">
                        <div class="ltn__top-bar-menu">
                            <ul>
                                <li><a href="mailto:@if (isset($inmo->correo)) {{ $inmo->correo }} @endif?Subject=Flower%20greetings%20to%20you"><i class="icon-mail"></i>@if (isset($inmo->correo)) {{ $inmo->correo }} @endif </a></li>
                                <li><a href=""><i class="icon-placeholder"></i>@if (isset($inmo->direccion)) {{ $inmo->direccion }} @endif</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-md-5">
                        <div class="top-bar-right text-right">
                            <div class="ltn__top-bar-menu">
                                <ul>
                                    <li>
                                        <!-- ltn__social-media -->
                                        <div class="ltn__social-media">
                                            <ul>
                                                <li><a href="@if (isset($inmo->facebook)) {{ $inmo->facebook }} @endif" title="Facebook"><i class="fab fa-facebook-f m-3 fa-2x"></i></a></li>
                                                <li><a href="@if (isset($inmo->instagram)) {{ $inmo->instagram }} @endif" title="Instagram"><i class="fab fa-instagram m-3 fa-2x"></i></a></li>
                                                <li><a href="@if (isset($inmo->whatsapp)) {{ $inmo->whatsapp }} @endif" title="Whatsapp"><i class="fab fa-whatsapp m-3 fa-2x"></i></a></li>
                                                <li><a href="@if (isset($inmo->tiktok)) {{ $inmo->tiktok }} @endif" title="Tiktok"><i class="fab fa-tiktok m-3 fa-2x"></i></a></li>
                                            </ul>
                                        </div>
                                    </li>
                                    <li>
                                        <!-- header-top-btn -->
                                        <div class="header-top-btn">
                                            <a href="tel: @if (isset($inmo->telefono)) {{ $inmo->telefono }} @endif">@if (isset($inmo->telefono)) {{ $inmo->telefono }} @endif</a>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- ltn__header-top-area end -->

        <!-- ltn__header-middle-area start ltn__header-sticky -->
        <div class="ltn__header-middle-area  ltn__sticky-bg-white">
            <div class="container">
                <div class="row">
                    <div class="col">
                        <div class="site-logo-wrap">
                            <div class="site-logo">
                                <a href=" {{ route("home") }} "><img src="{{ asset('assets/'.$inmo->logo) }}" alt="Logo" title="Logo"></a>
                            </div>
                        </div>
                    </div>
                    <div class="col header-menu-column">
                        <div class="header-menu d-none d-xl-block">
                            <nav>
                                <div class="ltn__main-menu">
                                    <ul>
                                        <li class="menu-icon"><a href=" {{ route("home") }} ">Home</a></li>                                           
                                        <li class="menu-icon"><a href="{{ route("listapropiedades")}}">Propiedades</a></li>
                                        <li class="menu-icon"><a href="{{ route("equipo")}}">Agentes</a></li>                                        
                                        <li class="menu-icon"><a href="{{ route("quienessomos")}}">Quienes Somos</a></li>
                                        <li class="menu-icon"><a href="{{ route("blog")}}">Novedades</a></li>
                                        <li class="menu-icon"><a href="{{ route("contactos")}}">Contactos</a></li>
                                        
                                    </ul>
                                </div>
                            </nav>
                        </div>
                    </div>
                    <div class="ltn__header-options ltn__header-options-2 mb-sm-20">
                        <!-- header-search-1 -->
                        <div class="header-search-wrap">
                            <div class="header-search-1-form">
                                <form id="#" method="get"  action="#">
                                    <input type="text" name="search" value="" placeholder="Buscar..."/>
                                    {{-- <button type="submit">
                                        <span><i class="icon-search"></i></span>
                                    </button> --}}
                                </form>
                            </div>
                        </div>
                        <!-- user-menu -->
                        <div class="ltn__drop-menu user-menu">
                            <ul>
                                <li>
                                    <a href="#"><i class="icon-user"></i></a>
                                    <ul>
                                        <li><a href="{{ route('login') }}">Log in</a></li>
                                    </ul>
                                </li>
                            </ul>
                        </div>
                        <!-- Mobile Menu Button -->
                        <div class="mobile-menu-toggle d-xl-none">
                            <a href="#ltn__utilize-mobile-menu" class="ltn__utilize-toggle">
                                <svg viewBox="0 0 800 600">
                                    <path d="M300,220 C300,220 520,220 540,220 C740,220 640,540 520,420 C440,340 300,200 300,200" id="top"></path>
                                    <path d="M300,320 L540,320" id="middle"></path>
                                    <path d="M300,210 C300,210 520,210 540,210 C740,210 640,530 520,410 C440,330 300,190 300,190" id="bottom" transform="translate(480, 320) scale(1, -1) translate(-480, -318) "></path>
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- ltn__header-middle-area end -->
    </header>
    <!-- HEADER AREA END -->

    <!-- Utilize Mobile Menu Start -->
    <div id="ltn__utilize-mobile-menu" class="ltn__utilize ltn__utilize-mobile-menu">
        <div class="ltn__utilize-menu-inner ltn__scrollbar">

            {{-- <div class="ltn__utilize-menu-head">
                <div class="site-logo">
                    <a href="index.html"><img src="/img/logo.png" alt="Logo"></a>
                </div>
                <button class="ltn__utilize-close">×</button>
            </div> --}}

            <div class="ltn__utilize-menu">
                <ul>
                    <li class="menu-icon"><a href="{{ route("home")}}">Home</a></li>                                                            
                    <li class=" menu-icon"><a href="{{ route("listapropiedades")}}">Propiedades</a></li>                    
                    <li class="menu-icon"><a href="{{ route("equipo")}}">Agentes</a></li>
                    <li class="menu-icon"><a href="{{ route("quienessomos")}}">Quienes Somos</a></li>
                    <li class="menu-icon"><a href="{{ route("blog")}}">Novedades</a></li>
                    <li class="menu-icon"><a href="{{ route("contactos")}}">Contactos</a></li>                
                </ul>
            </div>            

            <div class="ltn__social-media-2">
                <ul>
                    <li><a href="#" title="Facebook"><i class="fab fa-facebook-f"></i></a></li>
                    <li><a href="#" title="Twitter"><i class="fab fa-twitter"></i></a></li>
                    <li><a href="#" title="Linkedin"><i class="fab fa-linkedin"></i></a></li>
                    <li><a href="#" title="Instagram"><i class="fab fa-instagram"></i></a></li>
                </ul>
            </div>

        </div>
    </div>
    <!-- Utilize Mobile Menu End -->

    <div class="ltn__utilize-overlay"></div>

    <!-- SLIDER AREA START (slider-3) -->