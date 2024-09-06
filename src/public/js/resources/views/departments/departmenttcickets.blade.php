@extends('dashboard.master')
@inject('permission', 'App\Http\Controllers\PermissionController')

@section('title', __('theme.department_tickets'))

@section('main-section')
    <!-- Main content -->
    <div class="container-fluid">
        @if($permission->manageTicket() == 1)
        <h4 class="page-title">#{{ $tickets[0]['department']['title'] }} {{ __('theme.department_tickets') }}
            <a href="{{ route('department.index') }}" class="btn btn-primary btn-md pull-right">{{ __('theme.back') }}</a>
        </h4>
        <div class="row">
            <div class="col-md-12">
                <div class="card" id="deptID" data-dept="{{ $tickets[0]['department']['id'] }}">
                    @include('departments.ticket-table')
                </div>
                <!-- /.box -->
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
        @else
            <div class="callout callout-warning">
                <h4>{{ __('theme.access_denied') }}</h4>

                <p>{{ __("theme.don't_have_permission") }}</p>
            </div>
        @endif
    </div>
    <!-- /.content -->

@endsection