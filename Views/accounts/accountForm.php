<?php
session_start();
$_SESSION['LOGGED_IN_ACCOUNT'] = 2;

?>
<div class="content_cover">
    <div class="view_title">
        <h3>Moderator Account</h3>
    </div>
    <div class="view_nav_bar">
        <ul>
            <li>
                <button>New Moderators</button>
            </li>
            <li>
                <button>Delete</button>
            </li>
            <li>
                <button onclick="update_user()">Update</button>
            </li>
            <?php
                if(isset($_SESSION['LOGGED_IN_ACCOUNT'])){
                    ?>
                        
                    <?php
                } else {
                    ?>
                        <li>
                            <button onclick="create_user()">Create</button>
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
                        <input type="text" name="firstName">
                    </div>
                    <div class="input_element">
                        <p>Last Name</p>
                        <input type="text" name="lastName">
                    </div>
                    <div class="input_element">
                        <p>Other Name</p>
                        <input type="text" name="otherName">
                    </div>
                </div>
                <div class="input_group_linear">
                    <div class="input_element">
                        <p>User Name</p>
                        <input type="text" name="userName">
                    </div>
                    <div class="input_element">
                        <p>Email</p>
                        <input type="email" name="emailAddress">
                    </div>
                </div>
                <div class="input_group_linear">
                    <div class="input_element">
                        <p>Gender</p>
                        <input type="text" name="gender">
                    </div>
                    <div class="input_element">
                        <p>City</p>
                        <input type="" name="city">
                    </div>
                </div>
                <div class="input_group_linear">
                    <div class="input_element">
                        <p>Password</p>
                        <input type="password" name="Password">
                    </div>
                    <div class="input_element">
                        <p>Confirm Password</p>
                        <input type="password" name="confirmPassword" >
                    </div>
                </div>
                <div class="input_group_linear">
                    <div class="input_element">
                        <p>Address</p>
                        <textarea name="Address" id="" ></textarea>
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
                        <input type="text" name="userID" disabled>
                    </div>
                </div>
                <div class="input_group_linear">
                    <div class="input_element">
                        <p>National ID </p>
                        <input type="text" name="nationalID">
                    </div>
                </div>
                <div class="input_group_linear">
                    <div class="input_element">
                        <p>User Role </p>
                        <select name="role" id="">
                            <option value="superUser">Super User</option>
                            <option value="Admin">Admin</option>
                            <option value="Moderator">Moderator</option>
                            <option value="Manger">Manger</option>
                        </select>
                    </div>
                </div>
                <div class="input_group_linear">
                    <div class="input_element">
                        <p>Status </p>
                        <select name="status" id="">
                            <option value="Active">Active</option>
                            <option value="Inactive">Inactive</option>
                        </select>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>