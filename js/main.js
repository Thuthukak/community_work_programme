(function($) {
    "use strict";

    // language switcher
    var currentLanguage = document.documentElement.lang;
    $( ".language" ).on( "click", function( event ) {
        var currentId = $(this).attr('id');
        event.preventDefault();
        let selectedLang = $(this).data('locale');

        $.ajax({
            url: window.appUrl+'/switchLang/' + selectedLang,
            type: 'GET',
            success: function(response)
            {
                location.href = window.location.href;
                $('#langSwitcher').text($(this).text())
            }
        });
    });

    $(document).ready( function () {

        //remove owl-nav
        $( ".owl-nav" ).remove();

        let url = window.location.href;
        if (url.includes('login') || url.includes("register") || url.includes("password/reset")){
            $( ".footerContent" ).remove();
        }


        //knowledge base search
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $("form#btnSearch").on('submit',function(e){
            e.preventDefault();

            let search = $("input[name=search]").val();

            $.ajax({
                type:'post',
                url: window.appUrl+'/knowledge-search',
                data:{search:search},
                success:function(data){
                    $("#showSearch").html(data.posts)
                }
            });
        });



    });

    //animation
    AOS.init({
        // Global settings:
        disable: false, // accepts following values: 'phone', 'tablet', 'mobile', boolean, expression or function
        startEvent: 'DOMContentLoaded', // name of the event dispatched on the document, that AOS should initialize on
        initClassName: 'aos-init', // class applied after initialization
        animatedClassName: 'aos-animate', // class applied on animation
        useClassNames: false, // if true, will add content of `data-aos` as classes on scroll
        disableMutationObserver: false, // disables automatic mutations' detections (advanced)
        debounceDelay: 50, // the delay on debounce used while resizing window (advanced)
        throttleDelay: 99, // the delay on throttle used while scrolling the page (advanced)


        // Settings that can be overridden on per-element basis, by `data-aos-*` attributes:
        offset: 120, // offset (in px) from the original trigger point
        delay: 0, // values from 0 to 3000, with step 50ms
        duration: 400, // values from 0 to 3000, with step 50ms
        easing: 'ease', // default easing for AOS animations
        once: false, // whether animation should happen only once - while scrolling down
        mirror: false, // whether elements should animate out while scrolling past them
        anchorPlacement: 'top-bottom', // defines which position of the element regarding to window should trigger the animation

    });



})(jQuery);