<!--- footer section --->
<section id="footer">
    <div class="container">
        <div class="row">
            @include('layouts.footerMenu')
        </div>
        <hr>
        <p class="copyright">© {{ __('theme.copyright') }} {{ $gs->title }} {{ now()->year }}</p>
    </div>
</section>

<!--script-->
<script src="{{ asset($publicPath.'/js/app.js') }}"></script>

@yield('script')

<!--- Smooth Scroll --->
<script type="text/javascript" src="{{ asset($publicPath.'/js/smooth-scroll.js') }}"></script>
<!-- scripts -->
<script src="{{ asset($publicPath.'/js/particles.js') }}"></script>
<script src="{{ asset($publicPath.'/js/particles-app.js') }}"></script>
<!-- stats.js -->
<script src="{{ asset($publicPath.'/js/stats.js') }}"></script>

<script src="{{ asset($publicPath.'/js/aos.js') }}"></script>
<script src="{{ asset($publicPath.'/js/owl.carousel.min.js') }}"></script>
<script src="{{ asset($publicPath.'/assets/js/toastr.min.js') }}"></script>
<script src="{{ asset($publicPath.'/js/custom.js') }}"></script>
<script src="{{ asset($publicPath.'/js/main.js') }}"></script>

<!--toaster message-->
@include('includes.toasterMessage')