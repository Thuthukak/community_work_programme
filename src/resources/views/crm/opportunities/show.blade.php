@extends('layouts.home')

@section('title', 'Opportunity')

@section('style')
  <!-- Add any additional CSS styling here -->
@endsection

@section('contents')


<!-- Header Section -->
<!-- <div class="unit-5 overlay" style="background-image: url({{ asset('external/images/hero_2.jpg') }});">
  <div class="container text-left">
    <h1 class="mb-0 text-white" style="font-size: 1.5rem;">{{$opportunity->title}}</h1>
    <p class="mb-0 unit-6"><a href="/">Home</a> <span class="sep"> > <a href="{{ route('alljobs') }}">Opportunities</a></span> <span> > Opportunity details</span></p>
  </div>
</div> -->

<!-- Main Content Section -->
<div class="site-section bg-light">
  <div class="container">
    <!-- Notifications Section -->
    <div class="row mb-4">
      <div class="col-lg-12">
        @if (Session::has('opportunitymsg'))
          <div class="alert alert-success mt-3 alert-dismissible fade show" role="alert">
            <strong>That's Awesome!</strong> {{ Session::get('opportunitymsg') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>
        @endif
        @if (Session::has('error_msg'))
          <div class="alert alert-danger mt-3 alert-dismissible fade show" role="alert">
            <strong>Error!</strong> {{ Session::get('error_msg') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>
        @endif
        @if ($errors && count($errors) > 0)
          <div class="alert alert-danger mt-3 alert-dismissible fade show" role="alert">
            <ul>
              @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
              @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>
        @endif
      </div>
    </div>

    <!-- Opportunity Details Section -->
    <div class="row">
      <div class="col-md-12 col-lg-8 mb-5">
        <div class="p-5 bg-white rounded">
          <!-- Opportunity Title -->
          <div class="mb-4">
            <h2 class="text-black h4 mb-3">{{$opportunity->position}}</h2>
            <div class="d-flex align-items-center">
              <span class="border border-warning text-warning py-2 px-4 rounded">{{Str::ucfirst($opportunity->type)}}</span>
              <!-- <span class="border ml-3 bg-primary text-white py-2 px-4 rounded"><a href="#" data-toggle="modal" data-target="#recomend-opportunity-modal"><i class="icon-envelope-o text-white" style="font-size: 20px;"></i></a></span> -->
            </div>
            <div class="mt-2">
              <span><i class="icon-map-marker"></i> {{$opportunity->address}}</span>
            </div>
          </div>

          <!-- Opportunity Description -->
          <div class="mb-4">
            <h3 class="h5 text-black mb-3"><i class="icon-book text-success"></i> Description</h3>
            <p>{{$opportunity->description}}</p>
          </div>

          <!-- Roles and Responsibilities -->
          <div class="mb-4">
            <h3 class="h5 text-black mb-3"><i class="icon-user text-success"></i> Roles and Responsibilities</h3>
            <p>{{$opportunity->roles}}</p>
          </div>

          <!-- Additional Information -->
          <div class="mb-4">
            <h3 class="h5 text-black mb-3"><i class="icon-users text-success"></i> Number of Vacancies</h3>
            <p>{{$opportunity->vacancies}}</p>
          </div>
          <div class="mb-4">
            <h3 class="h5 text-black mb-3"><i class="icon-clock-o text-success"></i> Experience</h3>
            <p>{{$opportunity->experience}} years</p>
          </div>
          <div class="mb-4">
            <h3 class="h5 text-black mb-3"><i class="icon-genderless text-success"></i> Gender</h3>
            <p>{{ Str::ucfirst($opportunity->gender) }}</p>
          </div>
          <div class="mb-4">
            <h3 class="h5 text-black mb-3"><i class="icon-money text-success"></i> Salary</h3>
            <p>${{$opportunity->salary}}</p>
          </div>
        </div>
      </div>

      <!-- Sidebar: Short Opportunity Info -->
      <div class="col-lg-4">
        <div class="p-4 mb-3 bg-white rounded">
          <h3 class="h5 text-black mb-3">Short Opportunity Info</h3>
          <p><strong>Company:</strong> {{$opportunity->organization->name ?? 'N/A'}}</p>
          <p><strong>Address:</strong> {{$opportunity->address}}</p>
          <p><strong>Employment Type:</strong> {{ Str::ucfirst($opportunity->type) }}</p>
          <p><strong>Position:</strong> {{ Str::ucfirst($opportunity->position) }}</p>
          <p><strong>Posted:</strong> {{$opportunity->created_at->diffForHumans()}}</p>
          <p><strong>Last Date to Apply:</strong> {{ date('F d, Y', strtotime($opportunity->last_date)) }}</p>

          @auth
            @if (!$opportunity->checkApplication())
              <a href="javascript:void(0);" class="btn btn-dark w-100" data-toggle="modal" data-target="#applyModal">Apply For Opportunity</a>
            @else
              <button class="btn btn-warning w-100" disabled>Already applied</button>
            @endif

            <favorite-component :opportunityid="{{ $opportunity->id }}" :favorited="{{ $opportunity->checkSaved() ? 'true' : 'false' }}"></favorite-component>
          @else
            <a href="javascript:void(0);" class="btn btn-dark w-100" data-toggle="modal" data-target="#loginModal">Register/Login to Apply</a>
          @endauth
        </div>
      </div>
    </div>

    <!-- Recommended Opportunities Section -->
    @if (count($opportunityRecommendation) > 0)
      <div class="site-section bg-light pt-0">
        <div class="container">
          <div class="row">
            <div class="col-md-12 block-16" data-aos="fade-up" data-aos-delay="200">
              <div class="d-flex mb-0">
                <h2 class="mb-5 h3 mb-0">Recommended Opportunities</h2>
                <div class="ml-auto mt-1">
                  <a href="#" class="owl-custom-prev">Prev</a> / <a href="#" class="owl-custom-next">Next</a>
                </div>
              </div>
              <div class="nonloop-block-16 owl-carousel">
                @foreach ($opportunityRecommendation as $recommendopportunity)
                  <div class="border rounded p-4 bg-white">
                    <h2 class="h5">{{ $recommendopportunity->title }}</h2>
                    <p class="mb-0">
                      <span class="d-block"><i class="icon-suitcase"></i> {{ Str::limit($recommendopportunity->position, 30)}}</span>
                      <span class="d-block"><i class="icon-room"></i> {{ Str::limit($recommendopportunity->address, 30)}}</span>
                      <span class="d-block"><i class="icon-money"></i> Salary: ${{$recommendopportunity->salary}}</span>
                    </p>
                    <a href="{{ route('opportunity.show', [$recommendopportunity->id, $recommendopportunity->slug]) }}" class="btn btn-success btn-sm mt-3">Apply this Opportunity</a>
                  </div>
                @endforeach
              </div>
            </div>
          </div>
        </div>
      </div>
    @endif
  </div>
</div>

@include('auth.register')
@include('auth.loginModal')
@include('Apply.apply')
@endsection
