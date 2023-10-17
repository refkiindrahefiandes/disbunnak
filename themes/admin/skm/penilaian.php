<!-- CONTENT -->
<div id="main-content">
    <div id="content">
        <div class="content-wrap scroll-view">
            <!-- <section class="content-header"></section> -->
            <section class="content-body">
                <?php if (isset($this->session->userdata['error'])) {
                    echo '<div class="alert alert-warning alert-dismissable" role="alert">' . $this->session->userdata['error'] . '<button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button></div>';
                } ?>
                <?php if (isset($this->session->userdata['success'])) {
                    echo '<div class="alert alert-success alert-dismissable" role="alert">' . $this->session->userdata['success'] . '<button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button></div>';
                } ?>

                <div class="row">
                    <div class="col-md-12">
                        <div class="card card-line">
                            <div class="card-header">
                                <div class="card-header-title">
                                    <i class="icon ion-ios-photos"></i>Data Responden - <?php echo long_date(' M Y', date('Y-m-d')) ?>
                                </div>
                            </div>
                            <div class="card-body table-responsive form">
                                <div class="row">
                                    <div class="col-md-12">
                                        <legend>Jenis Kelamin</legend>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="card card-sm" style="margin-bottom: 10px;">
                                            <div class="card-header brand-default">
                                                <div class="card-header-title">
                                                    <i class="icon ion-man"></i>Laki-laki
                                                </div>
                                                <div class="tools"><span class="text-bold"><?php echo $jenis_kelamin['laki_laki'] ?? '0' ?></span></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="card card-sm" style="margin-bottom: 10px;">
                                            <div class="card-header brand-default">
                                                <div class="card-header-title">
                                                    <i class="icon ion-woman"></i>Perempuan
                                                </div>
                                                <div class="tools"><span class="text-bold"><?php echo $jenis_kelamin['perempuan'] ?? '0' ?></span></div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <legend>Tingkat Pendidikan</legend>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="card card-sm" style="margin-bottom: 10px;">
                                            <div class="card-header brand-default">
                                                <div class="card-header-title">
                                                    <i class="icon ion-university"></i>SD
                                                </div>
                                                <div class="tools"><span class="text-bold"><?php echo $pendidikan['sd'] ?? '0' ?></span></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="card card-sm" style="margin-bottom: 10px;">
                                            <div class="card-header brand-default">
                                                <div class="card-header-title">
                                                    <i class="icon ion-university"></i>SMP
                                                </div>
                                                <div class="tools"><span class="text-bold"><?php echo $pendidikan['smp'] ?? '0' ?></span></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="card card-sm" style="margin-bottom: 10px;">
                                            <div class="card-header brand-default">
                                                <div class="card-header-title">
                                                    <i class="icon ion-university"></i>SMA
                                                </div>
                                                <div class="tools"><span class="text-bold"><?php echo $pendidikan['sma'] ?? '0' ?></span></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="card card-sm" style="margin-bottom: 10px;">
                                            <div class="card-header brand-default">
                                                <div class="card-header-title">
                                                    <i class="icon ion-university"></i>D1-D2-D3
                                                </div>
                                                <div class="tools"><span class="text-bold"><?php echo $pendidikan['di_d2_d3'] ?? '0' ?></span></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="card card-sm" style="margin-bottom: 10px;">
                                            <div class="card-header brand-default">
                                                <div class="card-header-title">
                                                    <i class="icon ion-university"></i>S1
                                                </div>
                                                <div class="tools"><span class="text-bold"><?php echo $pendidikan['s1'] ?? '0' ?></span></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="card card-sm" style="margin-bottom: 10px;">
                                            <div class="card-header brand-default">
                                                <div class="card-header-title">
                                                    <i class="icon ion-university"></i>S2 Ke atas
                                                </div>
                                                <div class="tools"><span class="text-bold"><?php echo $pendidikan['s2_keatas'] ?? '0' ?></span></div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <legend>Pekerjaan</legend>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="card card-sm" style="margin-bottom: 10px;">
                                            <div class="card-header brand-default">
                                                <div class="card-header-title">
                                                    <i class="icon ion-person-stalker"></i>PNS
                                                </div>
                                                <div class="tools"><span class="text-bold"><?php echo $pekerjaan['pns'] ?? '0' ?></span></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="card card-sm" style="margin-bottom: 10px;">
                                            <div class="card-header brand-default">
                                                <div class="card-header-title">
                                                    <i class="icon ion-person-stalker"></i>TNI/ Polri
                                                </div>
                                                <div class="tools"><span class="text-bold"><?php echo $pekerjaan['tni_polri'] ?? '0' ?></span></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="card card-sm" style="margin-bottom: 10px;">
                                            <div class="card-header brand-default">
                                                <div class="card-header-title">
                                                    <i class="icon ion-person-stalker"></i>Swasta
                                                </div>
                                                <div class="tools"><span class="text-bold"><?php echo $pekerjaan['swasta'] ?? '0' ?></span></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="card card-sm" style="margin-bottom: 10px;">
                                            <div class="card-header brand-default">
                                                <div class="card-header-title">
                                                    <i class="icon ion-person-stalker"></i>Lainnya
                                                </div>
                                                <div class="tools"><span class="text-bold"><?php echo $pekerjaan['lainnya'] ?? '0' ?></span></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card card-line">
                            <div class="card-header">
                                <div class="card-header-title">
                                    <i class="icon ion-ios-photos"></i>Data Penilaian - <?php echo long_date(' M Y', date('Y-m-d')) ?>
                                </div>
                            </div>
                            <div class="card-body table-responsive">
                                <div class="table-responsive">
                                    <table class="table table-striped table-hover" id="dataTables">
                                        <thead>
                                            <tr>
                                                <th class="text-center no-sort" style="width:50px">No.</th>
                                                <th>Usia</th>
                                                <th class="text-center">Jenis Kelamin</th>
                                                <th class="text-center">Tingkat Pendidikan</th>
                                                <th class="text-center">Pekerjaan</th>
                                                <th class="text-center">Saran</th>
                                                <th class="text-center no-sort" style="width: 100px;"><?php echo lang('tbl_title_action') ?></th>
                                            </tr>
                                        </thead>
                                        <tbody></tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <div class="card card-line">
                            <div class="card-header">
                                <div class="card-header-title">
                                    <i class="icon ion-ios-photos"></i>Rekap Penilaian - <?php echo long_date(' M Y', date('Y-m-d')) ?>
                                </div>

                            </div>
                            <div class="card-body table-responsive form">
                                <div class="row">
                                    <div class="table-responsive">
                                        <table class="table table-striped table-hover">
                                            <thead>
                                                <tr>
                                                    <th class="text-center no-sort" style="width:50px">No.</th>
                                                    <th>Judul</th>
                                                    <th class="text-center">Keterangan</th>
                                                    <th class="text-center">Total Nilai</th>
                                                    <th class="text-center">Rata-Rata</th>
                                                    <th class="text-center">Jumlah Responden</th>
                                                    <th class="text-center">Jumlah Pertanyaan</th>
                                                </tr>
                                            </thead>
                                            <?php if (isset($ikm)) : ?>
                                                <tbody>
                                                    <?php $no = 1;
                                                        foreach ($ikm as $key => $val) : ?>
                                                        <tr>
                                                            <td class="text-center"><?php echo $no ?></td>
                                                            <td><?php echo $val['judul'] ?></td>
                                                            <td><?php echo $val['keterangan'] ?></td>
                                                            <td class="text-center"><?php echo (int) $val['total_nilai'] ?></td>
                                                            <td class="text-center"><?php echo (int) $val['nilai'] ?></td>
                                                            <td class="text-center"><?php echo (int) $val['jumlah_responden'] ?></td>
                                                            <td class="text-center"><?php echo (int) $val['jumlah_pertanyaan'] ?></td>
                                                        </tr>

                                                    <?php $no++;
                                                        endforeach; ?>
                                                </tbody>

                                                <tfoot>
                                                    <tr>
                                                        <th colspan="4">Indeks Kepuasan Masyarakat (IKM)</th>
                                                        <th class="text-center"><?php echo get_nilai_likert((int) (array_sum(array_column($ikm, 'nilai')) / count($ikm))) ?></th>
                                                        <th colspan="2"></th>
                                                    </tr>
                                                </tfoot>
                                            <?php endif; ?>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function() {
        var baseurl = '<?= base_url() ?>';
        $(function() {
            $('#dataTables').dataTable({
                "fnCreatedRow": function(nRow, aData, iDataIndex) {
                    var id = $('td:eq(6)', nRow).text();

                    // button =  '<a href="'+baseurl+'admin/skm/edit/'+id+'" class="btn btn-icon-toggle btn-default" data-toggle="tooltip" data-placement="top" data-original-title="Edit"><i class="icon ion-compose"></i></a>';
                    button = '<a href="' + baseurl + 'admin/skm/delete_penilaian/' + id + '" class="btn btn-icon-toggle btn-default" data-toggle="tooltip" data-placement="top" data-original-title="Delete"><i class="icon ion-trash-a"></i></a>';

                    $('td:eq(0)', nRow).addClass('text-center');
                    $('td:eq(1)', nRow).addClass('text-center');
                    $('td:eq(2)', nRow).addClass('text-center');
                    $('td:eq(3)', nRow).addClass('text-center');
                    $('td:eq(4)', nRow).addClass('text-center');
                    $('td:eq(6)', nRow).addClass('text-center');
                    $('td:eq(6)', nRow).html(button);
                },

                "fnDrawCallback": function(oSettings) {

                },

                "order": [],
                "columnDefs": [{
                    "targets": 'no-sort',
                    "orderable": false
                }],
                "bAutoWidth": false,
                "bProcessing": true,
                "language": {
                    "sProcessing": "<i class='icon ion-load-a ion-spin'></i>",
                    "search": '<i class="icon ion-search"></i>',
                    "paginate": {
                        "previous": '<i class="icon ion-ios-arrow-left"></i>',
                        "next": '<i class="icon ion-ios-arrow-right"></i>'
                    }
                },

                "bServerSide": true,
                "sAjaxSource": baseurl + "admin/skm/get_datatables_penilaian"
            });

            $('#dataTables').each(function() {
                var datatable = $(this);
            });
        });
    });
</script>