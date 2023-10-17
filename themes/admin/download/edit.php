<!-- CONTENT -->
<div id="main-content">
    <div id="content">
        <div class="content-wrap scroll-view">
            <!-- <section class="content-header"></section> -->
            <section class="content-body">
                <?php if (isset($this->session->userdata['error'])) {
                    echo '<div class="alert alert-warning alert-dismissable" role="alert">' . $this->session->userdata['error'] . '<button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button></div>';
                } ?>

                <div class="row">
                    <?php echo form_open('', 'class="form"'); ?>
                    <div class="col-md-8">
                        <div class="card card-line">
                            <div class="card-header">
                                <div class="card-header-title">
                                    <i class="icon ion-ios-photos"></i>Edit Download
                                </div>

                                <div class="tools">
                                    <div class="btn-group">
                                        <a class="btn btn-default btn-icon-toggle btn-collapse"><i class="icon ion-chevron-down menu-caret"></i></a>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body tab-content">
                                <div class="form-group <?php if (form_error("name")) {
                                                            echo 'has-error';
                                                        } ?>">
                                    <input type="text" class="form-control" id="name" name="name" value="<?php echo $download['name'] ?>">
                                    <label for="name">Judul <span class="required">*</span></label>
                                    <?php echo form_error("name", '<p class="help-block ">', '</p>'); ?>
                                </div>

                                <div class="form-group <?php if (form_error("filename")) {
                                                            echo 'has-error';
                                                        } ?>">
                                    <div class="input-group <?php if (form_error('filename')) {
                                                                echo 'has-error';
                                                            } ?>">
                                        <div class="input-group-content">
                                            <input type="hidden" name="filename" value="0">
                                            <input type="text" id="filename" name="filename" class="form-control" value="<?php echo $download['filename'] ?>">
                                        </div>
                                        <div class="input-group-btn">
                                            <button type="button" onclick="uploadFile('download')" class="btn btn-primary" data-loading-text="Loading...">Upload File</button>
                                            <?php if ($download['filename']) : ?>
                                                <a href="<?php echo base_url('admin/download/view/download/' . $download['filename'] . '') ?>" class="btn btn-primary" target="_blank">Lihat</a>
                                            <?php endif ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="card card-line">
                            <div class="card-body">
                                <div class="form-group">
                                    <select id="download_category_id" name="download_category_id" class="form-control select2_single">
                                        <?php foreach ($download_categories as $download_category) : ?>
                                            <option value="<?php echo $download_category['download_category_id'] ?>" <?php if ($download['download_category_id'] === $download_category['download_category_id']) echo "selected"; ?>><?php echo $download_category['name']; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                    <label for="download_category_id">Kategori Download</label>
                                </div>

                                <div>
                                    <label class="radio-styled">
                                        <input type="radio" name="status" class="iCheck" value="1" <?php if ($download['status'] == 1) { ?> checked <?php } ?>><span> <?php echo lang('text_enable') ?></span>
                                    </label>
                                    <label class="radio-inline radio-styled">
                                        <input type="radio" name="status" class="iCheck" value="0" <?php if ($download['status'] == 0) { ?> checked <?php } ?>><span> <?php echo lang('text_disable') ?></span>
                                    </label>
                                </div>
                            </div>

                            <div class="card-footer">
                                <div class="tools">
                                    <div class="btn-group">
                                        <a href="<?php echo site_url('admin/download'); ?>" class="btn btn-default" role="button"><i class="icon ion-reply"></i> <?php echo lang('btn_back') ?></a>
                                        <button class="btn btn-primary" type="submit">
                                            <?php echo lang('btn_save') ?>
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

<script>
    // Add File
    function uploadFile(dir) {
        var uploadURI = '<?= base_url() ?>' + 'admin/download/upload/' + dir;

        $('#form-upload').remove();
        $('body').prepend('<form enctype="multipart/form-data" id="form-upload" style="display: none;"><input type="file" name="file" /></form>');
        $('#form-upload input[name=\'file\']').trigger('click');
        if (typeof timer != 'undefined') {
            clearInterval(timer);
        }

        timer = setInterval(function() {
            if ($('#form-upload input[name=\'file\']').val() != '') {
                clearInterval(timer);

                $.ajax({
                    url: uploadURI,
                    type: 'post',
                    dataType: 'json',
                    data: new FormData($('#form-upload')[0]),
                    processData: false,
                    contentType: false,
                    beforeSend: function() {
                        $('#button-upload').button('loading');
                    },
                    complete: function() {
                        $('#button-upload').button('reset');
                    },
                    success: function(json) {
                        if (json['error']) {
                            toastr.options.closeButton = true;
                            toastr.options.hideDuration = 333;
                            toastr["error"](json['error']);
                        } else {
                            toastr.options.closeButton = true;
                            toastr.options.hideDuration = 333;
                            toastr["success"](json['success']);
                            $('input[name=\'filename\']').attr('value', json['filename']);
                        }
                    },
                    error: function(xhr, ajaxOptions, thrownError) {
                        toastr.options.closeButton = true;
                        toastr.options.hideDuration = 333;
                        toastr["error"](thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
                    }
                });
            }
        }, 500);
    }
</script>
<style>
    .editor-tabs {
        text-align: right;
    }

    textarea.form-control {
        margin-top: 10px;
        border: 1px solid #ddd;
        padding: 10px;
    }
</style>