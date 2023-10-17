<!-- CONTENT -->
<div id="main-content">
    <div id="content">
        <div class="content-wrap scroll-view">
            <!-- <section class="content-header"></section> -->
            <section class="content-body">
                <?php if (isset($this->session->userdata['error'])) { echo '<div class="alert alert-warning alert-dismissable" role="alert">' . $this->session->userdata['error'] . '<button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button></div>'; } ?>

                <div class="row">
                <?php echo form_open('','class="form"'); ?>
                    <input type="hidden" name="contact_id" value="<?php echo $contact['contact_id']; ?>">
                    <div class="col-md-8">
                        <div class="card card-line">
                            <div class="card-header">
                                <div class="card-header-title">
                                    <i class="icon ion-ios-photos"></i>Contact Form
                                </div>

                                <div class="tools">
                                    <div class="btn-group">
                                        <a class="btn btn-default btn-icon-toggle btn-collapse"><i class="icon ion-chevron-down menu-caret"></i></a>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body tab-content">
                                <div class="form-group">
                                    <input type="text" class="form-control" id="date_added" value="<?php echo long_date('D, j M Y', $contact['date_added']) ?>" disabled>
                                    <label for="date_added">Tanggal Pesan</label>
                                </div>
                                <div class="form-group">
                                    <input type="text" class="form-control" id="name" value="<?php echo $contact['name'] ?>" disabled>
                                    <label for="name">Pesan dari</label>
                                </div>
                                <div class="form-group">
                                    <input type="text" class="form-control" id="email" value="<?php echo $contact['email'] ?>" disabled>
                                    <label for="email">Email</label>
                                </div>
                                <div class="form-group">
                                    <input type="text" class="form-control" id="phone" value="<?php echo $contact['phone'] ?>" disabled>
                                    <label for="phone">Telp./HP</label>
                                </div>
                                <div class="form-group">
                                    <input type="text" class="form-control" id="jenis_contact" value="<?php echo $contact['type'] ?>" disabled>
                                    <label for="jenis_contact">Jenis Informasi</label>
                                </div>
                                <div class="form-group">
                                    <?php echo $contact['content']; ?>
                                    <label for="desc_contact">Isi Pesan</label>
                                </div>
                            </div>
                        </div>

                        <div class="card card-line">
                            <div class="card-header">
                                <div class="card-header-title">
                                    <i class="icon ion-ios-photos"></i>Balasan
                                </div>

                                <div class="tools">
                                    <div class="btn-group">
                                        <a class="btn btn-default btn-icon-toggle btn-collapse"><i class="icon ion-chevron-down menu-caret"></i></a>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <?php if ($contact_reply) : foreach ($contact_reply as $reply) : ?>
                                    <table class="table table-striped table-hover dataTable no-footer" style="margin-bottom: 30px!important;">
                                        <tbody>
                                            <tr>
                                                <td style="width: 100px;">Email Penerima</td>
                                                <td style="width: 20px;">:</td>
                                                <td><?php echo $reply['user_email'] ?></td>
                                            </tr>
                                            <tr>
                                                <td>Title</td>
                                                <td>:</td>
                                                <td><?php echo $reply['reply_title'] ?></td>
                                            </tr>
                                            <tr>
                                                <td>Balasan</td>
                                                <td>:</td>
                                                <td><?php echo $reply['reply_desc'] ?></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                <?php endforeach; else : ?>
                                <p>Belum ada balasan!</p>
                                <?php endif ?>
                            </div>
                        </div>

                        <div class="card">
                            <div class="card-body">
                                <div class="form-group">
                                    <input type="text" class="form-control" name="user_email" value="<?php echo $contact['email'] ?>">
                                    <label for="user_email">Email Penerima</label>
                                </div>
                                <div class="form-group">
                                    <input type="text" class="form-control" name="reply_title">
                                    <label for="reply_title">Judul</label>
                                </div>
                                <div class="form-group">
                                    <textarea id="reply_desc" name="reply_desc" class="form-control textarea" rows="5"></textarea>
                                    <label for="reply_desc">Tuliskan Balasan</label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="card card-line">
                            <div class="card-body">
                                <div class="form-group <?php if (form_error("status")) { echo 'has-error';  } ?>">
                                    <select id="status" name="status" class="form-control select2_single">
                                        <?php foreach($contact_status_text as $key => $status): ?>
                                        <option value="<?php echo $key; ?>" <?php if($key == $contact['status']) echo "selected"; ?> ><?php echo $status; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                    <label for="select1">Pilih Status Pesan <span class="required">*</span></label>
                                    <?php echo form_error("status", '<p class="help-block ">', '</p>'); ?>
                                </div>
                            </div>

                            <div class="card-footer">
                                <div class="tools">
                                    <div class="btn-group">
                                        <a href="<?php echo site_url('admin/contact'); ?>" class="btn btn-default" role="button"><i class="icon ion-reply"></i> <?php echo lang('btn_back') ?></a>
                                        <button class="btn btn-primary" type="submit">
                                            Kirim Balasan
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

<script>
$(document).ready(function() {
    // Call TinyMCE
    <?php tmce_init('200') ?>
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