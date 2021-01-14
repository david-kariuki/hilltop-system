<?php

/**
 * This is file works as the application entry point.
 * It pulls all back-end functionality files to one location.
 *
 */

require_once "templates.php";
require_once "config/databaseConfiguration.php";
require_once "classes/_classAutoLoader.php";
require_once "config/functions.php";
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
];

$values = [
    "firstName",
    "lastName",
    "otherName",
    "gender",
    "nationalID",
    "emailAddress",
    "userName",
    "password",
    "Address",
    "city",
    "role",
    "status",
];

$combined  = array_combine($fields, $values);

$admin = new User();

$combined  = array_combine($fields, $values);

$admin->addUserToDatabase($combined);
