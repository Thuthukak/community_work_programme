@extends('layouts.crm')

@section('title')
@yield('subtitle', __('job.detail')) - {{ $job->name }}
@endsection

@section('contents')
@include('crm.jobs.partials.breadcrumb')

<h1 class="page-header d-flex justify-content-between align-items-center" style="margin:20px;">
    <div>
        <h4 class="page-header-pill-layouts" style="justify-content:flex-start;
    align-items: center;
    padding: 0.5rem 0.5rem;
    border-radius: 9999px; 
    background-color: white;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
    padding:10px;
    display:inline-block;">{{ $job->name }}</h4>
    </div>
    <div class="action-buttons" style="padding: 0.25rem 0.5rem; 
    font-size: 0.875rem;  
    margin-right:3px;  
    justify-content:center;">
        @yield('action-buttons')
        {{ link_to_route('projects.jobs.index', __('job.back_to_index'), [$job->project_id, '#' . $job->id], ['class' => 'btn btn-info btn-sm']) }}
    </div>
</h1>

@include('crm.jobs.partials.nav-tabs')

@yield('content-job')

@endsection
