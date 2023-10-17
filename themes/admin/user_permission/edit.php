<!-- CONTENT -->
<div id="main-content">
    <div id="content">
        <div class="content-wrap scroll-view">
            <section class="content-body">
                <div class="row">
                <?php echo form_open('','class="form"'); ?>
                    <input type="hidden" name="user_group_id" value="<?php echo $user_group['user_group_id']; ?>">
                    <div class="col-md-8">
                        <div class="card card-line">
                            <div class="card-header">
                                <div class="card-header-title">
                                <i class="icon ion-person"></i>Edit User Group
                                </div>

                                <div class="tools">
                                    <div class="btn-group">
                                        <a class="btn btn-default btn-icon-toggle btn-collapse"><i class="icon ion-chevron-down menu-caret"></i></a>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="form-group <?php if (form_error('name')) { echo 'has-error';  } ?>">
                                    <input type="text" class="form-control" id="name" name="name" value="<?php echo $user_group['name']; ?>" <?php if($user_group['name']); ?> >
                                    <label for="name"><?php echo lang('text_user_group_name') ?> <span class="required">*</span></label>
                                    <?php echo form_error('name', '<p class="help-block ">', '</p>'); ?>
                                </div>

                                <div class="form-group">
                                    <div class="well" style="height: 150px; overflow: auto; border-radius: 0; margin-top: 10px">
                                    <?php if(count($permissions)) : ?>
                                    <?php
                                    foreach ($permissions as $permission_value) {
                                        $active = false;
                                        foreach($user_group['permission']['access'] as $selected){
                                            if($permission_value == $selected){
                                                $active = true;
                                            }
                                        }
                                    ?>
                                    <div class="form-group" style="padding-top: 0;">
                                        <div class="checkbox checkbox-styled" style="margin: 0">
                                            <label style="padding-left: 0;">
                                                <input type="checkbox" name="permission[access][]" value="<?php echo $permission_value; ?>" class="iCheck" <?php if($active===true) echo "checked"; ?>>
                                                <span><?php echo ucwords($permission_value); ?></span>
                                            </label>
                                        </div>
                                    </div>
                                    <?php } ?>
                                    <?php endif ?>

                                    </div>
                                    <label><?php echo lang('text_permission_access') ?> <span class="required">*</span>
                                        <div onclick="select_all(this);" class="btn btn-link">Select All</div> / <div onclick="unselect_all(this);" class="btn btn-link">Unselect All</div>
                                    </label>
                                </div>

                                <div class="form-group">
                                    <div class="well" style="height: 150px; overflow: auto; border-radius: 0; margin-top: 10px">
                                        <?php if(count($permissions)) : ?>
                                        <?php
                                        foreach ($permissions as $permission_value) {
                                            $active = false;
                                            foreach($user_group['permission']['modify'] as $selected){
                                                if($permission_value == $selected){
                                                    $active = true;
                                                }
                                            }
                                        ?>
                                        <div class="form-group" style="padding-top: 0;">
                                            <div class="checkbox checkbox-styled" style="margin: 0">
                                                <label style="padding-left: 0;">
                                                    <input type="checkbox" name="permission[modify][]" value="<?php echo $permission_value; ?>" class="iCheck" <?php if($active===true) echo "checked"; ?>>
                                                    <span><?php echo ucwords($permission_value); ?></span>
                                                </label>
                                            </div>
                                        </div>
                                        <?php } ?>
                                        <?php endif ?>

                                    </div>
                                    <label><?php echo lang('text_permission_modify') ?> <span class="required">*</span>
                                        <div onclick="select_all(this);" class="btn btn-link">Select All</div> / <div onclick="unselect_all(this);" class="btn btn-link">Unselect All</div>
                                    </label>
                                </div>

                                <div class="form-group">
                                    <div class="well" style="height: 150px; overflow: auto; border-radius: 0; margin-top: 10px">
                                        <?php if(count($permissions)) : ?>
                                        <?php
                                        foreach ($permissions as $permission_value) {
                                            $active = false;
                                            foreach($user_group['permission']['publish'] as $selected){
                                                if($permission_value == $selected){
                                                    $active = true;
                                                }
                                            }
                                        ?>
                                        <div class="form-group" style="padding-top: 0;">
                                            <div class="checkbox checkbox-styled" style="margin: 0">
                                                <label style="padding-left: 0;">
                                                    <input type="checkbox" name="permission[publish][]" value="<?php echo $permission_value; ?>" class="iCheck" <?php if($active===true) echo "checked"; ?>>
                                                    <span><?php echo ucwords($permission_value); ?></span>
                                                </label>
                                            </div>
                                        </div>
                                        <?php } ?>
                                        <?php endif ?>

                                    </div>
                                    <label><?php echo lang('text_permission_publish') ?> <span class="required">*</span>
                                        <div onclick="select_all(this);" class="btn btn-link">Select All</div> / <div onclick="unselect_all(this);" class="btn btn-link">Unselect All</div>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="card card-line">
                            <div class="card-body">
                                <div>
                                    <label class="radio-styled">
                                        <input type="radio" name="status" class="iCheck" value="1" <?php if( $user_group['status'] == 1){ ?> checked <?php } ?>><span> <?php echo lang('text_enable') ?></span>
                                    </label>
                                    <label class="radio-inline radio-styled">
                                        <input type="radio" name="status" class="iCheck" value="0" <?php if( $user_group['status'] == 0){ ?> checked <?php } ?>><span> <?php echo lang('text_disable') ?></span>
                                    </label>
                                </div>
                            </div>

                            <div class="card-footer">
                                <div class="tools">
                                    <div class="btn-group">
                                        <a href="<?php echo site_url('admin/user/user_permission'); ?>" class="btn btn-default" role="button"><i class="icon ion-reply"></i> <?php echo lang('btn_back') ?></a>
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
    function select_all(e) {
        var checkboxes = $(e).parent().parent().find('input.iCheck');
        checkboxes.iCheck('check');
    }

    function unselect_all(e) {
        var checkboxes = $(e).parent().parent().find('input.iCheck');
        checkboxes.iCheck('uncheck');
    }
</script>