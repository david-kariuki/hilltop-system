function renderMainContentView(viewName, loadingData = null, callBack = null) {
    var action = "renderMainView";
    var handler = "router";
    var token = 1;
    var data = viewName;
    var id = null;

    mainViewHandler(action, handler, data, callback, id);

    function callback(msg) {
        $(".contentArea_panel").html(msg);
    }
}