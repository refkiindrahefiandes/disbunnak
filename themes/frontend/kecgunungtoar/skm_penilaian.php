<section class="banner_area">
    <div class="container">
        <div class="pull-left">
            <h3>Indeks Kepuasan Masyarakat</h3>
        </div>
        <div class="pull-right">
            <a href="<?php echo site_url('', TRUE); ?>">Beranda</a>
            <a href="<?php echo site_url('skm/penilaian') ?>">IKM</a>
        </div>
    </div>
</section>

<section class="main_blog_area single_blog_details">
    <div class="container">
        <div class="row main_blog_inner">
            <div class="col-md-9">
                <div id="dataTable_wrapper">
                    <h2 class="text-center">INDEKS KEPUASAN MASYARAKAT</h1>
                        <h3 class="text-center" style="margin-bottom: 20px;"><?php echo long_date(' M Y', date('Y-m-d')) ?>
                    </h2>

                    <div class="row">
                        <div class="col-md-12">
                            <legend style="margin-top: 8px;">Jenis Kelamin</legend>
                        </div>
                        <div class="col-md-6">
                            <div class="panel panel-primary" style="margin-bottom: 10px;">
                                <div class="panel-heading">
                                    <h3 class="panel-title">
                                        <i style="margin-right: 10px;" class="icon ion-man"></i>Laki-laki
                                        <span class="pull-right"><?php echo $jenis_kelamin['laki_laki'] ?? '0' ?></span>
                                    </h3>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="panel panel-primary" style="margin-bottom: 10px;">
                                <div class="panel-heading">
                                    <h3 class="panel-title">
                                        <i style="margin-right: 10px;" class="icon ion-woman"></i>Perempuan
                                        <span class="pull-right"><?php echo $jenis_kelamin['perempuan'] ?? '0' ?></span>
                                    </h3>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <legend style="margin-top: 8px;">Tingkat Pendidikan</legend>
                        </div>
                        <div class="col-md-6">
                            <div class="panel panel-primary" style="margin-bottom: 10px;">
                                <div class="panel-heading">
                                    <h3 class="panel-title">
                                        <i style="margin-right: 10px;" class="icon ion-university"></i>SD
                                        <span class="pull-right"><?php echo $pendidikan['sd'] ?? '0' ?></span>
                                    </h3>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="panel panel-primary" style="margin-bottom: 10px;">
                                <div class="panel-heading">
                                    <h3 class="panel-title">
                                        <i style="margin-right: 10px;" class="icon ion-university"></i>SMP
                                        <span class="pull-right"><?php echo $pendidikan['smp'] ?? '0' ?></span>
                                    </h3>

                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="panel panel-primary" style="margin-bottom: 10px;">
                                <div class="panel-heading">
                                    <h3 class="panel-title">
                                        <i style="margin-right: 10px;" class="icon ion-university"></i>SMA
                                        <span class="pull-right"><?php echo $pendidikan['sma'] ?? '0' ?></span>
                                    </h3>

                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="panel panel-primary" style="margin-bottom: 10px;">
                                <div class="panel-heading">
                                    <h3 class="panel-title">
                                        <i style="margin-right: 10px;" class="icon ion-university"></i>D1-D2-D3
                                        <span class="pull-right"><?php echo $pendidikan['di_d2_d3'] ?? '0' ?></span>
                                    </h3>

                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="panel panel-primary" style="margin-bottom: 10px;">
                                <div class="panel-heading">
                                    <h3 class="panel-title">
                                        <i style="margin-right: 10px;" class="icon ion-university"></i>S1
                                        <span class="pull-right"><?php echo $pendidikan['s1'] ?? '0' ?></span>
                                    </h3>

                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="panel panel-primary" style="margin-bottom: 10px;">
                                <div class="panel-heading">
                                    <h3 class="panel-title">
                                        <i style="margin-right: 10px;" class="icon ion-university"></i>S2 Ke atas
                                        <span class="pull-right"><?php echo $pendidikan['s2_keatas'] ?? '0' ?></span>
                                    </h3>

                                </div>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <legend style="margin-top: 8px;">Pekerjaan</legend>
                        </div>
                        <div class="col-md-6">
                            <div class="panel panel-primary" style="margin-bottom: 10px;">
                                <div class="panel-heading">
                                    <h3 class="panel-title">
                                        <i style="margin-right: 10px;" class="icon ion-person-stalker"></i>PNS
                                        <span class="pull-right"><?php echo $pekerjaan['pns'] ?? '0' ?></span>
                                    </h3>

                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="panel panel-primary" style="margin-bottom: 10px;">
                                <div class="panel-heading">
                                    <h3 class="panel-title">
                                        <i style="margin-right: 10px;" class="icon ion-person-stalker"></i>TNI/ Polri
                                        <span class="pull-right"><?php echo $pekerjaan['tni_polri'] ?? '0' ?></span>
                                    </h3>

                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="panel panel-primary" style="margin-bottom: 10px;">
                                <div class="panel-heading">
                                    <h3 class="panel-title">
                                        <i style="margin-right: 10px;" class="icon ion-person-stalker"></i>Swasta
                                        <span class="pull-right"><?php echo $pekerjaan['swasta'] ?? '0' ?></span>
                                    </h3>

                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="panel panel-primary" style="margin-bottom: 10px;">
                                <div class="panel-heading">
                                    <h3 class="panel-title">
                                        <i style="margin-right: 10px;" class="icon ion-person-stalker"></i>Lainnya
                                        <span class="pull-right"><?php echo $pekerjaan['lainnya'] ?? '0' ?></span>
                                    </h3>

                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <legend style="margin-top: 8px;">Hasil</legend>
                        </div>
                        <div class="col-md-12">
                            <div class="panel panel-success" style="margin-bottom: 10px;">
                                <div class="panel-heading">
                                    <h3 class="panel-title">
                                        <i style="margin-right: 10px;" class="icon ion-university"></i>INDEKS KEPUASAN MASYARAKAT (IKM)
                                        <?php if (isset($ikm)) : ?>
                                            <span class="pull-right"><?php echo get_nilai_likert((int) (array_sum(array_column($ikm, 'nilai')) / count($ikm))) ?></span>
                                        <?php else : ?>
                                            <span class="pull-right">0</span>
                                        <?php endif ?>
                                    </h3>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group button_area text-center" style="margin-top: 30px;">
                        <a href="<?php echo site_url('skm') ?>" class="btn submit_blue form-control"><i class="fa fa-angle-left"></i> Kembali </a>
                    </div>

                </div>
            </div>
            <div class="col-md-3">
                <!-- SIDEBAR -->
                <?php $this->load->view('frontend/' . $active_theme . '/right-sidebar.php'); ?>
            </div>
        </div>
    </div>
</section>