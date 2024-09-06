
<div class="col-md-4 footer-box footerContent" data-aos="fade-right" data-aos-offset="200" data-aos-delay="20" data-aos-duration="1000" data-aos-easing="ease-in-out"  data-aos-mirror="true">
<img src="@if($gs->logo){{ asset(symImagePath().$gs->logo) }} @else {{ asset($publicPath.'/images/logo/wcp_logo_only_b&w.png') }} @endif"
style="height: 80px; width: 150px; filter:invert(100%);">
    <p>{{ $gs->footer_text}}</p>
</div>
<div class="col-md-4 footer-box footerContent" data-aos="fade-down" data-aos-offset="200" data-aos-delay="20" data-aos-duration="1000" data-aos-easing="ease-in-out"  data-aos-mirror="true">
    <p class="text-uppercase"><b>{{ $gs->contact_title }}</b></p>
    <p><i class="fa fa-map-marker"></i> {{ $gs->contact_address }}</p>
    <p><i class="fa fa-phone"></i> {{ $gs->contact_phone }}</p>
    <p><i class="fa fa-envelope-o"></i> {{ $gs->contact_email }}</p>
</div>
@php
    $socials = \App\Models\Social::all();
@endphp
<div class="col-md-4 footer-box footerContent" data-aos="fade-down" data-aos-offset="200" data-aos-delay="20" data-aos-duration="1000" data-aos-easing="ease-in-out"  data-aos-mirror="true">
    <p class="text-uppercase"><b>{{ $gs->social_title }}</b></p>
    <div class="social">
        @foreach($socials as $social)
            <a href="{{ $social->link }}" target="_blank"> <i class="{{ $social->code }}"></i> </a>
        @endforeach
    </div>
</div>