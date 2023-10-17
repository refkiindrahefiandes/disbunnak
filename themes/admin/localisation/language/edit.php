<!-- CONTENT -->
<div id="main-content">
    <div id="content">
        <div class="content-wrap scroll-view">
            <!-- <section class="content-header"></section> -->
            <section class="content-body">
                <?php if (isset($this->session->userdata['error'])) { echo '<div class="alert alert-warning alert-dismissable" role="alert">' . $this->session->userdata['error'] . '<button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button></div>'; } ?>

                <div class="row">
                <?php echo form_open('','class="form"'); ?>
                    <input type="hidden" name="language_id" value="<?php echo $languages['language_id']; ?>">
                    <div class="col-md-8">
                        <div class="card card-line">
                            <div class="card-header">
                                <div class="card-header-title">
                                <i class="icon ion-earth"></i><?php echo lang('text_edit_language') ?>
                                </div>

                                <div class="tools">
                                    <div class="btn-group">
                                        <a class="btn btn-default btn-icon-toggle btn-collapse"><i class="icon ion-chevron-down menu-caret"></i></a>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="form-group <?php if (form_error("name")) { echo 'has-error';  } ?>">
                                    <input type="text" class="form-control" id="name" name="name" value="<?php echo $languages['name']; ?>">
                                    <label for="name"><?php echo lang('text_language_name') ?> <span class="required">*</span></label>
                                    <?php echo form_error("name", '<p class="help-block ">', '</p>'); ?>
                                </div>
                                <div class="form-group <?php if (form_error("language_code")) { echo 'has-error';  } ?>">
                                    <input type="text" class="form-control" id="language_code" name="language_code" value="<?php echo $languages['language_code']; ?>">
                                    <label for="language_code"><?php echo lang('text_iso_code') ?> <span class="required">*</span></label>
                                    <?php echo form_error("language_code", '<p class="help-block ">', '</p>'); ?>
                                </div>
                                <div class="form-group <?php if (form_error("locale")) { echo 'has-error';  } ?>">
                                    <input type="text" class="form-control" id="locale" name="locale" value="<?php echo $languages['locale']; ?>">
                                    <label for="locale"><?php echo lang('text_locale') ?> <span class="required">*</span></label>
                                    <?php echo form_error("locale", '<p class="help-block ">', '</p>'); ?>
                                </div>
                                <div class="form-group <?php if (form_error("image")) { echo 'has-error';  } ?>">
                                    <select id="image" name="image" class="form-control select2_single" style="width: 50%;">
                                        <?php foreach( $flags as $flag ): ?>
                                        <option value="<?php echo $flag ?>" <?php if($flag == $languages['image']) echo "selected"; ?> ><?php echo $flag; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                    <label for="image"><?php echo lang('text_thumbnail') ?> <span class="required">*</span></label>
                                    <?php echo form_error("image", '<p class="help-block ">', '</p>'); ?>
                                </div>
                                <div class="form-group <?php if (form_error("date_format_lite")) { echo 'has-error';  } ?>">
                                    <input type="text" class="form-control" id="date_format_lite" name="date_format_lite" value="<?php echo $languages['date_format_lite']; ?>">
                                    <label for="date_format_lite"><?php echo lang('text_date_format') ?> <span class="required">*</span></label>
                                    <?php echo form_error("date_format_lite", '<p class="help-block ">', '</p>'); ?>
                                </div>
                                <div class="form-group <?php if (form_error("date_format_full")) { echo 'has-error';  } ?>">
                                    <input type="text" class="form-control" id="date_format_full" name="date_format_full" value="<?php echo $languages['date_format_full']; ?>">
                                    <label for="date_format_full"><?php echo lang('text_date_format_full') ?> <span class="required">*</span></label>
                                    <?php echo form_error("date_format_full", '<p class="help-block ">', '</p>'); ?>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="card card-line">
                            <div class="card-body">
                                <div class="form-group">
                                    <input type="text" class="form-control" id="sort_order" name="sort_order" value="<?php echo $languages['sort_order']; ?>">
                                    <label for="sort_order"><?php echo lang('text_sort_order') ?></label>
                                </div>
                                <div>
                                    <label class="radio-inline radio-styled">
                                        <input type="radio" name="status" value="1" <?php if( $languages['status'] == 1){ ?> checked <?php } ?>><span> <?php echo lang('text_enable') ?></span>
                                    </label>
                                    <label class="radio-inline radio-styled">
                                        <input type="radio" name="status" value="0" <?php if( $languages['status'] == 0){ ?> checked <?php } ?>><span> <?php echo lang('text_disable') ?></span>
                                    </label>
                                </div>
                            </div>

                            <div class="card-footer">
                                <div class="tools">
                                    <div class="btn-group">
                                        <a href="<?php echo site_url('admin/localisation/language'); ?>" class="btn btn-default" role="button"><i class="icon ion-reply"></i> <?php echo lang('btn_back') ?></a>
                                        <button class="btn btn-primary" type="submit">
                                            <?php echo lang('btn_save') ?>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php echo form_close();?>
                </div>
            </section>
        </div>
    </div>
</div>

<script>
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

    // TinyMCE image manager plugin
    (function($) {
        tinymce.create('tinymce.plugins.mediamanager', {
            init: function(editor, url) {
                editor.addButton('mediamanager', {
                    text: 'Insert Media',
                    icon: 'image',
                    onclick: function() {
                        $('#modal-media').remove();
                        var Url = "<?php echo base_url('admin/media/file_manager/'); ?>";
                        ajaxRequest(Url);
                    }
                });
            }
        });
        tinymce.PluginManager.add('mediamanager', tinymce.plugins.mediamanager);
    })($);

    // Tinymce init
    tinymce.init({
        selector: "textarea.textarea",
        theme: "modern",
        plugins: ["mediamanager, image, link, code, table, fullscreen, paste"],
        content_css: "<?php echo ADMIN_ASSETS_URL . 'css/libs/tinymce.content.css'; ?>",
        menubar: false,
        statusbar: false,
        relative_urls: false,
        remove_script_host: false,
        convert_urls: true,
        toolbar: "insertfile undo redo styleselect bold italic underline forecolor alignleft aligncenter alignright alignjustify bullist numlist outdent indent | table link code fullscreen mediamanager"
    });

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

    // Multiple select
    $(".select2_multiple").select2({
        // maximumSelectionLength: 4,
        placeholder: "Select Category",
        allowClear: true
    });
</script>