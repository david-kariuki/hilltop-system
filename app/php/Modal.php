<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

/**
 * This is file works as the application entry point.
 * It pulls all back-end functionality files to one location.
 *
 */

require_once "templates.php";
include_once "config/config.php";
require_once "config/databaseConfiguration.php";
require_once "classes/_classAutoLoader.php";
require_once "config/functions.php";
require_once "config/constants.php";
require_once "config/path.php";

//create a global User
/**
 * @example  $moderator = new AdminUser();
 *
 */


$fields = [
    "firstName",
    "lastName",
    "otherName",
    "gender",
    "nationalId",
    "Email",
    "userName",
    "password",
    "Address",
    "city",
    "role",
    "status",
    "logID"
];

$values = [
    "firstName",
    "lastName",
    "otherName",
    "gender",
    "nationalID",
    "email1",
    "user1",
    "password",
    "Address",
    "city",
    "role",
    "status",
    "1"
];

$admin = new User();

if(isset($_SESSION['LOGGED_USER'])){
    $table = "tbl_users";
    $fields = array(
        "*",
    );
    $order_by = "userName";
    $order_set = "DESC";
    $offset = 0;
    $reference = array(
        "statement" => "Email = ?",
        "type"=>"s",
        "values"=>[
            $_SESSION['LOGGED_USER']
        ]
    );

    $user = $admin->database_read_by_ref($table,$fields,$order_by,$order_set,$offset,$reference);

    if($user['status']){
        $user = $user['response'][0];

        $admin->assign_param($user);
    }
}

