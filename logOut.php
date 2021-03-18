<?php
require_once "app/php/Modal.php";
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
session_destroy();
header("location:http://" . ROOT ."/index.php");
?>