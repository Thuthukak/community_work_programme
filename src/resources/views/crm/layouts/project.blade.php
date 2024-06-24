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
    <div  class="page-header-pill-layouts" style="justify-content:flex-start;
    align-items: center;
    padding: 0.5rem 0.5rem;
    border-radius: 9999px; 
    background-color: white;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
    padding:10px;
    display:inline-block;
    margin:20">
   <h4> {{ $project->name }} </h4>
    </div>
</h1>

@include('crm.projects.partials.nav-tabs')

@yield('content-project')

@endsection
