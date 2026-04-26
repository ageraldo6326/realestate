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
    {{-- <link rel="stylesheet" href="/css/style.css"> --}}
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
    <title>{{$propiedad->referencia}}</title>
</head>
<body class="bg-secondary">

<div class="container bg-white">
    <div class="row">

        <div class="col-md-12">

            @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif


                <div class="row mt-3">
                        <div class="form-group">
                            <h1>{{ $propiedad->titulo }}</h1>
                            <h4>{{ $propiedad->referencia }}</h4>
                        </div>
                    
                        <div id="carouselExample2{{ $propiedad->id}}" class="carousel slide" data-ride="carousel" style="max-width: 200rem">
                            <div class="carousel-inner">
                                @if ($propiedad->foto_portada!="")
                                <div class="carousel-item active">
                                    <img src="{{ asset('assets/'.$propiedad->foto_portada) }}" class="d-block w-100 rounded-2" alt="...">
                                </div>
                                @endif
                                @if ($propiedad->foto1!="")
                                <div class="carousel-item">
                                    <img src="{{ asset('assets/'.$propiedad->foto1) }}" class="d-block w-100 rounded-2" alt="...">
                                </div>
                                @endif
                                @if ($propiedad->foto2!="")
                                <div class="carousel-item">
                                    <img src="{{ asset('assets/'.$propiedad->foto2) }}" class="d-block w-100 rounded-2" alt="...">
                                </div>
                                @endif
                                @if ($propiedad->foto3!="")
                                <div class="carousel-item">
                                    <img src="{{ asset('assets/'.$propiedad->foto3) }}" class="d-block w-100 rounded-2" alt="...">
                                </div>
                                @endif
                                @if ($propiedad->foto4!="")
                                <div class="carousel-item">
                                    <img src="{{ asset('assets/'.$propiedad->foto4) }}" class="d-block w-100 rounded-2" alt="...">
                                </div>
                                @endif 
                                @if ($propiedad->foto5!="")
                                <div class="carousel-item">
                                    <img src="{{ asset('assets/'.$propiedad->foto5) }}" class="d-block w-100 rounded-2" alt="...">
                                </div>
                                @endif   
                                @if ($propiedad->foto6!="")
                                <div class="carousel-item">
                                    <img src="{{ asset('assets/'.$propiedad->foto6) }}" class="d-block w-100 rounded-2" alt="...">
                                </div>
                                @endif  
                                @if ($propiedad->foto7!="")
                                <div class="carousel-item">
                                    <img src="{{ asset('assets/'.$propiedad->foto7) }}" class="d-block w-100 rounded-2" alt="...">
                                </div>
                                @endif 
                                @if ($propiedad->foto8!="")
                                <div class="carousel-item">
                                    <img src="{{ asset('assets/'.$propiedad->foto8) }}" class="d-block w-100 rounded-2" alt="...">
                                </div>
                                @endif                                                                                                                 
                            </div>
                            <button class="carousel-control-prev" type="button" data-target="#carouselExample2{{ $propiedad->id}}" data-slide="prev">
                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">Previous</span>
                            </button>
                            <button class="carousel-control-next" type="button" data-target="#carouselExample2{{ $propiedad->id}}" data-slide="next">
                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">Next</span>
                            </button>
                        


                        </div>     
                </div>

                <div class="mt-3">
                    <h2>Descripción</h2>
                    <p class="text-justify">{!! $propiedad->descripcion !!}</p>
                </div>


                {{-- <div class="card">
                    <div class="card-body">
                        <div class="row">

                            <div class="mb-3 col-md-3">
                                <label for="formFile" class="form-label">Foto 1</label>
                                <input class="form-control" type="file" id="foto1" name="foto1"
                                    value="{{ $propiedad->foto1 }}">

                                <div class="form-group col-md-12">
                                    <label for="titulo">Foto 1</label>
                                    <img src="{{ $propiedad->foto1 }}" class="img-fluid rounded-top" alt="">
                                </div>

                                <div class="form-group col-md-12">
                                    <input type="checkbox" disabled name="ckfoto1" id="ckfoto1"> Eliminar?
                                </div>

                            </div>

                            <div class="mb-3 col-md-3">
                                <label for="formFile" class="form-label">Foto 2</label>
                                <input class="form-control" type="file" id="foto2" name="foto2"
                                    value="{{ $propiedad->foto2 }}">

                                <div class="form-group col-md-12">
                                    <label for="titulo">Foto 2</label>
                                    <img src="{{ $propiedad->foto2 }}" class="img-fluid rounded-top" alt="">
                                </div>

                                <div class="form-group col-md-12">
                                    <input type="checkbox" disabled name="ckfoto2" id="ckfoto2"> Eliminar?
                                </div>
                            </div>

                            <div class="mb-3 col-md-3">
                                <label for="formFile" class="form-label">Foto 3</label>
                                <input class="form-control" type="file" id="foto3" name="foto3"
                                    value="{{ $propiedad->foto3 }}">

                                <div class="form-group col-md-12">
                                    <label for="titulo">Foto 3</label>
                                    <img src="{{ $propiedad->foto3 }}" class="img-fluid rounded-top" alt="">
                                </div>

                                <div class="form-group col-md-12">
                                    <input type="checkbox" disabled name="ckfoto3" id="ckfoto3"> Eliminar?
                                </div>
                            </div>

                            <div class="mb-3 col-md-3">
                                <label for="formFile" class="form-label">Foto 4</label>
                                <input class="form-control" type="file" id="foto4" name="foto4"
                                    value="{{ $propiedad->foto4 }}">

                                <div class="form-group col-md-12">
                                    <label for="titulo">Foto 4</label>
                                    <img src="{{ $propiedad->foto4 }}" class="img-fluid rounded-top" alt="">
                                </div>

                                <div class="form-group col-md-12">
                                    <input type="checkbox" disabled name="ckfoto4" id="ckfoto4"> Eliminar?
                                </div>
                            </div>

                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-body">
                        <div class="row">

                            <div class="mb-3 col-md-3">
                                <label for="formFile" class="form-label">Foto 5</label>
                                <input class="form-control" type="file" id="foto5" name="foto5"
                                    value="{{ $propiedad->foto5 }}">

                                <div class="form-group col-md-12">
                                    <label for="titulo">Foto 5</label>
                                    <img src="{{ $propiedad->foto5 }}" class="img-fluid rounded-top" alt="">
                                </div>

                                <div class="form-group col-md-12">
                                    <input type="checkbox" disabled name="ckfoto5" id="ckfoto5"> Eliminar?
                                </div>

                            </div>

                            <div class="mb-3 col-md-3">
                                <label for="formFile" class="form-label">Foto 6</label>
                                <input class="form-control" type="file" id="foto6" name="foto6"
                                    value="{{ $propiedad->foto6 }}">

                                <div class="form-group col-md-12">
                                    <label for="titulo">Foto 6</label>
                                    <img src="{{ $propiedad->foto6 }}" class="img-fluid rounded-top" alt="">
                                </div>

                                <div class="form-group col-md-12">
                                    <input type="checkbox" disabled name="ckfoto6" id="ckfoto6"> Eliminar?
                                </div>
                            </div>

                            <div class="mb-3 col-md-3">
                                <label for="formFile" class="form-label">Foto 7</label>
                                <input class="form-control" type="file" id="foto7" name="foto7"
                                    value="{{ $propiedad->foto7 }}">

                                <div class="form-group col-md-12">
                                    <label for="titulo">Foto 7</label>
                                    <img src="{{ $propiedad->foto7 }}" class="img-fluid rounded-top" alt="">
                                </div>

                                <div class="form-group col-md-12">
                                    <input type="checkbox" disabled name="ckfoto7" id="ckfoto7"> Eliminar?
                                </div>
                            </div>

                            <div class="mb-3 col-md-3">
                                <label for="formFile" class="form-label">Foto 8</label>
                                <input class="form-control" type="file" id="foto8" name="foto8"
                                    value="{{ $propiedad->foto8 }}">

                                <div class="form-group col-md-12">
                                    <label for="titulo">Foto 8</label>
                                    <img src="{{ $propiedad->foto8 }}" class="img-fluid rounded-top" alt="">
                                </div>

                                <div class="form-group col-md-12">
                                    <input type="checkbox" disabled name="ckfoto8" id="ckfoto8"> Eliminar?
                                </div>
                            </div>

                        </div>
                    </div>
                </div>


                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="mb-3 col-md-3">
                                <label for="formFile" class="form-label">Video 1</label>
                                <input class="form-control" type="text" id="video1" name="video1"
                                    value="{{ $propiedad->video1 }}">
                            </div>
                        </div>
                    </div>
                </div> --}}



                <div class="row">
                    <div class="form-group">
                        <h2>Caracteristicas</h2>
                    </div>                              

                    <div class="col-md-4">
              
                        <div class="form-group">
                            <label for="Zona">Zona</label>
                            <select class="form-control" name="zona_id" id="zona_id" disabled>
                                <option value="" selected>Zona</option>
                                @foreach ($zonas as $zona)
                                <option @if ($propiedad->zona_id==$zona->id) selected @endif value="{{ $zona->id }}">{{
                                    $zona->zona }}</option>
                                @endforeach

                            </select>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="provincia">Provincia</label>
                            <select class="form-control" name="provincia" id="provincia" disabled>
                                <option value="" selected>Provincia</option>
                                @foreach ($provincias as $provincia)
                                <option @if ($propiedad->provincia==$provincia->id) selected @endif value="{{
                                    $provincia->id }}"> {{ $provincia->provincia }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="col-md-1">
                        <div class="form-group">
                            <label for="Moneda">Moneda</label>
                            <select class="form-control" name="tipomoneda" id="tipomoneda" disabled>
                                <option @if ($propiedad->Moneda=='RD$') selected @endif value="RD$">RD$</option>
                                <option @if ($propiedad->Moneda=='US$') selected @endif value="US$">US$</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="">
                            <label for="precio">Precio</label>
                            <input type="text" class="form-control" id="precio" name="precio" disabled
                                placeholder="Precio" value="{{ number_format($propiedad->precio) }}">
                        </div>
                    </div>
                  

                </div>
                <div class="row">

                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="tipo">Tipo</label>
                            <select class="form-control" name="tipo" id="tipo" disabled>
                                <option value="" selected>Tipo</option>
                                @foreach ($tipos_propiedades as $tipos_propiedad)
                                <option @if ($propiedad->tipo==$tipos_propiedad->id) selected @endif value="{{
                                    $tipos_propiedad->id}}">{{ $tipos_propiedad->tipo }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="col-md-1">
                        <div class="form-group">
                            <label for="habitaciones">Hab</label>
                            <select class="form-control" name="habitaciones" id="habitaciones" disabled>
                                <option value="" selected>Habitaciones</option>
                                <option @if ($propiedad->habitaciones==1) selected @endif value="1">1</option>
                                <option @if ($propiedad->habitaciones==2) selected @endif value="2">2</option>
                                <option @if ($propiedad->habitaciones==3) selected @endif value="3">3</option>
                                <option @if ($propiedad->habitaciones==4) selected @endif value="4">4</option>
                                <option @if ($propiedad->habitaciones==5) selected @endif value="5">5</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-1">
                        <div class="form-group">
                            <label for="habitaciones">Baños</label>
                            <select class="form-control" name="banos" id="banos" disabled>
                                <option value="" selected>Baños</option>
                                <option @if ($propiedad->banos==1) selected @endif value="1">1</option>
                                <option @if ($propiedad->banos==1.5) selected @endif value="1.5">1.5</option>
                                <option @if ($propiedad->banos==2) selected @endif value="2">2</option>
                                <option @if ($propiedad->banos==2.5) selected @endif value="2.5">2.5</option>
                                <option @if ($propiedad->banos==3) selected @endif value="3">3</option>
                                <option @if ($propiedad->banos==3.5) selected @endif value="3.5">3.5</option>
                                <option @if ($propiedad->banos==4) selected @endif value="4">4</option>
                                <option @if ($propiedad->banos==4.5) selected @endif value="4.5">4.5</option>
                                <option @if ($propiedad->banos==5) selected @endif value="5">5</option>
                                <option @if ($propiedad->banos==5.5) selected @endif value="5.5">5.5</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-1">
                        <div class="form-group">
                            <label for="habitaciones">Parqueos</label>
                            <select class="form-control" name="parqueos" id="parqueos" disabled>
                                <option value="" selected>Parqueos</option>
                                <option @if ($propiedad->parqueos==1) selected @endif value="1">1</option>
                                <option @if ($propiedad->parqueos==2) selected @endif value="2">2</option>
                                <option @if ($propiedad->parqueos==3) selected @endif value="3">3</option>
                                <option @if ($propiedad->parqueos==4) selected @endif value="4">4</option>
                                <option @if ($propiedad->parqueos==5) selected @endif value="5">5</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="disponiblepara">Disponible para</label>
                            <select class="form-control" name="disponible_para" id="disponible_para" disabled>
                                <option value="" selected>Disponible para</option>
                                @forelse ($disponibles_para as $disponible_para )
                                <option @if ($propiedad->disponible_para==$disponible_para->id) selected @endif
                                    value="{{ $disponible_para->id }}">{{ $disponible_para->disponible_para }}</option>
                                @empty

                                @endforelse
                            </select>
                        </div>
                    </div>

                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="estadopropiedad">Estado de la Propiedad</label>
                            <select class="form-control" name="estadopropiedad" id="estadopropiedad" disabled>
                                <option value="" selected>Estado Propiedad</option>
                                @forelse ($estados_propiedad as $estado_propiedad )
                                <option @if ($propiedad->estado_id==$estado_propiedad->id) selected @endif value="{{
                                    $estado_propiedad->id }}">{{
                                    $estado_propiedad->estado }}</option>
                                @empty

                                @endforelse
                            </select>
                        </div>
                    </div>

                </div>


                <div class="row">

                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="metraje">Metraje</label>
                            <input type="text" class="form-control" id="metraje" name="metraje" placeholder="Metraje"
                                value="{{ $propiedad->metraje }}" readonly>
                        </div>
                    </div>

                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="metrajedeconstruccion">Metraje Construcción</label>
                            <input type="text" class="form-control" id="metraje_construccion"
                                name="metraje_construccion" placeholder="Metraje de Construcción"
                                value="{{ $propiedad->metraje_construccion }}" readonly>
                        </div>
                    </div>



                </div>

                <div class="form-group">
                    <h2>Amenidades</h2>
                </div>                  

                <div class="card mb-5">
                    
                    <div class="card-body">
                       
                        {{-- Detalles de la propiedad --}}

                        <div class="row">


                            <div class="col-md-2">
                                <div class="form-check">
                                    <input type="checkbox" disabled class="form-check-input" @if ($propiedad->lobby==1) checked
                                    @endif id="lobby" name="lobby">
                                    <label for="exampleCheck1">Lobby?</label>
                                </div>
                            </div>

                            <div class="col-md-2">
                                <div class="form-check">
                                    <input type="checkbox" disabled class="form-check-input" @if ($propiedad->plantaelectrica==1)
                                    checked @endif id="plantaelectrica" name="plantaelectrica">
                                    <label for="exampleCheck1">Planta electrica?</label>
                                </div>
                            </div>

                            <div class="col-md-2">
                                <div class="form-check">
                                    <input type="checkbox" disabled class="form-check-input" @if ($propiedad->camaravigilancia==1) checked @endif id="camaravigilancia"
                                    name="camaravigilancia">
                                    <label for="exampleCheck1">Camara vigilancia?</label>
                                </div>
                            </div>

                            <div class="col-md-2">
                                <div class="form-check">
                                    <input type="checkbox" disabled class="form-check-input" @if ($propiedad->escaleraemergencia==1) checked @endif id="escaleraemergencia"
                                    name="escaleraemergencia">
                                    <label for="exampleCheck1">Escalera emergencia?</label>
                                </div>
                            </div>

                            <div class="col-md-2">
                                <div class="form-check">
                                    <input type="checkbox" disabled class="form-check-input" @if ($propiedad->maderapreciosa==1)
                                    checked @endif id="maderapreciosa" name="maderapreciosa">
                                    <label for="exampleCheck1">Madera preciosa?</label>
                                </div>
                            </div>

                            <div class="col-md-2">
                                <div class="form-check">
                                    <input type="checkbox" disabled class="form-check-input" @if ($propiedad->balcon==1) checked
                                    @endif id="balcon" name="balcon">
                                    <label for="exampleCheck1">Balcon?</label>
                                </div>
                            </div>

                        </div>

                        {{-- Fin de una linea de los detalles --}}



                        {{-- Detalles de la propiedad --}}

                        <div class="row">

                            <div class="col-md-2">
                                <div class="form-check">
                                    <input type="checkbox" disabled class="form-check-input" @if ($propiedad->walkincloset==1)
                                    checked @endif id="walkincloset" name="walkincloset">
                                    <label for="exampleCheck1">Walk in closet?</label>
                                </div>
                            </div>

                            <div class="col-md-2">
                                <div class="form-check">
                                    <input type="checkbox" disabled class="form-check-input" @if ($propiedad->jacuzzi==1) checked
                                    @endif id="jacuzzi" name="jacuzzi">
                                    <label for="exampleCheck1">Jacuzzi?</label>
                                </div>
                            </div>

                            <div class="col-md-2">
                                <div class="form-check">
                                    <input type="checkbox" disabled class="form-check-input" @if ($propiedad->areainfantil==1)
                                    checked @endif id="areainfantil" name="areainfantil">
                                    <label for="exampleCheck1">Area infantil?</label>
                                </div>
                            </div>

                            <div class="col-md-2">
                                <div class="form-check">
                                    <input type="checkbox" disabled class="form-check-input" @if ($propiedad->banovisitas==1)
                                    checked @endif id="banovisitas" name="banovisitas">
                                    <label for="exampleCheck1">Baño visitas?</label>
                                </div>
                            </div>

                            <div class="col-md-2">
                                <div class="form-check">
                                    <input type="checkbox" disabled class="form-check-input" @if ($propiedad->cisterna==1)
                                    checked @endif id="cisterna" name="cisterna">
                                    <label for="exampleCheck1">Cisterna?</label>
                                </div>
                            </div>

                            <div class="col-md-2">
                                <div class="form-check">
                                    <input type="checkbox" disabled class="form-check-input" @if ($propiedad->inversorareacomun==1) checked @endif id="inversorareacomun"
                                    name="inversorareacomun">
                                    <label for="exampleCheck1">Inversor área común?</label>
                                </div>
                            </div>

                        </div>
                        {{-- Fin de una linea de los detalles --}}


                        {{-- Detalles de la propiedad --}}

                        <div class="row">

                            <div class="col-md-2">
                                <div class="form-check">
                                    <input type="checkbox" disabled class="form-check-input" @if ($propiedad->gascomun==1)
                                    checked @endif id="gascomun" name="gascomun">
                                    <label for="exampleCheck1">Gas común?</label>
                                </div>
                            </div>

                            <div class="col-md-2">
                                <div class="form-check">
                                    <input type="checkbox" disabled class="form-check-input" @if ($propiedad->gazebo==1) checked
                                    @endif id="gazebo" name="gazebo">
                                    <label for="exampleCheck1">Gazebo?</label>
                                </div>
                            </div>

                            <div class="col-md-2">
                                <div class="form-check">
                                    <input type="checkbox" disabled class="form-check-input" @if ($propiedad->pozo==1) checked
                                    @endif id="pozo" name="pozo">
                                    <label for="exampleCheck1">Pozo?</label>
                                </div>
                            </div>

                            <div class="col-md-2">
                                <div class="form-check">
                                    <input type="checkbox" disabled class="form-check-input" @if ($propiedad->piscina==1) checked
                                    @endif id="piscina" name="piscina">
                                    <label for="exampleCheck1">Piscina?</label>
                                </div>
                            </div>

                            <div class="col-md-2">
                                <div class="form-check">
                                    <input type="checkbox" disabled class="form-check-input" @if ($propiedad->familyroom==1)
                                    checked @endif id="familyroom" name="familyroom">
                                    <label for="exampleCheck1">Family room?</label>
                                </div>
                            </div>

                            <div class="col-md-2">
                                <div class="form-check">
                                    <input type="checkbox" disabled class="form-check-input" @if ($propiedad->cuartodeservicio==1) checked @endif id="cuartodeservicio"
                                    name="cuartodeservicio">
                                    <label for="exampleCheck1">Cuarto de servicio?</label>
                                </div>
                            </div>

                        </div>
                        {{-- Fin de una linea de los detalles --}}

                        {{-- Detalles de la propiedad --}}

                        <div class="row">

                            <div class="col-md-2">
                                <div class="form-check">
                                    <input type="checkbox" disabled class="form-check-input" @if ($propiedad->patio==1) checked
                                    @endif id="patio" name="patio">
                                    <label for="exampleCheck1">Patio?</label>
                                </div>
                            </div>

                            <div class="col-md-2">
                                <div class="form-check">
                                    <input type="checkbox" disabled class="form-check-input" @if ($propiedad->portonelectrico==1)
                                    checked @endif id="portonelectrico" name="portonelectrico">
                                    <label for="exampleCheck1">Portón elèctrico?</label>
                                </div>
                            </div>

                            <div class="col-md-2">
                                <div class="form-check">
                                    <input type="checkbox" disabled class="form-check-input" @if ($propiedad->seguridad24horas==1) checked @endif id="seguridad24horas"
                                    name="seguridad24horas">
                                    <label for="exampleCheck1">Seguridad 24 horas?</label>
                                </div>
                            </div>

                            <div class="col-md-2">
                                <div class="form-check">
                                    <input type="checkbox" disabled class="form-check-input" @if ($propiedad->ascensor==1)
                                    checked @endif id="ascensor" name="ascensor">
                                    <label for="exampleCheck1">Ascensor?</label>
                                </div>
                            </div>

                            <div class="col-md-2">
                                <div class="form-check">
                                    <input type="checkbox" disabled class="form-check-input" @if ($propiedad->parqueostechados==1) checked @endif id="parqueostechados"
                                    name="parqueostechados">
                                    <label for="exampleCheck1">Parqueos techados?</label>
                                </div>
                            </div>

                            <div class="col-md-2">
                                <div class="form-check">
                                    <input type="checkbox" disabled class="form-check-input" @if ($propiedad->preinstalacionairetinacoinversor==1) checked @endif
                                    id="preinstalacionairetinacoinversor" name="preinstalacionairetinacoinversor">
                                    <label for="exampleCheck1">Pre-instalacion aire/tinaco/inversor?</label>
                                </div>
                            </div>

                        </div>
                        {{-- Fin de una linea de los detalles --}}


                        {{-- Detalles de la propiedad --}}

                        <div class="row">

                            <div class="col-md-2">
                                <div class="form-check">
                                    <input type="checkbox" disabled class="form-check-input" @if ($propiedad->terraza==1) checked
                                    @endif id="terraza" name="terraza">
                                    <label for="exampleCheck1">Terraza?</label>
                                </div>
                            </div>

                            <div class="col-md-2">
                                <div class="form-check">
                                    <input type="checkbox" disabled class="form-check-input" @if ($propiedad->estudio==1) checked
                                    @endif id="estudio" name="estudio">
                                    <label for="exampleCheck1">Estudio?</label>
                                </div>
                            </div>

                            <div class="col-md-2">
                                <div class="form-check">
                                    <input type="checkbox" disabled class="form-check-input" @if ($propiedad->gimnasio==1)
                                    checked @endif id="gimnasio" name="gimnasio">
                                    <label for="exampleCheck1">Gimnasio?</label>
                                </div>
                            </div>

                            <div class="col-md-2">
                                <div class="form-check">
                                    <input type="checkbox" disabled class="form-check-input" @if ($propiedad->controldeacceso==1)
                                    checked @endif id="controldeacceso" name="controldeacceso">
                                    <label for="exampleCheck1">Control de acceso?</label>
                                </div>
                            </div>

                        </div>
                        {{-- Fin de una linea de los detalles --}}
                    </div>
                </div>

        </div>

    </div>
</div>
<!-- jQuery, Popper.js, and Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>



</body>

</html>