    <!--================Banner Area =================-->
    <section class="banner_area">
        <div class="container">
            <div class="pull-left">
                <h3>GANTI KATA SANDI</h3>
            </div>
            <div class="pull-right">
                <a href="<?php echo site_url('', TRUE); ?>">Home</a>
                <a href="<?php echo site_url('user/login'); ?>">Lupa Password</a>
            </div>
        </div>
    </section>
    <!--================End Banner Area =================-->
    <!--================Contact From Area =================-->
    <section class="contact_form_area">
        <div class="container">
            <div class="main_title">
                <h2>Sistem Layanan Pengaduan Dan Konsultasi</h2>
                <p class="m-0">Silahkan masukan email account anda untuk Reset Password.</p>
            </div>
            <div class="row contact_form_inner">
                <div class="col-md-12">
                <?php if (isset($this->session->userdata['error'])) {
                    echo alert('error', $this->session->userdata['error']);
                } ?>

                <?php if (isset($this->session->userdata['success'])) {
                    echo alert('success', $this->session->userdata['success']);
                } ?>
                </div>
				<?php echo form_open('', 'class="contact_us_form"') ?>
                    <div class="form-group col-md-12">
                        <label for="email" class="small text-white">Masukan Email</label>
                            <?php echo form_input('email', '', 'class="form-control" id="email"'); ?>
                        </div>
                    <div class="form-group col-md-12 button_area">
                        <button type="submit" class="btn submit_blue form-control" id="js-contact-btn">Ganti Kata Sandi<i class="fa fa-angle-right"></i></button>
						<div class="pull-right">
                        <p class="m-0 text-white ml-3"><a href="<?php echo site_url('user/login') ?>" class="undeline-dashed border-color-hover-danger">Batal</a></p>
                    	</div>
					</div>
				<?php echo form_close() ?>
            </div>
        </div>
    </section>
    <!--================End Contact From Area =================-->
