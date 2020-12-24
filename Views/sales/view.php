<div class="content_cover">
                <div class="view_title">
                    <h3>Sales</h3>
                </div>
                <div class="view_nav_bar">
                    <ul>
                        <li>
                            <button>New Sale</button>
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
                                <th scope="col">Sale ID</th>
                                <th scope="col">Customer Name</th>
                                <th scope="col">Sale Value</th>
                                <th scope="col">Sale Quantity</th>
                                <th scope="col">Transaction Ref</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php

                            for($i = 0; $i < 30; $i++){
                                ?>
                            <tr>
                                <td><div class="check_element"><input type="checkbox"></div></td>
                                <td><?php echo ($i + 1)?></td>
                                <td>SL-0001</td>
                                <td>Hill Top</td>
                                <td>20,000.00</td>
                                <td>3</td>
                                <td>TR-0001</td> 
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