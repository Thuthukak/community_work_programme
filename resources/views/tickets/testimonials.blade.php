<section class="reviews" id="testimonials">
    <div class="testimonial3 py-5 bg-light">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8 text-center">
                <div class="section-title" data-aos="fade-down" data-aos-offset="200" data-aos-delay="20" data-aos-duration="1000" data-aos-easing="ease-in-out"  data-aos-mirror="true">
                    <h2 class="mb-3">{{ $gs->testimonial_title }}</h2>
                    <span class="section-separator"></span>
                    <p class="subtitle font-weight-normal text-nb">{{ $gs->testimonial_details }}</p>
                </div>
            </div>
        </div>
        <!-- Row  -->
        <div class="owl-carousel owl-theme testi3 mt-4">
            <!-- item -->
            @foreach($testimonials as $testimonial)
            <div class="item" data-aos="fade-down" data-aos-offset="200" data-aos-delay="20" data-aos-duration="1000" data-aos-easing="ease-in-out"  data-aos-mirror="true">
                <div class="card card-shadow border-0 mb-4">
                    <div class="card-body">
                        <h6 class="font-weight-light mb-3 text-nb">“{{ Str::limit(strip_tags($testimonial->comment), 105) }}”</h6>
                        <div class="d-block d-md-flex align-items-center">
                            <span class="thumb-img"><img src="@if($testimonial->image){{ asset(env('APP_URL').$testimonial->image) }} @else {{ asset('images/testimonials/testimonial.png') }} @endif" alt="image" class="rounded-circle"/></span>
                            <div class="ml-3">
                                <h6 class="mb-0 customer text-nb">{{ $testimonial->name }}</h6>
                                <div class="font-10 text-nb">
                                    {{ $testimonial->designation }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
            <!-- item -->
        </div>
    </div>
</div>
</section>