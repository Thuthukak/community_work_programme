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
<script src="{{ asset('src/public/js/app.js') }}"></script>

@yield('script')

<!--- Smooth Scroll --->
<script type="text/javascript" src="{{ asset('src/public/js/smooth-scroll.js') }}"></script>
<!-- scripts -->
<script src= "{{ asset('src/public/js/particles.js') }}"></script>
<script src="{{ asset('src/public/js/particles-app.js') }}"></script>
<!-- stats.js -->
<script src="{{ asset('src/public/js/stats.js') }}"></script>

<script src="{{ asset('src/public/js/aos.js') }} "></script>
<script src="{{ asset('src/public/js/owl.carousel.min.js') }}"></script>
<script src="{{ asset('src/public/assets/js/tickets/toastr.min.js') }}"></script>
<script src="{{ asset('src/public/js/custom.js') }}"></script>
<script src="{{ asset('src/public/js/main.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>



<!--toaster message-->
@include('tickets.toasterMessage')