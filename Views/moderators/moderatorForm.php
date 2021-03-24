<?php
require_once $_SERVER['DOCUMENT_ROOT']."/app/php/Modal.php";
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$loadingData = $_REQUEST['loadingData'];
$mode = "new";
$user = null;

if(isset($_REQUEST['id'])){
    $mode = "update";

    $fields = array(
        "*",
    );
    $table = TABLE_USERS["NAME"];
    $order_by = "firstName";
    $order_set = "ASC";
    $offset = 0;
    $reference = array(
        "statement" => "UUID = ?",
        "type"=>"i",
        "values"=>[
            $_REQUEST['id']
        ]
    );

    $response = $admin->database_read_by_ref($table,$fields,$order_by,$order_set,$offset,$reference);

    if($response['status']){
        $user = $response['response'][0];
    }else{
        $mode = "new";
    }
}

?>
<div class="content_cover">
    <div class="view_title">
        <h3>Moderator Account</h3>
    </div>
    <div class="view_nav_bar">
        <ul>
            <li>
                <button onclick="open_selected_moderator('moderatorForm','createMode',null)">New Moderators</button>
            </li>
            <li>
                <button>Delete</button>
            </li>
            <?php
                if($loadingData == "updateMode"){
                    ?>
                        <li>
                            <button onclick="update_user(<?php echo $user['UUID'] ?>)">Update</button>
                        </li>
                    <?php
                } else {
                    ?>
                        <li>
                            <button onclick="create_user()">Save</button>
                        </li>
                    <?php
                }
            ?>
            
            <li>
            <select name="" id="">
                    <option value="QuickReports">Quick Reports</option>
                    <option value="List">List</option>
                </select>
            </li>
            <li>
                <select name="" id="">
                    <option value="QuickReports">Quick Reports</option>
                    <option value="List">List</option>
                </select>
            </li>
        </ul>
        <div class="element_search">
            <input type="Search">
        </div>
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
                                                                ?>>
                    </div>
                    <div class="input_element">
                        <p>Last Name</p>
                        <input type="text" name="lastName" <?php 
                                                                if($mode = 'update'){
                                                                    ?>
                                                                        value='<?php echo $user["lastName"]?>'
                                                                    <?php
                                                                } 
                                                                ?>>
                    </div>
                    <div class="input_element">
                        <p>Other Name</p>
                        <input type="text" name="otherName" <?php 
                                                                if($mode = 'update'){
                                                                    ?>
                                                                        value='<?php echo $user["otherName"]?>'
                                                                    <?php
                                                                } 
                                                                ?>>
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
                                                                ?>>
                    </div>
                    <div class="input_element">
                        <p>Email</p>
                        <input type="email" name="emailAddress" <?php 
                                                                if($mode = 'update'){
                                                                    ?>
                                                                        value='<?php echo $user["Email"]?>'
                                                                    <?php
                                                                } 
                                                                ?>>
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
                                                                ?>>
                    </div>
                    <div class="input_element">
                        <p>City</p>
                        <input type="" name="city" <?php 
                                                                if($mode = 'update'){
                                                                    ?>
                                                                        value='<?php echo $user["city"]?>'
                                                                    <?php
                                                                } 
                                                                ?>>
                    </div>
                </div>
                <div class="input_group_linear" <?php 
                                                                if($loadingData == "updateMode"){
                                                                    ?>
                                                                        style="display: none;"
                                                                    <?php
                                                                } else {
                                                                    ?>
                                                                        style="display: flex;"
                                                                    <?php
                                                                }
                                                                ?>>
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
                        <textarea name="Address"><?php if($mode = 'update'){ ?> <?php echo $user["Address"] ?> <?php } ?></textarea>
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
                                                                ?>>
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
                                                                ?>>
                    </div>
                </div>
                <div class="input_group_linear">
                    <div class="input_element">
                        <p>User Role </p>
                        <select name="role" id="">
                            <?php
                                if($mode = 'update'){
                                    $selected = $user['role'];
                                
                                    $roles = [
                                        ['superUser','Super User'],
                                        ['Admin','Admin'],
                                        ['Moderator','Moderator'],
                                        ['Manager','Manager'],
                                    ];

                                    foreach ($roles as $value) {
                                        ?>
                                        <option value="<?php echo $value[0].'" ' ; if($value[0] == $selected){ echo " selected = selected";}?>"><?php echo $value[1]?></option>
                                        <?php
                                    }
                                }else{
                                    ?>
                                    <option value="superUser">Super User</option>
                                    <option value="Admin">Admin</option>
                                    <option value="Moderator">Moderator</option>
                                    <option value="Manger">Manger</option>
                                    <?php
                                }
                            ?>
                            
                            
                        </select>
                    </div>
                </div>
                <div class="input_group_linear">
                    <div class="input_element">
                        <p>Status </p>
                        <select name="status" id="">
                        <?php
                            if($mode = 'update'){
                                $selected = $user['role'];
                                $status = [
                                    ['Active','Active'],
                                    ['Inactive','Inactive'],
                                ];

                                foreach ($status as $value) {
                                    ?>
                                        <option value=" <?php
                                                         echo $value[0] 
                                                        ?>"
                                                        <?php
                                                         if($value[0] == $selected){
                                                            echo 'selected = selected';
                                                         }
                                                        ?>
                                                         >
                                                         <?php
                                                            echo $value[1];
                                                         ?>
                                                         </option>        
                                    <?php
                                }
                            }else{
                                ?>
                                <option value="Active">Active</option>
                                <option value="Inactive">Inactive</option>
                                <?php
                            }
                        ?>
                            
                        </select>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>