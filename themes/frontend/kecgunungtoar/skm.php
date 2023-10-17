<section class="banner_area">
    <div class="container">
        <div class="pull-left">
            <h3>Survei Kepuasan Masyarakat</h3>
        </div>
        <div class="pull-right">
            <a href="<?php echo site_url('', TRUE); ?>">Beranda</a>
            <a href="<?php echo site_url('skm') ?>">SKM</a>
        </div>
    </div>
</section>

<section class="main_blog_area single_blog_details">
    <div class="container">
        <div class="row main_blog_inner">
            <div class="col-md-9">
                <?php echo form_open('','class="contact_us_form form"'); ?>
                <div id="dataTable_wrapper">
                    <div class="row">
                        <div class="col-md-12">
                            <?php if (isset($this->session->userdata['error'])) {
                                echo '<div class="alert alert-callout alert-warning" role="alert">' . $this->session->userdata['error'] . '</div>';
                            } ?>

                            <?php if (isset($this->session->userdata['success'])) {
                                echo '<div class="alert alert-callout alert-success" role="alert">' . $this->session->userdata['success'] . '</div>';
                            } ?>
                        </div>

                        <div class="col-md-12" style="margin-bottom: 15px;">
                            <p>Silahkan isi data responden dan pilih penilaian pada salah satu skala terendah hingga tertinggi. 1 Bintang = Sangat Tidak Baik, 5 Bintang = Sangat Baik</p>
                        </div>

                        <div class="form-group hp-comment col-md-12">
                            <input type="text" name="name" value="" id="name" class="form-control">
                        </div>
                        <div class="form-group col-md-6 <?php if (form_error("usia")) { echo 'has-error';  } ?>">
                            <label class="control-label" for="usia">Usia <span class="required">*</span></label>
                            <input type="number" class="form-control" id="usia" name="usia" value="">
                        </div>

                        <div class="form-group col-md-6 control-width-normal <?php if (form_error("jenis_kelamin")) { echo 'has-error';  } ?>">
                            <label class="control-label" for="jenis_kelamin">Jenis Kelamin <span class="required">*</span></label>
                            <select id="jenis_kelamin" name="jenis_kelamin" class="form-control select" style="height: 50px">
                                <option value="">-- Pilih Jenis Kelamin --</option>
                                <?php foreach($jenis_kelamin as $k => $v): ?>
                                <option value="<?php echo $k; ?>"><?php echo $v; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="form-group col-md-6 control-width-normal <?php if (form_error("pendidikan")) { echo 'has-error';  } ?>">
                            <label class="control-label" for="pendidikan">Tingkat Pendidikan <span class="required">*</span></label>
                            <select id="pendidikan" name="pendidikan" class="form-control select" style="height: 50px">
                                <option value="">-- Pilih Tingkat Pendidikan --</option>
                                <?php foreach($pendidikan as $k => $v): ?>
                                <option value="<?php echo $k; ?>"><?php echo $v; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="form-group col-md-6 control-width-normal <?php if (form_error("pekerjaan")) { echo 'has-error';  } ?>">
                            <label class="control-label" for="pekerjaan">Pekerjaan <span class="required">*</span></label>
                            <select id="pekerjaan" name="pekerjaan" class="form-control select" style="height: 50px">
                                <option value="">-- Pilih Pekerjaan --</option>
                                <?php foreach($pekerjaan as $k => $v): ?>
                                <option value="<?php echo $k; ?>"><?php echo $v; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="form-group col-md-12">
                            <label class="control-label" for="saran">Berikan saran anda untuk peningkatan kualitas pada pelayanan</label>
                            <textarea name="saran" id="saran" class="form-control" rows="5"></textarea>
                        </div>
                    </div>

                    <div class="table-responsive" style="margin: 30px 0">
                        <table class="table table-striped table-hover" id="dataTable">
                            <tbody>
                                <?php $no = 1; if ($pertanyaan) : foreach($pertanyaan as $k => $v) : ?>

                                <tr>
                                    <td class="text-center"><?php echo $no ?></td>
                                    <td style="width: 70%;">
                                        <strong><?php echo $v['judul'] ?></strong>
                                        <p><?php echo $v['keterangan'] ?></p>
                                    </td>
                                    <td>
                                        <div class="star-rating__stars">
                                          <input class="star-rating__input" type="radio" name="penilaian[<?=$v['skm_id']?>]" value="20" id="rating-1-<?=$k?>" checked="checked" />
                                          <label class="star-rating__label" for="rating-1-<?=$k?>" aria-label="One"></label>
                                          <input class="star-rating__input" type="radio" name="penilaian[<?=$v['skm_id']?>]" value="40" id="rating-2-<?=$k?>" />
                                          <label class="star-rating__label" for="rating-2-<?=$k?>" aria-label="Two"></label>
                                          <input class="star-rating__input" type="radio" name="penilaian[<?=$v['skm_id']?>]" value="60" id="rating-3-<?=$k?>" />
                                          <label class="star-rating__label" for="rating-3-<?=$k?>" aria-label="Three"></label>
                                          <input class="star-rating__input" type="radio" name="penilaian[<?=$v['skm_id']?>]" value="80" id="rating-4-<?=$k?>" />
                                          <label class="star-rating__label" for="rating-4-<?=$k?>" aria-label="Four"></label>
                                          <input class="star-rating__input" type="radio" name="penilaian[<?=$v['skm_id']?>]" value="100" id="rating-5-<?=$k?>" />
                                          <label class="star-rating__label" for="rating-5-<?=$k?>" aria-label="Five"></label>
                                          <div class="star-rating__focus"></div>
                                        </div>
                                    </td>
                                </tr>
                                <?php $no++; endforeach; endif; ?>
                            </tbody>
                        </table>
                    </div>

                    <div class="form-group button_area text-center">
                        <button type="submit" value="Kirim Penilaian" class="btn submit_blue form-control" id="js-contact-btn">Kirim Penilaian <i class="fa fa-angle-right"></i></button> <br>
                    </div>

                    <div class="lihat-penilaian" style="text-align: center;">
                        <a href="<?php echo site_url('skm/penilaian') ?>" style="margin-top: 20px;">Lihat IKM <?php echo long_date(' M Y', date('Y-m-d')) ?> <i class="fa fa-angle-right"></i></a>
                    </div>
                        
                </div>
                <?php echo form_close();?>
            </div>
            <div class="col-md-3">
                <!-- SIDEBAR -->
                <?php $this->load->view('frontend/'. $active_theme .'/right-sidebar.php'); ?>
            </div>
        </div>
    </div>
</section>

