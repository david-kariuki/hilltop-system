<?php
include_once "../../app/php/Modal.php";

$admin->download_send_headers("data_export_" . date("Y-m-d") . ".csv");
$array = [
    array(
        "name"=>"landcruiser",
        "price"=>20000000
    ),
    array(
        "name"=>"Range Rover",
        "price"=>30000000
    ),
];
echo $admin->csv_converter($array);
die();
?>