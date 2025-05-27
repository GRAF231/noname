/**
 * File navigation.js.
 *
 * Handles toggling the navigation menu for small screens and enables TAB key
 * navigation support for dropdown menus.
 */
(function($) {
    'use strict';

    // Toggle mobile menu
    $('.menu-toggle').on('click', function() {
        $(this).toggleClass('active');
        $('.menu').toggleClass('active');
    });

    // Toggle submenu on mobile
    $('.menu-item-has-children > a').on('click', function(e) {
        if ($(window).width() < 768) {
            e.preventDefault();
            $(this).parent().toggleClass('active');
            $(this).parent().find('.sub-menu').slideToggle();
        }
    });

    // Add dropdown toggle to menu items with children
    $('.menu-item-has-children > a').append('<span class="dropdown-toggle"><i class="fas fa-chevron-down"></i></span>');

    // Toggle dropdown on click
    $('.dropdown-toggle').on('click', function(e) {
        e.preventDefault();
        e.stopPropagation();
        $(this).toggleClass('active');
        $(this).parent().next('.sub-menu').slideToggle();
    });

    // Close menu when clicking outside
    $(document).on('click', function(e) {
        if (!$(e.target).closest('.main-navigation').length) {
            $('.menu').removeClass('active');
            $('.menu-toggle').removeClass('active');
        }
    });

    // Sticky header
    var header = $('.site-header');
    var headerHeight = header.outerHeight();
    var scrollPosition = $(window).scrollTop();

    function stickyHeader() {
        scrollPosition = $(window).scrollTop();

        if (scrollPosition > headerHeight) {
            header.addClass('sticky');
            $('body').css('padding-top', headerHeight);
        } else {
            header.removeClass('sticky');
            $('body').css('padding-top', 0);
        }
    }

    $(window).on('scroll', function() {
        stickyHeader();
    });

    $(window).on('resize', function() {
        headerHeight = header.outerHeight();
        stickyHeader();
    });

    // Initialize sticky header
    stickyHeader();

    // Smooth scroll to anchors
    $('a[href*="#"]:not([href="#"])').on('click', function() {
        if (location.pathname.replace(/^\//, '') === this.pathname.replace(/^\//, '') && location.hostname === this.hostname) {
            var target = $(this.hash);
            target = target.length ? target : $('[name=' + this.hash.slice(1) + ']');
            if (target.length) {
                $('html, body').animate({
                    scrollTop: target.offset().top - headerHeight
                }, 1000);
                return false;
            }
        }
    });

    // Back to top button
    var backToTop = $('.back-to-top');

    $(window).on('scroll', function() {
        if ($(this).scrollTop() > 300) {
            backToTop.addClass('show');
        } else {
            backToTop.removeClass('show');
        }
    });

    backToTop.on('click', function(e) {
        e.preventDefault();
        $('html, body').animate({
            scrollTop: 0
        }, 800);
    });

    // Hero slider
    if ($('.hero-slider').length) {
        $('.hero-slider').slick({
            dots: true,
            arrows: true,
            infinite: true,
            speed: 500,
            fade: true,
            cssEase: 'linear',
            autoplay: true,
            autoplaySpeed: 5000,
            prevArrow: '<button type="button" class="slick-prev"><i class="fas fa-chevron-left"></i></button>',
            nextArrow: '<button type="button" class="slick-next"><i class="fas fa-chevron-right"></i></button>'
        });
    }

    // Products slider
    if ($('.products-slider').length) {
        $('.products-slider').slick({
            dots: false,
            arrows: true,
            infinite: true,
            speed: 500,
            slidesToShow: 4,
            slidesToScroll: 1,
            autoplay: true,
            autoplaySpeed: 5000,
            prevArrow: '<button type="button" class="slick-prev"><i class="fas fa-chevron-left"></i></button>',
            nextArrow: '<button type="button" class="slick-next"><i class="fas fa-chevron-right"></i></button>',
            responsive: [
                {
                    breakpoint: 1200,
                    settings: {
                        slidesToShow: 3
                    }
                },
                {
                    breakpoint: 992,
                    settings: {
                        slidesToShow: 2
                    }
                },
                {
                    breakpoint: 576,
                    settings: {
                        slidesToShow: 1
                    }
                }
            ]
        });
    }

    // Initialize WOW.js for animations
    if (typeof WOW !== 'undefined') {
        new WOW().init();
    }

})(jQuery);