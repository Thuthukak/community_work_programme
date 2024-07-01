<footer>
    @routes
    @stack('before-scripts')
    {!! script(mix('js/vendor.js')) !!}
    {!! script(mix('js/manifest.js')) !!}
    {!! script(mix('js/core.js')) !!}
    {!! script('vendor/summernote/summernote-bs4.js') !!}
    <!-- <script src="https://code.jquery.com/jquery-2.2.4.min.js"></script>
    <script src="{{ asset('assets/js/bootstrap.min.js') }}"></script>
     <script src="{{ asset('assets/js/sb-admin-2.js') }}"></script> -->
    <script src="{{ asset('assets/js/plugins/jquery.datetimepicker.js') }}"></script> 
    <!-- <script src="{{ asset('assets/js/plugins/metisMenu/metisMenu.min.js') }}"></script> -->
    <!-- <script src="{{ asset('assets/js/plugins/jquery-ui.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/select2.min.js') }}"></script> -->
    @stack('after-scripts')
</footer>
