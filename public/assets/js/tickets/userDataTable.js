(function($) {
    "use strict";

    $(document).ready(function() {

        $('#data_table').DataTable({
            order: [ [0, 'desc'] ],
            "processing": true,
            "serverSide": true,
            "fixedHeader": {
                "headerOffset": $('.main-header').outerHeight()
            },
            "ajax": {
                url: window.appUrl+"/users",
            },
            "columns":[
                { "data": "id" },
                { "data": "name" },
                { "data": "email" },
                { "data": "tickets" },
                {  data: 'action', name: 'action', orderable: false, searchable: false}
            ]
        });
    });

})(jQuery);