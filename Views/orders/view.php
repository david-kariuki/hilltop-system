<?php
require_once $_SERVER['DOCUMENT_ROOT']."/app/php/Modal.php";

$order_count = 0;




$table = "tbl_orders";
$fields = array(
    "*",
);
$order_by = "date_created";
$order_set = "DESC";
$offset = 0;
$reference = array(
    "statement" => "Email = ?",
    "type"=>"s",
    "values"=>[
        $_SESSION['LOGGED_USER']
    ]
);

$response = $admin->database_read_by_ref($table,$fields,$order_by,$order_set,$offset,null);
// $fields = "*";
// $response2 = $admin->database_read_all($table,$fields,$order_by);
// $order_count= 0;

if($response['status']){
    // var_dump($response);
    $order_count = count($response['response']);
    // var_dump($order_count);
    // var_dump($response['response']);
    $order = $response['response'];
}else{
    //no records found
}

?>

<div class="content_cover">
    <div class="view_title">
        <h3>Order</h3>
    </div>
    <div class="view_nav_bar">
        <ul>
            <li>
                <button onclick="open_order_form();">New Order</button>
            </li>
            <li>
            <select name="" id="">
                    <option value="QuickReports">Remove Filters</option>
                    <option value="List">Apply Filters</option>
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
            <input type="Search" onkeyup="search_order()" placeholder="Search order by ID">
        </div>
    </div>
    <!-- <div class="view_nav_bar filter_area">
    </div> -->
    <div class="items_area">
        <table>
            <thead>
                <tr >
                    <th  scope="col"> <div class="check_element"><input type="checkbox"></div> </th>
                    <th scope="col">#</th>
                    <th scope="col">Order ID</th>
                    <th scope="col">Date Created</th>
                    <th scope="col">Amount</th>
                    <th scope="col">Quantity</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if($order_count> 0){
                    foreach ($order as $key => $value) {
                ?>
                        <tr onclick="open_order_form(<?php echo '\''.$value['UUID'].'\'' ?>);" >
                            <td onclick="open_order_form();" ><div class="check_element"><input type="checkbox"></div></td>
                            <td><?php echo ($key + 1)?></td>
                            <td class="sale_ID" ><?php echo $value['UUID'] ?></td>
                            <td><?php echo $value['date_created'] ?></td>
                            <td><?php echo $value['Amount'] ?></td>
                            <td><?php echo $value['Quantity'] ?></td> 
                        </tr>
                <?php
                    }
                }else{
                    echo "No records found";
                }
                ?>
            </tbody>
        </table>
    </div>
    <div class="pagination">
        <ul>
            <?php
                $page_count = floor($order_count/ SPLITTER);
                $rem = $order_count% SPLITTER;

                if($rem > 0){
                    $page_count = $page_count + 1;
                }

                // var_dump($page_count,$rem);

                if($page_count>1){
                    ?>
                    <li id="previous_pagination" onclick="previous_page_Sale()"> <p>Prev</p> </li>
                        <?php
                            for($i = 1;$i <= $page_count;$i++){
                        ?>
                                <li <?php if($i == 1){ echo "data-activePage=true class='active_page'";} ?>  onclick="change_page_Sale(<?php echo $i ?>)"> <p><?php echo $i ?></p> </li>
                        <?php
                            }
                        ?>
                    <li class="next_pagination" onclick="next_page_Sale()"> <p>Next</p> </li>
                    <?php
                }
            ?>
            
        </ul>
    </div>
</div>

<!-- echo $value['saleType']  -->