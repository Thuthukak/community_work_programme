@extends('dashboard.master')
@inject('permission', 'App\Http\Controllers\PermissionController')
@section('style')

@stop

@section('title', __('theme.edit_role'))

@section('main-section')
    <div class="container-fluid">
        @if($permission->manageRole() == 1)
        <h4 class="page-title">{{ __('theme.edit_roles') }} #{{ $role->title }}
            <a href="{{ route('roles.index') }}" class="btn btn-primary pull-right">{{ __('theme.back') }}</a>
        </h4>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    @include('includes.flash')
                    <!-- /.box-header -->
                    <!-- form start -->
                    <form role="form" class="mx-auto" method="POST" action="{{ route('role-update.update',$data->id) }}">
                        {!! csrf_field() !!}
                        <div class="card-body">
                            <div class="form-group">
                                <label for="title">{{ __('theme.title') }}</label>
                                <input id="title" type="text" class="form-control" name="title" value="{{ $role->title }}" placeholder="{{ __("theme.enter_role_name") }}" required>

                                @if ($errors->has('title'))
                                    <span class="invalid-feedback d-block">
                                        <strong>{{ $errors->first('title') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="box-header">
                                        <h6 class="box-title">{{__('theme.settings')}}</h6>
                                    </div>
                                    <div class="form-group minimal">
                                        <input type="checkbox" id="role-1" value="can_manage_app_setting" @if($data->permissions) {{ in_array("can_manage_app_setting",$data->permissions) ? "checked" : "" }} @endif name="permissions[]">
                                        <label for="role-1" class="font-weight-normal">{{ __('theme.can_manage_app_setting') }}</label>
                                        <span></span>
                                    </div>
                                    <div class="form-group minimal">
                                        <input type="checkbox" id="setting-2" value="can_manage_email_setting" @if($data->permissions){{ in_array("can_manage_email_setting",$data->permissions) ? "checked" : "" }}@endif name="permissions[]">
                                        <label for="setting-2" class="font-weight-normal">{{ __('theme.can_manage_email_setting') }}</label>
                                        <span></span>
                                    </div>

                                    <div class="form-group minimal">
                                        <input type="checkbox" id="role-4" value="can_manage_email_template" @if($data->permissions){{ in_array("can_manage_email_template",$data->permissions) ? "checked" : "" }}@endif name="permissions[]">
                                        <label for="role-4" class="font-weight-normal">{{ __('theme.can_manage_email_template') }}</label>
                                        <span></span>
                                    </div>

                                    <div class="box-header my-1">
                                        <h6 class="box-title">{{ __('theme.frontend_settings') }}</h6>
                                    </div>
                                    <div class="form-group minimal">
                                        <input type="checkbox" class="minimal" id="role-10" value="can_manage_logo_icon" @if($data->permissions){{ in_array("can_manage_logo_icon",$data->permissions) ? "checked" : "" }}@endif name="permissions[]">
                                        <label for="role-10" class="font-weight-normal">{{ __("theme.can_manage_logo_icon") }}</label>
                                        <span></span>
                                    </div>
                                    <div class="form-group minimal">
                                        <input type="checkbox" class="minimal" id="role-11" value="can_manage_social_link" @if($data->permissions){{ in_array("can_manage_social_link",$data->permissions) ? "checked" : "" }}@endif name="permissions[]">
                                        <label for="role-11" class="font-weight-normal">{{ __("theme.can_manage_social_link") }}</label>
                                        <span></span>
                                    </div>

                                    <div class="form-group minimal">
                                        <input type="checkbox" class="minimal" id="role-12" value="can_manage_baner_text" @if($data->permissions){{ in_array("can_manage_baner_text",$data->permissions) ? "checked" : "" }}@endif name="permissions[]">
                                        <label for="role-12" class="font-weight-normal">{{ __("theme.can_manage_baner_text") }}</label>
                                        <span></span>
                                    </div>

                                    <div class="form-group minimal">
                                        <input type="checkbox" class="minimal" id="role-13" value="can_manage_testimonial" @if($data->permissions){{ in_array("can_manage_testimonial",$data->permissions) ? "checked" : "" }}@endif name="permissions[]">
                                        <label for="role-13" class="font-weight-normal">{{ __('theme.can_manage_testimonial') }}</label>
                                        <span></span>
                                    </div>

                                    <div class="form-group minimal">
                                        <input type="checkbox" class="minimal" id="role-14" value="can_manage_service" @if($data->permissions){{ in_array("can_manage_testimonial",$data->permissions) ? "checked" : "" }}@endif name="permissions[]">
                                        <label for="role-14" class="font-weight-normal">{{ __('theme.can_manage_service') }}</label>
                                        <span></span>
                                    </div>

                                    <div class="form-group minimal">
                                        <input type="checkbox" class="minimal" id="role-15" value="can_manage_aboutus" @if($data->permissions){{ in_array("can_manage_aboutus",$data->permissions) ? "checked" : "" }}@endif name="permissions[]">
                                        <label for="role-15" class="font-weight-normal">{{ __('theme.can_manage_about_us') }}</label>
                                        <span></span>
                                    </div>

                                    <div class="form-group minimal">
                                        <input type="checkbox" class="minimal" id="role-16" value="can_manage_footer" @if($data->permissions){{ in_array("can_manage_footer",$data->permissions) ? "checked" : "" }}@endif name="permissions[]">
                                        <label for="role-16" class="font-weight-normal">{{ __('theme.can_manage_footer') }}</label>
                                        <span></span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="box-header">
                                        <h6 class="box-title">{{ __('theme.tickets') }}</h6>
                                    </div>
                                    <div class="form-group minimal">
                                        <input type="checkbox" id="role-5" value="can_manage_tickets" @if($data->permissions){{ in_array("can_manage_tickets",$data->permissions) ? "checked" : "" }}@endif name="permissions[]">
                                        <label for="role-5" class="font-weight-normal">{{ __('theme.can_manage_tickets') }}</label>
                                        <span></span>
                                    </div>

                                    <div class="box-header">
                                        <h6 class="box-title">{{ __('theme.departments') }}</h6>
                                    </div>
                                    <div class="form-group minimal">
                                        <input type="checkbox" id="role-6" value="can_manage_department" @if($data->permissions){{ in_array("can_manage_department",$data->permissions) ? "checked" : "" }}@endif name="permissions[]">
                                        <label for="role-6" class="font-weight-normal">{{ __('theme.can_manage_department') }}</label>
                                        <span></span>
                                    </div>

                                    <div class="box-header">
                                        <h6 class="box-title">{{ __('theme.knowledge_base') }}</h6>
                                    </div>
                                    <div class="form-group minimal">
                                        <input type="checkbox" id="role-7" value="can_manage_kb" @if($data->permissions){{ in_array("can_manage_kb",$data->permissions) ? "checked" : "" }}@endif name="permissions[]">
                                        <label for="role-7" class="font-weight-normal">{{ __('theme.can_manage_knowledge_base') }}</label>
                                        <span></span>
                                    </div>

                                    <div class="box-header">
                                        <h6 class="box-title">{{ __('theme.staffs') }}</h6>
                                    </div>
                                    <div class="form-group minimal">
                                        <input type="checkbox" id="role-8" value="can_manage_staff" @if($data->permissions){{ in_array("can_manage_staff",$data->permissions) ? "checked" : "" }}@endif name="permissions[]">
                                        <label for="role-8" class="font-weight-normal">{{ __('theme.can_manage_staff') }}</label>
                                        <span></span>
                                    </div>

                                    <div class="box-header">
                                        <h6 class="box-title">{{ __('theme.users') }}</h6>
                                    </div>
                                    <div class="form-group minimal">
                                        <input type="checkbox" id="role-9" value="can_manage_user" @if($data->permissions){{ in_array("can_manage_user",$data->permissions) ? "checked" : "" }}@endif name="permissions[]">
                                        <label for="role-9" class="font-weight-normal">{{ __('theme.can_manage_user') }}</label>
                                        <span></span>
                                    </div>
                                    <div class="box-header">
                                        <h6 class="box-title">{{ __('translation.translations') }}</h6>
                                    </div>
                                    <div class="form-group minimal">
                                        <input type="checkbox" id="can_manage_translation" value="can_manage_translation" @if($data->permissions){{ in_array("can_manage_translation",$data->permissions) ? "checked" : "" }}@endif name="permissions[]">
                                        <label for="can_manage_translation" class="font-weight-normal">{{ __('theme.can_manage_translation') }}</label>
                                        <span></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- /.card-body -->

                        <div class="card-footer mb-3">
                            <button type="submit" class="btn btn-primary btn-block">{{ __('theme.update') }}</button>
                        </div>
                    </form>
                </div>
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