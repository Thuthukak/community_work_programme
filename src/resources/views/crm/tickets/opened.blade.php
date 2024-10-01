@extends('layouts.crm')
@section('title', __('theme.open_tickets'))

@section('contents')
    <!-- Main content -->
    <div class="container-fluid">
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
            <div class="col-md-12">
                <div class="card" id="ticketType" data-type="Open">
                    @include('crm.tickets.table')
                    <!-- /.box-body -->
                </div>
                <!-- /.box -->
            </div>
            <!-- /.col -->
        </div>
    </div>
    <!-- /.content -->
    <!-- Add tickets Modal-->
    @include('crm.tickets.addTicket')

@endsection


@section('script')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<<script src="{{ asset('src/public/tinymce/tinymce.min.js') }}"></script>
<script src="{{ asset('src/public/tinymce/script.js')  }}"></script>

<link rel="stylesheet" type="text/css" href="{{ asset('src/public/tinymce/skins/lightgray/content.min.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('src/public/tinymce/skins/lightgray/skin.min.css') }}">


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
@endsection
