<section class="banner_area">
    <div class="container">
        <div class="pull-left">
            <h3>Agenda Details</h3>
        </div>
    </div>
</section>

<section class="main_blog_area single_blog_details">
    <div class="container">
        <div class="row main_blog_inner">
            <div class="col-md-9">
                <?php $result = query_agendas(array('slug' => $agenda['slug'])); ?>
                <?php if ($result) : foreach ($result as $agenda) : ?>
                        <div class="agenda_detail">
                            <div class="agenda_desc">
                                <h3 class="title"><?php echo $agenda['description'] ?></h3>
                                <h4 class="title_desc"><?php echo $agenda['information'] ?></h4>
                            </div>
                            <div class="agenda_info">
                                <div>
                                    Tanggal <br> <span><?php echo long_date(trim($this->data['date_format_lite']), $agenda['date_begin']) ?></span>
                                </div>
                                <div>
                                    Waktu <br> <span><?php echo $agenda['time'] ?></span>
                                </div>
                                <div>Lokasi <br>
                                    <span class="place"><?php echo $agenda['location'] ?></span>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else : ?>
                    <?php $this->load->view('frontend/' . $active_theme . '/404.php'); ?>
                <?php endif; ?>
            </div>
            <div class="col-md-3">
                <!-- SIDEBAR -->
                <?php $this->load->view('frontend/' . $active_theme . '/right-sidebar.php'); ?>
            </div>
        </div>
    </div>
</section>

<script type='text/javascript'>
    $(function() {
        $("a.reply").click(function() {
            var id = $(this).attr("id");
            $("#parent-id").attr("value", id);
            $("#input-user").focus();
        });
    });
</script>

<style>
    .has-error .form-control,
    .has-error .form-control:focus {
        border-color: #ff6a68 !important;
        box-shadow: none;
    }

    .hp-comment {
        display: none !important;
    }

    .main_blog_image,
    .main_blog_video {
        margin-bottom: 35px;
    }

    .main_blog_text img {
        width: 100%;
        height: auto;
    }

    .main_blog_items .main_blog_item .main_blog_text h2 {
        padding-top: 0;
    }
</style>