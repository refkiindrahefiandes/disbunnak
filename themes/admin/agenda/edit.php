<!-- CONTENT -->
<div id="main-content">
    <div id="content">
        <div class="content-wrap scroll-view">
            <!-- <section class="content-header"></section> -->
            <section class="content-body">
                <?php if (isset($this->session->userdata['error'])) {
                    echo '<div class="alert alert-warning alert-dismissable" role="alert">' . $this->session->userdata['error'] . '<button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button></div>';
                } ?>
                <?php echo validation_errors('<div class="alert alert-warning alert-dismissable" role="alert">', '<button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button></div>'); ?>

                <div class="row">
                    <?php echo form_open('', 'class="form"'); ?>
                    <input type="hidden" name="agenda_data[agenda_id]" value="<?php echo $agenda['agenda_data']['agenda_id']; ?>">
                    <div class="col-md-8">
                        <div class="card card-line">
                            <div class="card-header">
                                <div class="card-header-title">
                                    <i class="icon ion-ios-photos"></i><?php echo lang('text_edit_agenda') ?>
                                </div>

                                <div class="tools">
                                    <div class="btn-group">
                                        <a class="btn btn-default btn-icon-toggle btn-collapse"><i class="icon ion-chevron-down menu-caret"></i></a>
                                    </div>
                                </div>

                                <ul class="nav nav-tabs pull-right" data-toggle="tabs">
                                    <?php foreach ($languages as $language) : ?>
                                        <li <?php if ($language['language_code'] == $language_code) { ?> class="active" <?php } ?>><a href="#tab-language-<?php echo $language['language_code']; ?>" aria-controls="#tab-language-<?php echo $language['language_code']; ?>" role="tab" data-toggle="tab"><img src="<?php echo ADMIN_ASSETS_URL . 'images/flags/' . $language['image']; ?>" alt=""> <span class="hidden-xs"> <?php echo $language['name']; ?></span></a></li>
                                    <?php endforeach; ?>
                                </ul>
                            </div>
                            <div class="card-body tab-content">
                                <?php foreach ($languages as $language) : ?>
                                    <div class="tab-pane <?php if ($language['language_code'] == $language_code) { ?> active <?php } ?>" id="tab-language-<?php echo $language['language_code']; ?>" role="tabpanel">
                                        <div class="form-group <?php if (form_error("agenda_desc[$language[language_code]][description]")) {
                                                                        echo 'has-error';
                                                                    } ?>">
                                            <textarea name="agenda_desc[<?php echo $language['language_code']; ?>][description]" id="textarea-<?php echo $language['language_code']; ?>" class="form-control textarea" rows="7"><?php echo $agenda['agenda_desc'][$language['language_code']]['description'] ?></textarea>
                                            <label for="name-<?php echo $language['language_code']; ?>">Kegiatan <span class="required">*</span></label>
                                            <?php echo form_error("agenda_desc[$language[language_code]][title]", '<p class="help-block ">', '</p>'); ?>
                                        </div>
                                        <div class="form-group">
                                            <textarea name="agenda_desc[<?php echo $language['language_code']; ?>][information]" id="textarea-<?php echo $language['language_code']; ?>" class="form-control textarea" rows="7"><?php echo $agenda['agenda_desc'][$language['language_code']]['information'] ?></textarea>
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
                                    <label>Tanggal Mulai</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control datesingle" name="agenda_data[date_begin]" value="<?php echo $agenda['agenda_data']['date_begin']; ?>">
                                        <span class="input-group-addon"><i class="icon ion-calendar"></i></span>
                                    </div>
                                    <p class="help-block"><?php echo lang('form_info_date') ?></p>
                                </div>
                                <div class="form-group">
                                    <label>Tanggal Berakhir</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control datesingle" name="agenda_data[date_end]" value="<?php echo $agenda['agenda_data']['date_end']; ?>">
                                        <span class="input-group-addon"><i class="icon ion-calendar"></i></span>
                                    </div>
                                    <p class="help-block"><?php echo lang('form_info_date') ?></p>
                                </div>
                                <div class="form-group">
                                    <label>Jam</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control" name="agenda_data[time]" value="<?php echo $agenda['agenda_data']['time']; ?>">
                                        <span class="input-group-addon"><i class="icon ion-clock"></i></span>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <input type="text" class="form-control" id="sort_order" name="agenda_data[location]" value="<?php echo $agenda['agenda_data']['location']; ?>">
                                    <label for="sort_order">Tempat</label>
                                </div>
                                <div class="form-group">
                                    <input type="text" class="form-control" id="sort_order" name="agenda_data[organizer]" value="<?php echo $agenda['agenda_data']['organizer']; ?>">
                                    <label for="sort_order">Pelaksana</label>
                                </div>

                                <?php if ($publish_permission) : ?>
                                    <div>
                                        <label class="radio-styled">
                                            <input type="radio" name="agenda_data[status]" class="iCheck" value="1" <?php if ($agenda['agenda_data']['status'] == 1) { ?> checked <?php } ?>><span> <?php echo lang('text_publish') ?></span>
                                        </label>
                                        <label class="radio-inline radio-styled">
                                            <input type="radio" name="agenda_data[status]" class="iCheck" value="0" <?php if ($agenda['agenda_data']['status'] == 0) { ?> checked <?php } ?>><span> <?php echo lang('text_unpublish') ?></span>
                                        </label>
                                    </div>
                                <?php endif ?>
                            </div>

                            <div class="card-footer">
                                <div class="tools">
                                    <div class="btn-group">
                                        <a href="<?php echo site_url('admin/agenda'); ?>" class="btn btn-default" role="button"><i class="icon ion-reply"></i> <?php echo lang('btn_back') ?></a>
                                        <button class="btn btn-primary" type="submit">
                                            <?php echo $button; ?>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php echo form_close(); ?>
                </div>
            </section>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {


    });
</script>
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