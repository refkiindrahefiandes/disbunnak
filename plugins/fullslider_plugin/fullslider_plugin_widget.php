<div id="slider" class="sl-slider-wrapper">
    <div class="sl-slider">
        <?php foreach ($fullsliders as $fullslider) : ?>
        <div class="sl-slide" data-orientation="horizontal" data-slice1-rotation="-25" data-slice2-rotation="-25" data-slice1-scale="2" data-slice2-scale="2">
            <div class="sl-slide-inner">
                <div class="bg-img" style="background-image: url(<?php echo base_url($fullslider['fullslider_image']) ?>);"></div>
                <h2 style="margin-top: 20px;"><?php echo $fullslider['fullslider_title'] ?></h2>
                <blockquote><p style="font-size: 26px;"><?php echo $fullslider['fullslider_desc'] ?></blockquote>
            </div>
        </div>
        <?php endforeach ?>
    </div><!-- /sl-slider -->

    <nav id="nav-dots" class="nav-dots">
        <?php foreach ($fullsliders as $fullslider) : ?>
        <span></span>
        <?php endforeach ?>
    </nav>
</div>