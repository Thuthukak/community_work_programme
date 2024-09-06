<head>
    <title>@yield('title')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" href="@if(isset($gs->logo)){{ asset(symImagePath().$gs->favicon_icon) }} @else {{ asset('images/favicons.ico') }} @endif">
    <link rel="stylesheet" href="css/about.css">
    <link rel="stylesheet" href="css/auth.css">
    <link rel="stylesheet" href="css/contact.css">
    <link rel="stylesheet" href="css/custom.css">
    <link rel="stylesheet" href="css/aos.css">
    <link rel="stylesheet" type="text/css" media="screen" href="css/style.css">
    <link rel="stylesheet" type="text/css" media="screen" href="css/home-page.css">

    <link rel="stylesheet" href="src/public/bootstrap-4.0.0/css/bootstrap.css">


    <link rel="stylesheet" href="src/public/font-awesome-4.7.0/css/font-awesome.css">
    <link rel="stylesheet" href=" src/public/css/owl.carousel.min.css') }}">
    <link rel="stylesheet" href=" scr/public/css/owl.theme.default.min.css') }}">
    <link rel="stylesheet" type="text/css" href="src/public/assets/css/toastr.min.css">

    @yield('style')
</head>