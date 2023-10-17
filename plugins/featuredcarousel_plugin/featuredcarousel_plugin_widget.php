<div class="feature_slider_banner owl-carousel">
    <?php foreach ($featuredcarousels as $carousel) : ?>
    <div class="item">
        <div class="feature_s_item">
            <div class="image"><img src="<?=base_url($carousel['featuredcarousel_image'])?>" alt=""></div>
            <!-- <a href="<?php echo $carousel['featuredcarousel_link'] ?>"><h5><?php echo $carousel['featuredcarousel_title'] ?></h5></a> -->
        </div>
    </div>
    <?php endforeach ?>
</div>

<script>
$(document).ready(function() {
    function feature_slider_banner() {
        var $featureSliderDiv = $('.feature_slider_banner');
        if ($featureSliderDiv.length && $.fn.owlCarousel) {
            $featureSliderDiv.owlCarousel({
                loop: true,
                margin: 0,
                items: 1,
                nav: true,
                autoplay: true,
                smartSpeed: 1500,
                dots: true,
                navText: ['<i class="fa fa-angle-left"></i>', '<i class="fa fa-angle-right"></i>'],
                responsiveClass: true,
                responsive: {
                    0: {
                        items: 1,
                    },
                    600: {
                        items: 1,
                    },
                    992: {
                        items: 1,
                    }
                }
            });
        }
    }
    feature_slider_banner();
});
</script>

<style>
    .feature_slider_banner .owl-nav {
        display: none;
    }

    .feature_slider_banner img {
        width: auto;
    }
</style>