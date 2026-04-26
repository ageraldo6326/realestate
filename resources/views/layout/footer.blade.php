@if(isset($inmobiliaria))
<div class="ltn__call-to-action-area call-to-action-6 before-bg-bottom" data-bg="/img/1.jpg--">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="call-to-action-inner call-to-action-inner-6 ltn__secondary-bg text-center---">
                        <div class="coll-to-info text-color-white">
                            <span class="h1">{{ $inmo->titulo }}, {{ $inmo->slogan }}</span>
                        </div>
                        <div class="btn-wrapper">
                            <a class="btn btn-effect-3 btn-white" href="{{ route('listapropiedades') }}">Explorar Propiedades <i class="icon-next"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- CALL TO ACTION END -->

    <!-- FOOTER AREA START -->
    <footer class="ltn__footer-area  ">
        <div class="footer-top-area  section-bg-2 plr--5">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-xl-2 col-md-6 col-sm-6 col-12">
                        {{-- <div class="footer-widget footer-menu-widget clearfix">
                            <h4 class="footer-title">Company</h4>
                            <div class="footer-menu">
                                <ul>
                                    <li><a href="about.html">About</a></li>
                                    <li><a href="blog.html">Blog</a></li>
                                    <li><a href="shop.html">All Products</a></li>
                                    <li><a href="locations.html">Locations Map</a></li>
                                    <li><a href="faq.html">FAQ</a></li>
                                    <li><a href="contact.html">Contact us</a></li>
                                </ul>
                            </div>
                        </div> --}}
                    </div>
                    <div class="col-xl-2 col-md-6 col-sm-6 col-12">
                        {{-- <div class="footer-widget footer-menu-widget clearfix">
                            <h4 class="footer-title">Services</h4>
                            <div class="footer-menu">
                                <ul>
                                    <li><a href="order-tracking.html">Order tracking</a></li>
                                    <li><a href="wishlist.html">Wish List</a></li>
                                    <li><a href="login.html">Login</a></li>
                                    <li><a href="account.html">My account</a></li>
                                    <li><a href="about.html">Terms & Conditions</a></li>
                                    <li><a href="about.html">Promotional Offers</a></li>
                                </ul>
                            </div>
                        </div> --}}
                    </div>
                    <div class="col-xl-2 col-md-6 col-sm-6 col-12">
                        {{-- <div class="footer-widget footer-menu-widget clearfix">
                            <h4 class="footer-title">Customer Care</h4>
                            <div class="footer-menu">
                                <ul>
                                    <li><a href="login.html">Login</a></li>
                                    <li><a href="account.html">My account</a></li>
                                    <li><a href="wishlist.html">Wish List</a></li>
                                    <li><a href="order-tracking.html">Order tracking</a></li>
                                    <li><a href="faq.html">FAQ</a></li>
                                    <li><a href="contact.html">Contact us</a></li>
                                </ul>
                            </div>
                        </div> --}}
                    </div>
                    <div class="col-xl-2 col-md-6 col-sm-6 col-12">
                        <div class="footer-widget footer-about-widget">
                            <div class="footer-logo">
                                {{-- <div class="site-logo">
                                    <img src="img/logo-2.png" alt="Logo">
                                </div> --}}
                            </div>
                            <p>@if (isset($inmo->titulo)) {{$inmo->titulo}} @endif</p>
                            <div class="footer-address">
                                <ul>
                                    <li>
                                        <div class="footer-address-icon">
                                            <i class="icon-placeholder"></i>
                                        </div>
                                        <div class="footer-address-info">
                                            <p>@if (isset($inmo->direccion)) {{$inmo->direccion}} @endif</p>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="footer-address-icon">
                                            <i class="icon-call"></i>
                                        </div>
                                        <div class="footer-address-info">
                                            <p><a href="#">@if (isset($inmo->telefono)) {{$inmo->telefono}}
                                                    @endif</a></p>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="footer-address-icon">
                                            <i class="icon-mail"></i>
                                        </div>
                                        <div class="footer-address-info">
                                            <p><a href="@if (isset($inmo->correo)) {{$inmo->correo}}
                                                    @endif">@if (isset($inmo->correo)) {{$inmo->correo}}
                                                    @endif</a></p>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                            <div class="ltn__social-media mt-20">
                                <ul>
                                    <li><a href="@if (isset($inmo->facebook)) {{ $inmo->facebook }} @endif" title="Facebook"><i class="fab fa-facebook-f m-3 fa-2x"></i></a></li>
                                    <li><a href="@if (isset($inmo->instagram)) {{ $inmo->instagram }} @endif" title="Instagram"><i class="fab fa-instagram m-3 fa-2x"></i></a></li>
                                    <li><a href="@if (isset($inmo->whatsapp)) {{ $inmo->whatsapp }} @endif" title="Whatsapp"><i class="fab fa-whatsapp m-3 fa-2x"></i></a></li>
                                    <li><a href="@if (isset($inmo->tiktok)) {{ $inmo->tiktok }} @endif" title="Tiktok"><i class="fab fa-tiktok m-3 fa-2x"></i></a></li>
                                     
                                </ul>
                            </div>
                        </div>
                    </div>  

                    <div class="col-xl-3 col-md-6 col-sm-12 col-12">
                        <div class="footer-widget footer-newsletter-widget">
                            <h2 class="footer-title">Newsletter</h2>
                            <p>Subscribe to our weekly Newsletter and receive updates via email.</p>
                            <div class="footer-newsletter">
                                <form action="#">
                                    <input type="email" name="email" placeholder="Email*">
                                    <div class="btn-wrapper">
                                        <button aria-label="Submit Button" class="theme-btn-1 btn" type="submit"><i class="fas fa-location-arrow"></i></button>
                                    </div>
                                </form>
                            </div>
                            {{-- <h5 class="mt-30">We Accept</h5>
                            <img src="img/icons/payment-4.png" alt="Payment Image"> --}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="ltn__copyright-area ltn__copyright-2 section-bg-7  plr--5">
            <div class="container-fluid ltn__border-top-2">
                <div class="row">
                    <div class="col-md-6 col-12">
                        <div class="ltn__copyright-design clearfix">
                            <p>All Rights Reserved @ @if (isset($inmo->nombre)) {{$inmo->nombre}} @endif <span class="current-year"></span></p>
                        </div>
                    </div>
                    <div class="col-md-6 col-12 align-self-center">
                        <div class="ltn__copyright-menu text-right">
                            <ul>
                                <li><a href="#">Terms & Conditions</a></li>
                                <li><a href="#">Claim</a></li>
                                <li><a href="#">Privacy & Policy</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </footer>
    @endif
    <!-- FOOTER AREA END -->

</div>
    @livewireScripts
    {{-- <script src="js/rating.js"></script> --}}
    <!-- All JS Plugins -->
    <script src="/js/plugins.js"></script>
    <!-- Main JS -->
    <script src="/js/main.js"></script>
    
</body>
</html>

