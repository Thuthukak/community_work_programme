@extends('layouts.master')
@section('title', __('theme.login'))

@section('style')
    <link rel="stylesheet" type="text/css" media="screen" href="{{ asset($publicPath.'/css/auth.css') }}">
@endsection

@section('content')
<!-- particles.js container -->
<div id="particles-js"></div>

<!-- login container -->
<div class="background-image pt-5 pb-4rem">
    <div class="container">
        <div class="wrapper fadeInDown">
            <div id="formContent">
                <!-- Tabs Titles -->
                <!-- Icon -->
                <div class="fadeIn first py-3">
                    <h5>{{ __('theme.login') }}</h5>
                </div>
                <!-- Login Form -->
                <form method="POST" action="{{ route('login') }}">
                    @csrf
                    <input type="email" id="login" class="fadeIn second {{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" placeholder="{{ __('theme.email') }}" required>
                    @if ($errors->has('email'))
                        <div class="invalid-feedback d-block">
                            <strong>{{ $errors->first('email') }}</strong>
                        </div>
                    @endif
                    <input type="password" id="password" class="fadeIn third {{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" placeholder="{{ __('theme.password') }}" required>
                    @if ($errors->has('password'))
                        <div class="invalid-feedback d-block">
                            <strong>{{ $errors->first('password') }}</strong>
                        </div>
                    @endif
                    <div class="form-row">
                        <div class="form-group col-12">
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}> {{ __('Remember Me') }}
                                </label>
                            </div>
                        </div>
                    </div>
                    <input type="submit" class="fadeIn fourth" value="Log In">
                </form>
                <!-- Remind Passowrd -->
                <div id="formFooter">
                   <div>
                       <a class="bluish-text" href="{{ route('passwordRequest') }}">{{ __("theme.forgot_your_password") }}</a>
                   </div>
                    <div>
                        {{ __("theme.don't_have_account") }}
                        <a href="{{ route('register') }}" class="bluish-text">{{ __('theme.create_account') }}</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
