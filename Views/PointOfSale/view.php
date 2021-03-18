<?php
require_once $_SERVER['DOCUMENT_ROOT']."/app/php/Modal.php";

$fields = array(
    "*",
);
$table = TABLE_USERS["NAME"];
$order_by = "firstName";
$order_set = "ASC";
$offset = 0;
$reference = array(
    "statement" => "Email = ?",
    "type"=>"i",
    "values"=>[
        $_SESSION['LOGGED_USER']
    ]
);

$response = $admin->database_read_by_ref($table,$fields,$order_by,$order_set,$offset,$reference);

if($response['status']){
    $users = $response['response'];
    $user = null;

    foreach ($users as $key => $value) {
        $this_user = $value['Email'];

        if($this_user == $_SESSION['LOGGED_USER']){
            $user = $value['userName'];
        }
    }
}else{
    echo " Error retrieving data";
}

?>
<div class="content_cover">
    <div class="view_title">
        <h3>P.O.S</h3>
    </div>
    <div class="view_nav_bar">
        <ul>
            <li>
                <button onclick="create_new_sale()">New Sale</button>
            </li>
        </ul>
    </div>
    <div class="sale_customer_panel">
        <!-- <div class="customer_panel">
            <div>
                <h3>Customer Details</h3>
            </div>
            <div class="items_panel">
                <div class="section1">
                    <div class="input_area">
                        <h4>Customer</h4>
                        <input type="text">
                    </div>
                    <div class="input_area">
                        <h4>Customer Tel</h4>
                        <input type="text">
                    </div>
                </div>
                <div class="section2">
                    <div class="input_area">
                        <h4>Address</h4>
                        <textarea name="" id="" cols="30" rows="10"></textarea>
                    </div>
                </div>
            </div>
        </div> -->
        
        <div class="sales_panel">
            <div>
                <h3>Sales Details</h3>
            </div>
            <div class="items_panel">
            <div class="section1">
                    <div class="input_area">
                        <h4>Sale ID</h4>
                        <input type="text" disabled>
                    </div>
                    <div class="input_area">
                        <h4>Date</h4>
                        <input type="text" disabled value="<?php echo date("Y/m/d") ?>">
                    </div>
                </div>
                <div class="section2">
                <div class="input_area">
                        <h4>Sale Representative</h4>
                        <input type="text" disabled value="<?php if(isset($user)){echo $user;}?>">
                    </div>
                    <div class="input_area">
                        <h4>Sale Type</h4>
                        <select name="saleType" id="">
                            <option value="1">Retail</option>
                            <option value="2">Wholesale</option>
                            <option value="3">Vehicle</option>
                        </select>
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
                        <th scope="col">Price</th>
                        <th scope="col">Sub Total</th>
                        <th scope="col">#</th>
                        
                    </tr>
                </thead>
                <tbody class="table_body">
                <?php

                    for($i = 0; $i < 1; $i++){
                        ?>
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
                        <td style="width: 40px;"><input type="number" name="quantity" value="0" onchange="find_sub_total()" min=0></td>
                        <td class="sub_price">0</td>
                        <td class="sub_total">0</td>
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
                <p id="quantity">0</p>
            </div>
            <div class="tally_item">
                <h6>Amount</h6>
                <p id="amount">0</p>
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
                <p id="totalAmount">0</p>
            </div>
            <div class="action_button_elements">
                <button class="btn_action_sale btn1" onclick="confirm_sale()">Confirm Sale</button>
                <button class="btn_action_sale btn2" onclick="make_payment()">Make Payment</button>
                <button class="btn_action_sale btn3" onclick="create_new_sale()" >Cancel Sale</button>
                <button class="btn_action_sale btn4" onclick="view_transactions()">View Transactions</button>
            </div>
        </div>
        
        
    </div>
</div>
