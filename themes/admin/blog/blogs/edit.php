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
                    <input type="hidden" name="blog_data[blog_id]" value="<?php echo $blog['blog_data']['blog_id']; ?>">
                    <div class="col-md-8">
                        <div class="card card-line">
                            <div class="card-header">
                                <div class="card-header-title">
                                    <i class="icon ion-edit"></i><?php echo lang('text_edit_post') ?>
                                </div>

                                <div class="tools">
                                    <div class="btn-group">
                                        <a class="btn btn-default btn-icon-toggle btn-collapse"><i class="icon ion-chevron-down menu-caret"></i></a>
                                    </div>
                                </div>

                                <ul class="nav nav-tabs pull-right" role="tablist">
                                    <?php foreach ($languages as $language) : ?>
                                        <li <?php if ($language['language_code'] == $language_code) { ?> class="active" <?php } ?>><a href="#tab-language-<?php echo $language['language_code']; ?>" aria-controls="#tab-language-<?php echo $language['language_code']; ?>" role="tab" data-toggle="tab"><img src="<?php echo ADMIN_ASSETS_URL . 'images/flags/' . $language['image']; ?>" alt=""> <span class="hidden-xs"> <?php echo $language['name']; ?></span></a></li>
                                    <?php endforeach; ?>
                                </ul>
                            </div>
                            <div class="card-body tab-content">
                                <?php foreach ($languages as $language) : ?>
                                    <div class="tab-pane <?php if ($language['language_code'] == $language_code) { ?> active <?php } ?>" id="tab-language-<?php echo $language['language_code']; ?>" role="tabpanel">
                                        <div class="form-group <?php if (form_error("blog_desc[$language[language_code]][title]")) {
                                                                        echo 'has-error';
                                                                    } ?>">
                                            <input type="text" class="form-control" id="name-<?php echo $language['language_code']; ?>" name="blog_desc[<?php echo $language['language_code']; ?>][title]" value="<?php echo $blog['blog_desc'][$language['language_code']]['title'] ?>">
                                            <label for="name-<?php echo $language['language_code']; ?>"><?php echo lang('text_post_title') ?> <span class="required">*</span></label>
                                            <?php echo form_error("blog_desc[$language[language_code]][title]", '<p class="help-block ">', '</p>'); ?>
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
                                            <textarea name="blog_desc[<?php echo $language['language_code']; ?>][content]" id="textarea-<?php echo $language['language_code']; ?>" class="form-control textarea" rows="15"><?php echo $blog['blog_desc'][$language['language_code']]['content'] ?></textarea>
                                            <label for="textarea-<?php echo $language['language_code']; ?>"><?php echo lang('text_content') ?></label>
                                        </div>
                                        <div class="form-group">
                                            <textarea id="tags_<?php echo $language['language_code']; ?>" rows="1" name="blog_desc[<?php echo $language['language_code']; ?>][tag]" rel="textext"></textarea>
                                            <label for="tag"><?php echo lang('text_tags') ?></label>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>

                        <div class="card card-line">
                            <div class="card-header">
                                <div class="card-header-title">
                                    <i class="icon ion-tshirt"></i>Galeri Gambar
                                </div>
                            </div>

                            <div class="card-body">
                                <table id="form-list-images" class="table table-banner">
                                    <thead>
                                        <tr>
                                            <th>Image</th>
                                            <th>Status</th>
                                            <th class="text-center">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $image_row = 0; ?>
                                        <?php if (count($blog['blog_image'])) : foreach ($blog['blog_image'] as $key => $image) : ?>
                                                <tr>
                                                    <input type="hidden" name="post_image[<?php echo $image_row ?>][blog_image_id]" value="<?php echo $image['blog_image_id'] ?>" />
                                                    <td>
                                                        <a id="thumb-image<?php echo $image_row; ?>" data-toggle="image-thumb"><img src="<?php echo image_thumb($image['image'], 'medium') ?>" alt="" class="tbl-image-square"></a>
                                                        <input type="hidden" name="post_image[<?php echo $image_row ?>][image]" value="<?php echo $image['image_path'] ?>" id="input-image<?php echo $image_row; ?>" />
                                                    </td>
                                                    <td>
                                                        <input type="checkbox" name="post_image[<?php echo $image_row; ?>][status]" <?php if ($image['status'] == 1) { ?> checked <?php } ?> class="switch-onoff" value="<?php echo $image['status']; ?>">
                                                    </td>
                                                    <td class="text-center">
                                                        <button type="button" class="btn btn-default btn-icon-toggle" data-toggle="tooltip" data-placement="top" data-original-title="Delete" onclick="itemRemove(this);"><i class="icon ion-trash-a"></i></button>
                                                    </td>
                                                </tr>
                                                <?php $image_row++; ?>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                        <tr>
                                            <td colspan="4"><button type="button" class="btn btn-primary pull-right" onclick="addImage(<?php echo $image_row ?>); $(this).parent().parent().remove();"><i class="icon ion-plus"></i> Add Image</button></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="panel-group" id="accordion2" role="tablist" aria-multiselectable="true">
                            <div class="card panel card-line">
                                <div class="card-header" role="tab" id="heading4">
                                    <div class="card-header-title">
                                        <a role="button" data-toggle="collapse" data-parent="#accordion2" href="#collapse4" aria-expanded="true" aria-controls="collapse4">
                                            <i class="icon ion-image"></i><?php echo lang('text_featured_image') ?>
                                        </a>
                                    </div>
                                </div>
                                <div id="collapse4" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="heading4">
                                    <div class="card-body">
                                        <div id="post-thumbnail">
                                            <div class="thumbnail-image">
                                                <a id="thumb-image" data-toggle="image-thumb" style="min-height: 100px; display: block;"><img src="<?php echo $blog['blog_data']['image_path']; ?>" alt=""></a>
                                                <input type="hidden" name="blog_data[image]" value="<?php echo $blog['blog_data']['image']; ?>" id="input-image" />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card panel card-line">
                                <div class="card-header" role="tab" id="heading5">
                                    <div class="card-header-title">
                                        <a role="button" data-toggle="collapse" data-parent="#accordion2" href="#collapse5" aria-expanded="true" aria-controls="collapse5">
                                            <i class="icon ion-social-youtube-outline"></i><?php echo lang('text_featured_video') ?>
                                        </a>
                                    </div>
                                </div>
                                <div id="collapse5" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading5">
                                    <div class="card-body">
                                        <div id="post-thumbnail">
                                            <div id="featured-video" class="thumbnail-video">
                                                <?php if ($blog['blog_data']['video'] != NULL) { ?>

                                                    <!-- <iframe width="560" height="315" src="<?php echo $blog['blog_data']['video_embed']; ?>" frameborder="0" allowfullscreen></iframe> -->
                                                <?php } ?>
                                            </div>
                                        </div>

                                        <div class="form-group" style="margin-bottom: 0;">
                                            <input placeholder="Ketik video URL dan Enter..." name="blog_data[video]" value="<?php echo $blog['blog_data']['video']; ?>" id="featured-video-input" class="form-control" type="text">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card card-line">
                            <div class="card-header">
                                <div class="card-header-title">
                                    <i class="icon ion-folder"></i><?php echo lang('text_select_category') ?>
                                </div>
                            </div>
                            <div class="card-body nicescroll" style="min-height: 150px; max-height: 335px;">
                                <?php if (count($categories)) : ?>
                                    <?php
                                        foreach ($categories as $category) {
                                            $active = false;
                                            foreach ($blog['category_data'] as $selected) {
                                                if ($category['term_desc'][$language_code]['term_id'] == $selected['term_id']) {
                                                    $active = true;
                                                }
                                            }
                                            ?>
                                        <div class="form-group" style="padding-top: 0;">
                                            <div class="checkbox checkbox-styled" style="margin: 0">
                                                <label style="padding-left: 0;">
                                                    <input type="checkbox" name="category_data[]" value="<?php echo $category['term_data']['term_id']; ?>" class="iCheck" <?php if ($active === true) echo "checked"; ?>>
                                                    <span><?php echo $category['term_desc'][$language_code]['name']; ?></span>
                                                </label>
                                            </div>
                                        </div>
                                    <?php } ?>
                                <?php endif ?>
                            </div>
                        </div>

                        <div class="card card-line">
                            <div class="card-body">
                                <div class="form-group">
                                    <label><?php echo lang('text_date_published') ?></label>
                                    <div class="input-group">
                                        <input type="text" class="form-control datesingle" name="blog_data[date_published]" value="<?php echo $blog['blog_data']['date_published']; ?>">
                                        <span class="input-group-addon"><i class="icon ion-calendar"></i></span>
                                    </div>
                                    <p class="help-block"><?php echo lang('form_info_date') ?></p>
                                </div>

                                <div class="form-group">
                                    <select id="comment_status" name="blog_data[comment_status]" class="form-control select2_single">
                                        <?php foreach ($comment_status as $v => $op) : ?>
                                            <option value="<?php echo $v; ?>" <?php if ($v == $blog['blog_data']['comment_status']) echo "selected"; ?>><?php echo $op; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                    <label for="comment_status"><?php echo lang('text_enable_comments') ?></label>
                                </div>

                                <?php if ($publish_permission) : ?>
                                    <div>
                                        <label class="radio-styled">
                                            <input type="radio" name="blog_data[status]" class="iCheck" value="1" <?php if ($blog['blog_data']['status'] == 1) { ?> checked <?php } ?>><span> <?php echo lang('text_publish') ?></span>
                                        </label>
                                        <label class="radio-inline radio-styled">
                                            <input type="radio" name="blog_data[status]" class="iCheck" value="0" <?php if ($blog['blog_data']['status'] == 0) { ?> checked <?php } ?>><span> <?php echo lang('text_unpublish') ?></span>
                                        </label>
                                    </div>
                                <?php endif ?>

                            </div>

                            <div class="card-footer">
                                <div class="tools">
                                    <div class="btn-group">
                                        <a href="<?php echo site_url('admin/blog/blogs'); ?>" class="btn btn-default" role="button"><i class="icon ion-reply"></i> <?php echo lang('btn_back') ?></a>
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

<script type="text/javascript" src="<?php echo ADMIN_ASSETS_URL; ?>js/libs/textext.core.js"></script>
<script type="text/javascript" src="<?php echo ADMIN_ASSETS_URL; ?>js/libs/textext.plugin.autocomplete.js"></script>
<script type="text/javascript" src="<?php echo ADMIN_ASSETS_URL; ?>js/libs/textext.plugin.ajax.js"></script>
<script type="text/javascript" src="<?php echo ADMIN_ASSETS_URL; ?>js/libs/textext.plugin.tags.js"></script>

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
                $(element).find('img').attr('src', "<?php echo base_url('uploads/images/default/default-thumbnail.png'); ?>");
                $(element).parent().find('input').attr('value', '');
                $(element).popover('hide');
            });
        });

        // Tags Autocomplete
        var base_url = "<?php echo base_url('admin/blog/blogs/') ?>";
        var key = "<?= $firstkey ?>";
        $('textarea#tags_' + key).textext({
            plugins: 'autocomplete tags ajax',
            tags: {
                items: <?php echo json_encode($blog['blog_desc'][$firstkey]['tag']) ?>
            },
            ajax: {
                url: base_url + 'get_tags_ajax/' + key,
                dataType: 'json',
                cacheResults: true
            }
        });

        var tabComputed = ['#tab-language-' + key];

        $('a[data-toggle="tab"]').on('shown.bs.tab', function(e) {
            var target = $(e.target).attr("href");
            if (tabComputed.indexOf(target) == -1) {
                <?php foreach ($blog['blog_desc'] as $key => $blog_desc) : ?>
                    var key = "<?= $key ?>";
                    $(target).find('textarea#tags_' + key).textext({
                        plugins: 'autocomplete tags ajax',
                        tags: {
                            items: <?php echo json_encode($blog_desc['tag']) ?>
                        },
                        ajax: {
                            url: base_url + 'get_tags_ajax/' + key,
                            dataType: 'json',
                            cacheResults: true
                        }
                    });

                <?php endforeach ?>
                tabComputed.push(target);
            }
        });

        // Multiple select
        $(".select2_multiple").select2({
            placeholder: "Select Category",
            allowClear: true
        });

        // Featured Image
        $("#featured-video-input").keypress(function(event) {
            if (13 === event.keyCode) { // enter key
                event.preventDefault();
                var url = $(this).val();
                var src = (!url.includes('vimeo')) ? "//www.youtube.com/embed/" + url.split("=")[1] : "//player.vimeo.com/video/" + url.split("/")[3];
                var ifrm = '<iframe width="560" height="315" src="' + src + '" frameborder="0" allowfullscreen></iframe>';

                $('#featured-video').html(ifrm);
            }
        });
    });

    // Add Image Galery
    function addImage(image_row) {
        var add_row = image_row + 1;
        html = '<tr>';
        html += '<input type="hidden" name="post_image[' + image_row + '][blog_image_id]" value="" />';
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

    textarea.form-control {
        margin-top: 10px;
        border: 1px solid #ddd;
        padding: 10px;
    }

    .thumbnail-image img {
        width: 100%;
    }

    .thumbnail-video {
        width: 100%;
        height: 160px;
        background: #eee;
    }

    .thumbnail-video iframe {
        width: 100%;
        height: 160px;
    }
</style>