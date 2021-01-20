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