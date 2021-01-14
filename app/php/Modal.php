<?php

/**
 * This is file works as the application entry point.
 * It pulls all back-end functionality files to one location.
 *
 */

require_once "templates.php";
require_once "config/config.php";
require_once "classes/_classAutoLoader.php";
require_once "config/functions.php";
require_once "config/path.php";

//create a global User
/**
 * @example  $moderator = new AdminUser();
 *
 */
$Admin = new User();

$admin->addUserToDatabase("");
