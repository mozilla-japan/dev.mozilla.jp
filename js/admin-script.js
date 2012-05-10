jQuery(document).ready(function($){
        // clear date inputbox
        $('.clear_date').click(function(){$(this).prev().val(''); return false;});
        $('.clear_start_time').click(function(){$(this).prev().val(''); return false;});
        $('.clear_end_time').click(function(){$(this).prev().val(''); return false;});
        // datepicker
        if($.fn.datepicker){
            $('.datepicker').datetimepicker($.datepicker.regional['ja']);
        }
    });

