<section id="banner" class="banner-section">
    <div class="container">

        <div class="row">
            <div class="col-md-5 col-12 text-center text-md-left" data-aos="fade-down" data-aos-offset="200" data-aos-delay="20" data-aos-duration="700" data-aos-easing="ease-in-out" data-aos-mirror="true">
                <p class="banner-title">{{ $gs->header_title }}</p>
                <p>{{ $gs->header_subtitle }}</p>
                <a href="{{ url('add-new-ticket') }}" class="btn btn-primary mt-3 mb-3 md:mb-0"><i class="fa fa-ticket" aria-hidden="true"></i> {{ __('theme.submit_ticket') }}</a>
            </div>
            <div class="col-md-7 col-12 mb-0 md:col-md-7 col-12 mb-5">
                <!-- Carousel starts here -->
                <div id="imageCarousel" class="carousel slide" data-ride="carousel">
                    <!-- Indicators -->
                    <ol class="carousel-indicators">
                        <li data-target="#imageCarousel" data-slide-to="0" class="active"></li>
                        <li data-target="#imageCarousel" data-slide-to="1"></li>
                        <li data-target="#imageCarousel" data-slide-to="2"></li>
                        <li data-target="#imageCarousel" data-slide-to="3"></li>
                        <li data-target="#imageCarousel" data-slide-to="4"></li>
                        <li data-target="#imageCarousel" data-slide-to="5"></li>
                    </ol>

                    <!-- Slides -->
                    <div class="carousel-inner">
                        <div class="carousel-item active">
                            <img src="{{ asset(env('APP_URL').'/images/banner/banner1.jpg') }}" class="d-block w-100 img-fluid" alt="Image 1">
                        </div>
                        <div class="carousel-item">
                            <img src="{{ asset(env('APP_URL').'/images/banner/banner2.jpg') }}" class="d-block w-100 img-fluid" alt="Image 2">
                        </div>
                        <div class="carousel-item">
                            <img src="{{ asset(env('APP_URL').'/images/banner/banner3.jpg') }}" class="d-block w-100 img-fluid" alt="Image 3">
                        </div>
                        <div class="carousel-item">
                            <img src="{{ asset(env('APP_URL').'/images/banner/banner4.jpg') }}" class="d-block w-100 img-fluid" alt="Image 4">
                        </div>
                        <div class="carousel-item">
                            <img src="{{ asset(env('APP_URL').'/images/banner/banner5.jpg') }}" class="d-block w-100 img-fluid" alt="Image 5">
                        </div>
                        <div class="carousel-item">
                            <img src="{{ asset(env('APP_URL').'/images/banner/banner6.jpg') }}" class="d-block w-100 img-fluid" alt="Image 6">
                        </div>
                    </div>

                    <!-- Controls -->
                    <a class="carousel-control-prev" href="#imageCarousel" role="button" data-slide="prev" style="position: absolute; top: 50%; transform: translateY(-50%);
                    color: #fff;
                    font-weight: 600;
                    height: 40px !important;
                    width: 40px !important;
                    box-shadow: none;
                    padding: 8px !important;
                    border-radius: 25px !important;
                     ">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="sr-only">Previous</span>
                    </a>
                    <a class="carousel-control-next" href="#imageCarousel" role="button" data-slide="next" style="position: absolute; top: 50%; transform: translateY(-50%); 
                    color: #fff;
                    font-weight: 600;
                    height: 40px !important;
                    width: 40px !important;
                    box-shadow: none;
                    padding: 8px !important;
                    border-radius: 25px !important;
                     ">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="sr-only">Next</span>
                    </a>
                </div>
                <!-- Carousel ends here -->
            </div>
        </div>
    </div>
</section>
<style>
    .banner-section {
    margin-top: -30px; /* Adjust this value to control how much you want to push it up */
}

@media (max-width: 768px) {
    .banner-section {
        margin-top: -20px; /* For mobile devices, a slightly smaller negative margin */
    }
}

.banner-title {
    font-size: 2rem;
    margin-bottom: 10px;
}

.carousel img {
    max-height: 400px; /* Limit image height on mobile */
}

@media (max-width: 576px) {
    .carousel img {
        max-height: 250px; /* Further limit image height on smaller screens */
    }
}

</style>
