<!DOCTYPE html>
<html lang="en">

<head>
    <!-- config -->
    <meta charset="UTF-8">
    <meta http-equiv="refresh" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="HandheldFriendly" content="true">
    <title>Document</title>
    <!-- end config -->

    <!-- libs -->

    <!-- bootstrap -->
    <!-- CSS only -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">

    <!-- JS, Popper.js, and jQuery -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
    <!-- end libs -->

    <!-- site libs -->
    <script data-main="libs/main" src="libs/require.js"></script>

    <link rel="stylesheet" href="libs/css/main.css">
    <!-- end site libs -->
</head>

<body>
    <div class="navigation_panel">
        <div class="logo">
            <img src="logo.png" alt="">
        </div>
        <div class="timer">
            <div class="clocker">
                <ul>
                    <li class="time" id="hour">01</li>
                    <li class="time">:</li>
                    <li class="time" id="min">20</li>
                    <li class="time" id=period>am</li>
                    <li class="time"> </li>
                    <li class="time"> </li>
                    <li class="dates" id="day">20</li>
                    <li class="dates">/</li>
                    <li class="dates" id="month">30</li>
                    <li class="dates">/</li>
                    <li class="dates" id="Year">2020</li>
                </ul>
            </div>
        </div>
        <div class="search_bar">
            <div class="search_input">
                <input type="text">
            </div>
            <div class="search_display">

            </div>
        </div>
        <div class="nav_bar_navigation">
            <div class="icons_elem">
                <div class="icon_holder">
                    <img src="res/images/icons/settings_dark.png" alt="">
                </div>
                <div class="icon_holder">
                    <p>10</p>
                    <img src="res/images/icons/navNotification.png" alt="">
                </div>
                <div class="icon_holder">
                    <img src="res/images/icons/user_dark.png" alt="">
                </div>
            </div>
            <div class="icons_select_dropdown"></div>

        </div>
    </div>
    <div class="body_panel">
        <div class="side_panel">
            <div class="management_section">
                <p>Home</p>
                <div class="navigation_tab">
                    <img src="res/images/icons/dashboard.png" alt="">
                    <p>Dashboard</p>
                </div>
            </div>
            <div class="management_section">
                <p>Store</p>
                <div class="navigation_tab">
                    <img src="res/images/icons/pos.png" alt="">
                    <p>P.O.S</p>
                </div>
                <div class="navigation_tab">
                    <img src="res/images/icons/catalogue.png" alt="">
                    <p>Catalogue</p>
                </div>
                <div class="navigation_tab">
                    <img src="res/images/icons/customers.png" alt="">
                    <p>customers</p>
                </div>
                <div class="navigation_tab">
                    <img src="res/images/icons/orders.png" alt="">
                    <p>Sales</p>
                </div>
                <div class="navigation_tab">
                    <img src="res/images/icons/transaction.png" alt="">
                    <p>Transactions</p>
                </div>
            </div>
            <div class="management_section">
                <p>Management</p>
                <div class="navigation_tab">
                    <img src="res/images/icons/vendor.png" alt="">
                    <p>Vendors</p>
                </div>
                <div class="navigation_tab">
                    <img src="res/images/icons/notifications.png" alt="">
                    <p>Notifications</p>
                </div>
                <div class="navigation_tab">
                    <img src="res/images/icons/report.png" alt="">
                    <p>Reports</p>
                </div>
                <div class="navigation_tab">
                    <img src="res/images/icons/settings.png" alt="">
                    <p>Settings</p>
                </div>
            </div>
            <div class="management_section">
                <p>Admin</p>
                <div class="navigation_tab">
                    <img src="res/images/icons/user.png" alt="">
                    <p>Account</p>
                </div>
                <div class="navigation_tab">
                    <img src="res/images/icons/manager.png" alt="">
                    <p>Moderators</p>
                </div>
            </div>
        </div>
        <div class="contentArea_panel">
            <div class="view_title">
                <h3>Dashboard</h3>
            </div>
            <div class="statsDisplay">
                <div class="stat_element">
                    <div class="title_elem">
                        <img src="res/images/icons/sales_small.png" alt="">
                        <h4>Todays Sale Value</h4>
                    </div>
                    <div class="value_element">
                        <span>Ksh</span>
                        <p>120,000</p>
                    </div>
                    <div class="insight_elem">
                        <span>4%</span>
                        <p>Increase</p>
                    </div>
                </div>
                <div class="stat_element">
                    <div class="title_elem">
                        <img src="res/images/icons/sales_small.png" alt="">
                        <h4>Todays Sale Value</h4>
                    </div>
                    <div class="value_element">
                        <span>Ksh</span>
                        <p>120,000</p>
                    </div>
                    <div class="insight_elem">
                        <span>4%</span>
                        <p>Increase</p>
                    </div>
                </div>
                <div class="stat_element">
                    <div class="title_elem">
                        <img src="res/images/icons/sales_small.png" alt="">
                        <h4>Todays Sale Value</h4>
                    </div>
                    <div class="value_element">
                        <span>Ksh</span>
                        <p>120,000</p>
                    </div>
                    <div class="insight_elem">
                        <span>4%</span>
                        <p>Increase</p>
                    </div>
                </div>
                <div class="stat_element">
                    <div class="title_elem">
                        <img src="res/images/icons/sales_small.png" alt="">
                        <h4>Todays Sale Value</h4>
                    </div>
                    <div class="value_element">
                        <span>Ksh</span>
                        <p>120,000</p>
                    </div>
                    <div class="insight_elem">
                        <span>4%</span>
                        <p>Increase</p>
                    </div>
                </div>
                <div class="stat_element">
                    <div class="title_elem">
                        <img src="res/images/icons/sales_small.png" alt="">
                        <h4>Todays Sale Value</h4>
                    </div>
                    <div class="value_element">
                        <span>Ksh</span>
                        <p>120,000</p>
                    </div>
                    <div class="insight_elem">
                        <span>4%</span>
                        <p>Increase</p>
                    </div>
                </div>
                <div class="stat_element">
                    <div class="title_elem">
                        <img src="res/images/icons/sales_small.png" alt="">
                        <h4>Todays Sale Value</h4>
                    </div>
                    <div class="value_element">
                        <span>Ksh</span>
                        <p>120,000</p>
                    </div>
                    <div class="insight_elem">
                        <span>4%</span>
                        <p>Increase</p>
                    </div>
                </div>
            </div>
            <div class="dashboard_panel_1">
                <div class="header_tab">
                    <div class="title_elem">
                        <h3>Sales History</h3>
                        <span>Bar Graph</span>
                    </div>
                    <div class="date_elem">
                        <p>From</p>
                        <input type="date">
                        <p>to</p>
                        <input type="date">
                    </div>
                </div>
                <div class="dashboard_content_data">
                    <div class="graph_section">

                    </div>
                    <div class="product_stats_section">
                        <div class="heading_tab">
                            <h3>Top Selling Products</h3>
                        </div>
                        <table class="table table-bordered table-sm table-hover">
                            <thead>
                                <tr>
                                    <th scope="col">Last</th>
                                    <th scope="col">Handle</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Otto</td>
                                    <td>@mdo</td>
                                </tr>
                                <tr>
                                    <td>Thornton</td>
                                    <td>@fat</td>
                                </tr>
                                <tr>
                                    <td>@twitter</td>
                                    <td>@twitter</td>
                                </tr>
                                <tr>
                                    <td>Otto</td>
                                    <td>@mdo</td>
                                </tr>
                                <tr>
                                    <td>Thornton</td>
                                    <td>@fat</td>
                                </tr>
                                <tr>
                                    <td>@twitter</td>
                                    <td>@twitter</td>
                                </tr>
                                <tr>
                                    <td>Otto</td>
                                    <td>@mdo</td>
                                </tr>
                                <tr>
                                    <td>Thornton</td>
                                    <td>@fat</td>
                                </tr>
                                <tr>
                                    <td>@twitter</td>
                                    <td>@twitter</td>
                                </tr>
                                <tr>
                                    <td>@twitter</td>
                                    <td>@twitter</td>
                                </tr>
                            </tbody>
                            </table>
                    </div>
                </div>
            </div>
            <div class="dashboard_panel_2">
                <div class="orders_section">
                    <div class="heading_element">
                        <p>Unfulfilled Order</p>
                        <div class="dropdown_elem">
                            
                        </div>
                    </div>
                </div>
                <div class="To_Do_List">
                    <div class="heading_element">
                            
                    </div>
                </div>
                <div class="Recent_activity">
                    <div class="heading_element">
                            
                    </div>
                </div>
            </div>
        </div>
        <div class="right_side_panel">
            <p>hi</p>
        </div>
    </div>
    
</body>
</html>