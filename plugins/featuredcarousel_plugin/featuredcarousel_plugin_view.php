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
                                        <i class="icon ion-tshirt"></i>Banner Featured Carousel Plugin
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
                                            <?php foreach ($featuredcarousels as $featuredcarousel) { ?>
                                            <li role="presentation">
                                                <a class="tab-title" aria-controls="row-<?php echo $row ?>" aria-expanded="true" data-toggle="tab" href="#row-<?php echo $row ?>" role="tab">Widget <?php echo $row ?></a>
                                                <a class="btn-remove" onclick="tabRemove(this, <?php echo $row ?>)"><i class="icon ion-close-circled"></i></a>
                                            </li>
                                            <?php $row++; ?>
                                            <?php } ?>
                                            <li id="add-tab" class="add-tab" onclick="addTab();"><i class="icon ion-plus"></i></li>
                                        </ul> 
                                    </div>
                                    <div class="tab-content">
                                        <?php $row = 1; ?>
                                        <?php foreach ($featuredcarousels as $featuredcarousel) { ?>
                                        <div class="tab-pane fade" id="row-<?php echo $row ?>" role="tabpanel" style="padding: 20px">
                                            <table id="form-list-images-<?php echo $row ?>" class="table table-featuredcarousel">
                                                <thead>
                                                    <tr>
                                                        <th style="width: 10%;">Icon</th>
                                                        <th>Konten</th>
                                                        <th style="width: 10%;">Status</th>
                                                        <th class="text-center" style="width: 10%;">Actions</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php $image_row = 0; ?>
                                                    <?php if(count($featuredcarousel)): foreach($featuredcarousel as $key => $item): ?>
                                                    <tr>
                                                        <td>
                                                            <a id="thumb-image<?php echo $row; ?><?php echo $image_row; ?>" data-toggle="image-thumb"><img src="<?php echo image_thumb($item['featuredcarousel_image'], 'small') ?>" alt="" class="tbl-image-square"></a>
                                                            <input type="hidden" name="featuredcarousel[<?php echo $row ?>][<?php echo $key; ?>][featuredcarousel_image]" value="<?php echo $item['featuredcarousel_image'] ?>" id="input-image<?php echo $row; ?><?php echo $image_row; ?>"/>
                                                        </td>
                                                        <td>
                                                            <label for="">Judul</label>
                                                            <input type="text" class="form-control" name="featuredcarousel[<?php echo $row ?>][<?php echo $key; ?>][featuredcarousel_title]" value="<?php echo $item['featuredcarousel_title']; ?>">

                                                            <label for="url">Link</label>
                                                            <input type="text" class="form-control" name="featuredcarousel[<?php echo $row ?>][<?php echo $key; ?>][featuredcarousel_link]" value="<?php echo $item['featuredcarousel_link']; ?>">
                                                        </td>
                                                        <td>
                                                            <input type="checkbox" name="featuredcarousel[<?php echo $row ?>][<?php echo $key; ?>][status]" checked class="switch-onoff" value="<?php echo $item['status']; ?>">
                                                        </td>
                                                        <td class="text-center">
                                                            <button type="button" class="btn btn-default btn-icon-toggle" data-toggle="tooltip" data-placement="top" data-original-title="Delete" onclick="itemRemove(this);"><i class="icon ion-trash-a"></i></button>
                                                        </td>
                                                    </tr>
                                                    <?php $image_row++; ?>
                                                    <?php endforeach; ?>
                                                    <?php endif; ?>
                                                    <tr>
                                                        <td colspan="4"><button type="button" class="btn btn-primary" onclick="addImage(<?php echo $row ?>, <?php echo $image_row ?>); $(this).parent().parent().remove();"><i class="icon ion-plus"></i> Add</button></td>
                                                    </tr>
                                                </tbody>
                                            </table>
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
    // Call TinyMCE
    <?php tmce_init(100) ?>

    // Default visible tab
    $('a[href="#row-1"]').tab('show');

    // Ajax request
    var ajaxRequest = function(Url, Data) {
        $.ajax({
            url: Url,
            dataType: 'html',
            beforeSend: function() {
                $('body').append('<div id="modal-media" class="modal fade"tabindex="-1" role="dialog" aria-labelledby="modal-media" aria-hidden="true"><div class="modal-dialog modal-lg"><div class="modal-content"><div class="modal-header"><button type="button" class="close" data-dismiss="modal" aria-hidden="true">&links;</button><h4 class="modal-title">Media Manager</h4></div><div class="modal-body"><div class="card tabs-h-left transparent media-manager" style="margin: 0"></div></div></div></div></div>');
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
            $(element).find('img').attr('src', "<?php echo image_thumb('uploads/images/default/default-thumbnail.png'); ?>");
            $(element).parent().find('input').attr('value', '');
            $(element).popover('hide');
        });
    });
});

// Add tab
var row = <?php echo $row; ?>;
function addTab() {
    html = '<div class="tab-pane fade" id="row-' + row + '" role="tabpanel" style="padding: 20px"></div>';
    $('.tab-content').append(html);

    table  = '<table id="form-list-images-' + row + '" class="table">';
    table +=    '<thead>';
    table +=        '<tr>';
    table +=            '<th style="width: 10%;">Icon</th>';
    table +=            '<th>Konten</th>';
    table +=            '<th style="width: 10%;">Status</th>';
    table +=            '<th class="text-center" style="width: 10%;">Actions</th>';
    table +=        '</tr>';
    table +=    '</thead>';
    table +=    '<tbody><tr><td colspan="4"><button type="button" class="btn btn-primary" onclick="addImage(' + row + ', 0); $(this).parent().parent().remove();"><i class="icon ion-plus"></i>Add</button></td></tr><tbody>';
    table += '</table>';
    $('#row-' + row).append(table);

    $('.add-tab').before('<li role="presentation"><a aria-controls="row-' + row + '" aria-expanded="true" class="tab-title" data-toggle="tab" href="#row-' + row + '" role="tab">Widget ' + row + '</a><a class="btn-remove" onclick="tabRemove(this, ' + row + ')"><i class="icon ion-close-circled"></i></a></li>');
    $('a[href="#row-' + row + '"]').tab('show');
    row++;
}

// Add Image
function addImage (row, image_row) {
    var add_row = image_row + 1;
    html    = '<tr>';
    html    +=    '<td>';
    html    +=        '<div class="image-upload">';
    html    +=            '<a id="thumb-image'+ row + image_row + '" data-toggle="image-thumb"><img src="<?php echo image_thumb('uploads/images/default/default-thumbnail.png'); ?>" alt="" class="tbl-image-square"></a>';
    html    +=            '<input type="hidden" name="featuredcarousel[' + row + '][' + image_row + '][featuredcarousel_image]" value="" id="input-image'+ row + image_row + '" />';
    html    +=        '</div>';
    html    +=    '</td>'
    html    +=    '<td>';
    html    +=        '<label for="">Judul</label>';
    html    +=        '<input type="text" class="form-control" name="featuredcarousel[' + row + '][' + image_row + '][featuredcarousel_title]" value="">';
    html    +=        '<label for="">Link</label>';
    html    +=        '<input type="text" class="form-control" name="featuredcarousel[' + row + '][' + image_row + '][featuredcarousel_link]" value="">';
    html    +=    '</td>';
    html    +=    '<td>';
    html    +=         '<input type="checkbox" name="featuredcarousel[' + row + '][' + image_row + '][status]" checked value="1" class="switch-onoff">';
    html    +=    '</td>';
    html    +=    '<td class="text-center">';
    html    +=        '<button type="button" class="btn btn-default btn-icon-toggle" data-toggle="tooltip" data-placement="top" data-original-title="Delete" onclick="itemRemove(this);"><i class="icon ion-trash-a"></i></button>';
    html    +=    '</td>';
    html    += '</tr>';
    html    += '<tr><td colspan="4"><button type="button" class="btn btn-primary" onclick="addImage(' + row + ', ' + add_row + '); $(this).parent().parent().remove();"><i class="icon ion-plus"></i>Add</button></td></tr>';

    $('#form-list-images-' + row).append(html);

    $.fn.bootstrapSwitch.defaults.size = 'mini';
    $('.switch-onoff').bootstrapSwitch();

    image_row++;

    // Call TinyMCE
    <?php tmce_init(100) ?>

    // Select2
    $(".select2_single").select2({
        alignjustifyllowClear: true
    });
}

// Remove Tab
function tabRemove (select, row) {
    $(select).parent().remove();
    $('#row-' + row).remove();
    $('.nav-tabs li:first > a').tab('show');
}

// Remove Item
function itemRemove (select) {
    $(select).parent().parent().remove();
    $('.tooltip').remove();
}
</script>
<style>
    table td label {
        display: block;
        margin-top: 10px;
        margin-bottom: 0;
    }
</style>