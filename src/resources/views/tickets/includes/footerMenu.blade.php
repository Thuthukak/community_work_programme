<div class="col-md-4 footer-box footerContent" data-aos="fade-right" data-aos-offset="200" data-aos-delay="20" data-aos-duration="1000" data-aos-easing="ease-in-out"  data-aos-mirror="true">
    @php
        $logoUrl = isset($gs) && $gs->logo ? asset(symImagePath() . $gs->logo) : asset('images/profile.png');
        $footerText = isset($gs) ? $gs->footer_text : '';
    @endphp
    <img src="{{ $logoUrl }}" style="height: 80px; width: 150px; filter:invert(100%);">
    <p>{{ $footerText }}</p>
</div>

<div class="col-md-4 footer-box footerContent" data-aos="fade-down" data-aos-offset="200" data-aos-delay="20" data-aos-duration="1000" data-aos-easing="ease-in-out"  data-aos-mirror="true">
    @php
        $contactTitle = isset($gs) ? $gs->contact_title : '';
        $contactAddress = isset($gs) ? $gs->contact_address : '';
        $contactPhone = isset($gs) ? $gs->contact_phone : '';
        $contactEmail = isset($gs) ? $gs->contact_email : '';
    @endphp
    <p class="text-uppercase"><b>{{ $contactTitle }}</b></p>
    <p><i class="fa fa-map-marker"></i> {{ $contactAddress }}</p>
    <p><i class="fa fa-phone"></i> {{ $contactPhone }}</p>
    <p><i class="fa fa-envelope-o"></i> {{ $contactEmail }}</p>
</div>

@php
    $socials = \App\Models\CRM\Social\Social::all();
    $socialTitle = isset($gs) ? $gs->social_title : '';
@endphp

<div class="col-md-4 footer-box footerContent" data-aos="fade-down" data-aos-offset="200" data-aos-delay="20" data-aos-duration="1000" data-aos-easing="ease-in-out"  data-aos-mirror="true">
    <p class="text-uppercase"><b>{{ $socialTitle }}</b></p>
    <div class="social">
        @foreach($socials as $social)
            <a href="{{ $social->link }}" target="_blank"> <i class="{{ $social->code }}"></i> </a>
        @endforeach
    </div>
</div>
