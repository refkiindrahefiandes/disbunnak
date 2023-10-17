<!DOCTYPE html>
<html lang="en">
<head>
	<!-- BEGIN META -->
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Admin Dashboard - Login</title>

	<!-- LIBS CSS -->
	<link rel="stylesheet" href="<?php echo ADMIN_ASSETS_URL; ?>css/libs/bootstrap.min.css">
	<link rel="stylesheet" href="<?php echo ADMIN_ASSETS_URL; ?>js/libs/iCheck/skins/square/green.css">

	<!-- CSS -->
	<link rel="stylesheet" href="<?php echo ADMIN_ASSETS_URL; ?>css/style.css">

	<!-- LIBS JS -->
	<script type="text/javascript" src="<?php echo ADMIN_ASSETS_URL; ?>js/libs/jquery.min.js"></script>
	<script type="text/javascript" src="<?php echo ADMIN_ASSETS_URL; ?>js/libs/bootstrap.min.js"></script>
	<script type="text/javascript" src="<?php echo ADMIN_ASSETS_URL; ?>js/libs/iCheck/icheck.min.js"></script>

</head>
<body>
	<!-- BEGIN LOGIN SECTION -->
	<section class="section-account">
		<div class="card" style="max-width: 670px; margin: 50px auto 0 auto;">
			<div class="card-header text-center" style="margin-bottom: 30px; height: 139px; background-image: url('<?php echo ADMIN_ASSETS_URL; ?>images/login-bg.jpg');">
				<div class="card-header-title">Sign in</div>
			</div>
			<div class="card-body">
				<div class="row">
					<div class="col-sm-12">
						<?php if (isset($this->session->userdata['error'])) {
							echo '<div class="alert alert-callout alert-warning" role="alert">' . $this->session->userdata['error'] . '</div>';
						} ?>

						<?php echo validation_errors('<div class="alert alert-callout alert-warning" role="alert">', '</div>'); ?>

						<?php echo form_open('admin/user/user/login', 'class="form"');?>
							<div class="form-group">
								<?php echo form_input('username', '', 'class="form-control" id="username"'); ?>
								<label for="username">Username</label>
							</div>
							<div class="form-group">
								<?php echo form_password('password', '', 'class="form-control" id="password"'); ?>
								<label for="password">Password</label>
								<p class="help-block text-right"><a href="#">Forgotten?</a></p>
							</div>
							<div class="row">
								<div class="col-xs-6 text-left">
									<div class="checkbox">
										<label style="padding-left: 0;">
											<input type="checkbox" class="iCheck" name="remember"> <span>Remember me</span>
										</label>
									</div>
								</div>
								<div class="col-xs-6 text-right">
									<button class="btn btn-primary btn-raised" type="submit">Login</button>
								</div>
							</div>
						<?php echo form_close();?>
					</div>
				</div>
			</div>
		</div>
	</section>
	<!-- END LOGIN SECTION -->

<script>
    $(document).ready(function() {
        // iCheck
        $('input.iCheck').iCheck({
            checkboxClass: 'icheckbox_square-green',
            radioClass: 'iradio_square-green'
        });
    });
</script>

<style>
	body {
		background: #ebeeef;
	}

	.section-account .card {
		box-shadow: none;
		position: relative;
		border-radius: 10px!important;
		z-index: 1001;
	}

	.card .card-body {
		padding: 40px;
	}

	.card .card-body:last-child {
		border-radius: 0 0 10px 10px;
	}

	.card-header::before {
		content: "";
		display: block;
		position: absolute;
		z-index: -1;
		width: 100%;
		height: 100%;
		top: 0;
		left: 0;
		background-color: rgba(54,84,99,0.7);
		border-radius: 10px 10px 0 0;
	}

	.card .card-header {
		border-radius: 10px 10px 0 0;
	}

	.card .card-header .card-header-title {
		line-height: 139px;
		padding: 0;
		text-transform: uppercase;
		font-size: 2em;
		font-weight: 600;
		color: #fff;
	}
</style>
</body>
</html>