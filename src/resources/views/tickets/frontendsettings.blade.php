<!-- resources/views/layouts/vertical-tabs.blade.php -->
@extends('layouts.crm') <!-- Adjust to your base layout -->

@section('contents')
<div class="container-fluid mt-4">
    <div class="row no-gutters">
        <!-- Tab Menu -->
        <div class="col-md-3 pr-md-3 tab-menu">
            <div class="card card-with-shadow border-0">
                <div class="header-icon">
                    <div class="icon-position d-flex justify-content-center">
                        <div class="tab-icon d-flex justify-content-center align-items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-settings">
                                <circle cx="12" cy="12" r="3"></circle>
                                <path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1 0 2.83 2 2 0 0 1-2.83 0l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-2 2 2 2 0 0 1-2-2v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83 0 2 2 0 0 1 0-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1-2-2 2 2 0 0 1 2-2h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 0-2.83 2 2 0 0 1 2.83 0l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 2-2 2 2 0 0 1 2 2v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 0 2 2 0 0 1 0 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 2 2 2 2 0 0 1-2 2h-.09a1.65 1.65 0 0 0-1.51 1z"></path>
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Vertical Navigation -->
                <div class="px-primary py-primary">
                    <div role="tablist" aria-orientation="vertical" class="nav flex-column nav-pills">
                            <a id="logo-tab" data-toggle="pill" href="#logoIcon" class="tab-item-link d-flex justify-content-between my-2">
                                <span>{{ __('theme.logo_icon') }}</span>
                                <span class="active-icon"><i class="feather feather-chevron-right"></i></span>
                            </a>
                  
                            <a id="social-tab" data-toggle="pill" href="#socialLink" class="tab-item-link d-flex justify-content-between my-2">
                                <span>{{ __('theme.social_link') }}</span>
                                <span class="active-icon"><i class="feather feather-chevron-right"></i></span>
                            </a>
                  
                            <a id="banner-tab" data-toggle="pill" href="#bannerText" class="tab-item-link d-flex justify-content-between my-2">
                                <span>{{ __('theme.banner_text') }}</span>
                                <span class="active-icon"><i class="feather feather-chevron-right"></i></span>
                            </a>
                   
                            <a id="work-tab" data-toggle="pill" href="#howWeWork" class="tab-item-link d-flex justify-content-between my-2">
                                <span>{{ __('theme.how_we_work') }}</span>
                                <span class="active-icon"><i class="feather feather-chevron-right"></i></span>
                            </a>
                            <a id="work-tab" data-toggle="pill" href="#service_setting" class="tab-item-link d-flex justify-content-between my-2">
                                <span>{{ __('theme.service_setting') }}</span>
                                <span class="active-icon"><i class="feather feather-chevron-right"></i></span>
                            </a>   
                            
                            <a id="work-tab" data-toggle="pill" href="#counter_setting" class="tab-item-link d-flex justify-content-between my-2">
                                <span>{{ __('theme.counter_setting') }}</span>
                                <span class="active-icon"><i class="feather feather-chevron-right"></i></span>
                            </a>  
                            
                            <a id="work-tab" data-toggle="pill" href="#testimonial" class="tab-item-link d-flex justify-content-between my-2">
                                <span>{{ __('theme.testimonial') }}</span>
                                <span class="active-icon"><i class="feather feather-chevron-right"></i></span>
                            </a> 
                            
                            <a id="work-tab" data-toggle="pill" href="#about_us" class="tab-item-link d-flex justify-content-between my-2">
                                <span>{{ __('theme.about_us') }}</span>
                                <span class="active-icon"><i class="feather feather-chevron-right"></i></span>
                            </a>  
                            
                            <a id="work-tab" data-toggle="pill" href="#footer" class="tab-item-link d-flex justify-content-between my-2">
                                <span>{{ __('theme.footer') }}</span>
                                <span class="active-icon"><i class="feather feather-chevron-right"></i></span>
                            </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tab Content -->
        <div class="col-md-9 pl-md-3 pt-md-0 pt-sm-4 pt-4">
            <div class="card card-with-shadow border-0">
                <div class="tab-content px-primary">
                    <!-- Logo Icon Tab -->
                    <div id="logoIcon" class="tab-pane fade">
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
                      <!-- How We Work Tab -->
                      <div id="service_setting" class="tab-pane fade">
                      @include('frontendSetting.service')
                      </div>  <!-- How We Work Tab -->
                    <div id="counter_setting" class="tab-pane fade">
                    @include('frontendSetting.counter')
                    </div>  <!-- How We Work Tab -->
                    <div id="testimonial" class="tab-pane fade">
                    @include('frontendSetting.testimonial')
                    </div>  <!-- How We Work Tab -->
                    <div id="about_us" class="tab-pane fade">
                    @include('frontendSetting.aboutus')
                    </div>  <!-- How We Work Tab -->
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

<!-- Your script to initialize Flatpickr -->
<script>

    document.addEventListener('DOMContentLoaded', function() {
        // Initialize Flatpickr on the date input fields
        flatpickr("#proposal_date, #start_date, #due_date, #end_date", {
            dateFormat: "Y-m-d",
            disableMobile: true // optional: to force the desktop version on mobile devices
        });

        document.querySelectorAll('.edit-project-btn').forEach(function(button) {
            button.addEventListener('click', function() {
                var projectId = this.getAttribute('data-id');
                var url = "{{ route('logoIcon.Setting')}}";

                // AJAX request to fetch project details
                fetch(url, {
                    method: 'GET',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest' // Ensure the request is identified as AJAX
                    }
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then(data => {
                    console.log('Fetched data:', data); // Log the fetched data
                });
            });
          });  

        });

</script>


