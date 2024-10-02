<section id="how-work">
    <div class="container work">
        <div class="section-title pb-5" data-aos="fade-down" data-aos-offset="200" data-aos-delay="20" data-aos-duration="800" data-aos-easing="ease-in-out"  data-aos-mirror="true">
            <h2 class="text-uppercase">{{ $gs->how_work_title }}</h2>
            <span class="section-separator"></span>
        </div>
        <div class="process-wrap fl-wrap">
            <ul class="no-list-style">
                @foreach($works as $key=> $work)
                <li data-aos="fade-down" data-aos-offset="200" data-aos-delay="20" data-aos-duration="1000" data-aos-easing="ease-in-out"  data-aos-mirror="true">
                    <div class="process-item">
                        <span class="process-count">0{{ $key+1 }} </span>
                        <div><i class="{{ $work->icon }} base-color"></i></div>
                        <h4> {{ $work->title }}</h4>
                        <p>{{ $work->details }}</p>
                    </div>
                    @if($key == 0)
                    <span class="pr-dec"></span>
                    @endif
                    @if($key == 1)
                    <span class="pr-dec"></span>
                    @endif
                </li>
                @endforeach
            </ul>
            <div class="process-end" data-aos="fade-down" data-aos-offset="200" data-aos-delay="20" data-aos-duration="600" data-aos-easing="ease-in-out"  data-aos-mirror="true">
                <i class="fa fa-arrow-down"></i>
            </div>
        </div>
    </div>
</section>