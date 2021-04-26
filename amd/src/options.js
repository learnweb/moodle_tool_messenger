define(['jquery'], function ($) {

    var append = function(form_id, name, value) {
        return function() {
            $("<input />").attr("type", "hidden")
                .attr("name", name)
                .attr("value", value)
                .appendTo("#" + form_id);
        };
    };

    var init = function() {
        $(document).ready(function() {
            $('input[name=abort][type=hidden]').each(function (i, x) {
                x.remove();
            });
            $('input[name=followup][type=hidden]').each(function (i, x) {
                x.remove();
            });
            $('td > input').each(function (i, input) {
                var button = $(input);
                var [name, value] = input["id"].split('_');
                button.on('click', append($('form.mform')[0].id, name, value));
                return true;
            });
        });
    };

    return {
        init: init
    };
});