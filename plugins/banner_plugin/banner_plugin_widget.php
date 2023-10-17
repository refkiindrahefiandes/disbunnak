<div class="r_widget">
    <?php if ($widget_title) : ?>
        <div class="r_widget_title">
            <h3><?php echo $widget_title ?></h3>
        </div>
    <?php endif ?>
    <div class="r_widget_body">
        <div class="row">
            <?php foreach ($banners as $banner) : ?>
                <?php switch ($banner['jumlah_kolom']) {
                        case '1':
                            $column = 'col-md-12';
                            break;

                        case '2':
                            $column = 'col-md-6';
                            break;

                        case '3':
                            $column = 'col-md-4';
                            break;

                        default:
                            $column = 'col-md-12';
                            break;
                    } ?>

                    <div class="<?php echo $column ?>">
                        <div class="banner-image">
                            <a href="<?php echo $banner['banner_url'] ?>" target="_blank"><img style="width: 100%;" src="<?php echo base_url($banner['banner_image']) ?>" alt=""></a>
                        </div>
                    </div>

                <?php endforeach ?>
        </div>
    </div>
</div>