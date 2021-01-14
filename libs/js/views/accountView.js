function open_accountForm_view(viewName, loadingData = null, callBack = null) {
    var action = "openAccountForm";
    var View = "accounts";
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