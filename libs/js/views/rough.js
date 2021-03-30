var reports_status = {
    "action": "renderView",
    "data": {
        "priority": "Period",
        "span": "Day",
        "report_head": "Revenue",
        "date_filter": {
            "date_from": "2021-3-29",
            "date_to": "2021-3-30",
            "period_picker": "Day"
        }
    }
}

var bar_chart_data = [];


function loader(report_head = "Sales", ) {

    $("[name='dateFrom']").val(new Date().toDateInputValue());
    $("[name='dateTo']").val(new Date().toDateInputValue());
    var period = $("[name='period_picker']").find(":selected").val();
    reports_status.report_head = report_head;
    reports_status.date_filter.period_picker = period;
    reports_status.date_filter.date_from = $("[name='dateFrom']").val();
    reports_status.date_filter.date_to = $("[name='dateFrom']").val();

    if (period != "None") {
        var action = "renderView";
        var view = "reports";
        var data = reports_status;
        var id = null;
        return


        sendDataToHandler(action, view, data, callback, id);

        function callback(msg) {
            var data = JSON.parse(msg);

            render_report(data);
        }
    } else {

        var action = "loadDateReports";
        var view = "reports";
        var data = reports_status;
        var id = null;
        return


        sendDataToHandler(action, view, data, callback, id);

        function callback(msg) {
            console.log(msg);
        }
    }

}

function draw_bar_chart() {
    loader();
    google.charts.load('current', { packages: ['bar'] });
    google.charts.setOnLoadCallback(drawChart);

    function drawChart() {
        var data = new google.visualization.arrayToDataTable(bar_chart_data);

        var options = {
            width: 800,
            legend: { position: 'none' },
            chart: {
                title: 'Sales',
                subtitle: 'Sales Per day'
            },
            axes: {
                x: {
                    0: { side: 'top', label: 'Days' } // Top x-axis.
                }
            },
            bar: { groupWidth: "90%" }
        };

        var chart = new google.charts.Bar(document.getElementById('charter'));
        // Convert the Classic options to Material options.
        chart.draw(data, google.charts.Bar.convertOptions(options));
    }

    render_pie_chart();
}






Date.prototype.toDateInputValue = (function() {
    var local = new Date(this);
    local.setMinutes(this.getMinutes() - this.getTimezoneOffset());
    return local.toJSON().slice(0, 10);
});






function render_table(data = null, determiner) {
    var table = $(".report_details_panel .report_table_view .items_area table");

    switch (determiner) {
        case "Sale":
            var headings = '<thead>' +
                '<th scope="col">#</th>' +
                '<th scope="col">Sale ID</th>' +
                '<th scope="col">Sale type</th>' +
                '<th scope="col">Sale Amount</th>' +
                '<th scope="col">Sale Quantity</th>' +
                '</thead>';

            var body = "";
            var tbody = "<tbody>";
            var count = 1;
            $.each(data, function(key, value) {
                var sale_type = null;

                switch (sale_type) {
                    case 1:
                        sale_type = "Retail";
                        break;
                    case 2:
                        sale_type = "Wholesale";
                        break;
                    default:
                        sale_type = "Vehicle";
                        break;
                }
                var tr_local =
                    '<tr>' +
                    '<td>' + count + '</td>' +
                    '<td>' + value.sale_ID + '</td>' +
                    '<td>' + sale_type + '</td>' +
                    '<td>' + value.sale_Amount + '</td>' +
                    '<td>' + value.sale_Quantity + '</td>' +
                    '</tr>';

                tbody = tbody + tr_local;
                count++;
            });
            tbody = tbody + "</tbody>";
            var inner_table = headings + tbody;

            table.html(inner_table);
            break;
        case "orders":

            break;
        case "revenue":

            break;

        default:
            // console.log("done");
            break;
    }
}

function render_bar_chart(data = null, determiner) {
    var bar_data = new Array();
    bar_data.push(['Day', 'Quantity']);
    var temp_bar_data = data[0];

    switch (determiner) {
        case "Sale":
            days = [
                "Monday",
                "Tuesday",
                "Wednesday",
                "Thursday",
                "Friday"
            ];

            $.each(temp_bar_data['response'], function(key, value) {
                var keys = value.date;
                var count = value.count;

                if (count > 0) {

                    var quantity_sum = 0;

                    $.each(value.sales, function(key1, value1) {

                        var quantity = value1.saleQuantity;
                        quantity_sum = quantity_sum + quantity;

                    });
                    bar_data.push([value.date, quantity_sum]);
                } else {
                    bar_data.push([value.date, value.count]);
                }
            });
            bar_chart_data = bar_data;

            // console.log(bar_data);
        case "orders":

            break;
        case "revenue":

            break;

        default:
            // console.log("done");
            break;

            // bar_data.push([value.date, value.count]);
    }
}

function collect_date() {
    var period = $("[name='period_picker']").val();

    if (period == "None") {
        var date_from = $("[name='dateFrom']").val();
        var date_to = $("[name='dateTo']").val();

        var date_from1 = new Date(date_from);
        var date_to1 = new Date(date_to);

        if (date_from1.getTime() <= date_to1.getTime()) {
            apply_changes();
        } else {
            alert("Invalid date range");
        }
    } else {
        reports_status.date_filter.date_from = new Date().toDateInputValue();
        reports_status.date_filter.date_to = new Date().toDateInputValue();
        reports_status.date_filter.period_picker = period;
        reports_status.priority = "Period";
        reports_status.span = period;

        $("[name='dateFrom']").val(reports_status.date_filter.date_from);
        $("[name='dateTo']").val(reports_status.date_filter.date_to);
        apply_changes();
    }

}

function set_report_view(data) {
    reports_status.report_head = data;
    apply_changes();
}

function apply_changes() {
    var action = "renderView";
    var view = "reports";
    var data = reports_status;
    var id = null;

    // console.log(reports_status);


    // sendDataToHandler(action, view, data, callback, id);

    function callback(msg) {
        // console.log(msg);
    }
}