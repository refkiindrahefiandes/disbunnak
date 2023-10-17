<section class="banner_area">
    <div class="container">
        <div class="pull-left">
            <h3>Agenda</h3>
        </div>
        <div class="pull-right">
            <a href="<?php echo site_url('', TRUE); ?>">Beranda</a>
            <a href="<?php echo site_url('agenda') ?>">Agenda</a>
        </div>
    </div>
</section>

<section class="main_blog_area single_blog_details">
    <div class="container">
        <div class="row main_blog_inner">
            <div class="col-md-9">
                <div class="agenda_list">
                    <?php $limit = 6 ?>
                    <?php $result = query_agendas(array('limit' => $limit, 'offset' => $offset)); ?>
                    <?php if ($result) : foreach ($result as $agenda) : ?>
                            <div class="agenda_item">
                                <div class="time">
                                    <span><?php echo substr($agenda['date_begin'], -2) ?></span>
                                    <small><?php echo $agenda['time'] ?></small>
                                </div>
                                <div class="content_box">
                                    <h3 class="title"><?php echo $agenda['description'] ?></h3>
                                    <h4 class="title_desc"><?php echo $agenda['information'] ?></h4>
                                    <span class="place"><i class="fa fa-map-marker" aria-hidden="true"></i><?php echo $agenda['location'] ?></span>
                                </div>
                            </div>
                        <?php endforeach; ?>
                        <?php echo paginating($base_url, $total_agenda, $limit, $uri_segment); ?>
                    <?php endif; ?>
                </div>
            </div>
            <div class="col-md-3">
                <!-- SIDEBAR -->
                <?php $this->load->view('frontend/' . $active_theme . '/right-sidebar.php'); ?>
            </div>
        </div>
    </div>
</section>