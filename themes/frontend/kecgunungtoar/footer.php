    <!-- question_contact_area -->
    <section class="question_contact_area">
        <div class="container">
            <div class="row box_wrapper">
                <div class="col-md-6 pull-left">
                    <h4>Punya pertanyaan, keluhan, kritikan atau saran?</h4>
                </div>
                <div class="col-md-6 pull-right">
                    <div class="img-box">
                        <img src="<?php echo $theme_url; ?>img/pengaduan-footer.png" alt="pengaduan-images" width="100">
                    </div>
                    <!-- <a class="more_btn" href="<?php echo site_url('konsultasi'); ?>">Layanan Konsultasi</a> -->
                    <a class="more_btn" href="<?php echo site_url('pengaduan'); ?>">Layanan Pengaduan</a>
                </div>
            </div>
        </div>
    </section>

    <!-- <section class="main_running_text">
        <div class="simple-marquee-container">
            <div class="marquee-sibling">
                Konsultasi & Pengaduan
            </div>
            <div class="marquee">
                <ul class="marquee-content-items">
                    <?php $limit = 8 ?>
                    <?php $posts = query_pengaduan(array('limit' => $limit, 'offset' => $offset)); ?>
                    <?php if ($posts) : foreach ($posts as $post) : ?>
                            <li><a href="<?php echo $post['url']; ?><?php echo $post['id']; ?>"><?php echo $post['content']; ?></a></li>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </section> -->

    <!--================Footer Area =================-->
    <footer class="footer_area">
        <div class="footer_widget_area">
            <div class="container">
                <div class="row">
                    <div class="col-md-4">
                        <aside class="f_widget about_widget" style="margin-bottom: 30px">
                            <?php if ($theme_option) : ?>
                                <img src="<?php echo base_url($theme_option['about_us_image']); ?>" alt="">
                                <p><?php echo html_entity_decode($theme_option['about_us_description']) ?></p>
                                <div class="contact_info">
                                    <span>Telp : <?php echo $general['id']['website_phone'] ?></span>
                                    <span>Email : <?php echo $general['id']['website_email'] ?></span>
                                    <span>Media Sosial : </span>
                                    <?php if (isset($theme_option['about_us_social'])) : ?>
                                        <ul class="social-icons">
                                            <?php foreach ($theme_option['about_us_social'] as $social) : ?>
                                                <li><a href="<?php echo $social['social_url'] ?>" target="blank"><i class="<?php echo $social['social_icon'] ?>" aria-hidden="true"></i></a></li>
                                            <?php endforeach ?>
                                        </ul>
                                    <?php endif ?>
                                <?php endif ?>
                                </div>
                        </aside>
                    </div>
                    <div class="col-md-3">
                        <div class="f_widget link_widget" style="margin-bottom: 30px">
                            <h3 class="foote_sub_heading">Unduh Dokumen</h3>
                            <ul>
                                <li><a href="<?= base_url('id/download/renstra') ?>">Renstra</a></li>
                                <li><a href="<?= base_url('id/download/renja') ?>">Renja</a></li>
                                <li><a href="<?= base_url('id/download/produk-hukum') ?>">Produk Hukum</a></li>
                                <li><a href="<?= base_url('id/download/dokumen-lainnya') ?>">Dokumen Lainnya</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-md-5">
                        <aside class="f_widget link_widget" style="margin-bottom: 30px">
                            <h3 class="foote_sub_heading">Alamat Kantor</h3>
                            <div id="footer-map" style="width: 100%; height: 250px; margin-bottom: 10px;border-radius:10px;overflow:hdden;">
                                <div class=" mapouter">
                                    <div class="gmap_canvas">
                                        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2372.2364996916576!2d101.50748609612087!3d-0.5850281516267976!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e2a52b3ffcf8625%3A0x3be1d06b215e16f1!2sKantor%20Camat%20Gunung%20Toar!5e0!3m2!1sen!2sid!4v1686888972293!5m2!1sen!2sid" width="100%" height="230" style="border:0;border-radius:10px" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                                    </div>
                                    <style>
                                        .mapouter {
                                            position: relative;
                                            text-align: right;
                                            height: 250px;
                                            width: 100%;
                                        }

                                        .gmap_canvas {
                                            overflow: hidden;
                                            background: none !important;
                                            height: 300px;
                                            width: 100%;
                                        }
                                    </style>
                                </div>
                            </div>
                        </aside>
                    </div>
                </div>
            </div>
        </div>
        <div class="footer_copy_right">
            <div class="container">
                <h4> &copy; <?php echo date('Y'); ?> <a href="<?php echo base_url(); ?>">Kecamatan Gunung Toar</a>.<br>Powered By Diskominfoss Kabupaten Kuantan Singingi</h4>
            </div>
        </div>
    </footer>
    <!--================End Footer Area =================-->

    <!-- Extra Plugin js -->
    <script src="<?php echo $theme_url; ?>vendors/owl-carousel/owl.carousel.min.js" type="text/javascript"></script>
    <script src="<?php echo $theme_url; ?>vendors/magnific-popup/jquery.magnific-popup.min.js" type="text/javascript"></script>
    <script src="<?php echo $theme_url; ?>js/jquery.fancybox.min.js" type="text/javascript"></script>
    <script src="<?php echo $theme_url; ?>js/marquee.js" type="text/javascript"></script>
    <script src="<?php echo $theme_url; ?>vendors/glider-slider/glider.min.js" type="text/javascript"></script>
    <!-- Main js -->
    <script src="<?php echo $theme_url; ?>js/script.js" type="text/javascript"></script>
    <script>
        new Glider(document.querySelector(".glider"), {
            slidesToScroll: 1,
            slidesToShow: 4,
            draggable: true,
            dots: ".dots",
            arrows: {
                prev: ".glider-prev",
                next: ".glider-next",
            },
            responsive: [{
                    breakpoint: 1200,
                    settings: {
                        slidesToShow: 3.2,
                        slidesToScroll: 1,
                    },
                },
                // {
                //     breakpoint: 900,
                //     settings: {
                //         slidesToShow: 3,
                //         slidesToScroll: 1,
                //     },
                // },
                {
                    breakpoint: 768,
                    settings: {
                        slidesToShow: 3,
                        slidesToScroll: 1,
                    },
                },
                {
                    breakpoint: 576,
                    settings: {
                        slidesToShow: 2.5,
                        slidesToScroll: 1,
                    },
                },
                {
                    breakpoint: 304,
                    settings: {
                        slidesToShow: 1.5,
                        slidesToScroll: 1,
                    },
                },
                {
                    // screens greater than >= 1024px
                    breakpoint: 0,
                    settings: {
                        slidesToShow: 1,
                        slidesToScroll: 1,
                    },
                },
            ],
        });
    </script>

    </body>

    </html>