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

//form
function open_selected_sale(formName) {
    var action = "openSale";
    var View = "sales";
    var form = formName;
    var token = 1;
    var data = $(event.currentTarget).find('.sale_ID').text();

    var renderedElement = $(".contentArea_panel");

    formViewHandler(action, View, form, data, null, callback, null);

    function callback(msg) {
        renderedElement.html(msg);

        var id = data;
        get_transactions(id);

        // console.log(transactions);
    }
}

function previous_page_Sale() {
    var elem = $(event.currentTarget);
    var change = previous_page(elem);

    if (change) {
        var parent = elem.parent().parent();
        var current_page = parent.find('.active_page p').text();

        var action = "renderPage";
        var view = "sales";
        var data = (current_page - 1);
        var count = 0;

        sendDataToHandler(action, view, data, callback);

        function callback(msg) {
            var data = JSON.parse(msg);
            var statement = '';

            if (data.status) {
                var products = data.response;

                $.each(products, function(key, value) {
                    var id = value['sale_ID'];
                    var saleType = value['saleType'];
                    var saleValue = value['amount'];
                    var saleQuantity = value['saleQuantity'];
                    var saleDate = value['dateCreated'];

                    stmt = `
                                    <tr onclick="open_selected_product('catalogueForm',` + id + `)">
                                        <td onclick="select_current_product();"><div class="check_element"><input type="checkbox"></div></td>
                                        <td>` + (count + 1) + `</td>
                                        <td>` + id + `</td>
                                        <td>` + saleType + `</td>
                                        <td>` + saleValue + `</td>
                                        <td>` + saleQuantity + `</td>
                                        <td>` + saleDate + `</td>
                                    </tr>
                                `;
                    statement = statement + stmt;
                    count++;
                });

                $('.items_area table tbody').html(statement);
            } else {
                console.log("none");
                return;
            }

        }
    } else {
        return;
    }


}

function change_page_Sale(page) {
    var elem = $(event.currentTarget);
    var change = change_page(page, elem);

    if (change) {
        var parent = elem.parent().parent();
        var current_page = parent.find('.active_page p').text();

        var action = "renderPage";
        var view = "sales";
        var data = (current_page - 1);
        var count = 0;

        sendDataToHandler(action, view, data, callback);

        function callback(msg) {
            var data = JSON.parse(msg);
            var statement = '';

            if (data.status) {
                var products = data.response;

                $.each(products, function(key, value) {
                    var id = value['sale_ID'];
                    var saleType = value['saleType'];
                    var saleValue = value['amount'];
                    var saleQuantity = value['saleQuantity'];
                    var saleDate = value['dateCreated'];

                    stmt = `
                                    <tr onclick="open_selected_product('catalogueForm',` + id + `)">
                                        <td onclick="select_current_product();"><div class="check_element"><input type="checkbox"></div></td>
                                        <td>` + (count + 1) + `</td>
                                        <td>` + id + `</td>
                                        <td>` + saleType + `</td>
                                        <td>` + saleValue + `</td>
                                        <td>` + saleQuantity + `</td>
                                        <td>` + saleDate + `</td>
                                    </tr>
                                `;
                    statement = statement + stmt;
                    count++;
                });

                $('.items_area table tbody').html(statement);
            } else {
                console.log("none");
                return;
            }

        }
    } else {
        return;
    }


}

function next_page_Sale() {
    var elem = $(event.currentTarget);
    var change = next_page(elem);

    if (change) {
        var parent = elem.parent().parent();
        var current_page = parent.find('.active_page p').text();

        var action = "renderPage";
        var view = "sales";
        var data = (current_page - 1);

        console.log(data);

        var count = 0;

        sendDataToHandler(action, view, data, callback);

        function callback(msg) {
            var data = JSON.parse(msg);
            var statement = '';

            if (data.status) {
                var products = data.response;

                $.each(products, function(key, value) {
                    var id = value['sale_ID'];
                    var saleType = value['saleType'];
                    var saleValue = value['amount'];
                    var saleQuantity = value['saleQuantity'];
                    var saleDate = value['dateCreated'];

                    stmt = `
                                    <tr onclick="open_selected_product('catalogueForm',` + id + `)">
                                        <td onclick="select_current_product();"><div class="check_element"><input type="checkbox"></div></td>
                                        <td>` + (count + 1) + `</td>
                                        <td>` + id + `</td>
                                        <td>` + saleType + `</td>
                                        <td>` + saleValue + `</td>
                                        <td>` + saleQuantity + `</td>
                                        <td>` + saleDate + `</td>
                                    </tr>
                                `;
                    statement = statement + stmt;
                    count++;
                });

                $('.items_area table tbody').html(statement);
            } else {
                console.log("none");
                return;
            }

        }
    } else {
        return;
    }


}

function get_transactions(id) {

    var action = "getTransactions";
    var view = "sales";
    var data = id;
    var statement = "";

    sendDataToHandler(action, view, data, callback);

    function callback(msg) {
        var count = 1;
        var response = JSON.parse(msg);

        if (response.status) {
            transactions = response.response;

            $.each(transactions, function(key, value) {
                var method = value['transactionMethode'];
                var amount = value['transactionValue'];

                stmt = `
                                    <li>
                                        <div class="card_section">
                                            <div class="payment_method">
                                                <p>Method :</p>
                                                <p>` + method + `</p>
                                            </div>
                                            <div class="payment_method">
                                                <p>Amount :</p>
                                                <p class="transaction_amount">` + amount + `</p>
                                            </div>
                                        </div>
                                        <div class="transaction_closer">
                                            
                                        </div>
                                    </li>
                                `;
                statement = statement + stmt;
                count++;
            });
            var elem = $(".transaction_sales ul");
            elem.html("");
            elem.append(statement);
            open_right_panel();
        } else {
            return;
        }
    }
}