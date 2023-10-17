;
(function($) {
    "use strict";
    var navbar = $('.main_menu_area');
    var nav_offset_top = $('.main_menu_area').offset().top + 67;
    /*-------------------------------------------------------------------------------
      Navbar 
    -------------------------------------------------------------------------------*/
    navbar.affix({
        offset: {
            top: nav_offset_top,
        }
    });
    navbar.on('affix.bs.affix', function() {
        if (!navbar.hasClass('affix')) {
            navbar.addClass('animated slideInDown');
        }
    });
    navbar.on('affixed-top.bs.affix', function() {
        navbar.removeClass('animated slideInDown');
    });
    /*----------------------------------------------------*/
    /*  Main Slider js
    /*----------------------------------------------------*/
    function main_slider() {
        var $revSliderDiv = $('#main_slider');
        if ($revSliderDiv.length && $.fn.revolution) {
            $revSliderDiv.revolution({
                sliderType: "standard",
                sliderLayout: "auto",
                delay: 600000000,
                disableProgressBar: "on",
                navigation: {
                    onHoverStop: 'off',
                    touch: {
                        touchenabled: "on"
                    },
                    //                    arrows: {
                    //                        style: "Gyges",
                    //                        enable: true,
                    //                        hide_onmobile: false,
                    //                        hide_onleave: false,
                    //                        left: {
                    //                            h_align: "left",
                    //                            v_align: "top",
                    //                            h_offset: 385,
                    //                            v_offset: 170
                    //                        },
                    //                        right: {
                    //                            h_align: "left",
                    //                            v_align: "top",
                    //                            h_offset: 435,
                    //                            v_offset: 170
                    //                        }
                    //                    },
                    bullets: {
                        enable: false,
                        hide_onmobile: false,
                        style: "normal",
                        hide_onleave: false,
                        direction: "vertical",
                        h_align: "left",
                        v_align: "center",
                        h_offset: 45,
                        v_offset: 0,
                        space: 24,
                        tmp: '<span class="tp-bullet-inner"></span>'
                    }
                },
                responsiveLevels: [4096, 1199, 992, 767, 480],
                gridwidth: [1140, 970, 750, 700, 300],
                gridheight: [760, 760, 760, 500, 500],
                lazyType: "smart",
                fallbacks: {
                    simplifyAll: "off",
                    nextSlideOnWindowFocus: "off",
                    disableFocusListener: false,
                }
            });
        }
    }
    main_slider();
    /*----------------------------------------------------*/
    /*  Clients Slider2
    /*----------------------------------------------------*/
    function feature_slider() {
        var $featureSliderDiv = $('.feature_slider_inner');
        if ($featureSliderDiv.length && $.fn.owlCarousel) {
            $featureSliderDiv.owlCarousel({
                loop: true,
                margin: 0,
                items: 3,
                nav: true,
                autoplay: false,
                smartSpeed: 1500,
                dots: true,
                navText: ['<i class="fa fa-angle-left"></i>', '<i class="fa fa-angle-right"></i>'],
                responsiveClass: true,
                responsive: {
                    0: {
                        items: 1,
                    },
                    600: {
                        items: 2,
                    },
                    992: {
                        items: 3,
                    }
                }
            });
        }
    }
    feature_slider();
    /*----------------------------------------------------*/
    /*  Testimonials Slider
    /*----------------------------------------------------*/
    function testimonials_slider() {
        var $testSliderDiv = $('.testimonials_slider');
        if ($testSliderDiv.length && $.fn.owlCarousel) {
            $testSliderDiv.owlCarousel({
                loop: true,
                margin: 0,
                items: 1,
                nav: true,
                autoplay: false,
                smartSpeed: 1500,
                dots: true,
                navContainer: ".testimonials_inner",
                navText: ['<i class="fa fa-angle-left"></i>', '<i class="fa fa-angle-right"></i>'],
                responsiveClass: true,
                //                responsive: {
                //                    0: {
                //                        items: 1,
                //                    },
                //                    480: {
                //                        items: 2,
                //                    },
                //                    600: {
                //                        items: 4,
                //                    },
                //                    800: {
                //                        items: 6,
                //                    }
                //                }
            });
        }
    }
    testimonials_slider();
    /*----------------------------------------------------*/
    /*  Testimonials Slider
    /*----------------------------------------------------*/
    function client_slider() {
        var $clientSliderDiv = $('.client_slider');
        if ($clientSliderDiv.length && $.fn.owlCarousel) {
            $clientSliderDiv.owlCarousel({
                loop: true,
                margin: 20,
                items: 5,
                nav: false,
                autoplay: true,
                smartSpeed: 1500,
                dots: true,
                //                navContainer:".testimonials_inner",
                //                navText: ['<i class="fa fa-angle-left"></i>','<i class="fa fa-angle-right"></i>'],
                responsiveClass: true,
                responsive: {
                    0: {
                        items: 1,
                    },
                    400: {
                        items: 3,
                    },
                    600: {
                        items: 5,
                    }
                }
            });
        }
    }
    client_slider();
    /*----------------------------------------------------*/
    /*  Testimonials Slider
    /*----------------------------------------------------*/
    function team_slider() {
        var $teamSliderDiv = $('.our_team_slider');
        if ($teamSliderDiv.length && $.fn.owlCarousel) {
            $teamSliderDiv.owlCarousel({
                loop: true,
                margin: 30,
                items: 3,
                nav: false,
                autoplay: true,
                smartSpeed: 1500,
                dots: false,
                responsiveClass: true,
                responsive: {
                    0: {
                        items: 1,
                    },
                    400: {
                        items: 2,
                    },
                    600: {
                        items: 3,
                    }
                }
            });
        }
    }
    team_slider();
    /*----------------------------------------------------*/
    /*  Magnific Popup
    /*----------------------------------------------------*/
    var $zoomGalleryDiv = $('.zoom-gallery');
    if ($zoomGalleryDiv.length && $.fn.magnificPopup) {
        $zoomGalleryDiv.magnificPopup({
            delegate: 'a',
            type: 'image',
            closeOnContentClick: false,
            closeBtnInside: false,
            mainClass: 'mfp-with-zoom mfp-img-mobile',
            gallery: {
                enabled: true
            },
            zoom: {
                enabled: true,
                duration: 300, // don't foget to change the duration also in CSS
                opener: function(element) {
                    return element.find('img');
                }
            }
        });
    }

    // News video
    $('.kegiatan-item .video-news').first().removeClass('col-md-6').addClass('col-md-12 first-video');

    $('.simple-marquee-container').SimpleMarquee({
        duration:40000,
        autostart: true,
    });

})(jQuery);


