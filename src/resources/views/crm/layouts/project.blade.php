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
@yield('script')
@endsection


@section('ext_css')
@vite(['resources/css/plugins/jquery.datetimepicker.css'])
@endsection

@section('ext_js')
@vite(['resources/js/plugins/jquery.datetimepicker.js'])
@endsection

    @stack('before-scripts')
    <script src="{{ asset('assets/js/plugins/jquery-ui.min.js') }}"></script>
    <script src="{{ asset('assets/js/bootstrap.min.js') }}"></script>
    <!-- <-- <script src="{{ asset('assets/js/sb-admin-2.js') }}"></script> --> 
    <script src="{{ asset('assets/js/plugins/jquery.datetimepicker.js') }}"></script> 
    <!-- <script src="{{ asset('assets/js/plugins/metisMenu/metisMenu.min.js') }}"></script> -->
    <!-- <script src="{{ asset('assets/js/plugins/select2.min.js') }}"></script> -->
    @stack('after-scripts')

