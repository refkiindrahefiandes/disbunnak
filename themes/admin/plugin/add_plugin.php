<!-- CONTENT -->
<div id="main-content">
    <div id="content">
        <div class="content-wrap scroll-view">
            <!-- <section class="content-header"></section> -->
            <section class="content-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card card-line">
                            <div class="card-header">
                                <div class="card-header-title">
                                    <i class="icon ion-paintbrush"></i><?php echo lang('text_edit_plugin') ?>
                                </div>
                                <div class="tools">
                                    <div class="btn-group">
                                        <a href="<?php echo site_url('admin/plugin'); ?>" class="btn btn-default" role="button"><i class="icon ion-reply"></i> <?php echo lang('btn_back') ?></a>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body" id="file-upload">
                                 <div class="text-center" style="padding: 30px 0">
                                    <div class="upload-ui">
                                        <input type="file" id="file-upload-input" name="file" style="display:none;"/>
                                        <h4 class="upload-instructions"><?php echo lang('text_upload_plugin') ?></h4>
                                        <br>
                                        <p><button type="button" class="btn ink-reaction btn-raised btn-lg btn-primary" id="btn-upload"><?php echo lang('btn_select_file') ?></button></p>
                                        <p class="upload-limit"><?php echo lang('text_upload_limit') ?></p>
                                    </div>
                                    <div class="progress" style="display:none;">
                                        <div id="progress-bar" class="progress-bar progress-bar-success progress-bar-striped " role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%;"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        var baseurl     = '<?=base_url()?>';
        var inputFile   = $('input[name=file]');
        var uploadURI   = baseurl + 'admin/plugin/upload_plugin';
        var progressBar = $('#progress-bar');

        $('#btn-upload').on('click', function(e) {
            e.preventDefault();
            $('#file-upload-input').trigger('click');
            $('.progress').hide();
            progressBar.text("0%");
            progressBar.css({width: "0%"});
            $('#file-upload .alert').remove();
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
                        if (json['error']) {
                            $('.progress').hide();
                            $('#file-upload').prepend('<div class="alert alert-warning alert-dismissable"><div class="media"><div class="media-left"><i class="fa fa-warning"></i></div> <div class="media-body">' + json.error + '</div><button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button></div></div>');
                        } else {
                            // Hide progress bar
                            $('.progress').hide();
                            progressBar.text("0%");
                            progressBar.css({width: "0%"});

                            // Redirect
                            if (json.redirect !== undefined && json.redirect) {
                                window.location.href = json.redirect_url;
                            }
                        }
                    },
                    xhr: function() {
                        var xhr = new XMLHttpRequest();
                        xhr.upload.addEventListener("progress", function(event) {
                            if (event.lengthComputable) {
                                var percentComplete = Math.round( (event.loaded / event.total) * 100 );

                                $('.progress').show();
                                progressBar.css({width: percentComplete + "%"});
                                progressBar.text(percentComplete + '%');
                            };
                        }, false);

                        return xhr;
                    }
                });
            }
        });
    });
</script>