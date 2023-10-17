<!-- CONTENT -->
<div id="main-content">
    <div id="content">
        <div class="content-wrap scroll-view">
            <!-- <section class="content-header"></section> -->
            <section class="content-body">
                <?php if (isset($this->session->userdata['error'])) { echo '<div class="alert alert-warning alert-dismissable" role="alert">' . $this->session->userdata['error'] . '<button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button></div>'; } ?>

                <div class="row">
                <?php echo form_open('','class="form"'); ?>
                    <?php if ($comment): ?>
                    <div class="col-md-8">
                        <div class="card card-line">
                            <div class="card-header">
                                <div class="card-header-title">
                                <i class="icon ion-edit"></i><?php echo lang('text_edit_comment') ?>
                                </div>

                                <div class="tools">
                                    <div class="btn-group">
                                        <a class="btn btn-default btn-icon-toggle btn-collapse"><i class="icon ion-chevron-down menu-caret"></i></a>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="form-group <?php if (form_error("user")) { echo 'has-error';  } ?>">
                                    <input type="text" class="form-control" id="user" name="user" value="<?php echo $comment['user']; ?>">
                                    <label for="user"><?php echo lang('text_author') ?> <span class="required">*</span></label>
                                    <?php echo form_error("user", '<p class="help-block ">', '</p>'); ?>
                                </div>
                                <div class="form-group">
                                    <input type="text" class="form-control" id="email" name="email" value="<?php echo $comment['email']; ?>">
                                    <label for="email"><?php echo lang('text_email') ?></label>
                                </div>
                                <div class="form-group">
                                    <input type="text" class="form-control" id="url" name="url" value="<?php echo $comment['url']; ?>">
                                    <label for="url"><?php echo lang('text_url') ?></label>
                                </div>
                                <div class="form-group">
                                    <textarea name="comment" id="comment" class="form-control" rows="3"><?php echo $comment['comment']; ?></textarea>
                                    <label for="comment"><?php echo lang('text_comment') ?></label>
                                </div>
                                <div class="form-group">
                                    <input type="text" class="form-control" id="comment" disabled value="<?php echo $comment['article_title']; ?>">
                                    <label for="comment"><?php echo lang('text_comment_for') ?></label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="card card-line">
                            <div class="card-body">
                                <div>
                                    <label class="radio-styled">
                                        <input type="radio" name="status" value="1" <?php if( $comment['status'] == 1){ ?> checked <?php } ?> class="iCheck"><span> <?php echo lang('text_enable') ?></span>
                                    </label>
                                    <label class="radio-inline radio-styled">
                                        <input type="radio" name="status" value="0" <?php if( $comment['status'] == 0){ ?> checked <?php } ?> class="iCheck"><span> <?php echo lang('text_disable') ?></span>
                                    </label>
                                </div>
                            </div>

                            <div class="card-footer">
                                <div class="tools">
                                    <div class="btn-group">
                                        <a href="<?php echo site_url('admin/blog/comment'); ?>" class="btn btn-default" role="button"><i class="icon ion-reply"></i> <?php echo lang('btn_back') ?></a>
                                        <button class="btn btn-primary" type="submit">
                                            <?php echo lang('btn_save') ?>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <?php else : ?>
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-body">
                                <p>ID Komentar tidak sah <a href="javascript:history.go(-1)"><?php echo lang('btn_back') ?></a></p>
                            </div>
                        </div><!--end .card -->
                    </div>
                    <?php endif ?>
                <?php echo form_close();?>
                </div>
            </section>
        </div>
    </div>
</div>