@inject('permission', 'App\Http\Controllers\PermissionController')
@extends('dashboard.master')
@section('title', __('theme.app_settings'))

@section('main-section')
<div class="container-fluid">
    @if($permission->manageAppSetting() == 1)
    <h4 class="page-title">{{ __('theme.app_settings') }}</h4>
    <div class="card mb-4">
        <div class="card-body">
            @include('includes.flash')
            <form action="{{ route('appSettingUpdate',$setting->id) }}" method="post">
                @csrf
                @method('PUT')
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="appName"><strong>{{ __('theme.app_name') }}</strong></label>
                            <input id="appName" class="form-control mb-3" name="app_name" value="{{ $setting->app_name ?? old('app_name') }}" type="text" required>
                            <input class="form-control mb-3" name="id" value="{{ $setting->id }}" type="hidden">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="app_description"><strong>{{ __('theme.site_details') }}</strong></label>
                            <input id="app_description" class="form-control mb-3" name="app_description" value="{{ $setting->app_description ?? old('app_description') }}" type="text" required>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="keywords">
                                <strong>{{ __('theme.meta_keywords') }}</strong>
                            </label>
                            <textarea id="keywords" class="form-control" name="app_keywords"> {{ $setting->app_keywords ?? old('app_keywords') }}</textarea>
                        </div>
                    </div>
                </div>
                <div class="col-md-12 mb-3">
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