<?php

/**
* Database connection class
* This class contains all the functions required for database connection
* Only one connection is allowed through class instance
*
* @author David Kariuki (dk)
* @copyright (c) 2020 All Rights Reserved.
*/


class DatabaseConnection
{

    // Connection status value variable
    protected $databaseConnection;

    // Database single connection instance
    private static $connectionInstance;


    /**
    * Class constructor
    */
    private function __construct()
    {
        // Call configuration file
        //require_once '../config/databaseConfiguration.php';

        // Connecting to MYSQL database
        $this->databaseConnection = new mysqli(
            HOST,
            HOST_USERNAME,
            HOST_PASSWORD,
            DATABASE_NAME
        );

        // Check if connection was successful
        if ($this->databaseConnection->connect_error) {
            // Connection error

            trigger_error(
                "Connection Error: " . $this->databaseConnection->connect_error,
                E_USER_ERROR
            );
        }
    }


    /**
    * Class destructor
    */
    function __destruct()
    {

    }


    /**
    * Get an instance of the database connection
    *
    * @return self instance - connection instance
    */
    public static function getConnectionInstance()
    {
        // Check for another existent instance
        if (!self::$connectionInstance) {

            // Create new instance if not existing
            self::$connectionInstance = new self();
        }

        return self::$connectionInstance; // Return connection instance
    }


    /**
    * Clone() method
    * Leaving it empty to prevent duplication of database connection
    */
    private function __clone()
    {

    }


    /**
    * Function to get database connection
    *
    * @return mysqli - databaseConnection
    */
    public function getDatabaseConnection()
    {
        return $this->databaseConnection; // Return database connection
    }

}

// EOF: DatabaseConnection.php
