<!-- CONTENT -->
<div id="main-content">
    <div id="content">
        <div class="content-wrap scroll-view">
            <!-- <section class="content-header"></section> -->
            <section class="content-body">
                <?php if (isset($this->session->userdata['error'])) {
                    echo '<div class="alert alert-warning alert-dismissable" role="alert">' . $this->session->userdata['error'] . '<button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button></div>';
                } ?>
                <?php echo validation_errors('<div class="alert alert-warning alert-dismissable" role="alert">', '<button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button></div>'); ?>

                <div class="row">
                    <?php echo form_open('', 'class="form"'); ?>
                    <input type="hidden" name="layanan_data[layanan_id]" value="<?php echo $layanan['layanan_data']['layanan_id']; ?>">
                    <div class="col-md-8">
                        <div class="card card-line">
                            <div class="card-header">
                                <div class="card-header-title">
                                    <i class="icon ion-ios-photos"></i><?php echo lang('text_edit_service') ?>
                                </div>

                                <div class="tools">
                                    <div class="btn-group">
                                        <a class="btn btn-default btn-icon-toggle btn-collapse"><i class="icon ion-chevron-down menu-caret"></i></a>
                                    </div>
                                </div>

                                <ul class="nav nav-tabs pull-right" data-toggle="tabs">
                                    <?php foreach ($languages as $language) : ?>
                                        <li <?php if ($language['language_code'] == $language_code) { ?> class="active" <?php } ?>><a href="#tab-language-<?php echo $language['language_code']; ?>" aria-controls="#tab-language-<?php echo $language['language_code']; ?>" role="tab" data-toggle="tab"><img src="<?php echo ADMIN_ASSETS_URL . 'images/flags/' . $language['image']; ?>" alt=""> <span class="hidden-xs"> <?php echo $language['name']; ?></span></a></li>
                                    <?php endforeach; ?>
                                </ul>
                            </div>
                            <div class="card-body tab-content">
                                <?php foreach ($languages as $language) : ?>
                                    <div class="tab-pane <?php if ($language['language_code'] == $language_code) { ?> active <?php } ?>" id="tab-language-<?php echo $language['language_code']; ?>" role="tabpanel">
                                        <div class="form-group <?php if (form_error("layanan_data[title]")) {
                                                                        echo 'has-error';
                                                                    } ?>">
                                            <input type="text" class="form-control" id="name-<?php echo $language['language_code']; ?>" name="layanan_data[title]" value="<?php echo $layanan['layanan_data']['title'] ?>">
                                            <label for="name-<?php echo $language['language_code']; ?>"><?php echo lang('text_service_title') ?> <span class="required">*</span></label>
                                            <?php echo form_error("layanan_data[title]", '<p class="help-block ">', '</p>'); ?>
                                        </div>
                                        <div class="form-group">
                                            <div class="editor-tabs">
                                                <div class="btn-group text-left">
                                                    <button id="add-media-<?php echo $language['language_code']; ?>" class="btn btn-info" type="button" onclick="editor.addmedia('<?php echo $language['language_code']; ?>');"><i class="icon ion-image"></i> Tambahkan Media</button>
                                                </div>
                                                <div class="btn-group text-right">
                                                    <button id="content-tmce-<?php echo $language['language_code']; ?>" class="btn btn-primary" type="button" onclick="editor.tmce('<?php echo $language['language_code']; ?>');"><i class="icon ion-eye"></i> Visual</button>
                                                    <button id="content-html-<?php echo $language['language_code']; ?>" class="btn btn-primary" type="button" onclick="editor.html('<?php echo $language['language_code']; ?>');"><i class="icon ion-code"></i> Text</button>
                                                </div>
                                            </div>
                                            <textarea name="layanan_data[description]" id="textarea-<?php echo $language['language_code']; ?>" class="form-control textarea" rows="15"><?php echo $layanan['layanan_data']['description'] ?></textarea>
                                            <label for="textarea-<?php echo $language['language_code']; ?>"><?php echo lang('text_description') ?></label>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="card card-line">
                            <div class="card-body">
                                <div class="form-group">
                                    <input type="text" class="form-control" id="sort_order" name="layanan_data[sort_order]" value="<?php echo $layanan['layanan_data']['sort_order']; ?>">
                                    <label for="sort_order"><?php echo lang('text_sort_order') ?></label>
                                </div>
                                <?php if ($publish_permission) : ?>
                                    <div>
                                        <label class="radio-styled">
                                            <input type="radio" name="layanan_data[status]" class="iCheck" value="1" <?php if ($layanan['layanan_data']['status'] == 1) { ?> checked <?php } ?>><span> <?php echo lang('text_publish') ?></span>
                                        </label>
                                        <label class="radio-inline radio-styled">
                                            <input type="radio" name="layanan_data[status]" class="iCheck" value="0" <?php if ($layanan['layanan_data']['status'] == 0) { ?> checked <?php } ?>><span> <?php echo lang('text_unpublish') ?></span>
                                        </label>
                                    </div>
                                <?php endif ?>
                            </div>

                            <div class="card-footer">
                                <div class="tools">
                                    <div class="btn-group">
                                        <a href="<?php echo site_url('admin/layanan'); ?>" class="btn btn-default" role="button"><i class="icon ion-reply"></i> <?php echo lang('btn_back') ?></a>
                                        <button class="btn btn-primary" type="submit">
                                            <?php echo $button; ?>
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
    $(document).ready(function() {
        // Call TinyMCE
        <?php tmce_init() ?>

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
    });

    // Add Image Galery
    function addImage(image_row) {
        var add_row = image_row + 1;
        html = '<tr>';
        html += '<input type="hidden" name="post_image[' + image_row + '][page_image_id]" value="" />';
        html += '<td>';
        html += '<a id="thumb-image' + image_row + '" data-toggle="image-thumb"><img src="<?php echo image_thumb('uploads/images/default/default-thumbnail.png'); ?>" alt="" class="tbl-image-square"></a>';
        html += '<input type="hidden" name="post_image[' + image_row + '][image]" value="" id="input-image' + image_row + '"/>';
        html += '</td>';
        html += '<td>';
        html += '<input type="checkbox" name="post_image[' + image_row + '][status]" checked class="switch-onoff" value="1">';
        html += '</td>';
        html += '<td class="text-center">';
        html += '<button type="button" class="btn btn-default btn-icon-toggle" data-toggle="tooltip" data-placement="top" data-original-title="Delete" onclick="itemRemove(this);"><i class="icon ion-trash-a"></i></button>';
        html += '</td>';
        html += '</tr>';
        html += '<tr><td colspan="4"><button type="button" class="btn btn-primary pull-right" onclick="addImage(' + add_row + '); $(this).parent().parent().remove();"><i class="icon ion-plus"></i> Add Image</button></td></tr>';

        $('#form-list-images').append(html);

        $.fn.bootstrapSwitch.defaults.size = 'mini';
        $('.switch-onoff').bootstrapSwitch();

        image_row++;
    }

    // Switch editor
    var editor = {
        'html': function(id) {
            $('#content-html-' + id).addClass('active');
            $('#content-tmce-' + id).removeClass('active');
            tinymce.EditorManager.execCommand('mceRemoveEditor', true, 'textarea-' + id);
        },
        'tmce': function(id) {
            $('#content-tmce-' + id).addClass('active');
            $('#content-html-' + id).removeClass('active');
            tinymce.EditorManager.execCommand('mceAddEditor', true, 'textarea-' + id);
        },
        'addmedia': function(id) {
            $('#modal-media').remove();
            var Url = "<?php echo base_url('admin/media/file_manager/'); ?>";
            ajaxRequest(Url);
        }
    }

    // Remove Item
    function itemRemove(select) {
        $(select).parent().parent().remove();
        $('.tooltip').remove();
    }
</script>
<style>
    .editor-tabs {
        text-align: right;
    }

    .thumbnail-image img {
        width: 100%;
    }

    textarea.form-control {
        margin-top: 10px;
        border: 1px solid #ddd;
        padding: 10px;
    }
</style>