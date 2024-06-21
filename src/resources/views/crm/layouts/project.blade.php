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
    <div  class="page-header-pill-layouts">
   <h4> {{ $project->name }} </h4>
    </div>
</h1>

@include('crm.projects.partials.nav-tabs')

@yield('content-project')

@endsection
