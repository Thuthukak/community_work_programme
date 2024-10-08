@extends('layouts.home')
@section('title', 'Categories 1')

@section('style')

@section('contents')

@include('tickets.banner')

    <div class="container">
         <!-- Organizations Section -->
          <h2> All categories </h2>
        <div class="row">
            @if($categories->count())
                @foreach($categories as $category)
                <div class="col-md-4 mb-4">
                    <div class="card card-soft-shadow">
                        <div class="card-body">
                            <h5 class="card-title">{{ $category->name }}</h5>
                            <a href="{{ route('categorie.show', $category) }}">
                            {{ $category->name }}
                        </a>
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


    @endsection