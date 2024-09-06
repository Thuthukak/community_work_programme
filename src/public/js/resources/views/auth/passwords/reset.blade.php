@extends('layouts.master')
@section('title', __('theme.change_password'))

@section('style')
    <link rel="stylesheet" type="text/css" media="screen" href="{{ asset($publicPath.'/css/auth.css') }}">
@endsection

@section('content')

<!-- particles.js container -->
<div id="particles-js"></div>

<!-- Change Password container -->
<div class="background-image pt-5 pb-4rem">
    <div class="container">
        <div class="wrapper fadeInDown">
            <div id="formContent">
                <!-- Tabs Titles -->
                <!-- Icon -->
                <div class="fadeIn first py-3">
                    <h5>{{ __('theme.change_password') }}</h5>
                </div>
                <!-- Login Form -->
                <form method="POST" action="{{ route('password.request') }}">
                    @csrf
                    <input type="hidden" name="token" value="{{ $token }}">
                    <input id="password" type="password" placeholder="{{ __('theme.enter_password') }}" class="fadeIn second {{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required>
                    @if ($errors->has('password'))
                        <span class="invalid-feedback d-block">
                            <strong>{{ $errors->first('password') }}</strong>
                        </span>
                    @endif
                    <input type="password" id="confirm-password" class="fadeIn third" name="password_confirmation" placeholder="Confirm Password" required>
                    <input type="submit" class="fadeIn fourth" value="Change Password">
                </form>
                <!-- Remind Password -->
                <div id="formFooter">
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
