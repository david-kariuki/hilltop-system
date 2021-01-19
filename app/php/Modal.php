<?php

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


