<section class="banner_area">
    <div class="container">
        <div class="pull-left">
            <h3>Halaman</h3>
        </div>
        <div class="pull-right">
            <a href="<?php echo site_url('', TRUE); ?>">Beranda</a>
            <a href=""><?php echo $header_meta['meta_title']; ?></a>
        </div>
    </div>
</section>

<section class="main_blog_area single_blog_details">
    <div class="container">
        <div class="row main_blog_inner">
            <div class="col-md-9">
                <?php $pages = query_pages(array('slug' => $page_slug)); ?>
                <?php if ($pages) : foreach ($pages as $page) : ?>
                        <div class="main_blog_items">
                            <div class="main_blog_item">
                                <?php if ($page['thumb']) : ?>
                                    <div class="main_blog_image">
                                        <img alt="" src="<?php echo image_thumb($page['thumb'], 'larger'); ?>" />
                                    </div>
                                <?php endif; ?>

                                <div class="main_blog_text">
                                    <h2 style="margin-bottom: 30px;"><?php echo $page['title']; ?></h2>

                                    <?php echo $page['description']; ?>
                                </div>

                                <?php if ($page['galleries']) : ?>
                                    <div class="main_blog_gallery">
                                        <div class="row">
                                            <?php foreach ($page['galleries'] as $gallery) : ?>
                                                <div class="col-md-6"><a data-fancybox="gallery" href="<?php echo image_thumb($gallery['image'], 'larger') ?>"><img src="<?php echo image_thumb($gallery['image'], 'medium') ?>"></a></div>
                                            <?php endforeach ?>
                                        </div>
                                    </div>
                                <?php endif ?>
                            </div>
                        </div>

                    <?php endforeach ?>
                <?php else : ?>
                    <?php $this->load->view('frontend/' . $active_theme . '/404.php'); ?>
                <?php endif; ?>
            </div>
            <div class="col-md-3">
                <!-- SIDEBAR -->
                <?php $this->load->view('frontend/' . $active_theme . '/right-sidebar.php'); ?>
            </div>
        </div>
    </div>
</section>

<style>
    .main_blog_image {
        margin-bottom: 35px;
    }

    .main_blog_text img {
        width: 100%;
        height: auto;
    }

    .main_blog_items .main_blog_item .main_blog_text h2 {
        padding-top: 0;
    }
</style>