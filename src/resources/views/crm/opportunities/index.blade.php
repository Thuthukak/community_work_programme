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

        </div>
 @endsection