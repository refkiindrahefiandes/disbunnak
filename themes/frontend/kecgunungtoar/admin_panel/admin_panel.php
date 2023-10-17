<!-- CONTENT -->
<div id="main-content">
	<div id="content">
		<div class="content-wrap scroll-view">
			<section class="content-body">
				<?php if (isset($this->session->userdata['error'])) {
					echo '<div class="alert alert-warning alert-dismissable" role="alert">' . $this->session->userdata['error'] . '<button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button></div>';
				} ?>
				<?php if (isset($this->session->userdata['success'])) {
					echo '<div class="alert alert-success alert-dismissable" role="alert">' . $this->session->userdata['success'] . '<button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button></div>';
				} ?>

				<div class="row">
					<?php echo form_open('', 'class="form"') ?>
					<div class="col-md-12">
						<div class="card card-line tabs-h-left">
							<div class="card-header">
								<ul class="nav nav-tabs" role="tablist">
									<li class="active" role="presentation">
										<a aria-controls="general" aria-expanded="true" data-toggle="tab" href="#general" role="tab">
											<span>General Settings</span>
										</a>
									</li>
									<li class="" role="presentation">
										<a aria-controls="general" aria-expanded="true" data-toggle="tab" href="#organisation" role="tab">
											<span>Organisasi</span>
										</a>
									</li>
									<li class="" role="presentation">
										<a aria-controls="about-us" aria-expanded="false" data-toggle="tab" href="#about-us" role="tab">
											<span>Footer About Us</span>
										</a>
									</li>
									<li class="" role="presentation">
										<a aria-controls="footer-script" aria-expanded="false" data-toggle="tab" href="#footer-script" role="tab">
											<span>Footer Custom Script</span>
										</a>
									</li>
								</ul>
							</div>
							<div class="card-body">
								<div class="tab-content">
									<div class="tab-pane fade active in" id="general" role="tabpanel">
										<div class="form-group">
											<input class="form-control jscolor" id="navbar_header_bg" name="navbar_header_bg" type="text" value="<?php echo $theme_option['navbar_header_bg'] ?>" style="padding-left: 10px"></input>
											<label for="navbar_header_bg">Navbar Header Background</label>
										</div>
										<div class="form-group">
											<input class="form-control jscolor" id="footer_bg" name="footer_bg" type="text" value="<?php echo $theme_option['footer_bg'] ?>" style="padding-left: 10px"></input>
											<label for="footer_bg">Footer Background</label>
										</div>
										<div class="form-group">
											<input class="form-control" id="location" name="location" type="text" value="<?php echo $theme_option['location'] ?>" style="padding-left: 10px"></input>
											<label for="location">Koordinat Lokasi (Lat, Lang)</label>
										</div>
										<div class="form-group">
											<textarea class="form-control textarea" id="web_profile" name="web_profile" rows="3"><?php echo $theme_option['web_profile'] ?></textarea>
											<label for="web_profile">Profil Website</label>
										</div>
										<div class="form-group">
											<input class="form-control" id="web_profile_url" name="web_profile_url" type="text" value="<?php echo $theme_option['web_profile_url'] ?>" style="padding-left: 10px"></input>
											<label for="web_profile_url">URL Baca Profil Lengkap</label>
										</div>
									</div>
									<div class="tab-pane fade" id="organisation" role="tabpanel">
										<div class="form-group">
											<input class="form-control" id="organisation_visi" name="organisation_visi" type="text" value="<?php echo $theme_option['organisation_visi'] ?>" style="padding-left: 10px"></input>
											<label for="organisation_visi">Visi</label>
										</div>
										<div class="form-group">
											<textarea class="form-control textarea" id="organisation_misi" name="organisation_misi" rows="3"><?php echo $theme_option['organisation_misi'] ?></textarea>
											<label for="organisation_misi">Misi</label>
										</div>
										<div class="form-group">
											<textarea class="form-control textarea" id="organisation_tata_nilai" name="organisation_tata_nilai" rows="3"><?php echo $theme_option['organisation_tata_nilai'] ?></textarea>
											<label for="organisation_tata_nilai">Tata Nilai</label>
										</div>
										<div class="form-group">
											<textarea class="form-control textarea" id="organisation_motto" name="organisation_motto" rows="3"><?php echo $theme_option['organisation_motto'] ?></textarea>
											<label for="organisation_motto">Motto</label>
										</div>
										<div class="form-group">
											<textarea class="form-control textarea" id="organisation_janji_pelayanan" name="organisation_janji_pelayanan" rows="3"><?php echo $theme_option['organisation_janji_pelayanan'] ?></textarea>
											<label for="organisation_janji_pelayanan">Janji Pelayanan</label>
										</div>
									</div>
									<div class="tab-pane fade" id="about-us" role="tabpanel">
										<div class="col-md-8">
											<div class="form-group">
												<input class="form-control" id="about_us_title" name="about_us_title" type="text" value="<?php echo $theme_option['about_us_title'] ?>"></input>
												<label for="about_us_title">Footer About Us Title</label>
											</div>
											<div class="form-group">
												<textarea class="form-control" id="about_us_description" name="about_us_description" rows="3"><?php echo $theme_option['about_us_description'] ?></textarea>
												<label for="about_us_description">Footer About Us Description</label>
											</div>
											<div class="form-group">
												<input class="form-control" id="about_us_location" name="about_us_location" type="text" value="<?php echo $theme_option['about_us_location'] ?>"></input>
												<label for="about_us_location">Footer About Us Location (Lat, Lang)</label>
											</div>
										</div>
										<div class="col-md-4">
											<div id="post-thumbnail">
												<label for="about_us_description">Footer About Us Image</label>
												<div class="thumbnail-image">
													<a id="thumb-image" data-toggle="image-thumb" style="min-height: 150px; display: block;"><img src="<?php echo base_url($theme_option['about_us_image']) ?>" alt=""></a>
													<input type="hidden" name="about_us_image" value="<?php echo $theme_option['about_us_image']; ?>" id="input-image" />
												</div>
											</div>
										</div>
										<div class="col-md-12">
											<table id="form-list-images" class="table">
												<label for="about_us_description">Footer About Us Social</label>
												<thead>
													<tr>
														<th>Icon</th>
														<th>URL</th>
														<th>Status</th>
														<th class="text-center">Actions</th>
													</tr>
												</thead>
												<tbody>
													<?php $icon_row = 0; ?>
													<?php if (isset($theme_option['about_us_social'])) : foreach ($theme_option['about_us_social'] as $key => $social) : ?>
															<tr>
																<td>
																	<!-- <a id="thumb-image<?php echo $key; ?>" data-toggle="image-thumb"><img src="<?php echo image_thumb($social['social_image'], 'small') ?>" alt="" class="tbl-image-square"></a>
																	<input type="hidden" name="about_us_social[<?php echo $key; ?>][social_image]" value="<?php echo $social['social_image'] ?>" id="input-image<?php echo $key; ?>" /> -->
																	<input type="text" class="table-normal-input" name="about_us_social[<?php echo $key; ?>][social_icon]" value="<?php echo $social['social_icon']; ?>">
																</td>
																<td>
																	<input type="text" class="table-normal-input" name="about_us_social[<?php echo $key; ?>][social_url]" value="<?php echo $social['social_url']; ?>">
																</td>
																<td>
																	<input type="checkbox" name="about_us_social[<?php echo $key; ?>][status]" checked class="switch-onoff" value="<?php echo $social['status']; ?>">
																</td>
																<td class="text-center">
																	<button type="button" class="btn btn-default btn-icon-toggle" data-toggle="tooltip" data-placement="top" data-original-title="Delete" onclick="itemRemove(this);"><i class="icon ion-trash-a"></i></button>
																</td>
															</tr>
															<?php $icon_row++; ?>
														<?php endforeach; ?>
													<?php endif; ?>
												</tbody>
												<tfoot>
													<tr>
														<td colspan="4">
															<div class="btn-group pull-right">
																<button type="button" class="btn btn-default" onclick="addSocial()"><i class="icon ion-plus"></i> Add Social Media</button>
															</div>
														</td>
													</tr>
												</tfoot>
											</table>
										</div>
									</div>
									<div class="tab-pane fade" id="footer-script" role="tabpanel">
										<div class="form-group">
											<textarea class="form-control" id="footer_script" name="footer_script" rows="3"><?php echo $theme_option['footer_script'] ?></textarea>
											<label for="footer_script">Footer Custom Script</label>
										</div>
									</div>
								</div>
							</div>
							<div class="card-footer">
								<div class="tools">
									<div class="btn-group">
										<button class="btn btn-primary" type="submit">
											Save settings
										</button>
									</div>
								</div>
							</div>
						</div>
					</div>
					<?php echo form_close(); ?>
				</div>
			</section>
		</div>
	</div>
</div>
<?php load_script($file_dir . "admin_panel/jscolor/jscolor.min.js"); ?>
<?php //load_style($file_dir . "admin_panel/jscolor/jscolor.min.css"); 
?>

<script type="text/javascript">
	$(document).ready(function() {
		// Call TinyMCE
		<?php tmce_init('200') ?>

		// Ajax request
		var ajaxRequest = function(Url, Data) {
			$.ajax({
				url: Url,
				dataType: 'html',
				beforeSend: function() {
					$('body').append('<div id="modal-media" class="modal fade"tabindex="-1" role="dialog" aria-labelledby="modal-media" aria-hidden="true"><div class="modal-dialog modal-lg"><div class="modal-content"><div class="modal-header"><button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button><h4 class="modal-title">Media Manager</h4></div><div class="modal-body"><div class="card tabs-h-left transparent media-manager" style="margin: 0"></div></div></div></div></div>');
					$('#modal-media').modal('show');
					$('#modal-media').find('.tabs-h-left').append('<div class="modal-wait"><i class="icon ion-load-a ion-spin"></i></div>');
				},
				complete: function() {
					$('#button-media').prop('disabled', false);
				},
				success: function(html) {
					$('.modal-wait').remove();
					$('body').find('.media-manager').append(html);
				}
			});
		};

		// Thumnbnail image manager
		$(document).delegate('a[data-toggle=\'image-thumb\']', 'click', function(e) {
			e.preventDefault();
			var element = this;
			$(element).popover({
				html: true,
				placement: 'bottom',
				trigger: 'manual',
				content: function() {
					return '<div class="btn-group"><button type="button" id="button-image" class="btn btn-primary"><i class="icon ion-edit"></i></button> <button type="button" id="button-clear" class="btn btn-danger"><i class="icon ion-trash-a"></i></button></div>';
				}
			});

			$(element).popover('toggle');

			$('#button-image').on('click', function() {
				$('#modal-media').remove();

				var Url = "<?php echo base_url('admin/media/file_manager/'); ?>" + $(element).parent().find('input').attr('id') + '/' + $(element).attr('id');
				ajaxRequest(Url);

				$(element).popover('hide');
			});

			$('#button-clear').on('click', function() {
				$(element).find('img').attr('src', "<?php echo base_url('uploads/images/default-thumbnail.png'); ?>");
				$(element).parent().find('input').attr('value', '');
				$(element).popover('hide');
			});
		});
	});

	// Add Image
	var icon_row = <?php echo $icon_row; ?>;

	function addSocial() {
		html = '<tr>';
		// html += '<td>';
		// html += '<div class="image-upload">';
		// html += '<a id="thumb-image' + icon_row + '" data-toggle="image-thumb"><img src="<?php echo base_url("uploads/images/default/default-thumbnail.png"); ?>" alt="" class="tbl-image-square"></a>';
		// html += '<input type="hidden" name="about_us_social[' + icon_row + '][social_image]" value="" id="input-image' + icon_row + '" />';
		// html += '</div>';
		// html += '</td>'
		html += '<td>';
		html += '<input type="text" class="table-normal-input" name="about_us_social[' + icon_row + '][social_icon]" value="">';
		html += '</td>';
		html += '<td>';
		html += '<input type="text" class="table-normal-input" name="about_us_social[' + icon_row + '][social_url]" value="">';
		html += '</td>';
		html += '<td>';
		html += '<input type="checkbox" name="about_us_social[' + icon_row + '][status]" checked value="1" class="switch-onoff">';
		html += '</td>';
		html += '<td class="text-center">';
		html += '<button type="button" class="btn btn-default btn-icon-toggle" data-toggle="tooltip" data-placement="top" data-original-title="Delete" onclick="itemRemove(this);"><i class="icon ion-trash-a"></i></button>';
		html += '</td>';
		html += '</tr>';

		$('#form-list-images').append(html);

		$.fn.bootstrapSwitch.defaults.size = 'mini';
		$('.switch-onoff').bootstrapSwitch();

		icon_row++;
	}

	// Remove Item
	function itemRemove(select) {
		$(select).parent().parent().remove();
		$('.tooltip').remove();
	}
</script>