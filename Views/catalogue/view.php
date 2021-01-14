<div class="content_cover">
    <div class="view_title">
        <h3>Catalogue</h3>
    </div>
    <div class="view_nav_bar">
        <ul>
            <li>
                <button>New Item</button>
            </li>
            <li>
                <button>Delete</button>
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
                    <th scope="col"> <div class="check_element"><input type="checkbox"></div> </th>
                    <th scope="col">#</th>
                    <th scope="col">Product ID</th>
                    <th scope="col">Product Name</th>
                    <th scope="col">Quantity on hand</th>
                    <th scope="col">Price</th>
                    <th scope="col">Status</th>
                    <th scope="col">Category</th>
                    
                </tr>
            </thead>
            <tbody>
                <?php

                for($i = 0; $i < 30; $i++){
                    ?>
                <tr onclick="open_selected_product('catalogueForm')">
                    <td onclick="select_current_product();"><div class="check_element"><input type="checkbox"></div></td>
                    <td><?php echo ($i + 1)?></td>
                    <td>PL-0001</td>
                    <td>Captain Morgan</td>
                    <td>20</td>
                    <td>950</td>
                    <td>Active</td>
                    <td>Category</td>
                    
                </tr>
                <?php
                }?>
            </tbody>
        </table>
    </div>
    <div class="pagination">
        <ul>
            <li id="previous_pagination"> <p>Prev</p> </li>
            <li> <p>1</p> </li>
            <li> <p>2</p> </li>
            <li class="next_pagination"> <p>Next</p> </li>
        </ul>
    </div>
</div>