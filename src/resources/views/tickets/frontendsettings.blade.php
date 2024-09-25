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
                    <a id="logo-tab" data-toggle="pill" href="#logoIcon" data-title="{{ __('theme.logo_icon') }}" 
                            data-url="{{ route('logoIcon.Setting') }}" class="tab-item-link d-flex justify-content-between my-sm-3 active">
                                <span>{{ __('theme.logo_icon') }}</span>
                                <span class="active-icon"><i class="feather fa fa-chevron-right"></i></span>
                            </a>
                            <a id="social-tab" data-toggle="pill" href="#socialLink" data-title="{{ __('theme.social_link') }}" 
                            data-url="{{ route('social.Setting') }}" class="tab-item-link d-flex justify-content-between my-sm-3">
                                <span>{{ __('theme.social_link') }}</span>
                                <span class="active-icon"><i class="feather fa fa-chevron-right"></i></span>
                            </a>


                        <a id="banner-tab" data-toggle="pill" href="#bannerText" data-title="{{ __('theme.banner_text') }}" data-url="{{ route('headerTextSetting') }}"  class="tab-item-link d-flex justify-content-between my-sm-3">
                                <span>{{ __('theme.banner_text') }}</span>
                                <span class="active-icon"><i class="feather fa fa-chevron-right"></i></span>
                            </a>
                   
                            <a id="work-tab" data-toggle="pill" href="#howWeWork" data-title="{{ __('theme.how_we_work') }}" data-url="{{ route('how-we-work.index') }}"  class="tab-item-link d-flex justify-content-between my-sm-3">
                                <span>{{ __('theme.how_we_work') }}</span>
                                <span class="active-icon"><i class="feather fa fa-chevron-right"></i></span>
                            </a>
                            <a id="service-tab" data-toggle="pill" href="#service_setting" data-title="{{ __('theme.service_setting') }}"  data-url="{{ route('service.index') }}"  class="tab-item-link d-flex justify-content-between my-sm-3">
                                <span>{{ __('theme.service_setting') }}</span>
                                <span class="active-icon"><i class="feather fa fa-chevron-right"></i></span>
                            </a>   
                            
                            <a id="counter-tab" data-toggle="pill" href="#counter_setting" data-title="{{ __('theme.counter_setting') }}"  data-url="{{ route('counter.Setting') }}"  class="tab-item-link d-flex justify-content-between my-sm-3">
                                <span>{{ __('theme.counter_setting') }}</span>
                                <span class="active-icon"><i class="feather fa fa-chevron-right"></i></span>
                            </a>  
                            
                            <a id="testimonial-tab" data-toggle="pill" href="#testimonial" data-title="{{ __('theme.testimonial') }}"  data-url="{{ route('testimonial.index') }}"  class="tab-item-link d-flex justify-content-between my-sm-3">
                                <span>{{ __('theme.testimonial') }}</span>
                                <span class="active-icon"><i class="feather fa fa-chevron-right"></i></span>
                            </a> 
                            
                            <a id="about-us-tab" data-toggle="pill" href="#about_us" data-title="{{ __('theme.about_us') }}" data-url="{{ route('aboutus.Setting') }}"   class="tab-item-link d-flex justify-content-between my-sm-3">
                                <span>{{ __('theme.about_us') }}</span>
                                <span class="active-icon"><i class="feather fa fa-chevron-right"></i></span>
                            </a>  
                            
                            <a id="footer-tab" data-toggle="pill" href="#footer" data-title="{{ __('theme.footer') }}" data-url="{{ route('footer.Setting') }}" class="tab-item-link d-flex justify-content-between my-sm-3">
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
                        <div> 
                        <a href="javascript:void(0);" class="btn btn-primary mt-4 add-button" data-tab="#socialLink" data-toggle="modal" data-target="#addNewSocial">
                            {{ __('theme.add_new') }}
                        </a>
                        <a href="javascript:void(0);" class="btn btn-primary mt-4 add-button" data-tab="#service_setting" data-toggle="modal" data-target="#addNewService">
                            {{ __('theme.add_new') }}
                        </a>
                        <a href="javascript:void(0);" class="btn btn-primary mt-4 add-button" data-tab="#testimonial" data-toggle="modal" data-target="#addNewTestimonial">
                            {{ __('theme.add_new') }}
                        </a>

                        </div>
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
                    @include('frontendSetting.headerText')
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
<script>
document.addEventListener('DOMContentLoaded', function () {
    const tabContentTitle = document.getElementById('tabContentTitle');

    // Set the first tab as active by default
    const firstNavItem = document.querySelector('.tab-item-link');
    
    if (firstNavItem) {
        const firstTabContent = document.querySelector(firstNavItem.getAttribute('href'));

        // Ensure the first tab and content are activated
        firstNavItem.classList.add('active');
        firstTabContent.classList.add('show', 'active');
        tabContentTitle.textContent = firstNavItem.getAttribute('data-title');
    }

            // Handle click events for each tab item
        document.querySelectorAll('.tab-item-link').forEach(function (navItem) {
            navItem.addEventListener('click', function (event) {
                event.preventDefault();

                // Remove active state from all tabs and contents
                document.querySelectorAll('.tab-item-link').forEach(item => item.classList.remove('active'));
                document.querySelectorAll('.tab-pane').forEach(pane => pane.classList.remove('show', 'active'));

                // Update the title
                const newTitle = navItem.getAttribute('data-title');
                tabContentTitle.textContent = newTitle;

                // Activate clicked tab
                navItem.classList.add('active');

                // Fetch the content via AJAX
                const url = navItem.getAttribute('data-url');
                if (url) {
                    fetchTabContent(url, navItem.getAttribute('href')); // Fetch new content
                } else {
                    const targetTab = document.querySelector(navItem.getAttribute('href'));
                    if (targetTab) {
                        targetTab.classList.add('show', 'active');
                    }
                }

                // Show or hide the add buttons based on active tab
                            document.querySelectorAll('.add-button').forEach(function (button) {
                                const buttonTab = button.getAttribute('data-tab');
                                button.style.display = (navItem.getAttribute('href') === buttonTab) ? 'inline-block' : 'none';
                            });
                        });
                    });

            // Fetch tab content via AJAX
            function fetchTabContent(url, targetTabId) {

                console.log(url);
                    fetch(url)
                        .then(response => response.json())
                        .then(data => {


                            const lastSegment = url.split('/').pop();
                            console.log(lastSegment);

                            const targetTab = document.querySelector(targetTabId);
                            console.log("Response Data:", data);  // Log the full response data

                            if (targetTab) {
                                targetTab.classList.add('show', 'active');  // Make tab content visible
                            }

                            if(lastSegment == 'logo-icon'){
                            // Handle logo and favicon
                            if (data.logo) {
                                document.getElementById('logoPreview').src = '{{ asset('storage/') }}/' + data.logo;
                            }

                            if (data.favicon_icon) {
                                document.getElementById('faviconPreview').src = '{{ asset('storage/') }}/' + data.favicon_icon;
                            }
                        }
                        if(lastSegment == 'social-link'){
                            // Check if socialList exists and is an array
                            if (Array.isArray(data.socialList)) {
                                populateSocialLinks(data.socialList);
                            } else {
                                console.error('socialList is not an array or is undefined', data.socialList);
                            }
                        }
                        if(lastSegment == 'header-text'){
                            // Safely access header title and subtitle
                            const form = document.getElementById('hearderform');
                            
                            form.action = `{{ url('headerTextUpSetting') }}/${data.setting.id}`; 
                            const setting = data.setting || {};
                            document.querySelector('input[name="header_title"]').value = setting.header_title || '';
                            document.querySelector('input[name="header_subtitle"]').value = setting.header_subtitle || '';

                        }
                        if(lastSegment == 'how-we-work'){
                            // Populate how it works data if it exists
                            const worksData = data.works.data; // Array of work items

                            const settingData = data.setting;

                            if (Array.isArray(worksData) && typeof settingData === 'object' && settingData !== null) {
                           populateHowWorkData(worksData, settingData);
                            } else {
                                console.error('howWorkData is not an array or is undefined', worksData);
                            }
                        }
                        if (lastSegment === 'service') {
                            // Populate how it works data if it exists
                            const servicesData = data.services.data; // Array of service items
                            const settingData = data.setting;

                            if (Array.isArray(servicesData) && typeof settingData === 'object' && settingData !== null) {
                                populateServiceData(servicesData, settingData);
                            } else {
                                console.error('servicesData is not an array or is undefined', servicesData);
                            }
                        }
                        if(lastSegment == 'counter'){
                            const CounterData = data.setting;


                            if (typeof CounterData === 'object' && CounterData !== null) {
                                populateCounterData(CounterData);
                            } else {
                                console.error('CounterData is not an array or is undefined', CounterData);
                            }
                        }
                        if(lastSegment == 'testimonial'){

                                 // Populate how it testimonials  if it exists
                                const testimonialsData = data.testimonials.data; // Array of service items
                                const settingData = data.setting;

                                    if (Array.isArray(testimonialsData) && typeof settingData === 'object' && settingData !== null) {
                                        populateTestimonials(testimonialsData, settingData);
                                    } else {
                                        console.error('testimonialsData is not an array or is undefined', AboutUsData);
                                    }
                                }

                        if(lastSegment == 'aboutus'){

                            const AboutUsData = data.setting;

                            if (typeof AboutUsData === 'object' && AboutUsData !== null) {
                                populateAboutUsData(AboutUsData);
                            } else {
                                console.error('AboutUsData is not an array or is undefined', AboutUsData);
                            }
                        }

                        if (lastSegment == 'footer-setting') {
                            const FooterData = data.settings;

                            if (FooterData && typeof FooterData === 'object') {
                                populateFooterData(FooterData);
                            } else {
                                console.error('FooterData is not an object or is undefined', FooterData);
                            }
                        }
                        })
                        .catch(error => {
                            console.error('Error fetching content:', error);
                            // Handle error, e.g., display a message in the target tab
                        });
                }


            // Function to populate social links
            function populateSocialLinks(socialList) {
                const tableBody = document.querySelector('#tablesocialLink tbody');
                tableBody.innerHTML = '';  // Clear existing content

                socialList.forEach((socialLink, index) => {
                    const row = `
                        <tr>
                            <td>${index + 1}</td>
                            <td>${socialLink.name}</td>
                            <td><i class="${socialLink.code}"></i></td>
                            <td><a href="${socialLink.link}" target="_blank">${socialLink.link}</a></td>
                            <td>
                                <button class="btn btn-primary" onclick="editSocial(${socialLink.id})">{{ __('theme.edit') }}</button>
                                <button class="btn btn-danger" onclick="deleteSocial(${socialLink.id})">{{ __('theme.delete') }}</button>
                            </td>
                        </tr>
                    `;
                    tableBody.innerHTML += row;
                });
            }

            // Function to populate how it works data
            function populateHowWorkData(worksData, settingData) {
                console.log(settingData);

                const howWorkTitleInput = document.querySelector('input[name="how_work_title"]');
                const howWorkDetailsInput = document.querySelector('textarea[name="how_work_details"]'); // Changed to textarea

                if (howWorkTitleInput) {
                    howWorkTitleInput.value = settingData.how_work_title || '';
                }

                if (howWorkDetailsInput) {
                    howWorkDetailsInput.value = settingData.how_work_details || '';
                }


                const howWorkTableBody = document.querySelector('#testimonialTable tbody');
                howWorkTableBody.innerHTML = '';  // Clear existing content

                // Use worksData instead of howWorkData
                worksData.forEach((workItem, index) => {
                    const row = `
                        <tr>
                            <td>${index + 1}</td>
                            <td>${workItem.title}</td>
                            <td><i class="${workItem.icon}"></i></td>
                            <td>${workItem.details}</td>
                            <td>
                                <button class="btn btn-primary" onclick="editWork(${workItem.id})">
                                <i class="fas fa-edit"></i>
                                </button>
                                <button class="btn btn-danger" onclick="deleteWork(${workItem.id})">
                                <i class="fas fa-trash"></i>
                                </button>
                            </td>
                        </tr>
                    `;
                    howWorkTableBody.innerHTML += row;
                });
            }

            function populateServiceData(servicesData, settingData)
            {

                const ServiceTitleInput = document.querySelector('input[name="service_title"]');
                const ServiceDetailsInput = document.querySelector('textarea[name="service_details"]'); // Changed to textarea


                console.log('How Work Title Input:', ServiceTitleInput);
                console.log('How Work Details Input:', ServiceDetailsInput);

                if (ServiceTitleInput) {
                    ServiceTitleInput.value = settingData.service_title || '';
                }

                if (ServiceDetailsInput) {
                    ServiceDetailsInput.value = settingData.service_details || '';
                }


                // Use worksData 
                const ServicesTableBody = document.querySelector('#testimonialTableServices tbody');
                ServicesTableBody.innerHTML = '';  // Clear existing content

                servicesData.forEach((serviceItem, index) => {
                    const row = `
                        <tr>
                            <td>${index + 1}</td>
                            <td>${serviceItem.title}</td>
                            <td><i class="${serviceItem.icon}"></i></td>
                            <td>${serviceItem.details}</td>
                            <td>
                                <button class="btn btn-primary" onclick="editService(${serviceItem.id})">
                                <i class="fas fa-edit"></i>
                                </button>
                                
                                <button class="btn btn-danger" onclick="deleteService(${serviceItem.id})">
                                <i class="fas fa-trash"></i>
                                </button>
                            </td>
                        </tr>
                    `;
                    ServicesTableBody.innerHTML += row; // Append the new row to the table body
                });

            }


            //populate testimonials data 

            function populateTestimonials(testimonialsData, settingData) {
                console.log(settingData);

                const testimonialTitleInput = document.querySelector('input[name="testimonial_title"]');
                const testimonialDetailsInput = document.querySelector('textarea[name="testimonial_details"]'); // Changed to textarea

                console.log('How Work Title Input:', testimonialTitleInput);
                console.log('How Work Details Input:', testimonialDetailsInput);

                if (testimonialTitleInput) {
                    testimonialTitleInput.value = settingData.testimonial_title || '';
                }

                if (testimonialDetailsInput) {
                    testimonialDetailsInput.value = settingData.testimonial_details || '';
                }


                const TestimonialsTableBody = document.querySelector('#testimonialsTable tbody');
                TestimonialsTableBody.innerHTML = '';  // Clear existing content

                // Use worksData instead of howWorkData
                testimonialsData.forEach((testimonialItem, index) => {
                    const row = `
                        <tr>
                            <td>${index + 1}</td>
                            <td>${testimonialItem.name}</td>
                            <td><i class="${testimonialItem.image}"></i></td>
                            <td>${testimonialItem.comment}</td>
                            <td>${testimonialItem.designation}</td>

                            <td>
                                <button class="btn btn-primary" onclick="editWork(${testimonialItem.id})">
                                <i class="fas fa-edit"></i>
                                </button>
                                <button class="btn btn-danger" onclick="deleteWork(${testimonialItem.id})">
                                <i class="fas fa-trash"></i>
                                </button>
                            </td>
                        </tr>
                    `;
                    TestimonialsTableBody.innerHTML += row;
                });
            }
            function populateCounterData(counterData)
            {


                const form = document.getElementById('counterForm');
                
                form.action = `{{ url('updateCounter.Setting') }}/${data.setting.id}`; 

                const ticket_counter = document.querySelector('input[name="ticket_counter"]');
                const ticket_solved = document.querySelector('input[name="ticket_solved"]'); // Changed to textarea
                const kb_counter = document.querySelector('input[name="kb_counter"]'); // Changed to textarea
                const client_counter = document.querySelector('input[name="client_counter"]'); // Changed to textarea

                if (ticket_counter) {
                    ticket_counter.value = counterData.ticket_counter || '';
                }

                if (ticket_solved) {
                    ticket_solved.value = counterData.ticket_solved || '';
                }
                if (kb_counter) {
                    kb_counter.value = counterData.kb_counter || '';
                } if (client_counter) {
                    client_counter.value = counterData.client_counter || '';
                }

            }

            //populate about us link 
            function populateAboutUsData(aboutUsData) {
                const aboutus_title = document.querySelector('input[name="aboutus_title"]');
                const aboutus_details = document.querySelector('textarea[name="aboutus_details"]');
                const aboutus_image = document.getElementById('aboutus_image'); // For the file input, you won't set value directly
                const imageDisplay = document.querySelector('.thumbnail'); // Selector for the image display

                if (aboutus_title) {
                    aboutus_title.value = aboutUsData.aboutus_title || ''; // Use correct property name
                }

                if (aboutus_details) {
                    aboutus_details.value = aboutUsData.aboutus_details || ''; // Use correct property name
                }

                if (aboutus_image && aboutUsData.aboutus_image) {
                 
                    // show the image if a URL is provided.
                    imageDisplay.src = aboutUsData.aboutus_image || ''; // Adjust the image source
                } 
            }

            function populateFooterData(footerData) {

                console.log(footerData);

                    const footer_text = document.querySelector('input[name="footer_text"]');
                    const contact_title = document.querySelector('input[name="contact_title"]'); 
                    const contact_address = document.querySelector('input[name="contact_address"]'); 
                    const contact_phone = document.querySelector('input[name="contact_phone"]'); 
                    const contact_email = document.querySelector('input[name="contact_email"]');
                    const idField = document.querySelector('input[name="id"]');

                    console.log(idField);
                    if (footer_text) {
                        footer_text.value = footerData.footer_text || '';
                    }

                    if (contact_title) {
                        contact_title.value = footerData.contact_title || '';
                    }
                    if (contact_address) {
                        contact_address.value = footerData.contact_address || '';
                    } 
                    if (contact_phone) {
                        contact_phone.value = footerData.contact_phone || '';
                    }
                    if (contact_email) {
                        contact_email.value = footerData.contact_email || '';
                    }

                    // Populate the id field
                    if (idField) {
                        idField.value = footerData.id || '';  // Assuming footerData has the `id` field
                    }

                    console.log(idField.value);
                }




                function submitForm(event, form) {
                    event.preventDefault(); // Prevent default form submission

                    const formData = new FormData(form);

                    // Log the form data before submission
                    console.log('FormData before submission:');
                    formData.forEach((value, key) => {
                        console.log(key + ': ' + value);
                    });

                    // Ensure the id is correctly captured from the form
                    console.log('Captured id:', form.querySelector('input[name="id"]').value);

                    // Proceed with the request if formData looks correct
                    const options = {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value // Include CSRF token
                        }
                    };

                    fetch(form.action, options)
                        .then(response => {
                            if (!response.ok) {
                                throw new Error('Network response was not ok ' + response.statusText);
                            }
                            return response.json(); // Assuming the response is JSON
                        })
                        .then(data => {
                            console.log('Success:', data);
                            alert('Settings updated successfully!');
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            alert('There was an error updating the settings.');
                        });
                }


    function previewImage(event, previewId) {
    const reader = new FileReader();
    reader.onload = function(){
        const output = document.getElementById(previewId);
        output.src = reader.result;
    };
    reader.readAsDataURL(event.target.files[0]);
}

});



</script>

