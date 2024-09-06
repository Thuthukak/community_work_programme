@extends('layouts.master')
@section('title', $gs->app_name . ' - Community Work Programme Portal' ?? config('devstar.app_name'))

@section('content')
    <!-- particles.js container -->
    <div id="particles-js"></div>

    <!---Banner section--->
    @include('includes.banner')

    <!---how-work--->
    @include('includes.howWork', ['works' => $works])

    <!---Service Section--->
    @include('includes.services', ['services' => $services])

    <!--- counter --->
    @include('includes.counter')
    
    <!--- Testimonials --->
    @include('includes.testimonials', ['testimonials' => $testimonials])

    <!--- Need Support section --->
    @include('includes.needSupport')

@endsection

@section('script')
    <!-- counter js -->
    <script src="{{ asset($publicPath.'/js/counter.js') }}"></script>
@endsection