<section class="banner_area">
    <div class="container">
        <div class="pull-left">
            <h3>Konsultasi</h3>
        </div>
        <div class="pull-right">
            <a href="<?php echo site_url('', TRUE); ?>">Beranda</a>
            <a href="<?php echo site_url('contact'); ?>">Konsultasi</a>
        </div>
    </div>
</section>

<section class="main_blog_area single_blog_details">
    <div class="container">
        <div class="row main_blog_inner">
        <?php  $posts = query_detail_layanan(array('parameter' => 'konsultasi', 'slug' => $slug)); ?>
		<?php if($posts) : foreach ($posts as $post) : ?>
        <div class="col-md-9">
            <div class="main_blog_items">
                <div class="s_blog_quote">
                    <p><i class="fa fa-quote-left" aria-hidden="true"></i> <?= $post['content'] ?></p>
                    <a >- <?= $post['name'] ?></a>
                </div>
                <?php if($post['reply_desc'] !=='') { ?>
                <div class="s_main_text">
                    <p>Title : <?= $post['reply_title']; ?></p>
                    <blockquote><?= $post['reply_desc']; ?></blockquote>
                </div>
                <?php }else{ ?>
                    <blockquote>BELUM ADA JAWABAN</blockquote>
                </div>
                <?php } ?>
                
            </div>
        </div>
        <?php endforeach; ?>
        <?php endif; ?>
            <div class="col-md-3">
                <!-- SIDEBAR -->
                <?php $this->load->view('frontend/'. $active_theme .'/right-sidebar.php'); ?>
            </div>
        </div>
    </div>
</section>