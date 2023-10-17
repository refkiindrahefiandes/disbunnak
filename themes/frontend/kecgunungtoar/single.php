<section class="banner_area">
    <div class="container">
        <div class="pull-left">
            <h3>Blog Details</h3>
        </div>
        <!-- <div class="pull-right">
            <a href="<?php echo site_url('', TRUE); ?>">Beranda</a>
            <a href="<?php echo $post_url; ?>"><?php echo $header_meta['meta_title']; ?></a>
        </div> -->
    </div>
</section>

<section class="main_blog_area single_blog_details">
    <div class="container">
        <div class="row main_blog_inner">
            <div class="col-md-9">
                <?php $posts = query_posts(array('slug' => $slug)); ?>
                <?php if ($posts) : foreach ($posts as $post) : ?>

                        <div class="main_blog_items">
                            <div class="main_blog_item">
                                <?php if ($post['video']) : ?>
                                    <div class="main_blog_video">
                                        <iframe width="100%" height="400" src="<?php echo video_thumb($post['video']); ?>" frameborder="0" allowfullscreen></iframe>
                                    </div>

                                <?php elseif ($post['thumb']) : ?>
                                    <div class="main_blog_image">
                                        <img alt="" src="<?php echo image_thumb($post['thumb'], 'larger'); ?>" />
                                    </div>
                                <?php endif; ?>

                                <div class="main_blog_text">
                                    <h2><?php echo $post['title']; ?></h2>
                                    <div class="blog_author_area">
                                        <?php if ($post['user_info']) : ?>
                                            <a href="<?php echo site_url('author/get/' . md5($post['user_info']['user_id'])) ?>"><i class="fa fa-user"></i> <?php echo lang('text_author') ?> : <?php echo $post['user_info']['firstname'] . ' ' . $post['user_info']['lastname'] ?></a>
                                        <?php endif ?>

                                        <?php if ($post['tags']) : ?>
                                            <?php foreach ($post['tags'] as $tag) : ?>
                                                <a href="<?php echo site_url('blog/tag/' . $tag['slug']) ?>"><i class="fa fa-tag"></i><span><?php echo $tag['name']; ?></span></a>
                                            <?php endforeach ?>
                                        <?php endif ?>

                                        <a href="#respond"><i class="fa fa-comments-o"></i><?php echo $post['total_comments'] ?> <?php echo lang('text_comments') ?></a>
                                    </div>
                                    <?php echo $post['content']; ?>

                                    <?php if ($post['galleries']) : ?>
                                        <div class="main_blog_gallery">
                                            <div class="row">
                                                <?php foreach ($post['galleries'] as $gallery) : ?>
                                                    <div class="col-md-6"><a data-fancybox="gallery" href="<?php echo image_thumb($gallery['image'], 'larger') ?>"><img src="<?php echo image_thumb($gallery['image'], 'medium') ?>"></a></div>
                                                <?php endforeach ?>
                                            </div>
                                        </div>
                                    <?php endif ?>
                                </div>
                            </div>

                            <div class="s_comment_list">
                                <h3><?php echo $post['total_comments'] ?> <?php echo lang('text_comments') ?></h3>
                                <div class="s_comment_list_inner">
                                    <?php
                                            get_list_comments(array(
                                                'style'       => 'div',
                                                'avatar_size' => 56,
                                                'blog_id'     => $post['blog_id'],
                                                'limit'       => 5
                                            ));
                                            ?>
                                </div>
                            </div>
                            <div id="respond" class="s_comment_area">
                                <h3><?php echo lang('text_leave_a_comment') ?></h3>
                                <div class="s_comment_inner">
                                    <span class="help-block"><?php echo lang('text_comment_desc') ?></span>
                                    <?php echo form_open($post['url'], 'class="row contact_us_form"'); ?>
                                    <input type="hidden" name="blog_id" value="<?php echo $post['blog_id']; ?>">
                                    <input type='hidden' name='parent_id' value="<?php echo set_value('parent_id', 0) ?>" id="parent-id">

                                    <div class="form-group col-md-6 hp-comment">
                                        <input type="text" name="name" value="" id="name" class="form-control">
                                    </div>

                                    <div class="form-group col-md-6 <?php if (form_error("email")) {
                                                                                echo 'has-error';
                                                                            } ?>">
                                        <input type="text" class="form-control" name="user" value="<?php echo set_value('user') ?>" id="input-user" placeholder="Enter your name *">
                                    </div>
                                    <div class="form-group col-md-6 <?php if (form_error("email")) {
                                                                                echo 'has-error';
                                                                            } ?>">
                                        <input type="email" class="form-control" name="email" value="<?php echo set_value('email') ?>" id="input-email" placeholder="Enter your email address *">
                                    </div>
                                    <div class="form-group col-md-12">
                                        <textarea class="form-control" name="comment" id="input-comment" rows="1" placeholder="Tulis Komentar"></textarea>
                                    </div>
                                    <div class="form-group col-md-12">
                                        <button type="submit" value="submit" class="btn submit_blue form-control">Kirim Komentar</button>
                                    </div>
                                    <?php echo form_close(); ?>
                                </div>
                            </div>
                        </div>

                    <?php endforeach; ?>

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

<script type='text/javascript'>
    $(function() {
        $("a.reply").click(function() {
            var id = $(this).attr("id");
            $("#parent-id").attr("value", id);
            $("#input-user").focus();
        });
    });
</script>

<style>
    .has-error .form-control,
    .has-error .form-control:focus {
        border-color: #ff6a68 !important;
        box-shadow: none;
    }

    .hp-comment {
        display: none !important;
    }

    .main_blog_image,
    .main_blog_video {
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