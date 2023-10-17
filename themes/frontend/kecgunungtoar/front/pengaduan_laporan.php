<section class="banner_area">
    <div class="container">
        <div class="pull-left">
            <h3>Laporan Pengaduan</h3>
        </div>
        <div class="pull-right">
            <a href="<?php echo site_url('', TRUE); ?>">Beranda</a>
            <a href="<?php echo site_url('pengaduan/laporan'); ?>">Laporan Pengaduan</a>
        </div>
    </div>
</section>

<section class="main_blog_area single_blog_details">
    <div class="container">
        <div class="row main_blog_inner">
            <div class="col-md-12">
                <?php echo validation_errors('<div class="alert alert-callout alert-warning" role="alert">', '</div>'); ?>

				<?php if ($laporan) : ?>

                <div class="table-responsive">
                    <table class="table table-striped table-hover" id="dataTable">
                        <thead>
                            <tr>
                                <th class="text-center no-sort" style="width: 25px;">No</th>
                                <th>Jenis Laporan</th>
                                <th class="text-center no-sort">Pesan</th>
                                <th class="text-center" style="width: 130px;">Tanggal dibuat</th>
                                <th class="text-center" style="width: 130px;">Status</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>

				<?php else : ?>
					<h2>Laporan Pengaduan Masih Kosong</h2>
				<?php endif; ?>
            </div>
        </div>
    </div>
    <!-- Modal -->
<div class="modal fade" id="balasanModal" tabindex="-1" role="dialog" aria-labelledby="balasanModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h4 class="modal-title" id="balasanModalLabel">Balasan</h4>
        </button>
      </div>
      <div class="modal-body" id="balasanForm">
        
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <!-- <button type="button" class="btn btn-primary" id="BtnSave" data-id="">Save changes</button> -->
      </div>
    </div>
  </div>
</div>
</section>

<script type='text/javascript'>
var baseurl = '<?=base_url()?>';

$(document).ready(function() {
    $(function() {
        $('#dataTable').dataTable({
            "fnCreatedRow": function( nRow, aData, iDataIndexFull ) {
                var index = iDataIndexFull +1;
                var id = aData['0'];
                var filename = aData['2'];

                // button = '<a target="_blank" href="'+baseurl+'download/get/'+id+'" class="btn btn-default ink-reaction btn-primary" data-toggle="tooltip" data-placement="top" data-original-title="Download"><i class="fa fa-cloud-download"></i> Download</a>';

                $('td:eq(0)',nRow).html(index);
                $('td:eq(0)', nRow).addClass('text-center');
                $('td:eq(2)', nRow).addClass('text-left');
                $('td:eq(3)', nRow).addClass('text-center');
                $('td:eq(4)', nRow).addClass('text-center');
                // $('td:eq(3)', nRow).html(button);
            },

            "order": [],
            "columnDefs": [ { "targets": 'no-sort', "orderable": false } ],
            "bAutoWidth": false,
            "bProcessing": true,
            "oLanguage": {
                "sProcessing": "<i class='fa fa-circle-o-notch fa-spin'></i>"
            },

            "bServerSide": true,
            "sAjaxSource": baseurl + "pengaduan/fetch_data/"
        });

        $('#dataTable').each(function(){
            var datatable = $(this);
        });

        var modal = $('#balasanModal')
        var konten = $('#balasanForm');

        $('body').on('click', '.reply-laporan', function(){
            let id = $(this).data('id')
            console.log(id)
            // btnSave.data('id', id)
            $.ajax({
                url: baseurl + "pengaduan/balasan/"+id,
                dataType: 'json',
                success: function(json) {
                    konten.append(json.data)
                    modal.modal('show')
                }
            });

        })

        modal.on('hidden.bs.modal', function (e) {
            konten.empty()
        })

    });
});

</script>
<style>
    .table > thead > tr > th, .table > tbody > tr > th, .table > tfoot > tr > th, .table > thead > tr > td, .table > tbody > tr > td, .table > tfoot > tr > td {
        padding: 25px 10px;
    }
</style>

