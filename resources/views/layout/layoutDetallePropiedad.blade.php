@include('layout.encabezadoPropiedad')
        
        <!-- ltn__header-middle-area start -->


    <div class="ltn__utilize-overlay"></div>

    <!-- BREADCRUMB AREA START -->
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="ltn__breadcrumb-inner">
                        <span class="h1">Propiedad</span>
                        <div class="ltn__breadcrumb-list">
                            <ul>
                                <li><span class="ltn__secondary-color"><i class="fas fa-home"></i></span> Home</li>
                                <li>Propiedad</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- BREADCRUMB AREA END -->

    <!-- IMAGE SLIDER AREA START (img-slider-3) -->
    <div class="ltn__img-slider-area mb-90 d-none d-md-block">
        <div class="container-fluid">
            <div class="row ltn__image-slider-5-active slick-arrow-1 slick-arrow-1-inner ltn__no-gutter-all">

                @if($propiedad->foto_portada!="")
                <div class="col-lg-12">
                    <div class="ltn__img-slide-item-4">
                        <a href="{{ asset('assets/'.$propiedad->foto_portada) }}" data-rel="lightcase:myCollection">
                            <img loading="lazy" src="{{ asset('assets/'.$propiedad->foto_portada) }}" alt="Image">
                        </a>
                    </div>
                </div>
                @endif

                @if($propiedad->foto1!="")
                <div class="col-lg-12">
                    <div class="ltn__img-slide-item-4">
                        <a href="{{ asset('assets/'.$propiedad->foto1) }}" data-rel="lightcase:myCollection">
                            <img loading="lazy" src="{{ asset('assets/'.$propiedad->foto1) }}" alt="Image">
                        </a>
                    </div>
                </div>
                @endif

                @if($propiedad->foto2!="")
                <div class="col-lg-12">
                    <div class="ltn__img-slide-item-4">
                        <a href="{{ asset('assets/'.$propiedad->foto2) }}" data-rel="lightcase:myCollection">
                            <img loading="lazy" src="{{ asset('assets/'.$propiedad->foto2) }}" alt="Image">
                        </a>
                    </div>
                </div>
                @endif

                @if($propiedad->foto3!="")                
                <div class="col-lg-12">
                    <div class="ltn__img-slide-item-4">
                        <a href="{{ asset('assets/'.$propiedad->foto3) }}" data-rel="lightcase:myCollection">
                            <img loading="lazy" src="{{ asset('assets/'.$propiedad->foto3) }}" alt="Image">
                        </a>
                    </div>
                </div>
                @endif

                @if($propiedad->foto4!="")                
                <div class="col-lg-12">
                    <div class="ltn__img-slide-item-4">
                        <a href="{{ asset('assets/'.$propiedad->foto4) }}" data-rel="lightcase:myCollection">
                            <img loading="lazy" src="{{ asset('assets/'.$propiedad->foto4) }}" alt="Image">
                        </a>
                    </div>
                </div>
                @endif

                @if($propiedad->foto5!="")
                <div class="col-lg-12">
                    <div class="ltn__img-slide-item-4">
                        <a href="{{ asset('assets/'.$propiedad->foto5) }}" data-rel="lightcase:myCollection">
                            <img loading="lazy" src="{{ asset('assets/'.$propiedad->foto5) }}" alt="Image">
                        </a>
                    </div>
                </div>
                @endif   
                
                @if($propiedad->foto6!="")
                <div class="col-lg-12">
                    <div class="ltn__img-slide-item-4">
                        <a href="{{ asset('assets/'.$propiedad->foto6) }}" data-rel="lightcase:myCollection">
                            <img loading="lazy" src="{{ asset('assets/'.$propiedad->foto6) }}" alt="Image">
                        </a>
                    </div>
                </div>
                @endif       
                
                @if($propiedad->foto7!="")
                <div class="col-lg-12">
                    <div class="ltn__img-slide-item-4">
                        <a href="{{ asset('assets/'.$propiedad->foto7) }}" data-rel="lightcase:myCollection">
                            <img loading="lazy" src="{{ asset('assets/'.$propiedad->foto7) }}" alt="Image">
                        </a>
                    </div>
                </div>
                @endif          
                
                @if($propiedad->foto8!="")
                <div class="col-lg-12">
                    <div class="ltn__img-slide-item-4">
                        <a href="{{ asset('assets/'.$propiedad->foto8) }}" data-rel="lightcase:myCollection">
                            <img loading="lazy" src="{{ asset('assets/'.$propiedad->foto8) }}" alt="Image">
                        </a>
                    </div>
                </div>
                @endif                
                
            </div>
        </div>
    </div>
    <!-- IMAGE SLIDER AREA END -->

    <!-- SHOP DETAILS AREA START -->
        @yield('detalles')
    <!-- SHOP DETAILS AREA END -->

    <!-- PRODUCT SLIDER AREA START -->
    <div class="ltn__product-slider-area ltn__product-gutter pb-70 d-none">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="section-title-area ltn__section-title-2--- text-center---">
                        <span class="section-title h1">Related Properties</span>
                    </div>
                </div>
            </div>
            <div class="row ltn__related-product-slider-two-active slick-arrow-1">
            </div>
        </div>
    </div>
    <!-- PRODUCT SLIDER AREA END -->

    <!-- CALL TO ACTION START (call-to-action-6) -->
    @include('layout.footer')