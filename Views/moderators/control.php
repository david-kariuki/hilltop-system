<?php
//TODO:initiate session
//TODO:confirm security token

session_start();
$_SESSION['TOKEN'] = 123;

if (isset($_SESSION['TOKEN'])) {

    //retrieve the data required
    $data = $_REQUEST['data'];
    $action = $_REQUEST['action'];

    //confirm action intended
    switch($action){
        //create a new User
        case "createNewUser":
            if(isset($data)){

                // sanitize data
                foreach ($data as $key => $value) {
                    if($key == "password" || $key == "confirmPassword"){
                        continue;
                    }
                    $data[$key] = htmlspecialchars($value, ENT_COMPAT);
                }

                //validate email Address
                if (!filter_var($data['emailAddress'], FILTER_VALIDATE_EMAIL)) {
                    $response = array(
                        "status"=>"000200000",
                        "response"=>"Invalid Email",
                        "data"=>false
                    );

                    echo json_encode($response);

                    exit();
                }

                // Encrypt Password
                $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);

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
                    $data["firstName"],
                    $data["lastName"],
                    $data["otherName"],
                    $data["gender"],
                    $data["nationalID"],
                    $data["emailAddress"],
                    $data["userName"],
                    $data["password"],
                    $data["Address"],
                    $data["city"],
                    $data["role"],
                    $data["status"],
                ];

                // Combine field and value arrays
                $combined  = array_combine($fields, $values);

                print_r($combined); // Debug

            }else{
                $response = array(
                    "status"=>"000100000",
                    "response"=>"No data to Process",
                    "data"=>false
                );

                $response = json_encode($response);


            }
            break;
        case "updateUser";
            if(isset($data)){

            // sanitize data
            foreach ($data as $key => $value) {
                if($key == "password" || $key == "confirmPassword"){
                    continue;
                }
                $data[$key] = htmlspecialchars($value, ENT_COMPAT);
            }

            //validate email Address
            if (!filter_var($data['emailAddress'], FILTER_VALIDATE_EMAIL)) {
                $response = array(
                    "status"=>"000200000",
                    "response"=>"Invalid Email",
                    "data"=>false
                );

                $response = json_encode($response);

                echo $response;

                exit();
            }

            // Encrypt Password
            $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);

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
                $data["firstName"],
                $data["lastName"],
                $data["otherName"],
                $data["gender"],
                $data["nationalID"],
                $data["emailAddress"],
                $data["userName"],
                $data["password"],
                $data["Address"],
                $data["city"],
                $data["role"],
                $data["status"],
            ];

            $combined  = array_combine($fields, $values);

            // print_r($combined);

            } else {

                $response = array(
                    "status"=>"000100000",
                    "response"=>"No data to Process",
                    "data"=>false
                );

                $response = json_encode($response);

                echo $response;

                exit();
            }
            break;

        //all invalid actions
        default :
            $response = array(
                "status"=>"010000000",
                "response"=>"Invalid Action",
                "data"=>false
            );

            $response = json_encode($response);

            echo $response;

            exit();
    }
} else{
    echo "Not set";
}
