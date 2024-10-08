<section id="nav-bar">
    <nav class="navbar navbar-expand-lg navbar-light">
        <div class="container-fluid d-flex justify-content-between align-items-center">   
            <!-- Hamburger Button on the Left -->
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <i class="fa fa-bars"></i>
            </button>
            
            <!-- Logo in the Middle -->
            <a class="navbar-brand mx-auto d-flex justify-content-center" href="{{ url(env('APP_URL')) }}">
                @php
                    $logoUrl = isset($gs) && $gs->logo ? asset(symImagePath() . $gs->logo) : asset(env('APP_URL') . '/images/logo/wcp_logo_only_b&w.png');
                @endphp
                <img src="{{ $logoUrl }}" style="height: 75px; width: 150px; filter:invert(100%);">
            </a>
            
            <!-- Login Button on the Right -->
            <div class="d-flex align-items-center">
                @guest
                <a class="nav-link" href="javascript:void(0);" data-toggle="modal" data-target="#registerModal">{{ __('theme.register') }}</a>
                @else
                    <div class="dropdown">
                        <a id="navbarDropdown" class="nav-link dropdown-toggle" href="javascript:void(0);" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                            {{ Auth::user()->name }} <span class="caret"></span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right custom-dw" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="{{ request()->root().'/admin/dashboard' }}">
                                {{__('theme.dashboard')}}
                            </a>
                            <a class="dropdown-item" href="{{ route('auth.log_out') }}">
                                {{ __('theme.logout') }}
                            </a>
                        </div>
                    </div>
                @endguest
            </div>
        </div>

        <!-- Collapsible Navbar Menu -->
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link" href="{{route('homePage') }}">{{ __('theme.home') }}</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{route('KnowledgeBaseIndex') }}">{{ __('theme.knowledge_base') }}</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ url(env('APP_URL').'/#services') }}">{{ __('theme.services') }}</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ url(env('APP_URL').'/#testimonials') }}">{{ __('theme.testimonials') }}</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{  url(env('APP_URL').'/about-us') }}">{{ __('theme.about_us') }}</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('contactPage') }}">{{ __('theme.contact') }}</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('contactPage') }}">{{ __('theme.opportunities') }}</a>
                </li>
            </ul>
        </div>
    </nav>
</section>
