<section class="banner_area">
    <div class="container">
        <div class="pull-left">
            <h3>PENGADUAN</h3>
        </div>
        <div class="pull-right">
            <a href="<?php echo site_url('', TRUE); ?>">Beranda</a>
            <a href="<?php echo site_url('pengaduan'); ?>">PENGADUAN</a>
        </div>
    </div>
</section>

<section class="contact_form_area2">
    <div class="container">
            <div class="pull-right">
                <a class="more_btn" href="<?php echo site_url('pengaduan/laporan'); ?>">Laporan Pengaduan</a>
            </div>
        <div class="row">
            <div class="col-md-12">
                <?php //echo get_widgets('Contact Banner'); ?>
                <?php //printr($this->session->userdata);die; ?>
                <div class="row">
                	<div class="col-md-12">
                        <?php if (isset($this->session->userdata['error'])) {
                            echo '<div class="alert alert-callout alert-warning" role="alert">DATA GAGAL DI KIRIM<i class="fa fa-remove close" onclick="$(this).parent().remove();"></i></div>';
                        } ?>

                        <?php if (isset($this->session->userdata['success'])) {
                            echo '<div class="alert alert-callout alert-success" role="alert">DATA BERHASIL DIKIRIM, <a href="'. site_url('pengaduan/laporan') .'">LIHAT PENGADUAN</a><i class="fa fa-remove close" onclick="$(this).parent().remove();"></i></div>';
                        } ?>
                	</div>

                    <?php echo form_open('','class="contact_us_form form"'); ?>
                        <div class="form-group  col-md-6 <?php if (form_error("nama")) { echo 'has-error';  } ?>">
                            <label class="control-label" for="nama"><?php echo lang('text_name') ?></label>
                            <input type="text" class="form-control" id="nama" name="nama" value="<?= $this->session->userdata['name'] ?>" readonly>
                            <small><?php echo form_error("nama", '<p class="help-block ">', '</p>'); ?></small>
                        </div>
                        <div class="form-group  col-md-6 <?php if (form_error("email")) { echo 'has-error';  } ?>">
                            <label class="control-label" for="email"><?php echo lang('text_email') ?></label>
                            <input type="text" class="form-control" id="email" name="email" value="<?= $this->session->userdata['frontend_user_email'] ?>" readonly>
                            <small><?php echo form_error("email", '<p class="help-block ">', '</p>'); ?></small>
                        </div>
                        <div class="form-group col-md-4">
                            <label class="control-label" for="phone"><?php echo lang('text_phone') ?></label>
                            <input type="text" class="form-control" id="phone" name="phone" value="<?= $this->session->userdata['phone_number'] ?>" readonly>
                        </div>
                        <div class="form-group col-md-4 control-width-normal <?php if (form_error("type")) { echo 'has-error';  } ?>">
                            <label class="control-label" for="type"><?php echo lang('text_type') ?></label>
                            <select id="type" name="type" class="form-control" style="height: 50px">
                                <option value="">-- <?php echo lang('text_select_type') ?> --</option>
                                <?php foreach($type as $key => $jenis): ?>
                                <option value="<?php echo $key; ?>"><?php echo $jenis; ?></option>
                                <?php endforeach; ?>
                            </select>
                            <small><?php echo form_error("type", '<p class="help-block ">', '</p>'); ?></small>
                        </div>
                        <div class="form-group col-md-4 control-width-normal <?php if (form_error("is_public")) { echo 'has-error';  } ?>">
                            <label class="control-label" for="is_public">Status Pesan</label>
                            <select id="is_public" name="is_public" class="form-control" style="height: 50px">
                                <option value="">-- Pilih Status Pesan --</option>
                                <?php foreach($is_public as $key => $jenis): ?>
                                <option value="<?php echo $key; ?>"><?php echo $jenis; ?></option>
                                <?php endforeach; ?>
                            </select>
                            <small><?php echo form_error("type", '<p class="help-block ">', '</p>'); ?></small>
                        </div>
                        <div class="form-group col-md-12 <?php if (form_error("content")) { echo 'has-error';  } ?>">
                            <label class="control-label" for="email"><?php echo lang('text_message') ?> <span class="required">*</span></label>
                            <textarea name="content" id="content" class="form-control" rows="5"><?php echo set_value('content') ?></textarea>
                            <small><?php echo form_error("content", '<p class="help-block ">', '</p>'); ?></small>
                        </div>
                        <div class="form-group col-md-12 button_area">
                            <button type="submit" value="submit your quote" class="btn submit_blue form-control" id="js-contact-btn"><?php echo lang('btn_contact') ?> <i class="fa fa-angle-right"></i></button>
                        </div>
                    <?php echo form_close();?>
                </div>
            </div>
        </div>
    </div>
</section>

<style>
    .hp-comment {
        display: none!important;
    }
</style>