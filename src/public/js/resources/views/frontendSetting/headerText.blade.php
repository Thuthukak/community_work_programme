@inject('permission', 'App\Http\Controllers\PermissionController')
@extends('dashboard.master')
@section('title','Header Text Setting')

@section('main-section')
<div class="container-fluid">
    @if($permission->manageBanerText() == 1)
    <h4 class="page-title">{{ __('theme.banner_text_setting') }}</h4>
    <div class="card mb-4">
        <div class="card-body">
            @include('includes.flash')
            <form action="{{ route('headerTextUpSetting',$setting->id) }}" method="post" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="header_title">{{ __('theme.banner_text_title') }}</label>
                        <input class="form-control mb-3" name="header_title" value="{{ $setting->header_title ?? old('header_title') }}"  type="text" required>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="header_subtitle">{{ __('theme.banner_text_sub_title') }}</label>
                        <input class="form-control mb-3" name="header_subtitle" value="{{ $setting->header_subtitle ?? old('header_subtitle') }}"  type="text" required>
                    </div>
                </div>
                
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