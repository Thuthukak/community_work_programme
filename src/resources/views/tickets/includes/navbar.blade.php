<section id="nav-bar">
    <nav class="navbar navbar-expand-lg navbar-light">
    <a class="navbar-brand" href="{{ url(env('APP_URL')) }}">

            @php
                $logoUrl = isset($gs) && $gs->logo ? asset(symImagePath() . $gs->logo) : asset(env('APP_URL') . '/images/logo/wcp_logo_only_b&w.png');
            @endphp
            <img src="{{ $logoUrl }}" style="height: 75px; width: 150px; filter:invert(100%);">
        </a>

   

        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <i class="fa fa-bars"></i>
        </button>
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
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Opportunities
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="navbarDropdown " style="background-color: #fe9a4e !important; z-index: 1000;">
                        <li>
                            <a class="dropdown-item" href="{{ route('jobSeekerOpportunities') }}" style="color: black; background-color:#fe9a4e !important; padding: 10px; hover: background-color: #fe9a4e !important">{{ __('theme.job_seekers') }}</a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="{{ route('employee') }}" style="color: black; background-color: white; padding: 10px;">{{ __('theme.employers') }}</a>
                        </li>
                    </ul>
                </li>

                @guest
                <li class="nav-item nl-border">
                    <a class="nav-link" href="javascript:void(0);" data-toggle="modal" data-target="#loginModal">{{ __('theme.login') }}</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="javascript:void(0);" data-toggle="modal" data-target="#registerModal">{{ __('theme.register') }}</a>
                </li>
                @else
                    <li class="nav-item dropdown">
                        <a id="navbarDropdown" class="nav-link dropdown-toggle position absolute-left" href="javascript:void(0);" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                            {{ Auth::user()->name }} <span class="caret"></span>
                        </a>

                        <div class="dropdown-menu dropdown-menu-right " aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="{{ request()->root().'/admin/dashboard' }}">
                                {{__('theme.dashboard')}}
                            </a>
                            <a class="dropdown-item" href="{{ route('auth.log_out') }}">
                                {{ __('theme.logout') }}
                            </a>
                        </div>
                    </li>
                @endguest
            </ul>
        </div>
    </nav>
</section>
<style>
.custom-dw {
    right: 20px !important;
    left: -115px !important;
}

    /* General styling for the dropdown menu background */
.dropdown-menu {
    background-color: #fe9a4e !important;
    
}

/* Styling for the dropdown items */
.dropdown-item {
    color: black !important;
    background-color: #fe9a4e !important;
    padding: 10px;
}

/* Hover styling for dropdown items */
.dropdown-item:hover {
    color: black !important;
    background-color: #fe9a4e !important; /* Keep the background color the same on hover */
}

</style>