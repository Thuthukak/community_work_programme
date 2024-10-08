@extends('layouts.home')
@section('title', 'Dashboard 1')

@section('style')

@section('contents')

@include('tickets.banner')

    <div class="container">
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

                         <a href="{{ route('organizations.edit', $organization->id) }}">
                            {{ $organization->name }}
                        </a>
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
                    <a href="{{ route('opportunities')}}"> Show More </a>
                </div>
            </div>
        
    @endif

    @endsection