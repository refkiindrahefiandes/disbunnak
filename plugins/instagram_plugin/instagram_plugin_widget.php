<div class="widget">
    <?php if ($widget_title) : ?>
    <div class="widget-header">
        <h3><?php echo $widget_title ?></h3>
    </div>
    <?php endif ?>
    <div class="widget-body">
        <div id="instagram">
            <?php if ($widget_data) : foreach ($widget_data as $data) { ?>
            <a href="<?php echo $data['link'] ?>" target="<?php echo $data['target'] ?>">
                <img src="<?php echo $data['thumbnail'] ?>" alt="<?php echo $data['code'] ?>">
            </a>
            <?php } endif ?>
        </div>
    </div>
</div>
<style>
#instagram a {
    float: left;
    width: 33.3333%;
}
#instagram a img {
    margin: 0 0 10px;
    max-width: 100%;
    padding: 0 5px;
}
</style>