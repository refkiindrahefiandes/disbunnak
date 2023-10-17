<section class="banner_area">
    <div class="container">
        <div class="pull-left">
            <h3><?php echo $perizinan_nonkbli['name']; ?></h3>
        </div>
    </div>
</section>

<section class="main_blog_area main_blog_items">
    <div class="container">
        <div class="row">
            <div class="col-md-9 main_blog_item">
                <?php if ($perizinan_nonkbli) : ?>
                    <div class="main_blog_text">
                        <?php if($perizinan_nonkbli['content']['dasar_hukum']) : ?>
                            <h3 style="border-top: none;">Dasar Hukum</h3>
                            <?php echo $perizinan_nonkbli['content']['dasar_hukum']; ?>
                        <?php endif; ?>

                        <?php if($perizinan_nonkbli['content']['pemohon_baru']) : ?>
                            <h3>Permohonan Baru</h3>
                            <?php echo $perizinan_nonkbli['content']['pemohon_baru']; ?>
                        <?php endif; ?>

                        <?php if($perizinan_nonkbli['content']['perpanjangan']) : ?>
                            <h3>Perpanjangan</h3>
                            <?php echo $perizinan_nonkbli['content']['perpanjangan']; ?>
                        <?php endif; ?>

                        <?php if($perizinan_nonkbli['content']['mekanisme']) : ?>
                            <h3>Mekanisme</h3>
                            <?php echo $perizinan_nonkbli['content']['mekanisme']; ?>
                        <?php endif; ?>

                        <?php if($perizinan_nonkbli['content']['lama_penyelesaian']) : ?>
                            <h3>Lama Penyelesaian</h3>
                            <?php echo $perizinan_nonkbli['content']['lama_penyelesaian']; ?>
                        <?php endif; ?>

                        <?php if($perizinan_nonkbli['content']['biaya']) : ?>
                            <h3>Biaya</h3>
                            <?php echo $perizinan_nonkbli['content']['biaya']; ?>
                        <?php endif; ?>

                        <?php if($perizinan_nonkbli['content']['hasil']) : ?>
                            <h3>Hasil Proses</h3>
                            <?php echo $perizinan_nonkbli['content']['hasil']; ?>
                        <?php endif; ?>

                        <?php if($perizinan_nonkbli['content']['informasi_tambahan']) : ?>
                            <?php echo $perizinan_nonkbli['content']['informasi_tambahan']; ?>
                        <?php endif; ?>

                        <?php if($perizinan_nonkbli['content']['files']) : ?>
                            <h3>Download Formulir</h3>
                            <ol>
                            <?php foreach($perizinan_nonkbli['content']['files'] as $key => $file): ?>
                                <li><a href="<?php echo base_url('uploads/files/' . $file['file_url']); ?>" target="_blank" ><?php echo $file['file_name']; ?></a></li>
                            <?php endforeach; ?>
                            </ol>
                        <?php endif; ?>

                        <a data-original-title="Kembali" href="<?php echo site_url('layanan_perizinan_nonkbli'); ?>" data-toggle="tooltip" title="" class="btn ink-reaction btn-primary pull-right"><i class="fa fa-mail-reply"></i> <span class="hidden-xs">Kembali ke Halaman Sebelumnya</span></a>

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
