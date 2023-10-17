<!-- CONTENT -->
<div id="main-content">
    <div id="content">
        <div class="content-wrap scroll-view">
            <!-- <section class="content-header"></section> -->
            <section class="content-body">
                <?php if (isset($this->session->userdata['error'])) { echo '<div class="alert alert-warning alert-dismissable" role="alert">' . $this->session->userdata['error'] . '<button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button></div>'; } ?>

                <div class="row">
                <?php echo form_open('','class="form"'); ?>
                    <div class="col-md-8">
                        <div class="card card-line">
                            <div class="card-header">
                                <div class="card-header-title">
                                    <i class="icon ion-ios-photos"></i>Edit Pertanyaan
                                </div>

                                <div class="tools">
                                    <div class="btn-group">
                                        <a class="btn btn-default btn-icon-toggle btn-collapse"><i class="icon ion-chevron-down menu-caret"></i></a>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body tab-content">
                                <div class="form-group <?php if (form_error("judul")) { echo 'has-error';  } ?>">
                                    <input type="text" class="form-control" id="judul" name="judul" value="<?php echo $skm['judul'] ?>">
                                    <label for="name">Judul <span class="required">*</span></label>
                                    <?php echo form_error("judul", '<p class="help-block ">', '</p>'); ?>
                                </div>
                                <div class="form-group <?php if (form_error("keterangan")) { echo 'has-error';  } ?>">
                                    <textarea name="keterangan" id="keterangan" class="form-control" rows="5"><?php echo $skm['keterangan'] ?></textarea>
                                    <label for="name">Keterangan <span class="required">*</span></label>
                                    <?php echo form_error("keterangan", '<p class="help-block ">', '</p>'); ?>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="card card-line">
                            <div class="card-body">
                                <div>
                                    <label class="radio-styled">
                                        <input type="radio" name="status" class="iCheck" value="1" <?php if( $skm['status'] == 1){ ?> checked <?php } ?>><span> <?php echo lang('text_enable') ?></span>
                                    </label>
                                    <label class="radio-inline radio-styled">
                                        <input type="radio" name="status" class="iCheck" value="0" <?php if( $skm['status'] == 0){ ?> checked <?php } ?>><span> <?php echo lang('text_disable') ?></span>
                                    </label>
                                </div>
                            </div>

                            <div class="card-footer">
                                <div class="tools">
                                    <div class="btn-group">
                                        <a href="<?php echo site_url('admin/skm'); ?>" class="btn btn-default" role="button"><i class="icon ion-reply"></i> <?php echo lang('btn_back') ?></a>
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

<style>
    .editor-tabs {
        text-align: right;
    }

    textarea.form-control {
        margin-top: 10px;
        border: 1px solid #ddd;
        padding: 10px;
    }
</style>