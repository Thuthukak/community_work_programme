
<div class="container-fluid">

<div class="site-section">
<div id="app" class="site-blocks-cover overlay" style="background-image: url('external/images/hero_1.jpg');" data-aos="fade" data-stellar-background-ratio="0.5">
    <div class="container">
      <div class="row align-items-center">
        <div class="col-12" data-aos="fade">
          <h1>Find Job</h1>
          
            <div class="row mb-3">
              <div class="col-md-9">
                <div class="row">
                  <div class="col-md-12 mb-3 mb-md-0">
                    <search-component></search-component>
                  </div>
       
                </div>
              </div>
              <div class="col-md-3">
                <input type="button" class="btn btn-search btn-primary btn-block" value="Type Jobs">
              </div>
            </div>
            {{-- <div class="row">
              <div class="col-md-12">
                <p class="small">or browse by title, address, postion: </p>
              </div>
            </div> --}}
            
        </div>
      </div>
    </div>
  </div>

<div class="container">
      <div class="row">
        <div class="col-md-6 mx-auto text-center mb-5 section-heading">
          <h2 class="mb-5">Popular Categories</h2>
        </div>
      </div>
      <div class="row">

          
     
          @foreach ($categories as $category )
          <div class="col-sm-6 col-md-4 col-lg-3 mb-3" data-aos="fade-up" data-aos-delay="100">
            <a href="{{ route('category.index', [$category->id,$category->slug ]) }}" class="h-100 feature-item">
              <span class="d-block icon  mb-3 text-primary"></span>
              <h2>{{ $category->name }}</h2>
              <span class="counting">{{ $category->jobs->count() }}</span>
            </a>
          </div>
          @endforeach
 
      </div>

    </div>
  </div>
</div>