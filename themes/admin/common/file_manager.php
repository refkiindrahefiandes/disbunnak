<div class="card-header">
	<ul class="nav nav-tabs" role="tablist">
		<li class="active" role="presentation">
			<a aria-expanded="true" data-toggle="tab" href="#media-lib-tab" role="tab">
				Library
			</a>
		</li>
		<li role="presentation">
			<a aria-expanded="false" data-toggle="tab" href="#media-upload-tab" role="tab">
				Upload File
			</a>
		</li>
	</ul>
</div>
<div class="card-body" style="padding: 0 0 10px 10px;">
	<div class="tab-content">
		<div class="tab-pane fade in active" id="media-lib-tab" role="tabpanel">
			<div class="media-lib-tools form">
				<div class="col-md-4">
					<select id="file-type" name="file-type" class="form-control">
						<option value="all">All</option>
						<option value="file">Only files</option>
						<option value="image">Only Images</option>
					</select>
				</div>

				<div class="input-group col-md-4 pull-right">
					<span class="input-group-addon">
						<i class="icon ion-search"></i>
					</span>
					<input id="search-file" class="form-control" placeholder="Search file" type="text"></input>
				</div>
			</div>
			<ul id="media-lib-tab-list" class="list-unstyled nicescroll" style="height: 450px;">
				<div id="media-loadmore">
					<a class="loadmore" data-toggle="tooltip" title="" data-original-title="Load more">
						Load more
					</a>
				</div>
			</ul>
		</div>
		<div class="tab-pane fade" id="media-upload-tab" role="tabpanel">
			<div class="upload-ui">
				<input type="file" id="file-upload-input" name="file" style="display:none;" />
				<h3 class="upload-instructions">Letakkan berkas di mana saja untuk diunggah</h3>
				<p class="upload-instructions">atau</p>
				<p><button type="button" class="btn ink-reaction btn-raised btn-lg btn-primary" id="btn-upload">Pilih Berkas</button></p>
				<p class="upload-limit">Ukuran maksimal unggahan berkas: 2 MB.</p>
			</div>
			<div class="progress" style="display:none;">
				<div id="progress-bar" class="progress-bar progress-bar-success progress-bar-striped " role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%;"></div>
			</div>
		</div>
	</div>
</div>

<script>
	$(document).ready(function() {
		var baseurl = '<?= base_url() ?>';
		var inputFile = $('input[name=file]');
		var loadURI = baseurl + 'admin/media/ajax_load/';
		var uploadURI = baseurl + 'admin/media/upload/';
		var Data = [];
		var progressBar = $('#progress-bar');

		// Nicescroll
		$(".nicescroll").niceScroll({
			cursorcolor: "#cdd2d6",
			cursorwidth: "4px",
			cursorborder: "none"
		});

		// Ajax request
		var ajaxRequest = function(Url, Data) {
			$.ajax({
				url: Url,
				type: 'post',
				data: Data,
				dataType: 'json',
				beforeSend: function() {
					$('#media-lib-tab-list').append('<div class="modal-wait" style="position: absolute; top: 100px; left: 50%;"><i class="icon ion-load-a ion-spin"></i></div>');
				},
				success: function(json) {
					$('.modal-wait').remove();
					if (json['results']) {
						if (json['clear_list'] === 'true') {
							$('#media-lib-tab-list li').remove();
						}

						if (json['offset'] >= json['totals']) {
							$('#media-loadmore').css('display', 'none');
						} else {
							$('#media-loadmore').css('display', 'block');
						}

						$.each(json['results'], function(i, item) {
							file = '<li>';
							file += '<a href="' + baseurl + item.server_path + '" data-file="' + item.server_path + '" data-type="' + item.is_image + '" class="thumb" title="' + item.name + '">';
							file += '<img src="' + item.thumb + '" alt="">';
							file += '<input type="checkbox" name="path[]" value="' + item.server_path + '"/>';
							file += '</a>';
							file += '<a data-file="' + item.server_path + '" class="remove-file"><i class="icon ion-trash-a"></i></a>';
							file += '</li>';

							$("#media-loadmore").before(file);
						});
					}

					$('nicescroll').getNiceScroll().resize();
				}
			});
		};

		// Triger select on page load
		$('select[name=\'file-type\']').bind('change', function() {
			var search = $('#search-file').val();
			Data = {
				file_type: $(this).val(),
				search: search
			};
			ajaxRequest(loadURI, Data);
		});
		$('select[name=\'file-type\']').trigger('change');

		// Search file
		$("#search-file").keypress(function() {
			var file_type = $('select[name=\'file-type\']').val();
			var me = $(this);

			window.setTimeout(function() {
				Data = {
					file_type: file_type,
					search: me.val()
				};
				ajaxRequest(loadURI, Data);
			}, 0);
		});

		// Load more
		$('#media-loadmore').on('click', "a.loadmore", function(e) {
			e.preventDefault();
			var file_type = $('select[name=\'file-type\']').val();
			var search = $('#search-file').val();
			var offset = $('#media-lib-tab-list li').length;
			Data = {
				file_type: file_type,
				search: search,
				offset: offset
			};
			ajaxRequest(loadURI, Data);
		});

		// Upload file
		$('#btn-upload').on('click', function(e) {
			e.preventDefault();
			$('#file-upload-input').trigger('click');
			$('.progress').hide();
			progressBar.text("0%");
			progressBar.css({
				width: "0%"
			});
			$('#media-upload-tab .alert').remove();
		});

		$('#file-upload-input').change(function() {
			var fileToUpload = inputFile[0].files[0];

			if (fileToUpload != 'undefined') {
				var formData = new FormData();
				formData.append("file", fileToUpload);

				// now upload the file using $.ajax
				$.ajax({
					url: uploadURI,
					type: 'post',
					data: formData,
					processData: false,
					contentType: false,
					dataType: 'json',
					success: function(json) {
						// Check for error
						if (json['error']) {
							$('#media-upload-tab').prepend('<div class="alert alert-warning alert-dismissable"><div class="media"><div class="media-left"><i class="fa fa-warning"></i></div> <div class="media-body">' + json['error'] + '</div><button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button></div></div>');
						} else {
							// Hide progress bar
							$('.progress').hide();
							progressBar.text("0%");
							progressBar.css({
								width: "0%"
							});

							// Add file data to #file-upload-tab-list
							file = '<li>';
							file += '<a href="' + baseurl + json['path'] + '" data-file="' + json['path'] + '" data-type="' + json['is_image'] + '" class="thumb" title="' + json['name'] + '">';
							file += '<img src="' + json['url'] + '" alt="">';
							file += '<input type="checkbox" name="path[]" value="' + json['path'] + '"/>';
							file += '</a>';
							file += '<a data-file="' + json['path'] + '" class="remove-file"><i class="icon ion-trash-a"></i></a>';
							file += '</li>';

							$("#media-lib-tab-list").prepend(file);

							// Change visible tab
							$('a[href="#media-lib-tab"]').tab('show');
						}
					},
					xhr: function() {
						var xhr = new XMLHttpRequest();
						xhr.upload.addEventListener("progress", function(event) {
							if (event.lengthComputable) {
								var percentComplete = Math.round((event.loaded / event.total) * 100);

								$('.progress').show();
								progressBar.css({
									width: percentComplete + "%"
								});
								progressBar.text(percentComplete + '%');
							};
						}, false);

						return xhr;
					}
				});
			}
		});

		// Insert file to form
		$('#media-lib-tab').on('click', "a.thumb", function(e) {
			e.preventDefault();

			var is_image = $(this).attr('data-type');

			<?php if ($thumb) { ?>
				if (is_image == 1) {
					$('#<?php echo $thumb; ?>').find('img').attr('src', $(this).find('img').attr('src'));
				}
			<?php } ?>

			<?php if ($target) { ?>
				if (is_image == 1) {
					$('#<?php echo $target; ?>').attr('value', $(this).find('input').attr('value'));
				}
			<?php } else { ?>

				if (is_image == 1) {
					var src = $(this).attr('href');
					tinymce.activeEditor.insertContent('<img src="' + src + '"/>');
				} else {
					var src = $(this).attr('href');
					tinymce.activeEditor.insertContent('<a href="' + src + '"/>' + src + '</a>');
				}
			<?php } ?>

			$('#modal-media').modal('hide');
		});

		// Delete file
		$('#media-lib-tab-list').on('click', "a.remove-file", function(e) {
			e.preventDefault();
			var me = $(this);
			$.ajax({
				url: baseurl + 'admin/media/delete/',
				type: 'post',
				data: {
					file_to_remove: me.attr('data-file')
				},
				success: function() {
					me.closest('li').remove();
				}
			});
		})
	});
</script>

<style>
	#media-loadmore {
		padding: 0 5px;
	}

	#media-loadmore a {
		padding: 5px;
		display: block;
		color: #555;
		background: #ddd;
		clear: both;
		text-align: center;
		cursor: pointer;
		text-decoration: none;
	}

	#media-loadmore a:hover {
		color: #eee;
		background: #38938a;
	}
</style>