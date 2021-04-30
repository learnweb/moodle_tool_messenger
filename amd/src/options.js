define(['jquery'], function ($) {

    var append = function(form_id, name, value) {
        return function() {
            $("<input />").attr("type", "hidden")
                .attr("name", name)
                .attr("value", value)
                .appendTo("#" + form_id);
        };
    };

    var atto_html_mode = function () {
        let observer = new MutationObserver((mutations) => {
            mutations.forEach((mutation) => {
                if (!mutation.addedNodes) {
                    return;
                }

                for (let i = 0; i < mutation.addedNodes.length; i++) {
                    let node = mutation.addedNodes[i];
                    if (node && node.classList && node.classList.contains && node.classList.contains('atto_html_button')) {
                        node.click();
                        observer.disconnect();
                    }
                }
            });
        });

        observer.observe(document.body, {
            childList: true,
            subtree: true,
            attributes: false,
            characterData: false
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
            atto_html_mode();
        });
    };

    return {
        init: init
    };
});