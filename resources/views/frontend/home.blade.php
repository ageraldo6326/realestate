@extends('layout.layout')

@section('galeria')


    <div class="ltn__slider-area ltn__slider-3  section-bg-1">
    <div class="ltn__slide-one-active slick-slide-arrow-1 slick-slide-dots-1">
    <!-- ltn__slide-item -->
    @forelse ( $portadas as $portada)


            <div class="ltn__slide-item ltn__slide-item-2 ltn__slide-item-3-normal ltn__slide-item-3">
                <div class="ltn__slide-item-inner">
                    <div class="container">
                        <div class="row">
                            <div class="col-lg-12 align-self-center">
                                <div class="slide-item-info">
                                    <div class="slide-item-info-inner ltn__slide-animation">
                                        <div class="slide-video mb-50 d-none">
                                            <a class="ltn__video-icon-2 ltn__video-icon-2-border" href="{{ $portada->video }}" data-rel="lightcase:myCollection">
                                                <i class="fa fa-play"></i>
                                            </a>
                                        </div>
                                        <h6 class="slide-sub-title white-color--- animated"><span><i class="fas fa-home"></i></span> {{ $portada->minititulo }}</h6>
                                        <h1 class="slide-title animated col-10">{{ $portada->titulo }} <br></h1>
                                        <div class="slide-brief animated">
                                            <p>{{ $portada->descripcion }}</p>
                                        </div>
                                        <div class="btn-wrapper animated">
                                            <a href="{{ $portada->url1 }}" class="theme-btn-1 btn btn-effect-1">{{ $portada->enlace1 }}</a>
                                            <a class="ltn__video-play-btn bg-white" href="{{ $portada->video }}" data-rel="lightcase">
                                                <i class="icon-play  ltn__secondary-color"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <div class="slide-item-img">
                                    <img src="{{ $portada->foto }}" alt="#">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>    
@empty
    
@endforelse
    
    </div>
    </div>
    
@endsection

@section('zonas')

    <select class="nice-select">
    <option>Seleccionar Zona</option>
    @foreach ($zonas as $zona)
        <option value="{{$zona->id}}">{{ $zona->zona }}</option>        
    @endforeach
    </select>

@endsection

@section('disponibles_para')

    <select class="nice-select">
        <option>Disponible Para</option>
        @foreach ($disponibles_para as $disponible_para)
            <option value="{{ $disponible_para->id}}">{{ $disponible_para->disponible_para}}</option>            
        @endforeach
    </select>

@endsection

@section('tipo_propiedades')

    <select class="nice-select">
        <option>Tipo Propiedad</option>
        @foreach ($tipos_propiedades as $tipo_propiedad)
            <option value="{{ $tipo_propiedad->id}}">{{ $tipo_propiedad->tipo}}</option>            
        @endforeach
    </select>

@endsection

@section('propiedades_destacadas')
            <div class="row ltn__product-slider-item-four-active-full-width slick-arrow-1">
                <!-- ltn__product-item -->
                @forelse ( $propiedades as $propiedad)
                @if ($propiedad->destacada==1)
                <div class="col-lg-12">
                    <div class="ltn__product-item ltn__product-item-4 text-center---">
                        <div class="product-img">
                            <a href=" {{ route('product-details',$propiedad->id) }} "><img src="{{ $propiedad->foto_portada}}" alt="#"></a>
                            <div class="product-badge">
                                <ul>
                                    <li class="sale-badge bg-green">{{ $propiedad->disponible_para }}</li>
                                </ul>
                            </div>
                            <div class="product-img-location-gallery">
                                <div class="product-img-location">
                                    <ul>
                                        <li>
                                            <a href="locations.html"><i class="flaticon-pin"></i>{{ $propiedad->zona}} </a>
                                        </li>
                                    </ul>
                                </div>
                                <div class="product-img-gallery">
                                    <ul>
                                        {{-- <li>
                                            <a href=" {{ route('product-details',$propiedad->id) }} "><i class="fas fa-camera"></i> 4</a>
                                        </li>
                                        <li>
                                            <a href=" {{ route('product-details',$propiedad->id) }} "><i class="fas fa-film"></i> 2</a>
                                        </li> --}}
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="product-info">
                            <div class="product-price">
                                <span>${{ number_format($propiedad->precio,2)}}<label></label></span>
                            </div>
                            <h2 class="product-title"><a href=" {{ route('product-details',$propiedad->id) }} ">{{ $propiedad->titulo}}</a></h2>
                            <div class="product-description">
                                <p>{{ $propiedad->descripcion_corta}}</p>
                            </div>
                            <ul class="ltn__list-item-2 ltn__list-item-2-before">
                                <li><span>{{ $propiedad->habitaciones}} <i class="flaticon-bed"></i></span>
                                    Hab
                                </li>
                                <li><span>{{ $propiedad->banos}} <i class="flaticon-clean"></i></span>
                                    Baños
                                </li>                              
                                <li><span>{{ $propiedad->parqueos}} <i class="flaticon-car"></i></span>
                                    Parqueos
                                </li>                                
                                <li><span>{{ $propiedad->metraje}} <i class="flaticon-square-shape-design-interface-tool-symbol"></i></span>
                                    M2
                                </li>  
                            </ul>
                        </div>
                        <div class="product-info-bottom">
                            <div class="real-estate-agent">
                                <div class="agent-img">
                                    <a href="team-details.html"><img src="https://yt3.ggpht.com/nocyt2HhaPxyqjv9QdsGYLjwHdCStfQeggtqfot_o2FvA6LLMEk9YFyH31AVMCoFQy7yIQ1mVA=s900-c-k-c0x00ffffff-no-rj" alt="#"></a>
                                </div>
                                <div class="agent-brief">
                                    <h6><a href="team-details.html">Angel Geraldo</a></h6>
                                    <small>Agente inmobiliario</small>
                                </div>
                            </div>
                            <div class="product-hover-action">
                                <ul>
                                    <li>
                                        <a href="#" title="Quick View" data-toggle="modal" data-target="#quick_view_modal">
                                            <i class="flaticon-expand"></i>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#" title="Wishlist" data-toggle="modal" data-target="#liton_wishlist_modal">
                                            <i class="flaticon-heart-1"></i></a>
                                    </li>
                                    <li>
                                        <a href=" {{ route('product-details',$propiedad->id) }} " title="Product Details">
                                            <i class="flaticon-add"></i>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                @endif
                @empty
                    
                @endforelse    
            </div>

@endsection


@section('testimonios')

@forelse ($testimonios as $testimonio)
    <div class="col-lg-4">
        <div class="ltn__testimonial-item ltn__testimonial-item-7">
            <div class="ltn__testimoni-info">
                <p><i class="flaticon-left-quote-1"></i> 
                    {{ $testimonio->testimonio}}</p>
                <div class="ltn__testimoni-info-inner">
                    <div class="ltn__testimoni-img">
                        <img src="/img/testimonial/1.jpg" alt="#">
                    </div>
                    <div class="ltn__testimoni-name-designation">
                        <h5>{{ $testimonio->cliente }}</h5>
                    </div>
                </div>
            </div>
        </div>
    </div>
@empty
    
@endforelse

@endsection
