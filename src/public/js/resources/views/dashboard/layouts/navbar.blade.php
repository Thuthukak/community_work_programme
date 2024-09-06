@inject('notifications', 'App\Http\Controllers\NotificationController')

<div class="logo-header">
    <a href="{{ route('dashboard') }}" class="logo">
        {{ $gs->app_name ?? config('devstar.app_name') }}
    </a>
    <button class="navbar-toggler sidenav-toggler ml-auto" type="button" data-toggle="collapse" data-target="collapse"
            aria-controls="sidebar" aria-expanded="false" aria-label="Toggle navigation">
        <i class="la la-bars"></i>
    </button>
    <button class="topbar-toggler more">
        <i class="la la-ellipsis-v"></i>
    </button>
</div>
<nav class="navbar navbar-header navbar-expand-lg">
    <div class="container-fluid">
        @php
            $user = Auth::user();
        @endphp

        <ul class="navbar-nav topbar-nav ml-md-auto align-items-center">
            <li class="nav-item dropdown">
                <a href="{{ route('homePage') }}" class="pr-3">{{ __('theme.home') }}</a>
                <a class="nav-link countUp" href="javascript:void(0)" id="navbarDropdown" role="button"
                   data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fa fa-bell notify"></i>
                    <span class="count notifyCount">{{ $notifications->notificationCount() }}</span>
                </a>
                <ul class="dropdown-menu">
                    <li class="head">
                        <div class="row">
                            <div class="col-lg-12 col-sm-12 col-12 pb-2 border-bottom">
                                <span>{{ __('theme.notifications') }}</span>
                            </div>
                    </li>

                    <li class="notification-box">
                        <div class="">
                            @forelse($notifications->index() as $notify)
                                <div class="px-2 @if(!$loop->last) border-bottom @endif"
                                     @if(!$notify->read_at) style="background: aliceblue;"
                                     id="notificationRead-{{ $notify->id }}" data-nid="{{ $notify->id }}"
                                     data-ticketid="{{ $notify->data['ticket_id'] }}"
                                        @endif>
                                    <div>
                                        <a href="@if(!$notify->read_at) javascript:void(0) @else {{ route('ticket.show', $notify->data['ticket_id']) }} @endif"> {{ $notify->data['title'] }}</a>
                                    </div>
                                    <small class="text-warning">{{ $notify->created_at->format('Y-m-d') }}
                                        - {{ $notify->created_at->diffForHumans() }}</small>
                                </div>
                            @empty
                                <div class="px-2">
                                    {{ __('theme.notification_empty') }}
                                </div>

                            @endforelse
                        </div>
                    </li>
                    <li class="footer text-center">
                        <a href="{{ route('allNotification') }}" class="text-info">{{ __('theme.view_all') }}</a>
                    </li>
                </ul>
            </li>

            <li class="nav-item dropdown">
                <a class="dropdown-toggle profile-pic" data-toggle="dropdown" href="#" aria-expanded="false">
                    @if($user->avatar)
                        <img src="{{ asset(symImagePath().$user->avatar) }}" alt="avatar" width="36" class="img-circle">
                    @else
                        <img src="{{ asset($publicPath.'/uploads/profile/default.jpg') }}" alt="avatar" width="36"
                             class="img-circle">
                    @endif
                    <span>{{ $user->name }}</span>
                </a>
                <ul class="dropdown-menu dropdown-user">
                    <li>
                        <div class="user-box">
                            <div class="u-img">
                                @if($user->avatar)
                                    <img src="{{ asset(symImagePath().$user->avatar) }}" alt="user">
                                @else
                                    <img src="{{ asset($publicPath.'/uploads/profile/default.jpg') }}" alt="user">
                                @endif
                            </div>
                            <div class="u-text">
                                <h4> {{ $user->name }}</h4>
                                <p class="text-muted">{{ $user->email }}</p>
                            </div>
                        </div>
                    </li>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="{{ route('profile.index') }}"><i
                                class="la la-user"></i> {{ __('theme.my_profile') }}</a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="{{ route('logout') }}"
                       onclick="event.preventDefault();
                        document.getElementById('logout-form').submit();">
                        <i class="la la-power-off"></i> {{ __('theme.logout') }}
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </ul>
                <!-- /.dropdown-user -->
            </li>
        </ul>
    </div>
</nav>
