@extends('admin.layoutadmin')

@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <h1>CLIENTE</h1>
            @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif
            <form action="{{ route("clientes.update",$cliente->id) }}" method="post" enctype="multipart/form-data">
                @method("put")
                @csrf
                <div class="form-group">

                    <div class="form-group">
                        <label for="nombre">Nombre</label>
                        <input type="text" required class="form-control" id="nombre" name="nombre" disabled placeholder="nombre"
                            value="{{ $cliente->nombre }}">
                    </div>

                    <div class="form-group">
                        <label for="titulo">Titulo</label>
                        <select class="form-control" name="titulo" id="titulo" disabled>
                            <option value="">Titulo</option>
                            <option @if ($cliente->titulo=="Señor") selected @endif value="Señor">Señor</option>
                            <option @if ($cliente->titulo=="Señora") selected @endif value="Señora">Señora</option>
                            <option @if ($cliente->titulo=="Señorita") selected @endif value="Señorita">Señorita
                            </option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="tipo_contacto">Tipo Contacto</label>
                        <select class="form-control" name="tipo_contacto" id="tipo_contacto" disabled>
                            <option value="">Tipo</option>
                            <option @if ($cliente->tipo_contacto=="PersonaFisica") selected @endif
                                value="PersonaFisica">Persona Fisica</option>
                            <option @if ($cliente->tipo_contacto=="Empresa") selected @endif value="Empresa">Empresa
                            </option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="telefono">Telefono</label>
                        <input type="number" required class="form-control" id="telefono" disabled name="telefono"
                            placeholder="telefono" value="{{ $cliente->telefono }}">
                    </div>

                    <div class="form-group">
                        <label for="correo">Correo</label>
                        <input type="email" class="form-control" id="email" name="email" disabled placeholder="correo"
                            value="{{ $cliente->email }}">
                    </div>

                    <div class="form-group">
                        <label for="" class="form-label">Comentario</label>
                        <textarea disabled class="form-control" name="comentario" id="comentario"
                            rows="3">{{ $cliente->comentario }}</textarea>
                    </div>

                    <div class="form-group col-4">
                        <label for="contact_at">Fecha de Contacto</label>
                        <input type="date" class="form-control" required id="contact_at" disabled name="contact_at"
                            value="{{ substr($cliente->contact_at,0,10) }}">
                    </div>

                    <div class="form-group">
                        <input disabled clase="form-control" type="checkbox" @if ($cliente->activo==1) checked @endif
                        name="activo" id="activo">
                        <label for="activo">Activo?</label>
                    </div>

                    <div class="form-group">
                        <label for="tipo_contacto2">Tipo Contacto</label>
                        <select class="form-control" name="tipo_contacto2" id="tipo_contacto2" disabled>
                            <option value="">Tipo</option>
                            <option @if ($cliente->tipo_contacto2=="Vendedor") selected @endif value="Vendedor">Vendedor
                            </option>
                            <option @if ($cliente->tipo_contacto2=="Comprador") selected @endif
                                value="Comprador">Comprador</option>
                            <option @if ($cliente->tipo_contacto2=="Inquilino") selected @endif
                                value="Inquilino">Inquilino</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="medio">Por donde supo de nosotros</label>
                        <select class="form-control" name="medio" id="medio" disabled>
                            <option value="">Tipo</option>
                            <option @if ($cliente->medio=="Facebook") selected @endif value="Facebook">Facebook</option>
                            <option @if ($cliente->medio=="Instagram") selected @endif value="Instagram">Instagram
                            </option>
                            <option @if ($cliente->medio=="Letrero") selected @endif value="Letrero">Letrero</option>
                            <option @if ($cliente->medio=="Radio") selected @endif value="Radio">Radio</option>
                            <option @if ($cliente->medio=="TV") selected @endif value="TV">TV</option>
                            <option @if ($cliente->medio=="Referido") selected @endif value="Referido">Referido</option>
                            <option @if ($cliente->medio=="Otro") selected @endif value="Otro">Otro</option>
                        </select>
                    </div>


                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <h3 class="text-bold text-primary">NEGOCIO</h3>
                                {{-- <div class="col-4">

                                    <div class="form-group">
                                        <label for="Zona">Zona</label>
                                        <select class="form-control" name="zona_id" id="zona_id">
                                            <option selected>Zona</option>
                                            @foreach ($zonas as $zona)
                                            <option @if ($cliente->zona_id==$zona->id) selected @endif
                                                value="{{$zona->id}}">{{ $zona->zona }}</option>
                                            @endforeach

                                        </select>
                                    </div>
                                </div> --}}

                                <div class="col-3">
                                    <div class="form-group">
                                        <label for="precio">Precio Min</label>
                                        <input type="number" class="form-control" disabled id="precio_mini" name="precio_mini"
                                            placeholder="Precio" value="{{ $cliente->precio_mini }}">
                                    </div>
                                </div>

                                <div class="col-3">
                                    <div class="form-group">
                                        <label for="precio">Precio Max</label>
                                        <input type="number" class="form-control" disabled id="precio" name="precio_max"
                                            placeholder="Precio" value="{{ $cliente->precio_max }}">
                                    </div>
                                </div>

                            </div>
                            <div class="row">

                                <div class="col-3">
                                    <div class="form-group">
                                        <label for="habitaciones">Hab</label>
                                        <select class="form-control" name="habitaciones" disabled id="habitaciones">
                                            <option selected>Habitaciones</option>
                                            <option @if ($cliente->habitaciones==1) selected @endif value="1">1</option>
                                            <option @if ($cliente->habitaciones==2) selected @endif value="2">2</option>
                                            <option @if ($cliente->habitaciones==3) selected @endif value="3">3</option>
                                            <option @if ($cliente->habitaciones==4) selected @endif value="4">4</option>
                                            <option @if ($cliente->habitaciones==5) selected @endif value="5">5</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-3">
                                    <div class="form-group">
                                        <label for="habitaciones">Parqueos</label>
                                        <select class="form-control" name="parqueos" disabled id="parqueos">
                                            <option selected>Parqueos</option>
                                            <option @if ($cliente->parqueos==1) selected @endif value="1">1</option>
                                            <option @if ($cliente->parqueos==2) selected @endif value="2">2</option>
                                            <option @if ($cliente->parqueos==3) selected @endif value="3">3</option>
                                            <option @if ($cliente->parqueos==4) selected @endif value="4">4</option>
                                            <option @if ($cliente->parqueos==5) selected @endif value="5">5</option>
                                        </select>
                                    </div>
                                </div>

                                {{-- <div class="col-3">
                                    <div class="form-group">
                                        <label for="tipo">Tipo</label>
                                        <select class="form-control" name="tipo" id="tipo">
                                            <option selected>Tipo</option>
                                            @foreach ($tipos_propiedades as $tipos_propiedad)
                                            <option @if ($cliente->tipo==$tipos_propiedad->id) selected @endif value="{{
                                                $tipos_propiedad->id}}">{{ $tipos_propiedad->tipo }}
                                            </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div> --}}

                                {{-- <div class="col-3">
                                    <div class="form-group">
                                        <label for="estadopropiedad">Estado de la Propiedad</label>
                                        <select class="form-control" name="estadopropiedad" id="estadopropiedad">
                                            <option selected>Estado Propiedad</option>
                                            @forelse ($estados_propiedad as $estado_propiedad )
                                            <option @if ($cliente->estado==$estado_propiedad->id) selected @endif
                                                value="{{ $estado_propiedad->id }}">{{$estado_propiedad->estado }}
                                            </option>

                                            @empty

                                            @endforelse
                                        </select>
                                    </div>
                                </div> --}}

                                {{-- <a href="{{ route("veropciones",$cliente->id) }}" target="_blank" class="btn
                                    btn-primary btn-lg text-bold text-white">Ver opciones</a> --}}
                            </div>
                        </div>
                    </div>


                    <div class="form-group">
                        <label for="" class="form-label">Testimonio</label>
                        <textarea class="form-control" name="testimonio" id="testimonio" rows="3" disabled></textarea>
                    </div>


                    {{-- <div class="form-group">
                        <input type="submit" class="btn btn-success" name="submit" id="submit" value="Grabar">
                    </div> --}}

                </div>
            </form>
        </div>
    </div>
</div>


@endsection