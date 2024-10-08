@extends('layouts.home')
@section('title', 'Home')

@section('style')

@section('contents')


    <!-- forms -->

    @include('auth.register')
    @include('auth.loginModal')

    <!-- reset password  -->
    @include('auth.passwords.email')


    <!---Banner section--->
    @include('tickets.banner')

    <!---how-work--->
    @include('tickets.howWork', ['works' => $works])


    <!-- Opporties section -->


    <!---Service Section--->
    @include('tickets.services', ['services' => $services])

    <!--- counter --->
    @include('tickets.counter')
    
    <!--- Testimonials --->
    @include('tickets.testimonials', ['testimonials' => $testimonials])

    <!--- Need Support section --->
    @include('tickets.needSupport')

@endsection

