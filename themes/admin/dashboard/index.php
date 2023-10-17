    <!-- CONTENT -->
    <div id="main-content">
        <div id="content">
            <div class="content-wrap scroll-view">
                <!-- <section class="content-header"></section> -->
                <section class="content-body">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="card dashboard-info border-color1">
                                <div class="card-body">
                                    <div class="tile-stats">
                                        <div class="tile-icon"><i class="icon ion-pricetags"></i></div>
                                        <div class="count"><?php echo $dashboard_info['blog'] ?></div>
                                        <h3><?php echo lang('text_posts') ?></h3>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="card dashboard-info border-color2">
                                <div class="card-body">
                                    <div class="tile-stats">
                                        <div class="tile-icon"><i class="icon ion-folder"></i></div>
                                        <div class="count"><?php echo $dashboard_info['category'] ?></div>
                                        <h3><?php echo lang('text_categories') ?> & <?php echo lang('text_tags') ?></h3>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="card dashboard-info border-color3">
                                <div class="card-body">
                                    <div class="tile-stats">
                                        <div class="tile-icon"><i class="icon ion-chatboxes"></i></div>
                                        <div class="count"><?php echo $dashboard_info['comment'] ?></div>
                                        <h3><?php echo lang('text_comments') ?></h3>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="card dashboard-info border-color4">
                                <div class="card-body">
                                    <div class="tile-stats">
                                        <div class="tile-icon"><i class="icon ion-ios-browsers"></i></div>
                                        <div class="count"><?php echo $dashboard_info['page'] ?></div>
                                        <h3><?php echo lang('text_pages') ?></h3>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-9">
                            <div class="card card-line">
                                <div class="card-header">
                                    <div class="card-header-title">
                                        <i class="icon ion-stats-bars"></i><?php echo lang('text_site_activity') ?>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <canvas id="statistic" style="width:100%;"></canvas>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="card card-line">
                                <div class="card-header">
                                    <div class="card-header-title">
                                        <i class="icon ion-stats-bars"></i> <?php echo lang('text_today_stats') ?>
                                    </div>
                                </div>
                                <div class="card-body today-stats">
                                    <div class="media">
                                        <div class="media-left">
                                            <i class="icon ion-person-add background-color1"></i>
                                        </div>
                                        <div class="media-body">
                                            <div class="media-heading"><?php echo lang('text_today_visitors') ?></div>
                                            <span class="text-muted">
                                                <?php echo $today_visitor; ?>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="media">
                                        <div class="media-left">
                                            <i class="icon ion-person-stalker background-color2"></i>
                                        </div>
                                        <div class="media-body">
                                            <div class="media-heading"><?php echo lang('text_total_visitors') ?></div>
                                            <span class="text-muted">
                                                <?php echo $total_visitor; ?>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="media">
                                        <div class="media-left">
                                            <i class="icon ion-document background-color3"></i>
                                        </div>
                                        <div class="media-body">
                                            <div class="media-heading"><?php echo lang('text_today_hits') ?></div>
                                            <span class="text-muted">
                                                <?php echo $today_hits; ?>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="media">
                                        <div class="media-left">
                                            <i class="icon ion-ios-copy background-color4"></i>
                                        </div>
                                        <div class="media-body">
                                            <div class="media-heading"><?php echo lang('text_total_hits') ?></div>
                                            <span class="text-muted">
                                                <?php echo $total_hits; ?>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="media">
                                        <div class="media-left">
                                            <i class="icon ion-person background-color5"></i>
                                        </div>
                                        <div class="media-body">
                                            <div class="media-heading"><?php echo lang('text_online_visitors') ?></div>
                                            <span class="text-muted">
                                                <?php echo $online_visitor; ?>
                                            </span>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>

<script>
    var ctx = document.getElementById("statistic");
    var data = {
        labels: [<?php echo $date ?>],
        datasets: [
            {
                label: "<?php echo lang('text_visitors') ?>",
                fill: true,
                backgroundColor: "rgba(75,192,192,0.4)",
                borderColor: "#38938a",
                borderCapStyle: 'butt',
                borderDash: [],
                borderDashOffset: 0.0,
                borderJoinStyle: 'miter',
                pointBorderColor: "rgba(75,192,192,1)",
                pointBackgroundColor: "#fff",
                pointBorderWidth: 1,
                pointHoverRadius: 5,
                pointHoverBackgroundColor: "rgba(75,192,192,1)",
                pointHoverBorderColor: "rgba(220,220,220,1)",
                pointHoverBorderWidth: 2,
                pointRadius: 5,

                // The actual data
                data: [<?php echo $day_visitor; ?>],
            },
            {
                label: "<?php echo lang('text_page_views') ?>",
                fill: true,
                backgroundColor: "rgba(255,205,86,0.4)",
                borderColor: "#d27951",
                pointBorderColor: "rgba(255,205,86,1)",
                pointBackgroundColor: "#fff",
                pointBorderWidth: 1,
                pointHoverRadius: 5,
                pointHoverBackgroundColor: "rgba(255,205,86,1)",
                pointHoverBorderColor: "rgba(255,205,86,1)",
                pointHoverBorderWidth: 2,
                pointHoverBorderWidth: 2,
                pointRadius: 5,

                data: [<?php echo $day_hits; ?>]
            }
        ]
    };

    new Chart(ctx, {
        type: 'line',
        data: data,
        options: {
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero:true
                    }
                }]
            }
        }
    });
</script>