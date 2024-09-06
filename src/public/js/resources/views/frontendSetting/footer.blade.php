@inject('permission', 'App\Http\Controllers\PermissionController')
@extends('dashboard.master')
@section('title', 'Footer Setting')

@section('main-section')
<div class="container-fluid">
    @if($permission->manageFooter() == 1)
    <h4 class="page-title">{{ __('theme.footer_setting') }}</h4>
    <div class="card mb-4">
        <div class="card-body">
            <form action="{{ route('updateFooter.Setting') }}" method="post">
                @csrf
                @method('PUT')
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="footer_text"><strong>{{ __('theme.footer_text') }}</strong></label>
                            <input id="footer_text" class="form-control mb-3" name="footer_text" value="{{ $setting->footer_text ?? old('footer_text') }}"  type="text" required>
                            <input type="hidden" value="{{ $setting->id }}" name="id">
                        </div>
                    </div>
                </div>
                <div class="col-md-12 font-weight-bold text-uppercase">{{ __('theme.contact_us') }}</div>
                <hr>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group pt-0 mb-0 pb-0">
                            <label for="contact_title"><strong>{{ __('theme.contact_title') }}</strong></label>
                            <input id="contact_title" class="form-control mb-3" name="contact_title" value="{{ $setting->contact_title ?? old('contact_title') }}"  type="text" required>
                            <input type="hidden" value="{{ $setting->id }}" name="id">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group pt-0 mb-0 pb-0">
                            <label for="address"><strong>{{ __('theme.contact_address') }}</strong></label>
                            <input id="address" class="form-control mb-3" name="contact_address" value="{{ $setting->contact_address ?? old('contact_address') }}"  type="text" required>
                            <input type="hidden" value="{{ $setting->id }}" name="id">
                        </div>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group pt-0 mb-0 pb-0">
                            <label for="contact_phone"><strong>{{ __('theme.contact_phone') }}</strong></label>
                            <input id="contact_phone" class="form-control mb-3" name="contact_phone" value="{{ $setting->contact_phone ?? old('contact_phone') }}"  type="text" required>
                            <input type="hidden" value="{{ $setting->id }}" name="id">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group pt-0 mb-0 pb-0">
                            <label for="contact_email"><strong>{{ __('theme.contact_email') }}</strong></label>
                            <input id="contact_email" class="form-control mb-3" name="contact_email" value="{{ $setting->contact_email ?? old('contact_email') }}"  type="text" required>
                            <input type="hidden" value="{{ $setting->id }}" name="id">
                        </div>
                    </div>
                </div>

                <div class="col-md-12 mt-3">
                    <button type="submit" class="btn btn-primary btn-block">{{ __('theme.update') }}</button>
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