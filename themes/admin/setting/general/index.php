<!-- CONTENT -->
<div id="main-content">
    <div id="content">
        <div class="content-wrap scroll-view">
            <!-- <section class="content-header"></section> -->
            <section class="content-body">
                <?php if (isset($this->session->userdata['error'])) {echo '<div class="alert alert-warning alert-dismissable" role="alert">' . $this->session->userdata['error'] . '<button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button></div>'; } ?>
                <?php if (isset($this->session->userdata['success'])) {echo '<div class="alert alert-success alert-dismissable" role="alert">' . $this->session->userdata['success'] . '<button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button></div>'; } ?>

                <div class="row">
                    <?php echo form_open('admin/setting/general','class="form"'); ?>
                    <div class="col-md-12">
                        <div class="card card-line tabs-h-left">
                            <div class="card-header tab-h-icon">
                                <ul class="nav nav-tabs" role="tablist">
                                    <li role="presentation" class="active">
                                        <a href="#general" aria-controls="general" role="tab" data-toggle="tab">
                                            <i class="icon ion-settings"></i>
                                            <span><?php echo lang('text_setting_general') ?></span>
                                            <small><?php echo lang('text_setting_general_desc') ?></small>
                                        </a>
                                    </li>
                                    <li role="presentation">
                                        <a href="#localisation" aria-controls="localisation" role="tab" data-toggle="tab">
                                            <i class="icon ion-earth"></i>
                                            <span><?php echo lang('text_setting_localisation') ?></span>
                                            <small><?php echo lang('text_setting_localisation_desc') ?></small>
                                        </a>
                                    </li>
                                    <li role="presentation">
                                        <a href="#media-image" aria-controls="media-image" role="tab" data-toggle="tab">
                                            <i class="icon ion-images"></i>
                                            <span><?php echo lang('text_setting_media') ?></span>
                                            <small><?php echo lang('text_setting_media_desc') ?></small>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                            <div class="card-body no-padding" style="min-height: 350px;">
                                <div class="tab-content">
                                    <div role="tabpanel" class="tab-pane fade in active" id="general">
                                        <div class="card card-line no-border no-shadow no-margin">
                                            <div class="card-header">
                                                <ul class="nav nav-tabs pull-right" role="tablist">
                                                    <?php foreach($languages as $language): ?>
                                                    <li <?php if( $language['language_code'] === $language_code){ ?> class="active" <?php } ?>><a href="#tab-language-<?php echo $language['language_code']; ?>" aria-controls="#tab-language-<?php echo $language['language_code']; ?>" role="tab" data-toggle="tab"><img src="<?php echo ADMIN_ASSETS_URL . 'images/flags/' . $language['image']; ?>" alt=""> <span class="hidden-xs"> <?php echo $language['name']; ?></span></a></li>
                                                    <?php endforeach; ?>
                                                </ul>
                                            </div>
                                            <div class="card-body tab-content">
                                                <?php $row = 1; ?>
                                                <?php foreach($languages as $language): ?>
                                                <div class="tab-pane <?php if( $language['language_code'] === $language_code){ ?> active <?php } ?>" id="tab-language-<?php echo $language['language_code']; ?>" role="tabpanel">
                                                    <div class="form-group">
                                                        <input type="text" class="form-control" id="website_name" name="general_setting[<?php echo $language['language_code'] ?>][website_name]" value="<?php echo $general[$language['language_code']]['website_name'] ?>">
                                                        <label for="website_name"><?php echo lang('text_setting_web_name') ?></label>
                                                    </div>
                                                    <div class="form-group">
                                                        <textarea name="general_setting[<?php echo $language['language_code'] ?>][website_description]" id="website_description" class="form-control" rows="3"><?php echo $general[$language['language_code']]['website_description']; ?></textarea>
                                                        <label for="website_description"><?php echo lang('text_setting_web_desc') ?></label>
                                                    </div>
                                                    <div class="form-group">
                                                        <input type="text" class="form-control" id="website_location" name="general_setting[<?php echo $language['language_code'] ?>][website_location]" value="<?php echo $general[$language['language_code']]['website_location'] ?>">
                                                        <label for="website_location"><?php echo lang('text_setting_web_location') ?></label>
                                                    </div>
                                                    <div class="form-group">
                                                        <textarea name="general_setting[<?php echo $language['language_code'] ?>][website_address]" id="website_address" class="form-control" rows="3"><?php echo $general[$language['language_code']]['website_address']; ?></textarea>
                                                        <label for="website_address"><?php echo lang('text_setting_web_address') ?></label>
                                                    </div>
                                                    <div class="form-group">
                                                        <input type="text" class="form-control" id="website_email" name="general_setting[<?php echo $language['language_code'] ?>][website_email]" value="<?php echo $general[$language['language_code']]['website_email'] ?>">
                                                        <label for="website_email"><?php echo lang('text_setting_web_email') ?></label>
                                                    </div>
                                                    <div class="form-group">
                                                        <input type="text" class="form-control" id="website_phone" name="general_setting[<?php echo $language['language_code'] ?>][website_phone]" value="<?php echo $general[$language['language_code']]['website_phone'] ?>">
                                                        <label for="website_phone"><?php echo lang('text_setting_web_phone') ?></label>
                                                    </div>
                                                </div>
                                                <?php endforeach; ?>
                                                <?php $row++; ?>
                                            </div>
                                        </div>
                                    </div>
                                    <div role="tabpanel" class="tab-pane fade" id="localisation" style="padding: 20px">
                                        <div class="form-group">
                                            <select id="language_code" name="localisation_setting[language_code]" class="form-control select2_single">
                                                <?php foreach( $languages as $language ): ?>
                                                <option value="<?php echo $language['language_code'] ?>" <?php if($language['language_code'] === $localisation['language_code']) echo "selected"; ?> ><?php echo $language['name']; ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                            <label for="language_code"><?php echo lang('text_frontend_language') ?></label>
                                        </div>
                                    </div>
                                    <div role="tabpanel" class="tab-pane fade" id="media-image" style="padding: 20px">
                                        <div class="form-group">
                                            <div class="input-group">
                                                <div class="input-group-content">
                                                    <input type="text" class="form-control" name="media_setting[image_lg_width]" value="<?php echo $media['image_lg_width']; ?>">
                                                </div>
                                                <span class="input-group-addon">*</span>
                                                <div class="input-group-content">
                                                    <input type="text" class="form-control" name="media_setting[image_lg_height]" value="<?php echo $media['image_lg_height']; ?>">
                                                </div>
                                            </div>
                                            <label><?php echo lang('text_setting_image_large') ?></label>
                                        </div>
                                        <div class="form-group">
                                            <div class="input-group">
                                                <div class="input-group-content">
                                                    <input type="text" class="form-control" name="media_setting[image_md_width]" value="<?php echo $media['image_md_width']; ?>">
                                                </div>
                                                <span class="input-group-addon">*</span>
                                                <div class="input-group-content">
                                                    <input type="text" class="form-control" name="media_setting[image_md_height]" value="<?php echo $media['image_md_height']; ?>">
                                                    <div class="form-control-line"></div>
                                                </div>
                                            </div>
                                            <label><?php echo lang('text_setting_image_medium') ?></label>
                                        </div>
                                        <div class="form-group">
                                            <div class="input-group">
                                                <div class="input-group-content">
                                                    <input type="text" class="form-control" name="media_setting[image_sm_width]" value="<?php echo $media['image_sm_width']; ?>">
                                                </div>
                                                <span class="input-group-addon">*</span>
                                                <div class="input-group-content">
                                                    <input type="text" class="form-control" name="media_setting[image_sm_height]" value="<?php echo $media['image_sm_height']; ?>">
                                                    <div class="form-control-line"></div>
                                                </div>
                                            </div>
                                            <label><?php echo lang('text_setting_image_small') ?></label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer">
                                <div class="tools">
                                    <div class="btn-group">
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