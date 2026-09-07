@extends('admin.layoutadmin')

@section('content')
    @php
        $isAdmin =
            auth()->check() &&
            auth()
                ->user()
                ->hasAnyRole(['admin', 'superadmin']);
    @endphp
    <div class="container">
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

                <form action="{{ route('updatecualquiera', $propiedad->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('put')
                    <input type="hidden" name="id" value="{{ $propiedad->id }}">
                    <div class="mb-3">
                        <label for="formFile" class="form-label">Foto Principal</label>
                        <input class="form-control" type="file" id="foto_portada" name="foto_portada"
                            value="{{ $propiedad->foto_portada }}">
                    </div>

                    <div class="row">
                        <div class="form-group col-md-4">
                            <label for="titulo">Imagen de Portada</label>
                            <img src="{{ $propiedad->foto_portada }}" class="img-fluid rounded-top" alt="">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="titulo">Titulo</label>
                        <input type="text" class="form-control" id="titulo" name="titulo"
                            value="{{ $propiedad->titulo }}" placeholder="Titulo" required maxlength="60">
                    </div>

                    <div class="form-group">
                        <label for="descripcion_corta">Descripción corta</label>
                        <input type="text" class="form-control" id="descripcion_corta"
                            value="{{ $propiedad->descripcion_corta }}" name="descripcion_corta"
                            placeholder="Descripción corta" required maxlength="160">
                    </div>

                    <div class="form-group">
                        <label for="descripcion">Descripción</label>
                        <textarea class="form-control" placeholder="Descripción" id="descripcion" name="descripcion" style="height: 100px">{{ $propiedad->descripcion }}</textarea>
                    </div>

                    <div class="form-group">
                        <label for="descripcion">Dirección</label>
                        <textarea class="form-control" placeholder="Dirección" id="direccion" name="direccion" style="height: 100px">{{ $propiedad->direccion }}</textarea>
                    </div>

                    <div class="form-group">
                        <label for="metadescription">Meta Description</label>
                        <textarea class="form-control" placeholder="Meta Description" id="metadescription" name="metadescription"
                            maxlength="160" style="height: 100px">{{ $propiedad->metadescription }}</textarea>
                    </div>


                    <div class="card">
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
                                        <input type="checkbox" name="ckfoto1" id="ckfoto1"> Eliminar?
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
                                        <input type="checkbox" name="ckfoto2" id="ckfoto2"> Eliminar?
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
                                        <input type="checkbox" name="ckfoto3" id="ckfoto3"> Eliminar?
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
                                        <input type="checkbox" name="ckfoto4" id="ckfoto4"> Eliminar?
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
                                        <input type="checkbox" name="ckfoto5" id="ckfoto5"> Eliminar?
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
                                        <input type="checkbox" name="ckfoto6" id="ckfoto6"> Eliminar?
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
                                        <input type="checkbox" name="ckfoto7" id="ckfoto7"> Eliminar?
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
                                        <input type="checkbox" name="ckfoto8" id="ckfoto8"> Eliminar?
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
                                    <div id="video1-preview-wrapper" class="mt-3 d-none" aria-live="polite">
                                        <div class="rounded overflow-hidden border"
                                            style="position:relative; padding-top:56.25%; background:#f6f8fb;">
                                            <iframe id="video1-preview-frame" src=""
                                                title="Vista previa del video de YouTube" loading="lazy"
                                                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                                                allowfullscreen referrerpolicy="strict-origin-when-cross-origin"
                                                style="position:absolute; inset:0; width:100%; height:100%; border:0;"></iframe>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>



                    <div class="row">

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="provincia">Provincia</label>
                                <select class="form-control" name="provincia" id="provincia" required>
                                    <option value="">Selecciona una provincia</option>
                                    @foreach ($provincias as $provinciaItem)
                                        <option value="{{ $provinciaItem->id }}"
                                            {{ (string) old('provincia', $propiedad->provincia) === (string) $provinciaItem->id ? 'selected' : '' }}>
                                            {{ $provinciaItem->provincia }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="sector_id">Sector</label>
                                <select class="form-control" name="sector_id" id="sector_id" required>
                                    <option value="">Selecciona un sector</option>
                                    @foreach ($sectores as $sector)
                                        <option value="{{ $sector->id }}" data-provincia="{{ $sector->provincia_id }}"
                                            {{ (string) old('sector_id', $propiedad->sector_id) === (string) $sector->id ? 'selected' : '' }}>
                                            {{ $sector->sector }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-md-1">
                            <div class="form-group">
                                <label for="Moneda">Moneda</label>
                                <select class="form-control" name="tipomoneda" id="tipomoneda" required>
                                    <option @if ($propiedad->Moneda == 'RD$') selected @endif value="RD$">RD$</option>
                                    <option @if ($propiedad->Moneda == 'US$') selected @endif value="US$">US$</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="precio">Precio</label>
                                <input type="number" class="form-control" id="precio" name="precio" required
                                    placeholder="Precio" value="{{ $propiedad->precio }}">
                            </div>
                        </div>

                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="comision"><span class="bold text-info text-sm mx-1"></span>Comisión</label>
                                <input type="text" class="form-control" id="comision" name="comision"
                                    placeholder="Comision" value="{{ $propiedad->comision }}">
                            </div>
                        </div>

                    </div>
                    <div class="row">

                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="tipo">Tipo</label>
                                <select class="form-control" name="tipo" id="tipo" required>
                                    <option value="" selected>Tipo</option>
                                    @foreach ($tipos_propiedades as $tipos_propiedad)
                                        <option @if ($propiedad->tipo == $tipos_propiedad->id) selected @endif
                                            value="{{ $tipos_propiedad->id }}">{{ $tipos_propiedad->tipo }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-md-1">
                            <div class="form-group">
                                <label for="habitaciones">Hab</label>
                                <select class="form-control" name="habitaciones" id="habitaciones" required>
                                    <option value="" selected>Habitaciones</option>
                                    <option @if ($propiedad->habitaciones == 1) selected @endif value="1">1</option>
                                    <option @if ($propiedad->habitaciones == 2) selected @endif value="2">2</option>
                                    <option @if ($propiedad->habitaciones == 3) selected @endif value="3">3</option>
                                    <option @if ($propiedad->habitaciones == 4) selected @endif value="4">4</option>
                                    <option @if ($propiedad->habitaciones == 5) selected @endif value="5">5</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-1">
                            <div class="form-group">
                                <label for="habitaciones">Baños</label>
                                <select class="form-control" name="banos" id="banos" required>
                                    <option value="" selected>Baños</option>
                                    <option @if ($propiedad->banos == 1) selected @endif value="1">1</option>
                                    <option @if ($propiedad->banos == 1.5) selected @endif value="1.5">1.5</option>
                                    <option @if ($propiedad->banos == 2) selected @endif value="2">2</option>
                                    <option @if ($propiedad->banos == 2.5) selected @endif value="2.5">2.5</option>
                                    <option @if ($propiedad->banos == 3) selected @endif value="3">3</option>
                                    <option @if ($propiedad->banos == 3.5) selected @endif value="3.5">3.5</option>
                                    <option @if ($propiedad->banos == 4) selected @endif value="4">4</option>
                                    <option @if ($propiedad->banos == 4.5) selected @endif value="4.5">4.5</option>
                                    <option @if ($propiedad->banos == 5) selected @endif value="5">5</option>
                                    <option @if ($propiedad->banos == 5.5) selected @endif value="5.5">5.5</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-1">
                            <div class="form-group">
                                <label for="habitaciones">Parqueos</label>
                                <select class="form-control" name="parqueos" id="parqueos" required>
                                    <option value="" selected>Parqueos</option>
                                    <option @if ($propiedad->parqueos == 1) selected @endif value="1">1</option>
                                    <option @if ($propiedad->parqueos == 2) selected @endif value="2">2</option>
                                    <option @if ($propiedad->parqueos == 3) selected @endif value="3">3</option>
                                    <option @if ($propiedad->parqueos == 4) selected @endif value="4">4</option>
                                    <option @if ($propiedad->parqueos == 5) selected @endif value="5">5</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="disponiblepara">Disponible para</label>
                                <select class="form-control" name="disponible_para" id="disponible_para" required>
                                    <option value="" selected>Disponible para</option>
                                    @forelse ($disponibles_para as $disponible_para)
                                        <option @if ($propiedad->disponible_para == $disponible_para->id) selected @endif
                                            value="{{ $disponible_para->id }}">{{ $disponible_para->disponible_para }}
                                        </option>
                                    @empty
                                    @endforelse
                                </select>
                            </div>
                        </div>

                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="estadopropiedad">Estado de la Propiedad</label>
                                <select class="form-control" name="estadopropiedad" id="estadopropiedad" required>
                                    <option value="" selected>Estado Propiedad</option>
                                    @forelse ($estados_propiedad as $estado_propiedad)
                                        <option @if ($propiedad->estado_id == $estado_propiedad->id) selected @endif
                                            value="{{ $estado_propiedad->id }}">{{ $estado_propiedad->estado }}</option>
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
                                <input type="text" class="form-control" id="metraje" name="metraje"
                                    placeholder="Metraje" value="{{ $propiedad->metraje }}" required>
                            </div>
                        </div>

                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="metrajedeconstruccion">Metraje Construcción</label>
                                <input type="text" class="form-control" id="metraje_construccion"
                                    name="metraje_construccion" placeholder="Metraje de Construcción"
                                    value="{{ $propiedad->metraje_construccion }}">
                            </div>
                        </div>

                        <div class="col-md-2">
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input"
                                    @if ($propiedad->destacada == 1) checked @endif id="destacada" name="destacada">
                                <label for="exampleCheck1">Destacada?</label>
                            </div>
                        </div>

                        <div class="col-md-2">
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input"
                                    @if ($propiedad->vendida == 1) checked @endif id="vendida" name="vendida">
                                <label for="exampleCheck1">Vendida?</label>
                            </div>
                        </div>

                        <div class="col-md-2">
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input"
                                    @if ($propiedad->activa == 1) checked @endif id="activa" name="activa">
                                <label for="exampleCheck1">Activa?</label>
                            </div>
                        </div>

                        @if ((bool) optional($inmobiliaria)->aprobacion && $isAdmin)
                            <div class="col-md-2">
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input"
                                        @if ($propiedad->aprobada == 1) checked @endif id="aprobada" name="aprobada">
                                    <label for="aprobada">Aprobada?</label>
                                </div>
                            </div>
                        @endif



                    </div>

                    <div class="card">
                        <div class="card-body">
                            {{-- Detalles de la propiedad --}}

                            <div class="row">


                                <div class="col-md-2">
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input"
                                            @if ($propiedad->lobby == 1) checked @endif id="lobby"
                                            name="lobby">
                                        <label for="exampleCheck1">Lobby?</label>
                                    </div>
                                </div>

                                <div class="col-md-2">
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input"
                                            @if ($propiedad->plantaelectrica == 1) checked @endif id="plantaelectrica"
                                            name="plantaelectrica">
                                        <label for="exampleCheck1">Planta electrica?</label>
                                    </div>
                                </div>

                                <div class="col-md-2">
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input"
                                            @if ($propiedad->camaravigilancia == 1) checked @endif id="camaravigilancia"
                                            name="camaravigilancia">
                                        <label for="exampleCheck1">Camara vigilancia?</label>
                                    </div>
                                </div>

                                <div class="col-md-2">
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input"
                                            @if ($propiedad->escaleraemergencia == 1) checked @endif id="escaleraemergencia"
                                            name="escaleraemergencia">
                                        <label for="exampleCheck1">Escalera emergencia?</label>
                                    </div>
                                </div>

                                <div class="col-md-2">
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input"
                                            @if ($propiedad->maderapreciosa == 1) checked @endif id="maderapreciosa"
                                            name="maderapreciosa">
                                        <label for="exampleCheck1">Madera preciosa?</label>
                                    </div>
                                </div>

                                <div class="col-md-2">
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input"
                                            @if ($propiedad->balcon == 1) checked @endif id="balcon"
                                            name="balcon">
                                        <label for="exampleCheck1">Balcon?</label>
                                    </div>
                                </div>

                            </div>

                            {{-- Fin de una linea de los detalles --}}



                            {{-- Detalles de la propiedad --}}

                            <div class="row">

                                <div class="col-md-2">
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input"
                                            @if ($propiedad->walkincloset == 1) checked @endif id="walkincloset"
                                            name="walkincloset">
                                        <label for="exampleCheck1">Walk in closet?</label>
                                    </div>
                                </div>

                                <div class="col-md-2">
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input"
                                            @if ($propiedad->jacuzzi == 1) checked @endif id="jacuzzi"
                                            name="jacuzzi">
                                        <label for="exampleCheck1">Jacuzzi?</label>
                                    </div>
                                </div>

                                <div class="col-md-2">
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input"
                                            @if ($propiedad->areainfantil == 1) checked @endif id="areainfantil"
                                            name="areainfantil">
                                        <label for="exampleCheck1">Area infantil?</label>
                                    </div>
                                </div>

                                <div class="col-md-2">
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input"
                                            @if ($propiedad->banovisitas == 1) checked @endif id="banovisitas"
                                            name="banovisitas">
                                        <label for="exampleCheck1">Baño visitas?</label>
                                    </div>
                                </div>

                                <div class="col-md-2">
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input"
                                            @if ($propiedad->cisterna == 1) checked @endif id="cisterna"
                                            name="cisterna">
                                        <label for="exampleCheck1">Cisterna?</label>
                                    </div>
                                </div>

                                <div class="col-md-2">
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input"
                                            @if ($propiedad->inversorareacomun == 1) checked @endif id="inversorareacomun"
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
                                        <input type="checkbox" class="form-check-input"
                                            @if ($propiedad->gascomun == 1) checked @endif id="gascomun"
                                            name="gascomun">
                                        <label for="exampleCheck1">Gas común?</label>
                                    </div>
                                </div>

                                <div class="col-md-2">
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input"
                                            @if ($propiedad->gazebo == 1) checked @endif id="gazebo"
                                            name="gazebo">
                                        <label for="exampleCheck1">Gazebo?</label>
                                    </div>
                                </div>

                                <div class="col-md-2">
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input"
                                            @if ($propiedad->pozo == 1) checked @endif id="pozo"
                                            name="pozo">
                                        <label for="exampleCheck1">Pozo?</label>
                                    </div>
                                </div>

                                <div class="col-md-2">
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input"
                                            @if ($propiedad->piscina == 1) checked @endif id="piscina"
                                            name="piscina">
                                        <label for="exampleCheck1">Piscina?</label>
                                    </div>
                                </div>

                                <div class="col-md-2">
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input"
                                            @if ($propiedad->familyroom == 1) checked @endif id="familyroom"
                                            name="familyroom">
                                        <label for="exampleCheck1">Family room?</label>
                                    </div>
                                </div>

                                <div class="col-md-2">
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input"
                                            @if ($propiedad->cuartodeservicio == 1) checked @endif id="cuartodeservicio"
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
                                        <input type="checkbox" class="form-check-input"
                                            @if ($propiedad->patio == 1) checked @endif id="patio"
                                            name="patio">
                                        <label for="exampleCheck1">Patio?</label>
                                    </div>
                                </div>

                                <div class="col-md-2">
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input"
                                            @if ($propiedad->portonelectrico == 1) checked @endif id="portonelectrico"
                                            name="portonelectrico">
                                        <label for="exampleCheck1">Portón elèctrico?</label>
                                    </div>
                                </div>

                                <div class="col-md-2">
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input"
                                            @if ($propiedad->seguridad24horas == 1) checked @endif id="seguridad24horas"
                                            name="seguridad24horas">
                                        <label for="exampleCheck1">Seguridad 24 horas?</label>
                                    </div>
                                </div>

                                <div class="col-md-2">
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input"
                                            @if ($propiedad->ascensor == 1) checked @endif id="ascensor"
                                            name="ascensor">
                                        <label for="exampleCheck1">Ascensor?</label>
                                    </div>
                                </div>

                                <div class="col-md-2">
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input"
                                            @if ($propiedad->parqueostechados == 1) checked @endif id="parqueostechados"
                                            name="parqueostechados">
                                        <label for="exampleCheck1">Parqueos techados?</label>
                                    </div>
                                </div>

                                <div class="col-md-2">
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input"
                                            @if ($propiedad->preinstalacionairetinacoinversor == 1) checked @endif
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
                                        <input type="checkbox" class="form-check-input"
                                            @if ($propiedad->terraza == 1) checked @endif id="terraza"
                                            name="terraza">
                                        <label for="exampleCheck1">Terraza?</label>
                                    </div>
                                </div>

                                <div class="col-md-2">
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input"
                                            @if ($propiedad->estudio == 1) checked @endif id="estudio"
                                            name="estudio">
                                        <label for="exampleCheck1">Estudio?</label>
                                    </div>
                                </div>

                                <div class="col-md-2">
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input"
                                            @if ($propiedad->gimnasio == 1) checked @endif id="gimnasio"
                                            name="gimnasio">
                                        <label for="exampleCheck1">Gimnasio?</label>
                                    </div>
                                </div>

                                <div class="col-md-2">
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input"
                                            @if ($propiedad->controldeacceso == 1) checked @endif id="controldeacceso"
                                            name="controldeacceso">
                                        <label for="exampleCheck1">Control de acceso?</label>
                                    </div>
                                </div>

                            </div>
                            {{-- Fin de una linea de los detalles --}}
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary m-3" value="grabar" name="grabar">Grabar</button>
                </form>
            </div>

        </div>
    </div>


    <script>
        // Replace the <textarea id="editor1"> with a CKEditor 4
        // instance, using default configuration.
        CKEDITOR.replace('descripcion');

        (function() {
            const extractYouTubeId = (value) => {
                const rawValue = (value || '').trim();
                if (!rawValue) {
                    return '';
                }

                const idPattern = /^[a-zA-Z0-9_-]{11}$/;
                if (idPattern.test(rawValue)) {
                    return rawValue;
                }

                try {
                    const parsedUrl = new URL(rawValue);
                    const hostname = parsedUrl.hostname.replace('www.', '');

                    if (hostname === 'youtu.be') {
                        return parsedUrl.pathname.split('/').filter(Boolean)[0] || '';
                    }

                    if (hostname === 'youtube.com' || hostname === 'm.youtube.com' || hostname ===
                        'youtube-nocookie.com') {
                        if (parsedUrl.pathname === '/watch') {
                            return parsedUrl.searchParams.get('v') || '';
                        }

                        const pathParts = parsedUrl.pathname.split('/').filter(Boolean);
                        if (pathParts[0] === 'embed' || pathParts[0] === 'shorts') {
                            return pathParts[1] || '';
                        }
                    }
                } catch (error) {
                    // Si no es URL valida, intentamos extraer el ID.
                }

                const fallbackMatch = rawValue.match(/(?:v=|\/embed\/|youtu\.be\/|\/shorts\/)([a-zA-Z0-9_-]{11})/);
                return fallbackMatch ? fallbackMatch[1] : '';
            };

            const videoInput = document.getElementById('video1');
            const previewWrapper = document.getElementById('video1-preview-wrapper');
            const previewFrame = document.getElementById('video1-preview-frame');

            if (!videoInput || !previewWrapper || !previewFrame) {
                return;
            }

            const refreshVideoPreview = () => {
                const videoId = extractYouTubeId(videoInput.value);
                if (!videoId) {
                    previewFrame.src = '';
                    previewWrapper.classList.add('d-none');
                    return;
                }

                previewFrame.src = `https://www.youtube.com/embed/${videoId}`;
                previewWrapper.classList.remove('d-none');
            };

            videoInput.addEventListener('input', refreshVideoPreview);
            videoInput.addEventListener('blur', refreshVideoPreview);
            refreshVideoPreview();

            const provinciaSelect = document.getElementById('provincia');
            const sectorSelect = document.getElementById('sector_id');
            const allSectorOptions = sectorSelect ? Array.from(sectorSelect.options).map((option) => ({
                value: option.value,
                text: option.text,
                provincia: option.dataset.provincia || ''
            })) : [];

            const refreshSectorOptions = () => {
                if (!provinciaSelect || !sectorSelect) {
                    return;
                }

                const provinciaValue = provinciaSelect.value;
                const currentValue = sectorSelect.value;
                let hasCurrent = false;

                sectorSelect.innerHTML = '';

                allSectorOptions.forEach((item) => {
                    if (item.value && provinciaValue && item.provincia !== provinciaValue) {
                        return;
                    }

                    const option = document.createElement('option');
                    option.value = item.value;
                    option.text = item.text;

                    if (item.provincia) {
                        option.dataset.provincia = item.provincia;
                    }

                    if (item.value && item.value === currentValue) {
                        option.selected = true;
                        hasCurrent = true;
                    }

                    sectorSelect.appendChild(option);
                });

                if (!hasCurrent) {
                    sectorSelect.value = '';
                }
            };

            provinciaSelect?.addEventListener('change', refreshSectorOptions);
            refreshSectorOptions();
        })();
    </script>

@endsection
