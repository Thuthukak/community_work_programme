@section('style')
    <!-- data table css -->
    <link rel="stylesheet" href="{{ asset('assets/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/fixedHeader.bootstrap.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/daterangepicker.css') }}" />
@stop

<div class="card-body table-responsive">
    <div class="row mb-2">
        <div class="col-md-4 mb-2">
            <select class="form-control" id="kbDepartment">
                <option value="all" selected>{{ __('theme.all_category') }}</option>
                @foreach($departments as $department)
                    <option value="{{ $department->id }}">{{ $department->title }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-4 mb-2">
            <select class="form-control" id="kbPinned">
                <option value="all" selected>{{ __('theme.all_pinned') }}</option>
                <option value="1">{{ __('theme.pinned') }}</option>
                <option value="0">{{ __('theme.unpinned') }}</option>
            </select>
        </div>
        <div class="col-md-4 mb-2">
            <select class="form-control" id="kbStatus">
                <option value="all" selected>{{ __('theme.status_all') }}</option>
                <option value="1">{{ __('theme.published') }}</option>
                <option value="0">{{ __('theme.unpublished') }}</option>
            </select>
        </div>
    </div>

    <table id="data_table" class="table table-bordered table-striped table-hover dataTable w-100">
        <thead>
            <tr>
                <th>{{ __('theme.sl_no') }}</th>
                <th>{{ __('theme.title') }}</th>
                <th>{{ __('theme.content') }}</th>
                <th>{{ __('theme.category') }}</th>
                <th>{{ __('theme.views') }}</th>
                <th>{{ __('theme.pinned') }}</th>
                <th>{{ __('theme.created_by') }}</th>
                <th>{{ __('theme.status') }}</th>
                <th>{{ __('theme.actions') }}</th>
            </tr>
        </thead>
    </table>
</div>

<!-- Delete Product Modal -->
<div class="modal" id="DeleteDataModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">{{ __('theme.delete') }}</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <!-- Modal body -->
            <div class="modal-body">
                <div class="alert alert-danger alert-dismissible fade show" role="alert" style="display: none;">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="alert alert-success alert-dismissible fade show" role="alert" style="display: none;">
                    <strong>{{ __('theme.success') }} </strong>{{ __('theme.deleted_successfully') }}.
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <h4>{{ __('theme.are_you_sure_you_want_to_delete') }}</h4>
            </div>
            <!-- Modal footer -->
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" id="SubmitDeleteForm">{{ __('theme.yes') }}</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">{{ __('theme.no') }}</button>
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

    <script src="{{ asset('assets/js/kbDataTable.js') }}"></script>
@endsection