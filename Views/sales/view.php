<?php
require_once $_SERVER['DOCUMENT_ROOT']."/app/php/Modal.php";

$table = "tbl_sale";
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

$response = $admin->database_read_by_ref($table,$fields,$order_by,$order_set,$offset,null);
$fields = "*";
$response2 = $admin->database_read_all($table,$fields,$order_by);
$sale_count = 0;

if($response['status']){
    $sales = $response['response'];
    $sale_count = count($response2);
    $products = $response['response'];
}else{
}

?>

<div class="content_cover">
    <div class="view_title">
        <h3>Sales</h3>
    </div>
    <div class="view_nav_bar">
        <ul>
            <li>
                <button onclick="create_new_sale(true)">New Sale</button>
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
            <input type="Search">
        </div>
    </div>
    <div class="view_nav_bar filter_area">
    </div>
    <div class="items_area">
        <table>
            <thead>
                <tr >
                    <th  scope="col"> <div class="check_element"><input type="checkbox"></div> </th>
                    <th scope="col">#</th>
                    <th scope="col">Sale ID</th>
                    <th scope="col">Sale Type</th>
                    <th scope="col">Sale Value</th>
                    <th scope="col">Sale Quantity</th>
                    <th scope="col">Sale Date</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if($sale_count > 0){
                    foreach ($sales as $key => $value) {
                ?>
                        <tr onclick="open_selected_sale('salesForm')">
                            <td onclick="select_current_sale();" ><div class="check_element"><input type="checkbox"></div></td>
                            <td><?php echo ($key + 1)?></td>
                            <td class="sale_ID" ><?php echo $value['sale_ID'] ?></td>
                            <td><?php
                                    if($value['saleType'] == 1){
                                        echo "Retail";
                                    } else if($value['saleType'] == 2) {
                                        echo "Wholesale";
                                    }else{
                                        echo "Vehicle";
                                    }
                                ?></td>
                            <td><?php echo $value['amount'] ?></td>
                            <td><?php echo $value['saleQuantity'] ?></td>
                            <td><?php echo $value['dateCreated'] ?></td> 
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
                $page_count = floor($sale_count / SPLITTER);
                $rem = $sale_count % SPLITTER;

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