@inject('permission', 'App\Http\Controllers\PermissionController')

@extends('dashboard.master')
@section('title', __('theme.email_setting'))

@section('main-section')
<div class="container-fluid">
    @if($permission->manageEmailSetting() == 1)
    <h4 class="page-title">{{ __('theme.email_setting') }}</h4>
    <div class="card mb-4">
        <div class="card-body">
            @include('includes.flash')
            <form action="{{ route('emailSettingUpdate',$setting->id) }}" method="post">
                @csrf
                @method('PUT')
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="emailSendName">{{ __('theme.email_send_from_name') }}</label>
                            <input type="text" name="from_name" value="{{ $setting->from_name ?? old('from_name') }}" class="form-control {{ $errors->has('from_name') ? ' is-invalid' : '' }}" id="emailSendName" placeholder="{{ __('theme.enter_email_from_name') }}">
                        </div>
                        @if ($errors->has('from_name'))
                            <span class="invalid-feedback d-block">
                                <strong>{{ $errors->first('from_name') }}</strong>
                            </span>
                        @endif
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="from_email">{{ __('theme.from_email') }}</label>
                            <input type="text" name="from_email" value="{{ $setting->from_email ?? old('from_email') }}" class="form-control {{ $errors->has('from_email') ? ' is-invalid' : '' }}" id="from_email" placeholder="{{ __('theme.enter_from_email') }}">
                        </div>
                        @if ($errors->has('from_email'))
                            <span class="invalid-feedback d-block">
                                <strong>{{ $errors->first('from_email') }}</strong>
                            </span>
                        @endif
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="emailDriver">{{ __('theme.email_driver') }}</label>
                            <select class="form-control" id="emailDriver" name="mail_driver">
                                <option value="smtp" {{ $setting->mail_driver == 'smtp' ? 'selected' : '' }}>{{ __('SMTP') }}</option>
                                <option value="sendmail" {{ $setting->mail_driver == 'sendmail' ? 'selected' : '' }}>{{ __('Sendmail') }}</option>
                                <option value="mailgun" {{ $setting->mail_driver == 'mailgun' ? 'selected' : '' }}>{{ __('Mailgun') }}</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6" id="smtpHost">
                        <div class="form-group">
                            <label for="emailHost">{{ __('theme.smtp_host') }}</label>
                            <input type="text" name="smtp_host" value="{{ $setting->smtp_host ?? old('smtp_host') }}" class="form-control" id="emailHost" placeholder="{{ __('theme.enter_smtp_host') }}">
                        </div>
                    </div>
                    <div class="col-md-6" id="smtpPort">
                        <div class="form-group">
                            <label for="emailPort">{{ __('theme.smtp_port') }}</label>
                            <input type="number" name="smtp_port" value="{{ $setting->smtp_port ?? old('smtp_port') }}" class="form-control" id="emailPort" placeholder="{{ __('theme.enter_smtp_port') }}">
                        </div>
                    </div>
                    <div class="col-md-6" id="smtpUsername">
                        <div class="form-group">
                            <label for="smtpUsername">{{ __('theme.smtp_username') }}</label>
                            <input type="text" name="smtp_username" value="{{ $setting->smtp_username ?? old('smtp_username') }}" class="form-control" id="smtpUsername" placeholder="{{ __('theme.enter_smtp_username') }}">
                        </div>
                    </div>
                    <div class="col-md-6" id="smtpPassword">
                        <div class="form-group">
                            <label for="emailPassword">{{ __('theme.smtp_password') }}</label>
                            <input type="text" name="smtp_password" value="{{ $setting->smtp_password ?? old('smtp_password') }}" class="form-control" id="emailPassword" placeholder="{{ __('theme.enter_smtp_password') }}">
                        </div>
                    </div>
                    <div class="col-md-6" id="encryption">
                        <div class="form-group">
                            <label for="emailEncryption">{{ __('theme.encryption_type') }}</label>
                            <select name="smtp_encryption" id="emailEncryption" class="form-control">
                                <option disabled selected>{{ __('theme.select_one') }}</option>
                                <option value="tls" {{ $setting->smtp_encryption == 'tls' ? 'selected' : '' }}>{{ __('TLS') }}</option>
                                <option value="ssh" {{ $setting->smtp_encryption == 'ssh' ? 'selected' : '' }}>{{ __('SSH') }}</option>
                                <option value="ssl" {{ $setting->smtp_encryption == 'ssl' ? 'selected' : '' }}>{{ __('SSL') }}</option>
                            </select>
                        </div>
                    </div>

                    <!--mailgun setup-->
                    <div class="col-md-6" id="mailgunDomain" style="display: none">
                        <div class="form-group">
                            <label for="mailgun_domain">{{ __('theme.mailgun_domain') }}</label>
                            <input type="text" name="mailgun_domain" value="{{ $setting->mailgun_domain ?? old('mailgun_domain') }}" class="form-control" id="mailgun_domain" placeholder="{{ __('theme.enter_mailgun_domain') }}">
                        </div>
                    </div>
                    <div class="col-md-6" id="mailgunApi" style="display: none">
                        <div class="form-group">
                            <label for="mailgun_api">{{ __('theme.mailgun_api') }}</label>
                            <input type="text" name="mailgun_api" value="{{ $setting->mailgun_api ?? old('mailgun_api') }}" class="form-control" id="mailgun_api" placeholder="{{ __('theme.enter_mailgun_api') }}">
                        </div>
                    </div>
                    <!--end mailgun setup-->

                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label for="testMail">{{ __('theme.enter_test_mail') }}</label>
                        <input type="email" name="test_mail" value="{{ old('test_mail') }}" class="form-control" id="testMail" placeholder="{{ __('theme.enter_test_mail') }}">
                    </div>
                </div>

                <div class="card-footer col-md-12">
                    <button type="submit" class="btn btn-primary btn-block text-uppercase">{{ __('theme.update') }}</button>
                </div>
            </form>
        </div>
    </div>
    @else
        <div class="callout callout-warning">
            <h4>{{ __('theme.access_denied') }}</h4>

            <p>{{ __("theme.don't_have_permission") }}</p>
        </div>
    @endif
</div>

@endsection
