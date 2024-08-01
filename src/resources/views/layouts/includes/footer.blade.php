<footer>
    @routes
    @stack('before-scripts')
    {!! script(mix('js/vendor.js')) !!}
    {!! script(mix('js/manifest.js')) !!}
    {!! script(mix('js/core.js')) !!}
    {!! script('vendor/summernote/summernote-bs4.js') !!}
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>z
    @stack('after-scripts')
</footer>
