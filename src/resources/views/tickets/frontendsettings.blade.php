@extends('layouts.crm')

@section('contents')

<h4 class="pill-container heading-font ml-5" style="margin:30px; color:#374151">{{ __('default.settings') }}</h4>

<div class="container-fluid mt-4 vertical-tab" style="margin-left: 20px;">   
    <div class="row no-gutters">
        <!-- Tab Menu -->
        <div class="col-md-2 pr-md-3 tab-menu">
            <div class="card card-with-shadow border-0">
                <div class="header-icon">
                    <div class="icon-position d-flex justify-content-center">
                        <div class="tab-icon d-flex justify-content-center align-items-center ">
                            <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="#ff740b" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-settings">
                                <circle cx="12" cy="12" r="3"></circle>
                                <path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1 0 2.83 2 2 0 0 1-2.83 0l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-2 2 2 2 0 0 1-2-2v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83 0 2 2 0 0 1 0-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1-2-2 2 2 0 0 1 2-2h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 0-2.83 2 2 0 0 1 2.83 0l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 2-2 2 2 0 0 1 2 2v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 0 2 2 0 0 1 0 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 2 2 2 2 0 0 1-2 2h-.09a1.65 1.65 0 0 0-1.51 1z"></path>
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Vertical Navigation -->
                <div class="px-primary py-primary app-text">
                    <div role="tablist" aria-orientation="vertical" class="nav flex-column nav-pills">
                        <a id="logo-tab" data-toggle="pill" href="#logoIcon" data-title="{{ __('theme.logo_icon') }}" class="tab-item-link d-flex justify-content-between my-sm-3 active">
                            <span>{{ __('theme.logo_icon') }}</span>
                            <span class="active-icon"><i class="feather fa fa-chevron-right"></i></span>
                        </a>
                        <a id="social-tab" data-toggle="pill" href="#socialLink" data-title="{{ __('theme.social_link') }}" class="tab-item-link d-flex justify-content-between my-sm-3">
                            <span>{{ __('theme.social_link') }}</span>
                            <span class="active-icon"><i class="feather fa fa-chevron-right"></i></span>
                        </a>
                        <a id="banner-tab" data-toggle="pill" href="#bannerText" data-title="{{ __('theme.banner_text') }}" class="tab-item-link d-flex justify-content-between my-sm-3">
                                <span>{{ __('theme.banner_text') }}</span>
                                <span class="active-icon"><i class="feather fa fa-chevron-right"></i></span>
                            </a>
                   
                            <a id="work-tab" data-toggle="pill" href="#howWeWork" data-title="{{ __('theme.how_we_work') }}" class="tab-item-link d-flex justify-content-between my-sm-3">
                                <span>{{ __('theme.how_we_work') }}</span>
                                <span class="active-icon"><i class="feather fa fa-chevron-right"></i></span>
                            </a>
                            <a id="service-tab" data-toggle="pill" href="#service_setting" data-title="{{ __('theme.service_setting') }}" class="tab-item-link d-flex justify-content-between my-sm-3">
                                <span>{{ __('theme.service_setting') }}</span>
                                <span class="active-icon"><i class="feather fa fa-chevron-right"></i></span>
                            </a>   
                            
                            <a id="counter-tab" data-toggle="pill" href="#counter_setting" data-title="{{ __('theme.counter_setting') }}" class="tab-item-link d-flex justify-content-between my-sm-3">
                                <span>{{ __('theme.counter_setting') }}</span>
                                <span class="active-icon"><i class="feather fa fa-chevron-right"></i></span>
                            </a>  
                            
                            <a id="testimonial-tab" data-toggle="pill" href="#testimonial" data-title="{{ __('theme.testimonial') }}" class="tab-item-link d-flex justify-content-between my-sm-3">
                                <span>{{ __('theme.testimonial') }}</span>
                                <span class="active-icon"><i class="feather fa fa-chevron-right"></i></span>
                            </a> 
                            
                            <a id="about-us-tab" data-toggle="pill" href="#about_us" data-title="{{ __('theme.about_us') }}" class="tab-item-link d-flex justify-content-between my-sm-3">
                                <span>{{ __('theme.about_us') }}</span>
                                <span class="active-icon"><i class="feather fa fa-chevron-right"></i></span>
                            </a>  
                            
                            <a id="footer-tab" data-toggle="pill" href="#footer" data-title="{{ __('theme.footer') }}" class="tab-item-link d-flex justify-content-between my-sm-3">
                                <span>{{ __('theme.footer') }}</span>
                                <span class="active-icon"><i class="feather fa fa-chevron-right"></i></span>
                            </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tab Content -->
        <div class="col-md-9 pl-md-3 pt-md-0 pt-sm-4 pt-4">
            <div class="card card-with-shadow border-0">
                <div class="tab-content px-primary ">
                    <div class="d-flex justify-content-between">
                        <h5 class="d-flex align-items-center text-capitalize mb-0 title-text tab-content-header" id="tabContentTitle">
                            {{ __('default.settings') }}
                        </h5>
                    </div>
                    <hr>

                    <!-- Logo Icon Tab -->
                    <div id="logoIcon" class="tab-pane fade show active">
                        @include('frontendSetting.logoIcon')
                    </div>
                    <!-- Social Link Tab -->
                    <div id="socialLink" class="tab-pane fade">
                        @include('frontendSetting.socialLink')
                    </div>
                    <!-- Banner Text Tab -->
                    <div id="bannerText" class="tab-pane fade">
                    @include('frontendSetting.logoIcon')
                    </div>
                    <!-- How We Work Tab -->
                    <div id="howWeWork" class="tab-pane fade">
                    @include('frontendSetting.howWork')
                    </div>
                      <!-- services  Tab -->
                      <div id="service_setting" class="tab-pane fade">
                      @include('frontendSetting.service')
                      </div>  <!-- couter Tab -->
                    <div id="counter_setting" class="tab-pane fade">
                    @include('frontendSetting.counter')
                    </div>  <!-- testimonial Tab -->
                    <div id="testimonial" class="tab-pane fade">
                    @include('frontendSetting.testimonial')
                    </div>  <!-- about us Tab -->
                    <div id="about_us" class="tab-pane fade">
                    @include('frontendSetting.aboutus')
                    </div>  <!-- footer Tab -->
                    <div id="footer" class="tab-pane fade">
                    @include('frontendSetting.footer')
                    </div>

                    <!-- Default Active Tab -->
                    <div class="tab-pane fade show active" id="default">
                        @include('auth.passwords.email')
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
<!-- Include Flatpickr JS from cdnjs -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/flatpickr/4.6.6/flatpickr.min.js"></script>
<!-- bootstrap script -->
<script src="/src/public/assets/js/bootstrap.min.js"></script>

<!-- Your script to initialize Flatpickr -->
<script>

document.addEventListener('DOMContentLoaded', function () {
    // Set the first tab as active when the page loads
    const firstNavItem = document.querySelector('.tab-item-link');
    const firstTabContent = document.querySelector(firstNavItem.getAttribute('href'));
    const tabContentTitle = document.getElementById('tabContentTitle');

    // Activate the first nav item and tab content
    if (firstNavItem && firstTabContent) {
        firstNavItem.classList.add('active');
        firstTabContent.classList.add('show', 'active');
        tabContentTitle.textContent = firstNavItem.getAttribute('data-title');
    }

    // Handle click events for each tab item
    document.querySelectorAll('.tab-item-link').forEach(function (navItem) {
        navItem.addEventListener('click', function (event) {
            event.preventDefault();

            // Update the tabContentTitle based on clicked item
            const newTitle = navItem.getAttribute('data-title');
            tabContentTitle.textContent = newTitle;

            // Handle the active class for navigation
            document.querySelectorAll('.tab-item-link').forEach(function (item) {
                item.classList.remove('active');
            });
            navItem.classList.add('active');

            // Handle tab content visibility
            document.querySelectorAll('.tab-pane').forEach(function (pane) {
                pane.classList.remove('show', 'active');
            });
            const targetTab = document.querySelector(navItem.getAttribute('href'));
            targetTab.classList.add('show', 'active');
        });
    });
});

</script>

