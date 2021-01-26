<?php

require_once $_SERVER['DOCUMENT_ROOT']."/app/php/Modal.php";


$user;
$table = "tbl_products";
$fields = array(
    "*",
);
$order_by = "productName";
$order_set = "ASC";
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
$product_count = 0;

if($response['status']){
    $product_count = count($response2);
    $products = $response['response'];
}

?>



<div class="content_cover">
    <div class="view_title">
        <h3>Catalogue</h3>
    </div>
    <div class="view_nav_bar">
        <ul>
            <li>
                <button onclick="open_new_product('catalogueForm')">New Item</button>
            </li>
            <li>
                <button>Delete</button>
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
                    <th scope="col">Product ID</th>
                    <th scope="col">Product Name</th>
                    <th scope="col">Product Type</th>
                    <th scope="col">Visibility</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    $count = 1;

                    if($product_count > 0 ){
                        foreach ($products as $key => $value) {
                            
                        
                    ?>
                            <tr onclick="open_selected_product('catalogueForm',<?php echo $value['UUID'] ?>)">
                                <td onclick="select_current_product();"><div class="check_element"><input type="checkbox"></div></td>
                                <td><?php echo $count?></td>
                                <td><?php echo $value['UUID']?> </td>
                                <td><?php echo $value['productName']?></td>
                                <td><?php echo $value['productType']?></td>
                                <td><?php echo $value['visibility']?></td>
                            </tr>
                    <?php
                            $count++;
                        }
                    }else{
                        echo "No records Found";
                    }
                ?>
            </tbody>
        </table>
    </div>
    <div class="pagination">
        <ul>
            <?php
                $page_count = floor($product_count / SPLITTER);
                $rem = $product_count % SPLITTER;

                if($rem > 0){
                    $page_count = $page_count + 1;
                }

                // var_dump($page_count,$rem);

                if($page_count>1){
                    ?>
                    <li id="previous_pagination" onclick="previous_page_catalogue()"> <p>Prev</p> </li>
                        <?php
                            for($i = 1;$i <= $page_count;$i++){
                        ?>
                                <li <?php if($i == 1){ echo "data-activePage=true class='active_page'";} ?>  onclick="change_page_catalogue(<?php echo $i ?>)"> <p><?php echo $i ?></p> </li>
                        <?php
                            }
                        ?>
                    <li class="next_pagination" onclick="next_page_catalogue()"> <p>Next</p> </li>
                    <?php
                }
            ?>
            
        </ul>
    </div>
</div>