    <!--================Banner Area =================-->
    <section class="banner_area">
        <div class="container">
            <div class="pull-left">
                <h3>Register</h3>
            </div>
            <div class="pull-right">
                <a href="<?php echo site_url('', TRUE); ?>">Home</a>
                <a href="<?php echo site_url('user/login'); ?>">Login</a>
				<a href="<?php echo site_url('user/register'); ?>">Register</a>
            </div>
        </div>
    </section>
    <!--================End Banner Area =================-->
    <!--================Contact From Area =================-->
    <section class="contact_form_area">
        <div class="container">
            <div class="main_title">
                <h3>SISTEM LAYANAN PENGADUAN DAN KONSULTASI</h3>
				<p class="m-0">Silahkan isi formulir registrasi. Isian yang ditandai (*) wajib diisi.</p>
            </div>
            <div class="row contact_form_inner">
				<div class="col-md-12">
                        <?php if (isset($this->session->userdata['error'])) {
                            echo '<div class="alert alert-callout alert-warning" role="alert">REGISTER GAGAL DI KIRIM<i class="fa fa-remove close" onclick="$(this).parent().remove();"></i></div>';
                        } ?>

                        <?php if (isset($this->session->userdata['success'])) {
                            echo '<div class="alert alert-callout alert-success" role="alert">REGISTER BERHASIL<i class="fa fa-remove close" onclick="$(this).parent().remove();"></i></div>';
                        } ?>
                	</div>
				<?php echo form_open('', 'class="form "') ?>
                    <div class="form-group col-md-6">
						<label for="username" class="small text-white">Username <span class="required">*</span><small> (Huruf/Angka, Tanpa Spasi)</small></label>
							<?php
							$username = 'form-control';
							if (form_error('username')) {
								$username = 'form-control is-invalid';
								echo  '<script>'.'toastr.options.hideDuration = 12312312;toastr.error("'. form_error('username') .'")'.'</script>';
							}
							?>
							<?php echo form_input('username', set_value('username'), 'class="'. $username .'" id="username"'); ?>

							<label for="password" class="small text-white">Kata Sandi <span class="required">*</span></label>
							<?php
							$password = 'form-control';
							if (form_error('password')) {
								$password = 'form-control is-invalid';
								echo  '<script>'.
												'toastr.error("'. form_error('password') .'")'.
											'</script>';
							}
							?>
							<?php echo form_password('password', set_value('password'), 'class="'. $password .'" id="password"'); ?>

							<label for="password_confirm" class="small text-white">Konfirmasi Kata Sandi<span class="required">*</span></label>
							<?php
							$password_confirm = 'form-control';
							if (form_error('password_confirm')) {
								$password_confirm = 'form-control is-invalid';
								echo  '<script>'.
												'toastr.error("'. form_error('password_confirm') .'")'.
											'</script>';
							}
							?>
							<?php echo form_password('password_confirm', set_value('password_confirm'), 'class="'. $password_confirm .'" id="password_confirm"'); ?>
							
							<label for="email" class="small text-white">Email <span class="required">*</span></label>
							<?php
							$email = 'form-control';
							if (form_error('email')) {
								$email = 'form-control is-invalid'; 
								echo  '<script>'.
												'toastr.error("'. form_error('email') .'")'.
											'</script>';
							}
							?>
							<?php echo form_input('email', set_value('email'), 'class="'. $email .'" id="email"'); ?>
                    </div>
					<div class="form-group col-md-6">
					<label for="phone_number" class="small text-white">Nomor Handphone <span class="required">*</span></label>
						<?php
						$phone_number = 'form-control';
						if (form_error('phone_number')) {
							$phone_number = 'form-control is-invalid';
							echo  '<script>'.
											'toastr.error("'. form_error('phone_number') .'")'.
										'</script>';
						}
						?>
						<?php echo form_input('phone_number', set_value('phone_number'), 'class="'. $phone_number .'" id="phone_number"'); ?>
						<label for="name" class="small text-white">Nama <span class="required">*</span> <small>(Sesuai KTP)</small> </label>
						<?php
						$name = 'form-control';
						if (form_error('name')) {
							$name = 'form-control is-invalid'; 
							echo  '<script>'.
											'toastr.error("'. form_error('name') .'")'.
										'</script>';
						}
						?>
						<?php echo form_input('name', set_value('name'), 'class="'. $name .'" id="name"'); ?>
		
						<label for="alamat" class="small text-white">Alamat</label>
						<?php
						$alamat = 'form-control';
						if (form_error('alamat')) {
							$alamat = 'form-control is-invalid'; 
							echo  '<script>'.
											'toastr.error("'. form_error('alamat') .'")'.
										'</script>';
						}
						?>
						<?php echo form_input('alamat', set_value('alamat'), 'class="'. $alamat .'" id="alamat"'); ?>

						<label for="jenis_kelamin" class="small text-white">Jenis Kelamin</label>
						<select id="jenis_kelamin" name="jenis_kelamin" class="form-control select2_single">
								<?php foreach( $jenis_kelamin as $v=>$op ): ?>
								<option value="<?php echo $v;?>" <?php if($v == set_value('jenis_kelamin')) echo "selected"; ?> ><?php echo $op; ?></option>
								<?php endforeach; ?>
						</select>
                    </div>
                    <div class="form-group col-md-12 button_area">
                        <button type="submit" class="btn submit_blue form-control" id="js-contact-btn">Daftar<i class="fa fa-angle-right"></i></button>
						<div class="pull-right">
						<p class="m-0 text-white ml-3">Sudah punya Akun? <a href="<?php echo site_url('user/login') ?>" class="undeline-dashed border-color-hover-danger">Masuk</a></p>
                    	</div>
					</div>
				<?php echo form_close() ?>
            </div>
        </div>
    </section>
	<br>
    <!--================End Contact From Area =================-->
	<script>

	
</script>