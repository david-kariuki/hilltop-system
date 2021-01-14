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
    use System; // Call System class

    // Connection status value variable
    private $connectToDB;       // Create DatabaseConnection class object


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
    * @param
    *
    *
    */
    public function addUserToDatabase($userData, $table, $type = null)
    {

        $response = [
            false,
        ];

        $tempArray  = array();

        // Check if fields is passed as array
        if (is_array($fields)) {

            $arrayCount = count($fields); // Get array count

            // Check array count length
            if ($arrayCount > 0) {

                $fields[]; // Array to hold user data fields
                $values[]; // Array to hold user data values

                $fields = $userData[0]; // Get fields array from userData
                $values = $userData[1]; // Get values array from $userData

                $fieldsCombined = implode(",", $fields); // Join array elements with a comma

                $placeholders = str_repeat(" ?,", $arrayCount); // Repeat placeholder for fields
                $placeholders = rtrim($placeholders, ','); // Strip last comma

                // Prepare INSERT statement
                $stmt = $this->connectToDB->prepare(
                    "INSERT INTO $table($fieldsCombined) VALUES($placeholders)"
                );

                $stmt->bind_param($type, ...$values); // Bind parameters
                $stmt->execute(); // Execute statement
                $result = $stmt->get_result(); // Get result
                $stmt->close(); // Close statement

                // Loop through result fetching associative array
                while ($data = $result->fetch_assoc()) {

                    array_push($tempArray, $data);  // Add data to the end of temp array
                    $response[0] = true;            // Set response at index 0 to true
                }

                array_push($response, $tempArray); // Add temp array to response
            }
        }

        return $response; // Return response array
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
