@extends('layouts.home')
@section('title', 'Dashboard 1')

@section('style')

@section('contents')
    <!-- particles.js container -->
    <div id="particles-js">
  
    </div>

    <!-- forms -->

    @include('auth.register')
    @include('auth.loginModal')

    <!-- reset password  -->
    @include('auth.passwords.email')


    <!---Banner section--->
    @include('tickets.banner')

    <!---how-work--->
    @include('tickets.howWork', ['works' => $works])

    <!---Service Section--->
    @include('tickets.services', ['services' => $services])

    <!--- counter --->
    @include('tickets.counter')
    
    <!--- Testimonials --->
    @include('tickets.testimonials', ['testimonials' => $testimonials])

    <!--- Need Support section --->
    @include('tickets.needSupport')

@endsection

