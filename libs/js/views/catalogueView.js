function toggle_product_details_section() {
    var element = $(event.currentTarget);
    var tab_name = element.html();

    switch (tab_name) {
        case "Store":
            toggle_Active_tab(element, $(".store_section"));
            render_navigation_Buttons(element);
            break;
        case "Wholesale":
            toggle_Active_tab(element, $(".wholesale_section"));
            render_navigation_Buttons(element);
            break;
        case "Vehicle":
            toggle_Active_tab(element, $(".vehicle_section"));
            render_navigation_Buttons(element);
            break;
        case "Product Details":
            toggle_Active_tab(element, $(".product_section"));
            render_navigation_Buttons(element);
            break;
        default:
            alert("Invalid Entry");
    }

    function toggle_Active_tab(elem, element2) {
        var parent = $(".sections_elem");

        var list = parent.find(".content_product_section");

        $.each(list, function(key, value) {
            var parent1 = $(value).parent();
            parent1.fadeOut();
        });
        $(element2).fadeIn()

    }

    function render_navigation_Buttons(element) {
        var parent = $(".section_navigation");

        var list = parent.find("li");

        $.each(list, function(key, value) {
            $(value).removeClass("high_lighted");
        });

        element.addClass("high_lighted");
    }
}

function select_current_product() {
    console.log("checked");
    event.stopImmediatePropagation();
}

function open_selected_product(viewName, loadingData = null, callBack = null) {
    var action = "openProduct";
    var View = "catalogue";
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

function open_selected_product(viewName, uid) {
    var action = "openSelected";
    var View = "catalogue";
    var form = viewName;
    var data = uid;

    var renderedElement = $(".contentArea_panel");

    formViewHandler(action, View, form, data, null, callback, null);

    function callback(msg) {
        renderedElement.html(msg);
    }
}

function product_collector() {

    var productName = $("[name='productName']").val();
    var productType = $("[name='productType']").val();
    var visibility = $("[name='visibility']").val();
    var enableEdit = $("[name='enableEdit']").val();
    var Notes = $("[name='Notes']").val();

    var retail_currentStock = $("[name='retail_currentStock']").val();
    var retail_lowStockThreshold = $("[name='retail_lowStockThreshold']").val();
    var retail_supplier = $("[name='retail_supplier']").val();
    var retail_regularPrice = $("[name='retail_regularPrice']").val();
    var retail_salePrice = $("[name='retail_salePrice']").val();
    var retail_includedTax = $("[name='retail_includedTax']").val();

    var wholesale_currentStock = $("[name='wholesale_currentStock']").val();
    var wholesale_lowStockThreshold = $("[name='wholesale_lowStockThreshold']").val();
    var wholesale_supplier = $("[name='wholesale_supplier']").val();
    var wholesale_regularPrice = $("[name='wholesale_regularPrice']").val();
    var wholesale_salePrice = $("[name='wholesale_salePrice']").val();
    var wholesale_includedTax = $("[name='wholesale_includedTax']").val();

    var vehicle_currentStock = $("[name='vehicle_currentStock']").val();
    var vehicle_lowStockThreshold = $("[name='vehicle_lowStockThreshold']").val();
    var vehicle_supplier = $("[name='vehicle_supplier']").val();
    var vehicle_regularPrice = $("[name='vehicle_regularPrice']").val();
    var vehicle_salePrice = $("[name='vehicle_salePrice']").val();
    var vehicle_includedTax = $("[name='vehicle_includedTax']").val();


    var data = {
        product: {
            productName: productName,
            productType: productType,
            visibility: visibility,
            enableEdit: enableEdit,
            Notes: Notes
        },
        retail: {
            currentStock: retail_currentStock,
            lowStockThreshold: retail_lowStockThreshold,
            supplier: retail_supplier,
            regularPrice: retail_regularPrice,
            salePrice: retail_salePrice,
            includedTax: retail_includedTax,
        },
        wholesale: {
            currentStock: wholesale_currentStock,
            lowStockThreshold: wholesale_lowStockThreshold,
            supplier: wholesale_supplier,
            regularPrice: wholesale_regularPrice,
            salePrice: wholesale_salePrice,
            includedTax: wholesale_includedTax
        },
        vehicle: {
            currentStock: vehicle_currentStock,
            lowStockThreshold: vehicle_lowStockThreshold,
            supplier: vehicle_supplier,
            regularPrice: vehicle_regularPrice,
            salePrice: vehicle_salePrice,
            includedTax: vehicle_includedTax
        }
    }

    var exceptions = [
        'Notes',
        'includedTax',
        'lowStockThreshold',
        'supplier',
        'salePrice'
    ]

    $.each(data, function(key, valueObj) {
        $.each(valueObj, function(key1, valueObj1) {
            if (exceptions.includes(key1)) {

            } else {
                if (isEmpty(valueObj1)) {
                    console.log(key1);
                    data = false;
                    return
                }
            }
        });
    });

    return data;
}

function create_product() {
    var data = product_collector();

    if (data != false) {
        var action = "createNewProduct";
        var view = "catalogue";
        var data = data;

        sendDataToHandler(action, view, data, callback, null);

        function callback(msg) {
            var data = JSON.parse(msg);

            alert(data.response);
        }
    } else {
        alert("Some required fields were not filled");
    }
}

function update_product(id) {
    var data = product_collector();

    if (data != false) {
        var action = "updateProduct";
        var view = "catalogue";
        var data = data;

        sendDataToHandler(action, view, data, callback, id);

        function callback(msg) {
            var data = JSON.parse(msg);

            alert(data.response);
        }
    } else {
        alert("Some required fields were not filled");
    }
}

function previous_page_catalogue() {
    var elem = $(event.currentTarget);
    var change = previous_page(elem);

    if (change) {
        var parent = elem.parent().parent();
        var current_page = parent.find('.active_page p').text();

        var action = "renderPage";
        var view = "catalogue";
        var data = (current_page - 1);

        sendDataToHandler(action, view, data, callback);

        function callback(msg) {
            var data = JSON.parse(msg);
            var statement = '';
            var count = 0;

            if (data.status) {
                var products = data.response;

                $.each(products, function(key, value) {
                    var id = value['UUID'];
                    var productName = value['productName'];
                    var productType = value['productType'];
                    var visibility = value['visibility'];

                    stmt = `
                                    <tr onclick="open_selected_product('catalogueForm',` + id + `)">
                                        <td onclick="select_current_product();"><div class="check_element"><input type="checkbox"></div></td>
                                        <td>` + (count + 1) + `</td>
                                        <td>` + id + `</td>
                                        <td>` + productName + `</td>
                                        <td>` + productType + `</td>
                                        <td>` + visibility + `</td>
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

function change_page_catalogue(page) {
    var elem = $(event.currentTarget);
    var change = change_page(page, elem);

    if (change) {
        var parent = elem.parent().parent();
        var current_page = parent.find('.active_page p').text();

        var action = "renderPage";
        var view = "catalogue";
        var data = (current_page - 1);

        sendDataToHandler(action, view, data, callback);

        function callback(msg) {
            var data = JSON.parse(msg);
            var statement = '';
            var count = 0;

            if (data.status) {
                var products = data.response;

                $.each(products, function(key, value) {
                    var id = value['UUID'];
                    var productName = value['productName'];
                    var productType = value['productType'];
                    var visibility = value['visibility'];

                    stmt = `
                                    <tr onclick="open_selected_product('catalogueForm',` + id + `)">
                                        <td onclick="select_current_product();"><div class="check_element"><input type="checkbox"></div></td>
                                        <td>` + (count + 1) + `</td>
                                        <td>` + id + `</td>
                                        <td>` + productName + `</td>
                                        <td>` + productType + `</td>
                                        <td>` + visibility + `</td>
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

function next_page_catalogue() {
    var elem = $(event.currentTarget);
    var change = next_page(elem);

    if (change) {
        var parent = elem.parent().parent();
        var current_page = parent.find('.active_page p').text();

        var action = "renderPage";
        var view = "catalogue";
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
                    var id = value['UUID'];
                    var productName = value['productName'];
                    var productType = value['productType'];
                    var visibility = value['visibility'];

                    stmt = `
                                    <tr onclick="open_selected_product('catalogueForm',` + id + `)">
                                        <td onclick="select_current_product();"><div class="check_element"><input type="checkbox"></div></td>
                                        <td>` + (count + 1) + `</td>
                                        <td>` + id + `</td>
                                        <td>` + productName + `</td>
                                        <td>` + productType + `</td>
                                        <td>` + visibility + `</td>
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


function toggle_catalogue_filter() {
    var selector = $("select[name='apply_filters']");
    var filter_set = selector.val();

    var rendered_elem = $(".catalogue_filters");

    if (filter_set == "applyFilters") {
        rendered_elem.fadeIn("fast");
    } else if (filter_set == "removeFilters") {
        rendered_elem.fadeOut("fast");
    } else {
        rendered_elem.fadeOut("fast");
    }
}

function run_filter(status) {
    var action = "filter_data";
    var view = 'catalogue';
    var data = null;

    if (status) {
        var filter_visibility = $("select[name='Visibility']").val();

        var data = {
            visibility: filter_visibility
        };

        sendDataToHandler(action, view, data, callback, id = null)

        function callback(msg) {
            var data = JSON.parse(msg);
            var stmt = "";

            if (data.status) {
                var products = data.response;

                $.each(products, function(key, product) {

                    var temp_stmt = `
                            <tr onclick="open_selected_product('catalogueForm','` + products.productID + `')">
                                <td onclick="select_current_product();"><div class="check_element"><input type="checkbox"></div></td>
                                <td> ` + product.count + ` </td>
                                <td> ` + product.productID + ` </td>
                                <td> ` + product.productName + ` </td>
                                <td> ` + product.productType + ` </td>
                                <td> ` + product.visibility + ` </td>
                            </tr>
                    `

                    stmt = stmt + temp_stmt;
                });

                var render_elem = $(".items_area table tbody").html(stmt);

            } else {
                alert("Error Filtering Items");
            }
        }
    } else {
        var action = "remove_filter";
        var view = "catalogue";
        var data = "all";

        sendDataToHandler(action, view, data, callback, id = null);

        function callback(msg) {
            console.log(msg);
        }
    }
}

function search_product() {
    var elem = $(event.currentTarget);
    var product_name = elem.val();

    if (!isEmpty(product_name)) {
        var action = "search_product";
        var view = 'catalogue';
        var data = product_name;

        sendDataToHandler(action, view, data, callback, id = null);

        function callback(msg) {
            console.log(msg);
        }
    }
}