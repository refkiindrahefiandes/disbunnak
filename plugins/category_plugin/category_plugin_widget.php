<div class="r_widget categories_widget">
    <?php if ($widget_title) : ?>
    <div class="r_widget_title">
        <h3><?php echo $widget_title ?></h3>
    </div>
	<?php endif ?>
    <ul class="widget-list">
        <?php foreach ($categories as $category) : ?>
        <li><a href="<?php echo site_url('blog/category/' . $category['slug']) ?>" class="list-item"><?php echo $category['name'] ?> <i class="fa fa-angle-right" aria-hidden="true"></i></a></li>
        <?php endforeach ?>
    </ul>
</div>