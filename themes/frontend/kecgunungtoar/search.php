<section class="banner_area">
    <div class="container">
        <div class="pull-left">
            <h3><?php echo lang('text_search_result_for') ?> <?php echo $search_query ?></h3>
        </div>
    </div>
</section>

<section class="main_blog_area">
    <div class="container">
        <div class="row main_blog_inner">
            <div class="col-md-9">
                <div class="main_blog_items">
					<?php $limit = 5 ?>
					<?php $posts = query_posts(array('search_query' => $search_query, 'limit' => $limit, 'offset' => $offset)); ?>
					<?php if($posts) : foreach ($posts as $post) : ?>

                    <div class="main_blog_item">
					    <?php if($post['video']) : ?>
					    <div class="main_blog_video">
					    	<iframe width="100%" height="400" src="<?php echo video_thumb($post['video']); ?>" frameborder="0" allowfullscreen></iframe>
					    </div>

					    <?php elseif($post['thumb']) : ?>
					    <div class="main_blog_image">
					        <img alt="" src="<?php echo image_thumb($post['thumb'], 'larger'); ?>"/>
					    </div>
					    <?php endif; ?>
                        <div class="main_blog_text">
                            <a href="<?php echo $post['url']; ?>"><h2><?php echo $post['title']; ?></h2></a>
                            <div class="blog_author_area">
					    		<?php if ($post['user_info']) : ?>
						    	<a href="<?php echo site_url('author/get/' . md5($post['user_info']['user_id'])) ?>" ><i class="fa fa-user"></i> <?php echo lang('text_author') ?> : <span><?php echo $post['user_info']['firstname'] . $post['user_info']['lastname'] ?></span></a>
						    	<?php endif ?>
						    	<a><i class="fa fa-tag"></i> <span><?php echo $post['date_published']; ?></span></a>
								<a href="<?php echo $post['url']; ?>#respond"><i class="fa fa-comments-o"></i> <span><?php echo $post['total_comments'] ?> <?php echo lang('text_comments') ?></span></a>
                            </div>
							<p><?php echo get_excerpt($post['content'], 350) ?></p>
                            <a class="more_btn" href="<?php echo $post['url']; ?>">Baca selengkapnya</a>
                        </div>
                    </div>

					<?php endforeach; ?>
					<nav aria-label="Page navigation" class="blog_pagination">
					    <?php echo paginating($base_url, $total_post, $limit, $uri_segment);; ?>
					</nav>

					<?php else : ?>
						<?php $this->load->view('frontend/'. $active_theme .'/404.php'); ?>
					<?php endif; ?>
                </div>
            </div>
            <div class="col-md-3">
				<!-- SIDEBAR -->
				<?php $this->load->view('frontend/'. $active_theme .'/right-sidebar.php'); ?>
            </div>
        </div>
    </div>
</section>