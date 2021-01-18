<?php
require_once "app/php/Modal.php";
session_start();
session_destroy();
header("location:http://" . ROOT ."/home.php");
?>