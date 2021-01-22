const sale = {
    saleDetails: {
        saleQuantity: 0,
        saleType: 1,
        saleAmount: 0
    },
    subSale: [],
    transaction: [],
    balance: 0,
    payedAmount: 0
}

function sale_collector() {
    find_total_price();
    //sale
    sale.saleDetails.saleType = $("[name='saleType']").val();
    sale.saleDetails.saleQuantity = $("#quantity").html();
    sale.saleDetails.saleAmount = $("#amount").html();

    function get_paid_value() {
        var card = $(".transaction_sales");
        var transactions = card.find(".card_section");
        var totalAmountPaid = 0;

        $.each(transactions, function(key, value) {
            var amountElem = $(value).find(".transaction_amount");
            var amount = $(amountElem).text();

            totalAmountPaid = Number(totalAmountPaid) + Number(amount);
        })

        return totalAmountPaid;
    }

    function get_sale_item() {

        var elem = $(".table_body");
        var items = elem.find(".item_select");

        $.each(items, function(key, value) {
            var product = {
                productName: null,
                quantity: 0
            }

            product.productName = $(value).find("[name='productName']").val();
            product.quantity = $(value).parent().find("[name='quantity']").val();

            if (isEmpty(product.productName)) {
                return;
            } else {
                sale.subSale.push(product);
            }
        })

    }
    get_sale_item();

    sale.payedAmount = get_paid_value();
    sale.balance = sale.saleDetails.saleAmount - sale.payedAmount;
}


function create_new_sale() {
    var prompter = confirm("Do you wish to discard changes to current sale?");

    if (prompter) {
        renderMainContentView('PointOfSale');
    }
    find_total_price();
    reset_sale();
}

function remove_selected_item() {
    var elem = $(event.currentTarget);
    var parent = elem.parent();
    var grand_parent = parent.parent();

    parent.remove();
    find_total_price();
}

function make_payment() {
    var totalAmount, amountToPay, balance;

    totalAmount = $("#amount").text();
    amountToPay = $("#amount").text();

    $('[name="totalAmount"]').val(totalAmount);
    $('[name="amountToPay"]').val(amountToPay);

    paymentMethod = 0;
    amountPayed = 0;
    balance = 0;

    var element = $(".system_elemental");
    element.fadeIn();
}

function display_item_lister_select() {
    var elem = $(event.currentTarget);
    var parent = elem.parent();

    var lister = parent.find(".item_lister_select");

    lister.fadeIn(300);
    find_total_price();
}

function hide_item_lister_select() {
    var elem = $(event.currentTarget);
    var parent = elem.parent();

    var lister = parent.find(".item_lister_select");

    lister.fadeOut(250);
    find_total_price();
}

function confirm_sale() {
    sale_collector();

    var saleBalance = sale.balance;
    var sales = sale.subSale.length;

    if (saleBalance > 0) {
        alert("Balance Not Cleared");
        return;
    } else if (saleBalance < 0) {
        alert("Excess amount Payed")
        return;
    } else {

        if (sales > 0) {
            var action = "addSale";
            var view = "PointOfSale";
            var data = sale;


            sendDataToHandler(action, view, data, callback, null);

            function callback(msg) {
                console.log(msg);
            }
        } else {
            alert("No product entered");
        }
    }
}

function get_product_record() {
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
        var view = "PointOfSale";
        var data = [
            name,
            saleType
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

function select_purchase_item(uuid, name, price) {
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
    var subPrice = parent.find(".sub_price").html(price);
    quantity = parent.find("[name='quantity']").val();

    if (Number(quantity) <= 0) {
        quantity = 1;
        parent.find("[name='quantity']").val(quantity);
    }
    var totalPrice = Number(price) * Number(quantity);

    parent.find(".sub_total").html(totalPrice);

    var tableElem = `
                <tr>
                    <td class="item_select">
                        <input type="text" onfocus="display_item_lister_select()" onfocusOut="hide_item_lister_select()" onkeyup="get_product_record()" name="productName" autocomplete="off">
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
}

function find_sub_total() {
    var elem = $(event.currentTarget).parent().parent();
    var elemFind = elem.find(".sub_total");
    var quantity = elem.find('[name="quantity"]').val();
    var price = elem.find('.sub_price').html();

    var totalPrice = Number(quantity) * Number(price);

    elem.find(".sub_total").html(totalPrice);

    find_total_price();
}

function find_duplicate(name) {
    var table = $(".items_area table");
    var body = table.find('.table_body');
    var records = body.find("tr>td>[name='productName']");
    var show = true;

    $.each(records, function(key, value) {
        var productName = $(value).val();

        if (productName == name) {
            show = false;
            return false
        }
    });

    return show;
}

function find_total_price() {
    var table = $('.table_body');

    var values = table.find('.sub_total');
    var totalSaleValue = 0;

    $.each(values, function(key, value) {
        totalSaleValue = totalSaleValue + Number($(value).text());
    })

    $('#amount').html(totalSaleValue);
    $('#totalAmount').html('Ksh ' + totalSaleValue);

    var values2 = table.find('[name="quantity"]');
    var totalQuantity = 0;

    $.each(values2, function(key, value) {
        var item = $(value).val();
        totalQuantity = totalQuantity + Number(item);
    })

    $('#quantity').html(totalQuantity);
}

function updatePayment() {
    var elem = $(event.currentTarget);
    var amountPayed = elem.val();
    var totalAmount = $("[name='totalAmount']").val();
    var balance = totalAmount - amountPayed;
    $("[name=balance]").val(balance);
}

function confirm_payment() {
    var transaction = {
        paymentMethod: null,
        amount: null
    }
    if (confirm('Confirm payment?')) {
        transaction.paymentMethod = $("[name=paymentMethod]").val();
        transaction.amount = $("[name=amountPayed]").val();
        sale.transaction.push(transaction);

        var elem = $(".transaction_sales ul");
        var string = `
                        <li>
                            <div class="card_section">
                                <div class="payment_method">
                                    <p>Method :</p>
                                    <p>` + transaction.paymentMethod + `</p>
                                </div>
                                <div class="payment_method">
                                    <p>Amount :</p>
                                    <p class="transaction_amount">` + transaction.amount + `</p>
                                </div>
                            </div>
                            <div class="transaction_closer" onclick="remove_transaction()">
                                <span class="">X</span>
                            </div>
                        </li>
                    `

        elem.append(string);
        close_system_elemental();
    } else {
        alert("Payment canceled");
    }
}

function view_transactions(params) {
    open_right_panel();
}


function reset_sale() {
    sale.saleDetails.saleQuantity = null;
    sale.saleDetails.saleType = null;
    sale.saleDetails.saleAmount = null;

    sale.subSale = [];
    sale.transaction = [];
    sale.balance = [];
    sale.payedAmount = null;

    var transactionElem = $(".transaction_sales");
    var ulElem = transactionElem.find("ul");

    ulElem.html("");
}

function remove_transaction() {
    var elem = $(event.currentTarget);

    elem.parent().remove();
}