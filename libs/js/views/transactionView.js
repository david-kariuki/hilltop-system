function select_current_transaction() {
    console.log("checked");
    // event.stopImmediatePropagation();
}

function open_selected_transaction(viewName, id = null, loadingData = null) {
    var action = null;
    var View = 'transactions';
    var form = 'transactionForm';
    var data = null;

    var elem1 = $

    var renderedElement = $(".contentArea_panel");

    formViewHandler(action, View, form, data, loadingData, callback, id);

    function callback(msg) {
        renderedElement.html(msg);
    }
}