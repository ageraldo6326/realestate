@include('layout.encabezadoBlog')

    @yield('content')

    <!-- SLIDER AREA -->

        @yield('galeria')
   
    <!-- SLIDER AREA END -->

    <!-- PRODUCT SLIDER AREA START -->

        @yield('propiedades_destacadas')

    <!-- PRODUCT SLIDER AREA END -->    

    <!-- COUNTER UP AREA START -->

        @yield('counter')

    <!-- COUNTER UP AREA END -->

  
    <!-- TESTIMONIAL AREA START (testimonial-7) -->
                
        @yield('testimonios')

    <!-- TESTIMONIAL AREA END -->


    <!-- FEATURE AREA START ( Feature - 6) -->

        @yield('enfoque')

    <!-- FEATURE AREA END -->


    <!-- Blog Item -->

        @yield('blog')

    <!-- Blog Item -->


    <!-- CALL TO ACTION START (call-to-action-6) -->
@include('layout.footer')