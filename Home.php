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
    <script src="https://code.jquery.com/jquery-3.5.1.js" integrity="sha256-QWo7LDvxbWT2tbbQ97B53yJnYU3WhH/C8ycbRAkjPDc=" crossorigin="anonymous"></script>
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
                <div class="navigation_tab" onclick="renderMainContentView('Dashboard')">
                    <img src="res/images/icons/dashboard.png" alt="">
                    <p>Dashboard</p>
                </div>
            </div>
            <div class="management_section">
                <p>Store</p>
                <div class="navigation_tab" onclick="renderMainContentView('PointOfSale')">
                    <img src="res/images/icons/pos.png" alt="">
                    <p>P.O.S</p>
                </div>
                <div class="navigation_tab" onclick="renderMainContentView('Catalogue')">
                    <img src="res/images/icons/catalogue.png" alt="">
                    <p>Catalogue</p>
                </div>
                <div class="navigation_tab" onclick="renderMainContentView('Customers')">
                    <img src="res/images/icons/customers.png" alt="">
                    <p>Customers</p>
                </div>
                <div class="navigation_tab" onclick="renderMainContentView('Sales')">
                    <img src="res/images/icons/orders.png" alt="">
                    <p>Sales</p>
                </div>
                <div class="navigation_tab" onclick="renderMainContentView('Transactions')">
                    <img src="res/images/icons/transaction.png" alt="">
                    <p>Transactions</p>
                </div>
            </div>
            <div class="management_section">
                <p>Management</p>
                <div class="navigation_tab" onclick="renderMainContentView('Vendors')">
                    <img src="res/images/icons/vendor.png" alt="">
                    <p>Vendors</p>
                </div>
                <div class="navigation_tab" onclick="renderMainContentView('Notifications')">
                    <img src="res/images/icons/notifications.png" alt="">
                    <p>Notifications</p>
                </div>
                <div class="navigation_tab" onclick="renderMainContentView('Reports')">
                    <img src="res/images/icons/report.png" alt="">
                    <p>Reports</p>
                </div>
                <div class="navigation_tab" onclick="renderMainContentView('Settings')">
                    <img src="res/images/icons/settings.png" alt="">
                    <p>Settings</p>
                </div>
            </div>
            <div class="management_section">
                <p>Admin</p>
                <div class="navigation_tab" onclick="renderMainContentView('Account')">
                    <img src="res/images/icons/user.png" alt="">
                    <p>Account</p>
                </div>
                <div class="navigation_tab" onclick="renderMainContentView('Moderators')">
                    <img src="res/images/icons/manager.png" alt="">
                    <p>Moderators</p>
                </div>
            </div>
        </div>
        <div class="contentArea_panel">
            <div class="content_cover">
                <div class="view_title">
                    <h3>Product</h3>
                </div>
                <div class="view_nav_bar">
                    <ul>
                        <li>
                            <button>New Item</button>
                        </li>
                        <li>
                            <button>Delete</button>
                        </li>
                        <li>
                            <button>Update</button>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="product_title">
                <div class="product_Name">
                    <h4>Product Name</h4>
                    <input type="text">
                </div>
                <div class="product_type">
                    <h4>Product Type</h4>
                    <select name="" id="">
                        <option value="Simple">Simple Product</option>
                    </select>
                </div>
            </div>
            <div class="product_form_element">
                <div class="section_navigation">
                    <ul>
                        <li class="high_lighted" onclick="toggle_product_details_section()">Store</li>
                        <li onclick="toggle_product_details_section()" >Wholesale</li>
                        <li onclick="toggle_product_details_section()" >Vehicle</li>
                        <li onclick="toggle_product_details_section()" >Product Details</li>
                    </ul>
                </div>
                <div class="sections_elem">
                    <div class="store_section">
                        <div class="content_product_section">
                            <div class="split_panel">
                                <div class="panel_sections">
                                    <h6>Inventory</h6>
                                    <div class="input_group">
                                        <div class="input_element">
                                            <p>Current Stock</p>
                                            <input type="text">
                                        </div>
                                        <div class="input_element">
                                        <p>Low Stock</p>
                                            <input type="text">
                                        </div>
                                        <div class="input_element">
                                        <p>Suppliers</p>
                                            <input type="text">
                                        </div>
                                    </div>
                                </div>
                                <div class="panel_sections">
                                    <h6>Grouping</h6>
                                    <div class="input_group">
                                        <div class="input_element">
                                            <p>Category</p>
                                            <textarea name="" id="" cols="30" rows="10"></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="split_panel">
                                <div class="panel_sections">
                                    <h6>Price</h6>
                                    <div class="input_group">
                                        <div class="input_element">
                                            <p>Regular Price</p>
                                            <input type="text">
                                        </div>
                                        <div class="input_element">
                                            <p>Sale Price</p>
                                            <input type="text">
                                        </div>
                                        <div class="input_element">
                                            <p>Included Tax</p>
                                            <input type="text">
                                        </div>
                                    </div>
                                </div>
                                <div class="panel_sections">
                                <h6>Grouping</h6>
                                    <div class="input_group">
                                        <div class="input_element">
                                            <p>Tags</p>
                                            <textarea name="" id="" cols="30" rows="10"></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="wholesale_section">
                        <div class="content_product_section">
                            <div class="split_panel">
                                <div class="panel_sections">
                                    <h6>Inventory</h6>
                                    <div class="input_group">
                                        <div class="input_element">
                                            <p>Current Stock</p>
                                            <input type="text">
                                        </div>
                                        <div class="input_element">
                                        <p>Low Stock</p>
                                            <input type="text">
                                        </div>
                                        <div class="input_element">
                                        <p>Suppliers</p>
                                            <input type="text">
                                        </div>
                                    </div>
                                </div>
                                <div class="panel_sections">
                                    <h6>Grouping</h6>
                                    <div class="input_group">
                                        <div class="input_element">
                                            <p>Category</p>
                                            <textarea name="" id="" cols="30" rows="10"></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="split_panel">
                                <div class="panel_sections">
                                    <h6>Price</h6>
                                    <div class="input_group">
                                        <div class="input_element">
                                            <p>Regular Price</p>
                                            <input type="text">
                                        </div>
                                        <div class="input_element">
                                            <p>Sale Price</p>
                                            <input type="text">
                                        </div>
                                        <div class="input_element">
                                            <p>Included Tax</p>
                                            <input type="text">
                                        </div>
                                    </div>
                                </div>
                                <div class="panel_sections">
                                <h6>Grouping</h6>
                                    <div class="input_group">
                                        <div class="input_element">
                                            <p>Tags</p>
                                            <textarea name="" id="" cols="30" rows="10"></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="vehicle_section">
                        <div class="content_product_section">
                            <div class="split_panel">
                                <div class="panel_sections">
                                    <h6>Inventory</h6>
                                    <div class="input_group">
                                        <div class="input_element">
                                            <p>Current Stock</p>
                                            <input type="text">
                                        </div>
                                        <div class="input_element">
                                        <p>Low Stock</p>
                                            <input type="text">
                                        </div>
                                        <div class="input_element">
                                        <p>Suppliers</p>
                                            <input type="text">
                                        </div>
                                    </div>
                                </div>
                                <div class="panel_sections">
                                    <h6>Grouping</h6>
                                    <div class="input_group">
                                        <div class="input_element">
                                            <p>Category</p>
                                            <textarea name="" id="" cols="30" rows="10"></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="split_panel">
                                <div class="panel_sections">
                                    <h6>Price</h6>
                                    <div class="input_group">
                                        <div class="input_element">
                                            <p>Regular Price</p>
                                            <input type="text">
                                        </div>
                                        <div class="input_element">
                                            <p>Sale Price</p>
                                            <input type="text">
                                        </div>
                                        <div class="input_element">
                                            <p>Included Tax</p>
                                            <input type="text">
                                        </div>
                                    </div>
                                </div>
                                <div class="panel_sections">
                                <h6>Grouping</h6>
                                    <div class="input_group">
                                        <div class="input_element">
                                            <p>Tags</p>
                                            <textarea name="" id="" cols="30" rows="10"></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="product_section">
                        <div class="content_product_section">
                            <div class="split_section2">
                                <div class="panel_sections">
                                    <h6>Price</h6>
                                    <div class="input_group">
                                        <div class="input_element">
                                            <p>Added By</p>
                                            <input type="text">
                                        </div>
                                        <div class="input_element">
                                            <p>Date Added</p>
                                            <input type="text">
                                        </div>
                                        <div class="input_element">
                                            <p>Modified By</p>
                                            <input type="text">
                                        </div>
                                        <div class="input_element">
                                            <p>Date Modified</p>
                                            <input type="text">
                                        </div>
                                        <div class="input_element">
                                            <p>Mod. Details</p>
                                            <textarea name="" id="" cols="30" rows="5"></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="split_section2">
                                <div class="panel_sections">
                                    <h6>Price</h6>
                                    <div class="input_group">
                                        <div class="input_element">
                                            <p>Visibility</p>
                                            <select name="" id="">
                                                <option value="Visible">Visible</option>
                                                <option value="Invisible">Invisible</option>
                                            </select>
                                        </div>
                                        <div class="input_element">
                                            <p>Enable Edit</p>
                                            <select name="" id="">
                                                <option value="Enable">Enabled</option>
                                                <option value="Disable">Disable</option>
                                            </select>
                                        </div>
                                        <div class="input_element">
                                            <p>Modified By</p>
                                            <textarea class="product_notes" name="" id="" cols="30" rows="10"></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
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
