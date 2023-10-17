<div class="widget">
<?php if (count($posts_data)) : ?>
    <?php if ($widget_title) : ?>
    <div class="widget-header">
        <h3><?php echo $widget_title ?></h3>
    </div>
    <?php endif ?>
    <div class="widget-body">
        <div class="carousel slide" id="post-carousel">
            <?php $results = array_chunk( $posts_data, 1); //echo '<pre>'.print_r( $pages, 1 ); die; ?>
            <div class="carousel-inner">
            	<?php foreach( $results as $tab => $posts ) : ?>
                <?php foreach( $posts as $post ) : ?>
                <div class="item <?php if($tab == 0) { ?>active<?php } ?>">
                    <?php if($post['video']) : ?>
                    <div class="image-slide" style="line-height: 0">
                        <iframe width="1140" height="451" src="<?php echo video_thumb($post['video']); ?>" frameborder="0" allowfullscreen></iframe>
                    </div>
                    <?php elseif($post['thumb']) : ?>
                    <div class="image-slide">
                        <a href="<?php echo $post['url'] ?>"><img src="<?php echo image_thumb($post['thumb'], 'larger'); ?>" alt=""></a>
                    </div>
                    <?php endif; ?>

                    <div class="caption">
                        <h3 class="entry-title"><a href="<?php echo $post['url'] ?>"><?php echo $post['title']; ?></a></h3>
                        <div class="entry-meta"><?php echo $post['date_published']; ?></div>
                    </div>
                </div>
            	<?php endforeach ?>
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

<style>
    iframe {
        width: 100%;
    }
</style>