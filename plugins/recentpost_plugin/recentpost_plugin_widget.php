<div class="r_widget recent_widget">
    <?php if ($widget_title) : ?>
        <div class="r_widget_title">
            <h3><?php echo $widget_title ?></h3>
        </div>
    <?php endif ?>
    <div class="recent_inner">
        <?php foreach ($posts_data as $post) : ?>
            <div class="recent_item">
                <div class="recent_box_img">
                    <img src="<?= image_thumb($post['thumb'], 'small'); ?>" alt="berita-image" />
                </div>
                <div class="recent_boc_desc">
                    <a href="<?php echo $post['url'] ?>">
                        <h4><?php echo $post['title'] ?></h4>
                    </a>
                    <h5><?php echo $post['date_published'] ?></h5>
                </div>
            </div>
        <?php endforeach ?>
    </div>
</div>