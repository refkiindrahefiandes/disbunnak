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
                    <input type="hidden" name="user_id" value="<?php echo $user['user_id']; ?>">
                    <?php if ($user['user_id']) : ?>
                    <input type="hidden" name="username" value="<?php echo $user['username']; ?>">
                    <?php endif ?>
                    <div class="col-md-8">
                        <div class="card card-line">
                            <div class="card-header">
                                <div class="card-header-title">
                                <i class="icon ion-person"></i>Edit User
                                </div>

                                <div class="tools">
                                    <div class="btn-group">
                                        <a class="btn btn-default btn-icon-toggle btn-collapse"><i class="icon ion-chevron-down menu-caret"></i></a>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="form-group <?php if (form_error('username')) { echo 'has-error';  } ?>">
                                    <input type="text" class="form-control" id="username" name="username" value="<?php echo $user['username']; ?>" <?php if($user['user_id']) echo 'disabled' ?> >
                                    <label for="username"><?php echo lang('text_username') ?> <span class="required">*</span></label>
                                    <?php echo (empty($user['user_id'])) ? (form_error('username', '<p class="help-block ">', '</p>')) : '<p class="help-block">'. lang('form_info_username') .'</p>'; ?>
                                </div>
                                <div class="form-group <?php if (form_error('email')) { echo 'has-error';  } ?>">
                                    <input type="text" class="form-control" id="email" name="email" value="<?php echo $user['email']; ?>">
                                    <label for="email"><?php echo lang('text_email') ?> <span class="required">*</span></label>
                                    <?php echo form_error('email', '<p class="help-block ">', '</p>'); ?>
                                </div>
                                <div class="form-group">
                                    <input type="text" class="form-control" id="firstname" name="firstname" value="<?php echo $user['firstname']; ?>">
                                    <label for="firstname"><?php echo lang('text_firstname') ?></label>
                                </div>
                                <div class="form-group">
                                    <input type="text" class="form-control" id="lastname" name="lastname" value="<?php echo $user['lastname']; ?>">
                                    <label for="lastname"><?php echo lang('text_lastname') ?></label>
                                </div>

                                <div class="form-group">
                                    <textarea name="usermeta[description]" id="description" class="form-control" rows="3"><?php echo $user['description']; ?></textarea>
                                    <label for="description"><?php echo lang('text_user_desc') ?></label>
                                </div>
                            </div>
                        </div>

                        <div class="card card-line">
                            <div class="card-header">
                                <div class="card-header-title">
                                <i class="icon ion-person"></i><?php echo lang('text_social_media') ?>
                                </div>

                                <div class="tools">
                                    <div class="btn-group">
                                        <a class="btn btn-default btn-icon-toggle btn-collapse"><i class="icon ion-chevron-down menu-caret"></i></a>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <table id="form-list-images" class="table">
                                    <thead>
                                        <tr>
                                            <th><?php echo lang('tbl_title_thumbnail') ?></th>
                                            <th><?php echo lang('tbl_title_url') ?></th>
                                            <th><?php echo lang('tbl_title_status') ?></th>
                                            <th class="text-center"><?php echo lang('tbl_title_action') ?></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $icon_row = 0; ?>
                                        <?php if(count($user['social'])): foreach($user['social'] as $key => $social): ?>
                                        <tr>
                                            <td>
                                                <a id="thumb-image<?php echo $key; ?>" data-toggle="image-thumb"><img src="<?php echo image_thumb($social['social_image'], 'small') ?>" alt="" class="tbl-image-square"></a>
                                                <input type="hidden" name="usermeta[social][<?php echo $key; ?>][social_image]" value="<?php echo $social['social_image'] ?>" id="input-image<?php echo $key; ?>"/>
                                            </td>
                                            <td>
                                                <input type="text" class="table-normal-input" name="usermeta[social][<?php echo $key; ?>][social_url]" value="<?php echo $social['social_url']; ?>">
                                            </td>
                                            <td>
                                                <input type="checkbox" name="usermeta[social][<?php echo $key; ?>][status]" checked class="switch-onoff" value="<?php echo $social['status']; ?>">
                                            </td>
                                            <td class="text-center">
                                                <button type="button" class="btn btn-default btn-icon-toggle" data-toggle="tooltip" data-placement="top" data-original-title="Delete" onclick="itemRemove(this);"><i class="icon ion-trash-a"></i></button>
                                            </td>
                                        </tr>
                                        <?php $icon_row++; ?>
                                        <?php endforeach; ?>
                                        <?php endif; ?>
                                    </tbody>
                                </table>
                            </div>
                            <div class="card-footer">
                                <div class="tools">
                                    <div class="btn-group">
                                        <button type="button" class="btn btn-primary" onclick="addSocial()"><i class="icon ion-plus"></i> <?php echo lang('btn_add_social_media') ?></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="card card-line">
                            <div class="card-body">
                                <?php if ($this->session->userdata['user_privilege'] == (int) 1) : ?>
                                <div class="form-group">
                                    <select id="user_group_id" name="user_group_id" class="form-control select2_single">
                                        <?php foreach( $user_groups as $user_group ): ?>
                                        <option value="<?php echo $user_group['user_group_id'] ?>" <?php if($user['user_group_id'] === $user_group['user_group_id']) echo "selected"; ?> ><?php echo $user_group['name']; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                    <label for="user_group_id"><?php echo lang('text_user_permission') ?></label>
                                </div>
                                <?php endif; ?>
                                <div class="form-group">
                                    <select id="language_code" name="language_code" class="form-control select2_single">
                                        <?php foreach( $languages as $language ): ?>
                                        <option value="<?php echo $language['language_code'] ?>" <?php if($language['language_code'] === $language_code) echo "selected"; ?> ><?php echo $language['name']; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                    <label for="language_code"><?php echo lang('text_language') ?></label>
                                </div>
                                <div class="form-group <?php if (form_error('password')) { echo 'has-error';  } ?>">
                                    <input type="password" class="form-control" id="password" name="password" value="">
                                    <label for="password"><?php echo lang('text_password') ?> <span class="required">*</span></label>
                                    <?php echo form_error('password', '<p class="help-block ">', '</p>'); ?>
                                </div>
                                <div class="form-group <?php if (form_error('password_confirm')) { echo 'has-error';  } ?>">
                                    <input type="password" class="form-control" id="password_confirm" name="password_confirm" value="">
                                    <label for="password_confirm"><?php echo lang('text_password_confirm') ?> <span class="required">*</span></label>
                                    <?php echo form_error('password_confirm', '<p class="help-block ">', '</p>'); ?>
                                </div>

                                <div>
                                    <label class="radio-styled">
                                        <input type="radio" name="status" class="iCheck" value="1" <?php if( $user['status'] == 1){ ?> checked <?php } ?>><span> <?php echo lang('text_enable') ?></span>
                                    </label>
                                    <label class="radio-inline radio-styled">
                                        <input type="radio" name="status" class="iCheck" value="0" <?php if( $user['status'] == 0){ ?> checked <?php } ?>><span> <?php echo lang('text_disable') ?></span>
                                    </label>
                                </div>
                            </div>

                            <div class="card-footer">
                                <div class="tools">
                                    <div class="btn-group">
                                        <?php if ($this->session->userdata['user_privilege'] == (int) 1) : ?>
                                        <a href="<?php echo site_url('admin/user/user'); ?>" class="btn btn-default" role="button"><i class="icon ion-reply"></i> <?php echo lang('btn_back') ?></a>
                                        <?php endif; ?>
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
<script type="text/javascript">
$(document).ready(function() {
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
});

// Add Image
var icon_row = <?php echo $icon_row; ?>;
function addSocial () {
    html    = '<tr>';
    html    +=    '<td>';
    html    +=        '<div class="image-upload">';
    html    +=            '<a id="thumb-image' + icon_row + '" data-toggle="image-thumb"><img src="<?php echo base_url("uploads/images/default/default-thumbnail.png"); ?>" alt="" class="tbl-image-square"></a>';
    html    +=            '<input type="hidden" name="usermeta[social][' + icon_row + '][social_image]" value="" id="input-image' + icon_row + '" />';
    html    +=        '</div>';
    html    +=    '</td>'
    html    +=    '<td>';
    html    +=        '<input type="text" class="table-normal-input" name="usermeta[social][' + icon_row + '][social_url]" value="">';
    html    +=    '</td>';
    html    +=    '<td>';
    html    +=         '<input type="checkbox" name="usermeta[social][' + icon_row + '][status]" checked value="1" class="switch-onoff">';
    html    +=    '</td>';
    html    +=    '<td class="text-center">';
    html    +=        '<button type="button" class="btn btn-default btn-icon-toggle" data-toggle="tooltip" data-placement="top" data-original-title="Delete" onclick="itemRemove(this);"><i class="icon ion-trash-a"></i></button>';
    html    +=    '</td>';
    html    += '</tr>';

    $('#form-list-images').append(html);

    $.fn.bootstrapSwitch.defaults.size = 'mini';
    $('.switch-onoff').bootstrapSwitch();

    icon_row++;
}

// Remove Item
function itemRemove (select) {
    $(select).parent().parent().remove();
    $('.tooltip').remove();
}
</script>