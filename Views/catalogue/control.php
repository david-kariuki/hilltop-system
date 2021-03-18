<?php
include_once "../../app/php/Modal.php";
//TODO:confirm security token

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$_SESSION['TOKEN'] = 123;

if (isset($_SESSION['TOKEN'])) {

    //retrieve the data required
    $data = $_REQUEST['data'];
    $action = $_REQUEST['action'];

    //confirm action intended
    switch($action){
        //create a new User
        case "createNewProduct":
            if(isset($data)){

                $product = $data['product'];
                $sub_retail = $data['retail'];
                $sub_wholesale = $data['wholesale'];
                $sub_vehicle = $data['vehicle'];

                $var = $admin->addProductToDatabase($product,$sub_retail,$sub_wholesale,$sub_vehicle,"tbl_products");

                echo json_encode($var);
            }else{
                $response = array(
                    "status"=>"000100000",
                    "response"=>"No data to Process",
                    "data"=>false
                );

                $response = json_encode($response);

        
            }
            break;
        case "updateProduct":
            if(isset($data)){

                $product = $data['product'];
                $sub_retail = $data['retail'];
                $sub_wholesale = $data['wholesale'];
                $sub_vehicle = $data['vehicle'];
                $id = $_REQUEST['id'];

                
                $var = $admin->updateProductByReference($product,$sub_retail,$sub_wholesale,$sub_vehicle,'tbl_products',$id);

                echo json_encode($var);
            }else{
                $response = array(
                    "status"=>"000100000",
                    "response"=>"No data to Process",
                    "data"=>false
                );

                $response = json_encode($response);

        
            }
            break;
        case "renderPage":

            $table = "tbl_products";
            $fields = array(
                "*",
            );
            $order_by = "productName";
            $order_set = "ASC";
            $offset = $data * SPLITTER;

            $response = $admin->database_read_by_ref($table,$fields,$order_by,$order_set,$offset,null);

            if($response['status']){
                $products = $response['response'];

                echo json_encode($response);
            }else{
                exit();
            }
            break;
        case "filter_data":
            $table = "tbl_products";
            $fields = array(
                "*",
            );
            $order_by = "productName";
            $order_set = "ASC";
            $offset = 0;
            $reference = array(
                "statement" => "visibility = ?",
                "type"=>"s",
                "values"=>[
                    $data['visibility']
                ]
            );
            
            $response = $admin->database_read_by_ref($table,$fields,$order_by,$order_set,$offset,$reference);

            if($response['status']){
                $response_return = array(
                    "status"=>true,
                    "response" => array()
                );
                $products = $response['response'];
                $stmt = "";
                $count = 1;

                foreach ($products as $key => $product) {
                    $temp_array = array(
                        "count"=>$count,
                        "productID" => $product['UUID'],
                        "productName" => $product['productName'],
                        "productType" => $product['productType'],
                        "visibility" => $product['visibility']
                    );

                    array_push($response_return['response'],$temp_array);
                    $count++;
                }

                echo json_encode($response_return);
            }else{
                echo json_encode($response);
                return;
            }
            break;
        case "remove_filter":
            $table = "tbl_products";
            $fields = array(
                "*",
            );
            $order_by = "productName";
            $order_set = "ASC";
            $offset = 0;
            $reference = array(
                "statement" => "visibility = ?",
                "type"=>"s",
                "values"=>[
                    $data['visibility']
                ]
            );
            
            $response = $admin->database_read_by_ref($table,$fields,$order_by,$order_set,$offset,null);

            if($response['status']){
                $response_return = array(
                    "status"=>true,
                    "response" => array()
                );
                $products = $response['response'];
                $stmt = "";
                $count = 1;

                foreach ($products as $key => $product) {
                    $temp_array = array(
                        "count"=>$count,
                        "productID" => $product['UUID'],
                        "productName" => $product['productName'],
                        "productType" => $product['productType'],
                        "visibility" => $product['visibility']
                    );

                    array_push($response_return['response'],$temp_array);
                    $count++;
                }

                echo json_encode($response_return);
            }else{
                echo json_encode($response);
                return;
            }
            break;
        case "search_product":
            if(isset($data)){
                
            }
            break;
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
