<!-- CONTENT -->
<div id="main-content">
    <div id="content">
        <div class="content-wrap scroll-view">
            <!-- <section class="content-header"></section> -->
            <section class="content-body">
                <?php if (isset($this->session->userdata['error'])) {echo '<div class="alert alert-warning alert-dismissable" role="alert">' . $this->session->userdata['error'] . '<button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button></div>'; } ?>
                <?php if (isset($this->session->userdata['success'])) {echo '<div class="alert alert-success alert-dismissable" role="alert">' . $this->session->userdata['success'] . '<button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button></div>'; } ?>

                <div class="row">
                    <?php echo form_open('','class="form-horizontal control-label-left"'); ?>
                    <div class="col-md-12">
                        <div class="card card-line">
                            <div class="card-header">
                                <div class="card-header-title">
                                    <i class="icon ion-tshirt"></i>All category
                                </div>
                                <div class="tools">
                                    <div class="btn-group">
                                        <a href="<?php echo $back_to_plugins ?>" class="btn btn-default" role="button"><i class="icon ion-reply"></i> Kembali</a>
                                        <button class="btn btn-primary" type="submit">Save</button>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body no-padding" style="background: #f7f7f7;">
                                <div class="tab-header tabs-h-left">
                                    <ul class="nav nav-tabs" role="tablist">
                                        <?php $row = 1; ?>
                                        <?php foreach ($categories as $category) { ?>
                                        <li role="presentation">
                                            <a class="tab-title" aria-controls="row-<?php echo $row ?>" aria-expanded="true" data-toggle="tab" href="#row-<?php echo $row ?>" role="tab">Widget <?php echo $row ?></a>
                                            <a class="btn-remove" onclick="tabRemove(this, <?php echo $row ?>)"><i class="icon ion-close-circled"></i></a>
                                        </li>
                                        <?php $row++; ?>
                                        <?php } ?>
                                        <li id="add-tab" class="add-tab" onclick="addTab();"><i class="icon ion-plus"></i></li>
                                    </ul>
                                </div>
                                <div id="tab-wrapper" class="tab-content">
                                    <?php $row = 1; ?>
                                    <?php foreach ($categories as $category) { ?>
                                    <div class="tab-pane fade" id="row-<?php echo $row ?>" role="tabpanel" style="padding: 20px">
                                        <input type="hidden" name="category[<?php echo $row ?>][trigger_checkbox]" value="">
                                        <div class="form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12">Show child category</label>
                                            <div class="col-md-9 col-sm-9 col-xs-12">
                                                <div class="checkbox">
                                                    <label>
                                                        <input type="checkbox" class="switch-onoff" <?php if($category['show_child']) { echo 'checked="checked"'; } ?> name="category[<?php echo $row ?>][show_child]">
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12">Show post totals</label>
                                            <div class="col-md-9 col-sm-9 col-xs-12">
                                                <div class="checkbox">
                                                    <label>
                                                        <input type="checkbox" class="switch-onoff" <?php if($category['show_totals']) { echo 'checked="checked"'; } ?> name="category[<?php echo $row ?>][show_totals]">
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <?php $row++; ?>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                    </div>
                     <?php echo form_close() ?>
                </div>
            </section>
        </div>
    </div>
</div>

<script type="text/javascript">
$(document).ready(function() {
    // Default visible tab
    $('a[href="#row-1"]').tab('show');
});

// Add tab
var row = <?php echo $row; ?>;
function addTab() {
    text  =  '<div class="tab-pane fade" id="row-'+ row +'" role="tabpanel" style="padding: 20px">';
    text +=        '<input type="hidden" name="category['+ row +'][trigger_checkbox]" value="">';
    text +=        '<div class="form-group">';
    text +=            '<label class="control-label col-md-3 col-sm-3 col-xs-12">Show child category</label>';
    text +=            '<div class="col-md-9 col-sm-9 col-xs-12">';
    text +=                '<div class="checkbox">';
    text +=                    '<label>';
    text +=                        '<input type="checkbox" class="switch-onoff" name="category['+ row +'][show_child]">';
    text +=                    '</label>';
    text +=                '</div>';
    text +=            '</div>';
    text +=        '</div>';
    text +=        '<div class="form-group">';
    text +=            '<label class="control-label col-md-3 col-sm-3 col-xs-12">Show post totals</label>';
    text +=            '<div class="col-md-9 col-sm-9 col-xs-12">';
    text +=                '<div class="checkbox">';
    text +=                    '<label>';
    text +=                        '<input type="checkbox" class="switch-onoff" name="category['+ row +'][show_totals]">';
    text +=                    '</label>';
    text +=                '</div>';
    text +=            '</div>';
    text +=        '</div>';
    text +=  '</div>';

    $('#tab-wrapper').append(text);

    $('.add-tab').before('<li role="presentation"><a aria-controls="row-' + row + '" aria-expanded="true" class="tab-title" data-toggle="tab" href="#row-' + row + '" role="tab">Widget ' + row + '</a><a class="btn-remove" onclick="tabRemove(this, ' + row + ')"><i class="icon ion-close-circled"></i></a></li>');
    $('a[href="#row-' + row + '"]').tab('show');

    // Switch on-off
    $.fn.bootstrapSwitch.defaults.size = 'mini';
    $('.switch-onoff').bootstrapSwitch();
    row++;
}

// Remove Tab
function tabRemove (select, row) {
    $(select).parent().remove();
    $('#row-' + row).remove();
    $('.nav-tabs li:first > a').tab('show');
}
</script>