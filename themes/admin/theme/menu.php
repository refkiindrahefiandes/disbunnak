<!-- CONTENT -->
<div id="main-content">
    <div id="content">
        <div class="content-wrap scroll-view">
            <!-- <section class="content-header"></section> -->
            <section class="content-body">
                <?php if (isset($this->session->userdata['error'])) {
                    echo '<div class="alert alert-warning alert-dismissable" role="alert">' . $this->session->userdata['error'] . '<button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button></div>';
                } ?>
                <?php if (isset($this->session->userdata['success'])) {
                    echo '<div class="alert alert-success alert-dismissable" role="alert">' . $this->session->userdata['success'] . '<button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button></div>';
                } ?>

                <div class="row">
                    <div class="col-md-4">
                        <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                            <div class="card panel card-line">
                                <div class="card-header" role="tab" id="heading1">
                                    <div class="card-header-title">
                                        <i class="icon ion-pricetags"></i>Pages
                                    </div>
                                    <div class="tools">
                                        <div class="btn-group">
                                            <a class="btn btn-default btn-icon-toggle" data-toggle="collapse" data-parent="#accordion" href="#collapse1" aria-expanded="true" aria-controls="collapse1"><i class="icon ion-chevron-down menu-caret"></i></a>
                                        </div>
                                    </div>
                                </div>
                                <div id="collapse1" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="heading1">
                                    <div class="card-body nicescroll" style="max-height: 335px;">
                                        <?php echo form_open('', 'id="page-menus" class="form"') ?>
                                        <?php if (count($pages)) : ?>
                                            <?php foreach ($pages as $page) : ?>
                                                <div class="form-group" style="padding-top: 0;">
                                                    <div class="checkbox">
                                                        <label style="padding-left: 0;">
                                                            <input type="checkbox" name="menu-item[]" value="<?php echo $page['page_id']; ?>" class="iCheck">
                                                            <span><?php echo $page['title']; ?></span>
                                                        </label>
                                                    </div>
                                                </div>
                                            <?php endforeach ?>
                                        <?php endif ?>
                                        <?php echo form_close(); ?>
                                    </div>
                                    <div class="card-footer">
                                        <div class="tools">
                                            <div class="btn-group">
                                                <button class="btn btn-default" type="button" onclick="menu.add('page-menus', 'page');">
                                                    <?php echo lang('text_add_to_menu') ?>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card panel card-line">
                                <div class="card-header" role="tab" id="heading2">
                                    <div class="card-header-title">
                                        <i class="icon ion-pricetags"></i>Links
                                    </div>
                                    <div class="tools">
                                        <div class="btn-group">
                                            <a class="btn btn-default btn-icon-toggle" data-toggle="collapse" data-parent="#accordion" href="#collapse2" aria-expanded="true" aria-controls="collapse2"><i class="icon ion-chevron-down menu-caret"></i></a>
                                        </div>
                                    </div>
                                </div>
                                <div id="collapse2" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading2">
                                    <div class="card-body nicescroll" style="max-height: 335px;">
                                        <?php echo form_open('', 'id="link-menus" class="form"') ?>
                                        <div class="form-group" style="padding-top: 16px; margin-bottom: 19px;">
                                            <?php foreach ($languages as $language) : ?>
                                                <div class="input-group" style="width: 100%; margin-bottom: 10px;">
                                                    <input class="form-control" placeholder="<?php echo $language['name'] ?>" name="menu_text[<?php echo $language['language_code'] ?>]">
                                                    <span class="input-group-addon" style="width: 30px; padding-right: 0;"><img src="<?php echo ADMIN_ASSETS_URL . 'images/flags/' . $language['image']; ?>" alt=""></span>
                                                </div>
                                            <?php endforeach; ?>
                                            <label for="tag">Link Text</label>
                                        </div>
                                        <div class="form-group" style="padding-top: 16px; margin-bottom: 19px;">
                                            <?php foreach ($languages as $language) : ?>
                                                <div class="input-group" style="width: 100%; margin-bottom: 10px;">
                                                    <input class="form-control" placeholder="<?php echo $language['name'] ?>" name="menu_url[<?php echo $language['language_code'] ?>]">
                                                    <span class="input-group-addon" style="width: 30px; padding-right: 0;"><img src="<?php echo ADMIN_ASSETS_URL . 'images/flags/' . $language['image']; ?>" alt=""></span>
                                                </div>
                                            <?php endforeach; ?>
                                            <label for="tag">URL</label>
                                        </div>
                                        <?php echo form_close(); ?>
                                    </div>
                                    <div class="card-footer">
                                        <div class="tools">
                                            <div class="btn-group">
                                                <button class="btn btn-default" type="button" onclick="menu.addlink('link-menus', 'link');">
                                                    <?php echo lang('text_add_to_menu') ?>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card panel card-line">
                                <div class="card-header" role="tab" id="heading3">
                                    <div class="card-header-title">
                                        <i class="icon ion-pricetags"></i>Blog Categories
                                    </div>
                                    <div class="tools">
                                        <div class="btn-group">
                                            <a class="btn btn-default btn-icon-toggle" data-toggle="collapse" data-parent="#accordion" href="#collapse3" aria-expanded="true" aria-controls="collapse3"><i class="icon ion-chevron-down menu-caret"></i></a>
                                        </div>
                                    </div>
                                </div>
                                <div id="collapse3" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading3">
                                    <div class="card-body nicescroll" style="max-height: 335px;">
                                        <?php echo form_open('', 'id="blog-category-menus" class="form"') ?>
                                        <?php if (count($blog_categories)) : ?>
                                            <?php foreach ($blog_categories as $blog_category) : ?>
                                                <div class="form-group" style="padding-top: 0;">
                                                    <div class="checkbox checkbox-styled">
                                                        <label style="padding-left: 0;">
                                                            <input type="checkbox" name="menu-item[]" value="<?php echo $blog_category['term_id']; ?>" class="iCheck">
                                                            <span><?php echo $blog_category['name']; ?></span>
                                                        </label>
                                                    </div>
                                                </div>
                                            <?php endforeach ?>
                                        <?php endif ?>
                                        <?php echo form_close(); ?>
                                    </div>
                                    <div class="card-footer">
                                        <div class="tools">
                                            <div class="btn-group">
                                                <button class="btn btn-default" type="button" onclick="menu.add('blog-category-menus', 'blog-category');">
                                                    <?php echo lang('text_add_to_menu') ?>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="card panel card-line">
                                <div class="card-header" role="tab" id="heading3">
                                    <div class="card-header-title">
                                        <i class="icon ion-pricetags"></i>Download Categories
                                    </div>
                                    <div class="tools">
                                        <div class="btn-group">
                                            <a class="btn btn-default btn-icon-toggle" data-toggle="collapse" data-parent="#accordion" href="#collapse4" aria-expanded="true" aria-controls="collapse4"><i class="icon ion-chevron-down menu-caret"></i></a>
                                        </div>
                                    </div>
                                </div>
                                <div id="collapse4" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading3">
                                    <div class="card-body nicescroll" style="max-height: 335px;">
                                        <?php echo form_open('', 'id="download-category-menus" class="form"') ?>
                                        <?php if (count($download_categories)) : ?>
                                            <?php foreach ($download_categories as $download_category) : ?>
                                                <div class="form-group" style="padding-top: 0;">
                                                    <div class="checkbox checkbox-styled">
                                                        <label style="padding-left: 0;">
                                                            <input type="checkbox" name="menu-item[]" value="<?php echo $download_category['download_category_id']; ?>" class="iCheck">
                                                            <span><?php echo $download_category['name']; ?></span>
                                                        </label>
                                                    </div>
                                                </div>
                                            <?php endforeach ?>
                                        <?php endif ?>
                                        <?php echo form_close(); ?>
                                    </div>
                                    <div class="card-footer">
                                        <div class="tools">
                                            <div class="btn-group">
                                                <button class="btn btn-default" type="button" onclick="menu.add('download-category-menus', 'download-category');">
                                                    <?php echo lang('text_add_to_menu') ?>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="card card-line">
                            <div class="card-header">
                                <div class="card-header-title">
                                    <?php echo lang('text_select_menu') ?>
                                </div>
                                <div class="form-group" style="display: inline-block; margin-bottom: 0;">
                                    <select id="select-menu" name="select-menu" class="form-control select2_single">
                                        <?php foreach ($menus as $menu) : ?>
                                            <option value="<?php echo $menu['menu_id']; ?>"><?php echo $menu['name']; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="tools">
                                    <div class="btn-group">
                                        <a class="btn btn-default btn-icon-toggle btn-add-menu">
                                            <i class="icon ion-plus"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body" style="min-height: 300px;">
                                <?php echo validation_errors('<div class="alert alert-warning" role="alert">', '<button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button></div>'); ?>
                                <?php echo form_open('', 'id="form-add-menu" class="form" style="display: none;"') ?>
                                <div class="form-group <?php if (form_error("add-menu")) {
                                                            echo 'has-error';
                                                        } ?>">
                                    <div class="input-group">
                                        <input type="text" class="form-control" placeholder="Type menu ..." name="add-menu">
                                        <span class="input-group-btn">
                                            <button class="btn btn-info btn-flat" type="submit"><?php echo lang('text_create_menu') ?></button>
                                        </span>
                                    </div>
                                    <label><?php echo lang('text_menu_name') ?></label>
                                </div>
                                <?php echo form_close(); ?>

                                <p><?php echo lang('text_menu_information') ?></p>
                                <br>
                                <?php echo form_open('', 'class="form"') ?>
                                <div id="item-menu-grup"></div>
                                <?php echo form_close(); ?>
                            </div>
                            <div class="card-footer">
                                <div class="tools">
                                    <div class="btn-group">
                                        <button type="submit" id="delete-menu" class="btn btn-warning"><?php echo lang('btn_remove') ?></button>
                                        <button type="submit" id="save-menus" class="btn btn-primary"><?php echo lang('btn_save_order') ?></button>
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

<script type="text/javascript">
    var baseUrl = '<?= base_url() ?>';
    var saveitemUrl = baseUrl + 'admin/theme/menu/ajax_add_item/';
    var deleteMenu = baseUrl + 'admin/theme/menu/ajax_delete_menu/';
    var deleteItem = baseUrl + 'admin/theme/menu/ajax_delete_item/';
    var saveOrder = baseUrl + 'admin/theme/menu/save_order_ajax/';

    $(document).ready(function() {
        $('select[name=\'select-menu\']').bind('change', function() {
            var items = [];

            $.getJSON(baseUrl + 'admin/theme/menu/ajax_get_item/' + this.value, function(data) {
                $.each(data, function(key, value) {
                    items.push(value);
                });

                $('#item-menu-grup').html("").html(items.join(""));

                $('.sortable').nestedSortable({
                    forcePlaceholderSize: true,
                    handle: 'div',
                    items: 'li',
                    opacity: .8,
                    placeholder: 'placeholder',
                    tolerance: 'pointer',
                    toleranceElement: '> div',
                    maxLevels: 10
                });
            });
        });
        $('select[name=\'select-menu\']').trigger('change');

        $('#item-menu-grup').on('click', "a.btn-collapse", function(e) {
            e.preventDefault();
            var card = $(e.currentTarget).closest('.card');
            card.find('.card-body').slideToggle("fast");
            card.toggleClass('card-collapsed');
        });

        // Add menu
        $('a.btn-add-menu').click(function() {
            $('body').find('#form-add-menu').slideToggle("fast");
        });

        // Save menu items
        $('#save-menus').click(function() {
            oSortable = $('.sortable').nestedSortable('toArray');
            $.ajax({
                url: saveOrder,
                type: 'post',
                data: {
                    sortable: oSortable
                },
                dataType: 'json',
                success: function(json) {
                    if (json['error']) {
                        toastr.options.closeButton = true;
                        toastr.options.hideDuration = 333;
                        toastr["error"](json['error']);
                    }
                    if (json['success']) {
                        $('select[name=\'select-widget\']').trigger('change');
                        toastr.options.closeButton = true;
                        toastr.options.hideDuration = 333;
                        toastr["success"](json['success']);
                    }
                }
            });
        });

        // Delete menu
        $('#delete-menu').click(function() {
            $.ajax({
                url: deleteMenu,
                type: 'post',
                data: {
                    menu_to_remove: $('select[name=\'select-menu\']').val()
                },
                dataType: 'json',
                success: function(json) {
                    if (json['error']) {
                        toastr.options.closeButton = true;
                        toastr.options.hideDuration = 333;
                        toastr["error"](json['error']);
                    }
                    if (json['success']) {
                        window.location.reload();
                    }
                }
            });
        });

        // Remove item
        $('body').on('click', '.remove-item', function() {
            var me = $(this);
            $.ajax({
                url: deleteItem,
                type: 'post',
                data: {
                    item_to_remove: me.attr('data-item')
                },
                dataType: 'json',
                success: function(json) {
                    if (json['error']) {
                        toastr.options.closeButton = true;
                        toastr.options.hideDuration = 333;
                        toastr["error"](json['error']);
                    }
                    if (json['success']) {
                        me.closest('li').remove();
                    }
                }
            });
        });
    });
    // add menu item
    var menu = {
        'add': function(form_id, type) {
            $.ajax({
                url: saveitemUrl + type + '/' + $('select[name=\'select-menu\']').val(),
                type: 'post',
                data: $('form#' + form_id + ' input[name="menu-item[]"]:checked').serialize(),
                dataType: 'json',
                success: function(json) {
                    if (json['error']) {
                        toastr.options.closeButton = true;
                        toastr.options.hideDuration = 333;
                        toastr["error"](json['error']);

                        var checkboxes = $('input[name="menu-item[]"]');
                        checkboxes.iCheck('uncheck');
                    }
                    if (json['success']) {
                        $('select[name=\'select-menu\']').trigger('change');

                        var checkboxes = $('input[name="menu-item[]"]');
                        checkboxes.iCheck('uncheck');
                    }
                }
            });
        },
        'addlink': function(form_id, type) {
            $.ajax({
                url: saveitemUrl + type + '/' + $('select[name=\'select-menu\']').val(),
                type: 'post',
                data: $('form#' + form_id + ' input').serialize(),
                success: function(json) {
                    $('select[name=\'select-menu\']').trigger('change');
                }
            });
        }
    }
</script>