<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">


    
    <!-- Place favicon.png in the root directory -->
    <link rel="shortcut icon" href="{{ $inmobiliaria->favicon}}" type="image/x-icon" />
    <!-- Font Icons css -->
    <link rel="stylesheet" href="/css/font-icons.css">
    <!-- plugins css -->
    <link rel="stylesheet" href="/css/plugins.css">
    <!-- Main Stylesheet -->
    <link rel="stylesheet" href="/css/style.css">
    <!-- Responsive css -->
    <link rel="stylesheet" href="/css/responsive.css">  
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
            
    <style>
        /* Estilos adicionales para centrar el div */
        .container-centered {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            /* Asegura que el contenedor ocupe el 100% de la altura de la pantalla */
        }
    </style>
    <title>Propuesta</title>
</head>
<body>

    <div class="container mt-4">
        <div class="row">
            <div class="col-md-9">
                <picture>
                    <img src="{{$inmobiliaria->logo}}" class="img-fluid">
                  </picture>
            </div>
            <div class="col-md-3">
                <div class="text-center">
                    <div class="">
                        <a href="{{ route("propiedadesPorAgente",$usuario->id) }}"><img src="{{ $usuario->foto}}" height="300rem"
                                alt="Image"></a>
                    </div>
                    <div class="team-info">
                        <h4>{{ $usuario->name}}</h4>
                        <h6>{{ $usuario->titulo}}</h6>
                        <div class="ltn__social-media">
                            <h4>{{ $usuario->telefono}}</h4>
                            <ul>
                                <li><a href="#"><i class="fab fa-facebook-f"></i></a></li>
                                <li><a href="#"><i class="fab fa-twitter"></i></a></li>
                                <li><a href="#"><i class="fab fa-linkedin"></i></a></li>
                                <li><a href="#"><i class="fab fa-whatsapp"></i></a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>            
        </div>

        @if (isset($propiedades)) 
            <div class="row">
                <div class="col-md-12">
                    <h1>Propiedades en pesos</h1>
                </div>
            </div>        
        @endif

        <div class="row">
            @foreach ($propiedades as $propiedad)
                <div class="col-md-12">
                    <div class="row">
                        <div class="col-md-4 p-2">
                                <div id="carouselExample2{{ $propiedad->id}}" class="carousel slide" style="max-width: 600rem">
                                    <div class="carousel-inner">
                                        @if ($propiedad->foto_portada!="")
                                        <div class="carousel-item active">
                                            <img src="{{$propiedad->foto_portada}}" class="d-block w-100 rounded-2" alt="...">
                                        </div>
                                        @endif
                                        @if ($propiedad->foto1!="")
                                        <div class="carousel-item">
                                            <img src="{{$propiedad->foto1}}" class="d-block w-100 rounded-2" alt="...">
                                        </div>
                                        @endif
                                        @if ($propiedad->foto2!="")
                                        <div class="carousel-item">
                                            <img src="{{$propiedad->foto2}}" class="d-block w-100 rounded-2" alt="...">
                                        </div>
                                        @endif
                                        @if ($propiedad->foto3!="")
                                        <div class="carousel-item">
                                            <img src="{{$propiedad->foto3}}" class="d-block w-100 rounded-2" alt="...">
                                        </div>
                                        @endif
                                        @if ($propiedad->foto4!="")
                                        <div class="carousel-item">
                                            <img src="{{$propiedad->foto4}}" class="d-block w-100 rounded-2" alt="...">
                                        </div>
                                        @endif
                                        @if ($propiedad->foto5!="")
                                        <div class="carousel-item">
                                            <img src="{{$propiedad->foto5}}" class="d-block w-100 rounded-2" alt="...">
                                        </div>
                                        @endif
                                        @if ($propiedad->foto6!="")
                                        <div class="carousel-item">
                                            <img src="{{$propiedad->foto6}}" class="d-block w-100 rounded-2" alt="...">
                                        </div>
                                        @endif
                                        @if ($propiedad->foto7!="")
                                        <div class="carousel-item">
                                            <img src="{{$propiedad->foto7}}" class="d-block w-100 rounded-2" alt="...">
                                        </div>
                                        @endif
                                        @if ($propiedad->foto8!="")
                                        <div class="carousel-item">
                                            <img src="{{$propiedad->foto8}}" class="d-block w-100 rounded-2" alt="...">
                                        </div>
                                        @endif
                                    </div>
                                    <button class="carousel-control-prev" type="button" data-target="#carouselExample2{{ $propiedad->id}}"
                                        data-bs-slide="prev">
                                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                        <span class="visually-hidden">Previous</span>
                                    </button>
                                    <button class="carousel-control-next" type="button" data-target="#carouselExample2{{ $propiedad->id}}"
                                        data-bs-slide="next">
                                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                        <span class="visually-hidden">Next</span>
                                    </button>
                            
                            
                            
                                </div>

                        </div>
                        <div class="col-md-8 bg-muted">
                            <div class="row">
                                <div class="col-md-6">
                                    <h4>{{$propiedad->titulo}}</h4>
                                </div>
                                <div class="col-md-6">
                                    <h5>{{$propiedad->zona}}</h5>
                                </div>
                            </div>
                            <div class="row">
                                <div class="row">
                                    <div class="col-md-6">
                                        REF: {{$propiedad->referencia}}
                                    </div>
                                    <div class="col-md-6">
                                        Habitaciones: {{$propiedad->habitaciones}}
                                    </div>                                    
                                </div>
                
                                <div class="row">
                                    <div class="col-md-6">
                                        Baños: {{$propiedad->banos}}
                                    </div>
                                    <div class="col-md-6">
                                        Parqueo: {{$propiedad->parqueos}}
                                    </div>                                   
                                </div>
                
                                <div class="row">
                                    <div class="col-md-6">
                                        Metro: {{$propiedad->metraje}}
                                    </div>
                                    <div class="col-md-6">
                                        Mt Construcción: {{$propiedad->metraje_construccion}}
                                    </div> 
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        Estado: {{$propiedad->estado}}
                                    </div>
                                    <div class="col-md-6">
                                        Tipo: {{$propiedad->tipo}}
                                    </div>
                                </div>                                
                
                                <div class="row">
                                    <div class="col-md-6">
                                        Disponible para: {{$propiedad->disponible_para}}
                                    </div>
                                    <div class="col-md-6">
                                        Precio: {{$propiedad->moneda}} {{number_format($propiedad->precio)}}
                                    </div>
                                </div>
                

                
                                <div class="row">
                                    <div class="col-md-6 p-2">
                
                                    </div>


                                        <div x-data="{ open: false }"  class="row">
                                            <div class="col-8 mx-3">
                                                <a class="btn btn-primary btn-sm " @click="open = ! open" role="button">Descripción</a>

                                                <span x-show="open">
                                                <p x-show="open">{!! $propiedad->descripcion !!}</p>
                                                </span>
                                            </div>
                                            <div class="col-2">     
                                                <a name="" id="" class="btn btn-info text-white btn-sm" href="/admin/vercualquierpropiedad/{{$propiedad->id}}" target="_blank" role="button">Detalle</a>
                                            </div>                             
                                        </div>

                                </div>
                
                            </div>
                        </div>
                
                    </div>
                <div class="row">
            
                </div>
            
            </div>
            
            @endforeach

        </div>

        {{-- Propiedades en dolares  --}}
        @if (isset($propiedades_dolar)) 
            <div class="row">
                <div class="col-md-12">
                    <h1>Propiedades en dolares</h1>
                </div>
            </div>        
        @endif

        <div class="row">
            @foreach ($propiedades_dolar as $propiedad)
                <div class="col-md-12">
                    <div class="row">
                        <div class="col-md-4 p-2">
                                <div id="carouselExample2{{ $propiedad->id}}" class="carousel slide" style="max-width: 600rem">
                                    <div class="carousel-inner">
                                        @if ($propiedad->foto_portada!="")
                                        <div class="carousel-item active">
                                            <img src="{{$propiedad->foto_portada}}" class="d-block w-100 rounded-2" alt="...">
                                        </div>
                                        @endif
                                        @if ($propiedad->foto1!="")
                                        <div class="carousel-item">
                                            <img src="{{$propiedad->foto1}}" class="d-block w-100 rounded-2" alt="...">
                                        </div>
                                        @endif
                                        @if ($propiedad->foto2!="")
                                        <div class="carousel-item">
                                            <img src="{{$propiedad->foto2}}" class="d-block w-100 rounded-2" alt="...">
                                        </div>
                                        @endif
                                        @if ($propiedad->foto3!="")
                                        <div class="carousel-item">
                                            <img src="{{$propiedad->foto3}}" class="d-block w-100 rounded-2" alt="...">
                                        </div>
                                        @endif
                                        @if ($propiedad->foto4!="")
                                        <div class="carousel-item">
                                            <img src="{{$propiedad->foto4}}" class="d-block w-100 rounded-2" alt="...">
                                        </div>
                                        @endif
                                        @if ($propiedad->foto5!="")
                                        <div class="carousel-item">
                                            <img src="{{$propiedad->foto5}}" class="d-block w-100 rounded-2" alt="...">
                                        </div>
                                        @endif
                                        @if ($propiedad->foto6!="")
                                        <div class="carousel-item">
                                            <img src="{{$propiedad->foto6}}" class="d-block w-100 rounded-2" alt="...">
                                        </div>
                                        @endif
                                        @if ($propiedad->foto7!="")
                                        <div class="carousel-item">
                                            <img src="{{$propiedad->foto7}}" class="d-block w-100 rounded-2" alt="...">
                                        </div>
                                        @endif
                                        @if ($propiedad->foto8!="")
                                        <div class="carousel-item">
                                            <img src="{{$propiedad->foto8}}" class="d-block w-100 rounded-2" alt="...">
                                        </div>
                                        @endif
                                    </div>
                                    <button class="carousel-control-prev" type="button" data-target="#carouselExample2{{ $propiedad->id}}"
                                        data-bs-slide="prev">
                                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                        <span class="visually-hidden">Previous</span>
                                    </button>
                                    <button class="carousel-control-next" type="button" data-target="#carouselExample2{{ $propiedad->id}}"
                                        data-bs-slide="next">
                                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                        <span class="visually-hidden">Next</span>
                                    </button>
                            
                            
                            
                                </div>

                        </div>
                        <div class="col-md-8 bg-muted">
                            <div class="row">
                                <div class="col-md-6">
                                    <h4>{{$propiedad->titulo}}</h4>
                                </div>
                                <div class="col-md-6">
                                    <h5>{{$propiedad->zona}}</h5>
                                </div>
                            </div>
                            <div class="row">
                                <div class="row">
                                    <div class="col-md-6">
                                        REF: {{$propiedad->referencia}}
                                    </div>
                                    <div class="col-md-6">
                                        Habitaciones: {{$propiedad->habitaciones}}
                                    </div>
                                </div>
                            
                                <div class="row">
                                    <div class="col-md-6">
                                        Baños: {{$propiedad->banos}}
                                    </div>
                                    <div class="col-md-6">
                                        Parqueo: {{$propiedad->parqueos}}
                                    </div>
                                </div>
                            
                                <div class="row">
                                    <div class="col-md-6">
                                        Metro: {{$propiedad->metraje}}
                                    </div>
                                    <div class="col-md-6">
                                        Mt Construcción: {{$propiedad->metraje_construccion}}
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        Estado: {{$propiedad->estado}}
                                    </div>
                                    <div class="col-md-6">
                                        Tipo: {{$propiedad->tipo}}
                                    </div>
                                </div>
                            
                                <div class="row">
                                    <div class="col-md-6">
                                        Disponible para: {{$propiedad->disponible_para}}
                                    </div>
                                    <div class="col-md-6">
                                        Precio: {{$propiedad->moneda}} {{number_format($propiedad->precio)}}
                                    </div>
                                </div>
                            
                            
                            
                                <div class="row">
                                    <div class="col-md-6 p-2">
                            
                                    </div>
                            
                            
                                    <div x-data="{ open: false }" class="row mb-2">
                                        <div class="col-8 mx-3">
                                            <a class="btn btn-primary btn-sm " @click="open = ! open" role="button">Descripción</a>
                            
                                            <span x-show="open">
                                                <p x-show="open">{!! $propiedad->descripcion !!}</p>
                                            </span>
                                        </div>
                                        <div class="col-2">
                                            <a name="" id="" class="btn btn-info text-white btn-sm"
                                                href="/admin/vercualquierpropiedad/{{$propiedad->id}}" target="_blank" role="button">Detalle</a>
                                        </div>
                                    </div>
                            
                                </div>
                            
                            </div>
                        </div>
                
                    </div>
                <div class="row">
            
                </div>
            
            </div>
            
            @endforeach

        </div>        
    </div>
 
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
</script>    


</body>
</html>