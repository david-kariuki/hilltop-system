<?php
include_once "../../app/php/Modal.php";
//TODO:confirm security token

session_start();
$_SESSION['TOKEN'] = 123;

if (isset($_SESSION['TOKEN'])) {

    //retrieve the data required
    $data = $_REQUEST['data'];
    $action = $_REQUEST['action'];

    //confirm action intended
    switch($action){
        
        case "getProduct":
            $table = "tbl_products";
            $fields = array(
                "*",
            );
            $order_by = "productName";
            $order_set = "ASC";
            $offset = 0;
            $reference = array(
                "statement" => "LOWER(productName) LIKE ?",
                "type"=>"s",
                "values"=>[
                    "%{$data[0]}%"
                ]
            );
            
            $response = $admin->database_read_by_ref($table,$fields,$order_by,$order_set,$offset,$reference);

            $report = array(
                'status'=>false,
                'responseCode'=>1,
                'response'=>array()
            );

            if($response['status']){
                

                $items = $response['response'];

                foreach ($items as $key => $value) {
                    

                    $table = "tbl_inventory";
                    $fields = array(
                        "*",
                    );
                    $order_by = "fk_productID";
                    $order_set = "ASC";
                    $offset = 0;
                    $reference = array(
                        "statement" => "fk_productID = ? AND fk_storageID = ?",
                        "type"=>"ii",
                        "values"=>[
                            $value['UUID'],
                            $data[1]
                        ]
                    );
                    
                    $response = $admin->database_read_by_ref($table,$fields,$order_by,$order_set,$offset,$reference);

                    if($response['status']){
                        $report['status'] = true;
                        $report['responseCode'] = 0;

                        $sub_item = $response['response'];

                        foreach ($sub_item as $key1 => $value1) {
                            $stmt = "<tr onclick='select_purchase_item(\"{$value['UUID']}\",\"{$value['productName']}\",\"{$value1['regularPrice']}\",)' id=\"{$value['UUID']}\"><td>".$value["productName"]."</td><td>".$value1["currentStock"]."</td><td>".$value1["regularPrice"]."</td></tr>";

                            array_push($report['response'],$stmt);
                        }
                    }else{
                        $response = array(
                            'status'=>false,
                            'responseCode'=>2,
                            'response'=>'Item Not Found'
                        );
        
                        echo json_encode($response);
                    }
                }

                echo json_encode($report);

            }else{
                $response = array(
                    'status'=>false,
                    'responseCode'=>1,
                    'response'=>'Item Not Found'
                );

                echo json_encode($response);
            }
            break;
        case "addSale":
            /*
            sales_ID
            fk_salesID
            saleType
            saleQuantity
            amount
            */
            //generate user ID
            $ID = $admin->unique_ID_generator();
            //get User ID
            $user;
            $table = "tbl_users";
            $fields = array(
                "*",
            );
            $order_by = "firstName";
            $order_set = "ASC";
            $offset = 0;
            $reference = array(
                "statement" => "Email = ?",
                "type"=>"s",
                "values"=>[
                    $_SESSION['LOGGED_USER']
                ]
            );

            $response = $admin->database_read_by_ref($table,$fields,$order_by,$order_set,$offset,$reference);

            if($response['status']){
                $user = $response['response'][0];
                $user_ID = $user['UUID'];

                $fields = array(
                    'sale_ID',
                    'fk_saleRep',
                    'saleType',
                    'saleQuantity',
                    'amount',
                    'saleNote'
                );

                $fieldsCombined = implode("`,`", $fields); // Join array elements with a comma
                $fieldsCombined = "`".$fieldsCombined."`";
                $placeholders = "?,?,?,?,?,?";
                $type = "iisdds";
                $values = array(
                    $ID,
                    $user_ID,
                    $data['saleDetails']['saleType'],
                    $data['saleDetails']['saleQuantity'],
                    $data['saleDetails']['saleAmount'],
                    $data['saleDetails']['saleNote']
                );

                $insert = $admin->insert_to_database('tbl_sale',$fieldsCombined,$placeholders,$type,$values);

                if($insert['status']){
                    $products = $data['subSale'];


                    foreach ($products as $value) {
                        $subSaleID = $admin->unique_ID_generator();

                        //find ID
                        $table = "tbl_products";
                        $fields = array(
                            "*",
                        );
                        $order_by = "productName";
                        $order_set = "ASC";
                        $offset = 0;
                        $reference = array(
                            "statement" => "productName = ?",
                            "type"=>"s",
                            "values"=>[
                                $value['productName']
                            ]
                        );
            
                        $response = $admin->database_read_by_ref($table,$fields,$order_by,$order_set,$offset,$reference);

                        if($response['status']){
                            $productID = $response['response'][0]['UUID'];

                            $table = "tbl_inventory";
                            $fields = array(
                                "*",
                            );
                            $order_by = "fk_productID";
                            $order_set = "ASC";
                            $offset = 0;
                            $reference = array(
                                "statement" => "fk_productID = ? AND fk_storageID = ?",
                                "type"=>"ii",
                                "values"=>[
                                    $productID,
                                    $data['saleDetails']['saleType']
                                ]
                            );
                
                            $response = $admin->database_read_by_ref($table,$fields,$order_by,$order_set,$offset,$reference);

                            if($response['status']){
                                
                                $inventoryID = $response['response'][0]['UUID'];

                                $fields = array(
                                    'UUID',
                                    'fk_SaleID',
                                    'fk_productID',
                                    'quantity',
                                    'fk_createdBy',
                                    'Price',
                                    'subTotal'
                                );

                                $fieldsCombined = implode("`,`", $fields); // Join array elements with a comma
                                $fieldsCombined = "`".$fieldsCombined."`";
                                $placeholders = "?,?,?,?,?,?,?";
                                $type = "iiiiidd";
                                $values = array(
                                    $subSaleID,
                                    $ID,
                                    $inventoryID,
                                    $value['quantity'],
                                    $user_ID,
                                    $value['price'],
                                    $value['sub_total']
                                );

                                $insert = $admin->insert_to_database('tbl_subsale',$fieldsCombined,$placeholders,$type,$values);

                                if($insert['status']){
                                    $productID = $response['response'][0]['UUID'];

                                    $table = "tbl_inventory";
                                    $fields = array(
                                        "*",
                                    );
                                    $order_by = "fk_productID";
                                    $order_set = "ASC";
                                    $offset = 0;
                                    $reference = array(
                                        "statement" => "UUID = ?",
                                        "type"=>"i",
                                        "values"=>[
                                            $inventoryID
                                        ]
                                    );
                        
                                    $response = $admin->database_read_by_ref($table,$fields,$order_by,$order_set,$offset,$reference);

                                    $stock = $response['response'][0]['currentStock'];
                                    $newStock = (int)$stock - (int)$value['quantity'];
                                    switch ((int)$data['saleDetails']['saleType']) {
                                        case 1:
                                            $update = $admin->updateSubProductStock($inventoryID,$newStock,1);

                                            var_dump($update);
                                            break;
                                        case 2:
                                            $update = $admin->updateSubProductStock($inventoryID,$newStock,2);

                                            var_dump($update);
                                            break;
                                        case 3:
                                            $update = $admin->updateSubProductStock($inventoryID,$newStock,3);

                                            var_dump($update);
                                            break;
                                        default:
                                            return;
                                            break;
                                    }
                                }
                            }
                        }else{
                            $response = array(
                                "status"=>"000020000",
                                "response"=>"Product not found.",
                                "data"=>false
                            );
                
                            $response = json_encode($response);
                
                            echo $response;
                
                            exit();
                        }
                    }

                    $transactions = $data['transaction'];

                    if(!isset($transactions)){
                        exit();
                    }

                    foreach ($transactions as $value) {
                        $transactionID = $admin->unique_ID_generator();

                        $fields = array(
                            'UUID',
                            'fk_saleReference',
                            'transactionValue',
                            'transactionMethode',
                            'fk_createdBy',
                            'fk_modifiedBy' 
                        );

                        $fieldsCombined = implode("`,`", $fields); // Join array elements with a comma
                        $fieldsCombined = "`".$fieldsCombined."`";
                        $placeholders = "?,?,?,?,?,?";
                        $type = "ssssss";
                        $values = array(
                            $transactionID,
                            $ID,
                            $value['amount'],
                            $value['paymentMethod'],
                            $user_ID,
                            $user_ID,
                        );

                        $insert = $admin->insert_to_database('tbl_transaction',$fieldsCombined,$placeholders,$type,$values);

                        var_dump($insert);
                    }
                }
            }else{
                $response = array(
                    "status"=>"000010000",
                    "response"=>"User Not Found",
                    "data"=>false
                );
    
                $response = json_encode($response);
    
                echo $response;
    
                exit();
            }

            break;
        //all invalid actions
        default :
            $response = array(
                "status"=>"010000000",
                "response"=>"Invalid Action",
                "data"=>false
            );

            $response = json_encode($response);

            echo $response;

            exit();
    }
} else{
    echo "Not set";
}
