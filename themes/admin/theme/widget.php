<!-- CONTENT -->
<div id="main-content">
    <div id="content">
        <div class="content-wrap scroll-view">
            <!-- <section class="content-header"></section> -->
            <section class="content-body">
                <?php if (isset($this->session->userdata['error'])) {echo '<div class="alert alert-warning alert-dismissable" role="alert">' . $this->session->userdata['error'] . '<button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button></div>'; } ?>
                <?php if (isset($this->session->userdata['success'])) {echo '<div class="alert alert-success alert-dismissable" role="alert">' . $this->session->userdata['success'] . '<button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button></div>'; } ?>

                <div class="row">
                    <div class="col-md-4">
                        <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                        <?php foreach ($widgets_item as $key => $value) : ?>
                            <div class="card panel card-line">
                                <div class="card-header" role="tab" id="heading">
                                    <div class="card-header-title">
                                        <i class="icon ion-pricetags"></i><?php echo $value['widget_name']; ?>
                                    </div>
                                    <div class="tools">
                                        <div class="btn-group">
                                            <a class="btn btn-default btn-icon-toggle" data-toggle="collapse" data-parent="#accordion" href="#<?php echo $key; ?>" aria-expanded="true" aria-controls="<?php echo $key; ?>"><i class="icon ion-chevron-down menu-caret"></i></a>
                                        </div>
                                    </div>
                                </div>
                                <div id="<?php echo $key; ?>" class="panel-collapse collapse" role="tabpanel" aria-labelledby="<?php echo $key; ?>">
                                    <div class="card-body nicescroll" style="max-height: 335px;">
                                    <?php echo form_open('', 'id="' . $key . '" class="form"') ?>
                                        <div class="form-group">
                                            <?php foreach($languages as $language): ?>
                                            <div class="input-group" style="width: 100%; margin-bottom: 10px;">
                                                <input class="form-control" placeholder="<?php echo $language['name'] ?>" name="widget_title[<?php echo $language['language_code'] ?>]">
                                                <span class="input-group-addon" style="width: 30px; padding-right: 0;"><img src="<?php echo ADMIN_ASSETS_URL . 'images/flags/' . $language['image']; ?>" alt=""></span>
                                            </div>
                                            <?php endforeach; ?>
                                            <label for="widget_title">Widget Title</label>
                                        </div>

                                        <?php $widget_data = $this->setting_m->get_setting(trim($value['widget_data'])); ?>
                                        <?php if ($widget_data) : ?>
                                        <div class="form-group">
                                            <select id="widget_data" name="widget_data" class="form-control select2_single" style="width: 100%;">
                                                <?php foreach( $widget_data as $v=>$op ): ?>
                                                <option value="<?php echo $v;?>" >Widget <?php echo $v; ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                            <label for="widget_data">Pilih Widget</label>
                                        </div>
                                        <?php endif; ?>
                                    <?php echo form_close(); ?>
                                    </div>
                                    <div class="card-footer">
                                        <div class="tools">
                                            <div class="btn-group">
                                                <button class="btn btn-info" type="button" onclick="widget.add('<?php echo $key; ?>', '<?php echo $key; ?>');">
                                                    <?php echo lang('text_add_to_widget') ?>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach ?>
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="card card-line">
                            <div class="card-header">
                                <div class="card-header-title">
                                    <?php echo lang('text_select_widget') ?>
                                </div>
                                <div class="form-group" style="display: inline-block; margin-bottom: 0;">
                                    <select id="select-widget" name="select-widget" class="form-control select2_single">
                                        <?php foreach ($widgets as $widget) : ?>
                                        <option value="<?php echo $widget['widget_id']; ?>"><?php echo $widget['name']; ?></option>
                                        <?php endforeach ?>
                                    </select>
                                </div>
                                <div class="tools">
                                    <div class="btn-group">
                                        <a class="btn btn-default btn-icon-toggle btn-add-widget">
                                            <i class="icon ion-plus"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body" style="min-height: 300px;">
                                <?php echo validation_errors('<div class="alert alert-warning" role="alert">', '<button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button></div>'); ?>
                                <?php echo form_open('', 'id="form-add-widget" class="form" style="display: none;"') ?>
                                <div class="form-group <?php if (form_error("add-widget")) { echo 'has-error';  } ?>">
                                    <div class="input-group">
                                        <input type="text" class="form-control" placeholder="Type widget ..." name="add-widget">
                                        <span class="input-group-btn">
                                            <button class="btn btn-info btn-flat" type="submit"><?php echo lang('text_create_widget') ?></button>
                                        </span>
                                    </div>
                                    <label><?php echo lang('text_widget_name') ?></label>
                                </div>
                                <?php echo form_close(); ?>

                                <p><?php echo lang('text_widget_information') ?></p>
                                <br>
                                <?php echo form_open('', 'id="form-item-widget" class="form"') ?>
                                <div id="item-widget-grup"></div>
                                <?php echo form_close(); ?>
                            </div>
                            <div class="card-footer">
                                <div class="tools">
                                    <div class="btn-group">
                                        <button type="submit" id="delete-widget" class="btn btn-warning"><?php echo lang('btn_remove') ?></button>
                                        <button type="submit" id="save-widgets" class="btn btn-primary"><?php echo lang('btn_save_order') ?></button>
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
var baseUrl      = '<?=base_url()?>';
var saveitemUrl  = baseUrl + 'admin/theme/widget/ajax_add_item/';
var deletewidget = baseUrl + 'admin/theme/widget/ajax_delete_widget/';
var deleteItem   = baseUrl + 'admin/theme/widget/ajax_delete_item/';
var saveOrder    = baseUrl + 'admin/theme/widget/save_order_ajax/';

$(document).ready(function() {
    $('select[name=\'select-widget\']').bind('change', function() {
        var items = [];

        $.getJSON(baseUrl+'admin/theme/widget/ajax_get_item/' + this.value, function(data) {
            $.each(data, function(key, value) {
                items.push(value);
            });

            $('#item-widget-grup').html("").html(items.join(""));

            $('.sortable').nestedSortable({
                forcePlaceholderSize: true,
                handle: 'div',
                items: 'li',
                opacity: .8,
                placeholder: 'placeholder',
                tolerance: 'pointer',
                toleranceElement: '> div',
                maxLevels: 1
            });
        });
    });
    $('select[name=\'select-widget\']').trigger('change');

    $('#item-widget-grup').on('click', "a.btn-collapse", function (e) {
        e.preventDefault();
        var card = $(e.currentTarget).closest('.card');
        card.find('.card-body').slideToggle("fast");
        card.toggleClass('card-collapsed');
    });

    // Add widget
    $('a.btn-add-widget').click(function(){
        $('body').find('#form-add-widget').slideToggle("fast");
    });

    // Save widget items
    $('#save-widgets').click(function(){
        oSortable = $('.sortable').nestedSortable('toArray');
        $.ajax({
            url: saveOrder,
            type: 'post',
            data: {sortable: oSortable},
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

    // Delete widget
    $('#delete-widget').click(function(){
        $.ajax({
            url: deletewidget,
            type: 'post',
            data: {widget_to_remove: $('select[name=\'select-widget\']').val()},
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
    $('body').on('click', '.remove-item', function () {
        var me = $(this);
        $.ajax({
            url: deleteItem,
            type: 'post',
            data: {item_to_remove: me.attr('data-item')},
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
// add widget item
var widget = {
    'add': function(form_id, type) {
        $.ajax({
            url: saveitemUrl + type + '/' + $('select[name=\'select-widget\']').val(),
            type: 'post',
            data: $('form#' + form_id).serialize(),
            dataType: 'json',
            success: function(json) {
                if (json['error']) {
                    toastr.options.closeButton = true;
                    toastr.options.hideDuration = 333;
                    toastr["error"](json['error']);
                }
                if (json['success']) {
                    $('select[name=\'select-widget\']').trigger('change');
                }
            }
        });
    }
}
</script>