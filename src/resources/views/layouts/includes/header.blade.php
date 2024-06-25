@stack('before-styles')
{{ style(mix('css/dropzone.css')) }}
{{ style(mix('css/core.css')) }}
{{ style(mix('css/fontawesome.css')) }}
{{ style('vendor/summernote/summernote-bs4.css') }}
<script src="{{ url('assets/js/plugins/select2.min.js') }}"></script>

@stack('after-styles')
