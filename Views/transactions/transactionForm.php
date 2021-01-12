<div class="content_cover">
    <div class="view_title">
        <h3>Transactions</h3>
    </div>
    <div class="view_nav_bar">
        <ul>
            <li>
                <button>New Transaction</button>
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
    <div class="items_area items_area_transactions">
        <div class="elemental_transaction">
            <div class="left_panel">
                <h6>Transaction Details</h6>
                <div class="input_group">
                    <div class="input_element">
                        <p>Transaction ID</p>
                        <input type="text">
                    </div>
                    <div class="input_element">
                        <p>Customer</p>
                        <input type="text">
                    </div>
                    <div class="input_element">
                        <p>Order ID</p>
                        <input type="text">
                    </div>
                    <div class="input_element">
                        <p>Date Created</p>
                        <input type="text">
                    </div>
                </div>
                <h6>Payment Details</h6>
                <div class="input_group">
                    <div class="input_element">
                        <p>Payment Method</p>
                        <input type="text">
                    </div>
                    <div class="input_element">
                        <p>Amount Payed</p>
                        <input type="text">
                    </div>
                    <div class="input_element">
                        <p>Balance as Was</p>
                        <input type="text">
                    </div>
                    <div class="input_element">
                        <p>Date Created ID</p>
                        <input type="text">
                    </div>
                </div>
            </div>
            <div class="right_panel">
                <h6>Related Transactions</h6>
                <div class="related_transaction_panel">
                    <div class="items_area">
                        <table>
                            <thead>
                                <tr>
                                    
                                    <th scope="col">#</th>
                                    <th scope="col">Transaction ID</th>
                                    <th scope="col">Customer Ref</th>
                                    <th scope="col">Sale Ref</th>
                                    
                                    <th scope="col">Transaction Value</th>
                                    
                                    
                                </tr>
                            </thead>
                            <tbody>
                                <?php

                                for($i = 0; $i < 30; $i++){
                                    ?>
                                <tr>
                                    <td><?php echo ($i + 1)?></td>
                                    <td>TR-0001</td>
                                    <td>Hill Top Limited</td>
                                    <td>SL-0001</td>
                                    
                                    <td>20,000</td>
                                    
                                    
                                </tr>
                                <?php
                                }?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>