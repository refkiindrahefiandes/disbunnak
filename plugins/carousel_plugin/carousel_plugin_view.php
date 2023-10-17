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
                                    <i class="icon ion-tshirt"></i>Post Carousel Plugin
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
                                        <?php foreach ($carousels as $carousel) { ?>
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
                                    <?php foreach ($carousels as $carousel) { ?>
                                    <div class="tab-pane fade" id="row-<?php echo $row ?>" role="tabpanel" style="padding: 20px">
                                        <p>Select post from left box to add to post carousel plugin.</p>
                                        <br>
                                        <select multiple="multiple" id="multi-select-<?php echo $row ?>" class="multi-select" name="post-select[<?php echo $row ?>][]">
                                            <?php
                                            foreach ($post_data as $post) {
                                                $active = false;
                                                foreach($carousel as $selected){
                                                    if($post['blog_id'] == $selected){
                                                        $active = true;
                                                    }
                                                }
                                            ?>
                                            <option value="<?php echo $post['blog_id'] ?>" <?php if($active===true) echo "selected"; ?> ><?php echo $post['title'] ?></option>
                                            <?php } ?>
                                        </select>
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
    // Multiselect
    $('.multi-select').multiSelect();

    // Default visible tab
    $('a[href="#row-1"]').tab('show');
});

// Add tab
var row = <?php echo $row; ?>;
function addTab() {
    text  =  '<div class="tab-pane fade" id="row-'+ row +'" role="tabpanel" style="padding: 20px">';
    text +=        '<p>Select post from left box to add to post carousel plugin.</p><br>';
    text +=        '<select multiple="multiple" id="multi-select-'+ row +'" class="multi-select" name="post-select['+ row +'][]">';
                   <?php foreach ($post_data as $post) { ?>
    text +=            '<option value="<?php echo $post['blog_id'] ?>"><?php echo $post['title'] ?></option>';
                   <?php } ?>
    text +=        '</select>';
    text +=  '</div>';

    $('#tab-wrapper').append(text);

    $('.add-tab').before('<li role="presentation"><a aria-controls="row-' + row + '" aria-expanded="true" class="tab-title" data-toggle="tab" href="#row-' + row + '" role="tab">Widget ' + row + '</a><a class="btn-remove" onclick="tabRemove(this, ' + row + ')"><i class="icon ion-close-circled"></i></a></li>');
    $('a[href="#row-' + row + '"]').tab('show');
    // Multiselect
    $('.multi-select').multiSelect();
    row++;
}

// Remove Tab
function tabRemove (select, row) {
    $(select).parent().remove();
    $('#row-' + row).remove();
    $('.nav-tabs li:first > a').tab('show');
}
</script>