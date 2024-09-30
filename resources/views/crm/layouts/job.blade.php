@extends('layouts.crm')

@section('title')
@yield('subtitle', __('job.detail')) - {{ $job->name }}
@endsection

@section('contents')
@include('crm.jobs.partials.breadcrumb')

<h1 class="page-header d-flex justify-content-between align-items-center">
    <div>
        <h4 class="page-header-pill-layouts">{{ $job->name }}</h4>
    </div>
    <div class="action-buttons">
        @yield('action-buttons')
        {{ link_to_route('projects.jobs.index', __('job.back_to_index'), [$job->project_id, '#' . $job->id], ['class' => 'btn btn-info btn-sm']) }}
    </div>
</h1>

@include('crm.jobs.partials.nav-tabs')

@yield('content-job')

@endsection
