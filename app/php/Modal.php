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

$admin = new User();





