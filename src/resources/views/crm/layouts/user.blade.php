@extends('layouts.crm')

@section('title')
@yield('subtitle', trans('user.profile')) | {{ $user->name }}
@endsection

@section('contents')
@include('users.partials.breadcrumb')
<div class="pull-right" style="margin-top: -8px">
    @yield('action-buttons')
</div>
@include('users.partials.nav-tabs')
@yield('content-user')
@endsection
