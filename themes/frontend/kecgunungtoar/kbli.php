<section class="banner_area">
    <div class="container">
        <div class="pull-left">
            <h3>Data KBLI 2017</h3>
        </div>
        <div class="pull-right">
            <a href="<?php echo site_url('', TRUE); ?>">Beranda</a>
            <a href="<?php echo site_url('kbli') ?>">Data KBLI</a>
        </div>
    </div>
</section>

<section class="main_blog_area single_blog_details">
    <div class="container">
        <div class="row main_blog_inner">
            <div class="col-md-9">
                <div class="table-responsive">
                    <table class="table table-striped table-hover" id="dataTable">
                        <thead>
                            <tr>
                                <th class="text-center" style="width: 100px;">Kode KBLI</th>
                                <th>Judul</th>
                                <th>Keterangan</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
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
    $(function() {
        $('#dataTable').dataTable({
            "fnCreatedRow": function( nRow, aData, iDataIndexFull ) {
                $('td:eq(0)', nRow).addClass('text-center');
            },

            "order": [[ 0, "asc" ]],
            "columnDefs": [ { "targets": 'no-sort', "orderable": false } ],
            "bAutoWidth": false,
            "bProcessing": true,
            "language": {
                "sProcessing": "<i class='icon ion-load-a ion-spin'></i>",
                "search": '<i class="icon ion-search"></i>',
                "searchPlaceholder": "Cari Judul KBLI",
                "paginate": {
                    "previous": '<i class="icon ion-ios-arrow-left"></i>',
                    "next": '<i class="icon ion-ios-arrow-right"></i>'
                }
            },

            "bServerSide": true,
            "sAjaxSource": baseurl + "kbli/fetch_data/"
        });

        $('#dataTable').each(function(){
            var datatable = $(this);
        });
    });
});

</script>

