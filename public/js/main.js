(function ($) {
    "use strict";

    // Spinner
    var spinner = function () {
        setTimeout(function () {
            if ($('#spinner').length > 0) {
                $('#spinner').removeClass('show');
            }
        }, 1);
    };
    spinner(0);
    
    
    // Initiate the wowjs
    new WOW().init();


    // Sticky Navbar
    $(window).scroll(function () {
        if ($(this).scrollTop() > 45) {
            $('.navbar').addClass('sticky-top shadow-sm');
        } else {
            $('.navbar').removeClass('sticky-top shadow-sm');
        }
    });


    // Hero Header carousel
    $(".header-carousel").owlCarousel({
        animateOut: 'slideOutDown',
        items: 1,
        autoplay: true,
        smartSpeed: 1000,
        dots: false,
        loop: true,
        nav : true,
        navText : [
            '<i class="bi bi-arrow-left"></i>',
            '<i class="bi bi-arrow-right"></i>'
        ],
    });


    // International carousel
    $(".testimonial-carousel").owlCarousel({
        autoplay: true,
        items: 1,
        smartSpeed: 1500,
        dots: true,
        loop: true,
        margin: 25,
        nav : true,
        navText : [
            '<i class="bi bi-arrow-left"></i>',
            '<i class="bi bi-arrow-right"></i>'
        ]
    });


    // Modal Video
    $(document).ready(function () {
        var $videoSrc;
        $('.btn-play').click(function () {
            $videoSrc = $(this).data("src");
        });
        console.log($videoSrc);

        $('#videoModal').on('shown.bs.modal', function (e) {
            $("#video").attr('src', $videoSrc + "?autoplay=1&amp;modestbranding=1&amp;showinfo=0");
        })

        $('#videoModal').on('hide.bs.modal', function (e) {
            $("#video").attr('src', $videoSrc);
        })
    });


    // testimonial carousel
    $(".testimonial-carousel").owlCarousel({
        autoplay: true,
        smartSpeed: 1000,
        center: true,
        dots: true,
        loop: true,
        margin: 25,
        nav : true,
        navText : [
            '<i class="bi bi-arrow-left"></i>',
            '<i class="bi bi-arrow-right"></i>'
        ],
        responsiveClass: true,
        responsive: {
            0:{
                items:1
            },
            576:{
                items:1
            },
            768:{
                items:1
            },
            992:{
                items:1
            },
            1200:{
                items:1
            }
        }
    });

    
    
   // Back to top button
   $(window).scroll(function () {
    if ($(this).scrollTop() > 300) {
        $('.back-to-top').fadeIn('slow');
    } else {
        $('.back-to-top').fadeOut('slow');
    }
    });
    $('.back-to-top').click(function () {
        $('html, body').animate({scrollTop: 0}, 1500, 'easeInOutExpo');
        return false;
    });


})(jQuery);


// Mega menu interactions (mobile accordion + mobile open/close)
document.addEventListener('DOMContentLoaded', function () {
    var megaMenu = document.getElementById('productsMegaMenu');

    if (!megaMenu) {
        return;
    }

    var trigger = megaMenu.querySelector('.mega-menu__trigger');
    var categoryItems = megaMenu.querySelectorAll('.mega-menu__category');
    var categoryButtons = megaMenu.querySelectorAll('.mega-menu__category-toggle');

    var isMobile = function () {
        return window.matchMedia('(max-width: 991.98px)').matches;
    };

    var closeMegaMenu = function () {
        megaMenu.classList.remove('is-open');
        trigger.setAttribute('aria-expanded', 'false');
    };

    trigger.addEventListener('click', function (event) {
        if (!isMobile()) {
            return;
        }

        event.preventDefault();
        var openState = megaMenu.classList.toggle('is-open');
        trigger.setAttribute('aria-expanded', openState ? 'true' : 'false');
    });

    categoryButtons.forEach(function (button) {
        button.addEventListener('click', function () {
            if (!isMobile()) {
                return;
            }

            var category = button.closest('.mega-menu__category');
            var isOpen = category.classList.toggle('is-open');

            button.setAttribute('aria-expanded', isOpen ? 'true' : 'false');
        });
    });

    document.addEventListener('click', function (event) {
        if (!isMobile()) {
            return;
        }

        if (!megaMenu.contains(event.target)) {
            closeMegaMenu();
        }
    });

    window.addEventListener('resize', function () {
        if (!isMobile()) {
            closeMegaMenu();
            categoryItems.forEach(function (item) {
                item.classList.remove('is-open');
            });
            categoryButtons.forEach(function (button) {
                button.setAttribute('aria-expanded', 'false');
            });
        }
    });
});
