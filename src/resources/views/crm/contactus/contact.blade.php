@extends('layouts.home')

@section('title', __('theme.contact_us'))

@section('content')

<!--About Us -->
<section id="aboutus">
    <div class="" id="banner-container-fluid">
        <div class="" data-aos="fade-down" data-aos-offset="200" data-aos-delay="20" data-aos-duration="1000" data-aos-easing="ease-in-out"  data-aos-mirror="true">
            <div class="jumbotron">
              <h1 class="leader">{{ $gs->contact_title }}</h1>
              <p><a href="{{url('/')}}">{{ __('theme.home') }}</a> / <a href="{{ route('contactPage') }}" class="active">{{ __('theme.contact_us') }}</a></p>
            </div>
        </div>
    </div>

    <div class="container mb-5">
        <div class="row justify-content-lg-around position-relative pt-5">
            <div class="col-lg-5 col-md-5 mb-4">
                <div class="" data-aos="fade-down" data-aos-offset="200" data-aos-delay="20" data-aos-duration="1000">
                    <h3 class="mt-5 text-nb">{{ __('theme.tet_in_touch') }}</h3>

                    <div class="box-widget-content bwc-nopad">
                        <div class="list-author-widget-contacts list-item-widget-contacts bwc-padside">
                            <ul class="no-list-style">
                                <li class="pt-3"><span><i class="fa fa-map-marker"></i> {{ __('theme.address') }} :</span> <a href="javascript:void (0)" class="custom-scroll-link">{{ $gs->contact_address }}</a></li>
                                <li><span><i class="fa fa-phone"></i> {{ __('theme.phone') }} :</span> <a href="javascript:void (0)">{{ $gs->contact_phone }}</a></li>
                                <li><span><i class="fa fa-envelope"></i> {{ __('theme.email') }} :</span> <a href="javascript:void (0)">{{ $gs->contact_email }}</a></li>
                            </ul>
                        </div>

                        <div class="list-widget-social bottom-bcw-box  fl-wrap">
                            <ul class="no-list-style">
                                @foreach($socials as $social)
                                <li><a href="{{ $social->link }}" target="_blank"><i class="{{ $social->code }}"></i></a></li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-7 col-md-7 pr-lg-5">
                <div class="p-4 p-md-5 bg-white shadow" data-aos="fade-down" data-aos-offset="200" data-aos-delay="20" data-aos-duration="1000" data-aos-easing="ease-in-out"  data-aos-mirror="true">
                    <h3 class="text-nb">{{ __('theme.need_assistance') }}</h3>
                    @include('tickets.flash')
                    <form method="post" action="{{ route('contactStore') }}" class="mt-4">
                        @csrf
                        <div class="form-group mb-3">
                            <input type="text" class="form-control" name="name" value="{{ old('name') }}" id="exampleInputName" placeholder="{{ __('theme.your_full_name') }}" required>
                        </div>
                        <div class="form-group mb-3">
                            <input type="text" class="form-control" name="phone" value="{{ old('phone') }}" id="exampleInputEmail" placeholder="{{ __('theme.your_phone_number') }}" required>
                        </div>
                        <div class="form-group mb-3">
                            <input type="email" class="form-control" name="email" value="{{ old('email') }}" id="exampleInputEnquiry" placeholder="{{ __('theme.your_email_address') }}" required>
                        </div>
                        <div class="form-group mb-4">
                            <textarea class="form-control" name="message" id="exampleInputEnquiry-Description" placeholder="Enquiry Description" rows="5" required>{{ old('message') }}</textarea>
                        </div>
                        <div class="form-group mb-0">
                            <button type="submit" class="btn btn-primary">{{ __('theme.send_message') }}<i class="fa fa-arrow-right pl-3"></i></button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="contact-bg-logo">
                <i class="fa fa-comment"></i>
            </div>
        </div>
    </div>
</section>

@endsection

@section('style')
    <link rel="stylesheet" type="text/css" href="{{ asset('css/contact.css') }}">
@endsection