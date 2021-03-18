<?php
require_once $_SERVER['DOCUMENT_ROOT']."/app/php/Modal.php";

$table = "tbl_transaction";
$fields = array(
    "*",
);
$order_by = "dateCreated";
$order_set = "DESC";
$offset = 0;
$reference = array(
    "statement" => "Email = ?",
    "type"=>"s",
    "values"=>[
        $_SESSION['LOGGED_USER']
    ]
);
$transactions = null;

$response = $admin->database_read_by_ref($table,$fields,$order_by,$order_set,$offset,null);

if($response['status']){
    $transactions = $response['response'];
}else{
}

?>
<div class="content_cover">
    <div class="view_title">
        <h3>Transactions</h3>
    </div>
    <div class="view_nav_bar">
        <ul>
            <li>
                <button onclick="renderMainContentView('PointOfSale')" >New Sale</button>
            </li>
            <li>
                <button onclick="renderMainContentView('Sales')">View Sales</button>
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
    <div class="items_area">
        <table>
            <thead>
                <tr>
                    <th scope="col"> <div class="check_element"><input type="checkbox"></div> </th>
                    <th scope="col">#</th>
                    <th scope="col">Transaction ID</th>
                    <th scope="col">Sale Ref</th>
                    <th scope="col">Type</th>
                    <th scope="col">Transaction Value</th>
                    <th scope="col">Category</th>
                    
                </tr>
            </thead>
            <tbody>
                <?php
                $count = 1;
                if($transactions == null){
                    ?>
                    <p>No records</p>
                    <?php
                }else{
                    foreach ($transactions as $key => $value) {
                    ?>  
                    
                        <tr onclick="open_selected_transaction('transactionForm','<?php echo $value['UUID'] ?>')">
                            <td onclick="select_current_transaction('<?php echo $value['UUID'] ?>');"><div class="check_element"><input type="checkbox"></div></td>
                            <td><?php echo $count?></td>
                            <td><?php echo $value['UUID'] ?></td>
                            <td><?php echo $value['fk_saleReference'] ?></td>
                            <td><?php echo $value['transactionMethode'] ?></td>
                            <td><?php echo $value['transactionValue'] ?></td>
                            <td><?php echo $value['category'] ?></td>
                        </tr>
                    <?php
                    }
                }
                ?>

            </tbody>
        </table>
    </div>
    <!-- <div class="pagination">
        <ul>
            <li id="previous_pagination"> <p>Prev</p> </li>
            <li> <p>1</p> </li>
            <li> <p>2</p> </li>
            <li class="next_pagination"> <p>Next</p> </li>
        </ul>
    </div> -->
</div>