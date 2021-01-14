function create_new_sale() {
    var prompter = confirm("Do you wish to discard changes to current sale?");

    if (prompter) {
        renderMainContentView('PointOfSale');
    }
}

function remove_selected_item() {
    var elem = $(event.currentTarget);
    var parent = elem.parent();
    var grand_parent = parent.parent();

    parent.remove();
    console.log(grand_parent);
}

function make_payment() {
    var element = $(".system_elemental");
    element.fadeIn();
}

function display_item_lister_select() {
    var elem = $(event.currentTarget);
    var parent = elem.parent();

    var lister = parent.find(".item_lister_select");

    lister.fadeIn(300);
}

function hide_item_lister_select() {
    var elem = $(event.currentTarget);
    var parent = elem.parent();

    var lister = parent.find(".item_lister_select");

    lister.fadeOut(250);
}