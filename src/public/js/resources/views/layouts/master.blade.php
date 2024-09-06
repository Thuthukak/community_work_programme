<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="{{ App\Helpers\LanguageDirection::getDirection(app()->getLocale()) }}">

@include('layouts.head')
<body>

@include('layouts.navbar')

<div id="app">

    @yield('content')
    
</div>

<a href="javascript:" id="return-to-top"><i class="fa fa-arrow-up"></i></a>

@include('layouts.footer')
<script>
    window.appUrl = '{{ $appUrl }}';
</script>
</body>
</html>