(function($) {
    "use strict";

    $(document).ready(function() {

        let datatableSubmit = $('#data_table').DataTable({
            order: [ [0, 'desc'] ],
            "processing": true,
            "serverSide": true,
            "fixedHeader": {
                "headerOffset": $('.main-header').outerHeight()
            },
            "ajax": {
                url: window.appUrl+"/get-custom-field-data",
            },
            "columns":[
                { "data": "id" },
                { "data": "name" },
                { "data": "type" },
                { "data": "required" },
                { "data": "status" },
                {  data: 'action', name: 'action', orderable: false, searchable: false}
            ]
        });

        //modal assign department
        // Get single ticket department in EditModel
        $('.modelClose').on('click', function(){
            $('.alert-success').hide();
            $('#EditCustomFieldModal').hide();
        });
        var id;
        $('body').on('click', '#getEditCustomFieldData', function(e) {
            e.preventDefault();
            $('.page-loader').removeClass('d-none');
            $('.alert-danger').html('');
            $('.alert-danger').hide();
            id = $(this).data('id');
            $.ajax({
                url: window.appUrl+"/custom-field/"+id+"/edit",
                method: 'GET',
                success: function(result) {
                    $('.page-loader').addClass('d-none');
                    $('#EditCustomFieldModalBody').html(result.html);
                    $('#EditCustomFieldModal').show();
                }
            });
        });

        // Update department Ajax request.
        $('#SubmitEditCustomFieldForm').click(function(e) {
            e.preventDefault();
            $('.page-loader').removeClass('d-none');
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: window.appUrl+"/custom-field-update/"+id,
                method: 'post',
                data: {
                    name: $('#title').val(),
                    type: $('#type').val(),
                    placeholder: $('#placeholder').val(),
                    field_length: $('#field_length').val(),
                    required: $('input[name="required"]:checked').val(),
                    status: $('input[name="status"]:checked').val(),
                },
                success: function(result) {
                    $('.page-loader').addClass('d-none');
                    if(result.errors) {
                        $('.alert-danger').html('');
                        $.each(result.errors, function(key, value) {
                            $('.alert-danger').show();
                            $('.alert-danger').append('<strong><li>'+value+'</li></strong>');
                        });
                    } else {
                        $('.alert-danger').hide();
                        $('.alert-success').show();
                        $('#data_table').DataTable().ajax.reload();
                    }
                }
            });
        });

        // Delete product Ajax request.
        var deleteID;
        $('body').on('click', '#getDeleteId', function(){
            deleteID = $(this).data('id');
        })
        $('#SubmitDeleteCustomFieldForm').click(function(e) {
            e.preventDefault();
            $('.page-loader').removeClass('d-none');
            $('.alert-danger').html('');
            $('.alert-danger').hide();
            var id = deleteID;
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: window.appUrl+"/custom-field-delete/"+id,
                method: 'DELETE',
                success: function(result) {
                    $('.page-loader').addClass('d-none');
                    if(result.error) {
                        $('.alert-danger').html('');
                        $('.alert-danger').show();
                        $('.alert-danger').append('<strong><li>'+result.error+'</li></strong>');
                    }else {
                        $('.alert-danger').hide();
                        $('.alert-success').show();
                        $('#data_table').DataTable().ajax.reload();
                        $('#DeleteCustomFieldModal').hide();
                        $('.modal-backdrop').remove();
                        toastr.success('Deleted Successfully');
                        location.reload()
                    }
                }
            });
        });

    });

})(jQuery);