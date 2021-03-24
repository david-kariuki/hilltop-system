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
        case "openSale":
            echo "opening sale";
            break;
        case "renderPage":

            $table = "tbl_sale";
            $fields = array(
                "*",
            );
            $order_by = "dateCreated";
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
        case "getTransactions":

            $table = "tbl_transaction";
            $fields = array(
                "*",
            );
            $order_by = "dateCreated";
            $order_set = "DESC";
            $offset = 0;
            $reference = array(
                "statement" => "fk_saleReference = ?",
                "type"=>"i",
                "values"=>[
                    $data
                ]
            );

            $response = $admin->database_read_by_ref($table,$fields,$order_by,$order_set,$offset,null);

            if($response['status']){
                $transactions = $response;

                echo json_encode($transactions);
            }else{
                exit();
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
