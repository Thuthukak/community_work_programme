@extends('layouts.master')
@section('title', __('theme.register'))

@section('style')
<link rel="stylesheet" type="text/css" media="screen" href="{{ asset($publicPath.'/css/auth.css') }}">
<style>
    /* Custom styles to adjust form width */
    #formContent {
        width: calc(100% + 100px); /* Increase width by 100px */
        max-width: 800px; /* Set a max-width for better responsiveness */
        margin: auto;
        padding: 20px;
    }
    .form-group {
        margin-bottom: 15px; /* Add margin for spacing */
    }
</style>
@endsection

@section('content')
<!-- particles.js container -->
<div id="particles-js"></div>

<!-- register container -->
<div class="background-image pt-5 pb-4rem">
    <div class="container">
        <div class="wrapper fadeInDown">
            <div id="formContent">
                <!-- Tabs Titles -->
                <!-- Icon -->
                <div class="fadeIn first py-3">
                    <h5>{{ __('theme.register') }}</h5>
                </div>

                <!-- Registration Form -->
                <form method="POST" action="{{ route('register') }}">
                    @csrf

                    <!-- Registration Type Selection -->
                    <div class="fadeIn second py-2">
                        <input type="radio" id="new_applicant" name="registration_type" value="new_applicant" onclick="toggleFormFields()" checked required>
                        <label for="new_applicant">New Applicant</label>

                        <input type="radio" id="cwp_candidate" name="registration_type" value="cwp_candidate" onclick="toggleFormFields()">
                        <label for="cwp_candidate">CWP Candidate</label>

                        <input type="radio" id="smart_partner" name="registration_type" value="smart_partner" onclick="toggleFormFields()">
                        <label for="smart_partner">Smart Partner</label>
                    </div>

                    <!-- First Name and Last Name Fields -->
                    <div class="row applicant-fields ">
                        <div class="col-md-6">
                            <input type="text" id="first-name" class="fadeIn second form-control {{ $errors->has('first_name') ? ' is-invalid' : '' }}" name="first_name" value="{{ old('first_name') }}" placeholder="{{ __('theme.first_name') }}">
                            @if ($errors->has('first_name'))
                            <div class="invalid-feedback d-block">
                                <strong>{{ $errors->first('first_name') }}</strong>
                            </div>
                            @endif
                        </div>
                        <div class="col-md-6">
                            <input type="text" id="last-name" class="fadeIn second form-control {{ $errors->has('last_name') ? ' is-invalid' : '' }}" name="last_name" value="{{ old('last_name') }}" placeholder="{{ __('theme.last_name') }}">
                            @if ($errors->has('last_name'))
                            <div class="invalid-feedback d-block">
                                <strong>{{ $errors->first('last_name') }}</strong>
                            </div>
                            @endif
                        </div>
                    </div>

                    <!-- Company Name Field (for Smart Partners) -->
                    <div class="row smart-partner-fields" style="display:none;">
                        <div class="col-md-12">
                            <input type="text" id="company_name" class="fadeIn second form-control {{ $errors->has('company_name') ? ' is-invalid' : '' }}" name="company_name" value="{{ old('company_name') }}" placeholder="{{ __('theme.company_name') }}">
                            @if ($errors->has('company_name'))
                            <div class="invalid-feedback d-block">
                                <strong>{{ $errors->first('company_name') }}</strong>
                            </div>
                            @endif
                        </div>
                    </div>

                    <!-- Type of Company and Industry Sector -->
                    <div class="row smart-partner-fields" style="display:none;">
                        <div class="col-md-6">
                            <select id="type_of_company" name="type_of_company" class="fadeIn second form-control {{ $errors->has('type_of_company') ? ' is-invalid' : '' }}">
                                <option value="" disabled selected>{{ __('theme.select_type_of_company') }}</option>
                                <option value="pty_ltd">(Pty) Ltd</option>
                                <option value="ltd">Ltd</option>
                                <option value="npc">NPC</option>
                            </select>
                            @if ($errors->has('type_of_company'))
                            <div class="invalid-feedback d-block">
                                <strong>{{ $errors->first('type_of_company') }}</strong>
                            </div>
                            @endif
                        </div>
                        <div class="col-md-6">
                            <select id="industry_sector" name="industry_sector" class="fadeIn second form-control {{ $errors->has('industry_sector') ? ' is-invalid' : '' }}">
                                <option value="" disabled selected>{{ __('theme.select_industry_sector') }}</option>
                                <option value="it">IT</option>
                                <option value="construction">Construction</option>
                                <option value="finance">Finance</option>
                                <option value="healthcare">Healthcare</option>
                                <option value="other">Other (Please specify)</option>
                            </select>
                            @if ($errors->has('industry_sector'))
                            <div class="invalid-feedback d-block">
                                <strong>{{ $errors->first('industry_sector') }}</strong>
                            </div>
                            @endif
                        </div>
                    </div>

                    <!-- Date of Establishment and Business Registration Number -->
                    <div class="row smart-partner-fields" style="display:none;">
                        <div class="col-md-6">
                        <small id="delay-element" class="form-text text-muted hidden">{{ __('theme.date_of_establishment') }}</small>
                        <input type="date" id="date_of_establishment" name="date_of_establishment" class="fadeIn second form-control {{ $errors->has('date_of_establishment') ? ' is-invalid' : '' }}" value="{{ old('date_of_establishment') }}">
                            @if ($errors->has('date_of_establishment'))
                                <div class="invalid-feedback d-block">
                                    <strong>{{ $errors->first('date_of_establishment') }}</strong>
                                </div>
                            @endif
                        </div>
                        <div class="col-md-6">
                            <input type="text" id="business_registration_number" name="business_registration_number" class="fadeIn second form-control {{ $errors->has('business_registration_number') ? ' is-invalid' : '' }}" value="{{ old('business_registration_number') }}" placeholder="{{ __('theme.business_registration_number') }}">
                            @if ($errors->has('business_registration_number'))
                            <div class="invalid-feedback d-block">
                                <strong>{{ $errors->first('business_registration_number') }}</strong>
                            </div>
                            @endif
                        </div>
                    </div>

                    <!-- Business Address and Website URL -->
                    <div class="row smart-partner-fields" style="display:none;">
                        <div class="col-md-6">
                            <input type="text" id="business_address" name="business_address" class="fadeIn second form-control {{ $errors->has('business_address') ? ' is-invalid' : '' }}" value="{{ old('business_address') }}" placeholder="{{ __('theme.business_address') }}">
                            @if ($errors->has('business_address'))
                            <div class="invalid-feedback d-block">
                                <strong>{{ $errors->first('business_address') }}</strong>
                            </div>
                            @endif
                        </div>
                        <div class="col-md-6">
                            <input type="url" id="website_url" name="website_url" class="fadeIn second form-control {{ $errors->has('website_url') ? ' is-invalid' : '' }}" value="{{ old('website_url') }}" placeholder="{{ __('theme.website_url') }}">
                            @if ($errors->has('website_url'))
                            <div class="invalid-feedback d-block">
                                <strong>{{ $errors->first('website_url') }}</strong>
                            </div>
                            @endif
                        </div>
                    </div>

                    <!--   Areas of Expertise and  Description of Services -->
                    <div class="row smart-partner-fields" style="display:none;">
                        <div class = "col-md-6">
                        <select id="areas_of_expertise" name="areas_of_expertise[]" class="fadeIn second form-control {{ $errors->has('areas_of_expertise') ? ' is-invalid' : '' }}">
                            <option value="" disable selected> {{ __('theme.areas_of_expertise') }} </option>
                            <option value="project_management">Project Management</option>
                            <option value="software_development">Software Development</option>
                            <option value="marketing">Marketing</option>
                            <option value="logistics">Logistics</option>
                        </select>
                        @if ($errors->has('areas_of_expertise'))
                        <div class="invalid-feedback d-block">
                            <strong>{{ $errors->first('areas_of_expertise') }}</strong>
                        </div>
                        @endif
                    </div>
                    <div class="col-md-6">
                            <textarea id="description_of_services" name="description_of_services" class="fadeIn second form-control {{ $errors->has('description_of_services') ? ' is-invalid' : '' }}" placeholder="{{ __('theme.description_of_services') }}">{{ old('description_of_services') }}</textarea>
                            @if ($errors->has('description_of_services'))
                            <div class="invalid-feedback d-block">
                                <strong>{{ $errors->first('description_of_services') }}</strong>
                            </div>
                            @endif
                        </div>
                    </div>

                    <!-- ID Number (Visible for All) -->
                    <div class="form-group">
                        <input type="text" id="id-no" class="fadeIn second form-control {{ $errors->has('id_no') ? ' is-invalid' : '' }}" name="id_no" value="{{ old('id_no') }}" placeholder="{{ __('theme.id_no') }}" required>
                        @if ($errors->has('id_no'))
                        <div class="invalid-feedback d-block">
                            <strong>{{ $errors->first('id_no') }}</strong>
                        </div>
                        @endif
                    </div>

                    <!-- Cellphone No. Field (Visible for All) -->
                    <div class="form-group">
                        <input type="text" id="cell-no" class="fadeIn second form-control {{ $errors->has('cell_no') ? ' is-invalid' : '' }}" name="cell_no" value="{{ old('cell_no') }}" placeholder="{{ __('theme.cell_no') }}" required>
                        @if ($errors->has('cell_no'))
                        <div class="invalid-feedback d-block">
                            <strong>{{ $errors->first('cell_no') }}</strong>
                        </div>
                        @endif
                    </div>

                    <!-- CWP No. Field (Only for CWP Candidates) -->
                    <div class="form-group cwp-field" style="display:none;">
                        <input type="text" id="cwp-no" class="fadeIn second form-control {{ $errors->has('cwp_no') ? ' is-invalid' : '' }}" name="cwp_no" value="{{ old('cwp_no') }}" placeholder="{{ __('theme.cwp_no') }}">
                        @if ($errors->has('cwp_no'))
                        <div class="invalid-feedback d-block">
                            <strong>{{ $errors->first('cwp_no') }}</strong>
                        </div>
                        @endif
                    </div>

                    <!-- Email Field -->
                    <div class="form-group">
                        <input type="email" id="login" class="fadeIn third form-control {{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" placeholder="{{ __('theme.email') }}" required>
                        @if ($errors->has('email'))
                        <div class="invalid-feedback d-block">
                            <strong>{{ $errors->first('email') }}</strong>
                        </div>
                        @endif
                    </div>

                    <!-- Password Fields -->
                    <div class="row">
                        <div class="col-md-6">
                            <input type="password" id="password" class="fadeIn four form-control {{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" placeholder="{{ __('theme.password') }}" required>
                            @if ($errors->has('password'))
                            <div class="invalid-feedback d-block">
                                <strong>{{ $errors->first('password') }}</strong>
                            </div>
                            @endif
                        </div>
                        <div class="col-md-6">
                            <input type="password" id="confirm-password" class="fadeIn five form-control" name="password_confirmation" placeholder="{{ __('theme.confirm_password') }}" required>
                        </div>
                    </div>

                    <input type="submit" class="fadeIn fourth btn btn-primary mt-3" value="Sign Up">
                </form>

                <!-- Remind Password -->
                <div id="formFooter">
                    <div>
                        {{ __('theme.already_have_account') }}
                        <a href="{{ route('login') }}" class="bluish-text">{{ __('theme.login') }}</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
<script>
    function toggleFormFields() {
        // Determine which registration type is selected
        const isCWPCandidate = document.getElementById('cwp_candidate').checked;
        const isSmartPartner = document.getElementById('smart_partner').checked;



        // Toggle fields for CWP Candidate
        document.querySelectorAll('.cwp-field').forEach(function (field) {
            field.style.display = isCWPCandidate ? 'block' : 'none';
        });

        // Toggle fields for Smart Partner
        document.querySelectorAll('.smart-partner-fields').forEach(function (field) {
            field.style.display = isSmartPartner ? 'block' : 'none';
        });
        

        // Toggle fields for New Applicant (First Name and Last Name)
        document.querySelectorAll('.applicant-fields').forEach(function (field) {
            field.style.display = (!isSmartPartner && !isCWPCandidate) ? 'block' : 'block';
        });

        if(isSmartPartner == true){
            document.getElementById('id-no').style.display = 'none';
        }
    }

    // Call toggleFormFields() on page load to ensure proper initialization
    document.addEventListener('DOMContentLoaded', function () {
        toggleFormFields();
    });

    function showElementAfterDelay() {
            setTimeout(function() {
                document.getElementById('delay-element').classList.remove('hidden');
            }, 5000); // 2000 milliseconds = 2 seconds
        }

</script>
@endsection
