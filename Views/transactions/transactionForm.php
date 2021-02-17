<?php

require_once $_SERVER['DOCUMENT_ROOT']."/app/php/Modal.php";
session_start();

$loadingData = $_REQUEST['loadingData'];
$mode = "update";
$transaction = null;

if(isset($_REQUEST['id'])){
    $transaction_ID = $_REQUEST['id'];

    $fields = array(
        "*",
    );
    $table = 'tbl_transaction';
    $order_by = "UUID";
    $order_set = "ASC";
    $offset = 0;
    $reference = array(
        "statement" => "UUID = ?",
        "type"=>"i",
        "values"=>[
            $transaction_ID
        ]
    );

    $response = $admin->database_read_by_ref($table,$fields,$order_by,$order_set,$offset,$reference);

    if($response['status']){
        $transaction = $response['response'][0];
        
    }else{
        return;
    }
}
?>
<div class="content_cover">
    <div class="view_title">
        <h3>Transactions</h3>
    </div>
    <div class="view_nav_bar">
        <ul>
            <li>
                <button>New Transaction</button>
            </li>
            <li>
                <button>Delete</button>
            </li>
            <li>
                <button>Update</button>
            </li>
            <li>
            <select name="" id="">
                    <option value="QuickReports">Quick Reports</option>
                    <option value="List">List</option>
                </select>
            </li>
            <li>
                <select name="" id="">
                    <option value="QuickReports">Quick Reports</option>
                    <option value="List">List</option>
                </select>
            </li>
        </ul>
        <div class="element_search">
            <input type="Search">
        </div>
    </div>
    <div class="items_area items_area_transactions">
        <div class="elemental_transaction">
            <div class="left_panel">
                <h6>Transaction Details</h6>
                <div class="input_group">
                    <div class="input_element">
                        <p>Transaction ID</p>
                        <input type="text" value="<?php echo $transaction['UUID'] ?>">
                    </div>
                    <div class="input_element">
                        <p>Customer</p>
                        <input type="text" value="<?php echo $transaction['fk_customerReference'] ?>">
                    </div>
                    <div class="input_element">
                        <p>Sale ID</p>
                        <input type="text" value="<?php echo $transaction['fk_saleReference'] ?>">
                    </div>
                    <div class="input_element">
                        <p>Date Created</p>
                        <input type="text" value="<?php echo $transaction['dateCreated'] ?>">
                    </div>
                </div>
                <h6>Payment Details</h6>
                <div class="input_group">
                    <div class="input_element">
                        <p>Payment Method</p>
                        <input type="text" value="<?php echo $transaction['transactionMethode'] ?>">
                    </div>
                    <div class="input_element">
                        <p>Amount Payed</p>
                        <input type="text" value="<?php echo $transaction['transactionValue'] ?>">
                    </div>

                </div>
            </div>
            <div class="right_panel">
                <h6>Related Transactions</h6>
                <div class="related_transaction_panel">
                    <div class="items_area">
                        <table>
                            <thead>
                                <tr>
                                    
                                    <th scope="col">#</th>
                                    <th scope="col">Transaction ID</th>
                                    <th scope="col">Customer Ref</th>
                                    <th scope="col">Sale Ref</th>
                                    
                                    <th scope="col">Transaction Value</th>
                                    
                                    
                                </tr>
                            </thead>
                            <tbody>
                            <?php
                            $fields = array(
                                "*",
                            );
                            $table = 'tbl_transaction';
                            $order_by = "UUID";
                            $order_set = "ASC";
                            $offset = 0;
                            $reference = array(
                                "statement" => "fk_saleReference = ?",
                                "type"=>"i",
                                "values"=>[
                                    $transaction['fk_saleReference']
                                ]
                            );
                        
                            $response1 = $admin->database_read_by_ref($table,$fields,$order_by,$order_set,$offset,$reference);

                            if($response1['status'] && count($response1['response']) > 1){
                                $count = 1;
                                $other_transactions = $response1['response'];

                                foreach ($other_transactions as $key => $value) {
                                    
                                    if($value['UUID'] == $transaction_ID){
                                        continue;
                                    }else{
                                        ?>
                                        <tr>
                                            <td><?php echo $count?></td>
                                            <td><?php echo $value['UUID'] ?></td>
                                            <td><?php echo $value['fk_customerReference'] ?></td>
                                            <td><?php echo $value['fk_saleReference'] ?></td>
                                            <td><?php echo $value['transactionValue'] ?></td>
                                        </tr>
                                        <?php
                                        $count++;
                                    }
                                }

                            }else{
                                ?>
                                <p>No records found</p>
                                <?php
                            }
                            ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>




    