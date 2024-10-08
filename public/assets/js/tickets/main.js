(function ($) {
    "use strict";

    $(document).ready(function () {

        let url = window.location.href;
        let path = window.location.pathname;

        //sidebar menu active inactive
        if (url.includes('dashboard')) {
            $("#dashboard").addClass("active");
        } else if (url.includes('tickets') || url.includes('custom-fields')) {
            let element = document.getElementById("tickets");
            element.classList.remove("active");

            $("#tickets a").attr("aria-expanded", "true");
            $("#tickets a").addClass("collapsed");
            $("#submenuTickets").addClass("show");
            //$(".alltickets").addClass("active");
            $("#ticketsID").addClass("active");
        } else if (url.includes('closed-tickets')) {
            let element = document.getElementById("tickets");
            element.classList.remove("active");

            $("#tickets a").attr("aria-expanded", "true");
            $("#tickets a").addClass("collapsed");
            $("#submenuTickets").addClass("show");
            $(".closed-tickets").addClass("active");
            $("#ticketsID").addClass("active");
        } else if (url.includes('open-tickets')) {
            let element = document.getElementById("tickets");
            element.classList.remove("active");

            $("#tickets a").attr("aria-expanded", "true");
            $("#tickets a").addClass("collapsed");
            $("#submenuTickets").addClass("show");
            $(".opened-tickets").addClass("active");
            $("#ticketsID").addClass("active");
        } else if (url.includes('ticket')) {
            $("#tickets a").attr("aria-expanded", "true");
            $("#tickets a").addClass("collapsed");
            $("#submenuTickets").addClass("show");
            $("#ticketsID").addClass("active");

            // Summernote
            //$('.textarea').summernote();
        } else if (url.includes('departments')) {
            $("#department").addClass("active");
        } else if (url.includes('department')) {
            $("#department").addClass("active");
        } else if (url.includes('knowledge-base') || url.includes('knowledge-base-edit')) {
            $("#kb").addClass("active");
            let id = $('#editKB').data('id');

            if (url == appUrl + '/knowledge-base-edit/' + id) {
                //$('.textarea').summernote();
            }
            if (url == appUrl + '/knowledge-base-create') {
                //$('.textarea').summernote();
            }
        } else if (url.includes('staffs') || url.includes('staff')) {
            $("#staff").addClass("active");
        } else if (url.includes('roles') || url.includes('role')) {
            $("#roles").addClass("active");
        }  else if (url.includes('translations') || url.includes('translations/create')) {
            $("#langTranslations").addClass("active");
        } else if (url.includes('app-settings')) {
            $(".nav-item a").attr("aria-expanded", "true");
            $(".nav-item a").addClass("collapsed");
            $("#submenuSetting").addClass("show");
            $("#submenuSetting li:nth-child(1)").addClass("active");
            $("#appSettings").addClass("active");
        } else if (url.includes('email-settings')) {
            $(".nav-item a").attr("aria-expanded", "true");
            $(".nav-item a").addClass("collapsed");
            $("#submenuSetting").addClass("show");
            $("#submenuSetting li:nth-child(2)").addClass("active");
            $("#appSettings").addClass("active");
        } else if (url.includes('email-template')) {
            $(".nav-item #settings a").attr("aria-expanded", "true");
            $(".nav-item #settings a").addClass("collapsed");
            $("#submenuSetting").addClass("show");
            $("#submenuSetting li:nth-child(3)").addClass("active");
            $("#appSettings").addClass("active");
            let eID = $('#eTemp').data('id');
            if (url == appUrl + '/email-template/' + eID + '/edit') {
                //$('.textarea').summernote();
            }
        } else if (url.includes('aboutus')) {
            $(".nav-item #frontend a").attr("aria-expanded", "true");
            $(".nav-item #frontend a").addClass("collapsed");
            $("#submenuFrontend").addClass("show");
            $("#frontend li:nth-child(8)").addClass("active");
            $("#webSetting").addClass("active");
        } else if (url.includes('counter')) {
            $(".nav-item #frontend a").attr("aria-expanded", "true");
            $(".nav-item #frontend a").addClass("collapsed");
            $("#submenuFrontend").addClass("show");
            $("#frontend li:nth-child(6)").addClass("active");
            $("#webSetting").addClass("active");
        } else if (url.includes('footer-setting')) {
            $(".nav-item #frontend a").attr("aria-expanded", "true");
            $(".nav-item #frontend a").addClass("collapsed");
            $("#submenuFrontend").addClass("show");
            $("#frontend li:nth-child(9)").addClass("active");
            $("#webSetting").addClass("active");
        } else if (url.includes('header-text')) {
            $(".nav-item #frontend a").attr("aria-expanded", "true");
            $(".nav-item #frontend a").addClass("collapsed");
            $("#submenuFrontend").addClass("show");
            $("#frontend li:nth-child(3)").addClass("active");
            $("#webSetting").addClass("active");
        } else if (url.includes('how-we-work')) {
            $(".nav-item #frontend a").attr("aria-expanded", "true");
            $(".nav-item #frontend a").addClass("collapsed");
            $("#submenuFrontend").addClass("show");
            $("#frontend li:nth-child(4)").addClass("active");
            $("#webSetting").addClass("active");
        } else if (url.includes('logo-icon')) {
            $(".nav-item #frontend a").attr("aria-expanded", "true");
            $(".nav-item #frontend a").addClass("collapsed");
            $("#submenuFrontend").addClass("show");
            $("#frontend li:nth-child(1)").addClass("active");
            $("#webSetting").addClass("active");
        } else if (url.includes('service')) {
            $(".nav-item #frontend a").attr("aria-expanded", "true");
            $(".nav-item #frontend a").addClass("collapsed");
            $("#submenuFrontend").addClass("show");
            $("#frontend li:nth-child(5)").addClass("active");
            $("#webSetting").addClass("active");
        } else if (url.includes('social-link')) {
            $(".nav-item #frontend a").attr("aria-expanded", "true");
            $(".nav-item #frontend a").addClass("collapsed");
            $("#submenuFrontend").addClass("show");
            $("#frontend li:nth-child(2)").addClass("active");
            $("#webSetting").addClass("active");
        } else if (url.includes('testimonial')) {
            $(".nav-item #frontend a").attr("aria-expanded", "true");
            $(".nav-item #frontend a").addClass("collapsed");
            $("#submenuFrontend").addClass("show");
            $("#frontend li:nth-child(7)").addClass("active");
            $("#webSetting").addClass("active");
        } else if (url.includes('inbox') || url.includes('read-messgae')) {
            $("#inbox").addClass("active");
        } else if (url.includes('users')) {
            $("#users").addClass("active");
        }


        //knowledge base article pin unpin
        $(document).on("change", '.pinned-class', function (e) {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            //var status = $(this).prop('checked') == true ? 1 : 0;
            let id = $(this).data('id');

            $.ajax({
                type: "get",
                dataType: "json",
                url: window.appUrl + '/knowledge-pinned/' + id,
                success: function (data) {
                    toastr.success('Knowledge base pinned updated')

                },
                error: function (data) {
                    toastr.error('Knowledge base update failed!')
                }
            });
        })

        //email setting
        let driver = $("#emailDriver").val();
        emailSetting(driver)

        $(document).on('change', '#emailDriver', function () {
            let driver = $(this).val();
            emailSetting(driver)
        });

        function emailSetting(driver){
            if (driver === 'sendmail') {
                $("#smtpHost,#encryption,#smtpPort,#smtpUsername,#smtpPassword,#sparkpost,#sparkpost,#mandrill,#mailgunDomain,#mailgunApi").hide('slow');
            } else if (driver === 'mandrill') {
                $("#smtpHost,#encryption,#smtpPort,#smtpUsername,#smtpPassword,#sparkpost,#mailgunDomain,#mailgunApi").hide();
                $("#mandrill").show('slow');
            } else if (driver === 'mailgun') {
                $("#smtpHost,#encryption,#smtpPort,#smtpUsername,#smtpPassword,#mandrill,#sparkpost").hide();
                $("#mailgunDomain,#mailgunApi").show('slow');
            } else if (driver === 'sparkpost') {
                $("#smtpHost,#encryption,#smtpPort,#smtpUsername,#smtpPassword,#mandrill,#mailgunDomain,#mailgunApi").hide();
                $("#sparkpost").show('slow');
            } else if (driver === 'smtp'){
                $("#sparkpost,#mandrill,#mailgunDomain,#mailgunApi").hide();
                $("#smtpHost,#encryption,#smtpPort,#smtpUsername,#smtpPassword").show('slow');
            }
        }

        // notification read
            $("div[id^='notificationRead-']").click(function() {
                const id = $(this).data('nid');
                const ticketID = $(this).data('ticketid');

                $.ajax({  //create an ajax request to display.php
                    type: "GET",
                    url: window.appUrl + '/notification-read/' + id,
                    success: function (data) {
                        window.location = appUrl + '/ticket/'+ ticketID;
                    }
                });
            });

    });


})(jQuery);

function updateLanguageValue(key, id){
    let updateVal = document.getElementById(key+'-'+id).value//$('#'+key+'-'+id).val();

    axios.get(window.appUrl + `/translations/update/${id}/${updateVal}`).then(({data}) => {
        if(data.success) {
            toastr.success(data.message);
        } else {
            toastr.error(data.message);
        }
    })
}