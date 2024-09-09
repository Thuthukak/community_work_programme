<head>
    <title>@yield('title')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" href="@if(isset($gs->logo)){{ asset(symImagePath().$gs->favicon_icon) }} @else {{ asset('images/favicons.ico') }} @endif">

    <link rel="stylesheet" type="text/css" media="screen" href="{{ asset($publicPath.'/css/style.css') }}">
    <link rel="stylesheet" type="text/css" media="screen" href="{{ asset($publicPath.'/css/home-page.css') }}">

    <link rel="stylesheet" type="text/css" href="{{ asset($publicPath.'/bootstrap-4.0.0/css/bootstrap.css') }}">


    <link rel="stylesheet" type="text/css" href="{{ asset('font-awesome-4.7.0/css/font-awesome.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset($publicPath.'/css/owl.carousel.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset($publicPath.'/css/owl.theme.default.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/toastr.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/aos.css') }}">

    @yield('style')
</head>