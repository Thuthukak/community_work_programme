(function($){
    "use strict";

    var scroll = new SmoothScroll('a[href*="#"]');

    // Reviews slider
    $(".reviews .owl-carousel").owlCarousel({
        loop: true,
        margin: 35,
        nav: true,
        center: true,
        autoplay: true,
        navText: [
            '<i class="fa fa-angle-left"></i>',
            '<i class="fa fa-angle-right"></i>'
        ],
        responsive: {
            0: {
                items: 1
            },
            600: {
                items: 2
            },
            750: {
                items: 2
            },
            1000: {
                items: 3
            }
        }
    });

    // ===== Scroll to Top ====
    $(window).scroll(function() {
        if ($(this).scrollTop() >= 50) {        // If page is scrolled more than 50px
            $('#return-to-top').fadeIn(200);    // Fade in the arrow
        } else {
            $('#return-to-top').fadeOut(200);   // Else fade out the arrow
        }
    });
    $('#return-to-top').on('click',function() {      // When arrow is clicked
        $('body,html').animate({
            scrollTop : 0                       // Scroll to top of body
        }, 1500);


    });

    const dropdownItems = document.querySelectorAll('.dropdown-item');
        dropdownItems.forEach(item => {
            item.addEventListener('mouseenter', () => {
                item.style.backgroundColor = '#f8f9fa'; // Light background on hover
                item.style.color = 'black'; // Text color on hover
            });
            item.addEventListener('mouseleave', () => {
                item.style.backgroundColor = 'white'; // Reset background
                item.style.color = 'black'; // Reset text color
            });
        });
        
})(jQuery);
