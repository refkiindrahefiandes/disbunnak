<!DOCTYPE html>
<html lang="en">
<head>
	<!-- BEGIN META -->
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $header_meta['meta_title']; ?></title>

    <meta name="generator" content="<?php echo $meta_generator; ?>">
    <meta name="robots" content="<?php echo $meta_robot; ?>">
    <meta name="description" content="<?php echo $header_meta['meta_description']; ?>">
    <meta name="keywords" content="<?php echo $header_meta['meta_keyword']; ?>">

	<!-- LIBS JS -->
    <script src="<?php echo $theme_url; ?>js/jquery-2.2.4.js" type="text/javascript"></script>
    <script src="<?php echo $theme_url; ?>js/bootstrap.min.js" type="text/javascript"></script>

	<!-- Libs CSS -->
    <link href="<?php echo $theme_url; ?>css/bootstrap.min.css" rel="stylesheet">
    <link href="<?php echo $theme_url; ?>vendors/ionicons/ionicons.min.css" rel="stylesheet">
    <link href="<?php echo $theme_url; ?>css/font-awesome.min.css" rel="stylesheet">

    <!-- Main CSS -->
    <link href="<?php echo $theme_url; ?>css/style.css" rel="stylesheet">

    <!-- FAVICON -->
    <link rel="shortcut icon" href="<?php echo $theme_url; ?>img/favicon/favicon.ico">
    <link rel="shortcut icon" href="<?php echo $theme_url; ?>img/favicon/icon.png">
    <link rel="shortcut icon" sizes="72x72" href="<?php echo $theme_url; ?>img/favicon/icon-72x72.png">
    <link rel="shortcut icon" sizes="114x114" href="<?php echo $theme_url; ?>img/favicon/icon-114x114.png">

	<script>
		$(document).ready(function() {
			var bg = Math.floor(Math.random()*11)+1;
			$('#section0').css("background-image", "url(<?php echo $theme_url; ?>img/"+ bg + ".jpg)");
		});
	</script>

	<style>
	@font-face {
		font-family: 'Rubik';
		src: url("views/themes/default/fonts/rubik.woff2") format("woff2"), url("views/themes/default/fonts/rubik.ttf") format("truetype"); }
		@font-face {
			font-family: "controls";
			src: url("views/themes/default/fonts/controls.eot?-vma0st");
			src: url("views/themes/default/fonts/controls.eot?#iefix-vma0st") format("embedded-opentype"), url("views/themes/default/fonts/controls.woff?-vma0st") format("woff"), url("views/themes/default/fonts/controls.ttf?-vma0st") format("truetype"), url("views/themes/default/fonts/controls.svg?-vma0st#controls") format("svg");
			font-weight: normal;
			font-style: normal; }
	body {
		color: #444;
		font-family: 'Rubik', sans-serif;
		font-size: 16px;
		font-weight: normal;
		line-height: 1.6;
		margin: 0;
		padding: 0; }

/*	a {
	cursor: pointer;
	color: #78d8bd; }
	a:hover, a:hover {
	text-decoration: none;
	color: #555555; }*/

	h1, h2, h3, h4, h5 {
	font-family: 'Rubik', sans-serif;
	margin: 0;
	padding: 0;
	line-height: 1.3; }

	.border-right {
	border-right: 1px solid #78d8bd; }

	.border-left {
	border-left: 1px solid #78d8bd; }

	.border-top {
	border-top: 1px solid #78d8bd; }

	.border-bottom {
	border-bottom: 1px solid #78d8bd; }

	.section h1 {
	color: #fff;
	font-size: 3em;
	margin-top: 20px;
	text-transform: uppercase;
	z-index: 101;
	position: relative; }
	.section h2 {
	color: #fff;
	font-size: 2em;
	z-index: 101;
	position: relative;
	text-transform: uppercase; }
	.section h3 {
	font-size: 1.5em;
	color: #eee;
	z-index: 101;
	position: relative;
	text-transform: uppercase;
	}
	.section .logo {
	z-index: 101;
	margin-top: 20px;
	margin-bottom: 20px;
	position: relative;
	text-align: center; }
	.section .logo img {
	width: 50px;
	height: auto; }

	.menu {
	margin-top: 50px;
	z-index: 101;
	position: relative; }
	.menu .item-menu {
	color: #fff;
	display: block;
	padding: 20px;
	cursor: pointer;
	position: relative;
	z-index: 101; }
	.menu .item-menu i {
	font-size: 3em;
	color: #78d8bd; }
	.menu .item-menu:hover {
	opacity: 0.5;
	filter: alpha(opacity=0.5); }

	.content-container ul {
	padding: 0;
	margin: 0;
	list-style-type: none; }
	.content-container ul li {
	background: #eee;
	padding: 15px 10px;
	border: 1px solid #ddd;
	margin-bottom: 10px;
	cursor: pointer; }
	.content-container ul li i {
	margin-right: 10px; }

    /* section
    * --------------------------------------- */
    .section{
    	text-align:center;
    	position: relative;
    	z-index: 1;
    	top: 0;
    	bottom: 0;
    	left: 0;
    	right: 0;
    	overflow: hidden;
    	width: 100%;
    	height: 100%;
    	background-size: cover;
    	padding-right: 20px;
    	padding-left: 20px;
    	padding-top: 50px;
    }

    /* Defining each section background and styles
    * --------------------------------------- */
    #section0{
    	/*background-image: url(views/themes/default/images/1.jpg);*/
    }

    .overlay:after {
    	position: absolute;
    	content:"";
    	top:0;
    	left:0;
    	width:100%;
    	height:100%;
    	opacity:.7;
    	background: #000;
    	z-index: 1;
    	-webkit-filter:blur(4px);
    	filter:blur(4px);
    }

    /* RESPONSIVE */
	@media (min-width: 1024px) {
	    .section{
	    	position: absolute;
	    }

	    .menu {
	    	margin-top: 100px;
	    }

		.menu .item-menu {
			padding-top: 100px;
			padding-bottom: 100px;
		}

		.section h3 {
			margin-top: 30px;
			margin-bottom: 30px;
		}

		.desc h2 {
			font-size: 2.5em;
		}

		.desc p {
			font-size: 2.3em;
			font-weight: normal;
		}

		.section .logo img {
			width: 80px;
			height: auto;
		}
	}

    /* RESPONSIVE */
	@media (max-width: 767px) {
		.section {
			padding: 20px!important;
		}

		.section h1 {
			font-size: 1.8em;
		}

		.section h2 {
			font-size: 1.5em;
		}

		.section h3 {
			font-size: 1.2em;
			font-weight: normal;
		}

		.desc h2 {
			font-size: 1em;
		}

		.desc p {
			font-size: 0.9em;
			font-weight: normal;
		}

		.menu .item-menu {
			padding: 0;
		}
	}

    .welcome_inner .panel-group .panel .panel-collapse .panel-body {
        padding: 0;
    }
    .list-group-item {
        border: none;
        border-bottom: 1px solid #ddd;
        margin-bottom: 1px;
    }

    .list-group-item:last-child {
        border-bottom: 0;
        border-radius: 0;
    }
</style>
</head>
<body>

	<div class="section overlay" id="section0">
		<div class="logo"><img src="<?php echo $theme_url; ?>img/logo-kuansing.png" alt=""></div>
		<h1>Selamat Datang</h1>
		<h2>Di Anjungan Informasi</h2>
		<h3>Dinas Penanaman Modal, Pelayanan Terpadu Satu Pintu dan Tenaga Kerja <br> Kabupaten Kuantan Singingi</h3>
		<div class="menu">
			<div class="row">
				<div class="col-md-6 col-xs-6 border-right ">
					<div onclick="addModal('perizinan')" class="item-menu border-bottom">
						<div class="icon">
							<i class="icon ion-ios-list"></i>
						</div>
						<div class="desc">
							<h2>PERIZINAN</h2>
							<p>Lihat Persyaratan Pengurusan Perizinan</p>
						</div>
					</div>
				</div>
				<div class="col-md-6 col-xs-6">
					<div onclick="addModal('nonperizinan')" class="item-menu border-bottom">
						<div class="icon">
							<i class="icon ion-ios-list"></i>
						</div>
						<div class="desc">
							<h2>NON PERIZINAN</h2>
							<p>Lihat Persyaratan Pengurusan Non-Perizinan</p>
						</div>
					</div>
				</div>
				<div class="col-md-6 col-xs-6 border-right">
					<div onclick="addModal('perizinan_oss')" class="item-menu">
						<div class="icon">
							<i class="icon ion-ios-list"></i>
						</div>
						<div class="desc">
							<h2>PERIZINAN (OSS)</h2>
							<p>Lihat Persyaratan Perizinan melalui OSS</p>
						</div>
					</div>
				</div>
				<div class="col-md-6 col-xs-6">
					<div onclick="addSaran('saran')" class="item-menu">
						<div class="icon">
							<i class="icon ion-compose"></i>
						</div>
						<div class="desc">
							<h2>KOTAK SARAN</h2>
							<p>Kirim Masukan dan Saran Kepada Kami</p>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

<script type="text/javascript">
	function addModal(e) {
		var Url = '<?=base_url()?>' + 'kiosk/detail/' + e + '.html';

		modal  =	'<div class="modal fade" id="modal-media" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">';
		modal +=		'<div class="modal-dialog modal-lg" role="document">';
		modal +=			'<div class="modal-content">';
		modal +=				'<div class="modal-header">';
		modal +=					'<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>';
		modal +=					'<h4 class="modal-title" id="myModalLabel">Informasi Perizinan/ Non-Perizinan</h4>';
		modal +=				'</div>';
		modal +=				'<div class="modal-body welcome_inner"></div>';
		modal +=				'<div class="modal-footer">';
		modal +=					'<button type="button" class="btn btn-default" data-dismiss="modal">TUTUP</button>';
		modal +=					'<button type="button" id="button-back" onclick="goBack()" class="btn btn-info"><i class="icon ion-reply" style="margin-right: 10px;"></i>Kembali</button>';
		modal +=				'</div>';
		modal +=			'</div>';
		modal +=		'</div>';
		modal +=	'</div>';


		$.ajax({
			url: Url,
			dataType: 'html',
			beforeSend: function() {
				$('#modal-media').remove();
				$('body').append(modal);
				$('#modal-media').modal('show');
				$('#modal-media').find('.modal-body').append('<div class="modal-wait"><i class="icon ion-load-a ion-spin"></i></div>');
			},
			complete: function() {
			},
			success: function(html) {
				$('.modal-wait').remove();
				$('body').find('.modal-body').append(html);
			}
		});
	}

	function addSaran(e) {
		var Url = '<?=base_url()?>' + 'kiosk/' + e + '.html';

		modal  =	'<div class="modal fade" id="modal-media" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">';
		modal +=		'<div class="modal-dialog modal-lg" role="document">';
		modal +=			'<div class="modal-content">';
		modal +=				'<div class="modal-header">';
		modal +=					'<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>';
		modal +=					'<h4 class="modal-title" id="myModalLabel">Kotak Saran</h4>';
		modal +=				'</div>';
		modal +=				'<div class="modal-body"></div>';
		modal +=				'<div class="modal-footer">';
		modal +=					'<button type="button" class="btn btn-default" data-dismiss="modal">TUTUP</button>';
		modal +=					'<button type="button" id="button-submit" onclick="submitForm(this)" class="btn btn-info"><i class="icon ion-paper-airplane" style="margin-right: 10px;"></i>Kirim Saran</button>';
		modal +=				'</div>';
		modal +=			'</div>';
		modal +=		'</div>';
		modal +=	'</div>';


		$.ajax({
			url: Url,
			dataType: 'html',
			beforeSend: function() {
				$('#modal-media').remove();
				$('body').append(modal);
				$('#modal-media').modal('show');
				$('#modal-media').find('.modal-body').append('<div class="modal-wait"><i class="icon ion-load-a ion-spin"></i></div>');
			},
			complete: function() {
			},
			success: function(html) {
				$('.modal-wait').remove();
				$('body').find('.modal-body').append(html);
			}
		});
	}
</script>

<style>
.modal {
  text-align: center;
  padding: 0!important;
}

.modal:before {
  content: '';
  display: inline-block;
  height: 100%;
  vertical-align: middle;
  margin-right: -4px;
}

.modal-dialog {
  display: inline-block;
  text-align: left;
  vertical-align: middle;
}
</style>
</body>
</html>