    <!--================Banner Area =================-->
    <section class="banner_area">
        <div class="container">
            <div class="pull-left">
                <h3>Login</h3>
            </div>
            <div class="pull-right">
                <a href="<?php echo site_url('', TRUE); ?>">Home</a>
                <a href="<?php echo site_url('user/login'); ?>">Login</a>
            </div>
        </div>
    </section>
    <!--================End Banner Area =================-->
    <!--================Contact From Area =================-->
    <section class="contact_form_area">
        <div class="container">
            <div class="main_title">
                <h3>SISTEM LAYANAN PENGADUAN DAN KONSULTASI</h3>
                <p class="m-0">Untuk mengajukan pengaduan atau konsultasi <br> Secara Online Bapak/Ibu harus Login dahulu</p>
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
                    <div class="form-group col-md-6 <?php if (form_error("username")) { echo 'has-error';  } ?>">
						<?php echo form_input('username', '', 'class="form-control" id="username" placeholder="Username"'); ?>
                    </div>
					<div class="form-group col-md-6 <?php if (form_error("password")) { echo 'has-error';  } ?>">
						<?php echo form_password('password', '', 'class="form-control" id="password" placeholder="Password"'); ?>
						<p class="help-block text-right m-0 mt-1"><a href="<?php echo site_url('user/forgoten') ?>" class="undeline-dashed border-color-hover-danger small">Lupa Password?</a></p>
                    </div>
                    <div class="form-group col-md-12 button_area">
                        <button type="submit" class="btn submit_blue form-control" id="js-contact-btn">Login<i class="fa fa-angle-right"></i></button>
						<div class="pull-right">
							<p class="m-0 text-white ml-3">Belum memiliki Akun? <a href="<?php echo site_url('user/register') ?>" class="undeline-dashed border-color-hover-danger">Mendaftar</a></p>
                    	</div>
					</div>
				<?php echo form_close() ?>
            </div>
        </div>
    </section>
    <!--================End Contact From Area =================-->
