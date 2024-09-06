<!--- footer section --->
<section id="footer">
    <div class="container">
        <div class="row">
            @include('tickets.includes.footerMenu')
        </div>
        <hr>
        @php
        $Title = isset($gs) ? $gs->title : '';
        @endphp
        <p class="copyright">© {{ __('theme.copyright') }} {{ $Title }} {{ now()->year }}</p>
    </div>
</section>

<!--script-->
<script src="src/public/js/app.js"></script>

@yield('script')

<!--- Smooth Scroll --->
<script type="text/javascript" src="src/public/js/smooth-scroll.js"></script>
<!-- scripts -->
<script src="src/public/js/particles.js"></script>
<script src="src/public/js/particles-app.js"></script>
<!-- stats.js -->
<script src="src/public/js/stats.js"></script>

<script src="src/public/js/aos.js"></script>
<script src="src/public/js/owl.carousel.min.js"></script>
<script src="src/public/assets/js/tickets/toastr.min.js"></script>
<script src="src/public/js/custom.js"></script>
<script src="src/public/js/main.js"></script>

<!--toaster message-->
@include('tickets.toasterMessage')