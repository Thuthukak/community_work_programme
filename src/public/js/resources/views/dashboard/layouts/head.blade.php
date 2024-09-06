<meta name="csrf-token" content="{{ csrf_token() }}">
<meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=no' name='viewport' />
<link rel="icon" href="@if($gs->logo){{ asset(symImagePath().$gs->favicon_icon) }} @else {{ asset('images/favicons.ico') }} @endif">
<link rel="stylesheet" href="{{ asset('css/app.css') }}">
<link rel="stylesheet" href="{{ asset('css/fonts-family.css') }}">
<link rel="stylesheet" href="{{ asset('assets/css/dashboard-style.css') }}">
<link rel="stylesheet" href="{{ asset('assets/line-awesome/css/line-awesome.css') }}">
<link rel="stylesheet" href="{{ asset('assets/line-awesome/css/line-awesome-font-awesome.css') }}">
<link rel="stylesheet" href="{{ asset('font-awesome-4.7.0/css/font-awesome.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/toastr.min.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/notification.css') }}">
