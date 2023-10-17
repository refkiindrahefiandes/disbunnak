<!-- CONTENT -->
<div id="main-content">
    <div id="content">
        <div class="content-wrap scroll-view">
            <!-- <section class="content-header"></section> -->
            <section class="content-body">
                <?php if (isset($this->session->userdata['error'])) {echo '<div class="alert alert-warning alert-dismissable" role="alert">' . $this->session->userdata['error'] . '<button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button></div>'; } ?>
                <?php if (isset($this->session->userdata['success'])) {echo '<div class="alert alert-success alert-dismissable" role="alert">' . $this->session->userdata['success'] . '<button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button></div>'; } ?>

                <div class="row">
                    <?php echo form_open('','class="form"'); ?>
                    <div class="col-md-12">
                        <div class="card card-line">
                            <div class="card-header">
                                <div class="card-header-title">
                                    <i class="icon ion-tshirt"></i>Instagram Widget
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
                                        <?php foreach ($instagram as $insta) { ?>
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
                                    <?php foreach ($instagram as $insta) { ?>
                                    <div class="tab-pane fade" id="row-<?php echo $row ?>" role="tabpanel" style="padding: 20px">
                                        <div class="form-group">
                                            <input class="form-control" id="username" name="instagram[<?php echo $row ?>][username]" value="<?php echo $insta['username'] ?>" type="text">
                                            <label for="username">Username</label>
                                        </div>
                                        <div class="form-group">
                                            <input class="form-control" id="limit" name="instagram[<?php echo $row ?>][limit]" value="<?php echo $insta['limit'] ?>" type="text">
                                            <label for="limit">Number of photos: </label>
                                        </div>
                                        <div class="form-group">
                                            <select id="target" name="instagram[<?php echo $row ?>][target]" class="form-control select2_single" style="width: 100%;">
                                                <?php foreach( $target as $v=>$op ): ?>
                                                <option value="<?php echo $v;?>" <?php if($v == $insta['target']) echo "selected"; ?> ><?php echo $op; ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                            <label for="target">Buka links di</label>
                                        </div>
                                    </div>
                                    <?php $row++; ?>
                                    <?php } ?>
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
<script type="text/javascript">
$(document).ready(function() {
    // Default visible tab
    $('a[href="#row-1"]').tab('show');
});

// Add tab
var row = <?php echo $row; ?>;
function addTab() {
    text  =  '<div class="tab-pane fade" id="row-'+ row +'" role="tabpanel" style="padding: 20px">';
    text +=     '<div class="form-group">';
    text +=         '<input class="form-control" id="username" name="instagram['+ row +'][username]" value="" type="text">';
    text +=         '<label for="username">Username</label>';
    text +=     '</div>';
    text +=     '<div class="form-group">';
    text +=         '<input class="form-control" id="limit" name="instagram['+ row +'][limit]" value="" type="text">';
    text +=         '<label for="limit">Number of photos: </label>';
    text +=     '</div>';
    text +=     '<div class="form-group">';
    text +=         '<select id="target" name="instagram['+ row +'][target]" class="form-control select2_single" style="width: 100%;">';
                        <?php foreach( $target as $v=>$op ): ?>
    text +=             '<option value="<?php echo $v;?>"><?php echo $op; ?></option>';
                        <?php endforeach; ?>
    text +=         '</select>';
    text +=         '<label for="target">Buka links di</label>';
    text +=     '</div>';
    text +=  '</div>';

    $('#tab-wrapper').append(text);

    $('.add-tab').before('<li role="presentation"><a aria-controls="row-' + row + '" aria-expanded="true" class="tab-title" data-toggle="tab" href="#row-' + row + '" role="tab">Widget ' + row + '</a><a class="btn-remove" onclick="tabRemove(this, ' + row + ')"><i class="icon ion-close-circled"></i></a></li>');
    $('a[href="#row-' + row + '"]').tab('show');

    // Select2
    $(".select2_single").select2({
        alignjustifyllowClear: true
    });
    row++;
}

// Remove Tab
function tabRemove (select, row) {
    $(select).parent().remove();
    $('#row-' + row).remove();
    $('.nav-tabs li:first > a').tab('show');
}
</script>