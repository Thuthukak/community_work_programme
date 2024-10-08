(function($) {
    "use strict";

    $(document).ready(function() {

        let kbDepartment, kbPinned,kbStatus;

        let datatableSubmit = $('#data_table').DataTable({
            order: [ [0, 'desc'] ],
            "processing": true,
            "serverSide": true,
            "fixedHeader": {
                "headerOffset": $('.main-header').outerHeight()
            },
            "ajax": {
                url: window.appUrl+"/knowledge-base",
                data: function (d) {
                    d.kbCategory = kbDepartment;
                    d.kbPinned = kbPinned;
                    d.kbStatus = kbStatus;
                }
            },
            "columns":[
                { "data": "id" },
                { "data": "title" },
                { "data": "content" },
                { data: "category", name: "department_id" },
                { "data": "view_count" },
                { data: "pinned_status", name: "pinned" },
                { data: "created_by", name: "user_id" },
                { data: "kb_status", name: "status" },
                {  data: 'action', name: 'action', orderable: false, searchable: false}
            ]
        });

        //filter
        $(document).on('change','#kbDepartment', function () {
            kbDepartment = $('#kbDepartment').val();
            datatableSubmit.draw();
        });
        $(document).on('change','#kbPinned', function () {
            kbPinned = $('#kbPinned').val();
            datatableSubmit.draw();
        });
        $(document).on('change','#kbStatus', function () {
            kbStatus = $('#kbStatus').val();
            datatableSubmit.draw();
        });

        // Delete product Ajax request.
        var deleteID;
        $(document).on('click', '#getDataDeleteId', function(){
            deleteID = $(this).data('id');
        });
        $(document).on('click','#SubmitDeleteForm',function(e) {
            e.preventDefault();
            $('.page-loader').removeClass('d-none');
            $('.alert-danger').html('');
            $('.alert-danger').hide();
            $('.alert-success').hide();
            var id = deleteID;
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: window.appUrl+"/kb-destroy/"+id,
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
                        $('#DeleteDataModal').hide();
                        $('.modal-backdrop').remove();
                        $('body').removeClass('modal-open');
                        toastr.success('Deleted Successfully');
                        location.reload()
                    }
                },
                error: function (error) {
                    $('.page-loader').addClass('d-none');
                }
            });
        });

    });

})(jQuery);