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

function confirm_sale() {
    var sale = sale_collector();

    console.log(sale);
}

function sale_collector() {
    //sale
    var saleType = $("[name='saleType']").val();
    var quantity = $("#quantity").html();
    var amount = $("#amount").html();
    var totalAmount = amount;
    var saleNote = $("[name='saleNote']").val();

    var data = {
        saleType: saleType,
        quantity: quantity,
        amount: amount,
        totalAmount: totalAmount,
        saleNote: saleNote
    }

    return data;
}

function get_product_record() {
    var elem = event.currentTarget;
    var name = $(elem).val()

    if (isEmpty(name)) {
        return;
    } else {
        var action = "getProduct";
        var view = "PointOfSale";
        var data = name;


        sendDataToHandler(action, view, data, callback, null);

        function callback(msg) {
            console.log(msg);
        }
    }

}