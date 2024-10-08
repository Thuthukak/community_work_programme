@extends('layouts.home')

@section('title', 'Category Details')

@section('style')
    <style>
        .category-box {
            max-width: 500px;
            margin: 20px auto;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            padding: 20px;
            border-radius: 8px;
            background-color: #f9f9f9;
        }
    </style>
@endsection

@section('contents')

@include('tickets.banner')

<div class="container">
    <div class="category-box">
        <h4 class="text-center">{{ $categorie->name }}</h4>
        <p><strong>Slug:</strong> {{ $categorie->slug }}</p>
        <p><strong>Status:</strong> {{ $categorie->status == 1 ? 'Active' : 'Inactive' }}</p>
        <p><strong>Created At:</strong> {{ $categorie->created_at->format('Y-m-d H:i:s') }}</p>
        <p><strong>Updated At:</strong> {{ $categorie->updated_at->format('Y-m-d H:i:s') }}</p>
    </div>
</div>

@endsection
