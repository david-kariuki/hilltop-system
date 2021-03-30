function renderMainContentView(viewName, loadingData = null, callback1) {
    var action = "renderMainView";
    var handler = "router";
    var token = 1;
    var data = viewName;
    var id = null;

    mainViewHandler(action, handler, data, callback, id);

    function callback(msg) {
        $(".contentArea_panel").html(msg);
        reset_sale();
        clear_right_side_panel();
        if (callback1 != undefined) {
            callback1();
        } else {

        }
    }
}

function close_system_elemental() {
    var element = $(".system_elemental");
    element.fadeOut();
}

function render_dropdown_select(button) {
    $(".icons_select_dropdown").toggle('slow');
}

function logUserOut() {
    window.location.replace("http://" + window.location.hostname + "/logOut.php");
}

function close_right_panel() {
    var right_panel = $(".right_side_panel");

    right_panel.css({
        "right": "-400px"
    });
}

function open_right_panel() {
    var right_panel = $(".right_side_panel");

    right_panel.css({
        "right": "0px"
    });
}

function next_page(elem) {
    var parent = elem.parent().parent();

    var current = parent.find(".active_page");
    var next = current.next();
    var next2 = next.next();

    if (next.find("p").text() != "Next") {
        current.removeClass('active_page');
        next.addClass('active_page');
        return true;
    } else {
        return false;
    }
}

function previous_page(elem) {
    var parent = elem.parent().parent();

    var current = parent.find(".active_page");
    var prev = current.prev();

    if (prev.find("p").text() != "Prev") {
        current.removeClass('active_page');
        prev.addClass('active_page');
        return true;
    } else {
        return false;
    }
}

function change_page(page, elem) {
    var parent = elem.parent().parent();

    var buttons = parent.find("li");

    $.each(buttons, function(key, value) {
        var txt = $(value).text();

        if (txt == page) {
            $(value).addClass('active_page');
        } else {
            $(value).removeClass('active_page');
        }
    });
    return true;

}

function check_all() {
    event.preventDefault()
    var elem = $(event.currentTarget);

    var is_checkbox = elem.is(':checkbox');

    if (!is_checkbox) {
        return;
    } else {
        var is_checked = elem.is(':checked');

        if (is_checked) {
            //check all check boxes
            var table = elem.parent().parent().parent().parent().parent();

            if (table.is("table")) {
                var checkboxes = table.find("tbody>tr>td>div>input");

                $.each(checkboxes, function(key, value) {
                    $(value).prop('checked', true);
                });
            }
        } else {
            //un check all check boxes
            var table = elem.parent().parent().parent().parent().parent();

            if (table.is("table")) {
                var checkboxes = table.find("tbody>tr>td>div>input");

                $.each(checkboxes, function(key, value) {
                    $(value).prop('checked', false);
                });
            }
        }

    }
}

function clear_right_side_panel() {
    var elem = $(".transaction_sales ul");
    elem.html(" ");
}