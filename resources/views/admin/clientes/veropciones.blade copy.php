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
    <div class="container-fluid">
        <div class="row mx-5">
            <div class="col-md-2 d-md-block mt-4">                

                    <div class="ltn__team-item ltn__team-item-3---">
                        <div class="team-img mt-4">
                            <a href="{{ route("propiedadesPorAgente",$usuario->id) }}"><img src="{{ $usuario->foto}}" height="300px" alt="Image"></a>
                        </div>
                        <div class="team-info">
                            <h4>{{ $usuario->name}}</h4>
                            <h6 class="ltn__secondary-color">{{ $usuario->titulo}}</h6>
                            <div class="ltn__social-media">
                                
                                <h4>{{ $usuario->telefono}}</h4>
                                <ul>
                                    <li><a href="#"><i class="fab fa-facebook-f"></i></a></li>
                                    <li><a href="#"><i class="fab fa-twitter"></i></a></li>
                                    <li><a href="#"><i class="fab fa-linkedin"></i></a></li>
                                </ul>
                            </div>
                        </div>
                    </div>

            </div>

            @foreach ( $propiedades as $propiedad) 

                <div class="d-xl-none m-3">
                    <div id="carouselExample{{ $propiedad->id}}" class="carousel slide w-100">
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
                        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExample{{ $propiedad->id}}" data-bs-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Previous</span>
                        </button>
                        <button class="carousel-control-next" type="button" data-bs-target="#carouselExample{{ $propiedad->id}}" data-bs-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Next</span>
                        </button>

                        <div class="property-detail-info-list mb-60">                          
                            <ul>
                                <li><label>REF:</label> <span>{{ $propiedad->referencia }}</span></li>
                                <li><label>Metros: </label> <span>{{ $propiedad->metraje }} M2</span></li>
                                <li><label>Mt Construcción:</label> <span>{{ $propiedad->metraje_construccion }} </span></li>
                                <li><label>Habitaciones:</label> <span>{{ $propiedad->habitaciones }}</span></li>
                                <li><label>Estado:</label> <span class="btn-sm btn-success text-white rounded-0 text-success">{{ $propiedad->estado }}</span></li>                              

                                {{-- <li><label>Year built:</label> <span>1992</span></li> --}}
                            </ul>
                            <ul>
                                <li><label>Baños:</label> <span>{{ $propiedad->banos }}</span></li>                                
                                {{-- <li><label>Lot dimensions:</label> <span>120 sqft</span></li> --}}
                                <li><label>Parqueos:</label> <span>{{ $propiedad->parqueos }}</span></li>
                                <li><label>Disponible Para:</label> <span>{{ $propiedad->disponible_para }}</span></li>
                                <li><label>Precio:</label> <span>{{ $propiedad->Moneda }} {{  number_format($propiedad->precio,2) }}</span></li> 
                                <li><label>Tipo:</label> <span class="btn-sm btn-success text-white rounded-0 text-success">{{ $propiedad->tipo
                                        }}</span></li>                               
                            </ul>
                        </div> 

                        <div x-data="{ open: false }"  class="row">
                            <div class="col-6">
                                <a class="btn btn-primary btn-sm " @click="open = ! open" role="button">Descripción</a>

                                <span x-show="open">
                                <p x-show="open">{!! $propiedad->descripcion !!}</p>
                                </span>
                            </div>
                            <div class="col-6">     
                                <a name="" id="" class="btn btn-info text-white btn-sm" href="/admin/vercualquierpropiedad/{{$propiedad->id}}" target="_blank" role="button">Detalle</a>
                            </div>                             
                        </div>
                                                  
                    </div>
                    <div>

                        
                    </div>  
                </div>            
            
            @endforeach

            <div class="col-md-10 mt-4">
                <div class="row">
                    <div class="col-12">
                        Propuesta en RD$
                    </div>
                </div>                
                <table class="table mt-0 rounded table-borderless hover">

                    @foreach ( $propiedades as $propiedad)
                    
                    <tr class="d-none d-xl-block">
                        <td class="d-none d-lg-table-cell" scope="col" style="width: 1px;">{{ $propiedad->id}}</td>
                        <td class="d-none d-lg-table-cell" style="width: 500px;">
                            <div id="carouselExample2{{ $propiedad->id}}" class="carousel slide" style="max-width: 600px">
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
                                <button class="carousel-control-prev" type="button" data-bs-target="#carouselExample2{{ $propiedad->id}}" data-bs-slide="prev">
                                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                    <span class="visually-hidden">Previous</span>
                                </button>
                                <button class="carousel-control-next" type="button" data-bs-target="#carouselExample2{{ $propiedad->id}}" data-bs-slide="next">
                                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                    <span class="visually-hidden">Next</span>
                                </button>
                            


                            </div>     
                        </td>
                        <td class="d-none d-lg-table-cell">
                            <table class="table mt-0 table-borderless " style="width: 100%;">
                                <tr>
                                    <td>
                                        <table style="width: 100%">
                                            <tr class="col-md-3">
                                                <td class="fw-bold w-25">{{ $propiedad->titulo}}                                   
                                                </td>
                                                <td class="w-25">{{ $propiedad->zona}}</td>
                                            </tr>
                                        </table>                        
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <table class="bg-white" style="width: 100%">
                                            <tr>
                                                <td>
                                                    
                                                    <div class="property-detail-info-list section-bg-1 clearfix mb-60">                          
                                                        <ul>
                                                            <li><label>REF:</label> <span>{{ $propiedad->referencia }}</span></li>
                                                            <li><label>Metros: </label> <span>{{ $propiedad->metraje }} M2</span></li>
                                                            <li><label>Mt Construcción:</label> <span>{{ $propiedad->metraje_construccion }} </span></li>
                                                            <li><label>Habitaciones:</label> <span>{{ $propiedad->habitaciones }}</span></li>
                                                            <li><label>Estado:</label> <span class="btn-sm btn-success text-white rounded-0 text-success">{{ $propiedad->estado }}</span></li>

                                                            {{-- <li><label>Year built:</label> <span>1992</span></li> --}}
                                                        </ul>
                                                        <ul>
                                                            <li><label>Baños:</label> <span>{{ $propiedad->banos }}</span></li>                                
                                                            {{-- <li><label>Lot dimensions:</label> <span>120 sqft</span></li> --}}
                                                            <li><label>Parqueos:</label> <span>{{ $propiedad->parqueos }}</span></li>
                                                            <li><label>Disponible Para:</label> <span>{{ $propiedad->disponible_para }}</span></li>
                                                            <li><label>Precio:</label> <span>{{ $propiedad->Moneda }} {{  number_format($propiedad->precio,2) }}</span></li>                                
                                                            <li><label>Tipo:</label> <span class="btn-sm btn-success text-white rounded-0 text-success">{{ $propiedad->tipo
                                                                                                    }}</span></li>
                                                        </ul>
                                                    </div>

                                                </td> 
                                            </tr>
                                        </table> 
                                    </td>                    
                                </tr>
                                <tr>
                                    <td class="">
                                        <div x-data="{ open: false }"  class="row">
                                            <div class="col-6">
                                                <a class="btn btn-primary btn-sm " @click="open = ! open" role="button">Descripción</a>

                                                <span x-show="open">
                                                <p x-show="open">{!! $propiedad->descripcion !!}</p>
                                                </span>
                                            </div>
                                            <div class="col-6">     
                                                <a name="" id="" class="btn btn-info text-white btn-sm" href="/admin/vercualquierpropiedad/{{$propiedad->id}}" target="_blank" role="button">Detalle</a>
                                            </div>                             
                                        </div>                      
                                    </td>
                                </tr>
                            </table>
                            
                        </td>
                    </tr>

                    @endforeach
                    </tbody>
                </table>

                
                <table class="table mt-0 rounded table-borderless hover">
                    <div class="row">
                        <div class="col-12">
                            Propuesta en US$
                        </div>
                    </div>
                    @foreach ( $propiedades_dolar as $propiedad_dolar)
                
                    <tr class="d-none d-xl-block">
                        <td class="d-none d-lg-table-cell" scope="col" style="width: 1px;">{{ $propiedad_dolar->id}}</td>
                        <td class="d-none d-lg-table-cell" style="width: 500px;">
                            <div id="carouselExample2{{ $propiedad_dolar->id}}" class="carousel slide" style="max-width: 600px">
                                <div class="carousel-inner">
                                    @if ($propiedad_dolar->foto_portada!="")
                                    <div class="carousel-item active">
                                        <img src="{{$propiedad_dolar->foto_portada}}" class="d-block w-100 rounded-2" alt="...">
                                    </div>
                                    @endif
                                    @if ($propiedad_dolar->foto1!="")
                                    <div class="carousel-item">
                                        <img src="{{$propiedad_dolar->foto1}}" class="d-block w-100 rounded-2" alt="...">
                                    </div>
                                    @endif
                                    @if ($propiedad_dolar->foto2!="")
                                    <div class="carousel-item">
                                        <img src="{{$propiedad->foto2}}" class="d-block w-100 rounded-2" alt="...">
                                    </div>
                                    @endif
                                    @if ($propiedad_dolar->foto3!="")
                                    <div class="carousel-item">
                                        <img src="{{$propiedad->foto3}}" class="d-block w-100 rounded-2" alt="...">
                                    </div>
                                    @endif
                                    @if ($propiedad_dolar->foto4!="")
                                    <div class="carousel-item">
                                        <img src="{{$propiedad->foto4}}" class="d-block w-100 rounded-2" alt="...">
                                    </div>
                                    @endif
                                    @if ($propiedad_dolar->foto5!="")
                                    <div class="carousel-item">
                                        <img src="{{$propiedad_dolar->foto5}}" class="d-block w-100 rounded-2" alt="...">
                                    </div>
                                    @endif
                                    @if ($propiedad_dolar->foto6!="")
                                    <div class="carousel-item">
                                        <img src="{{$propiedad_dolar->foto6}}" class="d-block w-100 rounded-2" alt="...">
                                    </div>
                                    @endif
                                    @if ($propiedad_dolar->foto7!="")
                                    <div class="carousel-item">
                                        <img src="{{$propiedad_dolar->foto7}}" class="d-block w-100 rounded-2" alt="...">
                                    </div>
                                    @endif
                                    @if ($propiedad_dolar->foto8!="")
                                    <div class="carousel-item">
                                        <img src="{{$propiedad_dolar->foto8}}" class="d-block w-100 rounded-2" alt="...">
                                    </div>
                                    @endif
                                </div>
                                <button class="carousel-control-prev" type="button"
                                    data-bs-target="#carouselExample2{{ $propiedad_dolar->id}}" data-bs-slide="prev">
                                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                    <span class="visually-hidden">Previous</span>
                                </button>
                                <button class="carousel-control-next" type="button"
                                    data-bs-target="#carouselExample2{{ $propiedad_dolar->id}}" data-bs-slide="next">
                                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                    <span class="visually-hidden">Next</span>
                                </button>
                
                
                
                            </div>
                        </td>
                        <td class="d-none d-lg-table-cell">
                            <table class="table mt-0 table-borderless " style="width: 100%;">
                                <tr>
                                    <td>
                                        <table style="width: 100%">
                                            <tr class="col-md-3">
                                                <td class="fw-bold w-25">{{ $propiedad_dolar->titulo}}
                                                </td>
                                                <td class="w-25">{{ $propiedad_dolar->zona}}</td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <table class="bg-white" style="width: 100%">
                                            <tr>
                                                <td>
                
                                                    <div class="property-detail-info-list section-bg-1 clearfix mb-60">
                                                        <ul>
                                                            <li><label>REF:</label> <span>{{ $propiedad_dolar->referencia }}</span></li>
                                                            <li><label>Metros: </label> <span>{{ $propiedad_dolar->metraje }} M2</span>
                                                            </li>
                                                            <li><label>Mt Construcción:</label> <span>{{
                                                                    $propiedad_dolar->metraje_construccion }} </span></li>
                                                            <li><label>Habitaciones:</label> <span>{{ $propiedad_dolar->habitaciones
                                                                    }}</span></li>
                                                            <li><label>Estado:</label> <span
                                                                    class="btn-sm btn-success text-white rounded-0 text-success">{{
                                                                    $propiedad_dolar->estado }}</span></li>
                
                                                            {{-- <li><label>Year built:</label> <span>1992</span></li> --}}
                                                        </ul>
                                                        <ul>
                                                            <li><label>Baños:</label> <span>{{ $propiedad_dolar->banos }}</span></li>
                                                            {{-- <li><label>Lot dimensions:</label> <span>120 sqft</span></li> --}}
                                                            <li><label>Parqueos:</label> <span>{{ $propiedad_dolar->parqueos }}</span>
                                                            </li>
                                                            <li><label>Disponible Para:</label> <span>{{
                                                                    $propiedad_dolar->disponible_para
                                                                    }}</span></li>
                                                            <li><label>Precio:</label> <span>{{ $propiedad_dolar->Moneda }} {{
                                                                    number_format($propiedad_dolar->precio,2) }}</span></li>
                                                            <li><label>Tipo:</label> <span
                                                                    class="btn-sm btn-success text-white rounded-0 text-success">{{
                                                                    $propiedad_dolar->tipo
                                                                    }}</span></li>
                                                        </ul>
                                                    </div>
                
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="">
                                        <div x-data="{ open: false }">
                                            <a class="btn btn-primary btn-sm " @click="open = ! open" role="button">Descripción</a>
                                            <a name="" id="" class="btn btn-sm btn-block btn-info text-white" href="/admin/vercualquierpropiedad/{{$propiedad->id}}"
                                                target="_blank" role="button">Ver</a>                
                                            <span x-show="open">
                                                <p x-show="open">{!! $propiedad->descripcion !!}</p>
                                            </span>
                                        </div>

                                    </td>
                                </tr>
                            </table>
                
                        </td>
                    </tr>
                
                    @endforeach
                    </tbody>
                </table>

            </div>

<div class="col-md-10 mt-4">

            
            
            </div>            
        </div>
    </div>

    
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
</script>    


</body>
</html>