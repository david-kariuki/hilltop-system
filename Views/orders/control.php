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
                            $stmt = "<tr onclick='select_order_item(\"{$value['UUID']}\",\"{$value['productName']}\",\"{$value1['regularPrice']}\",)' id=\"{$value['UUID']}\"><td>".$value["productName"]."</td><td>".$value1["currentStock"]."</td><td>".$value1["regularPrice"]."</td></tr>";

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
        case "addNewOrder":
            /*
            UUID
            fk_OrderBy
            fk_confirmedBy
            Quantity
            Amount
            Merchant
            Merchant_tel
            Merchant_address
            Order_Note
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
                    'UUID',
                    'Ordered_By',
                    'Confirmed_by',
                    'Quantity',
                    'Amount',
                    'Merchant',
                    'Merchant_tel',
                    'Merchant_Address',
                    'Order_Notes',
                );

                $fieldsCombined = implode("`,`", $fields); // Join array elements with a comma
                $fieldsCombined = "`".$fieldsCombined."`";
                $placeholders = "?,?,?,?,?,?,?,?,?";
                $type = "iiiddssss";
                $values = array(
                    $ID,
                    $user_ID,
                    $user_ID,
                    $data['orderDetails']['Quantity'],
                    $data['orderDetails']['Amount'],
                    $data['merchantDetails']['name'],
                    $data['merchantDetails']['number'],
                    $data['merchantDetails']['Address'],
                    $data['orderDetails']['Note'],
                );

                $insert = $admin->insert_to_database('tbl_orders',$fieldsCombined,$placeholders,$type,$values);

                if($insert['status']){

                    $products = $data['subOrdersDetails'];


                    foreach ($products as $value) {
                        $subOrderID = $admin->unique_ID_generator();

                        $fields = array(
                            'UUID',
                            'fk_OrderID',
                            'fk_ProductID',
                            'Quantity',
                            'Price',
                        );
        
                        $fieldsCombined = implode("`,`", $fields); // Join array elements with a comma
                        $fieldsCombined = "`".$fieldsCombined."`";
                        $placeholders = "?,?,?,?,?";
                        $type = "iiidd";
                        $values = array(
                            $subOrderID,
                            $ID,
                            $value["id"],
                            $value["quantity"],
                            $value["sub_total"],
                        );
        
                        $insert = $admin->insert_to_database('tbl_suborders',$fieldsCombined,$placeholders,$type,$values);

                        
                    }

                    echo json_encode($insert);
                } else{
                    echo "invalid";
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
