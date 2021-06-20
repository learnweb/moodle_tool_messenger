define(['jquery'], function ($) {

    var set_correct_parent_date = function(timestamp) {
        var date = new Date(timestamp * 1000);
        $('#id_knockout_date_day').val(date.getDate());
        $('#id_knockout_date_month').val(date.getMonth() + 1);
        $('#id_knockout_date_year').val(date.getFullYear());
    };

    return {
        set_correct_parent_date: set_correct_parent_date
    };

});