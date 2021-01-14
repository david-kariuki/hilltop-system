function select_current_transaction() {
    console.log("checked");
    event.stopImmediatePropagation();
}

function open_selected_transaction(viewName, loadingData = null, callBack = null) {
    var action = "openTransaction";
    var View = "transactions";
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