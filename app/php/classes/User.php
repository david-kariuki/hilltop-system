<?php

/**
* User class
* This class contains all the methods required by a user
*
* @author David Kariuki (dk)
* @author Peter Kimani (dk)
* @copyright Copyright (c) 2021 All Rights Reserved.
*/


// User class
class User
{

    // Connection status value variable
    private $connectToDB;       // Create DatabaseConnection class object
    private $constants;         // Create Constants class object


    /**
    * Class constructor
    */
    function __construct()
    {

        // Creating objects of the required classes

        // Initialize database connection class instance
        $connectionInstance = DatabaseConnection::getConnectionInstance();

        // Initialize connection object
        $this->connectToDB  = $connectionInstance->getDatabaseConnection();
        $this->constants    = new Constants();      // Initialize constants object
    }


    /**
    * Class destructor
    */
    function __destruct()
    {

    }

    /**
    * Function to add user to the database
    *
    */
    public function addUserToDatabase($userDetails){

        // UUID
        // firstName
        // lastName
        // otherName
        // gender
        // nationalId
        // Email
        // userName
        // password
        // Address
        // city
        // role
        // status
        // dateCreated
        // lastModified
        // logID

        // Prepare insert statement
        $stmt = $this->connectToDB->prepare(
            "{}"
        );
        $stmt->bind_param(); // Bind parameters



    }

    /**
    * Function to read user by reference
    *
    */
    public function readUserByReference(){

    }

    /**
    * Function to read all users
    *
    */
    public function readAllUsers(){

    }

    /**
    * Function to update user by reference
    *
    */
    public function updateUserByReference(){

    }

    /**
    * Function to delete user by reference
    */
    public function deleteUserByReference(){

    }
}

// EOF : User.php
