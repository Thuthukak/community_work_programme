(function($) {
    "use strict";

    $(document).ready(function() {

        let ticketType = $('#ticketType').data('type');
        let startDate, endDate,ticketDepartment,ticketPriority;

        let datatableSubmit = $('#data_table').DataTable({
            language: {
                searchPlaceholder: "Input Ticket ID"
            },
            order: [ [0, 'desc'] ],
            "processing": true,
            "serverSide": true,
            "fixedHeader": {
                "headerOffset": $('.main-header').outerHeight()
            },
            "ajax": {
                url: window.appUrl+"/get-ticket-data",
                data: function (d) {
                    d.startDate = startDate;
                    d.endDate = endDate;
                    d.ticketDepartment = ticketDepartment;
                    d.ticketType = ticketType;
                    d.ticketPriority = ticketPriority;
                }
            },
            "columns":[
                { "data": "id" },
                { data: "department", name: "department_id" },
                { "data": "ticket_id" },
                { data: "ticket_title", name: "title" },
                { data: "priority", name: "priority" },
                { data: "user_name", name: "user_id" },
                { data: "ticket_status", name: "status" },
                { data: "updated", name: "updated_at" },
                { data: 'action', name: 'action', orderable: false, searchable: false}
            ]
        });

        //filter
        $(function() {

            var start = moment().subtract(29, 'days');
            var end = moment();

            function cb(start, end) {
                $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));

                startDate = start.format('YYYY-MM-DD');
                endDate = end.format('YYYY-MM-DD');
                datatableSubmit.draw();
            }

            $('#reportrange').daterangepicker({
                startDate: start,
                endDate: end,
                ranges: {
                    'Today': [moment(), moment()],
                    'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                    'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                    'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                    'This Month': [moment().startOf('month'), moment().endOf('month')],
                    'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
                }
            }, cb);

            //cb(start, end);

        });

        $(document).on('change','#ticketDepartment', function () {
            ticketDepartment = $('#ticketDepartment').val();
            datatableSubmit.draw();
        });
        $(document).on('change','#ticketPriority', function () {
            ticketPriority = $('#ticketPriority').val();
            datatableSubmit.draw();
        });

        //modal assign department
        // Get single ticket department in EditModel
        $('.modelClose').on('click', function(){
            $('#TicketAssignedDepartmentModal').hide();
        });
        var id;
        $('body').on('click', '#getAssignedTicketData', function(e) {
            e.preventDefault();
            $('.page-loader').removeClass('d-none');
            $('.alert-danger').html('');
            $('.alert-danger').hide();
            id = $(this).data('id');
            $.ajax({
                url: window.appUrl+"/ticket-assign-to/"+id,
                method: 'GET',
                success: function(result) {
                    $('.page-loader').addClass('d-none');
                    $('#AssignedTicketModalBody').html(result.html);
                    $('#TicketAssignedDepartmentModal').show();
                }
            });
        });

        // Update department Ajax request.
        $('#SubmitTicketAssignedForm').click(function(e) {
            e.preventDefault();
            $('.page-loader').removeClass('d-none');
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: window.appUrl+"/ticket-assigned/"+id,
                method: 'post',
                data: {
                    department: $('#assignedDepartment').val(),
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
                        setInterval(function(){
                            $('.alert-success').hide();
                            $('#TicketAssignedDepartmentModal').hide();
                        }, 2000);
                    }
                }
            });
        });

    });

})(jQuery);