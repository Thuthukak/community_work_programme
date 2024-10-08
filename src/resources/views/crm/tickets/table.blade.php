@section('style')
    <!-- data table css -->
    <link rel="stylesheet" href="{{ asset('assets/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/fixedHeader.bootstrap.min.css') }}">
    <link rel="stylesheet" type="text/css" href="src/public/assets/css/daterangepicker.css" />
@stop

<div class="datatable mt-5 ml-4 mr-4">
    <div class="table-responsive">
        <table style="width: 100%;">
            <thead>
                <tr style="border-bottom: 1px solid var(--default-border-color);">
                    <th class="datatable-th">{{ __('theme.sl_no') }}</th>
                    <th class="datatable-th">{{ __('theme.id') }}</th>
                    <th class="datatable-th">{{ __('theme.title') }}</th>
                    <th class="datatable-th">{{ __('theme.priority') }}</th>
                    <th class="datatable-th">{{ __('theme.user') }}</th>
                    <th class="datatable-th">{{ __('theme.status') }}</th>
                    <th class="datatable-th">{{ __('theme.last_updated') }}</th>
                    <th class="datatable-th">{{ __('theme.actions') }}</th>
                </tr>
            </thead>
            <tbody>
                @foreach($tickets as $index => $ticket)
                <tr>
                    <td class="datatable-td">{{ $index + 1 }}</td>
                    <td class="datatable-td">{{ $ticket->ticket_id }}</td>
                    <td class="datatable-td">{{ $ticket->title }}</td>
                    <td class="datatable-td">{{ $ticket->priority }}</td>
                    <td class="datatable-td">{{ $ticket->user->name ?? 'N/A' }}</td> <!-- Assuming 'user' relationship is defined -->
                    <td class="datatable-td">{{ $ticket->status }}</td>
                    <td class="datatable-td">{{ \Carbon\Carbon::parse($ticket->updated_at)->format('Y-m-d H:i:s') }}</td>
                    <td>
                        <a href="{{ route('ticket.show', $ticket->id) }}">
                            <i class="btn btn-primary btn-info fa fa-eye"></i>
                            </a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<!-- Edit Product Modal -->
<div class="modal" id="TicketAssignedDepartmentModal">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content shadow-lg p-3 mb-5 bg-white rounded">
            <!-- Modal Header -->
            <div class="modal-header">
                <h5 class="modal-title">{{ __('theme.change_or_assign') }}</h5>
                <button type="button" class="close modelClose" data-dismiss="modal">&times;</button>
            </div>
            <!-- Modal body -->
            <div class="modal-body">
                <div class="alert alert-danger alert-dismissible fade show" role="alert" style="display: none;">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="alert alert-success alert-dismissible fade show" role="alert" style="display: none;">
                    <strong>{{ __('theme.success') }} </strong>{{ __('theme.ticket_successfully_assigned') }}.
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div id="AssignedTicketModalBody">

                </div>
            </div>
            <!-- Modal footer -->
            <div class="modal-footer">
                <button type="button" class="btn btn-success" id="SubmitTicketAssignedForm">{{ __('theme.update') }}</button>
                <button type="button" class="btn btn-danger modelClose" data-dismiss="modal">{{ __('theme.close') }}</button>
            </div>
        </div>
    </div>
</div>

<!--page-loader-->
<div class="page-loader d-none">
    <div class="loader">
        <span class="dot dot_1"></span>
        <span class="dot dot_2"></span>
        <span class="dot dot_3"></span>
        <span class="dot dot_4"></span>
    </div>
</div>

@section('js')
    <!-- dataTables  -->
    <script src="{{ asset('assets/js/jquery.dataTables.min.js') }}"></script>
    <!-- bootstrap dataTables  -->
    <script src="{{ asset('assets/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('assets/js/dataTables.fixedHeader.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/js/moment.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/js/daterangepicker.min.js') }}"></script>

    <script src="src/public/assets/js/tickets/daterangepicker.min.js"></script>

    <script src="{{ asset('assets/js/dtMain.js') }}"></script>
@endsection