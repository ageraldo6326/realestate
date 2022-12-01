@extends('layout.layoutDetallePropiedad')

@section('detalles')
    <div class="ltn__shop-details-area pb-10">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 col-md-12">
                    <div class="ltn__shop-details-inner ltn__page-details-inner mb-60">
                        <div class="ltn__blog-meta">
                            <ul>
                                <li class="ltn__blog-category">
                                    <a href="#">DESTACADA</a>
                                </li>
                                <li class="ltn__blog-category">
                                    <a class="bg-orange" href="#">{{ $propiedad->disponible_para }}</a>
                                </li>
                                <li class="ltn__blog-date">
                                    <i class="far fa-calendar-alt"></i>{{ date($propiedad->created_at) }}
                                </li>
                                {{-- <li>
                                    <a href="#"><i class="far fa-comments"></i>35 Comments</a>
                                </li> --}}
                            </ul>
                        </div>
                        <h1>{{ $propiedad->titulo }}</h1>
                        <label><span class="ltn__secondary-color"><i class="flaticon-pin"></i></span>{{ $propiedad->zona }}</label>
                        <label><span class="ltn__secondary-color"><i class="flaticon-building"></i></span>{{ $propiedad->tipo }}</label>
                        <h4 class="title-2">Descripción</h4>
                        <p>{{ $propiedad->descripcion }}</p>
                        {{-- <p>To the left is the modern kitchen with central island, leading through to the unique breakfast family room which feature glass walls and doors out onto the garden and access to the separate utility room.</p> --}}

                        <h4 class="title-2">Detalles de la Propiedad</h4>  
                        <div class="property-detail-info-list section-bg-1 clearfix mb-60">                          
                            <ul>
                                <li><label>ID Propiedad:</label> <span>{{ $propiedad->id }}</span></li>
                                <li><label>Metros: </label> <span>{{ $propiedad->metraje }} M2</span></li>
                                <li><label>Mt Construcción:</label> <span>{{ $propiedad->metraje_construccion }} </span></li>
                                <li><label>Habitaciones:</label> <span>{{ $propiedad->habitaciones }}</span></li>

                                {{-- <li><label>Year built:</label> <span>1992</span></li> --}}
                            </ul>
                            <ul>
                                <li><label>Baños:</label> <span>{{ $propiedad->banos }}</span></li>                                
                                {{-- <li><label>Lot dimensions:</label> <span>120 sqft</span></li> --}}
                                <li><label>Parqueos:</label> <span>{{ $propiedad->parqueos }}</span></li>
                                <li><label>Disponible Para:</label> <span>{{ $propiedad->disponible_para }}</span></li>
                                <li><label>Precio:</label> <span>{{ $propiedad->Moneda }} {{  number_format($propiedad->precio,2) }}</span></li>                                
                            </ul>
                        </div>
                                        
                        <h4 class="title-2">Características y Amenidades</h4>
                        <div class="property-detail-feature-list clearfix mb-45">                            
                            <ul>
                                <li>
                                    <label class="checkbox-item">Lobby
                                        <input type="checkbox" disabled  @if ($propiedad->lobby>0) checked="checked" @endif>
                                        <span class="checkmark"></span>
                                    </label>
                                </li>  
                                
                                <li>
                                    <label class="checkbox-item">Planta eléctrica
                                        <input type="checkbox"  disabled @if ($propiedad->plantaelectrica>0) checked="checked" @endif>
                                        <span class="checkmark"></span>
                                    </label>
                                </li>   
                                
                                <li>
                                    <label class="checkbox-item">Escalera de emergencia
                                        <input type="checkbox"  disabled @if ($propiedad->escaleraemergencia>0) checked="checked" @endif>
                                        <span class="checkmark"></span>
                                    </label>
                                </li>     
                                                                
                                
                                <li>
                                    <label class="checkbox-item">Seguridad 24 horas 
                                        <input type="checkbox"  disabled @if ($propiedad->seguridad24horas>0) checked="checked" @endif>
                                        <span class="checkmark"></span>
                                    </label>
                                </li>       
                                
                                <li>
                                    <label class="checkbox-item">Ascensor 
                                        <input type="checkbox"  disabled @if ($propiedad->ascensor>0) checked="checked" @endif>
                                        <span class="checkmark"></span>
                                    </label>
                                </li> 
                                
                                <li>
                                    <label class="checkbox-item">Parqueo techado 
                                        <input type="checkbox"  disabled @if ($propiedad->parqueostechados>0) checked="checked" @endif>
                                        <span class="checkmark"></span>
                                    </label>
                                </li>
                                
                                
                                <li>
                                    <label class="checkbox-item">Terraza 
                                        <input type="checkbox"  disabled @if ($propiedad->terraza>0) checked="checked" @endif>
                                        <span class="checkmark"></span>
                                    </label>
                                </li>
                                
                                <li>
                                    <label class="checkbox-item">Estudio 
                                        <input type="checkbox"  disabled @if ($propiedad->estudio>0) checked="checked" @endif>
                                        <span class="checkmark"></span>
                                    </label>
                                </li>
                                
                                <li>
                                    <label class="checkbox-item">Gimnasio
                                        <input type="checkbox"  disabled @if ($propiedad->gimnasio>0) checked="checked" @endif>
                                        <span class="checkmark"></span>
                                    </label>
                                </li>     
                                
                                <li>
                                    <label class="checkbox-item">Control de acceso 
                                        <input type="checkbox"  disabled @if ($propiedad->controldeacceso>0) checked="checked" @endif>
                                        <span class="checkmark"></span>
                                    </label>
                                </li>
                                <li>
                                    <label class="checkbox-item">Area infantil
                                        <input type="checkbox"  disabled @if ($propiedad->areainfantil>0) checked="checked" @endif>
                                        <span class="checkmark"></span>
                                    </label>
                                </li>
                                
                                <li>
                                    <label class="checkbox-item">Baño de visita
                                        <input type="checkbox"  disabled @if ($propiedad->banovisitas>0) checked="checked" @endif>
                                        <span class="checkmark"></span>
                                    </label>
                                </li>   
                                
                                <li>
                                    <label class="checkbox-item">Cisterna
                                        <input type="checkbox"  disabled @if ($propiedad->cisterna>0) checked="checked" @endif>
                                        <span class="checkmark"></span>
                                    </label>
                                </li>  

                                <li>
                                    <label class="checkbox-item">Inversor área común 
                                        <input type="checkbox"  disabled @if ($propiedad->inversorareacomun>0) checked="checked" @endif>
                                        <span class="checkmark"></span>
                                    </label>
                                </li> 
                                
                                <li>
                                    <label class="checkbox-item">Gas común 
                                        <input type="checkbox"  disabled @if ($propiedad->gascomun>0) checked="checked" @endif>
                                        <span class="checkmark"></span>
                                    </label>
                                </li>
                                
                                <li>
                                    <label class="checkbox-item">Gazebo
                                        <input type="checkbox"  disabled @if ($propiedad->gazebo>0) checked="checked" @endif>
                                        <span class="checkmark"></span>
                                    </label>
                                </li> 
                                
                                <li>
                                    <label class="checkbox-item">Pozo 
                                        <input type="checkbox"  disabled @if ($propiedad->pozo>0) checked="checked" @endif>
                                        <span class="checkmark"></span>
                                    </label>
                                </li>

                                <li>
                                    <label class="checkbox-item">Madera preciosa
                                        <input type="checkbox"  disabled @if ($propiedad->maderapreciosa>0) checked="checked" @endif>
                                        <span class="checkmark"></span>
                                    </label>
                                </li>  
                                
                                <li>
                                    <label class="checkbox-item">Balcón
                                        <input type="checkbox"  disabled @if ($propiedad->balcon>0) checked="checked" @endif>
                                        <span class="checkmark"></span>
                                    </label>
                                </li>  
                                
                                <li>
                                    <label class="checkbox-item">Walk In Closed
                                        <input type="checkbox"  disabled @if ($propiedad->walkincloset>0) checked="checked" @endif>
                                        <span class="checkmark"></span>
                                    </label>
                                </li>  
                                
                                <li>
                                    <label class="checkbox-item">Jacuzzi
                                        <input type="checkbox"  disabled @if ($propiedad->jacuzzi>0) checked="checked" @endif>
                                        <span class="checkmark"></span>
                                    </label>
                                </li>

                                
                                <li>
                                    <label class="checkbox-item">Piscina 
                                        <input type="checkbox"  disabled @if ($propiedad->piscina>0) checked="checked" @endif>
                                        <span class="checkmark"></span>
                                    </label>
                                </li> 
                                
                                <li>
                                    <label class="checkbox-item">Family room
                                        <input type="checkbox"  disabled @if ($propiedad->familyroom>0) checked="checked" @endif>
                                        <span class="checkmark"></span>
                                    </label>
                                </li>  
                                
                                <li>
                                    <label class="checkbox-item">Cuarto de servicio 
                                        <input type="checkbox"  disabled @if ($propiedad->cuartodeservicio>0) checked="checked" @endif>
                                        <span class="checkmark"></span>
                                    </label>
                                </li>                                

                                <li>
                                    <label class="checkbox-item">Patio 
                                        <input type="checkbox"  disabled @if ($propiedad->patio>0) checked="checked" @endif>
                                        <span class="checkmark"></span>
                                    </label>
                                </li>     
                                
                                <li>
                                    <label class="checkbox-item">Porton electrico 
                                        <input type="checkbox"  disabled @if ($propiedad->portonelectrico>0) checked="checked" @endif>
                                        <span class="checkmark"></span>
                                    </label>
                                </li> 

                                <li>
                                    <label class="checkbox-item">Pre instalación aire/tinaco/inversor 
                                        <input type="checkbox"  disabled @if ($propiedad->preinstalacionairetinacoinversor>0) checked="checked" @endif>
                                        <span class="checkmark"></span>
                                    </label>
                                </li>                                 
                                
                                   
                            </ul>
                        </div>

                        <h4 class="title-2">De nuestra Galeria</h4>
                        <div class="ltn__property-details-gallery mb-30">
                            <div class="row">
                                <div class="col-md-6">
                                    <a href="img/others/14.jpg" data-rel="lightcase:myCollection">
                                        <img class="mb-30" src="/img/img-slide/slider1.png" alt="Image">
                                    </a>
                                    <a href="img/others/15.jpg" data-rel="lightcase:myCollection">
                                        <img class="mb-30" src="/img/img-slide/slider2.png" alt="Image">
                                    </a>
                                </div>
                                <div class="col-md-6">
                                    <a href="img/others/16.jpg" data-rel="lightcase:myCollection">
                                        <img class="mb-30" src="/img/img-slide/slider3.png" alt="Image">
                                        {{-- <img class="mb-30" src="/img/others/16.jpg" alt="Image"> --}}
                                    </a>
                                </div>
                            </div>
                        </div>

                        <h4 class="title-2">Ubicación</h4>
                        <div class="property-details-google-map mb-60">
                            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d9334.271551495209!2d-73.97198251485975!3d40.668170674982946!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x89c25b0456b5a2e7%3A0x68bdf865dda0b669!2sBrooklyn%20Botanic%20Garden%20Shop!5e0!3m2!1sen!2sbd!4v1590597267201!5m2!1sen!2sbd" width="100%" height="100%" frameborder="0" allowfullscreen="" aria-hidden="false" tabindex="0"></iframe>
                        </div>

                        {{-- <h4 class="title-2">Floor Plans</h4> --}}
                        <!-- APARTMENTS PLAN AREA START -->
                        {{-- <div class="ltn__apartments-plan-area product-details-apartments-plan mb-60">
                            <div class="ltn__tab-menu ltn__tab-menu-3 ltn__tab-menu-top-right-- text-uppercase--- text-center---">
                                <div class="nav">
                                    <a data-toggle="tab" href="#liton_tab_3_1">First Floor</a>
                                    <a class="active show"  data-toggle="tab" href="#liton_tab_3_2" class="">Second Floor</a>
                                    <a data-toggle="tab" href="#liton_tab_3_3" class="">Third Floor</a>
                                    <a data-toggle="tab" href="#liton_tab_3_4" class="">Top Garden</a>
                                </div>
                            </div>
                            <div class="tab-content">
                                <div class="tab-pane fade" id="liton_tab_3_1">
                                    <div class="ltn__apartments-tab-content-inner">
                                        <div class="row">
                                            <div class="col-lg-7">
                                                <div class="apartments-plan-img">
                                                    <img src="img/others/10.png" alt="#">
                                                </div>
                                            </div>
                                            <div class="col-lg-5">
                                                <div class="apartments-plan-info ltn__secondary-bg--- text-color-white---">
                                                    <h2>First Floor</h2>
                                                    <p>Enimad minim veniam quis nostrud exercitation ullamco laboris.
                                                        Lorem ipsum dolor sit amet cons aetetur adipisicing elit sedo
                                                        eiusmod tempor.Incididunt labore et dolore magna aliqua.
                                                        sed ayd minim veniam.</p>
                                                </div>
                                            </div>
                                            <div class="col-lg-12">
                                                <div class="product-details-apartments-info-list  section-bg-1">
                                                    <div class="row">
                                                        <div class="col-lg-6">
                                                            <div class="apartments-info-list apartments-info-list-color mt-40---">
                                                                <ul>
                                                                    <li><label>Total Area</label> <span>2800 Sq. Ft</span></li>
                                                                    <li><label>Bedroom</label> <span>150 Sq. Ft</span></li>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <div class="apartments-info-list apartments-info-list-color mt-40---">
                                                                <ul>
                                                                    <li><label>Belcony/Pets</label> <span>Allowed</span></li>
                                                                    <li><label>Lounge</label> <span>650 Sq. Ft</span></li>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade active show" id="liton_tab_3_2">
                                    <div class="ltn__product-tab-content-inner">
                                        <div class="row">
                                            <div class="col-lg-7">
                                                <div class="apartments-plan-img">
                                                    <img src="img/others/10.png" alt="#">
                                                </div>
                                            </div>
                                            <div class="col-lg-5">
                                                <div class="apartments-plan-info ltn__secondary-bg--- text-color-white---">
                                                    <h2>Second Floor</h2>
                                                    <p>Enimad minim veniam quis nostrud exercitation ullamco laboris.
                                                        Lorem ipsum dolor sit amet cons aetetur adipisicing elit sedo
                                                        eiusmod tempor.Incididunt labore et dolore magna aliqua.
                                                        sed ayd minim veniam.</p>
                                                </div>
                                            </div>
                                            <div class="col-lg-12">
                                                <div class="product-details-apartments-info-list  section-bg-1">
                                                    <div class="row">
                                                        <div class="col-lg-6">
                                                            <div class="apartments-info-list apartments-info-list-color mt-40---">
                                                                <ul>
                                                                    <li><label>Total Area</label> <span>2800 Sq. Ft</span></li>
                                                                    <li><label>Bedroom</label> <span>150 Sq. Ft</span></li>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <div class="apartments-info-list apartments-info-list-color mt-40---">
                                                                <ul>
                                                                    <li><label>Belcony/Pets</label> <span>Allowed</span></li>
                                                                    <li><label>Lounge</label> <span>650 Sq. Ft</span></li>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="liton_tab_3_3">
                                    <div class="ltn__product-tab-content-inner">
                                        <div class="row">
                                            <div class="col-lg-7">
                                                <div class="apartments-plan-img">
                                                    <img src="img/others/10.png" alt="#">
                                                </div>
                                            </div>
                                            <div class="col-lg-5">
                                                <div class="apartments-plan-info ltn__secondary-bg--- text-color-white---">
                                                    <h2>Third Floor</h2>
                                                    <p>Enimad minim veniam quis nostrud exercitation ullamco laboris.
                                                        Lorem ipsum dolor sit amet cons aetetur adipisicing elit sedo
                                                        eiusmod tempor.Incididunt labore et dolore magna aliqua.
                                                        sed ayd minim veniam.</p>
                                                </div>
                                            </div>
                                            <div class="col-lg-12">
                                                <div class="product-details-apartments-info-list  section-bg-1">
                                                    <div class="row">
                                                        <div class="col-lg-6">
                                                            <div class="apartments-info-list apartments-info-list-color mt-40---">
                                                                <ul>
                                                                    <li><label>Total Area</label> <span>2800 Sq. Ft</span></li>
                                                                    <li><label>Bedroom</label> <span>150 Sq. Ft</span></li>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <div class="apartments-info-list apartments-info-list-color mt-40---">
                                                                <ul>
                                                                    <li><label>Belcony/Pets</label> <span>Allowed</span></li>
                                                                    <li><label>Lounge</label> <span>650 Sq. Ft</span></li>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="liton_tab_3_4">
                                    <div class="ltn__product-tab-content-inner">
                                        <div class="row">
                                            <div class="col-lg-7">
                                                <div class="apartments-plan-img">
                                                    <img src="img/others/10.png" alt="#">
                                                </div>
                                            </div>
                                            <div class="col-lg-5">
                                                <div class="apartments-plan-info ltn__secondary-bg--- text-color-white---">
                                                    <h2>Top Garden</h2>
                                                    <p>Enimad minim veniam quis nostrud exercitation ullamco laboris.
                                                        Lorem ipsum dolor sit amet cons aetetur adipisicing elit sedo
                                                        eiusmod tempor.Incididunt labore et dolore magna aliqua.
                                                        sed ayd minim veniam.</p>
                                                </div>
                                            </div>
                                            <div class="col-lg-12">
                                                <div class="product-details-apartments-info-list  section-bg-1">
                                                    <div class="row">
                                                        <div class="col-lg-6">
                                                            <div class="apartments-info-list apartments-info-list-color mt-40---">
                                                                <ul>
                                                                    <li><label>Total Area</label> <span>2800 Sq. Ft</span></li>
                                                                    <li><label>Bedroom</label> <span>150 Sq. Ft</span></li>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <div class="apartments-info-list apartments-info-list-color mt-40---">
                                                                <ul>
                                                                    <li><label>Belcony/Pets</label> <span>Allowed</span></li>
                                                                    <li><label>Lounge</label> <span>650 Sq. Ft</span></li>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div> --}}
                        <!-- APARTMENTS PLAN AREA END -->

                        <h4 class="title-2">Property Video</h4>
                        <div class="ltn__video-bg-img ltn__video-popup-height-500 bg-overlay-black-50 bg-image mb-60" data-bg="https://www.youtube.com/embed/eWUxqVFBq74?autoplay=1&showinfo=0">
                            <a class="ltn__video-icon-2 ltn__video-icon-2-border---" href="https://www.youtube.com/embed/eWUxqVFBq74?autoplay=1&showinfo=0" data-rel="lightcase:myCollection">
                                <i class="fa fa-play"></i>
                            </a>
                        </div>
                        
                        <div class="ltn__shop-details-tab-content-inner--- ltn__shop-details-tab-inner-2 ltn__product-details-review-inner mb-60">
                            {{-- <h4 class="title-2">Customer Reviews</h4>
                            <div class="product-ratting">
                                <ul>
                                    <li><a href="#"><i class="fas fa-star"></i></a></li>
                                    <li><a href="#"><i class="fas fa-star"></i></a></li>
                                    <li><a href="#"><i class="fas fa-star"></i></a></li>
                                    <li><a href="#"><i class="fas fa-star-half-alt"></i></a></li>
                                    <li><a href="#"><i class="far fa-star"></i></a></li>
                                    <li class="review-total"> <a href="#"> ( 95 Reviews )</a></li>
                                </ul>
                            </div> --}}
                            <hr>
                            <!-- comment-area -->
                            {{-- <div class="ltn__comment-area mb-30">
                                <div class="ltn__comment-inner">
                                    <ul>
                                        <li>
                                            <div class="ltn__comment-item clearfix">
                                                <div class="ltn__commenter-img">
                                                    <img src="img/testimonial/1.jpg" alt="Image">
                                                </div>
                                                <div class="ltn__commenter-comment">
                                                    <h6><a href="#">Adam Smit</a></h6>
                                                    <div class="product-ratting">
                                                        <ul>
                                                            <li><a href="#"><i class="fas fa-star"></i></a></li>
                                                            <li><a href="#"><i class="fas fa-star"></i></a></li>
                                                            <li><a href="#"><i class="fas fa-star"></i></a></li>
                                                            <li><a href="#"><i class="fas fa-star-half-alt"></i></a></li>
                                                            <li><a href="#"><i class="far fa-star"></i></a></li>
                                                        </ul>
                                                    </div>
                                                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Doloribus, omnis fugit corporis iste magnam ratione.</p>
                                                    <span class="ltn__comment-reply-btn">September 3, 2020</span>
                                                </div>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="ltn__comment-item clearfix">
                                                <div class="ltn__commenter-img">
                                                    <img src="img/testimonial/3.jpg" alt="Image">
                                                </div>
                                                <div class="ltn__commenter-comment">
                                                    <h6><a href="#">Adam Smit</a></h6>
                                                    <div class="product-ratting">
                                                        <ul>
                                                            <li><a href="#"><i class="fas fa-star"></i></a></li>
                                                            <li><a href="#"><i class="fas fa-star"></i></a></li>
                                                            <li><a href="#"><i class="fas fa-star"></i></a></li>
                                                            <li><a href="#"><i class="fas fa-star-half-alt"></i></a></li>
                                                            <li><a href="#"><i class="far fa-star"></i></a></li>
                                                        </ul>
                                                    </div>
                                                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Doloribus, omnis fugit corporis iste magnam ratione.</p>
                                                    <span class="ltn__comment-reply-btn">September 2, 2020</span>
                                                </div>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="ltn__comment-item clearfix">
                                                <div class="ltn__commenter-img">
                                                    <img src="img/testimonial/2.jpg" alt="Image">
                                                </div>
                                                <div class="ltn__commenter-comment">
                                                    <h6><a href="#">Adam Smit</a></h6>
                                                    <div class="product-ratting">
                                                        <ul>
                                                            <li><a href="#"><i class="fas fa-star"></i></a></li>
                                                            <li><a href="#"><i class="fas fa-star"></i></a></li>
                                                            <li><a href="#"><i class="fas fa-star"></i></a></li>
                                                            <li><a href="#"><i class="fas fa-star-half-alt"></i></a></li>
                                                            <li><a href="#"><i class="far fa-star"></i></a></li>
                                                        </ul>
                                                    </div>
                                                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Doloribus, omnis fugit corporis iste magnam ratione.</p>
                                                    <span class="ltn__comment-reply-btn">September 2, 2020</span>
                                                </div>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </div> --}}
                            <!-- comment-reply -->
                            {{-- <div class="ltn__comment-reply-area ltn__form-box mb-30">
                                <form action="#">
                                    <h4>Add a Review</h4>
                                    <div class="mb-30">
                                        <div class="add-a-review">
                                            <h6>Your Ratings:</h6>
                                            <div class="product-ratting">
                                                <ul>
                                                    <li><a href="#"><i class="fas fa-star"></i></a></li>
                                                    <li><a href="#"><i class="fas fa-star"></i></a></li>
                                                    <li><a href="#"><i class="fas fa-star"></i></a></li>
                                                    <li><a href="#"><i class="fas fa-star"></i></a></li>
                                                    <li><a href="#"><i class="fas fa-star"></i></a></li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="input-item input-item-textarea ltn__custom-icon">
                                        <textarea placeholder="Type your comments...."></textarea>
                                    </div>
                                    <div class="input-item input-item-name ltn__custom-icon">
                                        <input type="text" placeholder="Type your name....">
                                    </div>
                                    <div class="input-item input-item-email ltn__custom-icon">
                                        <input type="email" placeholder="Type your email....">
                                    </div>
                                    <div class="input-item input-item-website ltn__custom-icon">
                                        <input type="text" name="website" placeholder="Type your website....">
                                    </div>
                                    <label class="mb-0"><input type="checkbox" name="agree"> Save my name, email, and website in this browser for the next time I comment.</label>
                                    <div class="btn-wrapper">
                                        <button class="btn theme-btn-1 btn-effect-1 text-uppercase" type="submit">Submit</button>
                                    </div>
                                </form>
                            </div> --}}
                        </div>

                        <h4 class="title-2">Related Properties</h4>
                        <div class="row">
                            <!-- ltn__product-item -->
                            <div class="col-xl-6 col-sm-6 col-12">
                                <div class="ltn__product-item ltn__product-item-4 ltn__product-item-5 text-center---">
                                    <div class="product-img">
                                        <a href="product-details.html"><img src="/img/product-3/1.jpg" alt="#"></a>
                                        <div class="real-estate-agent">
                                            <div class="agent-img">
                                                <a href="team-details.html"><img src="/img/blog/author.jpg" alt="#"></a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="product-info">
                                        <div class="product-badge">
                                            <ul>
                                                <li class="sale-badg">For Rent</li>
                                            </ul>
                                        </div>
                                        <h2 class="product-title"><a href="product-details.html">New Apartment Nice View</a></h2>
                                        <div class="product-img-location">
                                            <ul>
                                                <li>
                                                    <a href="product-details.html"><i class="flaticon-pin"></i> Belmont Gardens, Chicago</a>
                                                </li>
                                            </ul>
                                        </div>
                                        <ul class="ltn__list-item-2--- ltn__list-item-2-before--- ltn__plot-brief">
                                            <li><span>3 </span>
                                                Bedrooms
                                            </li>
                                            <li><span>2 </span>
                                                Bathrooms
                                            </li>
                                            <li><span>3450 </span>
                                                square Ft
                                            </li>
                                        </ul>
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
                                                    <a href="portfolio-details.html" title="Compare">
                                                        <i class="flaticon-add"></i>
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="product-info-bottom">
                                        <div class="product-price">
                                            <span>$349,00<label>/Month</label></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- ltn__product-item -->
                            <div class="col-xl-6 col-sm-6 col-12">
                                <div class="ltn__product-item ltn__product-item-4 ltn__product-item-5 text-center---">
                                    <div class="product-img">
                                        <a href="product-details.html"><img src="/img/product-3/2.jpg" alt="#"></a>
                                        <div class="real-estate-agent">
                                            <div class="agent-img">
                                                <a href="team-details.html"><img src="/img/blog/author.jpg" alt="#"></a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="product-info">
                                        <div class="product-badge">
                                            <ul>
                                                <li class="sale-badg">For Sale</li>
                                            </ul>
                                        </div>
                                        <h2 class="product-title"><a href="product-details.html">New Apartment Nice View</a></h2>
                                        <div class="product-img-location">
                                            <ul>
                                                <li>
                                                    <a href="product-details.html"><i class="flaticon-pin"></i> Belmont Gardens, Chicago</a>
                                                </li>
                                            </ul>
                                        </div>
                                        <ul class="ltn__list-item-2--- ltn__list-item-2-before--- ltn__plot-brief">
                                            <li><span>3 </span>
                                                Bedrooms
                                            </li>
                                            <li><span>2 </span>
                                                Bathrooms
                                            </li>
                                            <li><span>3450 </span>
                                                square Ft
                                            </li>
                                        </ul>
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
                                                    <a href="portfolio-details.html" title="Compare">
                                                        <i class="flaticon-add"></i>
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="product-info-bottom">
                                        <div class="product-price">
                                            <span>$349,00<label>/Month</label></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <aside class="sidebar ltn__shop-sidebar ltn__right-sidebar---">
                        <!-- Author Widget -->
                        <div class="widget ltn__author-widget">
                            <div class="ltn__author-widget-inner text-center">
                                <img src="https://yt3.ggpht.com/nocyt2HhaPxyqjv9QdsGYLjwHdCStfQeggtqfot_o2FvA6LLMEk9YFyH31AVMCoFQy7yIQ1mVA=s900-c-k-c0x00ffffff-no-rj" alt="Image">
                                <h5>Angel Geraldo</h5>
                                <small>Agente Inmobiliario</small>
                                <div class="product-ratting">
                                    <ul>
                                        <li><a href="#"><i class="fas fa-star"></i></a></li>
                                        <li><a href="#"><i class="fas fa-star"></i></a></li>
                                        <li><a href="#"><i class="fas fa-star"></i></a></li>
                                        <li><a href="#"><i class="fas fa-star-half-alt"></i></a></li>
                                        <li><a href="#"><i class="far fa-star"></i></a></li>
                                        <li class="review-total"> <a href="#"> ( 1 Reviews )</a></li>
                                    </ul>
                                </div>
                                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Veritatis distinctio, odio, eligendi suscipit reprehenderit atque.</p>
                                <div class="ltn__social-media">
                                    <ul>
                                        <li><a href="#" title="Facebook"><i class="fab fa-facebook-f"></i></a></li>
                                        <li><a href="#" title="Twitter"><i class="fab fa-twitter"></i></a></li>
                                        <li><a href="#" title="Linkedin"><i class="fab fa-linkedin"></i></a></li>
                                        
                                        <li><a href="#" title="Youtube"><i class="fab fa-youtube"></i></a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <!-- Search Widget -->
                        <div class="widget ltn__search-widget">
                            <h4 class="ltn__widget-title ltn__widget-title-border-2">Buscar</h4>
                            <form action="#">
                                <input type="text" name="search" placeholder="Buscar por palabra clave...">
                                <button type="submit"><i class="fas fa-search"></i></button>
                            </form>
                        </div>
                        <!-- Form Widget -->
                        <div class="widget ltn__form-widget">
                            <h4 class="ltn__widget-title ltn__widget-title-border-2">Enviar Mensaje</h4>
                            <form action="#">
                                <input type="text" name="yourname" placeholder="Tu nombre*">
                                <input type="text" name="youremail" placeholder="Tu correo*">
                                <textarea name="yourmessage" placeholder="Escribe tu mensaje..."></textarea>
                                <button type="submit" class="btn theme-btn-1">Enviar</button>
                            </form>
                        </div>
                        <!-- Top Rated Product Widget -->
                        <div class="widget ltn__top-rated-product-widget">
                            <h4 class="ltn__widget-title ltn__widget-title-border-2">Propiedades Más Destacadas</h4>
                            <ul>
                                <li>
                                    <div class="top-rated-product-item clearfix">
                                        <div class="top-rated-product-img">
                                            <a href="product-details.html"><img src="/img/product/1.png" alt="#"></a>
                                        </div>
                                        <div class="top-rated-product-info">
                                            <div class="product-ratting">
                                                <ul>
                                                    <li><a href="#"><i class="fas fa-star"></i></a></li>
                                                    <li><a href="#"><i class="fas fa-star"></i></a></li>
                                                    <li><a href="#"><i class="fas fa-star"></i></a></li>
                                                    <li><a href="#"><i class="fas fa-star"></i></a></li>
                                                    <li><a href="#"><i class="fas fa-star"></i></a></li>
                                                </ul>
                                            </div>
                                            <h6><a href="product-details.html">Luxury House In Greenville </a></h6>
                                            <div class="product-price">
                                                <span>$30,000.00</span>
                                                <del>$35,000.00</del>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                                <li>
                                    <div class="top-rated-product-item clearfix">
                                        <div class="top-rated-product-img">
                                            <a href="product-details.html"><img src="/img/product/2.png" alt="#"></a>
                                        </div>
                                        <div class="top-rated-product-info">
                                            <div class="product-ratting">
                                                <ul>
                                                    <li><a href="#"><i class="fas fa-star"></i></a></li>
                                                    <li><a href="#"><i class="fas fa-star"></i></a></li>
                                                    <li><a href="#"><i class="fas fa-star"></i></a></li>
                                                    <li><a href="#"><i class="fas fa-star"></i></a></li>
                                                    <li><a href="#"><i class="fas fa-star"></i></a></li>
                                                </ul>
                                            </div>
                                            <h6><a href="product-details.html">Apartment with Subunits</a></h6>
                                            <div class="product-price">
                                                <span>$30,000.00</span>
                                                <del>$35,000.00</del>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                                <li>
                                    <div class="top-rated-product-item clearfix">
                                        <div class="top-rated-product-img">
                                            <a href="product-details.html"><img src="/img/product/3.png" alt="#"></a>
                                        </div>
                                        <div class="top-rated-product-info">
                                            <div class="product-ratting">
                                                <ul>
                                                    <li><a href="#"><i class="fas fa-star"></i></a></li>
                                                    <li><a href="#"><i class="fas fa-star"></i></a></li>
                                                    <li><a href="#"><i class="fas fa-star"></i></a></li>
                                                    <li><a href="#"><i class="fas fa-star-half-alt"></i></a></li>
                                                    <li><a href="#"><i class="far fa-star"></i></a></li>
                                                </ul>
                                            </div>
                                            <h6><a href="product-details.html">3 Rooms Manhattan</a></h6>
                                            <div class="product-price">
                                                <span>$30,000.00</span>
                                                <del>$35,000.00</del>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </div>
                        <!-- Menu Widget (Category) -->
                        <div class="widget ltn__menu-widget ltn__menu-widget-2--- ltn__menu-widget-2-color-2---">
                            <h4 class="ltn__widget-title ltn__widget-title-border-2">Categorias</h4>
                            <ul>
                                @forelse ( $tipo_de_propiedades as $tipo_de_propiedad)
                                <li><a href="#">{{ $tipo_de_propiedad->tipo }}<span>(26)</span></a></li>                                 
                                @empty
                                    
                                @endforelse

                            </ul>
                        </div>
                        <!-- Popular Product Widget -->
                        {{-- <div class="widget ltn__popular-product-widget">       
                            <h4 class="ltn__widget-title ltn__widget-title-border-2">Popular Properties</h4>                     
                            <div class="row ltn__popular-product-widget-active slick-arrow-1">
                                <!-- ltn__product-item -->
                                <div class="col-12">
                                    <div class="ltn__product-item ltn__product-item-4 ltn__product-item-5 text-center---">
                                        <div class="product-img">
                                            <a href="product-details.html"><img src="img/product-3/6.jpg" alt="#"></a>
                                            <div class="real-estate-agent">
                                                <div class="agent-img">
                                                    <a href="team-details.html"><img src="img/blog/author.jpg" alt="#"></a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="product-info">
                                            <div class="product-price">
                                                <span>$349,00<label>/Month</label></span>
                                            </div>
                                            <h2 class="product-title"><a href="product-details.html">New Apartment Nice View</a></h2>
                                            <div class="product-img-location">
                                                <ul>
                                                    <li>
                                                        <a href="product-details.html"><i class="flaticon-pin"></i> Belmont Gardens, Chicago</a>
                                                    </li>
                                                </ul>
                                            </div>
                                            <ul class="ltn__list-item-2--- ltn__list-item-2-before--- ltn__plot-brief">
                                                <li><span>3 </span>
                                                    Bedrooms
                                                </li>
                                                <li><span>2 </span>
                                                    Bathrooms
                                                </li>
                                                <li><span>3450 </span>
                                                    square Ft
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <!-- ltn__product-item -->
                                <div class="col-12">
                                    <div class="ltn__product-item ltn__product-item-4 ltn__product-item-5 text-center---">
                                        <div class="product-img">
                                            <a href="product-details.html"><img src="img/product-3/4.jpg" alt="#"></a>
                                            <div class="real-estate-agent">
                                                <div class="agent-img">
                                                    <a href="team-details.html"><img src="img/blog/author.jpg" alt="#"></a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="product-info">
                                            <div class="product-price">
                                                <span>$349,00<label>/Month</label></span>
                                            </div>
                                            <h2 class="product-title"><a href="product-details.html">New Apartment Nice View</a></h2>
                                            <div class="product-img-location">
                                                <ul>
                                                    <li>
                                                        <a href="product-details.html"><i class="flaticon-pin"></i> Belmont Gardens, Chicago</a>
                                                    </li>
                                                </ul>
                                            </div>
                                            <ul class="ltn__list-item-2--- ltn__list-item-2-before--- ltn__plot-brief">
                                                <li><span>3 </span>
                                                    Bedrooms
                                                </li>
                                                <li><span>2 </span>
                                                    Bathrooms
                                                </li>
                                                <li><span>3450 </span>
                                                    square Ft
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <!-- ltn__product-item -->
                                <div class="col-12">
                                    <div class="ltn__product-item ltn__product-item-4 ltn__product-item-5 text-center---">
                                        <div class="product-img">
                                            <a href="product-details.html"><img src="img/product-3/5.jpg" alt="#"></a>
                                            <div class="real-estate-agent">
                                                <div class="agent-img">
                                                    <a href="team-details.html"><img src="img/blog/author.jpg" alt="#"></a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="product-info">
                                            <div class="product-price">
                                                <span>$349,00<label>/Month</label></span>
                                            </div>
                                            <h2 class="product-title"><a href="product-details.html">New Apartment Nice View</a></h2>
                                            <div class="product-img-location">
                                                <ul>
                                                    <li>
                                                        <a href="product-details.html"><i class="flaticon-pin"></i> Belmont Gardens, Chicago</a>
                                                    </li>
                                                </ul>
                                            </div>
                                            <ul class="ltn__list-item-2--- ltn__list-item-2-before--- ltn__plot-brief">
                                                <li><span>3 </span>
                                                    Bedrooms
                                                </li>
                                                <li><span>2 </span>
                                                    Bathrooms
                                                </li>
                                                <li><span>3450 </span>
                                                    square Ft
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <!--  -->
                            </div>
                        </div> --}}
                        <!-- Popular Post Widget -->
                        {{-- <div class="widget ltn__popular-post-widget">
                            <h4 class="ltn__widget-title ltn__widget-title-border-2">Leatest Blogs</h4>
                            <ul>
                                <li>
                                    <div class="popular-post-widget-item clearfix">
                                        <div class="popular-post-widget-img">
                                            <a href="blog-details.html"><img src="img/team/5.jpg" alt="#"></a>
                                        </div>
                                        <div class="popular-post-widget-brief">
                                            <h6><a href="blog-details.html">Lorem ipsum dolor sit
                                                cing elit, sed do.</a></h6>
                                            <div class="ltn__blog-meta">
                                                <ul>
                                                    <li class="ltn__blog-date">
                                                        <a href="#"><i class="far fa-calendar-alt"></i>June 22, 2020</a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                                <li>
                                    <div class="popular-post-widget-item clearfix">
                                        <div class="popular-post-widget-img">
                                            <a href="blog-details.html"><img src="img/team/6.jpg" alt="#"></a>
                                        </div>
                                        <div class="popular-post-widget-brief">
                                            <h6><a href="blog-details.html">Lorem ipsum dolor sit
                                                cing elit, sed do.</a></h6>
                                            <div class="ltn__blog-meta">
                                                <ul>
                                                    <li class="ltn__blog-date">
                                                        <a href="#"><i class="far fa-calendar-alt"></i>June 22, 2020</a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                                <li>
                                    <div class="popular-post-widget-item clearfix">
                                        <div class="popular-post-widget-img">
                                            <a href="blog-details.html"><img src="img/team/7.jpg" alt="#"></a>
                                        </div>
                                        <div class="popular-post-widget-brief">
                                            <h6><a href="blog-details.html">Lorem ipsum dolor sit
                                                cing elit, sed do.</a></h6>
                                            <div class="ltn__blog-meta">
                                                <ul>
                                                    <li class="ltn__blog-date">
                                                        <a href="#"><i class="far fa-calendar-alt"></i>June 22, 2020</a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                                <li>
                                    <div class="popular-post-widget-item clearfix">
                                        <div class="popular-post-widget-img">
                                            <a href="blog-details.html"><img src="img/team/8.jpg" alt="#"></a>
                                        </div>
                                        <div class="popular-post-widget-brief">
                                            <h6><a href="blog-details.html">Lorem ipsum dolor sit
                                                cing elit, sed do.</a></h6>
                                            <div class="ltn__blog-meta">
                                                <ul>
                                                    <li class="ltn__blog-date">
                                                        <a href="#"><i class="far fa-calendar-alt"></i>June 22, 2020</a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </div> --}}
                        <!-- Social Media Widget -->
                        <div class="widget ltn__social-media-widget">
                            <h4 class="ltn__widget-title ltn__widget-title-border-2">Follow us</h4>
                            <div class="ltn__social-media-2">
                                <ul>
                                    <li><a href="#" title="Facebook"><i class="fab fa-facebook-f"></i></a></li>
                                    <li><a href="#" title="Twitter"><i class="fab fa-twitter"></i></a></li>
                                    <li><a href="#" title="Linkedin"><i class="fab fa-linkedin"></i></a></li>
                                    <li><a href="#" title="Instagram"><i class="fab fa-instagram"></i></a></li>
                                    
                                </ul>
                            </div>
                        </div>
                        <!-- Tagcloud Widget -->
                        {{-- <div class="widget ltn__tagcloud-widget">
                            <h4 class="ltn__widget-title ltn__widget-title-border-2">Popular Tags</h4>
                            <ul>
                                <li><a href="#">Popular</a></li>
                                <li><a href="#">desgin</a></li>
                                <li><a href="#">ux</a></li>
                                <li><a href="#">usability</a></li>
                                <li><a href="#">develop</a></li>
                                <li><a href="#">icon</a></li>
                                <li><a href="#">Car</a></li>
                                <li><a href="#">Service</a></li>
                                <li><a href="#">Repairs</a></li>
                                <li><a href="#">Auto Parts</a></li>
                                <li><a href="#">Oil</a></li>
                                <li><a href="#">Dealer</a></li>
                                <li><a href="#">Oil Change</a></li>
                                <li><a href="#">Body Color</a></li>
                            </ul>
                        </div> --}}
                        <!-- Banner Widget -->
                        <div class="widget ltn__banner-widget d-none">
                            <a href="shop.html"><img src="img/banner/2.jpg" alt="#"></a>
                        </div>
                    </aside>
                </div>
            </div>
        </div>
    </div>

    @endsection

    @section('categoria')



    @endsection

