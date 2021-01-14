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
define("TABLE_USERS",                           "Users");


/**
* Table users fields
*/
define("FIELD_USER_ID",                         "UserId");

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


/**
* Class declaration for autoload visibility and
* to get constants value when calling the constant in between quotes
*/
class Constants
{

    /**
    * Class constructor
    */
    function __construct()
    {

    }


    /**
    * Class destructor
    */
    function __destruct()
    {

    }


    /**
    * Function to return constant value within SQL statements
    *
    * @param constant - Constants value
    */
    public function valueOfConst($constant)
    {

        if (!empty($constant)) {
            // Constant not empty

            return $constant; // Return constant

        } else {
            // Constant empty

            // Throw exception
            throw new Exception(
                'Method '.__METHOD__.' failed : The required constant is null or undefined'
            );
        }
    }
}

// EOF: Constants.php
