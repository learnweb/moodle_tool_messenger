define(['jquery', 'core/modal_factory', 'core/url', 'core/ajax'], function ($, modalfactory, url, ajax) {

    /**
     * Returns a function that will append a supplied form with a key: value pair
     * @param formid the forms id
     * @param name the key name
     * @param value the value
     * @returns {(function(): void)}
     */
    var append = function(formid, name, value) {
        return function() {
            $("<input />").attr("type", "hidden")
                .attr("name", name)
                .attr("value", value)
                .appendTo("#" + formid);
        };
    };

    /**
     * Shows the message that was sent with a tool_messenge instance.
     * the message id has to be supplied by the events current target through its messageid attribute.
     * @param event
     */
    var show_message = function (event) {
        event.preventDefault();
        var button = event.currentTarget;
        var id = button.getAttribute("messageid");
        var type = button.getAttribute('type');
        ajax.call([
            {methodname: 'tool_messenger_get_message', args: {'id': id, 'type': type}}
        ])[0].done(function (response) {
            var data = JSON.parse(response);
            modalfactory.create({
                type: modalfactory.types.ALERT,
                title: data.subject,
                body: data.message
            }).then(function (modal) {
                modal.show();
            });
        }).fail(function (ex) {
            window.console.log('fetch message failed: ');
            window.console.log(ex);
        });
    };

    var initialize_showmessage_buttons = function () {
        $('button.showmessagebutton').each(function(i, x) {
            $(x).on('click', show_message);
            return true; // Makes this a foreach loop.
        });
    };

    var init_select_all_button = function () {
        $('#id_select_all_recipients').click(function () {
            var vals = [];
            $('#id_recipients').children().each(
                function (i, option) {
                    vals.push(option.value);
                }
            );
            $('#id_recipients').val(vals);
        });
    };

    var init_predicitonlink = function () {

        $('#predictiontrigger').click(function (event) {
            event.preventDefault();
            var parent = $('#id_followup');
            var params;
            if (parent.length > 0) {
                params = {'parentid': parent.val()};
            } else {
                // Get roles.
                var roles = [];
                $('#id_recipients').children(':selected').each(function (i, x) {
                    roles.push(x.value);
                });
                // Get time.
                var unix;
                if ($('#id_knockout_enable').prop('checked')) {
                    var day = $('#id_knockout_date_day').val();
                    var month = $('#id_knockout_date_month').val();
                    var year = $('#id_knockout_date_year').val();
                    unix = Math.floor(new Date(year + "." + month + "." + day).getTime() / 1000);
                } else {
                    unix = -1;
                }
                // Build url.
                params = {'roles': roles.join(","), 'knockoutdate': unix};
            }
            ajax.call([
                {methodname: 'tool_messenger_predict_users', args: params}
            ])[0].done(function (response) {
                $('#predictionbox').text(response);
            }).fail(function (ex) {
                window.console.log('fetch predicted users failed: ');
                window.console.log(ex);
            });
        });
    };

    /**
     * This function removes all hidden followup and abort fields and attaches a listener to the abort
     * and followup buttons that will add them as followup:id or abort:id in the form on click.
     * This is done to enable the use of the abort and followup button while using mform->data which would be sanitized
     * otherwise. It also ensures that "abort" or "followup" will not be saved across instances of this form as to stop
     * accidental resending of this formdata.
     */
    var sanitize_form = function () {
        $('input[name=abort][type=hidden]').each(function (i, x) {
            x.remove();
        });
        $('input[name=abortpopup][type=hidden]').each(function (i, x) {
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
    };

    var init = function() {
        $(document).ready(function() {
            sanitize_form();
            initialize_showmessage_buttons();
            init_predicitonlink();
            init_select_all_button();
        });
    };

    return {
        init: init
    };
});