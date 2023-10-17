<section class="banner_area">
    <div class="container">
        <div class="pull-left">
            <h3>Perizinan Berusaha Menunjang Kegiatan Usaha</h3>
        </div>
    </div>
</section>

<section class="main_blog_area welcome_inner">
    <div class="container">
        <div class="row">
            <div class="col-md-9">
                <?php if ($result_perizinan_penunjang_nested) : ?>
                    <?php foreach( $result_perizinan_penunjang_nested as $key => $result ) : ?>
                    <div class="panel-group" id="#<?php echo $key; ?>" role="tablist" aria-multiselectable="true">
                        <div class="panel">
                            <div class="panel-heading" role="tab" id="heading<?php echo $key; ?>">
                                <h4 class="panel-title" style="text-transform: uppercase;">
                                    <a role="button" data-toggle="collapse" data-parent="#<?php echo $key; ?>" href="#collapse<?php echo $key; ?>" aria-expanded="true" aria-controls="collapse<?php echo $key; ?>">
                                        <i class="fa fa-angle-down" aria-hidden="true"></i>
                                        <i class="fa fa-angle-right" aria-hidden="true"></i>
                                        <?php echo $result['name']; ?>
                                    </a>
                                </h4>
                            </div>
                            <div id="collapse<?php echo $key; ?>" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="heading<?php echo $key; ?>" aria-expanded="true">
                                <div class="panel-body">
                                    <ul class="list-group" style="margin-bottom: 0">
                                        <?php foreach( $result['children'] as $child ) : ?>
                                        <li class="list-group-item"><i class="fa fa-angle-right"></i> <a href="<?php echo $child['url'] ?>"><?php echo $child['name'] ?></a></li>
                                        <?php endforeach; ?>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                <?php else : ?>
                    <?php $this->load->view('frontend/'. $active_theme .'/404.php'); ?>
                <?php endif; ?>
            </div>
            <div class="col-md-3">
				<!-- SIDEBAR -->
				<?php $this->load->view('frontend/'. $active_theme .'/right-sidebar.php'); ?>
            </div>
        </div>
    </div>
</section>
