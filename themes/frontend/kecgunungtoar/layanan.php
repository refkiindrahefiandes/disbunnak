<section class="banner_area">
    <div class="container">
        <div class="pull-left">
            <h3>Layanan</h3>
        </div>
        <div class="pull-right">
            <a href="<?php echo site_url('', TRUE); ?>">Beranda</a>
            <a href="<?php echo site_url('layanan') ?>">Layanan</a>
        </div>
    </div>
</section>

<section class="main_blog_area single_blog_details">
    <div class="container">
        <div class="row main_blog_inner">
            <div class="col-md-9">
                <img src="<?php echo $theme_url; ?>img/pelayanan.png" alt="pelayanan-images" class="layanan_img">
                <div class="layanan_list">
                    <?php $result = query_services(array('offset' => $offset)); ?>
                    <?php if ($result) :
                        foreach ($result as $key => $layanan) : ?>
                            <div class="layanan_tab">
                                <input type="radio" name="acc" id="acc<?php echo $key + 1; ?>">
                                <label for="acc<?php echo $key + 1; ?>">
                                    <h2 class="number">0<?php echo $key + 1; ?></h2>
                                    <h3 class="title"><?php echo $layanan['title'] ?></h3>
                                </label>
                                <div class="content">
                                    <?php echo $layanan['description'] ?>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>
            <div class="col-md-3">
                <!-- SIDEBAR -->
                <?php $this->load->view('frontend/' . $active_theme . '/right-sidebar.php'); ?>
            </div>
        </div>
    </div>
</section>