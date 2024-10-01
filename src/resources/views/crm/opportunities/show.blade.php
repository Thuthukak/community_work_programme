@extends('layouts.home')

@section('title', 'Opportunity')

@section('style')

@section('contents')

  <div style="height: 94px;"></div>

<div class="unit-5 overlay" style="background-image: url({{ asset('external/images/hero_2.jpg') }});">
  <div class="container text-center">
    <h1 class="mb-0" style="    color: #fff;
    font-size: 1.5rem;">{{$opportunity->title}}</h1>
    <p class="mb-0 unit-6"><a href="/">Home</a> <span class="sep"> > <a href="{{ route('alljobs') }}">opportunities</a> </span> <span><span class="sep m-0"> ></span> Opportunity details</span></p>
  </div>
</div>
<div class="site-section bg-light">
  <div class="container">
    <div class="row">
      <div class="col-lg-12">
        @if (Session::has('opportunitymsg'))
        <div class="p-2 bg-white mb-2">
          <div class="alert alert-success mt-3 alert-dismissible fade show" role="alert">
              <strong>That's Awesome !</strong> {{ Session::get('opportunitymsg') }}
              <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>

        </div>
          
        @endif

        @if (Session::has('error_msg'))
        <div class="p-2 bg-white mb-2">
          <div class="alert alert-danger mt-3 alert-dismissible fade show" role="alert">
              <strong>Error !</strong> {{ Session::get('error_msg') }}
              <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>

        </div>
          
        @endif

        @if (isset($errors) && count($errors) > 0)
          <div class="p-2 bg-white mb-2">
            <div class="alert alert-danger mt-3 alert-dismissible fade show" role="alert">
               <ul>
                @foreach ($errors->all() as  $error)
                  <li>{{ $error }}</li>
                @endforeach
               </ul>
               <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>

          </div>
        @endif


      </div>
    </div>
    <div class="row">
   
      <div class="col-md-12 col-lg-8 mb-5">
      
        
      
        <div class="p-5 bg-white">

          <div class="mb-4 mb-md-4 mr-5">
           <div class="opportunity-post-item-header d-flex align-items-center">
             <h2 class="mr-3 text-black h4">{{$opportunity->position}}</h2>
             <div class="badge-wrap">
              <span class="border border-warning text-warning py-2 px-4 rounded">{{Str::ucfirst($opportunity->type)}}</span>
              <span class="border ml-3 bg-primary border-primary text-white py-2 px-4 rounded"><a href="#"data-toggle="modal" data-target="#recomend-opportunity-modal"><i class="icon-envelope-o" style="font-size: 20px;color:#fff"></i></a></span>
             </div>
           </div>
           <div class="opportunity-post-item-body d-block d-md-flex">
             <div class="mr-3"><span class="fl-bigmug-line-portfolio23"></span> <a href="#">Office address:</a></div>
             <div><span class="fl-bigmug-line-big104"></span> <span>{{$opportunity->address}}</span></div>
           </div>
          </div>


        
          <div class=" mb-8 bg-white">
            <!-- icon-book mr-3-->
            <h3 class="h5 text-black mb-3"><i class="icon-library_books" style="color: #28a745;">&nbsp;</i>Description </a></h3>
            <p> {{$opportunity->description}}</p>
            
          </div>
    
          <div class=" mb-8 bg-white">
            <!--icon-align-left mr-3-->
            <h3 class="h5 text-black mb-3"><i class="icon-user" style="color: #28a745;">&nbsp;</i>Roles and Responsibilities</h3>
            <p>{{$opportunity->roles}} .</p>
            
          </div>
          <div class=" mb-8 bg-white">
            <h3 class="h5 text-black mb-3"><i class="icon-users" style="color: #28a745;">&nbsp;</i>Number of vacancy</h3>
            <p> </p>
            
          </div>
          <div class=" mb-8 bg-white">
            <h3 class="h5 text-black mb-3"><i class="icon-clock-o" style="color: #28a745;">&nbsp;</i>Experience</h3>
            <p>{{$opportunity->experience}}&nbsp;years</p>
            
          </div>
          <div class=" mb-8 bg-white">
            <h3 class="h5 text-black mb-3"><i class="icon-genderless" style="color: #28a745;">&nbsp;</i>Gender</h3>
            <p> {{  Str::ucfirst($opportunity->gender)}}</p>
            
          </div>
          <div class=" mb-8 bg-white">
            <h3 class="h5 text-black mb-3"><i class="icon-money" style="color: #28a745;">&nbsp;</i>Salary</h3>
            <p>${{$opportunity->salary}}</p>
          </div>
      
 

        </div>
      </div>

      <div class="col-lg-4">
        
        
        <div class="p-4 mb-3 bg-white">
          <h3 class="h5 text-black mb-3">Short Opportunity Info</h3>
            <p>Company name: {{$opportunity->organization->name ?? ''}}</p>
            <p>Address: {{$opportunity->address}}</p>
            <p>Employment Type: {{  Str::ucfirst($opportunity->type)}}</p>
            <p>Position: {{  Str::ucfirst($opportunity->position)}}</p>
            <p>Posted: {{$opportunity->created_at->diffForHumans()}}</p>
            <p>Last date to apply: {{ date('F d, Y', strtotime($opportunity->last_date)) }}</p>


            @if (Auth::check())

                  @if (!$opportunity->checkApplication())
                  <p>
                  <li class="nav-item nl-border">
                    <a class="btn btn-dark" href="javascript:void(0);" data-toggle="modal" data-target="#applyModal" style="width: 100%;">Apply For Opportunity.</a>
                </li>
                  </p>
                
                  @else
                      <p> <button type="button" class="w-100 text-black btn btn-warning " disabled>Already applied</button></p>
                  @endif

                  <p> 
                    <favorite-component :opportunityid="{{ $opportunity->id }}" :favorited="{{ $opportunity->checkSaved() ? 'true' : 'false' }}"></favorite-component>
                  </p>

          

            @endif

            @if (!Auth::check() )

                 <p>
                  <li class="nav-item nl-border">
                    <a class="btn btn-dark" href="javascript:void(0);" data-toggle="modal" data-target="#loginModal" style="width: 100%;">For apply need to Register/Login.</a>
                </li>
                  </p>

            @endif
          {{-- <p><a href="#" class="btn btn-primary  py-2 px-4">Apply Opportunity</a></p> --}}
        </div>
      </div>
    </div>
  </div>
</div>

@include('auth.register')
@include('auth.loginModal')
@include('Apply.apply')


@if (count($opportunityRecommendation) > 0)
  

  <div class="site-section bg-light pt-0">
    <div class="container">
      <div class="row">

        <div class="col-md-12 block-16" data-aos="fade-up" data-aos-delay="200">
          <div class="d-flex mb-0">
            <h2 class="mb-5 h3 mb-0">Recommended Opportunitys</h2>
            <div class="ml-auto mt-1"><a href="#" class="owl-custom-prev">Prev</a> / <a href="#" class="owl-custom-next">Next</a></div>
          </div>

          <div class="nonloop-block-16 owl-carousel">

            @foreach ($opportunityRecommendation as $recommendopportunity)
              
          
            <div class="border rounded p-4 bg-white">
              <h2 class="h5">{{ $recommendopportunity->title }}</h2>
              <p><span class="
                border rounded p-1 px-2
                @if($recommendopportunity->type =='fulltime')         
                text-info  border-info
                @elseif($recommendopportunity->type =='freelance') 
                text-warning   border-warning
                @elseif($recommendopportunity->type =='partime')   
                text-danger   border-danger
                
                @elseif($recommendopportunity->type =='remote')   
                text-dark   border-dark
                @endif

                ">{{Str::ucfirst($recommendopportunity->type)}}</span></p>
              <p>
                <span class="d-block"><span class="icon-suitcase"></span> {{ Str::limit($recommendopportunity->position, 30)}}</span>
                <span class="d-block"><span class="icon-room"></span> {{ Str::limit($recommendopportunity->address, 30)}}</span>
                <span class="d-block"><span class="icon-money mr-1"></span>Salary: ${{$recommendopportunity->salary}}</span>
              </p>
              <p class="mb-0">{{$recommendopportunity->roles}}</p>

              <a href="{{ route('opportunity.show', [$recommendopportunity->id, $recommendopportunity->slug]) }}"><button class="btn btn-success btn-sm mt-4">Apply this Opportunity</button></a>
            </div>
          
            @endforeach
        


          </div>

        </div>
      </div>
    </div>
  </div>

@endif

  <!-- Opportunity Recomend Modal -->
  <div class="modal fade" id="recomend-opportunity-modal" tabindex="-1" role="dialog" aria-labelledby="login-modal" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content pb-4">
        <div class="modal-header mt-2 mb-2">
          <h5 class="modal-title" id="recomend-opportunity-modal">{{ __('Send opportunity to your friend.') }}</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="card">
          
              <div class="card-body">
                  <form method="POST" action="{{ route('mail') }}">
                      @csrf
                    
                      <input type="hidden" name="opportunity_id" value="{{ $opportunity->id }}">
                      <input type="hidden" name="opportunity_slug" value="{{ $opportunity->slug }}">
                      <input type="hidden" name="title" value="{{ $opportunity->title }}">
                      <input type="hidden" name="cname" value="{{$opportunity->organization}}">
                      <input type="hidden" name="position" value="{{$opportunity->position}}">

                      <div class="row mb-2">
                          <label for="your_name" class="col-md-12 col-form-label text-md-start">{{ __('Your name *') }}</label>
  
                          <div class="col-md-12">
                              <input id="your_name" type="text" class="form-control @error('your_name') is-invalid @enderror" name="your_name" value="{{ old('your_name') }}"  autocomplete="your_name" autofocus>
  
                              @error('your_name')
                                  <span class="invalid-feedback" role="alert">
                                      <strong>{{ $message }}</strong>
                                  </span>
                              @enderror
                          </div>
                      </div>

                      <div class="row mb-2">
                          <label for="your_email" class="col-md-12 col-form-label text-md-start">{{ __('Your email *') }}</label>
  
                          <div class="col-md-12">
                              <input id="your_email" type="email" class="form-control @error('your_email') is-invalid @enderror" name="your_email" value="{{ old('your_email') }}"  autocomplete="your_email" autofocus>
  
                              @error('your_email')
                                  <span class="invalid-feedback" role="alert">
                                      <strong>{{ $message }}</strong>
                                  </span>
                              @enderror
                          </div>
                      </div>
                      <div class="row mb-2">
                        <label for="friend_name" class="col-md-12 col-form-label text-md-start">{{ __('Your friend name *') }}</label>

                        <div class="col-md-12">
                            <input id="friend_name" type="text" class="form-control @error('friend_name') is-invalid @enderror" name="friend_name" value="{{ old('friend_name') }}"  autocomplete="friend_name" autofocus>

                            @error('friend_name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="row mb-2">
                      <label for="friend_email" class="col-md-12 col-form-label text-md-start">{{ __('Your friend email *') }}</label>

                      <div class="col-md-12">
                          <input id="friend_email" type="email" class="form-control @error('friend_email') is-invalid @enderror" name="friend_email" value="{{ old('friend_email') }}"  autocomplete="friend_email" autofocus>

                          @error('friend_email')
                              <span class="invalid-feedback" role="alert">
                                  <strong>{{ $message }}</strong>
                              </span>
                          @enderror
                      </div>
                  </div>
  
                      <div class="row mb-0">
                          <div class="col-md-12 ">
                              <button type="submit" class="btn btn-primary">
                                  {{ __('Mail this opportunity') }}
                              </button>
  

                          </div>
                      </div>
                  </form>
              </div>
          </div>
        </div>

      </div>
    </div>
  </div>
    <!-- Modal -->
  



@endsection


@section('script')
<!-- Include Flatpickr JS from cdnjs -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/flatpickr/4.6.6/flatpickr.min.js"></script>
<!-- bootstrap script -->
<script src="/src/public/assets/js/bootstrap.min.js"></script>
<script>
    $(document).ready(function() {
        // When the apply button is clicked
        $('.btn-dark').on('click', function() {
            // Fetch the opportunity data from the clicked element's data attributes or the current context
            const opportunity = {
                title: "{{ $opportunity->title }}",
                position: "{{ $opportunity->position }}",
                description: "{{ $opportunity->description }}",
                salary: "{{ $opportunity->salary }}",
                address: "{{ $opportunity->address }}",
                number_of_vacancy: "{{ $opportunity->number_of_vacancy }}"
            };

            // Populate the modal fields with the fetched data
            $('#opportunityTitle').val(opportunity.title);
            $('#opportunityPosition').val(opportunity.position);
            $('#opportunityDescription').val(opportunity.description);
            $('#opportunitySalary').val(opportunity.salary);
            $('#opportunityAddress').val(opportunity.address);
            $('#opportunityVacancies').val(opportunity.number_of_vacancy);

            // Open the modal
            $('#applyModal').modal('show');
        });
    });


</script>

