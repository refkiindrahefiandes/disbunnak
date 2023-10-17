$(function () {
    "use strict";

    // Popover & Tooltip
    $('[data-toggle="popover"]').popover();
    $('[data-toggle="tooltip"]').tooltip();

    // Card Tools
    var CardCollapse = function(e) {
        var card = $(e.currentTarget).closest('.card');
        card.find('.card-body').slideToggle("fast");
        // card.find('.card-footer').slideToggle("fast");
        card.toggleClass('card-collapsed');
    };

    var CardClose = function(e) {
        var card = $(e.currentTarget).closest('.card');
        card.remove();
    };

    $('.card-header .tools .btn-collapse').on('click', function (e) {
        e.preventDefault();
        CardCollapse(e);
    });
    $('.card-header .tools .btn-close').on('click', function (e) {
        e.preventDefault();
        CardClose(e);
    });

    $(document).ready(function() {
        $(".nicescroll").niceScroll({
            cursorcolor: "#cdd2d6",
            cursorwidth: "4px",
            cursorborder: "none"
        });

        // iCheck
        $('input.iCheck').iCheck({
            checkboxClass: 'icheckbox_square-green',
            radioClass: 'iradio_square-green'
        });

        // Switch on-off
        $.fn.bootstrapSwitch.defaults.size = 'mini';
        $('.switch-onoff').bootstrapSwitch();
        $('.switch-radio').bootstrapSwitch();

        // Select2
        $(".select2_single").select2({
            alignjustifyllowClear: true
        });

        $(".select2_group").select2({});

        // Datepicker range
        $('input.daterange').daterangepicker();

        // Datepicker single
        $('input.datesingle').daterangepicker({
            singleDatePicker: true,
            showDropdowns: true,
            locale: {
                format: 'YYYY/MM/DD'
            }
        });

        // Checkbox select all
        $('#select_all').on('change',function(){
            if($(this).attr('checked') == 'checked') {
                $('input[name*=\'selected\']').attr('checked','checked');
            } else {
                $('input[name*=\'selected\']').removeAttr('checked');
            }
        });
    });
});

// Ajax request
var ajaxRequest = function(Url, Data) {
    $.ajax({
        url: Url,
        dataType: 'html',
        beforeSend: function() {
            $('body').append('<div id="modal-media" class="modal fade"tabindex="-1" role="dialog" aria-labelledby="modal-media" aria-hidden="true"><div class="modal-dialog modal-lg"><div class="modal-content"><div class="modal-header"><button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button><h4 class="modal-title">Media Manager</h4></div><div class="modal-body"><div class="card tabs-h-left transparent media-manager" style="margin: 0"></div></div></div></div></div>');
            $('#modal-media').modal('show');
            $('#modal-media').find('.tabs-h-left').append('<div class="modal-wait"><i class="icon ion-load-a ion-spin"></i></div>');
        },
        complete: function() {
            $('#button-media').prop('disabled', false);
        },
        success: function(html) {
            $('.modal-wait').remove();
            $('body').find('.media-manager').append(html);
        }
    });
};
