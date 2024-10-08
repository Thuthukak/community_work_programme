<div class="modal fade" id="registerModal" role="dialog" aria-labelledby="registerModalLabel" aria-hidden="true" style="z-index: 1041;" >
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="registerModalLabel">{{ __('theme.register') }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Registration Form -->
                <form id="registerForm">
                    @csrf

                    <!-- Registration Type Selection -->
                    <label class="font-weight-bold">{{ __('theme.select_application_type') }}</label>
                    <div class="mb-3">
                        <div class="form-check form-check-inline">
                            <input type="radio" id="new_applicant" name="registration_type" class="form-check-input" value="new_applicant" onclick="toggleFormFields()" checked required>
                            <label for="new_applicant" class="form-check-label">New Applicant</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input type="radio" id="cwp_candidate" name="registration_type" class="form-check-input" value="cwp_candidate" onclick="toggleFormFields()">
                            <label for="cwp_candidate" class="form-check-label">CWP Candidate</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input type="radio" id="smart_partner" name="registration_type" class="form-check-input" value="smart_partner" onclick="toggleFormFields()">
                            <label for="smart_partner" class="form-check-label">Smart Partner</label>
                        </div>
                    </div>

                    <!-- Fields for New Applicant -->
                    <div id="newApplicantFields">
                        <div class="row">
                            <div class="col-md-6">
                                <input type="text" id="first-name" class="form-control" name="first_name" value="{{ old('first_name') }}" placeholder="First Name">
                            </div>
                            <div class="col-md-6">
                                <input type="text" id="last-name" class="form-control" name="last_name" value="{{ old('last_name') }}" placeholder="Last Name">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <input type="email" id="email" class="form-control" name="email" value="{{ old('email') }}" placeholder="Email">
                            </div>
                            <div class="col-md-6">
                                <input type="text" id="cell-no" class="form-control" name="cell_no" value="{{ old('cell_no') }}" placeholder="Cell No.">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <input type="text" id="id-no" class="form-control" name="id_no" value="{{ old('id_no') }}" placeholder="ID Number">
                            </div>
                        </div>
                    </div>

                    <!-- Fields for CWP Candidate -->
                    <div id="cwpFields" style="display: none;">
                        <div class="row">
                            <div class="col-md-6">
                                <input type="email" id="cwp-email" class="form-control" name="cwp_email" value="{{ old('cwp_email') }}" placeholder="Email">
                            </div>
                            <div class="col-md-6">
                                <input type="text" id="cwp-cell-no" class="form-control" name="cwp_cell_no" value="{{ old('cwp_cell_no') }}" placeholder="Cell No.">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <input type="text" id="cwp-id-no" class="form-control" name="cwp_id_no" value="{{ old('cwp_id_no') }}" placeholder="ID Number">
                            </div>
                            <div class="col-md-6">
                                <input type="text" id="cwp-no" class="form-control" name="cwp_no" value="{{ old('cwp_no') }}" placeholder="CWP Number">
                            </div>
                        </div>
                    </div>

               <!-- Fields for Smart Partner -->
                    <div id="smartPartnerFields" style="display: none;">

                    <div class="row smart-partner-fields" >
                        <div class="col-md-6">
                            <input type="text" id="company_name" class=" second form-control {{ $errors->has('company_name') ? ' is-invalid' : '' }}" name="company_name" value="{{ old('company_name') }}" placeholder="{{ __('theme.company_name') }}">
                            @if ($errors->has('company_name'))
                            <div class="invalid-feedback d-flex">
                                <strong>{{ $errors->first('company_name') }}</strong>
                            </div>
                            @endif
                        </div>
                        <div class="col-md-6 mt-1">
                            <select id="industry_sector" name="industry_sector" class=" second form-control {{ $errors->has('industry_sector') ? ' is-invalid' : '' }}">
                                <option value="" disabled selected>{{ __('theme.select_industry_sector') }}</option>
                                <option value="it">IT</option>
                                <option value="construction">Construction</option>
                                <option value="finance">Finance</option>
                                <option value="healthcare">Healthcare</option>
                                <option value="other">Other (Please specify)</option>
                            </select>
                            @if ($errors->has('industry_sector'))
                            <div class="invalid-feedback d-flex">
                                <strong>{{ $errors->first('industry_sector') }}</strong>
                            </div>
                            @endif
                        </div>
                    </div>

                    <div class="row">
                            <div class="col-md-6">
                                <input type="text" id="business_registration_number" class="form-control" name="business_registration_number" value="{{ old('business_registration_number') }}" placeholder="Business Registration Number">
                            </div>

                            <div class = "col-md-6">
                                <select id="areas_of_expertise" name="areas_of_expertise[]" class=" second form-control {{ $errors->has('areas_of_expertise') ? ' is-invalid' : '' }}">
                                    <option value="" disable selected> {{ __('theme.select_areas_of_expertise') }} </option>
                                    <option value="project_management">Project Management</option>
                                    <option value="software_development">Software Development</option>
                                    <option value="marketing">Marketing</option>
                                    <option value="logistics">Logistics</option>
                                </select>
                                @if ($errors->has('areas_of_expertise'))
                                <div class="invalid-feedback d-flex">
                                    <strong>{{ $errors->first('areas_of_expertise') }}</strong>
                                </div>
                                @endif
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <input type="email" id="partner_email" class="form-control" name="partner_email" value="{{ old('partner_email') }}" placeholder="Partner Email">
                            </div>
                            <div class="col-md-6">
                                <input type="text" id="partner-cell-no" class="form-control" name="partner_cell_no" value="{{ old('partner_cell_no') }}" placeholder="Partner Cell No.">
                            </div>
                        </div>
   
                        <div class="row">
                            <div class="col-md-6">
                                <input type="text" id="business_address" class="form-control" name="business_address" value="{{ old('business_address') }}" placeholder="Business Address">
                            </div>
                            <div class="col-md-6">
                                <input type="url" id="website_url" class="form-control" name="website_url" value="{{ old('website_url') }}" placeholder="Website URL">
                            </div>
                        </div>


                        <hr>
                        <div class="form-group smart-partner-fields" >
                            <button type="button" class="btn btn-sm btn-secondary mt-3" id="addContactPersonBtn" onclick="toggleContactPersonFields()">
                                <i class="fa fa-plus"></i> Add Contact Person
                            </button>
                        </div>
                        <div id="contactPersonFields" class="smart-partner-fields" style="display:none;">
                                <!-- Add clearfix to separate button from fields -->
                                <div class="clearfix"></div>

                                <!-- H5 Heading should be its own block -->
                                <div class="row">
                                <h5 class=" col-md-12 mt-4">Contact Person Details</h5>
                                </div>

                                <!-- First and Last Name Row -->
                                <div class="row mt-10">
                                    <div class="col-md-10">
                                        <input type="text" id="contact_first_name" class="form-control" name="contact_first_name" placeholder="Contact First Name">
                                    </div>
                                    <div class="col-md-10">
                                        <input type="text" id="contact_last_name" class="form-control" name="contact_last_name" placeholder="Contact Last Name">
                                    </div>
                                </div>

                                <!-- Cell Number and Email Row -->
                                <div class="row">
                                    <div class="col-md-10">
                                        <input type="text" id="contact_cell_no" class="form-control" name="contact_cell_no" placeholder="Contact Cell No">
                                    </div>
                                    <div class="col-md-10">
                                        <input type="email" id="contact_email" class="form-control" name="contact_email" placeholder="Contact Email">
                                    </div>
                                </div>
                            </div>
                    </div>
                    <!-- Submit Button -->
                    <div class="form-group mt-4">
                        <input type="submit" class="btn btn-primary" value="Sign Up">
                    </div>
                    </form>
                <div id="formFooter">
                    <div>
                        {{ __('theme.already_have_account') }}
                        <a class="nav-link" href="javascript:void(0);" data-toggle="modal" data-target="#loginModal">{{ __('theme.login') }}</a>
                        </div>
                </div>
            </div>
        </div>
    </div>
</div>
@section('script')
<script>
        function toggleFormFields() {
            const isCWPCandidate = document.getElementById('cwp_candidate').checked;
            const isSmartPartner = document.getElementById('smart_partner').checked;
            
            document.getElementById('newApplicantFields').style.display = !isCWPCandidate && !isSmartPartner ? 'block' : 'none';
            document.getElementById('cwpFields').style.display = isCWPCandidate ? 'block' : 'none';
            document.getElementById('smartPartnerFields').style.display = isSmartPartner ? 'block' : 'none';
        }

        document.addEventListener('DOMContentLoaded', function() {
            toggleFormFields();
        });


        function toggleContactPersonFields(show = false) {
            const contactPersonFields = document.getElementById('contactPersonFields');
            if (show || contactPersonFields.style.display === 'none' || contactPersonFields.style.display === '') {
                contactPersonFields.style.display = 'block';
            } else {
                contactPersonFields.style.display = 'none';
            }
        }

    // Listen for the modal show event
        $('.modal').on('show.bs.modal', function (e) {
            // Hide all other open modals
            $('.modal').not($(this)).modal('hide');
        });


        function showFieldError(fieldId, errorMessage) {
                const input = document.getElementById(fieldId);
                input.classList.add('is-invalid');
                input.insertAdjacentHTML('afterend', `<div class="invalid-feedback d-flex"><strong>${errorMessage}</strong></div>`);
            }

        $(document).ready(function () {

            // Call toggleFormFields() only once on page load
            toggleFormFields();
            const originalFormContent = $('#registerModal .modal-body').html();

            // Attach the submit handler to the form
            $('#registerForm').off('submit').on('submit', function (e) {
                e.preventDefault(); // Prevent the default form submission

                // Clear previous errors
                $('.invalid-feedback').remove();
                $('.is-invalid').removeClass('is-invalid');

                // Get the registration type value
                const isCWPCandidate = document.getElementById('cwp_candidate').checked;
                const isSmartPartner = document.getElementById('smart_partner').checked;
                const partneremail = document.getElementById('partner_email').value;
                const contactEmail = document.getElementById('contact_email').value;


        
                    if (isSmartPartner) {
                        const contactFirstName = document.getElementById('contact_first_name').value.trim();
                        const contactLastName = document.getElementById('contact_last_name').value.trim();
                        const contactCellNo = document.getElementById('contact_cell_no').value.trim();
                        const contactEmail = document.getElementById('contact_email').value.trim();

                        // Check if contact person fields are filled
                        let contactPersonFieldsMissing = false;
                        if (!contactFirstName) {
                            showFieldError('contact_first_name', 'Contact First Name is required.');
                            contactPersonFieldsMissing = true;
                        }
                        if (!contactLastName) {
                            showFieldError('contact_last_name', 'Contact Last Name is required.');
                            contactPersonFieldsMissing = true;
                        }
                        if (!contactCellNo) {
                            showFieldError('contact_cell_no', 'Contact Cell Number is required.');
                            contactPersonFieldsMissing = true;
                        }
                        if (!contactEmail) {
                            showFieldError('contact_email', 'Contact Email is required.');
                            contactPersonFieldsMissing = true;
                        }

                        if (contactPersonFieldsMissing) {
                            // If contact person fields are missing, show them and display the error message
                            toggleContactPersonFields(true);
                            $('html, body').animate({
                                scrollTop: $('#contactPersonFields').offset().top
                            }, 500); // Scroll to contact person fields for visibility
                            return;
                        }
                        if (partneremail === contactEmail) {
                        // Display error if emails match
                        const contactEmailInput = document.getElementById('contact_email');
                        contactEmailInput.classList.add('is-invalid');
                        contactEmailInput.insertAdjacentHTML('afterend', 
                            `<div class="invalid-feedback d-flex">
                                <strong>The contact email should not be the same as the main email.</strong>
                            </div>`);
                        
                        // Re-enable the submit button
                        $('input[type="submit"]').prop('disabled', false);

                        return;  // Stop form submission
                    }

                    }
                // If Smart Partner is selected, check that email and contact_email are not the same
                if (isSmartPartner) {
                    if (email === contactEmail) {
                        // Display error if emails match
                        const contactEmailInput = document.getElementById('contact_email');
                        contactEmailInput.classList.add('is-invalid');
                        contactEmailInput.insertAdjacentHTML('afterend', 
                            `<div class="invalid-feedback d-flex">
                                <strong>The contact email should not be the same as the main email.</strong>
                            </div>`);
                        
                        // Re-enable the submit button
                        $('input[type="submit"]').prop('disabled', false);

                        return;  // Stop form submission
                    }
                }

                // If validation passes, perform the AJAX request
                $.ajax({
                    url: "{{ route('register') }}",  // The Laravel route for registration
                    method: 'POST',
                    data: $(this).serialize(),
                    success: function (response) {
                        // Show success message based on type of user
                        if (isCWPCandidate) {
                            $('#registerModal .modal-body').html('<p>Registration successful! An invite link has been sent to the contact email.</p>');
                        } else {
                            $('#registerModal .modal-body').html('<p>Registration successful!</p>');
                        }
                    },
                    error: function (xhr) {
                        if (xhr.status === 422) {
                            // Re-enable the submit button
                            $('input[type="submit"]').prop('disabled', false);

                            // Handle validation errors
                            const errors = xhr.responseJSON.errors;
                            for (const field in errors) {
                                const input = $(`[name="${field}"]`);
                                input.addClass('is-invalid');
                                input.after(`<div class="invalid-feedback d-flex"><strong>${errors[field][0]}</strong></div>`);
                            }

                            // Ensure the modal stays open
                            $('#registerModal').modal('show');
                        }
                    }
                });
            });

            $('#registerModal').on('hidden.bs.modal', function () {
                // Restore the original form content
                $('#registerModal .modal-body').html(originalFormContent);

                // Re-enable the submit button (in case it was disabled)
                $('input[type="submit"]').prop('disabled', false);

                // Reattach the form submit event
                $('#registerForm').off('submit').on('submit', function (e) {
                    e.preventDefault(); // Prevent default form submission

                    // Your form submission logic here...
                });
            });
            });


</script>

@endsection



