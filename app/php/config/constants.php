<?php

/**
* Constants class
* This class contains all the constants required by all project files
*
* @author David Kariuki (dk)
* @copyright Copyright (c) 2020 - 2021 David Kariuki (dk) All Rights Reserved.
*/

// Enable error reporting
error_reporting(1);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL|E_NOTICE|E_STRICT);


// Website and domain details
define("PROTOCOL",                              "https://");
define("SUB_DOMAIN",                            "www.");
define("ROOT_DOMAIN",                           "duesclerk.com");
define("ROOT_DOMAIN_WITH_SUB_DOMAIN",           SUB_DOMAIN . ROOT_DOMAIN);
define("WEBSITE_URL",                           PROTOCOL . ROOT_DOMAIN_WITH_SUB_DOMAIN);
define("COMPANY_NAME",                          "DuesClerk");


// Table Names
define(
    "TABLE_USERS",
    array(
        "NAME"                  => "tbl_users",
        "FIELD_USER_ID"         => "UUID",
        "FIELD_FIRST_NAME"      => "firstName",
        "FIELD_LAST_NAME"       => "lastName",
        "FIELD_OTHER_NAME"      => "otherName",
        "FIELD_GENDER"          => "gender",
        "FIELD_NATIONAL_ID"     => "nationalId",
        "FIELD_EMAIL"           => "email",
        "FIELD_USERNAME"        => "userName",
        "FIELD_PASSWORD"        => "password",
        "FIELD_ADDRESS"         => "Address",
        "FIELD_CITY"            => "city",
        "FIELD_ROLE"            => "role",
        "FIELD_STATUS"          => "status",
        "FIELD_DATE_CREATED"    => "dateCreated",
        "FIELD_LAST_MODIFIED"   => "lastModified",
        "FIELD_LOG_ID"          => "logID"
    )
);

/**
* Table field lengths
*/
define("LENGTH_MIN_SINGLE_NAME",                1);
define("LENGTH_MIN_PASSWORD",                   8);
define("LENGTH_MAX_EMAIL_ADDRESS",              320);
define("LENGTH_TABLE_IDS_SHORT",                20);
define("LENGTH_TABLE_IDS_LONG",                 40);


// Expressions (preg match)
define("EXPRESSION_NAMES",                      "/^[A-Za-z .'-]+$/");


// Logs keys
define("LOG_TYPE_SIGN_UP",                      "LogTypeSignUp");
define("LOG_TYPE_SIGN_IN",                      "LogTypeSignIn");
define("LOG_TYPE_SIGN_OUT",                     "LogTypeSignOut");
define("LOG_TYPE_UPDATE_PROFILE",               "LogTypeUpdateProfile");
define("LOG_TYPE_UPDATE_PASSWORD",              "LogTypeUpdatePassword");


// EOF: constants.php
