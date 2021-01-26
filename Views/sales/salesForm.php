<?php
require_once $_SERVER['DOCUMENT_ROOT']."/app/php/Modal.php";
session_start();

$mode = null;
$user = null;

if(isset($_REQUEST['data'])){
    $mode = "update";
    $update = false;
    $sale = null;
    $products = null;

    $fields = array(
        "*",
    );
    $table = 'tbl_sale';
    $order_by = "sale_ID";
    $order_set = "ASC";
    $offset = 0;
    $reference = array(
        "statement" => "sale_ID = ?",
        "type"=>"i",
        "values"=>[
            $_REQUEST['data']
        ]
    );

    $response = $admin->database_read_by_ref($table,$fields,$order_by,$order_set,$offset,$reference);

    if($response['status']){
        $update = true;
        $sale = $response['response'][0];

        // var_dump($sale);

        $fields = array(
            "*",
        );
        $table = 'tbl_subsale';
        $order_by = "UUID";
        $order_set = "DESC";
        $offset = 0;
        $reference = array(
            "statement" => "fk_SaleID = ?",
            "type"=>"i",
            "values"=>[
                $_REQUEST['data']
            ]
        );

        $response2 = $admin->database_read_by_ref($table,$fields,$order_by,$order_set,$offset,$reference);

        if($response2['status']){
            $products = $response2['response'];
        }else{
            exit();
        }
    }else{
        exit();
    }
}
?>
<div class="content_cover sale_element">
    <div class="view_title">
        <h3>Sale</h3>
    </div>
    <div class="view_nav_bar">
        <ul>
            <li>
                <button onclick="create_new_sale(true)" >New Sale</button>
            </li>
            <!-- <li>
                <select name="" id="">
                    <option value="QuickReports">Enable Edit</option>
                    <option value="List">Disable Edit</option>
                </select>
            </li> -->
        </ul>
        <div class="element_search">
            <input type="Search">
        </div>
    </div>
    <div class="sale_customer_panel">
        <div class="customer_panel">
            <div>
                <h3>Customer Details</h3>
            </div>
            <div class="items_panel">
                <div class="section1">
                    <div class="input_area">
                        <h4>Customer</h4>
                        <input type="text" value="<?php echo $sale['fk_customer'];  ?>">
                    </div>
                    <div class="input_area">
                        <h4>Customer Tel</h4>
                        <input type="text" value="<?php echo $sale['customerTel'];  ?>">
                    </div>
                </div>
                <div class="section2">
                    <div class="input_area">
                        <h4>Customer</h4>
                        <textarea name="" id="" cols="30" rows="10"><?php echo $sale['deliverAddress'];  ?></textarea>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="sales_panel">
            <div>
                <h3>Sales Details</h3>
            </div>
            <div class="items_panel">
            <div class="section1">
                    <div class="input_area">
                        <h4>Sale ID</h4>
                        <input type="text" value="<?php echo $sale['sale_ID'];  ?>">
                    </div>
                    <div class="input_area">
                        <h4>Date</h4>
                        <input type="text" value="<?php echo $sale['dateCreated'];  ?>">
                    </div>
                </div>
                <div class="section2">
                <div class="input_area">
                        <h4>Sale Representative</h4>
                        <input type="text" value="<?php echo $sale['fk_saleRep'];  ?>">
                    </div>
                    <div class="input_area">
                        <h4>Sale Type</h4>
                        <input type="text" value="<?php if((int)$sale['saleType'] == 1){
                            echo "Retail";
                        } else if((int)$sale['saleType']){
                            echo "Wholesale";
                        }else{
                            echo "Vehicle";
                        }  ?>">
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
                        <th scope="col">#</th>
                        <th scope="col">Product Name</th>
                        <th scope="col">Quantity</th>
                        <th scope="col">Price</th>
                        <th scope="col">Sub Total</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                $i = 0;
                $productName = null;
                foreach ($products as $key => $value) {    
                    $fields = array(
                        "*",
                    );
                    $table = 'tbl_inventory';
                    $order_by = "UUID";
                    $order_set = "DESC";
                    $offset = 0;
                    $reference = array(
                        "statement" => "UUID = ?",
                        "type"=>"i",
                        "values"=>[
                            $value['fk_productID']
                        ]
                    );
            
                    $response2 = $admin->database_read_by_ref($table,$fields,$order_by,$order_set,$offset,$reference);
            
                    if($response2['status']){
                        $fields = array(
                            "*",
                        );
                        $table = ' tbl_products';
                        $order_by = "UUID";
                        $order_set = "DESC";
                        $offset = 0;
                        $reference = array(
                            "statement" => "UUID = ?",
                            "type"=>"i",
                            "values"=>[
                                $response2['response'][0]['fk_productID']
                            ]
                        );
    
                        // echo $value['fk_productID'];
                
                        $response2 = $admin->database_read_by_ref($table,$fields,$order_by,$order_set,$offset,$reference);

                        if($response2['status']){
                            $productName = $response2['response'][0]['productName'];
                        }else{
                            exit();
                        }
                    }else{
                        exit();
                    }            
                ?>
                    <tr>
                        <td><?php echo ($i + 1)?></td>
                        <td><?php echo $productName ?></td>
                        <td><?php echo $value['quantity'] ?></td>
                        <td><?php echo $value['Price'] ?></td>
                        <td><?php echo $value['subTotal'] ?></td>
                    </tr>
                <?php
                $i++;
                }
                ?>
                </tbody>
            </table>
            <div class="sale_note_element">
                <h5>Sales Note</h5>
                <textarea name="" id="" cols="30" rows="10"><?php echo $sale['saleNote']; ?></textarea>
            </div>
        </div>
        <div class="sales_complete_tally">
            <div class="tally_item">
                <h6>Quantity</h6>
                <p><?php echo $sale['saleQuantity']; ?></p>
            </div>
            <div class="tally_item">
                <h6>Amount</h6>
                <p><?php echo "KSh".$sale['amount']; ?></p>
            </div>
            <div class="total_sale_amount">
                <h6>Total Amount</h6>
                <p><?php echo "KSh".$sale['amount']; ?></p>
            </div>
            <div class="action_button_elements">
                <button class="btn_action_sale btn_sale_actions" onclick="open_right_panel();">View Transactions</button>
            </div>
        </div>
        
        
    </div>
</div>
