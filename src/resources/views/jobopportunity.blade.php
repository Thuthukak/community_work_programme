@extends('layouts.home')
@section('title', 'Dashboard 1')

@section('style')
    <style>
        .section-title {
            margin: 30px 0;
            font-size: 2rem;
            font-weight: bold;
            color: #333;
        }

        .card-soft-shadow {
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1), 0 1px 2px rgba(0, 0, 0, 0.06);
            transition: transform 0.3s;
        }

        .card-soft-shadow:hover {
            transform: scale(1.02);
        }

        .no-data {
            text-align: center;
            font-style: italic;
            color: #777;
        }
    </style>
@endsection

@section('contents')
    <div class="container my-5">

<<<<<<< HEAD
        <!-- Opportunities Section -->
        <div class="row">
            <div class="col-12">
                <h2 class="section-title text-center">Opportunities</h2>
            </div>
=======
@include('tickets.banner')

    <div class="container">
    <!-- Opportunities Section -->
    <div class="row">
        <div class="col-12">
            <h2 class="text-center mb-4">Opportunities</h2>
>>>>>>> f1066b3603fa39fecfae7ba2b69b8c61443a3244
        </div>

        <div class="row">
            @if($Opportunities->count())
                @foreach($Opportunities as $opportunity)
                <div class="col-md-4 mb-4">
                    <div class="card card-soft-shadow">
                        <div class="card-body">
                            <h5 class="card-title">{{ $opportunity->title }}</h5>
                            <p class="card-text">{{ Str::limit($opportunity->description, 100) }}</p>
                            <p class="card-text"><strong>Roles:</strong> {{ $opportunity->roles }}</p>
                            <p class="card-text"><strong>Experience:</strong> {{ $opportunity->experience }} years</p>
                            <p class="card-text"><strong>Company:</strong> {{ $opportunity->organization->name ?? 'N/A' }}</p>
                            <a href="{{ route('opportunity.show', $opportunity) }}" class=" btn-crm">Apply</a>
                        </div>
                    </div>
                </div>
                @endforeach
            @else
                <div class="col-12">
                    <p class="no-data">No opportunities available at the moment.</p>
                </div>
            @endif
        </div>

        <!-- Organizations Section -->
        <div class="row">
            <div class="col-12">
                <h2 class="section-title text-center">Organizations</h2>
            </div>
        </div>

        <div class="row" id="organization-list">
<<<<<<< HEAD
            @foreach($organizations as $organization)
                <div class="col-md-4 mb-4">
                    <div class="card card-soft-shadow">
                        <div class="card-body">
                            <h5 class="card-title">{{ $organization->name ?? 'No name available' }}</h5>
                            <p class="card-text"><strong>Address:</strong> {{ $organization->address ?? 'No address available' }}</p>
                        </div>
=======
        @foreach($organizations as $organization)
            <div class="col-md-4">
                <div class="card mb-4">
                    <div class="card-body">

                         <a href="{{ route('organizations.edit', $organization->id) }}">
                            {{ $organization->name }}
                        </a>
                        <p class="card-text"><strong>Address:</strong> {{ $organization->address ?? 'No address available' }}</p>
>>>>>>> f1066b3603fa39fecfae7ba2b69b8c61443a3244
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Show More Button -->
        @if($organizations->count() >= 8)
            <div class="row">
                <div class="col-12 text-center">
                    <button id="load-more" class=" btn-crm">Show More</button>
                </div>
            </div>
        @endif

        <!-- Categories Section -->
        <div class="row">
            <div class="col-12">
                <h2 class="section-title text-center">Categories</h2>
            </div>
        </div>
<<<<<<< HEAD

        <div class="row">
            @if($categories->count())
                @foreach($categories as $category)
                <div class="col-md-4 mb-4">
                    <div class="card card-soft-shadow">
                        <div class="card-body">
                            <h5 class="card-title">{{ $category->name }}</h5>
                            <p class="card-text"><strong>Slug:</strong> {{ $category->slug }}</p>
                        </div>
                    </div>
                </div>
                @endforeach
            @else
                <div class="col-12">
                    <p class="no-data">No categories available at the moment.</p>
                </div>
            @endif
        </div>

        @if($categories->count() >= 8)
        <div class="row">
            <div class="col-12 text-center">
                <button id="load-more" class=" btn-crm">Show More</button>
            </div>
        </div>
        @endif

    </div>
@endsection
<style>
    .btn-crm {
        background-color: #ff740b;
        color: #fff;
        padding: 10px 20px;
        border-radius: 5px;
        font-weight: bold;
        cursor: pointer;
=======
    @endif
</div>
 @endsection
>>>>>>> f1066b3603fa39fecfae7ba2b69b8c61443a3244

    }
</style>