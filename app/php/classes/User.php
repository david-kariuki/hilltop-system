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
    * TODO - Check if method runs
    *
    */
    public function addUserToDatabase($userData, $table, $type = null,$unique_ID_generator)
    {

        $response = [
            false,
        ];

        $tempArray  = array();

        // Check if user data is passed as array
        if (is_array($userData)) {

            $arrayCount = count($userData); // Get array count

            // Check array count length
            if ($arrayCount > 0) {
                $ID = $this->unique_ID_generator();

                $fields = array(); // Array to hold user data fields
                $values = array("MD_".$ID); // Array to hold user data values

                $fields = array(
                    TABLE_USERS['FIELD_USER_ID'],
                    TABLE_USERS['FIELD_EMAIL'],
                    TABLE_USERS['FIELD_USERNAME'],
                    TABLE_USERS['FIELD_ROLE'],
                );

                $fieldsCombined = implode("`,`", $fields); // Join array elements with a comma
                $fieldsCombined = "`".$fieldsCombined."`";
                $placeholders = "?,?,?,?";
                $type = "isss";
                $values = array(
                    $ID,
                    $userData['Email'],
                    $userData["userName"],
                    $userData["role"]
                );
                

                $insert = $this->insert_to_database($table,$fieldsCombined,$placeholders,$type,$values);

                if($insert["status"]){
                    $fields = array(
                        TABLE_USERS['FIELD_FIRST_NAME'],
                        TABLE_USERS['FIELD_LAST_NAME'],
                        TABLE_USERS['FIELD_OTHER_NAME'],
                        TABLE_USERS['FIELD_GENDER'],
                        TABLE_USERS['FIELD_NATIONAL_ID'],
                        TABLE_USERS['FIELD_PASSWORD'],
                        TABLE_USERS['FIELD_ADDRESS'],
                        TABLE_USERS['FIELD_CITY'],
                        TABLE_USERS['FIELD_STATUS'],
                        TABLE_USERS['FIELD_LOG_ID']
                    );
                    $fieldsCombined = implode("`,`", $fields); // Join array elements with a comma
                    $fieldsCombined = "`".$fieldsCombined."`";

                    $placeholders = "?,?,?,?,?,?,?,?,?,?";

                    $values = array(
                        [$userData['firstName'],"si"],
                        [$userData['lastName'],"si"],
                        [$userData['otherName'],"si"],
                        [$userData['gender'],"si"],
                        [$userData['nationalId'],"si"],
                        [$userData['password'],"si"],
                        [$userData['Address'],"si"],
                        [$userData['city'],"si"],
                        [$userData['status'],"si"],
                        [$userData['logID'],"si"],
                    );

                    $data_combined = array_combine($fields,$values);

                    $update = $this->database_update($table,$data_combined,$ID);

                    if($update["status"]){
                        $order_by = "UUID";
                        $offset = 1;
                        $this->database_read($table,$order_by,$offset);

                    }else {
                        var_dump($update["response"]);
                    }
                } else {
                    var_dump($insert["response"]);
                }

                // foreach ($userData as $key => $value) {
                //     array_push($fields,$key); // Get fields array from userData
                //     array_push($values,$value); // Get values array from $userData
                // }    

                // $fieldsCombined = implode("`,`", $fields); // Join array elements with a comma
                // $fieldsCombined = "`".$fieldsCombined."`";

                // $placeholders = str_repeat(" ?,", $arrayCount); // Repeat placeholder for fields
                // $placeholders = rtrim($placeholders, ','); // Strip last comma

                // var_dump($values);

                

                // $result = $this->connectToDB->insert_id(); // Get result
                

                // var_dump($result);

                // Loop through result fetching associative array
                // while ($data = $result->fetch_assoc()) {
                //     array_push($tempArray, $data);  // Add data to the end of temp array
                //     $response[0] = true;            // Set response at index 0 to true
                // }

                // array_push($response, $tempArray); // Add temp array to response
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

    /**
    * Sample get by ref
    */
    public function get_by_ref($fields, $table, $reference = null, $type = null ,$limit = null){

        $response = [
            false,
        ];

        $tempArray = array();

        // Check if fields is passed as array
        if (is_array($fields)) {

            $arrayCount = count($fields); // Get array count

            // Check array count length
            if ($arrayCount > 0) {

                $fieldsCombined = implode(",", $fields); // Join array elements with a comma
                $stmt; // Shared statement variable

                // Check if reference is set
                if (isset($reference)) {
                    // Reference set

                    $keys   = [];   // Keys array
                    $values = [];   // Values array

                    /**
                    * Loop through reference using &(reference) to name the value with a different name * or alias. References are a means to access the same variable content by different * names.
                    *
                    * @example - Just likes a person who has two different names.
                    */
                    foreach ($reference as &$val) {

                        array_push($keys, $val[0] . " = ?"); // Add to keys array
                        $myVal = $val[1];
                        array_push($values, $myVal); // Add to values array
                    }

                    $keysCombined = implode(" AND ", $keys); // Join array elements with a ' AND '

                    // Prepare SELECT statement
                    $stmt = $this->connectToDB->prepare(
                        "SELECT $fieldsCombined FROM $table WHERE $keysCombined "
                    );

                    $stmt->bind_param($type, ...$values); // Bind parameters

                } else {
                    // Reference not set

                    // Prepare SELECT statement
                    $stmt = $this->connectToDB->prepare("SELECT $fieldsCombined FROM $table");
                }

                $stmt->execute(); // Execute statement
                $result = $stmt->get_result(); // Get result
                $stmt->close(); // Close statement

                // Loop through result fetching associative array
                while ($data = $result->fetch_assoc()) {

                    array_push($tempArray, $data); // Add data to the end of temp array
                    $response[0] = true; // Set response at index 0 to true
                }

                array_push($response, $tempArray); // Add temp array to response
            }
        } else {

            if ($fields == "*") {
                // Selecting *

                // Check for reference
                if (isset($reference)) {
                    // Reference set

                    $keys   = [];   // Keys array
                    $values = [];   // Values array

                    // Loop through reference
                    foreach ($reference as &$val) {

                        array_push($keys, $val[0] . " = ?"); // Add to keys array
                        $myVal = $val[1];
                        array_push($values, $myVal); // Add to values array
                    }

                    $keysCombined = implode(" AND ", $keys); // Join array elements with a ' AND '

                    // Create statement
                    $statement = "select * from tbl_products where " . $keysCombined;

                    echo $statement; // Debug
                    exit(); // Debug

                    // Prepare SELECT statement
                    $stmt = $this->connectToDB->prepare("SELECT * FROM $table WHERE $keysCombined ");
                    $stmt->bind_param($type, ...$values); // Bind parameters

                } else {
                    // Reference not set

                    // Prepare SELECT statement
                    $stmt = $this->connectToDB->prepare("SELECT * FROM $table");
                }

                $stmt->execute(); // Execute statement
                $result = $stmt->get_result(); // Get result
                $stmt->close(); // Close statement

                // Loop through result fetching associative array
                while ($data = $result->fetch_assoc()) {

                    array_push($tempArray, $data); // Add data to the end of temp array
                    $response[0] = true; // Set response at index 0 to true
                }

                array_push($response, $tempArray); // Add temp array to response
            }
        }

        return $response; // Return response array
    }
}

// EOF : User.php
