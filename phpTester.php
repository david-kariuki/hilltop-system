<?php
include_once "../../app/php/Modal.php";
//TODO:confirm security token

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$_SESSION['TOKEN'] = 123;
$test_mode = false;

if (isset($_SESSION['TOKEN'])) {
    $response = array(
        "status"=>false,
        "response_code"=>1,
        "response"=>"Premature Termination"
    );

    $params = array();
    if($test_mode){
        array_push($params,extract_data());
        $action = $params[0]['action'];
        $data = $params[0]['data'];
        $head = $data['report_head'];
        $priority = $data['priority'];
        $span = $data['span'];
    }else{
        
        $action = $_REQUEST['action'];
        $data = $_REQUEST['data'];
        $head = $data['report_head'];
        $priority = $data['priority'];
        $span = $data['span'];
    }

    switch($priority){
        case "Period":
            $dates = my_date_formatter($data['date_filter']['date_from'],$data['date_filter']['date_to']);

            $Report = new Reports();
            $sales_quantity_amount = $Report->get_count('tbl_sale','amount',$dates,);
            $Order_quantity_amount = $Report->get_count('tbl_orders','Amount',$dates,'date_created');
            $Revenue_amount = $Report->get_count('tbl_transaction','transactionValue',$dates);

            if(($sales_quantity_amount['status'] == true) && ($Order_quantity_amount['status'] == true) && ($Revenue_amount['status'] == true)){
                $todays_date = date('Y-m-d');
                $report = array(
                    "name"=>$head,
                    "report"=> $todays_date,
                    "status"=>0,
                    "sales"=>array(),
                    "orders" => array(),
                    "Revenue"=>array(),
                    "bar_data"=>array()
                );
                switch($head){
                    case "Sales":
                            $sales_query = $Report->get_by_period("tbl_sale",$dates);  
                        
                            $sale_entry_template = array(
                                "sale_ID"=>null,
                                "sale_Type"=>null,
                                "sale_Amount"=>null,
                                "sale_Quantity"=>null,
                                "sub_Sales"=> array(),

                            );

                            if($sales_query['status']){
                        

                                $sales = $sales_query['response'];
                                
                                $sub_sales = array(
                                    "sub_sale_ID"=>null,
                                    "sub_sale_product_name"=>null,
                                    "sub_sale_quantity"=>null,
                                    "sub_sale_Amount"=>null,
                                );
                                if($sales_query['responseCode'] == 0){
                                    $report["status"] = 0;
                                    foreach ($sales as $key => $value) {


                                        $id = $value['sale_ID'];

                                        $table = "tbl_subsale";
                                        $fields = array(
                                            "*",
                                        );
                                        $order_by = "UUID";
                                        $order_set = "ASC";
                                        $offset = 0;
                                        $reference = array(
                                            "statement" => "fk_SaleID = ?",
                                            "type"=>"s",
                                            "values"=>[
                                                $id
                                            ]
                                        );

                                        $response = $admin->database_read_by_ref($table,$fields,$order_by,$order_set,$offset,$reference);

                                        if($response['status'] == true){
                                            $sub_sale = $response['response'][0];

                                            $product_ID = $sub_sale['fk_productID'];
                                            $sub_sale_ID = $sub_sale['UUID'];
                                            $sub_sale_quantity = $sub_sale ['quantity'];
                                            $sub_sale_Amount = $sub_sale['subTotal'];
                                            $product_name = null;

                                            $sale_id = $sub_sale['fk_productID'];

                                            $table = "tbl_inventory";
                                            $fields = array(
                                                "*",
                                            );
                                            $order_by = "UUID";
                                            $order_set = "ASC";
                                            $offset = 0;
                                            $reference = array(
                                                "statement" => "UUID = ?",
                                                "type"=>"s",
                                                "values"=>[
                                                    $sale_id
                                                ]
                                            );

                                            $response2 = $admin->database_read_by_ref($table,$fields,$order_by,$order_set,$offset,$reference);

                                            if($response2['status']){
                                            $inventory_ID = $response2['response'][0]['fk_productID']; 

                                            $table = "tbl_products";

                                                $fields = array(
                                                    "*",
                                                );
                                                $order_by = "UUID";
                                                $order_set = "ASC";
                                                $offset = 0;
                                                $reference = array(
                                                    "statement" => "UUID = ?",
                                                    "type"=>"s",
                                                    "values"=>[
                                                        $inventory_ID
                                                    ]
                                                );

                                                $response3 = $admin->database_read_by_ref($table,$fields,$order_by,$order_set,$offset,$reference);

                                                if($response3['status']){

                                                    $product_name = $response3['response'][0]['productName'];
                                                }else{
                                                    var_dump($response3);
                                                }
                                            }else{
                                                var_dump($response2);
                                            }
                                            $sub_sale_template = array(
                                                "sub_sale_ID"=>$sub_sale_ID,
                                                "sub_sale_product_name"=>$product_name,
                                                "sub_sale_product_ID"=>$inventory_ID,
                                                "sub_sale_Quantity"=>$sub_sale_quantity,
                                                "sub_sale_Amount"=>$sub_sale_Amount
                                            );

                                            array_push($sale_entry_template['sub_Sales'],$sub_sale_template);
                                        }else{
                                            var_dump($response);
                                        }
                                        $sale_entry_template['sale_ID'] = $value['sale_ID'];
                                        $sale_entry_template['sale_Type'] = $value['saleType'];
                                        $sale_entry_template['sale_Amount'] = $value['amount'];
                                        $sale_entry_template['sale_Quantity'] = $value['saleQuantity'];
                                        
                                        $report['sales'];

                                        array_push($report['sales'],$sale_entry_template);
                                    }
                                }else{
                                    $report["status"] = 101;
                                }
                            } else {
                                var_dump($response);
                            }

                            switch($span){
                                case "Day":
                                    $date = new DateTime($dates['from']);
                                    $week = $date->format("W");
                                    $year = $date->format("Y");

                                    $dates=get_week_start_and_end($week,$year);

                                    $range_list = list_days($dates);

                                    $data_set = get_sales_per_date($range_list);

                                    array_push($report['bar_data'],$data_set);
                                    echo json_encode($report);
                                    

                                    break;
                                case "Weekly":
                                    break;
                                case "Monthly":
                                    break;
                                case "Annualy":
                                    break;
                                default:
                                    $response = array(
                                        "status"=>false,
                                        "response_code"=>1,
                                        "response"=>"Period is not the priority"
                                    );
                                
                                    echo json_encode($response);
                                break;
                            }

                            

                        
                        break;
                    case "Revenue":
                        break;
                    case "Orders":
                        break;
                    case "Products":
                        break;
                    default:
                        $response = array(
                            "status"=>false,
                            "response_code"=>1,
                            "response"=>"Period is not the priority"
                        );

                        echo json_encode($response);
                    break;
                }
            }else{
                if(($sales_quantity_amount['status'] != true)){
                    echo json_encode($sales_quantity_amount);
                    exit();
                }else if(($Order_quantity_amount['status'] == true)){
                    echo json_encode($Order_quantity_amount);
                    exit();
                }else{
                    echo json_encode($Revenue_amount);
                    exit();
                }
            }



            break;
        default:
            $response = array(
                "status"=>false,
                "response_code"=>1,
                "response"=>"Period is not the priority"
            );
        
            echo json_encode($response);
        break;
    }
    
}else{
    $response = array(
        "status"=>false,
        "response_code"=>1,
        "response"=>"Token was not Passed"
    );

    echo json_encode($response);
}


function extract_data($data = null){
    $params = (array) json_decode(file_get_contents('php://input'), TRUE);
    return $params;
}

function exporter($data = null){
    if(isset($data)){
        echo json_encode($data);
    }else{
        $response = array(
            "status"=>false,
            "response_code"=>1,
            "response"=>"There was no data passed"
        );

        echo json_encode($response);
    }
}

function my_date_formatter($date1,$date2){
    $dates = array(
        "from"=>$date1." 00:00:00",
        "to"=>$date2." 23:59:00"
    );

    return $dates;
}

function get_week_start_and_end($week,$year){
  $dateTime = new DateTime();
  $dateTime->setISODate($year, $week);
  $result['start_date'] = $dateTime->format('Y-m-d');
  $dateTime->modify('+6 days');
  $result['end_date'] = $dateTime->format('Y-m-d');
  return $result;
}

function list_days($dates){
    $start_date = new DateTime($dates['start_date']);
    $end_date = new DateTime($dates['end_date']);
    $end_date = $end_date->modify( '+1 day' );
    $interval = new DateInterval('P1D');

    $date_range = new DatePeriod($start_date,$interval,$end_date);

    $range_list = array();

    foreach ($date_range as $date) {
        array_push($range_list,$date->format("Y-m-d"));
    }

    return $range_list;
}

function get_sales_per_date($range){

    if(isset($range)){
        $response = array(
            "status"=>false,
            "responseCode"=>1,
            "response" => array()
        );
        foreach ($range as  $date) {
            $count = 0;
            $temp_date = array(
                "date"=>$date,
                "count"=>$count,
                "sales"=>array()
            );
            $start_date = $date." 00:00:00";
            $end_date = $date." 23:59:59";

            $dates = array(
                "from"=>$start_date,
                "to"=>$end_date
            );

            $Report = new Reports();

            $all_sales = $Report->get_by_period("tbl_sale",$dates);

            if($all_sales['status']){

                if($all_sales['responseCode'] == 0){
                    $sales = $all_sales['response'];

                    foreach ($sales as $sale) {

                        $temp_array = array(
                            "sale_ID" => $sale['sale_ID'],
                            "saleType" => $sale['saleType'],
                            "saleQuantity" => $sale['saleQuantity'],
                            "amount" => $sale['amount'],
                            "dateCreated" => $sale['dateCreated'],
                        );

                        array_push($temp_date['sales'],$temp_array);
                        $count++;
                    }
                    $temp_date['count'] = $count;
                }else{
                }
            }else{
                return $all_sales;
            }
            array_push($response['response'],$temp_date);
        }
        $response['status'] = true;
        $response['responseCode'] = true;

        return $response;
    }
}







































$response = array(
    "name"=>null,
    "title"=>null,
    "sales"=>array(
        "status"=>false,
        "responseCode"=>1,
        "response"=> array(
            "title"=>null,
            "stat_display",
            "bar_chart_data"=> array(
                "status"=>false,
                "responseCode"=>1,
                "response"=> array()
            ),
            "table_data"=> array(
                "status"=>false,
                "responseCode"=>1,
                "response"=> array()
            ),
            "pie_chart_data"=> array(
                "status"=>false,
                "responseCode"=>1,
                "response"=> array()
            ),
        )
    ),
    "Orders"=>array(
        "status"=>false,
        "responseCode"=>1,
        "response"=> array(
            "title"=>null,
            "stat_display",
            "bar_chart_data"=> array(
                "status"=>false,
                "responseCode"=>1,
                "response"=> array()
            ),
            "table_data"=> array(
                "status"=>false,
                "responseCode"=>1,
                "response"=> array()
            ),
            "pie_chart_data"=> array(
                "status"=>false,
                "responseCode"=>1,
                "response"=> array()
            ),
        )
    ),
    "Revenue"=>array(
        "status"=>false,
        "responseCode"=>1,
        "response"=> array(
            "title"=>null,
            "stat_display",
            "bar_chart_data"=> array(
                "status"=>false,
                "responseCode"=>1,
                "response"=> array()
            ),
            "table_data"=> array(
                "status"=>false,
                "responseCode"=>1,
                "response"=> array()
            ),
            "pie_chart_data"=> array(
                "status"=>false,
                "responseCode"=>1,
                "response"=> array()
            ),
        )
    ),
    "Products"=>array(
        "status"=>false,
        "responseCode"=>1,
        "response"=> array(
            "title"=>null,
            "stat_display",
            "bar_chart_data"=> array(
                "status"=>false,
                "responseCode"=>1,
                "response"=> array()
            ),
            "table_data"=> array(
                "status"=>false,
                "responseCode"=>1,
                "response"=> array()
            ),
            "pie_chart_data"=> array(
                "status"=>false,
                "responseCode"=>1,
                "response"=> array()
            ),
        )
    ),
);