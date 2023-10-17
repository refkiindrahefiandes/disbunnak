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
                                    <i class="icon ion-wrench"></i><?php echo lang('text_backup_restore') ?>
                                </div>
                                <div class="tools">
                                    <a class="btn btn-default btn-icon-toggle btn-collapse"><i class="icon ion-chevron-down menu-caret"></i></a>
                                </div>
                            </div>
                            <div id="file-upload" class="card-body">
                                 <div class="text-center" style="padding: 30px 0">
                                    <div class="upload-ui">
                                        <input type="file" id="file-upload-input" name="file" style="display:none;"/>
                                        <h4 class="upload-instructions"><?php echo lang('text_upload_restore') ?></h4>
                                        <br>
                                        <p><button type="button" class="btn ink-reaction btn-raised btn-lg btn-primary" id="btn-upload"><div class="icon ion-load-a ion-spin" style="display: none;"></div> Pilih Berkas</button></p>
                                        <p class="upload-limit"><?php echo lang('text_upload_limit') ?></p>
                                    </div>
                                    <div class="progress" style="display:none;">
                                        <div id="progress-bar" class="progress-bar progress-bar-success progress-bar-striped " role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%;"></div>
                                    </div>
                                    <br>
                                    <h4 class="upload-instructions"><?php echo lang('text_backup_or') ?></h4>
                                    <br>
                                    <?php echo form_open('','id="form-backup" class="form"'); ?>
                                    <?php foreach ($tables as $table) : ?>
                                    <div class="form-group" style="padding-top: 0; display: inline-block; margin-right: 30px">
                                        <div class="checkbox checkbox-styled" style="margin: 0">
                                            <label style="padding-left: 0;">
                                                <input type="checkbox" name="table_data[]" value="<?php echo $table['table_slug']; ?>" class="iCheck" checked>
                                                <span><?php echo $table['table_name']; ?></span>
                                            </label>
                                        </div>
                                    </div>
                                    <?php endforeach ?>
                                    <?php echo form_close();?>
                                </div>
                            </div>
                            <div class="card-footer">
                                <div class="tools">
                                    <div class="btn-group">
                                        <button class="btn btn-primary" type="submit" onclick="$('#form-backup').submit()">
                                            <i class="icon ion-archive"></i> <?php echo lang('btn_dowload_backup') ?>
                                        </button>
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
        var uploadURI   = baseurl + 'admin/tool/upload_backup';
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

                            $('#btn-upload div.icon').hide();

                            $('#file-upload').prepend('<div class="alert alert-warning alert-dismissable"><div class="media"><div class="media-left"><i class="fa fa-warning"></i></div> <div class="media-body">' + json.error + '</div><button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button></div></div>');
                        } else {
                            // Hide progress bar and icon spin
                            $('.progress').hide();
                            progressBar.text("0%");
                            progressBar.css({width: "0%"});

                            $('#btn-upload div.icon').hide();

                            $('#file-upload').prepend('<div class="alert alert-success alert-dismissable"><div class="media"><div class="media-left"><i class="fa fa-warning"></i></div> <div class="media-body">' + json.success + '</div><button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button></div></div>');
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

                                $('#btn-upload div.icon').css('display', 'inline-block');
                            };
                        }, false);

                        return xhr;
                    }
                });
            }
        });
    });
</script>