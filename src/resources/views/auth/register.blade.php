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
                <form method="POST" action="{{ route('register') }}">
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


                    <!-- First Name and Last Name Fields -->
                    <div class="row applicant-fields">
                        <div class="col-md-6">
                            <input type="text" id="first-name" class=" second form-control {{ $errors->has('first_name') ? ' is-invalid' : '' }}" name="first_name" value="{{ old('first_name') }}" placeholder="{{ __('theme.first_name') }}">
                            @if ($errors->has('first_name'))
                            <div class="invalid-feedback d-flex">
                                <strong>{{ $errors->first('first_name') }}</strong>
                            </div>
                            @endif
                        </div>
                        <div class="col-md-6">
                            <input type="text" id="last-name" class=" second form-control {{ $errors->has('last_name') ? ' is-invalid' : '' }}" name="last_name" value="{{ old('last_name') }}" placeholder="{{ __('theme.last_name') }}">
                            @if ($errors->has('last_name'))
                            <div class="invalid-feedback d-flex">
                                <strong>{{ $errors->first('last_name') }}</strong>
                            </div>
                            @endif
                        </div>
                    </div>

                    <!-- Type of Company and Industry Sector -->
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
                    <!-- Date of Establishment and Business Registration Number -->
                    <div class="row smart-partner-fields" style="display:none;">
                        <div class="col-md-12">
                            <input type="text" id="business_registration_number" name="business_registration_number" class=" second form-control {{ $errors->has('business_registration_number') ? ' is-invalid' : '' }}" value="{{ old('business_registration_number') }}" placeholder="{{ __('theme.business_registration_number') }}">
                            @if ($errors->has('business_registration_number'))
                            <div class="invalid-feedback d-flex">
                                <strong>{{ $errors->first('business_registration_number') }}</strong>
                            </div>
                            @endif
                        </div>
                    </div>

                    <!-- Business Address and Website URL -->
                    <div class="row smart-partner-fields" style="display:none;">
                        <div class="col-md-6">
                            <input type="text" id="business_address" name="business_address" class=" second form-control {{ $errors->has('business_address') ? ' is-invalid' : '' }}" value="{{ old('business_address') }}" placeholder="{{ __('theme.business_address') }}">
                            @if ($errors->has('business_address'))
                            <div class="invalid-feedback d-flex">
                                <strong>{{ $errors->first('business_address') }}</strong>
                            </div>
                            @endif
                        </div>
                        <div class="col-md-6 mt-1">
                            <input type="url" id="website_url" name="website_url" class=" second form-control {{ $errors->has('website_url') ? ' is-invalid' : '' }}" value="{{ old('website_url') }}" placeholder="{{ __('theme.website_url') }}">
                            @if ($errors->has('website_url'))
                            <div class="invalid-feedback d-flex">
                                <strong>{{ $errors->first('website_url') }}</strong>
                            </div>
                            @endif
                        </div>
                    </div>

                    <!--   Areas of Expertise and  Description of Services -->
                    <div class="row smart-partner-fields mt-2" style="display:none;">
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
                    <div class="col-md-6">
                            <textarea id="description_of_services" name="description_of_services" class=" second form-control {{ $errors->has('description_of_services') ? ' is-invalid' : '' }}" placeholder="{{ __('theme.description_of_services') }}">{{ old('description_of_services') }}</textarea>
                            @if ($errors->has('description_of_services'))
                            <div class="invalid-feedback d-flex">
                                <strong>{{ $errors->first('description_of_services') }}</strong>
                            </div>
                            @endif
                        </div>
                    </div>

                    <!-- Email Field -->
                    <div class="row">
                        <div class="col-md-6">
                            <input type="email" id="login" class=" third form-control {{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" placeholder="{{ __('theme.email') }}" required autocomplete="Username">
                            @if ($errors->has('email'))
                            <div class="invalid-feedback d-flex">
                                <strong>{{ $errors->first('email') }}</strong>
                            </div>
                            @endif
                        </div>
                    <!-- Cellphone No. Field (Visible for All) -->
                        <div class="col-md-6">
                            <input type="text" id="cell-no" class="form-control {{ $errors->has('cell_no') ? ' is-invalid' : '' }}" name="cell_no" value="{{ old('cell_no') }}" placeholder="{{ __('theme.cell_no') }}" required>
                            @if ($errors->has('cell_no'))
                            <div class="invalid-feedback d-flex">
                                <strong>{{ $errors->first('cell_no') }}</strong>
                            </div>
                            @endif
                        </div>  
                    </div>

                     <!-- ID Number (Visible for All) -->
                     <div class="row">
                        <div class="col-md-12">
                            <input type="text" id="id-no" class=" second form-control {{ $errors->has('id_no') ? ' is-invalid' : '' }}" name="id_no" value="{{ old('id_no') }}" placeholder="{{ __('theme.id_no') }}" required>
                            @if ($errors->has('id_no'))
                            <div class="invalid-feedback d-flex">
                                <strong>{{ $errors->first('id_no') }}</strong>
                            </div>
                            @endif
                        </div>
                    </div>

                    <!-- CWP No. Field (Only for CWP Candidates) -->
                    <div class="row cwp-field" style="display:none;">
                        <div class="col-md-12">
                        <input type="text" id="cwp-no" class=" second form-control {{ $errors->has('cwp_no') ? ' is-invalid' : '' }}" name="cwp_no" value="{{ old('cwp_no') }}" placeholder="{{ __('theme.cwp_no') }}">
                        @if ($errors->has('cwp_no'))
                        <div class="invalid-feedback d-flex">
                            <strong>{{ $errors->first('cwp_no') }}</strong>
                        </div>
                        @endif
                        </div>
                    </div>

                    

                    <div class="form-group smart-partner-fields" style="display:none;">
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

<!-- Submit Button -->
<div class="form-group mt-4">
    <input type="submit" class="btn btn-primary" value="Sign Up">
</div>



                <!-- Remind Password -->
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
    // Determine which registration type is selected
    const isCWPCandidate = document.getElementById('cwp_candidate').checked;
    const isSmartPartner = document.getElementById('smart_partner').checked;

    // Toggle fields for CWP Candidate and New Applicant (show first name and last name)
    document.querySelectorAll('.applicant-fields').forEach(function (field) {
        field.style.display = (!isSmartPartner) ? 'flex' : 'none'; // Show for New Applicant and CWP Candidate, hide for Smart Partner
    });

    // Toggle fields for CWP Candidate
    document.querySelectorAll('.cwp-field').forEach(function (field) {
        field.style.display = isCWPCandidate ? 'flex' : 'none';
    });

    // Toggle fields for Smart Partner
    document.querySelectorAll('.smart-partner-fields').forEach(function (field) {
        field.style.display = isSmartPartner ? 'flex' : 'none';
    });

     // Manage ID No field visibility and required attribute
    const idField = document.getElementById('id-no');
    if (isSmartPartner) {
        idField.style.display = 'none';
        idField.removeAttribute('required'); // Remove required attribute for Smart Partner
    } else {
        idField.style.display = 'flex';
        idField.setAttribute('required', 'required'); // Add required attribute for other types
    }
}
    // Call toggleFormFields() on page load to ensure proper initialization
    document.addEventListener('DOMContentLoaded', function () {
        toggleFormFields();
    });


    function toggleContactPersonFields() {
    const contactPersonFields = document.getElementById('contactPersonFields');
    
        if (contactPersonFields.style.display === 'none' || contactPersonFields.style.display === '') {
            contactPersonFields.style.display = 'flex';
        } else {
            contactPersonFields.style.display = 'none';
        }
    }

    // Form validation before submission
    document.querySelector('form').addEventListener('submit', function(e) {
        const isSmartPartner = document.getElementById('smart_partner').checked;
        const contactPersonFields = document.getElementById('contactPersonFields');
        
        // If Smart Partner is selected and contact person fields are shown
        if (isSmartPartner && contactPersonFields.style.display === 'flex') {
            // Validate that contact person fields are filled
            const contactFirstName = document.getElementById('contact_first_name').value;
            const contactLastName = document.getElementById('contact_last_name').value;
            const contactCellNo = document.getElementById('contact_cell_no').value;
            const contactEmail = document.getElementById('contact_email').value;
            const contactPassword = document.getElementById('contact_password').value;
            const contactConfirmPassword = document.getElementById('contact_confirm_password').value;

            if (!contactFirstName || !contactLastName || !contactCellNo || !contactEmail || !contactPassword || !contactConfirmPassword) {
                e.preventDefault(); // Prevent form submission
                alert('Please fill out all contact person fields.');
            } else if (contactPassword !== contactConfirmPassword) {
                e.preventDefault(); // Prevent form submission
                alert('Passwords do not match.');
            }
        }
    });
    // Listen for the modal show event
        $('.modal').on('show.bs.modal', function (e) {
            // Hide all other open modals
            $('.modal').not($(this)).modal('hide');
        });

</script>
@endsection



