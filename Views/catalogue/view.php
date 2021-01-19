<?php

require_once $_SERVER['DOCUMENT_ROOT']."/app/php/modal.php";


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

if($response['status']){
    $products = $response['response'];
}else{
    exit();
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
                ?>
            </tbody>
        </table>
    </div>
    <div class="pagination">
        <ul>
            <li id="previous_pagination"> <p>Prev</p> </li>
            <li> <p>1</p> </li>
            <li> <p>2</p> </li>
            <li class="next_pagination"> <p>Next</p> </li>
        </ul>
    </div>
</div>