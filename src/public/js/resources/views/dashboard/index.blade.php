@extends('dashboard.master')
@section('title', __('theme.dashboard'))

@section('main-section')
    @php
        $user = Auth::user();
    @endphp
    <div class="container-fluid">
        <h4 class="page-title">{{ __('theme.dashboard') }}</h4>
        @if($user->is_admin)
            @widget('DasboardCounterStatus')
        @endif

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h6>Monthly Tickets in {{ date('Y') }}</h6>
                    </div>
                    <div class="card-body">
                        <div id="chart"></div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h6>Department Wise Tickets</h6>
                    </div>
                    <div class="card-body">
                        <div id="donut-chart"></div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h6>Ticket Status Chart</h6>
                    </div>
                    <div class="card-body">
                        <div id="pie-chart"></div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="card" id="ticketType" @if($user->is_admin == 1 ||  $user->user_type == 1)data-type="open" @else data-type="all" @endif>
                    <div class="card-body table-responsive">
                        <div class="card-sub">
                            <h6>
                                @if($user->is_admin == 1 ||  $user->user_type == 1)
                                    {{ __('theme.open_tickets') }}
                                @else
                                    {{ __('theme.my_tickets') }}
                                @endif
                            </h6>
                        </div>
                            @include('tickets.table', ['departments' => $departments])
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('scripts')
<script src="{{ asset('assets/js/apexcharts.js') }}"></script>
<script>
    @php
        $monthName = array_keys($monthlyTickets);
        $monthValue = array_values($monthlyTickets);
    @endphp
    let currentYearMonthName = @json($monthName);
    let currentYearMonthValue = @json($monthValue);
    let departmentStatsTickets = @json(array_map('intval', $departmentStats['tickets']));
    let departmentStatsName = @json($departmentStats['name']);
    let ticketsStatusCount = @json(array_map('intval', $ticketsStats['count']));
    let ticketsStatusName = @json($ticketsStats['status']);

</script>

<script src="{{ asset('assets/js/dashboardReportCharts.js') }}"></script>
@endsection