<?php
require_once $_SERVER['DOCUMENT_ROOT']."/app/php/modal.php";
session_start();

$mode = "new";
$user = null;

if(isset($_REQUEST['data'])){

    
    $mode = "Create";

    $fields = array(
        "*",
    );
    $table = 'tbl_products';
    $order_by = "productName";
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
        $product = $response['response'][0];

        $mode = "update";

        $fields = array(
            "*",
        );
        $table = 'tbl_inventory';
        $order_by = "fk_storageID";
        $order_set = "ASC";
        $offset = 0;
        $reference = array(
            "statement" => "fk_productID = ?",
            "type"=>"i",
            "values"=>[
                $_REQUEST['data']
            ]
        );
    
        $response = $admin->database_read_by_ref($table,$fields,$order_by,$order_set,$offset,$reference);
        

        if($response['status']){
            $retail = $response['response'][0];
            $wholeSale = $response['response'][1];
            $vehicle = $response['response'][2];
        }
    }
}
?>
<section class="Content">
    <div class="content_cover">
        <div class="view_title">
            <h3>Product</h3>
        </div>
        <div class="view_nav_bar">
            <ul>
                <li>
                    <button onclick="open_selected_product('catalogueForm')">New Item</button>
                </li>
                <li>
                    <button>Delete</button>
                </li>
                <?php
                    if($mode == "update"){
                        ?>
                        <li>
                            <button onclick="update_product(<?php echo $product['UUID'] ?>)">Update</button>
                        </li>
                        <?php
                    } else{
                        ?>
                        <li>
                            <button onclick="create_product()">Create</button>
                        </li>
                        <?php
                    }
                ?>
            </ul>
        </div>
    </div>

    <div class="product_title">
        <div class="product_Name">
            <h4>Product Name</h4>
            <input type="text" name="productName" <?php
                                                                                        if($mode == "update"){
                                                                                            echo "value='".$product['productName']."'";
                                                                                        }
                                                                                    ?>>
        </div>
        <div class="product_type">
            <h4>Product Type</h4>
            <select name="productType" id="">
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
                                    <input type="text" name="retail_currentStock" <?php
                                                                                        if($mode == "update"){
                                                                                            echo "value='".$retail['currentStock']."'";
                                                                                        }
                                                                                    ?>>
                                </div>
                                <div class="input_element">
                                <p>Low Stock</p>
                                    <input type="text" name="retail_lowStockThreshold" <?php
                                                                                        if($mode == "update"){
                                                                                            echo "value='".$retail['lowStockThreashold']."'";
                                                                                        }
                                                                                    ?>>
                                </div>
                                <div class="input_element">
                                <p>Suppliers</p>
                                    <input disabled type="text" name="retail_supplier" <?php
                                                                                        if($mode == "update"){
                                                                                            echo "value='".$retail['currentStock']."'";
                                                                                        }
                                                                                    ?>> 
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
                                    <input type="text" name="retail_regularPrice"<?php
                                                                                        if($mode == "update"){
                                                                                            echo "value='".$retail['regularPrice']."'";
                                                                                        }
                                                                                    ?>>
                                </div>
                                <div class="input_element">
                                    <p>Sale Price</p>
                                    <input type="text" name="retail_salePrice"<?php
                                                                                        if($mode == "update"){
                                                                                            echo "value='".$retail['salePrice']."'";
                                                                                        }
                                                                                    ?>>
                                </div>
                                <div class="input_element">
                                    <p>Included Tax</p>
                                    <input type="text" name="retail_includedTax"<?php
                                                                                        if($mode == "update"){
                                                                                            echo "value='".$retail['includedTaxPercent']."'";
                                                                                        }
                                                                                    ?>>
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
                                    <input type="text" name="wholesale_currentStock"<?php
                                                                                        if($mode == "update"){
                                                                                            echo "value='".$wholeSale['currentStock']."'";
                                                                                        }
                                                                                    ?>>
                                </div>
                                <div class="input_element">
                                <p>Low Stock</p>
                                    <input type="text" name="wholesale_lowStockThreshold"<?php
                                                                                        if($mode == "update"){
                                                                                            echo "value='".$wholeSale['lowStockThreashold']."'";
                                                                                        }
                                                                                    ?>>
                                </div>
                                <div class="input_element">
                                <p>Suppliers</p>
                                    <input type="text" name="wholesale_supplier"<?php
                                                                                        if($mode == "update"){
                                                                                            echo "value='".$wholeSale['currentStock']."'";
                                                                                        }
                                                                                    ?>>
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
                                    <input type="text" name="wholesale_regularPrice"<?php
                                                                                        if($mode == "update"){
                                                                                            echo "value='".$wholeSale['regularPrice']."'";
                                                                                        }
                                                                                    ?>>
                                </div>
                                <div class="input_element">
                                    <p>Sale Price</p>
                                    <input type="text" name="wholesale_salePrice"<?php
                                                                                        if($mode == "update"){
                                                                                            echo "value='".$wholeSale['salePrice']."'";
                                                                                        }
                                                                                    ?>>
                                </div>
                                <div class="input_element">
                                    <p>Included Tax</p>
                                    <input type="text" name="wholesale_includedTax"<?php
                                                                                        if($mode == "update"){
                                                                                            echo "value='".$wholeSale['includedTaxPercent']."'";
                                                                                        }
                                                                                    ?>>
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
                                    <input type="text" name="vehicle_currentStock"<?php
                                                                                        if($mode == "update"){
                                                                                            echo "value='".$vehicle['currentStock']."'";
                                                                                        }
                                                                                    ?>>
                                </div>
                                <div class="input_element">
                                <p>Low Stock</p>
                                    <input type="text" name="vehicle_lowStockThreshold"<?php
                                                                                        if($mode == "update"){
                                                                                            echo "value='".$vehicle['lowStockThreashold']."'";
                                                                                        }
                                                                                    ?>>
                                </div>
                                <div class="input_element">
                                <p>Suppliers</p>
                                    <input type="text" name="vehicle_supplier"<?php
                                                                                        if($mode == "update"){
                                                                                            echo "value='".$vehicle['currentStock']."'";
                                                                                        }
                                                                                    ?>>
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
                                    <input type="text" name="vehicle_regularPrice"<?php
                                                                                        if($mode == "update"){
                                                                                            echo "value='".$vehicle['regularPrice']."'";
                                                                                        }
                                                                                    ?>>
                                </div>
                                <div class="input_element">
                                    <p>Sale Price</p>
                                    <input type="text" name="vehicle_salePrice"<?php
                                                                                        if($mode == "update"){
                                                                                            echo "value='".$vehicle['salePrice']."'";
                                                                                        }
                                                                                    ?>>
                                </div>
                                <div class="input_element">
                                    <p>Included Tax</p>
                                    <input type="text" name="vehicle_includedTax"<?php
                                                                                        if($mode == "update"){
                                                                                            echo "value='".$vehicle['includedTaxPercent']."'";
                                                                                        }
                                                                                    ?>>
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
                                    <input disabled type="text" name="" <?php
                                                                                        if($mode == "update"){
                                                                                            echo "value='".$product['fk_addedBy']."'";
                                                                                        }
                                                                                    ?>>
                                </div>
                                <div class="input_element">
                                    <p>Date Added</p>
                                    <input disabled type="text" name="" <?php
                                                                                        if($mode == "update"){
                                                                                            echo "value='".$product['dateCreated']."'";
                                                                                        }
                                                                                    ?>>
                                </div>
                                <div class="input_element">
                                    <p>Modified By</p>
                                    <input disabled type="text" name="" <?php
                                                                                        if($mode == "update"){
                                                                                            echo "value='".$product['fk_modifiedBy']."'";
                                                                                        }
                                                                                    ?>>
                                </div>
                                <div class="input_element">
                                    <p>Date Modified</p>
                                    <input disabled type="text" name="" <?php
                                                                                        if($mode == "update"){
                                                                                            echo "value='".$product['dateModified']."'";
                                                                                        }
                                                                                    ?>>
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
                                    <select name="visibility" id="">
                                    <?php
                                        if($mode = 'update'){
                                            $selected = $product['visibility'];
                                        
                                            $roles = [
                                                ['Visible','Visible'],
                                                ['Invisible','Invisible'],
                                            ];

                                            foreach ($roles as $value) {
                                                ?>
                                                <option value="<?php echo $value[0].'" ' ; if($value[0] == $selected){ echo " selected = selected";}?>"><?php echo $value[1]?></option>
                                                <?php
                                            }
                                        }else{
                                            ?>
                                            <option value="Visible">Visible</option>
                                            <option value="Invisible">Invisible</option>
                                            <?php
                                        }
                                    ?>
                                    
                                    </select>
                                </div>
                                <div class="input_element">
                                    <p>Enable Edit</p>
                                    <select name="enableEdit" id="">
                                        <?php
                                            if($mode = 'update'){
                                                $selected = $user['enableEdit'];
                                            
                                                $roles = [
                                                    ['enabled','enabled'],
                                                    ['Disabled','Disabled'],
                                                ];

                                                foreach ($roles as $value) {
                                                    ?>
                                                    <option value="<?php echo $value[0].'" ' ; if($value[0] == $selected){ echo " selected = selected";}?>"><?php echo $value[1]?></option>
                                                    <?php
                                                }
                                            }else{
                                                ?>
                                                <option value="enabled">enabled</option>
                                                <option value="Disabled">Disabled</option>
                                                <?php
                                            }
                                        ?>
                                    </select>
                                </div>
                                <div class="input_element">
                                    <p>Notes</p>
                                    <textarea class="product_notes" name="Notes" id="" cols="30" rows="10"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>