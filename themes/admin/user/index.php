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
                            <i class="icon ion-ios-photos"></i><?php echo lang('text_all_users') ?>
                            </div>
                            <div class="tools">
                                <div class="btn-group">
                                    <a href="<?php echo site_url('admin/user/user/edit'); ?>" class="btn btn-primary" role="button"><i class="icon ion-compose"></i> <?php echo lang('btn_add') ?></a>
                                    <button type="button" class="btn btn-warning" onclick="confirm('<?php echo lang('notification_delete') ?>') ? $('#form').submit() : false;"><i class="icon ion-trash-a"></i> <span class="hidden-xs"><?php echo lang('btn_remove_selected') ?></span></button>
                                </div>
                            </div>
                        </div>
                        <div class="card-body table-responsive">
                            <?php echo form_open('admin/user/user/delete','id="form-user"'); ?>
                            <div class="table-responsive">
                                <table id="dataTables" class="table table-hover table-striped">
                                    <thead>
                                        <tr>
                                            <th class="text-center no-sort" style="width:50px">
                                                <div class="checkbox checkbox-styled">
                                                    <label>
                                                        <input type="checkbox" id="select_all" class="iCheck">
                                                    </label>
                                                </div>
                                            </th>
                                            <th><?php echo lang('tbl_title_user_name') ?></th>
                                            <th><?php echo lang('tbl_title_user_email') ?></th>
                                            <th><?php echo lang('tbl_title_user_level') ?></th>
                                            <th class="text-center no-sort" style="width: 100px;"><?php echo lang('tbl_title_action') ?></th>
                                        </tr>
                                    </thead>
                                    <tbody></tbody>
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
    var baseurl = '<?=base_url()?>';
    $(function() {
        $('#dataTables').dataTable({
            "fnCreatedRow": function( nRow, aData, iDataIndex ) {
                var id = $('td:eq(0)', nRow).text();

                select    =    '<div class="checkbox checkbox-styled">';
                select    +=        '<label>';
                select    +=            '<input type="checkbox" name="selected[]" value="' + id + '" class="iCheck">';
                select    +=            '<span></span>';
                select    +=        '</label>';
                select    +=    '</div>';

                button =  '<a href="'+baseurl+'admin/user/user/edit/'+id+'" class="btn btn-icon-toggle btn-default" data-toggle="tooltip" data-placement="top" data-original-title="Edit"><i class="icon ion-compose"></i></a>';
                button += '<a href="'+baseurl+'admin/user/user/delete/'+id+'" class="btn btn-icon-toggle btn-default" data-toggle="tooltip" data-placement="top" data-original-title="Delete"><i class="icon ion-trash-a"></i></a>';

                $('td:eq(0)', nRow).html(select);
                $('td:eq(0)', nRow).css('text-align','center');
                $('td:eq(4)', nRow).addClass('text-center');
                $('td:eq(4)', nRow).html(button);
            },

            "fnDrawCallback": function( oSettings ) {
                $.fn.bootstrapSwitch.defaults.size = 'mini';
                $('.switch-onoff').bootstrapSwitch();

                // iCheck
                var checkAll = $('input#select_all');
                var checkboxes = $('input.iCheck');

                $('input.iCheck').iCheck({
                    checkboxClass: 'icheckbox_square-green',
                    radioClass: 'iradio_square-green'
                });

                checkAll.on('ifChecked ifUnchecked', function(event) {
                    if (event.type == 'ifChecked') {
                        checkboxes.iCheck('check');
                    } else {
                        checkboxes.iCheck('uncheck');
                    }
                });

                checkboxes.on('ifChanged', function(event){
                    if(checkboxes.filter(':checked').length == checkboxes.length) {
                        checkAll.prop('checked', 'checked');
                    } else {
                        checkAll.removeProp('checked');
                    }
                    checkAll.iCheck('update');
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

            "bServerSide": true,
            "sAjaxSource": baseurl+"admin/user/user/get_datatables"
        });

        $('#dataTables').each(function(){
            var datatable = $(this);
        });
    });
});
</script>