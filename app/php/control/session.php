<?php
/**
 * This file deals with session management
 */

 
require_once "../Modal.php";

session_start();

if (isset($_SESSION['TOKEN'])) {
    $action = $_REQUEST['action'];

    if($action == "logOut"){
        return session_destroy();
    }

} else {
    echo "not set";
}
