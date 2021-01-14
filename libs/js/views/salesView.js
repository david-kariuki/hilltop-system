function select_current_Sale() {
    console.log("checked");
    event.stopImmediatePropagation();
}

function open_selected_sale(viewName, loadingData = null, callBack = null) {
    var action = "openSales";
    var View = "sales";
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