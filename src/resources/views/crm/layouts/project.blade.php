@extends('layouts.crm')

@section('title')
@yield('subtitle', __('project.detail')) - {{ $project->name }}
@endsection

@section('contents')
@include('crm.projects.partials.breadcrumb')

<h1 class="page-header">
    <div class="pull-right">
        @yield('action-buttons')
    </div>
    {{ $project->name }} <small>@yield('subtitle', __('project.detail'))</small>
</h1>

@include('crm.projects.partials.nav-tabs')

@yield('content-project')

@endsection
