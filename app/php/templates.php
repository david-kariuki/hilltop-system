<?php
/**
 * Includes all html,json,javascript and css templates
 */

// public function addUserToDatabase($userData, $table, $type = null,$unique_ID_generator)
// {

//     $response = [
//         false,
//     ];

//     $tempArray  = array();

//     // Check if user data is passed as array
//     if (is_array($userData)) {

//         $arrayCount = count($userData); // Get array count

//         // Check array count length
//         if ($arrayCount > 0) {
//             $ID = $this->unique_ID_generator();

//             $fields = array(); // Array to hold user data fields
//             $values = array($ID); // Array to hold user data values

//             $fields[0] = "UUID";

//             foreach ($userData as $key => $value) {
//                 array_push($fields,$key); // Get fields array from userData
//                 array_push($values,$value); // Get values array from $userData
//             }    

//             $fieldsCombined = implode("`,`", $fields); // Join array elements with a comma
//             $fieldsCombined = "`".$fieldsCombined."`";

//             $placeholders = str_repeat(" ?,", $arrayCount); // Repeat placeholder for fields
//             $placeholders = rtrim($placeholders, ','); // Strip last comma

//             var_dump($values);

//             // Prepare INSERT statement
//             $stmt = $this->connectToDB->prepare("INSERT INTO $table($fieldsCombined) VALUES($placeholders)");
//             if (false == $stmt) {
//                 die('bind_param() failed: ' . htmlspecialchars($this->connectToDB->error));
//             }

//             $bind = $stmt->bind_param($type, ...$values); // Bind parameters

//             if(false == $bind){
//                 die('bind_param() failed: ' . htmlspecialchars($stmt->error));
//             }
//             $execute = $stmt->execute(); // Execute statement

//             if(false == $execute){
//                 die('bind_param() failed: ' . htmlspecialchars($stmt->error));
//             }

//             // $result = $this->connectToDB->insert_id(); // Get result
//             $stmt->close(); // Close statement

//             var_dump($result);

//             // Loop through result fetching associative array
//             // while ($data = $result->fetch_assoc()) {
//             //     array_push($tempArray, $data);  // Add data to the end of temp array
//             //     $response[0] = true;            // Set response at index 0 to true
//             // }

//             // array_push($response, $tempArray); // Add temp array to response
//         }
//     }

//     return $response; // Return response array
// }