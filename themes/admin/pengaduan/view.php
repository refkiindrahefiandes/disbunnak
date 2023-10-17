<!-- CONTENT -->
<div id="main-content">
    <div id="content">
        <div class="content-wrap scroll-view">
            <!-- <section class="content-header"></section> -->
            <section class="content-body">
                <?php if (isset($this->session->userdata['error'])) { echo '<div class="alert alert-warning alert-dismissable" role="alert">' . $this->session->userdata['error'] . '<button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button></div>'; } ?>

                <div class="row">
                <?php echo form_open('','class="form"'); ?>
                    <input type="hidden" name="pengaduan_id" value="<?php echo $contact['pengaduan_id']; ?>">
                    <div class="col-md-6">
                        <div class="card card-line">
                            <div class="card-header">
                                <div class="card-header-title">
                                    <i class="icon ion-ios-photos"></i>Pengaduan
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
                    </div>
                    <div class="col-md-6">

                    <div class="card card-line">
							<div class="card-header">
								<div class="card-header-title"><i class="icon ion-ios-people"></i>Riwayat</div>
								
							</div>
							<div class="card-body" style="padding: 0 0 24px 0">
								<div class="nicescroll" style="max-height: 400px; padding: 24px 24px 0 24px; overflow: hidden;">
									<ul class="timeline-line">
                                        <li class="approved" ><?= strtoupper($contact['name']) ?>
                                        <p class="describe"> Dibuat pada <?=  long_date('D, j M Y',  $contact['date_added'], $this->data['language_code']) ?>;
                                        </li>
                                        <li class="approved" > OPERATOR
                                        <p class="describe"> Diteruskan pada <?=  long_date('D, j M Y',  $contact['date_submit'], $this->data['language_code']) ?>;
                                        </li>
                                        <li class="approved" > 
                                            <?php switch ($contact['is_level']) {
                                                case '1':
                                                    echo 'PEMODALAN';
                                                    break;
                                                case '2':
                                                    echo 'PERIZINAN';
                                                    break;
                                                case '3':
                                                    echo 'NAKER';
                                                    break;
                                                
                                                default:
                                                    # code...
                                                    break;
                                            } ?>
                                        <p class="describe"> Dijawab pada <?=  long_date('D, j M Y',  $contact['date_submit'], $this->data['language_code']) ?>;
                                        </li>
									</ul>
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
                                        <div class="form-group">
                                            <input type="text" class="form-control" value="<?php echo $reply['user_email'] ?>" readonly>
                                            <label for="user_email">Email Penerima</label>
                                        </div>
                                        <div class="form-group">
                                            <input type="text" class="form-control"  value="<?php echo $reply['reply_title'] ?>"readonly>
                                            <label for="reply_title">Judul</label>
                                        </div>
                                        <div class="form-group">
                                            <?=  $reply['reply_desc'] ?>
                                            <label for="desc_contact">Isi Balasan</label>
                                        </div>
                                    <?php endforeach; endif; ?>
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
    <?php //tmce_init('200') ?>
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