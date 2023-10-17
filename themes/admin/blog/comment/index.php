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
                            <i class="icon ion-ios-paper"></i><?php echo lang('text_all_comments') ?>
                            </div>
                            <div class="tools">
                                <div class="btn-group">
                                    <button type="button" class="btn btn-warning" onclick="confirm('<?php echo lang('notification_delete') ?>') ? $('#form').submit() : false;"><i class="icon ion-trash-a"></i> <span class="hidden-xs"><?php echo lang('btn_remove_selected') ?></span></button>
                                </div>
                            </div>
                        </div>
                        <div class="card-body table-responsive">
                            <?php echo form_open('admin/blog/comment/delete','id="form"'); ?>
                            <div class="table-responsive">
                                <table class="table table-striped table-hover" id="dataTables">
                                    <thead>
                                        <tr>
                                            <th class="text-center no-sort" style="width:50px">
                                                <div class="checkbox checkbox-styled">
                                                    <label>
                                                        <input type="checkbox" id="select_all" class="iCheck">
                                                    </label>
                                                </div>
                                            </th>
                                            <th class="text-center"><?php echo lang('tbl_title_comment_author') ?></th>
                                            <th class="text-center" style="width:30%;"><?php echo lang('tbl_title_comment') ?></th>
                                            <th><?php echo lang('tbl_title_comment_for') ?></th>
                                            <th class="text-center"><?php echo lang('tbl_title_status') ?></th>
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
                var get_status = $('td:eq(4)', nRow).text();

                select    =    '<div class="checkbox checkbox-styled">';
                select    +=        '<label>';
                select    +=            '<input type="checkbox" name="selected[]" value="' + id + '" class="iCheck">';
                select    +=            '<span></span>';
                select    +=        '</label>';
                select    +=    '</div>';

                if (get_status == '1') {
                    active = 'checked';
                } else{
                    active = '';
                };

                status    =     '<div class="checkbox">';
                status    +=        '<label>';
                status    +=            '<input type="checkbox" name="status" class="switch-onoff" value="'+get_status+'" data="'+id+'" '+active+'>' ;
                status    +=        '</label>';
                status    +=    '</div>';


                button =  '<a href="'+baseurl+'admin/blog/comment/edit/'+id+'" class="btn btn-icon-toggle btn-default" data-toggle="tooltip" data-placement="top" data-original-title="Edit"><i class="icon ion-compose"></i></a>';
                button += '<a href="'+baseurl+'admin/blog/comment/delete/'+id+'" class="btn btn-icon-toggle btn-default" data-toggle="tooltip" data-placement="top" data-original-title="Delete"><i class="icon ion-trash-a"></i></a>';

                $('td:eq(0)', nRow).html(select);
                $('td:eq(0)', nRow).addClass('text-center');
                $('td:eq(1)', nRow).addClass('text-center');
                $('td:eq(4)', nRow).html(status);
                $('td:eq(5)', nRow).addClass('text-center');
                $('td:eq(5)', nRow).html(button);
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

                $('input[name="status"]').on('switchChange.bootstrapSwitch', function(event, state) {
                    $.ajax({
                        url: baseurl + 'admin/blog/comment/status/' + $(this).attr('data') + '/' + state ,
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
                            toastr["error"]("<?php echo lang('status_update_failed') ?>");
                        }
                    });
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
            "sAjaxSource": baseurl+"admin/blog/comment/get_datatables"
        });

        $('#dataTables').each(function(){
            var datatable = $(this);
        });
    });
});
</script>