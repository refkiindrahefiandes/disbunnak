<?php if (count($result_nested)) : ?>
<div class="row">
	<div class="col-md-12">
		<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
			<?php foreach( $result_nested as $key => $result ) : ?>
                    <div class="panel-group" id="#<?php echo $key; ?>" role="tablist" aria-multiselectable="true">
                        <div class="panel">
                            <div class="panel-heading" role="tab" id="heading<?php echo $key; ?>">
                                <h4 class="panel-title" style="text-transform: uppercase;">
                                    <a role="button" data-toggle="collapse" data-parent="#<?php echo $key; ?>" href="#collapse<?php echo $key; ?>" aria-expanded="true" aria-controls="collapse<?php echo $key; ?>">
                                        <i class="fa fa-angle-down" aria-hidden="true"></i>
                                        <i class="fa fa-angle-right" aria-hidden="true"></i>
                                        <?php echo $result['name']; ?>
                                    </a>
                                </h4>
                            </div>
                            <div id="collapse<?php echo $key; ?>" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="heading<?php echo $key; ?>" aria-expanded="true">
                                <div class="panel-body">
                                    <ul class="list-group" style="margin-bottom: 0">
                                        <?php foreach( $result['children'] as $child ) : ?>
                                        <li class="list-group-item"><i class="fa fa-angle-right"></i> <a onclick="viewItem('<?php echo $type ?>', '<?php echo $child['slug'] ?>')"><?php echo $child['name'] ?></a></li>
                                        <?php endforeach; ?>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
			<?php endforeach; ?>
		</div>
	</div>
</div>
<?php endif; ?>
<script>
function viewItem(type, slug) {
    var Url = '<?=base_url()?>' + 'kiosk/view/' + type + '/' + slug;
    $.ajax({
        url: Url,
        dataType: 'html',
        beforeSend: function() {
        	$('#modal-media').find('.modal-body').append('<div class="modal-item-desc"></div>');
        	$('#accordion').hide();
        },
        complete: function() {
        	$('.modal-item-desc').remove();
        },
        success: function(html) {
            $('body').find('.modal-body').append(html);
        }
    });
}

function goBack() {
    $('#modal-media').modal('hide');
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
</style>