define(['jquery', 'core/modal_factory', 'core/url', 'core/ajax', 'core/modal_events'], function ($, modalfactory, url, ajax, modalevents) {

    var get_next_modal = function (data, index) {
        if (data.length <= index) {
            return;
        }
        var localdata = data[index];
        modalfactory.create({
            type: modalfactory.types.ALERT,
            title: localdata.header,
            body: localdata.message
        }).then(function (modal) {
            var root = modal.getRoot();
            root.on(modalevents.cancel, function () {
                ajax.call([
                    {methodname: 'tool_messenger_set_lastpopupid_for_user', args: {lastpopupid: localdata.id}}
                ]);
                get_next_modal(data, index + 1);
            });
            modal.show();
        });
    };

    var init = function () {
        var params = {};
        ajax.call([
            {methodname: 'tool_messenger_get_popups_for_user', args: params}
        ])[0].done(function (response) {
            var data = JSON.parse(response);
            get_next_modal(data, 0);
        }).fail(function (ex) {
            window.console.log('Getting popups for this user failed: ');
            window.console.log(ex);
        });
    };

    return {
        init: init
    };
});
