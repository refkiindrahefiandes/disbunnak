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
                                    <i class="icon ion-tshirt"></i>About Us Plugin
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
                                        <?php foreach ($abouts as $about) { ?>
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
                                    <?php foreach ($abouts as $about) { ?>
                                    <div class="tab-pane fade" id="row-<?php echo $row ?>" role="tabpanel">
                                        <div class="card card-line no-border no-shadow no-margin">
                                            <div class="card-header">
                                                <div class="card-header-title">
                                                    Widget <?php echo $row ?>
                                                </div>
                                                <ul class="nav nav-tabs pull-right" role="tablist">
                                                    <?php foreach($languages as $language): ?>
                                                    <li <?php if( $language['language_code'] === $language_code){ ?> class="active" <?php } ?>><a href="#tab-language-<?php echo $row; ?>-<?php echo $language['language_code']; ?>" aria-controls="#tab-language-<?php echo $language['language_code']; ?>" role="tab" data-toggle="tab"><img src="<?php echo ADMIN_ASSETS_URL . 'images/flags/' . $language['image']; ?>" alt=""> <span class="hidden-xs"> <?php echo $language['name']; ?></span></a></li>
                                                    <?php endforeach; ?>
                                                </ul>
                                            </div>
                                            <div class="card-body tab-content">
                                                <?php foreach($languages as $language): ?>
                                                <div class="tab-pane <?php if( $language['language_code'] === $language_code){ ?> active <?php } ?>" id="tab-language-<?php echo $row; ?>-<?php echo $language['language_code']; ?>" role="tabpanel">
                                                    <div class="form-group">
                                                        <input class="form-control" id="user_name-<?php echo $language['language_code']; ?>" name="aboutus[<?php echo $row; ?>][user_desc][<?php echo $language['language_code']; ?>][user_name]" value="<?php echo $about['user_desc'][$language['language_code']]['user_name']; ?>" type="text">
                                                        <label for="user_name-<?php echo $language['language_code']; ?>">Name</label>
                                                    </div>
                                                    <div class="form-group">
                                                        <textarea name="aboutus[<?php echo $row; ?>][user_desc][<?php echo $language['language_code']; ?>][user_desc]" id="user_desc-<?php echo $language['language_code']; ?>" class="form-control textarea" rows="6"><?php echo $about['user_desc'][$language['language_code']]['user_desc']; ?></textarea>
                                                        <label for="user_desc-<?php echo $language['language_code']; ?>">User Description</label>
                                                    </div>
                                                </div>
                                                <?php endforeach; ?>
                                                <div class="form-group">
                                                    <div class="input-group">
                                                        <div class="input-group-content">
                                                            <input type="text" id="user-image-<?php echo $row; ?>" name="aboutus[<?php echo $row; ?>][user_image]" class="form-control" value="<?php echo $about['user_image']; ?>">
                                                        </div>
                                                        <div class="input-group-btn">
                                                            <button type="button" id="button-upload" class="btn btn-success" onclick="selectImage(this, <?php echo $row; ?>)">Select Image</button>
                                                        </div>
                                                    </div>
                                                    <label for="user-image">User Image</label>
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

    // Call TinyMCE
    <?php tmce_init('200') ?>
});

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

// Select image
function selectImage(select, row) {
    $('#modal-media').remove();

    var Url = "<?php echo base_url('admin/media/file_manager/'); ?>" + $('input#user-image-' + row).attr('id');
    ajaxRequest(Url);
}

// Add tab
var row = <?php echo $row; ?>;
function addTab() {
    text =  '<div class="tab-pane fade" id="row-'+ row +'" role="tabpanel">';
    text +=     '<div class="card card-line no-border no-shadow no-margin">';
    text +=         '<div class="card-header">';
    text +=             '<div class="card-header-title">';
    text +=                 'Widget '+ row;
    text +=             '</div>';
    text +=             '<ul class="nav nav-tabs pull-right" role="tablist">';
                             <?php foreach($languages as $language): ?>
    text +=                  '<li <?php if( $language['language_code'] === $language_code){ ?> class="active" <?php } ?>><a href="#tab-language-'+ row +'-<?php echo $language['language_code']; ?>" aria-controls="#tab-language-<?php echo $language['language_code']; ?>" role="tab" data-toggle="tab"><img src="<?php echo ADMIN_ASSETS_URL . 'images/flags/' . $language['image']; ?>" alt=""> <span class="hidden-xs"> <?php echo $language['name']; ?></span></a></li>';
                             <?php endforeach; ?>
    text +=             '</ul>';
    text +=         '</div>';
    text +=         '<div class="card-body tab-content">';
                         <?php foreach($languages as $language): ?>
    text +=              '<div class="tab-pane <?php if( $language['language_code'] === $language_code){ ?> active <?php } ?>" id="tab-language-'+ row +'-<?php echo $language['language_code']; ?>" role="tabpanel">';
    text +=                 '<div class="form-group">';
    text +=                     '<input class="form-control" id="user_name-<?php echo $language['language_code']; ?>" name="aboutus['+ row +'][user_desc][<?php echo $language['language_code']; ?>][user_name]" type="text">';
    text +=                     '<label for="user_name-<?php echo $language['language_code']; ?>">Name</label>';
    text +=                 '</div>';
    text +=                 '<div class="form-group">';
    text +=                     '<textarea name="aboutus['+ row +'][user_desc][<?php echo $language['language_code']; ?>][user_desc]" id="user_desc-<?php echo $language['language_code']; ?>" class="form-control" rows="6"></textarea>';
    text +=                     '<label for="user_desc-<?php echo $language['language_code']; ?>">User Description</label>';
    text +=                 '</div>';
    text +=              '</div>';
                         <?php endforeach; ?>
    text +=              '<div class="form-group">';
    text +=                  '<div class="input-group">';
    text +=                      '<div class="input-group-content">';
    text +=                          '<input type="text" id="user-image-'+ row +'" name="aboutus['+ row +'][user_image]" class="form-control">';
    text +=                      '</div>';
    text +=                      '<div class="input-group-btn">';
    text +=                          '<button type="button" id="button-upload" class="btn btn-success" onclick="selectImage(this, '+ row +')">Select Image</button>';
    text +=                      '</div>';
    text +=                  '</div>';
    text +=                  '<label for="user-image">User Image</label>';
    text +=              '</div>';
    text +=          '</div>';
    text +=      '</div>';
    text +=  '</div>';

    $('#tab-wrapper').append(text);

    $('.add-tab').before('<li role="presentation"><a aria-controls="row-' + row + '" aria-expanded="true" class="tab-title" data-toggle="tab" href="#row-' + row + '" role="tab">Widget ' + row + '</a><a class="btn-remove" onclick="tabRemove(this, ' + row + ')"><i class="icon ion-close-circled"></i></a></li>');
    $('a[href="#row-' + row + '"]').tab('show');
    row++;
}

// Remove Tab
function tabRemove (select, row) {
    $(select).parent().remove();
    $('#row-' + row).remove();
    $('.nav-tabs li:first > a').tab('show');
}

</script>