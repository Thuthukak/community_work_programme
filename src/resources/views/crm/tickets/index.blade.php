@extends('layouts.crm')

@section('title', 'Tickets')

@section('contents')
    <!-- Main content -->
    <div class="container-fluid">
        <h4 class="page-title">{{ __('theme.tickets') }}
            <a href="{{ route('submit-new-ticket.create') }}" target="_blank" class="btn btn-primary btn-md pull-right">{{ __('theme.add_new') }}</a>
        </h4>
        <div class="row">
            <div class="col-md-12">
                <div class="card" id="ticketType" data-type="all">
                    <!-- /.box-header -->
                    @include('crm.tickets.table', ['departments' => $departments])
                    <!-- /.box-body -->
                </div>
                <!-- /.box -->
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
            <div class="callout callout-warning">
                <h4>{{ __('theme.access_denied') }}</h4>

                <p>{{ __("theme.don't have permission") }}</p>
            </div>
    </div>
    <!-- /.content -->

@endsection