<!doctype html>
<html class="no-js" lang="zxx">

<head>


    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>{{ $propiedad->titulo }}</title>
    <meta name="keywords" content="{{ $inmo->palabrasclaves }}" />
    <meta name="description" content="{{ $propiedad->metadescription }}">
    @if (isset($inmo->dominio))
    <link rel="canonical" href="{{ preg_replace('/^http:/i', 'https:', url()->current()) }}" />
    @endif
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    

    <!-- Place favicon.png in the root directory -->
    <link rel="shortcut icon" href="{{ optional($inmo)->publicFaviconUrl() }}" type="image/x-icon" />
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
                                <li><a href=""><i class="icon-mail"></i>{{ $inmo->correo }}</a></li>
                                <li><a href=""><i class="icon-placeholder"></i>{{ $inmo->direccion }}</a></li>
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

        <!-- ltn__header-middle-area start -->
        {{-- ltn__header-sticky permite hacer el encabezado que de deslice --}}
        <div class="ltn__header-middle-area ltn__sticky-bg-white">
            <div class="container">
                <div class="row">
                    <div class="col">
                        <div class="site-logo-wrap">
                            <div class="site-logo">
                                <a href=" {{ route("home") }} "><img src="{{ optional($inmo)->publicLogoUrl() }}" alt="Logo"></a>
                            </div>
                            {{-- <div class="get-support clearfix d-none">
                                <div class="get-support-icon">
                                    <i class="icon-call"></i>
                                </div>
                                <div class="get-support-info">
                                    <h6>Get Support</h6>
                                    <h4><a href="tel:+123456789">123-456-789-10</a></h4>
                                </div>
                            </div> --}}
                        </div>
                    </div>
                    <div class="col header-menu-column">
                        <div class="header-menu d-none d-xl-block">
                            <nav>
                                <div class="ltn__main-menu">
                                    <ul>
                                        <li class="menu-icon"><a href=" {{ route("home") }} ">Home</a>                                          
                                        </li>
                                        <li class="menu-icon"><a href="{{ route("listapropiedades")}}">Propiedades</a>
                                        </li>
                                        <li class="menu-icon"><a href="{{ route("equipo")}}">Agentes</a>
                                        </li>                                        
                                        <li class="menu-icon"><a href="{{ route("quienessomos")}}">Quienes Somos</a>
                                        </li>
                                        <li class="menu-icon"><a href="{{ route("blog")}}">Novedades</a>
                                        </li>
                                        <li class="menu-icon"><a href="{{ route("contactos")}}">Contactos</a>
                                        </li>
                                    </ul>
                                </div>
                            </nav>
                        </div>
                    </div>
                    <div class="ltn__header-options ltn__header-options-2 mb-sm-20">
                        <!-- header-search-1 -->
                        <div class="header-search-wrap">
                            {{-- <div class="header-search-1">
                                <div class="search-icon">
                                    <i class="icon-search for-search-show"></i>
                                    <i class="icon-cancel  for-search-close"></i>
                                </div>
                            </div> --}}
                            <div class="header-search-1-form">
                                <form id="#" method="get"  action="#">
                                    <input type="text" name="search" value="" placeholder="Search here..."/>
                                    {{-- Boton escondido header-search --}}
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

                                    <a href="#" aria-label="LoginIcon"><i class="icon-user"></i></a>
                                    <ul>
                                        <li><a aria-label="Log in" href="{{ route('login') }}">Log in</a></li>
                                    </ul>
                                </li>
                            </ul>
                        </div>
                        <!-- mini-cart -->
                        {{-- <div class="mini-cart-icon">
                            <a href="#ltn__utilize-cart-menu" class="ltn__utilize-toggle">
                                <i class="icon-shopping-cart"></i>
                                <sup>2</sup>
                            </a>
                        </div> --}}
                        <!-- mini-cart -->
                        <!-- Mobile Menu Button -->
                        <div class="mobile-menu-toggle d-xl-none">
                            <a href="#ltn__utilize-mobile-menu" class="ltn__utilize-toggle" aria-label="Menu Toggle">
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

    <!-- Utilize Cart Menu Start -->
    {{-- <div id="ltn__utilize-cart-menu" class="ltn__utilize ltn__utilize-cart-menu">
        <div class="ltn__utilize-menu-inner ltn__scrollbar">
            <div class="ltn__utilize-menu-head">
                <span class="ltn__utilize-menu-title">Cart</span>
                <button class="ltn__utilize-close">×</button>
            </div>
            <div class="mini-cart-product-area ltn__scrollbar">
                <div class="mini-cart-item clearfix">
                    <div class="mini-cart-img">
                        <a href="#"><img src="/img/product/1.png" alt="Image"></a>
                        <span class="mini-cart-item-delete"><i class="icon-cancel"></i></span>
                    </div>
                    <div class="mini-cart-info">
                        <h6><a href="#">Wheel Bearing Retainer</a></h6>
                        <span class="mini-cart-quantity">1 x $65.00</span>
                    </div>
                </div>
                <div class="mini-cart-item clearfix">
                    <div class="mini-cart-img">
                        <a href="#"><img src="/img/product/2.png" alt="Image"></a>
                        <span class="mini-cart-item-delete"><i class="icon-cancel"></i></span>
                    </div>
                    <div class="mini-cart-info">
                        <h6><a href="#">3 Rooms Manhattan</a></h6>
                        <span class="mini-cart-quantity">1 x $85.00</span>
                    </div>
                </div>
                <div class="mini-cart-item clearfix">
                    <div class="mini-cart-img">
                        <a href="#"><img src="/img/product/3.png" alt="Image"></a>
                        <span class="mini-cart-item-delete"><i class="icon-cancel"></i></span>
                    </div>
                    <div class="mini-cart-info">
                        <h6><a href="#">OE Replica Wheels</a></h6>
                        <span class="mini-cart-quantity">1 x $92.00</span>
                    </div>
                </div>
                <div class="mini-cart-item clearfix">
                    <div class="mini-cart-img">
                        <a href="#"><img src="/img/product/4.png" alt="Image"></a>
                        <span class="mini-cart-item-delete"><i class="icon-cancel"></i></span>
                    </div>
                    <div class="mini-cart-info">
                        <h6><a href="#">Shock Mount Insulator</a></h6>
                        <span class="mini-cart-quantity">1 x $68.00</span>
                    </div>
                </div>
            </div>
            <div class="mini-cart-footer">
                <div class="mini-cart-sub-total">
                    <h5>Subtotal: <span>$310.00</span></h5>
                </div>
                <div class="btn-wrapper">
                    <a href="cart.html" class="theme-btn-1 btn btn-effect-1">View Cart</a>
                    <a href="cart.html" class="theme-btn-2 btn btn-effect-2">Checkout</a>
                </div>
                <p>Free Shipping on All Orders Over $100!</p>
            </div>

        </div>
    </div> --}}
    <!-- Utilize Cart Menu End -->

<!-- Utilize Mobile Menu Start -->
    <div id="ltn__utilize-mobile-menu" class="ltn__utilize ltn__utilize-mobile-menu">
        <div class="ltn__utilize-menu-inner ltn__scrollbar">
    
            <div class="ltn__utilize-menu-head">
                <div class="site-logo">
                    <a href="/" aria-label="Logo"><img src="/img/logo.png" alt="Logo"></a>
                </div>
                {{-- Boton escondido --}}
                {{-- <button class="ltn__utilize-close">×</button> --}}
            </div>
    
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
