<html lang="<?php  app()->getLocale(); ?>">
<head>
    <meta charset="UTF-8"/>
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0"/>
    <meta http-equiv="X-UA-Compatible" content="ie=edge"/>
    <link rel="shortcut icon" href="{{ env('APP_URL').config('settings.application.company_icon') }}"/>
    <link rel="apple-touch-icon" href="{{ env('APP_URL').config('settings.application.company_icon') }}"/>
    <link rel="apple-touch-icon-precomposed" href="{{ env('APP_URL').config('settings.application.company_icon') }}"/>
    <title>@yield('title') - {{ config('app.name') }}</title>
    @include('layouts.includes.header')
</head>
<body>
<div id="app">
    <div class="container-scroller">
        <!--Top Navbar-->
    @section('nav-bar')
        @include('layouts.includes.navbar')
    @show
    <!--Sidebar-->
        @section('side-bar')
            @include('layouts.includes.sidebar')
        @show
        <div class="container-fluid page-body-wrapper">
            <div class="main-panel">
                <!--Contents-->
                @yield('contents')
            </div>
        </div>
    </div>
</div>
@guest()
    <script>
        window.localStorage.removeItem('permissions');
    </script>
@endguest

@auth()

<!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script> -->
    <script>
        window.localStorage.setItem('permissions', JSON.stringify(
            <?php echo json_encode(array_merge(
                    resolve(\App\Repositories\Core\Auth\UserRepository::class)->getPermissionsForFrontEnd(),
                    [
                        'is_app_admin' => auth()->user()->isAppAdmin(),
                    ]
                )
            )
            ?>
        ))
        window.onload = function () {
            window.scroll({
                top: 0,
                left: 0,
                behavior: 'smooth'
            })
        }
    </script>
@endauth


<!-- Include necessary JS libraries -->
{!! Html::script(url('../assets/js/jquery.js')) !!}
    {!! Html::script(url('../assets/js/bootstrap.min.js')) !!}
    @include('crm.layouts.partials.noty')
    {!! Html::script(url('../assets/js/plugins/metisMenu/metisMenu.min.js')) !!}
    @yield('ext_js')
    {!! Html::script(url('../assets/js/sb-admin-2.js')) !!}


<script type="text/javascript">
(function() {
    $("div.alert.notifier, div.alert.add-cart-notifier").delay(5000).slideUp('slow');
    $.ajaxSetup({
        headers: {
            'X-CSRF-Token': $('meta[name="x-csrf-token"]').attr('content')
        },
        beforeSend: function(xhr){
            xhr.setRequestHeader('Authorization', 'Bearer ' + "{{ auth()->user()->api_token }}");
        }
    });
})();
</script>



<script>

    window.localStorage.setItem('base_url', '<?php echo request()->root(); ?>');
</script>

<script>
    window.settings = <?php echo json_encode($settings) ?>
</script>
<script>
    if (!window.localStorage.getItem('app-language')) {
        // initital language added
        window.localStorage.setItem('app-language', "en");
    }
    ;

    window.user = <?php echo auth()->user()->load('profilePicture', 'roles'); ?>;
    window.user.isAppAdmin = "{{!!auth()->user()->isAppAdmin()}}";
    window.broadcastDriver = "{{config('services.broadcast_custom_driver','ajax')}}";
    window.pusherDriver = <?php echo config('services.broadcast_custom_driver') == 'pusher' ?  json_encode([
				'MIX_PUSHER_APP_KEY'=>config('broadcasting.connections.pusher.key'),
				'MIX_PUSHER_APP_CLUSTER'=>config('broadcasting.connections.pusher.options.cluster')
			]) : json_encode([
				'MIX_PUSHER_APP_KEY'=>'',
				'MIX_PUSHER_APP_CLUSTER'=>''
			]) ?>
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
@include('layouts.includes.footer')

@yield('script')
</body>
</html>