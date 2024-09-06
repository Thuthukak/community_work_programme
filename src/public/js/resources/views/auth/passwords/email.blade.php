@extends('layouts.master')
@section('title', __('theme.reset_password'))

@section('style')
    <link rel="stylesheet" type="text/css" media="screen" href="{{ asset($publicPath.'/css/auth.css') }}">
@endsection

@section('content')

<!-- particles.js container -->
<div id="particles-js"></div>

<!-- Forgot Password container -->
<div class="background-image pt-5 pb-13rem">
    <div class="container">
        <div class="wrapper fadeInDown">
            <div id="formContent">
                <!-- Tabs Titles -->
                <!-- Icon -->
                <div class="fadeIn first py-3">
                    <h5>{{ __('theme.reset_password') }}</h5>
                </div>
                @if (session('status'))
                    <div class="alert alert-success">
                        {{ session('status') }}
                    </div>
                @endif

                <!-- Login Form -->
                <form method="POST" action="{{ route('passwordReset') }}">
                    @csrf
                    <input type="email" id="login" class="fadeIn second {{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" placeholder="{{ __('theme.email') }}" required>
                    @if ($errors->has('email'))
                        <div class="invalid-feedback d-block">
                            <strong>{{ $errors->first('email') }}</strong>
                        </div>
                    @endif
                    <input type="submit" class="fadeIn third" value="{{ __('theme.send_password_reset_link') }}">
                </form>
                <!-- Remind Passowrd -->
                <div id="formFooter">
                    <div>
                        {{ __('theme.back_to') }}
                        <a href="{{ route('login') }}" class="bluish-text">{{ __('theme.login') }}</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
