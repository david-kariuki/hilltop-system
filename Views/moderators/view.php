<?php

require_once $_SERVER['DOCUMENT_ROOT']."/app/php/Modal.php";
?>
<div class="content_cover">
    <div class="view_title">
        <h3>Moderators</h3>
    </div>
    <div class="view_nav_bar">
        <ul>
            <li>
                <button onclick="open_selected_moderator('moderatorForm','createMode',null)">New Moderators</button>
            </li>
            <li>
                <button onclick="delete_multiple_moderators()" >Delete</button>
            </li>
            <li>
                <button>Update</button>
            </li>
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
    <div class="items_area">
        <table>
            <thead>
                <tr>
                    <th scope="col"> <div class="check_element"><input type="checkbox" onchange="check_all()"></div> </th>
                    <th scope="col">#</th>
                    <th scope="col">Moderator ID</th>
                    <th scope="col">Moderator Name</th>
                    <th scope="col">Email</th>
                    <th scope="col">Phone</th>
                    <th scope="col">Status</th>
                    <th scope="col">Role</th>
                    
                </tr>
            </thead>
            <tbody>
                <?php
                    $fields = array(
                        "*",
                    );
                    $table = TABLE_USERS["NAME"];
                    $order_by = "firstName";
                    $order_set = "ASC";
                    $offset = 0;
                    $reference = null;

                    $response = $admin->database_read_by_ref($table,$fields,$order_by,$order_set,$offset,$reference);

                    if($response["status"] === true && $response['responseCode'] == 0){
                        $items = $response['response'];
                        $count = 1;

                        foreach ($items as $row) {
                    ?>
                            <tr onclick="open_selected_moderator('moderatorForm','updateMode',<?php echo $row['UUID'] ?>)" data-uid=<?php echo $row['UUID'] ?>>
                                <td onclick="select_current_moderator();"><div class="check_element"><input type="checkbox" onchange="check_item()"></div></td>
                                <td><?php echo $count ?></td>
                                <td><?php echo $row['UUID'] ?></td>
                                <td><?php echo $row['firstName']." ".$row['lastName'] ?></td>
                                <td><?php echo $row['Email'] ?></td>
                                <td><?php echo $row['nationalId'] ?></td>
                                <td><?php echo $row['status'] ?></td>
                                <td><?php echo $row['role'] ?></td>
                            </tr>
                            
                    <?php
                            $count++;
                        }
                    }
                    ?>
            </tbody>
        </table>
    </div>
    <div class="pagination">
        <ul>
            <?php
                if($response['status'] == true){
                    $itemCount = count($response['response']);
                    $page = (floor($itemCount / 25))+1;

                    if($page > 1){
                        ?>
                            <li id="previous_pagination"> <p>Prev</p> </li>
                            <?php
                                for ($i= 1; $i < $page  ; $i++) { 
                                    ?>
                                    <li> <p><?php echo $i ?></p> </li>
                                    <?php
                                }
                            ?>
                            <li class="next_pagination"> <p>Next</p> </li>
                        <?php
                    }
                }else{
                    echo "No records available please add a record to list.";
                }
            ?>

        </ul>
    </div>
</div>

