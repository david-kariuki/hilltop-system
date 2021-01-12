function select_current_moderator() {
    console.log("checked");
    event.stopImmediatePropagation();
}

function open_selected_moderator(viewName, loadingData = null, callBack = null) {
    var action = "openModerator";
    var View = "moderators";
    var form = viewName;
    var token = 1;
    var data = viewName;
    var id = null;

    var renderedElement = $(".contentArea_panel");

    formViewHandler(action, View, form, data, callback, id);

    function callback(msg) {
        renderedElement.html(msg);
    }
}