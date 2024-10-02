@extends('layouts.crm')

@section('title')
@yield('subtitle', __('issue.detail')) 
@endsection

@section('contents')
<h1 class="page-header">
    <div class="pull-right">
        @yield('action-buttons')
    </div>
    <div>
   <h4 class="page-header-pill-layouts"> Actions </h4>
    </div>
</h1>


@yield('content-actions')
@yield('script')
@endsection


@section('ext_css')
@vite(['resources/css/plugins/jquery.datetimepicker.css'])
@endsection

@section('ext_js')

@endsection


