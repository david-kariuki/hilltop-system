<?php
/**
 * This file deals with session management
 */

 
require_once "../Modal.php";

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (isset($_SESSION['TOKEN'])) {
    $action = $_REQUEST['action'];

    if($action == "logOut"){
        return session_destroy();
    }

} else {
    echo "not set";
}
