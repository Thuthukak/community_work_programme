<html lang="<?php  app()->getLocale(); ?>">
<head>
    <meta charset="UTF-8"/>
    <meta name="viewport"
    content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0"/>
    <meta http-equiv="X-UA-Compatible" content="ie=edge"/>
    <link rel="shortcut icon" href="{{ env('APP_URL').config('settings.application.company_icon') }}"/>
    <link rel="apple-touch-icon" href="{{ env('APP_URL').config('settings.application.company_icon') }}"/>
    <link rel="apple-touch-icon-precomposed" href="{{ env('APP_URL').config('settings.application.company_icon') }}"/>
     <link href="https://unpkg.com/tailwindcss@^2/dist/tailwind.min.css" rel="stylesheet">
     <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css">


     

    <title>@yield('title') - {{ config('app.name') }}</title>
    @include('tickets.includes.head')

</head>
<body>

<div class="hidden md:block"> @include('tickets.includes.navbar') </div>
<div class="block md:hidden"> @include('tickets.includes.navbar-mobile') </div>

<div id="app">
    <div class="container-scroller">
        <div class="page-body-wrapper">
            <div class="main-panel">
                <!--Contents-->
                @yield('contents')
            </div>
        </div>
    </div>
</div>
@yield('ext_js')
<script>

    window.localStorage.setItem('base_url', '<?php echo request()->root(); ?>');
</script>

<script>
    window.settings = <?php echo json_encode($settings ?? '') ?>
</script>
<script>
    window.localStorage.setItem('app-languages',
        JSON.stringify(
            @php
                echo
                    json_encode(
                        include resource_path()
                            . DIRECTORY_SEPARATOR . 'lang'
                            . DIRECTORY_SEPARATOR .
                            (
                                Cookie::has('user_lang') ? Cookie::get('user_lang') : ($settings['language'] ?? 'en')
                            )
                            . DIRECTORY_SEPARATOR . 'default.php'
                    )
            @endphp
        )
        );
</script>
@include('tickets.includes.footer')

@yield('script')
</body>
</html>