<?php
require_once $_SERVER['DOCUMENT_ROOT']."/app/php/Modal.php";
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$data = $_REQUEST['loadingData'];
$mode = null;
$order;
$sub_orders;

if(isset($data) && $data == "new"){
    $mode = $data;
}else{
    $mode = "update";
}

$table = "tbl_users";
$fields = array(
    "*",
);
$order_by = "userName";
$order_set = "DESC";
$offset = 0;
$reference = array(
    "statement" => "Email = ?",
    "type"=>"s",
    "values"=>[
        $_SESSION['LOGGED_USER']
    ]
);

$user = $admin->database_read_by_ref($table,$fields,$order_by,$order_set,$offset,$reference);
$user = $user['response'][0]['userName'];



$fields = array(
    "*",
);
$table = "tbl_orders";
$order_by = "UUID";
$order_set = "ASC";
$offset = 0;
$reference = array(
    "statement" => "UUID = ?",
    "type"=>"i",
    "values"=>[
        $_REQUEST['data']
    ]
);

$response = $admin->database_read_by_ref($table,$fields,$order_by,$order_set,$offset,$reference);

if($response['status']){
    $order = $response['response'][0];
    // var_dump($order);

    $fields = array(
        "*",
    );
    $table = "tbl_suborders";
    $order_by = "UUID";
    $order_set = "ASC";
    $offset = 0;
    $reference = array(
        "statement" => "fk_OrderID = ?",
        "type"=>"i",
        "values"=>[
            $_REQUEST['data']
        ]
    );
    
    $response2 = $admin->database_read_by_ref($table,$fields,$order_by,$order_set,$offset,$reference);

    if($response2['status']){
        // var_dump($response2);
        $sub_orders = $response2['response'];
    }else{
        // var_dump($response2);
    }
}else{
    // var_dump($response);
}


?>
<div class="content_cover">
    <div class="view_title">
        <h3>Order</h3>
    </div>
    <div class="view_nav_bar">
        <ul>
            <li>
                <button onclick="open_order_form()">New Order</button>
            </li>
        </ul>
    </div>
    <div class="sale_customer_panel">
        <div class="customer_panel">
            <div>
                <h3>Merchant Details</h3>
            </div>
            <div class="items_panel">
                <div class="section1">
                    <div class="input_area">
                        <h4>Name</h4>
                        <input type="text" name="merchant_name" value="<?php if($mode == "update"){
                                                                                echo $order['Merchant'];
                                                                            } ?>">
                    </div>
                    <div class="input_area">
                        <h4>Merchant Tel</h4>
                        <input type="text" name="merchant_number" value="<?php if($mode == "update"){
                                                                                echo $order['Merchant_Tel'];
                                                                            } ?>"> 
                    </div>
                </div>
                <div class="section2">
                    <div class="input_area">
                        <h4>Address</h4>
                        <textarea name="merchant_address" id="" cols="30" rows="10"><?php if($mode == "update"){
                                                                                                echo $order['Merchant_Address'];
                                                                                            } ?></textarea>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="sales_panel">
            <div>
                <h3>Order Details</h3>
            </div>
            <div class="items_panel">
            <div class="section1">
                    <div class="input_area">
                        <h4>Order ID</h4>
                        <input type="text" disabled value="<?php if($mode == "update"){
                                                                                echo $order['UUID'];
                                                                            } ?>">
                    </div>
                    <div class="input_area">
                        <h4>Date</h4>
                        <input type="text" disabled value="<?php if($mode == "update"){
                                                                                echo $order['date_created'];
                                                                            } ?>">
                    </div>
                </div>
                <div class="section2">
                <div class="input_area">
                        <h4>Order By</h4>
                        <input type="text" disabled value="<?php if(isset($user)){echo $user;}?>">
                    </div>
                    <div class="input_area">
                        <h4>Confirmed By</h4>
                        <input type="text" disabled value="<?php if(isset($user)){echo $user;}?>">
                    </div>
                </div>
            </div>
        </div>
        
        
    </div>
    <div class="sale_details_list">
        <div class="items_area">
            <table>
                <thead>
                    <tr>
                        <th scope="col">Product Name</th>
                        <th scope="col">Quantity</th>
                        <th scope="col">Sub Total</th>
                        <th scope="col">Price</th>
                        <th scope="col">#</th>
                        
                    </tr>
                </thead>
                <tbody class="table_body">
                <?php
                if($mode == "update"){
                    foreach ($sub_orders as $key => $value) {
                        ?>
                    <tr>
                                <?php
                                        $fields = array(
                                        "*",
                                    );
                                    $table = "tbl_products";
                                    $order_by = "UUID";
                                    $order_set = "ASC";
                                    $offset = 0;
                                    $reference = array(
                                        "statement" => "UUID = ?",
                                        "type"=>"i",
                                        "values"=>[
                                            $value['fk_ProductID']
                                        ]
                                    );
                                    
                                    $response4 = $admin->database_read_by_ref($table,$fields,$order_by,$order_set,$offset,$reference);
                                    
                                ?>
                        <td class="item_select" data-uuid="unidentified">
                            <input type="text" onfocus="display_item_lister_select()" onfocusOut="hide_item_lister_select()" onkeyup="get_order_product()" name="productName" autocomplete="off" value="<?php if($mode == "update"){ echo $response4['response'][0]['productName']; }?>">
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
                        <td style="width: 40px;"><input type="number" name="quantity" min=0 onchange="evaluate_sub_order()" value="<?php if($mode == "update"){echo $value['Quantity']; } else{ echo 0; }?>"></td>
                        <td class="sub_total"><input type="number" name="subtotal" min=0 onchange="evaluate_sub_order()" value="<?php if($mode == "update"){ echo $value['Price'] ;} else{ echo 0; }?>" ></td>
                    <td class="sub_price"><?php if($mode == "update"){ echo ($value['Price'])/$value['Quantity'];}else{ echo 0;} ?></td>
                        <td class="cancel_button" onclick="remove_selected_item()"><p>X</p></td>
                    </tr>
                    <?php
                    }
                    }else{
                        ?>
                    <tr>
                        <td class="item_select" data-uuid="unidentified">
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
                        <td style="width: 40px;"><input type="number" name="quantity" min=0 onchange="evaluate_sub_order()" value="<?php if($mode == "update"){echo $value['Quantity']; } else{ echo 0; }?>"></td>
                        <td class="sub_total"><input type="number" name="subtotal" min=0 onchange="evaluate_sub_order()" value="<?php if($mode == "update"){ echo $value['Price'] ;} else{ echo 0; }?>" ></td>
                        <td class="sub_price"><?php if($mode == "update"){echo 2;}else{ echo 0;} ?></td>
                        <td class="cancel_button" onclick="remove_selected_item()"><p>X</p></td>
                    </tr>
                        <?php
                    }?>
                </tbody>
            </table>
            <div class="sale_note_element">
                <h5>Sales Note</h5>
                <textarea name="saleNote" id="" cols="30" rows="10"></textarea>
            </div>
        </div>
        <div class="sales_complete_tally">
            <div class="tally_item">
                <h6>Quantity</h6>
                <p id="quantity">
                <?php
                if($mode == "update"){
                    echo $order['Quantity'];
                }else{
                    echo 0;
                }
                ?>
                </p>
            </div>
            <div class="tally_item">
                <h6>Amount</h6>
                <p id="amount">
                <?php
                if($mode == "update"){
                    echo $order['Amount'];
                }else{
                    echo 0;
                }
                ?>
                </p>
            </div>
            <!-- <div class="items_discount">
                <h6>Discount</h6>
                <div class="discount_option">
                    <input type="text" placeholder="Ksh">
                    <input type="text" placeholder="%">
                </div>
            </div> -->
            <div class="total_sale_amount">
                <h6>Total Amount</h6>
                <p id="totalAmount">
                <?php
                if($mode == "update"){
                    echo $order['Amount'];
                }else{
                    echo 0;
                }
                ?>
                </p>
            </div>
            <div class="action_button_elements">
                    <?php
                    if($mode == "new"){
                    ?>
                    <button class="btn_action_sale btn1" onclick="Make_Order()">Make Order</button>
                    <?php
                    }
                    ?>

                    <?php
                    if($mode != "new"){
                        ?>
                        <!-- <button class="btn_action_sale btn4" onclick="Confirm_Order()">Confirm Order</button> -->
                        <?php
                    }
                    ?>
            </div>
        </div>
        
        
    </div>
</div>
