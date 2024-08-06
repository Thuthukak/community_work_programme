<footer>
    @routes
    @stack('before-scripts')
    {!! script(mix('js/vendor.js')) !!}
    {!! script(mix('js/manifest.js')) !!}
    {!! script(mix('js/core.js')) !!}
    {!! script('vendor/summernote/summernote-bs4.js') !!}
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>z
    {{-- <script src="{{ asset('src/public/assets/js/okr/scroll.js') }}" defer></script> --}}
    <script src="https://unpkg.com/gijgo@1.9.11/js/gijgo.min.js" type="text/javascript" defer></script>
    <script src="{{ asset('src/public/assets/js/okr/datepicker.js') }}" defer></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/ion-rangeslider/2.3.0/js/ion.rangeSlider.min.js" defer></script>
    <script src="{{ asset('src/public/assets/js/okr/slider.js') }}" defer></script>
    {{-- <script src="https://js.pusher.com/3.1/pusher.min.js" defer></script> --}}
    <script src="{{ asset('src/public/assets/js/okr/textarea.js') }}" defer></script>
    @stack('after-scripts')
</footer>
