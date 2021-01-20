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
            $user;
            $table = "tbl_products";
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
