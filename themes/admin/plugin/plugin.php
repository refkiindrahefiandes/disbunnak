<!-- CONTENT -->
<div id="main-content">
    <div id="content">
        <div class="content-wrap scroll-view">
            <!-- <section class="content-header"></section> -->
            <section class="content-body">
                <?php if (isset($this->session->userdata['error'])) {echo '<div class="alert alert-warning alert-dismissable" role="alert">' . $this->session->userdata['error'] . '<button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button></div>'; } ?>
                <?php if (isset($this->session->userdata['success'])) {echo '<div class="alert alert-success alert-dismissable" role="alert">' . $this->session->userdata['success'] . '<button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button></div>'; } ?>

                <div class="row">
                    <div class="col-md-12">
                    <div class="card card-line">
                        <div class="card-header">
                            <div class="card-header-title">
                                <i class="icon ion-tshirt"></i><?php echo lang('text_all_plugin') ?>
                            </div>
                            <div class="tools">
                                <a href="<?php echo site_url('admin/plugin/add'); ?>" class="btn btn-primary btn-icon-toggle" role="button"><i class="icon ion-plus"></i></a>
                            </div>
                        </div>
                        <div class="card-body table-responsive">
                            <?php echo form_open('','id="form"'); ?>
                            <div class="table-responsive">
                                <table id="dataTables" class="table">
                                    <thead>
                                        <tr>
                                            <th><?php echo lang('tbl_title_name') ?></th>
                                            <th>Deskripsi</th>
                                            <th class="text-center"><?php echo lang('tbl_title_status') ?></th>
                                            <th class="text-center no-sort"><?php echo lang('tbl_title_action') ?></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if(count($plugins)): foreach($plugins as $key => $plugin): ?>
                                        <tr>
                                            <td><strong><?php echo $plugin['name'] ?></strong></td>
                                            <td style="max-width: 350px"><?php echo $plugin['desc'] ?></td>
                                            <td class="text-center">
                                                <div class="checkbox">
                                                    <label>
                                                        <input type="checkbox" name="status" class="switch-onoff" value="<?php echo $plugin['action']['status']; ?>" <?php if( $plugin['action']['status'] == 1){ ?> checked <?php } ?> data="<?php echo $plugin['code']; ?>" data-widget="<?php echo $plugin['data_widget']; ?>">
                                                    </label>
                                                </div>
                                            </td>
                                            <td class="text-center">
                                                <?php if (isset($plugin['action']['href_edit'])) { ?>
                                                <a href="<?php echo $plugin['action']['href_edit']; ?>" class="btn btn-default btn-icon-toggle" data-toggle="tooltip" data-placement="top" data-original-title="Manage Plugin"><i class="icon ion-wrench"></i></a>
                                                <?php } else { ?>
                                                <a class="btn btn-default btn-icon-toggle" data-toggle="tooltip" data-placement="top" data-original-title="Manage Plugin" disabled><i class="icon ion-wrench"></i></a>
                                                <?php } ?>
                                                <a href="<?php echo $plugin['action']['href_delete']; ?>" class="btn btn-default btn-icon-toggle" data-toggle="tooltip" data-placement="top" data-original-title="Delete Plugin"><i class="icon ion-trash-a"></i></a>
                                            </td>
                                        </tr>
                                        <?php endforeach; ?>
                                        <?php endif; ?>
                                    </tbody>
                                </table>
                            </div>
                            <?php echo form_close();?>
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
    // Datatable
    $('#dataTables').dataTable({
        "fnDrawCallback": function( oSettings ) {
            $.fn.bootstrapSwitch.defaults.size = 'mini';
            $('.switch-onoff').bootstrapSwitch();

            $('input.iCheck').iCheck({
                checkboxClass: 'icheckbox_square-green',
                radioClass: 'iradio_square-green'
            });
        },
        "order": [],
        "columnDefs": [ { "targets": 'no-sort', "orderable": false } ],
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
    });

    $('input[name="status"]').on('switchChange.bootstrapSwitch', function(event, state) {
        $.ajax({
            url: "<?php echo base_url('admin/plugin/status/'); ?>" + $(this).attr('data') + '/' + state + '/' + $(this).attr('data-widget') ,
            dataType: 'json',
            success: function(json) {
                if (json['error']) {
                    toastr.options.closeButton = true;
                    toastr.options.hideDuration = 333;
                    toastr["error"](json['error']);
                }
                if (json['success']) {
                    toastr.options.closeButton = true;
                    toastr.options.hideDuration = 333;
                    toastr["success"](json['success']);
                }
            },
            error: function() {
                toastr.options.closeButton = true;
                toastr.options.hideDuration = 333;
                toastr["error"]("Gagal!");
            }
        });
    });
});
</script>