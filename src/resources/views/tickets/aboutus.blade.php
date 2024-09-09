@extends('layouts.home')

@section('title', __('theme.about_us'))

@section('content')

<!--About Us -->
<section id="aboutus">
    <div class="" id="banner-container-fluid">
        <div class="" data-aos="fade-down" data-aos-offset="200" data-aos-delay="20" data-aos-duration="1000" data-aos-easing="ease-in-out"  data-aos-mirror="true">
            <div class="jumbotron mb-0">
              <h1 class="leader">{{ $gs->aboutus_title }}</h1>
              <p><a href="{{url('/')}}">{{ __('theme.home') }}</a> / <a href="{{ route('aboutusPage') }}" class="active">{{ __('theme.about_us') }}</a></p>
            </div>
        </div>
    </div>
    <div class="bg-light">

    <div class="container py-4 mb-5">

        <div class="row align-items-center">
            <div class="section-title my-5" data-aos="fade-down" data-aos-offset="200" data-aos-delay="30" data-aos-duration="1000" data-aos-easing="ease-in-out"  data-aos-mirror="true">
                <h2 class="text-uppercase">{{ __('theme.who_are_we') }}</h2>
                <span class="section-separator m-0"></span>
            </div>

            <div class="col-md-6" data-aos="fade-right" data-aos-offset="200" data-aos-delay="20" data-aos-duration="1000" data-aos-easing="ease-in-out"  data-aos-mirror="true">
                <div class="list-single-main-media fl-wrap" style="box-shadow: 0 9px 26px rgba(58, 87, 135, 0.2);">
                    <img src="{{ asset('/images/bg/about_details.jpg') }}" class="respimg" alt="">
                </div>
            </div>
            <div class="col-md-6" data-aos="fade-up" data-aos-offset="200" data-aos-delay="20" data-aos-duration="1000" data-aos-easing="ease-in-out"  data-aos-mirror="true">
                <div class="ab_text">
                    <div class="ab_text-title fl-wrap">
                        <h3>We are,</h3>
                    </div>
                    <p class="about-text">{{ $gs->aboutus_details }}</p>
                </div>
            </div>
        </div>

    </div>
</div>
</section>

<!--- Need Support section --->
@include('tickets.needSupport')

@endsection
@section('style')
    <link rel="stylesheet" type="text/css" href="{{ asset('css/about.css') }}">
@endsection