@inject('permission', 'App\Http\Controllers\PermissionController')
@extends('dashboard.master')
@section('title', __('theme.logo_icon_setting'))

@section('main-section')
<div class="container-fluid">
    @if($permission->manageLogoIcon() == 1)
    <h4 class="page-title">{{ __('theme.logo_icon_setting') }}</h4>
    @include('includes.flash')
    <div class="card mb-4">
        <div class="card-body">
            <form action="{{ route('logoIconUpdate.Setting') }}" method="post" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="row  container-fluid">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="logo">{{ __('theme.logo') }}</label>
                            <input id="logo" class="form-control mb-3" type="file" name="logo" >
                            @if ($errors->has('logo'))
                                <span class="invalid-feedback d-block">
                                    <strong>{{ $errors->first('logo') }}</strong>
                                </span>
                            @endif
                            <small class="text-danger">[{{ __('theme.image_format') }}: PNG]</small>
                        </div>
                        <img class="thumbnail img-responsive" src="@if($gs->logo){{ asset(symImagePath().$gs->logo) }} @else {{ asset('images/logo.png') }} @endif"/>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="favicon_icon">{{ __('theme.favicon_icon') }}</label>
                            <input id="favicon_icon" class="form-control" type="file" name="favicon_icon">
                            @if ($errors->has('favicon_icon'))
                                <span class="invalid-feedback d-block">
                                    <strong>{{ $errors->first('favicon_icon') }}</strong>
                                </span>
                            @endif
                            <small class="text-danger">[{{ __('theme.image_format') }}: PNG]</small>
                        </div>
                        <img class="thumbnail img-responsive" src="@if($gs->favicon_icon){{ asset(symImagePath().$gs->favicon_icon) }} @else {{ asset('images/favicons.ico') }} @endif"/>
                    </div>
                </div>
                <br>
                <div class="col-md-12">
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