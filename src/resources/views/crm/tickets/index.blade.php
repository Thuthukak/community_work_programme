@extends('layouts.crm')

@section('title', 'Tickets')



@section('contents')
    <!-- Main content -->
    <div class="container-fluid mt-5">
        <div class="row">
            <div class="col-md-6">
        <h4 class="page-header-pill-layouts">{{ __('theme.tickets') }}</h4>
        </div>
        <div class="col-md-6">
            <div class="create-action-btns ml-auto">
                <button class="btn btn-primary" data-toggle="modal" data-target="#addTicketModal">
                    {{ __('theme.add_new') }}
                </button>
            </div>
        </div>
        </div>

        <div class="row">
            <div class="col-md-12 mt-3">

            <!-- filters for tickets table -->
                        <div class="">
                            
            <div class="row mb-2">
                    <div class="col-md-4 mb-2">
                        <select class="form-control" id="ticketDepartment">
                            <option value="all" selected>{{ __('theme.all_department') }}</option>
                            @foreach($departments as $department)
                                <option value="{{ $department->id }}">{{ $department->title }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4 mb-2">
                        <select class="form-control" id="ticketPriority">
                            <option value="all" selected>{{ __('theme.all_priority') }}</option>
                            <option value="low">{{ __('theme.low') }}</option>
                            <option value="medium">{{ __('theme.medium') }}</option>
                            <option value="medium">{{ __('theme.high') }}</option>
                        </select>
                    </div>
                    <div class="col-md-4 mb-2">
            <div id="reportrange" class="w-100 pointer pad-border">
                <i class="fa fa-calendar"></i>&nbsp;
                <span></span> <i class="fa fa-caret-down"></i>
            </div>
        </div>
    </div>

            </div>
                <div class="card" id="ticketType" data-type="all">
                    <!-- /.box-header -->
                    @include('crm.tickets.table', ['departments' => $departments])
                    <!-- /.box-body -->
                </div>
                <!-- /.box -->
            </div>
        </div>
        
       
    </div>
    <!-- /.content -->

    <!-- Modal -->
    <div class="modal fade" id="addTicketModal" tabindex="-1" role="dialog" aria-labelledby="addTicketModalLabel" aria-hidden="true">
        <div class="modal-dialog" style="max-width: 1000px !important;" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addTicketModalLabel">{{ __('theme.add_new_ticket') }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <!-- Include the form here, ensure the form has id="customerform" -->
                    @include('crm.tickets.create', ['departments' => $departments])
                </div>
                <div class="modal-footer">
                    <div class="row">
                        <div class="col-md-6">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('theme.close') }}</button>
                    </div>
                    <div class="col-md-6">
                    <button type="submit" form="customerform" class="btn btn-primary">{{ __('theme.submit') }}</button>
                    </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script src="src/public/tinymce/tinymce.min.js"></script>
<script src="src/public/tinymce/script.js"></script>

<link rel="stylesheet" type="text/css" href="src/public/tinymce/skins/lightgray/content.min.css">
<link rel="stylesheet" type="text/css" href="src/public/tinymce/skins/lightgray/skin.min.css">


    <script>
        $(document).ready(function() {
    // Initialize TinyMCE only when the modal is shown
    $('#addTicketModal').on('shown.bs.modal', function () {
        if (typeof tinymce !== 'undefined') {
            // Initialize TinyMCE only if it's not already initialized
            if (!tinymce.get('message')) {
                tinymce.init({
                    selector: '#message',
                    height: 200,
                    menubar: false,
                    plugins: [
                        'advlist autolink lists link image charmap print preview anchor',
                        'searchreplace visualblocks code fullscreen',
                        'insertdatetime media table paste code help wordcount'
                    ],
                    toolbar: 'undo redo | formatselect | bold italic backcolor | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | removeformat | help'
                });
            }
        } else {
            console.error('TinyMCE is not loaded!');
        }
    });

    // Destroy TinyMCE when the modal is hidden
    $('#addTicketModal').on('hidden.bs.modal', function () {
        if (tinymce.get('message')) {
            tinymce.remove('#message');
        }
    });
});

    </script>
@stop
