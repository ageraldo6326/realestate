<?php if(isset($inmobiliaria)): ?>
    <div class="ltn__call-to-action-area call-to-action-6 before-bg-bottom" data-bg="/img/1.jpg--">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="call-to-action-inner call-to-action-inner-6 ltn__secondary-bg text-center---">
                        <div class="coll-to-info text-color-white">
                            <H1 class="h1"><?php echo e($inmo->titulo); ?>, <?php echo e($inmo->slogan); ?></H1>
                        </div>
                        <div class="btn-wrapper">
                            <a class="btn btn-effect-3 btn-white" href="<?php echo e(route('listapropiedades')); ?>">Explorar Propiedades <i class="icon-next"></i></a>
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

                    </div>
                    <div class="col-xl-2 col-md-6 col-sm-6 col-12">

                    </div>
                    <div class="col-xl-2 col-md-6 col-sm-6 col-12">

                    </div>
                    
                    <div class="col-xl-3 col-md-6 col-sm-12 col-12">
                        <div class="footer-widget footer-about-widget">
                            <div class="footer-logo">

                            </div>
                            <p><?php if(isset($inmo->titulo)): ?> <?php echo e($inmo->titulo); ?> <?php endif; ?></p>
                            <div class="footer-address">
                                <ul>
                                    <li>
                                        <div class="footer-address-icon">
                                            <i class="icon-placeholder"></i>
                                        </div>
                                        <div class="footer-address-info">
                                            <p><?php if(isset($inmo->direccion)): ?> <?php echo e($inmo->direccion); ?> <?php endif; ?></p>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="footer-address-icon">
                                            <i class="icon-call"></i>
                                        </div>
                                        <div class="footer-address-info">
                                            <p><a href="#"><?php if(isset($inmo->telefono)): ?> <?php echo e($inmo->telefono); ?>

                                                    <?php endif; ?></a></p>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="footer-address-icon">
                                            <i class="icon-mail"></i>
                                        </div>
                                        <div class="footer-address-info">
                                            <p><a href="<?php if(isset($inmo->correo)): ?> <?php echo e($inmo->correo); ?>

                                                    <?php endif; ?>"><?php if(isset($inmo->correo)): ?> <?php echo e($inmo->correo); ?>

                                                    <?php endif; ?></a></p>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                            <div class="ltn__social-media mt-20">
                                <ul>
                                    <li><a href="<?php if(isset($inmo->facebook)): ?> <?php echo e($inmo->facebook); ?> <?php endif; ?>" title="Facebook"><i class="fab fa-facebook-f m-3 fa-2x"></i></a></li>
                                    <li><a href="<?php if(isset($inmo->instagram)): ?> <?php echo e($inmo->instagram); ?> <?php endif; ?>" title="Instagram"><i class="fab fa-instagram m-3 fa-2x"></i></a></li>
                                    <li><a href="<?php if(isset($inmo->whatsapp)): ?> <?php echo e($inmo->whatsapp); ?> <?php endif; ?>" title="Whatsapp"><i class="fab fa-whatsapp m-3 fa-2x"></i></a></li>
                                    <li><a href="<?php if(isset($inmo->tiktok)): ?> <?php echo e($inmo->tiktok); ?> <?php endif; ?>" title="Tiktok"><i class="fab fa-tiktok m-3 fa-2x"></i></a></li>
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
                                        <button class="theme-btn-1 btn" aria-label="Submit Button" type="submit"><i class="fas fa-location-arrow"></i></button>
                                    </div>
                                </form>
                            </div>
                            
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
                            <p>All Rights Reserved @ <?php if(isset($inmo->nombre)): ?> <?php echo e($inmo->nombre); ?> <?php endif; ?> <span class="current-year"></span></p>
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
    <?php endif; ?>
    <!-- FOOTER AREA END -->

</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.10/jquery.mask.js"></script>
<script>
    $(document).ready(function ($) {
        // Aplicar máscara de dinero al campo de monto
        $('.monto').mask('000,000,000,000,000', { reverse: true });
    });
</script>
    <?php echo \Livewire\Livewire::scripts(); ?>


    
    <!-- All JS Plugins -->
    <script src="/js/plugins.js"></script>
    <!-- Main JS -->
    <script src="/js/main.js"></script>


    
</body>
</html>

<?php /**PATH D:\xampp3\htdocs\realestate_dev\resources\views/layout/footerHome.blade.php ENDPATH**/ ?>