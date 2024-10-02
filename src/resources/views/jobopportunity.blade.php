@extends('layouts.home')
@section('title', 'Dashboard 1')

@section('style')

@section('contents')

@include('tickets.banner')

    <div class="container">
    <!-- Opportunities Section -->
    <div class="row">
        <div class="col-12">
            <h2 class="text-center mb-4">Opportunities</h2>
        </div>
    </div>

    <div class="row">
        @if($Opportunities->count())
            @foreach($Opportunities as $opportunity)
            <div class="col-md-4">
                <div class="card mb-4">
                    <div class="card-body">
                        <h5 class="card-title">{{ $opportunity->title }}</h5>
                        <p class="card-text">{{ Str::limit($opportunity->description, 100) }}</p>
                        <p class="card-text"><strong>Roles:</strong> {{ $opportunity->roles }}</p>
                        <p class="card-text"><strong>Experience:</strong> {{ $opportunity->experience }} years</p>
                        <p class="card-text"><strong>Company:</strong> {{ $opportunity->company->name ?? 'N/A' }}</p>
                        <a href="{{ route('opportunity.show', $opportunity  ) }}" class="btn btn-primary">Apply</a>
                    </div>
                </div>
            </div>
            @endforeach
        @else
            <div class="col-12">
                <p class="text-center">No opportunities available at the moment.</p>
            </div>
        @endif
    </div>

    <!-- Organizations Section -->
    <div class="row">
        <div class="col-12">
            <h2 class="text-center mb-4">Organizations</h2>
        </div>
    </div>

        <div class="row" id="organization-list">
        @foreach($organizations as $organization)
            <div class="col-md-4">
                <div class="card mb-4">
                    <div class="card-body">
                        <h5 class="card-title">{{ $organization->name ?? 'No name available' }}</h5>
                        <p class="card-text"><strong>Address:</strong> {{ $organization->address ?? 'No address available' }}</p>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <!-- Show More Button -->
    @if($organizations->count() >= 8)
        <div class="row">
            <div class="col-12 text-center">
                <button id="load-more" class="btn btn-primary">Show More</button>
            </div>
        </div>
    @endif

    </div>


      <!-- Categories Section -->
      <div class="row">
        <div class="col-12">
            <h2 class="text-center mb-4">Categories</h2>
        </div>
        </div>

        <div class="row">
            @if($categories->count())
                @foreach($categories as $category)
                <div class="col-md-4">
                    <div class="card mb-4">
                        <div class="card-body">
                            <h5 class="card-title">{{ $category->name }}</h5>
                            <p class="card-text"><strong>Slug:</strong> {{ $category->slug }}</p>
                        </div>
                    </div>
                </div>
                @endforeach
            @else
                <div class="col-12">
                    <p class="text-center">No categories available at the moment.</p>
                </div>
            @endif
        </div>

        @if($categories->count() >= 8)
        <div class="row">
            <div class="col-12 text-center">
                <button id="load-more" class="btn btn-primary">Show More</button>
            </div>
        </div>
    @endif

    </div>
 @endsection

