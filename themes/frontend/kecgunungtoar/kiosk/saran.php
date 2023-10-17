<div class="row">
	<div class="col-md-12">
		<?php echo form_open('','class="form" id="form"'); ?>
            <div class="form-pengaduan">

                <div class="form-group hp-comment">
                    <input type="text" name="name" value="" id="name" class="form-control">
                </div>
                <div class="form-group <?php if (form_error("nama")) { echo 'has-error';  } ?>">
                    <label class="control-label" for="nama">Nama <span class="required">*</span></label>
                    <input type="text" class="form-control" id="nama" name="nama" value="">
                    <?php echo form_error("nama", '<p class="help-block ">', '</p>'); ?>
                </div>
                <div class="form-group <?php if (form_error("email")) { echo 'has-error';  } ?>">
                    <label class="control-label" for="email">Email <span class="required">*</span></label>
                    <input type="text" class="form-control" id="email" name="email" value="">
                    <?php echo form_error("email", '<p class="help-block ">', '</p>'); ?>
                </div>
                <div class="form-group">
                    <label class="control-label" for="hp">Nomor Handphone</label>
                    <input type="text" class="form-control" id="hp" name="hp" value="">
                    <span class="help-block pull-right">Optional</span>
                </div>
                <div class="form-group">
                    <label class="control-label" for="type"><?php echo lang('text_type') ?></label>
                    <select id="type" name="type" class="form-control" style="height: 50px">
                        <option value="">-- <?php echo lang('text_select_type') ?> --</option>
                        <?php foreach($type as $key => $jenis): ?>
                        <option value="<?php echo $key; ?>"><?php echo $jenis; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-group <?php if (form_error("content")) { echo 'has-error';  } ?>">
                    <label class="control-label" for="email">Saran <span class="required">*</span></label>
                    <textarea name="content" id="content" class="form-control" rows="5"></textarea>
                    <?php echo form_error("content", '<p class="help-block ">', '</p>'); ?>
                </div>
            </div>
		<?php echo form_close();?>
	</div>
</div>
<script>
function submitForm(e) {
    var Url = '<?=base_url()?>' + 'kiosk/submit';

    $.ajax({
        url: Url,
        type: "POST",
        data: $('#form').serialize(),
        dataType: 'json',
        beforeSend: function() {
        },
        complete: function() {
        },
        success: function(json) {
            if (json['success']) {
                $('.alert').remove();
                $('body').find('.modal-body').prepend(json['success']);
                $('body').find('.form-pengaduan').remove();
                $('body').find('#button-submit').remove();
            }
            if (json['error']) {
                $('.alert').remove();
                $('body').find('.modal-body').prepend(json['error']);
            }
        }
    });
}
</script>
<style>
	.card .card-header .card-header-title {
		display: block;
		padding: 0;
	}

	.card .card-header .card-header-title a {
		display: block;
		line-height: 56px;
	}

    .modal-body {
        padding: 30px!important;
    }

    .hp-comment {
        display: none!important;
    }

</style>