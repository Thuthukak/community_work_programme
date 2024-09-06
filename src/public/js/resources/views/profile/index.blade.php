@extends('dashboard.master')

@section('title', __('theme.profile'))

@section('main-section')
    <!-- Main content -->
    <div class="container-fluid">
        @include('includes.flash')
        <div class="row">
            <div class="col-md-3">
                <!-- Profile Image -->
                <div class="card">
                    <div class="card-body card-profile">
                        @if($user->avatar)
                        <img class="profile-user-img img-thumbnail img-round center" src="{{ asset(symImagePath().$user->avatar) }}" alt="avatar">
                        @else
                        <img class="profile-user-img img-thumbnail img-round center profile-avatar" src="{{ asset('uploads/profile/default.jpg') }}" alt="avatar">
                        @endif

                        <h3 class="profile-username text-center">{{ $user->name }}</h3>

                        <p class="text-muted text-center">{{ $user->email }}</p>
                        <p class="text-black text-center">
                            @if($user->is_admin == 1)
                                <span>{{ __('theme.role') }}: {{ __('theme.admin') }}</span>
                            @endif
                        </p>
                    </div>
                    <!-- /.box-body -->
                </div>
                <!-- /.box -->
            </div>
            <!-- /.col -->
            <div class="col-md-9">
                <div class="card">
                    <ul class="nav nav-tabs">
                        <li class="nav-item">
                            <a href="#edit-profile" class="nav-link active" data-toggle="tab">{{ __('theme.edit_profile') }}</a>
                        </li>
                        <li class="nav-item">
                            <a href="#change-password" class="nav-link" data-toggle="tab">{{ __('theme.change_password') }}</a>
                        </li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane fade show active" id="edit-profile">
                            <form class="form-horizontal" action="{{ route('profileUpdate') }}" method="post" enctype="multipart/form-data">
                                @csrf
                                {{ method_field('put') }}
                                <div class="form-group">
                                    <label for="inputName" class="col-sm-2 control-label">{{ __('theme.name') }}</label>
                                    <div class="col-sm-10">
                                        <input type="text" name="name" value="{{ $user->name }}" class="form-control" id="inputName" placeholder="{{ __('theme.name') }}">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="inputEmail" class="col-sm-2 control-label">{{ __('theme.email') }}</label>
                                    <div class="col-sm-10">
                                        <input type="email" name="email" value="{{ $user->email }}" class="form-control" id="inputEmail" placeholder="{{ __('theme.email') }}">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="inputImage" class="col-sm-2 control-label">{{ __('theme.upload_avatar') }}</label>
                                    <div class="col-sm-10">
                                        <input type="file" name="avatar" value="{{ $user->avatar }}" class="form-control" id="inputImage" placeholder="avatar" accept="">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-sm-offset-2 col-sm-10">
                                        <button type="submit" class="btn btn-primary">{{ __('theme.submit') }}</button>
                                    </div>
                                </div>
                            </form>
                        </div>

                        <div class="tab-pane fade" id="change-password">
                            <form class="form-horizontal" action="{{ route('changed-password.changedPassword') }}" method="post">
                                @csrf
                                <div class="form-group">
                                    <label for="password" class="col-sm-3 control-label">{{ __('theme.new_password') }}</label>

                                    <div class="col-sm-9 {{ $errors->has('password') ? ' has-error' : '' }}">
                                        <input type="password" name="password" class="form-control" id="password" placeholder="{{ __('theme.enter_new_password') }}" required>
                                        @if ($errors->has('password'))
                                            <span class="help-block">
                                            {{ $errors->first('password') }}
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="password-confirm" class="col-sm-3 control-label">{{ __('theme.confirm_password') }}</label>

                                    <div class="col-sm-9">
                                        <input type="password" name="password_confirmation" class="form-control" id="password-confirm" placeholder="{{ __('theme.enter_confirm_password') }}" required>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="col-sm-offset-2 col-sm-10">
                                        <button type="submit" class="btn btn-primary">{{ __('theme.change_password') }}</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <!-- /.tab-pane -->
                    </div>
                    <!-- /.tab-content -->
                </div>
                <!-- /.nav-tabs-custom -->
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
    </div>
    <!-- /.content -->
@endsection