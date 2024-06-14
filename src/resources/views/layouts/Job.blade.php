@extends('layouts.crm')

@section('title')
@yield('subtitle', __('job.detail')) - {{ $job->name }}
@endsection
@section('content')
@include('jobs.partials.breadcrumb')
<h1 class="page-header">
    <div class="pull-right">
        @yield('action-buttons')
        {{ link_to_route('projects.jobs.index', __('job.back_to_index'), [$job->project_id, '#' . $job->id], ['class' => 'btn btn-default']) }}
    </div>
    {{ $job->name }} <small>@yield('subtitle', __('job.detail'))</small>
</h1>

@include('jobs.partials.nav-tabs')

@yield('content-job')

@endsection


@guest()
    <script>
        window.localStorage.removeItem('permissions');
    </script>
@endguest

@auth()
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
</body>
</html>