<section class="main_slider_area">
    <div class="r_widget">
        <div class="r_widget_body">
            <div class="banner-image">
                <img src="<?php echo $theme_url; ?>img/hero.jpg" alt="slider-images">
            </div>
            <!-- <div class="service">
                <div class="container">
                    <div class="service-list">
                        <div class="service-item">
                            <div class="service-img">
                                <img src="<?php echo $theme_url; ?>img/kartu-kuning.png" alt="service-images">
                            </div>
                            <a href="<?php echo base_url('id/page/kartu-kuning-ak-1'); ?>">Kartu Kuning (AK.1) <i class="fa fa-long-arrow-right" aria-hidden="true"></i></a>
                        </div>
                        <div class="service-item">
                            <div class="service-img">
                                <img src="<?php echo $theme_url; ?>img/pengaduan.png" alt="service-images">
                            </div>
                            <a href="<?php echo base_url('id/pengaduan'); ?>">Pengaduan <i class="fa fa-long-arrow-right" aria-hidden="true"></i></a>
                        </div>
                        <div class="service-item">
                            <div class="service-img">
                                <img src="<?php echo $theme_url; ?>img/pelatihan.png" alt="service-images">
                            </div>
                            <a href="<?php echo base_url('id/page/pendidkan-dan-pelatihan'); ?>">Pendidikan dan Pelatihan <i class="fa fa-long-arrow-right" aria-hidden="true"></i></a>
                        </div>
                    </div>
                </div>
            </div> -->
        </div>
    </div>
</section>

<!-- main_welcome -->
<section class="main_welcome">
    <div class="container wrapper">
        <div class="row">
            <div class="col-md-7">
                <div class="welcome_inner">
                    <div class="welcome">
                        <div class="widget">
                            <div class="widget-header">
                                <h3></h3>
                            </div>
                            <div class="widget-body">
                                <div class="meta">
                                    <h4>Selamat Datang Di Website Resmi</h4>
                                    <h3>Kecamatan Gunung Toar</h3>
                                </div>
                                <div class="desc">
                                    <?php $pages = query_pages(array('slug' => 'selamat-datang')); ?>
                                    <?php if ($pages) : foreach ($pages as $page) : ?>
                                            <p><?php echo get_excerpt($page['description'], 400) ?> <a href="<?php echo site_url('page/selamat-datang') ?>">Baca selengkapnya...</a></p>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                    <!--  -->
                                </div>
                                <div class="image">
                                    <img src="<?php echo $theme_url; ?>img/kadis.jpg" alt="">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-5">
                <div class="welcome_inner">
                    <div class="panel-group" id="accordion2" role="tablist" aria-multiselectable="true">
                        <div class="panel">
                            <div class="panel-heading" role="tab" id="headingfour">
                                <h4 class="panel-title">
                                    <a role="button" data-toggle="collapse" data-parent="#accordion2" href="#collapsefour" aria-expanded="true" aria-controls="collapsefour">
                                        <i class="fa fa-angle-down" aria-hidden="true"></i>
                                        <i class="fa fa-angle-right" aria-hidden="true"></i>
                                        VISI
                                    </a>
                                </h4>
                            </div>
                            <div id="collapsefour" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingfour" aria-expanded="true">
                                <div class="panel-body">
                                    <?= $theme_option['organisation_visi'] ?>
                                </div>
                            </div>
                        </div>
                        <div class="panel">
                            <div class="panel-heading" role="tab" id="headingfive">
                                <h4 class="panel-title">
                                    <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion2" href="#collapsefive" aria-expanded="false" aria-controls="collapsefive">
                                        <i class="fa fa-angle-down" aria-hidden="true"></i>
                                        <i class="fa fa-angle-right" aria-hidden="true"></i>
                                        MISI
                                    </a>
                                </h4>
                            </div>
                            <div id="collapsefive" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingfive" aria-expanded="false">
                                <div class="panel-body" style="color:#fff;">
                                    <?= $theme_option['organisation_misi'] ?>
                                </div>
                            </div>
                        </div>
                        <div class="panel">
                            <div class="panel-heading" role="tab" id="headingsix">
                                <h4 class="panel-title">
                                    <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion2" href="#collapsesix" aria-expanded="false" aria-controls="collapsesix">
                                        <i class="fa fa-angle-down" aria-hidden="true"></i>
                                        <i class="fa fa-angle-right" aria-hidden="true"></i>
                                        MOTO
                                    </a>
                                </h4>
                            </div>
                            <div id="collapsesix" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingsix" aria-expanded="false">
                                <div class="panel-body" style="color:#fff;">
                                    <?= $theme_option['organisation_motto'] ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- FEATURED POST SLIDER -->
<!-- <div id="main-slider" style="background: #f5f7f9;">
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <?php echo get_widgets('Home Welcome'); ?>
            </div>
        </div>
    </div>
</div> -->

<!-- our_blog_area -->
<section class="our_blog_area">
    <div class="container">
        <div class="main_title">
            <h5>Berita Terbaru</h5>
            <h2>Berita Kegiatan Kecamatan Gunung Toar</h2>
        </div>
        <div class="row our_blog_inner">

            <?php $limit = 3 ?>
            <?php $posts = query_posts_term(array('slug' => 'berita', 'slug_type' => 'category', 'limit' => $limit, 'offset' => $offset)); ?>
            <?php if ($posts) : foreach ($posts as $post) : ?>
                    <div class="col-md-4">
                        <div class="our_blog_item">
                            <div class="our_blog_img">
                                <?php if ($post['video']) : ?>
                                    <iframe width="358" height="142" src="<?php echo video_thumb($post['video']); ?>" frameborder="0" allowfullscreen></iframe>

                                <?php elseif ($post['thumb']) : ?>
                                    <div class="images">
                                        <img alt="" src="<?php echo image_thumb($post['thumb'], 'medium'); ?>" />
                                    </div>
                                <?php endif; ?>

                                <span class="b_category">
                                    Berita
                                </span>
                            </div>
                            <div class="our_blog_content">
                                <div class="b_date">
                                    <small style="color: #163f78;"> <?php echo $post['date_published'] ?></small>
                                </div>

                                <a href="<?php echo $post['url']; ?>" title="<?php echo $post['title']; ?>">
                                    <h4><?php echo $post['title']; ?></h4>
                                </a>
                                <!-- <p><?php echo get_excerpt($post['content'], 160) ?></p> -->
                                <h6><a href="<?php echo site_url('author/get/' . md5($post['user_info']['user_id'])) ?>"><?php echo $post['user_info']['firstname'] . ' ' . $post['user_info']['lastname'] ?></a><span>•</span><a href="<?php echo $post['url']; ?>#respond"><?php echo $post['total_comments'] ?> <?php echo lang('text_comments') ?></a></h6>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
</section>

<!-- main_feature_area -->
<section class="main_feature_area">
    <div class="container">
        <div class="feature_content">
            <div class="feature_content_wrapper">
                <div class="agenda_head">
                    <h2 class="title">Agenda</h2>
                    <span>Kecamatan Gunung Toar</span>
                </div>
                <div class="link">
                    <h4 class="agenda_month"><?php echo long_date(' M Y', date('Y-m-d')) ?></h4>
                    <a href="<?php echo base_url('agenda') ?>" class="btn_read_more">Semua Agenda <i class="fa fa-long-arrow-right" aria-hidden="true"></i></a>
                </div>
                <div class="agenda_list">
                    <?php $limit = 3 ?>
                    <?php $result = query_agendas(array('limit' => $limit, 'offset' => $offset)); ?>
                    <?php if ($result) : foreach ($result as $agenda) : ?>
                            <div class="agenda_item">
                                <div class="time">
                                    <span><?php echo substr($agenda['date_begin'], -2) ?></span>
                                    <small><?php echo $agenda['time'] ?></small>
                                </div>
                                <div class="content_box">
                                    <h3 class="title"><?php echo $agenda['description'] ?></h3>
                                    <span class="place"><i class="fa fa-map-marker" aria-hidden="true"></i><?php echo $agenda['location'] ?></span>
                                    <a href="<?php echo site_url('agenda/' . $agenda['slug']) ?>" class="read_more_btn">Lihat <i class="fa fa-long-arrow-right" aria-hidden="true"></i></a>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Slider Fetured -->
<section class="feature_slider_area" style="padding-bottom:30px; display: none;">
    <div class="container">
        <div class="main_title">
            <h5>Galeri Kegiatan</h5>
            <h2>LAYANAN PUBLIK</h2>
        </div>
        <div class="row feature_row">
            <div class="feature_slider_inner owl-carousel">
                <div class="item">
                    <div class="feature_s_item">
                        <div class="fitur-logo">
                            <img src="<?php echo $theme_url; ?>img/fitur-logo-oss.png" alt="" style="width: 80px;">
                        </div>
                        <a href="<?php echo site_url('layanan_perizinan_berkbli') ?>">
                            <h4>Kartu Kuning (AK.1)</h4>
                        </a>
                        <p>Lihat Persyaratan Pengurusan Perizinan Berusaha Ber-KBLI</p>
                    </div>
                </div>
                <div class="item">
                    <div class="feature_s_item">
                        <div class="fitur-logo">
                            <img src="<?php echo $theme_url; ?>img/8.jpg" alt="">
                        </div>
                        <!-- <a href="<?php echo site_url('layanan_perizinan_penunjang') ?>">
                            <h4>Lowongan Kerja</h4>
                        </a> -->
                        <!-- <p>Lihat Persyaratan Pengurusan Perizinan Berusaha Menunjang Kegiatan Usaha</p> -->
                    </div>
                </div>
                <div class="item">
                    <div class="feature_s_item">
                        <div class="fitur-logo">
                            <img src="<?php echo $theme_url; ?>img/fitur-logo-kuansing.png" alt="" style="width: 80px;">
                        </div>
                        <!-- <a href="<?php echo site_url('layanan_perizinan_nonkbli') ?>">
                            <h4>Pengaduan</h4>
                        </a> -->
                        <p>Lihat Persyaratan Pengurusan Perizinan Berusaha Non Ber-KBLI dan Non Perizinan </p>
                    </div>
                </div>
                <div class="item">
                    <div class="feature_s_item">
                        <div class="fitur-logo">
                            <img src="<?php echo $theme_url; ?>img/fitur-logo-kuansing.png" alt="" style="width: 80px;">
                        </div>
                        <!-- <a href="<?php echo site_url('layanan_perizinan_nonkbli') ?>">
                            <h4>Pendidikan dan Pelatihan</h4>
                        </a> -->
                        <p>Lihat Persyaratan Pengurusan Perizinan Berusaha Non Ber-KBLI dan Non Perizinan </p>
                    </div>
                </div>
                <div class="item">
                    <div class="feature_s_item">
                        <div class="fitur-logo">
                            <img src="<?php echo $theme_url; ?>img/fitur-logo-kuansing.png" alt="" style="width: 80px;">
                        </div>
                        <!-- <a href="<?php echo site_url('layanan_perizinan_nonkbli') ?>">
                            <h4>Pendidikan dan Pelatihan</h4>
                        </a> -->
                        <p>Lihat Persyaratan Pengurusan Perizinan Berusaha Non Ber-KBLI dan Non Perizinan </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="galeri_slider">
    <div class="galeri_slider_wrapper">
        <div class="main_title">
            <h5>Foto Kegiatan</h5>
            <h2>Kecamatan Gunung Toar Dalam Galeri</h2>
        </div>
        <div class="glider-contain">
            <div class="glider">
                <?php $limit = 8 ?>
                <?php $posts = query_posts_term(array('slug' => 'foto-kegiatan', 'slug_type' => 'category', 'limit' => $limit, 'offset' => $offset)); ?>
                <?php if ($posts) : foreach ($posts as $post) : ?>
                        <div class="galeri_item">
                            <div class="galeri_img">
                                <a href="#">
                                    <img alt="" src="<?php echo image_thumb($post['thumb'], 'medium'); ?>" />
                                </a>
                            </div>
                            <div class="galeri_info">
                                <h3 class="galeri_title"><?php echo $post['title']; ?></h3>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
                <!-- <div class="galeri_item">
                    <div class="galeri_img">
                        <a href="#">
                            <img src="<?php echo $theme_url; ?>img/galeri-1.jpg" alt="">
                        </a>
                    </div>
                    <div class="galeri_info">
                        <h3 class="galeri_title">Jembatan Gunung Toar Ramai Dikunjungi Warga Untuk Melihat keindahan Pemandangan Disore Hari</h3>
                    </div>
                </div>
                <div class="galeri_item">
                    <div class="galeri_img">
                        <a href="#">
                            <img src="<?php echo $theme_url; ?>img/galeri-2.jpg" alt="">
                        </a>
                    </div>
                    <div class="galeri_info">
                        <h3 class="galeri_title">Gunung Toar Jadi Kampung Batik Pertama di Riau</h3>
                    </div>
                </div>
                <div class="galeri_item">
                    <div class="galeri_img">
                        <a href="#">
                            <img src="<?php echo $theme_url; ?>img/galeri-3.jpeg" alt="">
                        </a>
                    </div>
                    <div class="galeri_info">
                        <h3 class="galeri_title">Foto Bersama Pemerintahan Gunung Toar</h3>
                    </div>
                </div>
                <div class="galeri_item">
                    <div class="galeri_img">
                        <a href="#">
                            <img src="<?php echo $theme_url; ?>img/galeri-1.jpg" alt="">
                        </a>
                    </div>
                    <div class="galeri_info">
                        <h3 class="galeri_title">Jembatan Gunung Toar Ramai Dikunjungi Warga Untuk Melihat keindahan Pemandangan Disore Hari</h3>
                    </div>
                </div>
                <div class="galeri_item">
                    <div class="galeri_img">
                        <a href="#">
                            <img src="<?php echo $theme_url; ?>img/galeri-2.jpg" alt="">
                        </a>
                    </div>
                    <div class="galeri_info">
                        <h3 class="galeri_title">Gunung Toar Jadi Kampung Batik Pertama di Riau</h3>
                    </div>
                </div>
                <div class="galeri_item">
                    <div class="galeri_img">
                        <a href="#">
                            <img src="<?php echo $theme_url; ?>img/galeri-3.jpeg" alt="">
                        </a>
                    </div>
                    <div class="galeri_info">
                        <h3 class="galeri_title">Foto Bersama Pemerintahan Gunung Toar</h3>
                    </div>
                </div> -->

            </div>
        </div>
        <div class="slider-btns">
            <button aria-label="Previous" class="glider-prev">«</button>
            <button aria-label="Next" class="glider-next">»</button>
            <!-- <div role="tablist" class="dots"></div> -->
        </div>
    </div>
</section>

<!-- layanan_publik_area -->
<!-- <section class="layanan_publik_area">
    <div class="container">
        <div class="main_title">
            <h5>Galeri Kegiatan</h5>
            <h2>LAYANAN PUBLIK</h2>
        </div>
    </div>
</section> -->