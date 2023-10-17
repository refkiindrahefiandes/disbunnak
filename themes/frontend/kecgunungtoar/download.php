<section class="banner_area">
    <div class="container">
        <div class="pull-left">
            <h3><?php echo $download_category['name'] ?></h3>
        </div>
        <div class="pull-right">
            <a href="<?php echo site_url('', TRUE); ?>">Beranda</a>
            <a href="<?php echo site_url('download/' . $download_category['slug']); ?>"><?php echo $download_category['name']; ?></a>
        </div>
    </div>
</section>

<section class="main_blog_area single_blog_details">
    <div class="container">
        <div class="row main_blog_inner">
            <div class="col-md-9">
                <?php echo validation_errors('<div class="alert alert-callout alert-warning" role="alert">', '</div>'); ?>

				<?php if($download_category['download_category_id']) : ?>

                <div class="table-responsive">
                    <table class="table table-striped table-hover" id="dataTable">
                        <thead>
                            <tr>
                                <th class="text-center no-sort" style="width: 25px;">No</th>
                                <th>Nama Dokumen</th>
                                <th class="text-center no-sort" style="width: 130px;">Download</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>

				<?php else : ?>
					<?php $this->load->view('frontend/'. $active_theme .'/404.php'); ?>
				<?php endif; ?>
            </div>
            <div class="col-md-3">
				<!-- SIDEBAR -->
				<?php $this->load->view('frontend/'. $active_theme .'/right-sidebar.php'); ?>
            </div>
        </div>
    </div>
</section>

<script type='text/javascript'>
var baseurl = '<?=base_url()?>';

$(document).ready(function() {
    var downloadCategortySlug = '<?=$download_category['download_category_id']?>';
    $(function() {
        $('#dataTable').dataTable({
            "fnCreatedRow": function( nRow, aData, iDataIndexFull ) {
                var index = iDataIndexFull +1;
                var id = aData['0'];
                var filename = aData['2'];

                button = '<a target="_blank" href="'+baseurl+'download/get/'+id+'" class="btn btn-default ink-reaction btn-primary" data-toggle="tooltip" data-placement="top" data-original-title="Download"><i class="fa fa-cloud-download"></i> Download</a>';

                $('td:eq(0)',nRow).html(index);
                $('td:eq(0)', nRow).addClass('text-center');
                $('td:eq(2)', nRow).addClass('text-center');
                $('td:eq(2)', nRow).html(button);
            },

            "order": [],
            "columnDefs": [ { "targets": 'no-sort', "orderable": false } ],
            "bAutoWidth": false,
            "bProcessing": true,
            "oLanguage": {
                "sProcessing": "<i class='fa fa-circle-o-notch fa-spin'></i>"
            },

            "bServerSide": true,
            "sAjaxSource": baseurl + "download/fetch_data/" + downloadCategortySlug
        });

        $('#dataTable').each(function(){
            var datatable = $(this);
        });
    });
});

</script>
<style>
    .table > thead > tr > th, .table > tbody > tr > th, .table > tfoot > tr > th, .table > thead > tr > td, .table > tbody > tr > td, .table > tfoot > tr > td {
        padding: 25px 10px;
    }
</style>

