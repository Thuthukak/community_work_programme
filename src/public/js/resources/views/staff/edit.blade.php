@extends('dashboard.master')
@inject('permission', 'App\Http\Controllers\PermissionController')
@section('title', __('theme.edit_staff_info'))

@section('main-section')
    <div class="container-fluid">
        @if($permission->manageStaff() == 1)
        <h4 class="page-title">{{ __('theme.update') }} #{{ $user->id }} - {{ $user->name }} {{ __('theme.staff_info') }}
            <a href="{{ route('staffs.staffList') }}" class="btn btn-primary pull-right">{{ __('theme.back') }}</a>
        </h4>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                @include('includes.flash')
                <!-- /.box-header -->
                    <!-- form start -->
                    <form role="form" method="POST" action="{{ route('staff-update.staffUpdate', $user->id) }}">
                        {!! csrf_field() !!}
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="name">{{ __('theme.name') }}</label>
                                        <input id="name" type="text" class="form-control {{ $errors->has('name') ? ' has-error' : '' }}" name="name" value="{{ $user->name }}">

                                        @if ($errors->has('name'))
                                            <span class="invalid-feedback d-block">
                                                <strong>{{ $errors->first('name') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="email">{{ __('theme.email') }}</label>
                                        <input id="email" type="text" class="form-control {{ $errors->has('email') ? ' has-error' : '' }}" name="email" value="{{ $user->email }}">

                                        @if ($errors->has('email'))
                                            <span class="invalid-feedback d-block">
                                                <strong>{{ $errors->first('email') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="department">{{ __('theme.department') }}</label>
                                        <select id="department" type="" class="form-control {{ $errors->has('department') ? ' has-error' : '' }}" name="department">
                                            @foreach ($departments as $department)
                                                <option value="{{ $department->id }}" {{ $user->department_id == $department->id ? 'selected' : '' }}>{{ $department->title }}</option>
                                            @endforeach
                                        </select>
                                        @if ($errors->has('department'))
                                            <span class="invalid-feedback d-block">
                                            <strong>{{ $errors->first('department') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="role">{{ __('theme.role') }}</label>
                                        <select id="role" type="" class="form-control" name="role">
                                            @foreach ($roles as $role)
                                                <option value="{{ $role->id }}" {{ $user->role_id == $role->id ? 'selected' : '' }}>{{ $role->title }}</option>
                                            @endforeach
                                        </select>
                                        @if ($errors->has('role'))
                                            <span class="invalid-feedback d-block">
                                            <strong>{{ $errors->first('role') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="email">{{ __('theme.status') }}</label>
                                        <select id="status" type="" class="form-control {{ $errors->has('status') ? ' has-error' : '' }}" name="status">
                                            <option value="1" {{ old('status') == '1' ? 'selected' : '' }}>{{ __('theme.active') }}</option>
                                            <option value="0" {{ old('status') == '0' ? 'selected' : '' }}>{{ __('theme.inactive') }}</option>
                                        </select>
                                        @if ($errors->has('status'))
                                            <span class="help-block">
                                            <strong>{{ $errors->first('status') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="box-footer mb-3">
                                <button type="submit" class="btn btn-primary btn-block">{{ __('theme.update') }}</button>
                            </div>
                        </div>
                        <!-- /.box-body -->
                    </form>
                </div>
            </div>
        </div>
        @else
            <div class="callout callout-warning">
                <h4>{{ __('theme.access_denied') }}</h4>

                <p>{{ __("theme.don't have permission") }}</p>
            </div>
        @endif
    </div>
@endsection