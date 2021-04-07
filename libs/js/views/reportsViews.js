var reports_status = {
    action: "renderView",
    data: {
        priority: "Period",
        span: "Day",
        report_head: "Sales",
        date_filter: {
            date_from: "2021-3-29",
            date_to: "2021-3-30",
            period_picker: "Day"
        }
    }
}

var bar_chart_data = [];

var data_return = null;

function report_page_loader() {
    set_defaults();
    apply_period_sort();
}

function set_defaults() {
    //initialize values
    var action = "renderView";
    var priority = "Period";
    var period_picker = "Day";
    var span = "Day";
    var date_range = {
        start_date: new Date().toDateInputValue(),
        end_date: new Date().toDateInputValue()
    }
    var report_head = "Sales";

    //assign default values
    reports_status.action = action;
    reports_status.data.priority = priority;
    reports_status.data.span = span;
    reports_status.data.report_head = report_head;
    reports_status.data.date_filter.date_from = date_range.start_date;
    reports_status.data.date_filter.date_to = date_range.end_date;
    reports_status.data.date_filter.period_picker = period_picker;

    bar_chart_data = [];

    //set dates on range
    reset_date_range();
}

function period_collector() {
    var period_picker_elem = $("[name='period_picker']");

    if (period_picker_elem.val() != "None") {
        //initialize values
        var action = "renderView";
        var priority = "Period";


        var period_picker = $("[name='period_picker']").val();
        var span = $("[name='period_picker']").val();


        var date_range = {
            start_date: new Date().toDateInputValue(),
            end_date: new Date().toDateInputValue()
        }
        var report_head = reports_status.data.report_head;

        //assign default values
        reports_status.action = action;
        reports_status.data.priority = priority;
        reports_status.data.span = span;
        reports_status.data.report_head = report_head;
        reports_status.data.date_filter.date_from = date_range.start_date;
        reports_status.data.date_filter.date_to = date_range.end_date;
        reports_status.data.date_filter.period_picker = period_picker;

        bar_chart_data = [];

        apply_period_sort();
    } else {
        range_collector()
    }
}

function range_collector() {
    var period_picker_elem = $("[name='period_picker']");

    if (period_picker_elem.val() == "None") {
        var valid_dates = range_verify();

        if (valid_dates) {
            //get dates
            var date_from_elem = $("[name='dateFrom']");
            var date_to_elem = $("[name='dateTo']");

            var date_from = date_from_elem.val();
            var date_to = date_to_elem.val();



            //initialize values
            var action = "renderView";
            var priority = "Range";
            var period_picker = "Day";
            var span = "Day";
            var date_range = {
                start_date: date_from,
                end_date: date_to,
            }
            var report_head = "Sales";

            //assign default values
            reports_status.action = action;
            reports_status.data.priority = priority;
            reports_status.data.span = span;
            reports_status.data.report_head = report_head;
            reports_status.data.date_filter.date_from = date_range.start_date;
            reports_status.data.date_filter.date_to = date_range.end_date;
            reports_status.data.date_filter.period_picker = period_picker;

            bar_chart_data = [];

            apply_period_sort();
        } else {
            alert("Invalid Dates");
        }
    } else {
        period_collector();
    }
}

function range_verify() {
    var date_from_elem = $("[name='dateFrom']");
    var date_to_elem = $("[name='dateTo']");

    var date_from = date_from_elem.val();
    var date_to = date_to_elem.val();

    if (Date.parse(date_from) <= Date.parse(date_to)) {
        return true;
    } else {
        return false;
    }
}

function apply_period_sort(params) {
    var action = reports_status.action;
    var view = "reports";
    var data = reports_status.data;
    var id = null;

    sendDataToHandler(action, view, data, callback, id);

    function callback(msg) {
        var data = JSON.parse(msg);
        data_return = msg;

        if (data.status === true) {
            render_report(data);
            draw_bar_chart();
        } else {
            alert("Error Opening Reports!");
            renderMainContentView('Dashboard');
        }
    }
}

function set_report_view(data) {
    view_changer(data);
    var head = data

    reports_status.data.report_head = data;

    apply_period_sort();
}




//helper
Date.prototype.toDateInputValue = (function() {
    var local = new Date(this);
    local.setMinutes(this.getMinutes() - this.getTimezoneOffset());
    return local.toJSON().slice(0, 10);
});

function render_report(data) {
    var response = data;
    //set Name
    $("#report_title").text(data.name);

    //set Displays
    $("#content_sales_total").text("Total sales " + data.Sales.saleQuantity);
    $("#content_Revenue_total").text("Ksh " + data.Revenue.transactionValue);
    $("#content_Orders_total").text("Ksh " + Math.floor(data.Orders.Amount));
    $("#content_Products_total").text(data.Products.currentStock + " Products");

    //render bar_chart
    switch (data.name) {
        case "Sales":
            var data = data.Sales;
            var bar_data = new Array(
                ['Day', 'Amount']
            );
            var data = data.bar_chart_data;

            $.each(data, function(key, value) {
                var day = value.day;
                var quantity = value.count;

                bar_data.push([day, parseInt(quantity)]);
            });

            bar_chart_data = bar_data;
            break;
        case "Revenue":
            var data1 = data.Revenue.bar_chart_data;
            var bar_data = new Array(
                ['Day', 'Quantity']
            );


            $.each(data1, function(key, value) {

                var day = value.day;
                var quantity = value.count;
                var quantity = Number(quantity.replace(/[^0-9.-]+/g, ""));
                var sub_data = [day, quantity];

                bar_data.push([day, parseInt(quantity)]);
            });

            bar_chart_data = bar_data;
            break;
        default:
            break;
    }

    //render table
    var table_html = "";
    var table_elem = $(".items_area table");


    switch (response.name) {
        case "Sales":

            var table_head = '' +
                '<thead>' +
                '<th scope="col">#</th>' +
                '<th scope="col">Sale ID</th>' +
                '<th scope="col">Sale type</th>' +
                '<th scope="col">Sale Amount</th>' +
                '<th scope="col">Sale Quantity</th>' +
                '</thead>';
            table_html = table_html + table_head + '<tbody>';
            var table_data = response.Sales.Sales_table_data;

            if (table_data == "No Data found") {
                alert(table_data);
            }

            var count = 1;

            $.each(table_data, function(key, value) {
                // console.log(value);
                var sale_id = value.sale_ID;
                var sale_type = value.saleType;
                var sale_amount = value.amount;
                var sale_quantity = value.saleQuantity;

                table_body = '' +
                    '<tr>' +
                    '<td>' + count + '</td>' +
                    '<td>' + sale_id + '</td>' +
                    '<td>' + sale_type + '</td>' +
                    '<td>' + sale_amount + '</td>' +
                    '<td>' + sale_quantity + '</td>' +
                    '</tr>';

                table_html = table_html + table_body;
                count++;
            });

            table_html = table_html + '</tbody>';
            break;
        case "Revenue":
            var table_html = "";
            var table_head = '' +
                '<thead>' +
                '<th scope="col">#</th>' +
                '<th scope="col">Sale ID</th>' +
                '<th scope="col">Sale type</th>' +
                '<th scope="col">Sale Amount</th>' +
                '<th scope="col">Sale Quantity</th>' +
                '</thead>';
            table_html = table_html + table_head + '<tbody>';
            var table_data = response.Revenue.Revenue_table_data;

            if (table_data == "No Data found") {
                alert(table_data);
                table_html = table_html + "<p>No Data found!<p/>";
            }
            var count = 1;

            $.each(table_data, function(key, value) {
                // console.log(value);
                var sale_id = value.sale_ID;
                var sale_type = value.saleType;
                var sale_amount = value.amount;
                var sale_quantity = value.saleQuantity;

                table_body = '' +
                    '<tr>' +
                    '<td>' + count + '</td>' +
                    '<td>' + sale_id + '</td>' +
                    '<td>' + sale_type + '</td>' +
                    '<td>' + sale_amount + '</td>' +
                    '<td>' + sale_quantity + '</td>' +
                    '</tr>';

                table_html = table_html + table_body;
                count++;
            });

            table_html = table_html + '</tbody>';
            break;
        case "Orders":
            var table_html = "";
            var table_head = '' +
                '<thead>' +
                '<th scope="col">#</th>' +
                '<th scope="col">Order ID</th>' +
                '<th scope="col">Quantity</th>' +
                '<th scope="col">Amount</th>' +
                '</thead>';
            var table_data = response.Orders.Orders_table_data;

            if (table_data == "No Data found") {
                alert(table_data);
                table_html.html("<p>No Data found!<p/>");
            }
            var count = 1;
            table_html = table_html + table_head + '<tbody>';

            $.each(table_data, function(key, value) {
                // console.log(value);
                var order_id = value.sale_ID;
                var order_amount = value.Amount;
                var order_quantity = value.Quantity;

                table_body = '' +
                    '<tr>' +
                    '<td>' + count + '</td>' +
                    '<td>' + order_id + '</td>' +
                    '<td>' + order_amount + 'e</td>' +
                    '<td>' + order_quantity + '</td>' +
                    '</tr>';

                table_html = table_html + table_body;
                count++;
            });

            table_html = table_html + '</tbody>';


            break;
        case "Products":
            return;
            break;

        default:
            break;


    }

    table_elem.html(table_html);
}

function draw_bar_chart() {
    google.charts.load('current', { 'packages': ['bar'] });
    google.charts.setOnLoadCallback(drawChart);

    function drawChart() {
        var data = google.visualization.arrayToDataTable(bar_chart_data);

        var options = {
            chart: {
                // title: 'Company Performance',
                // subtitle: 'Sales, Expenses, and Profit: 2014-2017',
            }
        };

        var chart = new google.charts.Bar(document.getElementById('bar_chart'));

        chart.draw(data, google.charts.Bar.convertOptions(options));
    }
}

function reset_date_range() {
    var todayDate = new Date().toISOString().slice(0, 10);

    var date_from_elem = $("[name='dateFrom']");
    date_from_elem.val(todayDate);

    var date_to_elem = $("[name='dateTo']");
    date_to_elem.val(todayDate);

}

function view_changer(data = null) {
    if (data = null) {
        console.log("Invalid Entry");
    } else {
        reports_status.data.report_head = data;
    }
}




// elemental_handlers
function export_content(doc_type) {
    var passdata = null;

    stats = JSON.parse(data_return);

    // report_title = stats.name;
    // console.log(report_tityle);
    var format = null;

    report_title = stats.name;
    data = null;

    switch (report_title) {
        case "Sales":
            data = stats.Sales.Sales_table_data;
            break;
        case "Revenue":
            data = stats.Revenue.Revenue_table_data;
            break;
        default:
            break;


    }

    passdata = export_formatter(data);
    passdata = passdata;

    switch (doc_type) {
        case "csv":
            format = "CSV";
            break;
        case "pdf":
            format = "PDF";
            break;
        case "view":
            format = "View";
            break;

        default:
            return;
            break;
    }

    var action = "export_report";
    var view = "reports"
    var period = $("[name = 'period_picker'").val();
    var range = [];
    var from = $("[name = 'dateFrom']").val();
    var to = $("[name = 'dateTo']").val();

    var data = {
        "sub_data": passdata,
        "Title": "Sales Report",
        "format": format,
        "range": {
            from: from,
            to: to
        },
        "Period": period,
    };

    var id = null;

    sendDataToHandler(action, view, data, callback, id);

    function callback(msg) {
        window.open(root + "/Views/reports/doc_gen.php?data=" + msg, '_blank');
    }
}

//helper files
function export_formatter(data) {
    var return_array = [];

    var type = typeof data;


    if (data != null && data != "No data found") {
        $.each(data, function(key, value) {
            var sale_ID = value.sale_ID;
            var Amount = value.amount;
            var Quantity = value.saleQuantity;
            var sale_type = value.saleType;

            if (sale_type == '1') {
                var sale_type = "Retail";
            } else if (sale_type == '2') {
                var sale_type = "Wholesale";
            } else if (sale_type == '3') {
                var sale_type = "Vehicle";
            } else {
                alert("invalid entry");
                return;
            }

            temp_array = {
                'sale_ID': sale_ID,
                'sale_type': sale_type,
                'sale_Quantity': Quantity,
                'sale_Amount': Amount
            };

            return_array.push(temp_array);
        });
    } else {
        alert("Cannot perform Action");
        return;
    }

    return return_array;
}