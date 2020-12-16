function password_toggle() {
    var elem = $(event.target);
    var src = elem.attr("src");
    var parent = elem.parent();
    var input = parent.find("input");

    if (src == "res/images/icons/view.png") {
        elem.attr("src", "res/images/icons/hide.png")
        input.attr("type", "text");
    } else {
        elem.attr("src", "res/images/icons/view.png")
        input.attr("type", "password");
    }
}

function render_outline() {
    var elem = $(event.currentTarget);
    var parent = elem.parent();
    parent.css("border", "solid #489BE5 2px");
}

function render_outline_hide() {
    var elem = $(event.currentTarget);
    var parent = elem.parent();
    parent.css("border", "solid rgb(160, 160, 160) 1px");
}