<!-- CONTENT -->
<div id="main-content">
    <div id="content">
        <div class="content-wrap scroll-view">
            <!-- <section class="content-header"></section> -->
            <section class="content-body">
                <?php if (isset($this->session->userdata['error'])) { echo '<div class="alert alert-warning alert-dismissable" role="alert">' . $this->session->userdata['error'] . '<button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button></div>'; } ?>
                <?php echo validation_errors('<div class="alert alert-warning alert-dismissable" role="alert">', '<button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button></div>'); ?>
                <div class="row">
                <?php echo form_open('','class="form"'); ?>
                    <input type="hidden" name="category_data[term_id]" value="<?php echo $category['category_data']['term_id']; ?>">
                    <div class="col-md-8">
                        <div class="card card-line">
                            <div class="card-header">
                                <div class="card-header-title">
                                <i class="icon ion-edit"></i><?php echo lang('text_edit_category') ?>
                                </div>

                                <div class="tools">
                                    <div class="btn-group">
                                        <a class="btn btn-default btn-icon-toggle btn-collapse"><i class="icon ion-chevron-down menu-caret"></i></a>
                                    </div>
                                </div>

                                <ul class="nav nav-tabs pull-right" role="tablist">
                                    <?php foreach($languages as $language): ?>
                                    <li <?php if( $language['language_code'] == $language_code){ ?> class="active" <?php } ?>><a href="#tab-language-<?php echo $language['language_code']; ?>" role="tab" data-toggle="tab"><img src="<?php echo ADMIN_ASSETS_URL . 'images/flags/' . $language['image']; ?>" alt=""> <span class="hidden-xs"> <?php echo $language['name']; ?></span></a></li>
                                    <?php endforeach; ?>
                                </ul>
                            </div>
                            <div class="card-body tab-content">
                                <?php foreach($languages as $language): ?>
                                <div class="tab-pane <?php if( $language['language_code'] == $language_code){ ?> active <?php } ?>" id="tab-language-<?php echo $language['language_code']; ?>" role="tabpanel">
                                    <div class="form-group <?php if (form_error("category_desc[$language[language_code]][name]")) { echo 'has-error';  } ?>">
                                        <input type="text" class="form-control" id="name-<?php echo $language['language_code']; ?>" name="category_desc[<?php echo $language['language_code']; ?>][name]" value="<?php echo $category['category_desc'][$language['language_code']]['name'] ?>">
                                        <label for="name-<?php echo $language['language_code']; ?>"><?php echo lang('text_category_name') ?> <span class="required">*</span></label>
                                        <?php echo form_error("category_desc[$language[language_code]][name]", '<p class="help-block ">', '</p>'); ?>
                                    </div>
                                    <div class="form-group">
                                        <textarea name="category_desc[<?php echo $language['language_code']; ?>][description]" id="textarea-<?php echo $language['language_code']; ?>" class="form-control summernote" rows="10"><?php echo $category['category_desc'][$language['language_code']]['description'] ?></textarea>
                                        <label for="textarea-<?php echo $language['language_code']; ?>"><?php echo lang('text_description') ?></label>
                                    </div>
                                </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="card card-line">
                            <div class="card-body">
                                <div class="form-group">
                                    <select id="category" class="form-control select2_single" name="category_data[parent_id]">
                                        <option value="0"><?php echo lang('text_no_parent') ?></option>
                                        <?php foreach ($categories as $parent_category) { ?>
                                        <option value="<?php echo $parent_category['term_desc'][$language_code]['term_id']; ?>" <?php if ($parent_category['term_desc'][$language_code]['term_id'] == $category['category_data']['parent_id']) { echo "selected"; } ?>><?php echo $parent_category['term_desc'][$language_code]['name']; ?></option>
                                        <?php } ?>
                                    </select>
                                    <label for="category"><?php echo lang('text_select_parent_category') ?></label>
                                </div>
                                <div class="form-group">
                                    <input type="text" class="form-control" id="sort_order" name="category_data[sort_order]" value="<?php echo $category['category_data']['sort_order']; ?>">
                                    <label for="sort_order"><?php echo lang('text_sort_order') ?></label>
                                </div>
                                <div>
                                    <label class="radio-styled">
                                        <input type="radio" name="category_data[status]" value="1" <?php if( $category['category_data']['status'] == 1){ ?> checked <?php } ?> class="iCheck"><span> <?php echo lang('text_enable') ?></span>
                                    </label>
                                    <label class="radio-inline radio-styled">
                                        <input type="radio" name="category_data[status]" value="0" <?php if( $category['category_data']['status'] == 0){ ?> checked <?php } ?> class="iCheck"><span> <?php echo lang('text_disable') ?></span>
                                    </label>
                                </div>
                            </div>

                            <div class="card-footer">
                                <div class="tools">
                                    <div class="btn-group">
                                        <a href="<?php echo site_url('admin/blog/category'); ?>" class="btn btn-default" role="button"><i class="icon ion-reply"></i> <?php echo lang('btn_back') ?></a>
                                        <button class="btn btn-primary" type="submit">
                                            <?php echo $button; ?>
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