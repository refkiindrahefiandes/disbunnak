<section class="banner_area">
    <div class="container">
        <div class="pull-left">
            <h3><?php echo lang('title_contact') ?></h3>
        </div>
        <div class="pull-right">
            <a href="<?php echo site_url('', TRUE); ?>">Beranda</a>
            <a href="<?php echo site_url('contact'); ?>"><?php echo lang('title_contact') ?></a>
        </div>
    </div>
</section>

<section class="contact_form_area2">
    <div class="container">
        <div class="row">
            <div class="col-md-9">
                <?php echo get_widgets('Contact Banner'); ?>
                <div class="row">
                    <div class="col-md-12">
                        <?php if (isset($this->session->userdata['error'])) {
                            echo '<div class="alert alert-callout alert-warning" role="alert">' . $this->session->userdata['error'] . '<i class="fa fa-remove close" onclick="$(this).parent().remove();"></i></div>';
                        } ?>

                        <?php if (isset($this->session->userdata['success'])) {
                            echo '<div class="alert alert-callout alert-success" role="alert">' . $this->session->userdata['success'] . '<i class="fa fa-remove close" onclick="$(this).parent().remove();"></i></div>';
                        } ?>

                        <p style="margin-bottom: 30px;"><?php echo lang('text_comment_desc') ?></p>
                    </div>

                    <?php echo form_open('', 'class="contact_us_form form"'); ?>
                    <div class="form-group hp-comment">
                        <input type="text" name="name" value="" id="name" class="form-control">
                    </div>
                    <div class="form-group  col-md-6 <?php if (form_error("nama")) {
                                                            echo 'has-error';
                                                        } ?>">
                        <label class="control-label" for="nama"><?php echo lang('text_name') ?> <span class="required">*</span></label>
                        <input type="text" class="form-control" id="nama" name="nama" value="">
                        <small><?php echo form_error("nama", '<p class="help-block ">', '</p>'); ?></small>
                    </div>
                    <div class="form-group  col-md-6 <?php if (form_error("email")) {
                                                            echo 'has-error';
                                                        } ?>">
                        <label class="control-label" for="email"><?php echo lang('text_email') ?> <span class="required">*</span></label>
                        <input type="text" class="form-control" id="email" name="email" value="">
                        <small><?php echo form_error("email", '<p class="help-block ">', '</p>'); ?></small>
                    </div>
                    <div class="form-group col-md-6">
                        <label class="control-label" for="phone"><?php echo lang('text_phone') ?></label>
                        <input type="text" class="form-control" id="phone" name="phone" value="">
                        <small>
                            <p class="help-block pull-right">Optional</p>
                        </small>
                    </div>
                    <div class="form-group col-md-6 control-width-normal">
                        <label class="control-label" for="type"><?php echo lang('text_type') ?></label>
                        <select id="type" name="type" class="form-control" style="height: 50px">
                            <option value="">-- <?php echo lang('text_select_type') ?> --</option>
                            <?php foreach ($type as $key => $jenis) : ?>
                                <option value="<?php echo $key; ?>"><?php echo $jenis; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group col-md-12 <?php if (form_error("content")) {
                                                            echo 'has-error';
                                                        } ?>">
                        <label class="control-label" for="email"><?php echo lang('text_message') ?> <span class="required">*</span></label>
                        <textarea name="content" id="content" class="form-control" rows="5"></textarea>
                        <small><?php echo form_error("content", '<p class="help-block ">', '</p>'); ?></small>
                    </div>
                    <div class="form-group col-md-12 button_area">
                        <button type="submit" value="submit your quote" class="btn submit_blue form-control" id="js-contact-btn"><?php echo lang('btn_contact') ?> <i class="fa fa-angle-right"></i></button>
                    </div>
                    <?php echo form_close(); ?>
                </div>
            </div>
            <div class="col-md-3">
                <!-- SIDEBAR -->
                <?php $this->load->view('frontend/' . $active_theme . '/right-sidebar.php'); ?>
            </div>
        </div>
    </div>
</section>

<style>
    .hp-comment {
        display: none !important;
    }
</style>