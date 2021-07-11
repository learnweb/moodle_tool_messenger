define(['jquery', 'core/modal_factory', 'core/url'], function ($, modalfactory, url) {

    var append = function(formid, name, value) {
        return function() {
            $("<input />").attr("type", "hidden")
                .attr("name", name)
                .attr("value", value)
                .appendTo("#" + formid);
        };
    };

    var show_message = function (event) {
        event.preventDefault();
        var button = event.currentTarget;
        var id = button.getAttribute("messageid");
        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function () {
            if (this.readyState === 4 && this.status === 200) {
                var data = JSON.parse(this.responseText);
                modalfactory.create({
                    type: modalfactory.types.ALERT,
                    title: data.subject,
                    body: data.message
                }).then(function (modal) {
                    modal.show();
                });
            }
        };
        var s = url.relativeUrl("/admin/tool/messenger/get_message_ajax.php", {'id': id}, true);
        xhttp.open("GET", s);
        xhttp.send();
    };

    var initialize_showmessage_buttons = function () {
        $('button.showmessagebutton').each(function(i, x) {
            $(x).on('click', show_message);
            return true;
        });
    };

    var init_predicitonlink = function () {
        $('#predictiontrigger').click(function (event) {
            event.preventDefault();
            var s;
            var parent = $('#id_followup');
            if (parent.length > 0) {
                s = url.relativeUrl("/admin/tool/messenger/predict_affected_users_ajax.php",
                    {'parentid': parent.val()}, true);
            } else {
                var roles = [];
                $('#id_recipients').children(':selected').each(function (i, x) {
                    roles.push(x.value);
                });
                var unix;
                if ($('#id_knockout_enable').prop('checked')) {
                    var day = $('#id_knockout_date_day').val();
                    var month = $('#id_knockout_date_month').val();
                    var year = $('#id_knockout_date_year').val();
                    unix = Math.floor(new Date(year + "." + month + "." + day).getTime() / 1000);
                } else {
                    unix = -1;
                }
                s = url.relativeUrl("/admin/tool/messenger/predict_affected_users_ajax.php",
                    {'roles': roles.join(","), 'knockoutdate': unix}, true);
            }
            var xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function () {
                if (this.readyState === 4 && this.status === 200) {
                    $('#predictionbox').text(this.responseText);
                }
            };
            xhttp.open("GET", s);
            xhttp.send();
        });
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
            initialize_showmessage_buttons();
            init_predicitonlink();
        });
    };

    return {
        init: init
    };
});