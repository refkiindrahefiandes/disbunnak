<div class="widget">
<?php if (count($posts_data)) : ?>
    <?php if ($widget_title) : ?>
    <div class="widget-header">
        <h3><?php echo $widget_title ?></h3>
    </div>
    <?php endif ?>
    <div class="widget-body">
        <div class="carousel slide" id="post-carousel">
            <?php $results = array_chunk( $posts_data, 3); //echo '<pre>'.print_r( $pages, 1 ); die; ?>
            <div class="carousel-inner">
            	<?php foreach( $results as $tab => $posts ) : ?>
                <div class="item <?php if($tab == 0) { ?>active<?php } ?>">
                    <ul class="thumbnails">
                       	<?php foreach( $posts as $post ) : ?>
                        <li class="col-sm-4">
                            <div class="thumbnail">
                                <a href="<?php echo $post['url'] ?>"><img src="<?php echo image_thumb($post['thumb'], 'medium'); ?>" alt=""></a>
                            </div>
                            <div class="caption">
                            	<?php if ($post['category_info']): ?>
                            	<?php foreach ($post['category_info'] as $category): ?>
                            	<div class="cat-links">
                            		<a href="<?php echo base_url('blog/category/' . $category['slug']) ?>"><?php echo $category['name'] ?></a>
                            	</div>
                            	<?php endforeach ?>
                            	<?php endif ?>

                                <h3 class="entry-title"><a href="<?php echo $post['url'] ?>"><?php echo $post['title']; ?></a></h3>
                                <div class="entry-meta"><?php echo $post['date_published']; ?></div>
                            </div>
                        </li>
                        <?php endforeach ?>
                    </ul>
                </div>
            	<?php endforeach ?>
            </div>

            <!-- Indicators -->
            <ol class="carousel-indicators">
            	<?php foreach( $results as $tab => $posts ) : ?>
            	<li data-target="#post-carousel" data-slide-to="<?php echo $tab ?>" class="<?php if($tab == 0) { ?>active<?php } ?>"></li>
            	<?php endforeach ?>
            </ol>

            <a class="left carousel-control" href="#post-carousel" role="button" data-slide="prev">&nbsp;</a>
            <a class="right carousel-control" href="#post-carousel" role="button" data-slide="next">&nbsp;</a>
        </div>
    </div>
<?php endif ?>
</div>