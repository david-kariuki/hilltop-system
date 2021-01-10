<div class="content_cover">
    <div class="view_title">
        <h3>P.O.S</h3>
    </div>
    <div class="view_nav_bar">
        <ul>
            <li>
                <button>New Item</button>
            </li>
        </ul>
        <div class="element_search">
            <input type="Search">
        </div>
    </div>
    <div class="sale_customer_panel">
        <div class="customer_panel">
            <div>
                <h3>Customer Details</h3>
            </div>
            <div class="items_panel">
                <div class="section1">
                    <div class="input_area">
                        <h4>Customer</h4>
                        <input type="text">
                    </div>
                    <div class="input_area">
                        <h4>Customer Tel</h4>
                        <input type="text">
                    </div>
                </div>
                <div class="section2">
                    <div class="input_area">
                        <h4>Customer</h4>
                        <textarea name="" id="" cols="30" rows="10"></textarea>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="sales_panel">
            <div>
                <h3>Sales Details</h3>
            </div>
            <div class="items_panel">
            <div class="section1">
                    <div class="input_area">
                        <h4>Sale ID</h4>
                        <input type="text">
                    </div>
                    <div class="input_area">
                        <h4>Date</h4>
                        <input type="text">
                    </div>
                </div>
                <div class="section2">
                <div class="input_area">
                        <h4>Sale Representative</h4>
                        <input type="text">
                    </div>
                    <div class="input_area">
                        <h4>Sale Type</h4>
                        <input type="text">
                    </div>
                </div>
            </div>
        </div>
        
        
    </div>
    <div class="sale_details_list">
        <div class="items_area">
            <table>
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Product Name</th>
                        <th scope="col">Quantity</th>
                        <th scope="col">Price</th>
                        <th scope="col">Sub Total</th>
                        <th scope="col">#</th>
                        
                    </tr>
                </thead>
                <tbody>
                <?php

                    for($i = 0; $i < 9; $i++){
                        ?>
                    <tr>
                        <td><?php echo ($i + 1)?></td>
                        <td>Captain Morgan</td>
                        <td>20</td>
                        <td>950</td>
                        <td>950</td>
                        <td class="cancel_button" onclick="alert('clicked')"><div>x</div></td>
                    </tr>
                    <?php
                    }?>
                </tbody>
            </table>
            <div class="sale_note_element">
                <h5>Sales Note</h5>
                <textarea name="" id="" cols="30" rows="10"></textarea>
            </div>
        </div>
        <div class="sales_complete_tally">
            <div class="tally_item">
                <h6>Quantity</h6>
                <p>37</p>
            </div>
            <div class="tally_item">
                <h6>Amount</h6>
                <p>37</p>
            </div>
            <div class="items_discount">
                <h6>Discount</h6>
                <div class="discount_option">
                    <input type="text" placeholder="Ksh">
                    <input type="text" placeholder="%">
                </div>
            </div>
            <div class="total_sale_amount">
                <h6>Total Amount</h6>
                <p>Ksh 45,000</p>
            </div>
            <div class="action_button_elements">
                <button class="btn_action_sale btn1">Confirm Sale</button>
                <button class="btn_action_sale btn2">Make Payment</button>
                <button class="btn_action_sale btn3">Cancel Sale</button>
                <button class="btn_action_sale btn4">Confirm as Quotation</button>
            </div>
        </div>
        
        
    </div>
</div>
