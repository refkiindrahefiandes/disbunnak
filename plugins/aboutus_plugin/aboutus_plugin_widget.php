<div class="widget">
    <?php if (isset($widget_title)) : ?>
    <div class="widget-header">
        <h3><?php echo $widget_title ?></h3>
    </div>
	<?php endif ?>
    <div class="widget-body">
        <div class="image">
            <img src="<?php echo image_thumb($user_image, 'small'); ?>" alt="">
        </div>
        <div class="meta">
            <h5>SELAMAT DATANG</h5>
            <h2><?php echo $user_desc['user_name'] ?></h2>
        </div>
        <div class="desc">
            <?php echo $user_desc['user_desc'] ?>
        </div>
    </div>
</div>