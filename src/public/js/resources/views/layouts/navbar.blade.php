@inject('languages', 'App\Http\Controllers\SwitchLanguageController')
<section id="nav-bar">
    <nav class="navbar navbar-expand-lg navbar-light">
        <a class="navbar-brand" href="{{ url($appUrl) }}">
            <img src="@if($gs->logo){{ asset(symImagePath().$gs->logo) }} @else {{ asset($publicPath.'/images/logo/wcp_logo_only_b&w.png') }} @endif"
            style="height: 75px; width: 150px; filter:invert(100%);">
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <i class="fa fa-bars"></i>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link" href="{{ url($appUrl.'/#top') }}">{{ __('theme.home') }}</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('KnowledgeBaseIndex') }}">{{ __('theme.knowledge_base') }}</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ url($appUrl.'/#services') }}">{{ __('theme.services') }}</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ url($appUrl.'/#testimonials') }}">{{ __('theme.testimonials') }}</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ url($appUrl.'/about-us') }}">{{ __('theme.about_us') }}</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('contactPage') }}">{{ __('theme.contact') }}</a>
                </li>
                <li class="nav-item dropdown">
                    <a id="navbarDropdown" class="nav-link dropdown-toggle" href="javascript:void(0);" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                        {{ strtoupper(app()->getLocale()) }} <span class="caret"></span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right custom-dw" aria-labelledby="navbarDropdown">
                        @foreach($languages->getLanguage() as $language)
                            <a class="dropdown-item language" data-locale="{{ $language->code }}" data-lang="{{ $language->code }}" href="javascript:void(0)">{{ $language->name }}</a>
                        @endforeach
                    </div>
                </li>
                @guest
                    <li class="nav-item nl-border">
                    <a class="nav-link" href="http://localhost/marketplace_version">{{ __('theme.login') }} </a>
                    <!-- <a class="nav-link" href="{{ route('login') }}">{{ __('theme.login') }}</a> -->
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('register') }}">{{ __('theme.register') }}</a>
                    </li>

                @else

                    <li class="nav-item dropdown">
                        <a id="navbarDropdown" class="nav-link dropdown-toggle" href="javascript:void(0);" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                            {{ Auth::user()->name }} <span class="caret"></span>
                        </a>

                        <div class="dropdown-menu dropdown-menu-right custom-dw" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="{{ route('dashboard') }}">
                                {{__('theme.dashboard')}}
                            </a>
                            <a class="dropdown-item" href="{{ route('logout') }}"
                               onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                {{ __('theme.logout') }}
                            </a>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                        </div>
                    </li>
                @endguest
            </ul>
        </div>
    </nav>
</section>