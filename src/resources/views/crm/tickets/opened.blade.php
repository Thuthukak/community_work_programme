@extends('layout.crm')
@inject('permission', 'App\Http\Controllers\PermissionController')

@section('title', __('theme.open_tickets'))

@section('main-section')
    <!-- Main content -->
    <div class="container-fluid">
        @if($permission->manageTicket() == 1 || Auth::user()->user_type == 1)
        <h4 class="page-title">{{ __('theme.tickets') }}
            <span class="pull-right">
                <a href="{{ route('submit-new-ticket.create') }}" target="_blank" class="btn btn-primary btn-md pull-right">{{ __('theme.add_new') }}</a>
            </span>
        </h4>
        <div class="row">
            <div class="col-md-12">
                <div class="card" id="ticketType" data-type="Open">
                    @include('tickets.table', ['departments' => $departments])
                    <!-- /.box-body -->
                </div>
                <!-- /.box -->
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
        @else
            <div class="callout callout-warning">
                <h4>{{ __('theme.access_denied') }}</h4>

                <p>{{ __("theme.don't have permission") }}</p>
            </div>
        @endif
    </div>
    <!-- /.content -->

@endsection