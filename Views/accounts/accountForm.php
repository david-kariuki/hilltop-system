<?php
require_once $_SERVER['DOCUMENT_ROOT']."/app/php/Modal.php";
session_start();

$data = json_decode(file_get_contents('php://input'), true);
$user = null;
$mode = "update";

if(!isset($_SESSION['LOGGED_USER'])){
    
    if(!isset($data)){
        echo "exited";
        exit();
    } else {
        
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
                $data
            ]
        );
    
        $response = $admin->database_read_by_ref($table,$fields,$order_by,$order_set,$offset,$reference);

        

        if($response['status'] == true){
            $user = $response['response'][0];
            
        } 

    }
}


?>

<div class="content_cover">
    <div class="view_title">
        <h3><?php echo $user['userName']?></h3>
    </div>
    <div class="view_nav_bar">
        <ul>
            <li>
                <button onclick="update_password(<?php echo `'`.$user['UUID'].`'` ?>)">Update password</button>
            </li>
        </ul>
    </div>
    <div class="items_area item_area_moderator">
        <div class="users_details">
            <div class="render_container">
                <h6>User Details</h6>
                <div class="input_group_linear">
                    <div class="input_element">
                        <p>First Name</p>
                        <input type="text" name="firstName" <?php 
                                                                if($mode = 'update'){
                                                                    ?>
                                                                        value='<?php echo $user["firstName"]?>'
                                                                    <?php
                                                                } 
                                                                ?> disabled>
                    </div>
                    <div class="input_element">
                        <p>Last Name</p>
                        <input type="text" name="lastName" <?php 
                                                                if($mode = 'update'){
                                                                    ?>
                                                                        value='<?php echo $user["lastName"]?>'
                                                                    <?php
                                                                } 
                                                                ?> disabled>
                    </div>
                    <div class="input_element">
                        <p>Other Name</p>
                        <input type="text" name="otherName" <?php 
                                                                if($mode = 'update'){
                                                                    ?>
                                                                        value='<?php echo $user["otherName"]?>'
                                                                    <?php
                                                                } 
                                                                ?> disabled>
                    </div>
                </div>
                <div class="input_group_linear">
                    <div class="input_element">
                        <p>User Name</p>
                        <input type="text" name="userName" <?php 
                                                                if($mode = 'update'){
                                                                    ?>
                                                                        value='<?php echo $user["userName"]?>'
                                                                    <?php
                                                                } 
                                                                ?> disabled>
                    </div>
                    <div class="input_element">
                        <p>Email</p>
                        <input type="email" name="emailAddress" <?php 
                                                                if($mode = 'update'){
                                                                    ?>
                                                                        value='<?php echo $user["Email"]?>'
                                                                    <?php
                                                                } 
                                                                ?> disabled>
                    </div>
                </div>
                <div class="input_group_linear">
                    <div class="input_element">
                        <p>Gender</p>
                        <input type="text" name="gender" <?php 
                                                                if($mode = 'update'){
                                                                    ?>
                                                                        value='<?php echo $user["gender"]?>'
                                                                    <?php
                                                                } 
                                                                ?> disabled>
                    </div>
                    <div class="input_element">
                        <p>City</p>
                        <input type="" name="city" <?php 
                                                                if($mode = 'update'){
                                                                    ?>
                                                                        value='<?php echo $user["city"]?>'
                                                                    <?php
                                                                } 
                                                                ?> disabled>
                    </div>
                </div>
                <div class="input_group_linear" <?php 
                                                                if($mode == !"updateMode"){
                                                                    ?>
                                                                        style="display: none;"
                                                                    <?php
                                                                } else {
                                                                    ?>
                                                                        style="display: flex;"
                                                                    <?php
                                                                }
                                                                ?> disabled>
                    <div class="input_element">
                        <p>Password</p>
                        <input type="password" name="Password" >
                    </div>
                    <div class="input_element">
                        <p>Confirm Password</p>
                        <input type="password" name="confirmPassword" >
                    </div>
                </div>
                <div class="input_group_linear">
                    <div class="input_element">
                        <p>Address</p>
                        <textarea name="Address" disabled><?php if($mode = 'update'){ ?> <?php echo $user["Address"] ?> <?php } ?></textarea>
                    </div>
                </div>

            </div>
            
            
        </div>
        <div class="user_configuration">
            <div class="render_container">
                <h6>User Details</h6>
                <div class="input_group_linear">
                    <div class="input_element">
                        <p>User ID </p>
                        <input type="text" name="userID" disabled <?php 
                                                                if($mode = 'update'){
                                                                    ?>
                                                                        value='<?php echo $user["UUID"]?>'
                                                                    <?php
                                                                } 
                                                                ?> disabled>
                    </div>
                </div>
                <div class="input_group_linear">
                    <div class="input_element">
                        <p>National ID </p>
                        <input type="text" name="nationalID" <?php 
                                                                if($mode = 'update'){
                                                                    ?>
                                                                        value='<?php echo $user["nationalId"]?>'
                                                                    <?php
                                                                } 
                                                                ?> disabled>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>