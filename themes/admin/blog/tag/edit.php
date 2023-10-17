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
                    <input type="hidden" name="tag_data[term_id]" value="<?php echo $tag['tag_data']['term_id']; ?>">
                    <div class="col-md-8">
                        <div class="card card-line">
                            <div class="card-header">
                                <div class="card-header-title">
                                    <i class="icon ion-edit"></i><?php echo lang('text_edit_tag') ?>
                                </div>

                                <div class="tools">
                                    <div class="btn-group">
                                        <a class="btn btn-default btn-icon-toggle btn-collapse"><i class="icon ion-chevron-down menu-caret"></i></a>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="form-group <?php if (form_error("tag_desc[name]")) { echo 'has-error';  } ?>">
                                    <input type="text" class="form-control" id="name" name="tag_desc[name]" value="<?php echo $tag['tag_desc']['name'] ?>">
                                    <label for="name"><?php echo lang('text_tag_name') ?> <span class="required">*</span></label>
                                    <?php echo form_error("tag_desc[name]", '<p class="help-block ">', '</p>'); ?>
                                </div>
                                <div class="form-group">
                                    <textarea name="tag_desc[description]" id="textarea" class="form-control" rows="10"><?php echo $tag['tag_desc']['description'] ?></textarea>
                                    <label for="textarea"><?php echo lang('text_description') ?></label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="card card-line">
                            <div class="card-body">
                                <div class="form-group">
                                    <select id="language_code" name="tag_desc[language_code]" class="form-control select2_single">
                                        <?php foreach( $languages as $language ): ?>
                                        <option value="<?php echo $language['language_code'];?>" <?php if($language['language_code'] == $tag['tag_desc']['language_code']) echo "selected"; ?> ><?php echo $language['name']; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                    <label for="language_code"><?php echo lang('text_language') ?></label>
                                </div>

                                <div class="form-group">
                                    <input type="text" class="form-control" id="sort_order" name="tag_data[sort_order]" value="<?php echo $tag['tag_data']['sort_order']; ?>">
                                    <label for="sort_order"><?php echo lang('text_sort_order') ?></label>
                                </div>
                                <div>
                                    <label class="radio-styled">
                                        <input type="radio" name="tag_data[status]" value="1" <?php if( $tag['tag_data']['status'] == 1){ ?> checked <?php } ?> class="iCheck"><span> <?php echo lang('text_enable') ?></span>
                                    </label>
                                    <label class="radio-inline radio-styled">
                                        <input type="radio" name="tag_data[status]" value="0" <?php if( $tag['tag_data']['status'] == 0){ ?> checked <?php } ?> class="iCheck"><span> <?php echo lang('text_disable') ?></span>
                                    </label>
                                </div>
                            </div>

                            <div class="card-footer">
                                <div class="tools">
                                    <div class="btn-group">
                                        <a href="<?php echo site_url('admin/blog/tag'); ?>" class="btn btn-default" role="button"><i class="icon ion-reply"></i> <?php echo lang('btn_back') ?></a>
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