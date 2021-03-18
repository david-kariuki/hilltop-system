var order = {
    merchantDetails: {
        name: null,
        number: null,
        Address: null
    },
    orderDetails: {
        OrderID: null,
        date: null,
        Quantity: 0,
        Amount: 0,
        Note: null
    },
    subOrdersDetails: []
}

//open order form panel
function open_order_form(order_id = null) {

    if (order_id == null) {
        //creating a new order

        //render view
        var action = "openNewOrder";
        var View = "orders";
        var form = "orderForm";
        var loadingData = "new";

        var renderedElement = $(".contentArea_panel");

        formViewHandler(action, View, form, null, loadingData, callback, null);

        function callback(msg) {
            renderedElement.html(msg);
        }

    } else {
        //opening specific order
        var action = "openExistingOrder";
        var View = "orders";
        var form = "orderForm";
        var loadingData = "updating";

        var renderedElement = $(".contentArea_panel");

        formViewHandler(action, View, form, order_id, loadingData, callback, null);

        function callback(msg) {
            renderedElement.html(msg);
        }
    }

    clear_order();
}

//conforms the order details and add them to the database
function Make_Order() {
    //collect merchant data 
    var merchant_name = $("[name='merchant_name']").val();
    var merchant_number = $("[name='merchant_number']").val();
    var merchant_address = $("[name='merchant_address']").val();

    order.merchantDetails.name = merchant_name;
    order.merchantDetails.number = merchant_number;
    order.merchantDetails.Address = merchant_address;


    //collect order details
    var order_quantity = $("#quantity").text();
    var order_amount = $("#amount").text();
    var order_order_note = $("[name='saleNote']").val();

    order.orderDetails.Quantity = order_quantity;
    order.orderDetails.Amount = order_amount;
    order.orderDetails.Note = order_order_note;

    //collect all sub orders
    collect_all_sub_orders();

    var action = "addNewOrder";
    var view = "orders";
    var data = order;
    var callback = confirm_order;
    var id;

    sendDataToHandler(action, view, data, callback, id);

    function confirm_order(msg) {
        var data = JSON.parse(msg);

        if (data.status == true) {
            alert(data.response);
            renderMainContentView('Orders');
        } else {
            alert(data.response);
        }
    }

}

//search for product in the database
function get_order_product() {
    var elem = event.currentTarget;
    var name = $(elem).val()
    var saleType = $("[name='saleType']").val();

    if (isEmpty(name)) {
        hide_item_lister_select();
        find_total_price();
        return;
    } else {
        display_item_lister_select()
        var action = "getProduct";
        var view = "orders";
        var data = [
            name,
            1
        ];

        sendDataToHandler(action, view, data, callback, null);

        function callback(msg) {
            var data = JSON.parse(msg);

            if (data.status) {
                var statement = "";

                $.each(data.response, function(key, value) {
                    statement = statement + value;
                });

                var Elem = $(".item_lister_select");

                var renderElem = Elem.find("tbody");
                renderElem.html(statement);
                find_total_price();
            } else {
                var Elem = $(".item_lister_select");
                var renderElem = Elem.find("tbody");
                renderElem.html("<p>" + data.response + "<p>");
                find_total_price();
            }
        }
    }
}

// select and add item to list of sub order
function select_order_item(uuid, name, price) {

    var tester = find_duplicate(name);

    if (tester == false) {
        alert("Duplicate Entry");
        return;
    }

    //get value
    var elem = $(event.currentTarget);
    var parent = elem.parent().parent().parent().parent().parent();
    var ancestor = parent.parent();

    //set name and price
    var productName = parent.find("[name='productName']").val(name);
    // var subPrice = parent.find(".sub_price").html(price);
    quantity = parent.find("[name='quantity']").val();

    if (Number(quantity) <= 0) {
        quantity = 1;
        parent.find("[name='quantity']").val(quantity);
    }
    var totalPrice = Number(price) * Number(quantity);

    var sub_total = parent.find(".sub_price");

    sub_total.text(calculate_price_per_item(parent));


    var tableElem = `
                <tr>
                    <td class="item_select"  data-uuid="unidentified">
                        <input type="text" onfocus="display_item_lister_select()" onfocusOut="hide_item_lister_select()" onkeyup="get_order_product()" name="productName" autocomplete="off">
                        <div class="item_lister_select">
                            <table class="tbl_show">
                                <thead>
                                    <tr>
                                        <th scope="col">Product Name</th>
                                        <th scope="col">Quantity</th>
                                        <th scope="col">Price</th>
                                    </tr>
                                </thead>
                                <tbody>

                                </tbody>
                            </table>
                        </div>
                    </td>
                    <td style="width: 40px;"><input type="number" name="quantity" value="0" onchange="find_sub_total()"></td>
                    <td class="sub_price">0</td>
                    <td class="sub_total">0</td>
                    <td class="cancel_button" onclick="remove_selected_item()"><p>X</p></td>
                </tr>
    `

    ancestor.append(tableElem);
    find_total_price();
    update_balance();
    assign_id_to_selected_element(uuid, parent);
}

//this function collect all the sub orders
function collect_all_sub_orders() {
    var sub_order_table = $(".items_area .table_body");

    var sub_orders = sub_order_table.find(".item_select");

    $.each(sub_orders, function(key, value) {
        var elem = $(value);
        var item = {
            id: null,
            quantity: null,
            sub_total: null
        };

        if (elem.data('uuid') !== 'unidentified') {
            var id = elem.data('uuid');
            var quantity = elem.parent().find("[name='quantity']").val();
            var sub_total = elem.parent().find("[name='subtotal']").val();

            item.id = id;
            item.quantity = quantity;
            item.sub_total = sub_total

            order.subOrdersDetails.push(item);
        }
    });
}

function calculate_price_per_item(element) {
    var quantity = element.find("[name='quantity']").val();
    var sub_total = element.find("[name='subtotal']").val();
    var price = (parseInt(sub_total) / parseInt(quantity)).toFixed(2);

    calculate_all_sub_orders()
}

function evaluate_sub_order() {
    var elem = $(event.currentTarget);
    var parent = elem.parent().parent();

    var quantity = parent.find("[name='quantity'").val();
    var sub_total = parent.find("[name='subtotal'").val();
    var sub_price = parent.find(".sub_price");

    var price = (parseFloat(sub_total) / parseFloat(quantity)).toFixed(2);

    sub_price.text(price);

    calculate_all_sub_orders()
}

function calculate_all_sub_orders() {
    var element = $(".items_area");
    var all_prices = element.find("[name=subtotal");
    var all_quantities = element.find("[name=quantity");
    var total = parseFloat(0.00);
    var quantity_total = parseFloat(0.00);


    $.each(all_prices, function(key, value) {
        var elem = $(value);
        var price = elem.val();

        total = parseFloat(total) + parseFloat(price);

    });

    $.each(all_quantities, function(key, value) {
        var elem = $(value);
        var quantity = elem.val();

        quantity_total = parseFloat(quantity_total) + parseFloat(quantity);

    });

    var total_price_display = $("#amount").text(total);
    var total_price_display = $("#totalAmount").text(total);
    var total_quantity_display = $("#quantity").text(quantity_total);
}

function clear_order() {
    order.merchantDetails.name = null;
    order.merchantDetails.name = null;
    order.merchantDetails.name = null;

    order.orderDetails.OrderID = null;
    order.orderDetails.date = null;
    order.orderDetails.Quantity = null;
    order.orderDetails.Amount = null;
    order.orderDetails.Note = null;

    order.subOrdersDetails = [];
}

function search_by_ID() {
    var value = $(event.currentTarget).val();
    console.log(value);
}