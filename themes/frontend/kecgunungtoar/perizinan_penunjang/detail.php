<section class="banner_area">
    <div class="container">
        <div class="pull-left">
            <h3><?php echo $perizinan_penunjang['name']; ?></h3>
        </div>
    </div>
</section>

<section class="main_blog_area main_blog_items">
    <div class="container">
        <div class="row">
            <div class="col-md-9 main_blog_item">
                <?php if ($perizinan_penunjang) : ?>
                <div class="welcome_inner">
                    <div class="panel-group" id="accordion-izin" role="tablist" aria-multiselectable="true">
                        <?php if ($perizinan_penunjang['content_mikro']) : ?>
                        <div class="panel">
                            <div class="panel-heading" role="tab" id="heading1">
                                <h4 class="panel-title">
                                    <a role="button" data-toggle="collapse" data-parent="#accordion-izin" href="#collapse1" aria-expanded="true" aria-controls="collapse1">
                                    <i class="fa fa-angle-down" aria-hidden="true"></i>
                                    <i class="fa fa-angle-right" aria-hidden="true"></i>
                                    Skala Usaha Mikro
                                    </a>
                                </h4>
                            </div>
                            <div id="collapse1" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="heading1" aria-expanded="true">
                                <div class="panel-body">
                                    <table class="table table-striped">
                                        <tbody>
                                            <tr>
                                                <td style="width: 30%;">Luas Lahan</td>
                                                <td style="width: 5px;">:</td>
                                                <td><?=$perizinan_penunjang['content_mikro']['luas_lahan'] ?></td>
                                            </tr>
                                            <tr>
                                                <td>Tingkat Risiko</td>
                                                <td>:</td>
                                                <td><?=$perizinan_penunjang['content_mikro']['tingkat_risiko'] ?></td>
                                            </tr>
                                            <tr>
                                                <td>Perizinan Berusaha</td>
                                                <td>:</td>
                                                <td><?=$perizinan_penunjang['content_mikro']['perizinan_berusaha'] ?></td>
                                            </tr>
                                            <tr>
                                                <td>Jangka Waktu</td>
                                                <td>:</td>
                                                <td><?=$perizinan_penunjang['content_mikro']['jangka_waktu'] ?></td>
                                            </tr>
                                            <tr>
                                                <td>Masa Berlaku</td>
                                                <td>:</td>
                                                <td><?=$perizinan_penunjang['content_mikro']['masa_berlaku'] ?></td>
                                            </tr>
                                            <tr>
                                                <td>Parameter</td>
                                                <td>:</td>
                                                <td><?=$perizinan_penunjang['content_mikro']['parameter'] ?></td>
                                            </tr>
                                        </tbody>        
                                    </table>

                                    <strong>Persyaratan Perizinan Berusaha</strong> <br>
                                    <?=$perizinan_penunjang['content_mikro']['persyaratan_perizinan'] ?>

                                    <strong>Jangka Waktu Pemenuhan Persyaratan</strong> <br>
                                    <p><?=$perizinan_penunjang['content_mikro']['jw_persyaratan'] ?></p>

                                    <strong>Kewajiban Perizinan Berusaha</strong> <br>
                                    <?=$perizinan_penunjang['content_mikro']['kewajiban_perizinan'] ?>

                                    <strong>Jangka Waktu Pemenuhan Kewajiban</strong> <br>
                                    <p><?=$perizinan_penunjang['content_mikro']['jw_kewajiban'] ?></p>
                                </div>
                            </div>
                        </div>
                        <?php endif ?>

                        <?php if ($perizinan_penunjang['content_kecil']) : ?>
                        <div class="panel">
                            <div class="panel-heading" role="tab" id="heading2">
                                <h4 class="panel-title">
                                    <a role="button" data-toggle="collapse" data-parent="#accordion-izin" href="#collapse2" aria-expanded="false" aria-controls="collapse2">
                                    <i class="fa fa-angle-down" aria-hidden="true"></i>
                                    <i class="fa fa-angle-right" aria-hidden="true"></i>
                                    Skala Usaha Kecil
                                    </a>
                                </h4>
                            </div>
                            <div id="collapse2" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading2" aria-expanded="false">
                                <div class="panel-body">
                                    <table class="table table-striped">
                                        <tbody>
                                            <tr>
                                                <td style="width: 30%;">Luas Lahan</td>
                                                <td style="width: 5px;">:</td>
                                                <td><?=$perizinan_penunjang['content_kecil']['luas_lahan'] ?></td>
                                            </tr>
                                            <tr>
                                                <td>Tingkat Risiko</td>
                                                <td>:</td>
                                                <td><?=$perizinan_penunjang['content_kecil']['tingkat_risiko'] ?></td>
                                            </tr>
                                            <tr>
                                                <td>Perizinan Berusaha</td>
                                                <td>:</td>
                                                <td><?=$perizinan_penunjang['content_kecil']['perizinan_berusaha'] ?></td>
                                            </tr>
                                            <tr>
                                                <td>Jangka Waktu</td>
                                                <td>:</td>
                                                <td><?=$perizinan_penunjang['content_kecil']['jangka_waktu'] ?></td>
                                            </tr>
                                            <tr>
                                                <td>Masa Berlaku</td>
                                                <td>:</td>
                                                <td><?=$perizinan_penunjang['content_kecil']['masa_berlaku'] ?></td>
                                            </tr>
                                            <tr>
                                                <td>Parameter</td>
                                                <td>:</td>
                                                <td><?=$perizinan_penunjang['content_kecil']['parameter'] ?></td>
                                            </tr>
                                        </tbody>        
                                    </table>

                                    <strong>Persyaratan Perizinan Berusaha</strong> <br>
                                    <?=$perizinan_penunjang['content_kecil']['persyaratan_perizinan'] ?>

                                    <strong>Jangka Waktu Pemenuhan Persyaratan</strong> <br>
                                    <p><?=$perizinan_penunjang['content_kecil']['jw_persyaratan'] ?></p> 

                                    <strong>Kewajiban Perizinan Berusaha</strong> <br>
                                    <?=$perizinan_penunjang['content_kecil']['kewajiban_perizinan'] ?> 

                                    <strong>Jangka Waktu Pemenuhan Kewajiban</strong> <br>
                                    <p><?=$perizinan_penunjang['content_kecil']['jw_kewajiban'] ?></p> 
                                </div>
                            </div>
                        </div>
                        <?php endif ?>

                        <?php if ($perizinan_penunjang['content_menengah']) : ?>
                        <div class="panel">
                            <div class="panel-heading" role="tab" id="heading3">
                                <h4 class="panel-title">
                                    <a role="button" data-toggle="collapse" data-parent="#accordion-izin" href="#collapse3" aria-expanded="false" aria-controls="collapse3">
                                    <i class="fa fa-angle-down" aria-hidden="true"></i>
                                    <i class="fa fa-angle-right" aria-hidden="true"></i>
                                    Skala Usaha Menengah
                                    </a>
                                </h4>
                            </div>
                            <div id="collapse3" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading3" aria-expanded="false">
                                <div class="panel-body">
                                    <table class="table table-striped">
                                        <tbody>
                                            <tr>
                                                <td style="width: 30%;">Luas Lahan</td>
                                                <td style="width: 5px;">:</td>
                                                <td><?=$perizinan_penunjang['content_menengah']['luas_lahan'] ?></td>
                                            </tr>
                                            <tr>
                                                <td>Tingkat Risiko</td>
                                                <td>:</td>
                                                <td><?=$perizinan_penunjang['content_menengah']['tingkat_risiko'] ?></td>
                                            </tr>
                                            <tr>
                                                <td>Perizinan Berusaha</td>
                                                <td>:</td>
                                                <td><?=$perizinan_penunjang['content_menengah']['perizinan_berusaha'] ?></td>
                                            </tr>
                                            <tr>
                                                <td>Jangka Waktu</td>
                                                <td>:</td>
                                                <td><?=$perizinan_penunjang['content_menengah']['jangka_waktu'] ?></td>
                                            </tr>
                                            <tr>
                                                <td>Masa Berlaku</td>
                                                <td>:</td>
                                                <td><?=$perizinan_penunjang['content_menengah']['masa_berlaku'] ?></td>
                                            </tr>
                                            <tr>
                                                <td>Parameter</td>
                                                <td>:</td>
                                                <td><?=$perizinan_penunjang['content_menengah']['parameter'] ?></td>
                                            </tr>
                                        </tbody>        
                                    </table>

                                    <strong>Persyaratan Perizinan Berusaha</strong><br>
                                    <?=$perizinan_penunjang['content_menengah']['persyaratan_perizinan'] ?>

                                    <strong>Jangka Waktu Pemenuhan Persyaratan</strong><br>
                                    <p><?=$perizinan_penunjang['content_menengah']['jw_persyaratan'] ?></p>

                                    <strong>Kewajiban Perizinan Berusaha</strong><br>
                                    <?=$perizinan_penunjang['content_menengah']['kewajiban_perizinan'] ?>

                                    <strong>Jangka Waktu Pemenuhan Kewajiban</strong><br>
                                    <p><?=$perizinan_penunjang['content_menengah']['jw_kewajiban'] ?></p>
                                </div>
                            </div>
                        </div>
                        <?php endif ?>

                        <?php if ($perizinan_penunjang['content_besar']) : ?>
                        <div class="panel">
                            <div class="panel-heading" role="tab" id="heading4">
                                <h4 class="panel-title">
                                    <a role="button" data-toggle="collapse" data-parent="#accordion-izin" href="#collapse4" aria-expanded="false" aria-controls="collapse4">
                                    <i class="fa fa-angle-down" aria-hidden="true"></i>
                                    <i class="fa fa-angle-right" aria-hidden="true"></i>
                                    Skala Usaha Besar
                                    </a>
                                </h4>
                            </div>
                            <div id="collapse4" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading4" aria-expanded="false">
                                <div class="panel-body">
                                    <table class="table table-striped">
                                        <tbody>
                                            <tr>
                                                <td style="width: 30%;">Luas Lahan</td>
                                                <td style="width: 5px;">:</td>
                                                <td><?=$perizinan_penunjang['content_besar']['luas_lahan'] ?></td>
                                            </tr>
                                            <tr>
                                                <td>Tingkat Risiko</td>
                                                <td>:</td>
                                                <td><?=$perizinan_penunjang['content_besar']['tingkat_risiko'] ?></td>
                                            </tr>
                                            <tr>
                                                <td>Perizinan Berusaha</td>
                                                <td>:</td>
                                                <td><?=$perizinan_penunjang['content_besar']['perizinan_berusaha'] ?></td>
                                            </tr>
                                            <tr>
                                                <td>Jangka Waktu</td>
                                                <td>:</td>
                                                <td><?=$perizinan_penunjang['content_besar']['jangka_waktu'] ?></td>
                                            </tr>
                                            <tr>
                                                <td>Masa Berlaku</td>
                                                <td>:</td>
                                                <td><?=$perizinan_penunjang['content_besar']['masa_berlaku'] ?></td>
                                            </tr>
                                            <tr>
                                                <td>Parameter</td>
                                                <td>:</td>
                                                <td><?=$perizinan_penunjang['content_besar']['parameter'] ?></td>
                                            </tr>
                                        </tbody>        
                                    </table>

                                    <strong>Persyaratan Perizinan Berusaha</strong> <br>
                                    <?=$perizinan_penunjang['content_besar']['persyaratan_perizinan'] ?>

                                    <strong>Jangka Waktu Pemenuhan Persyaratan</strong> <br>
                                    <p><?=$perizinan_penunjang['content_besar']['jw_persyaratan'] ?></p>

                                    <strong>Kewajiban Perizinan Berusaha</strong> <br>
                                    <?=$perizinan_penunjang['content_besar']['kewajiban_perizinan'] ?>

                                    <strong>Jangka Waktu Pemenuhan Kewajiban</strong> <br>
                                    <p><?=$perizinan_penunjang['content_besar']['jw_kewajiban'] ?></p>
                                </div>
                            </div>
                        </div>
                        <?php endif ?>
                    </div>
                </div>


                <div class="main_blog_text">

                    <?php if($perizinan_penunjang['files']) : ?>
                        <h3>Download Formulir</h3>
                        <ol>
                        <?php foreach($perizinan_penunjang['files'] as $key => $file): ?>
                            <li><a href="<?php echo base_url('uploads/files/' . $file['file_url']); ?>" target="_blank" ><?php echo $file['file_name']; ?></a></li>
                        <?php endforeach; ?>
                        </ol>
                    <?php endif; ?>

                    <a data-original-title="Kembali" href="<?php echo site_url('layanan_perizinan_penunjang'); ?>" data-toggle="tooltip" title="" class="btn ink-reaction btn-primary pull-right"><i class="fa fa-mail-reply"></i> <span class="hidden-xs">Kembali ke Halaman Sebelumnya</span></a>

                </div>
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
