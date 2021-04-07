<?php
include_once "../../app/php/Modal.php";
//TODO:confirm security token

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$_SESSION['TOKEN'] = false;
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
    }else{
        $action = $_REQUEST['action'];
        $data = $_REQUEST['data'];
    }
    

    switch ($action) {
        //figureOut the action
        case 'renderView':
            $head = $data['report_head'];
            $priority = $data['priority'];
            $span = $data['span'];
            $period_picker = $data['date_filter']['period_picker'];
            $response = array(
                "status"=>false,
                "name"=>$head,
                "title"=>$head,
                "Sales"=>array(),
                "Orders"=>array(),
                "Products"=>array(),
                "Revenue"=>array(),
            );
            $Report = new Reports();

            switch ($priority) {
                case 'Period':
                    $dateFrom = $data['date_filter']['date_from'];
                    $dateTo = $data['date_filter']['date_to'];

                    $dates = $temp_date = $date_range_list = null;

                    switch ($period_picker) {
                        case 'Day':
                            $dates = my_date_formatter($dateFrom,null,'Day');

                            $temp_date = my_date_formatter($dateFrom,null,'Week');
                            $date_range_list = list_days($temp_date);


                            break;
                        case 'Week':
                            $dates = my_date_formatter($dateFrom,null,'Week');
                            $date_range_list = list_days($dates);


                            break;
                        case 'Month':
                            $dates = my_date_formatter($dateFrom,null,'Month');
                            $date_range_list = list_days($dates);


                            break;
                        default:
                            $response = array(
                                "status"=>false,
                                "response_code"=>1,
                                "response"=>"Invalid period picked"
                            );
                
                            echo json_encode($response); 
                        break;
                    }

                    break;
                case 'Range':
                    $dateFrom = $data['date_filter']['date_from'];
                    $dateTo = $data['date_filter']['date_to'];

                    $dates = my_date_formatter($dateFrom,$dateTo);

                    $date_range_list = list_days($dates);

                    
                    break;
                default:
                    $response = array(
                        "status"=>false,
                        "response_code"=>1,
                        "response"=>"Invalid Priority"
                    );
        
                    echo json_encode($response); 
                    break;
            }

            $variables = array(
                "Reports"=>$Report,
                "dates"=>$dates,
                "date_range_list" =>$date_range_list,
                "head"=>$head
            );
            


            $variable_response = get_display_area_data($variables);

            foreach ($variable_response as $key => $displays) {
                    
                foreach ($displays as $title => $value) {
                    foreach ($value as $title1 => $value1) {
                        $temp = array(
                            $title1=>$value1
                        );
                        
                        $response[$key] = $temp;
                    }
                }
            }

            switch ($head) {
                case 'Sales':
                    $variables = array(
                        "head" => $head,
                        "date" => $dates,
                        "date_range" => $date_range_list,
                        "period_picker" => $period_picker
                    );
                    break;
                case 'Orders':
                    $variables = array(
                        "head" => $head,
                        "date" => $dates,
                        "date_range" => $date_range_list,
                        "period_picker" => $period_picker
                    );
                    break;
                case 'Revenue':
                    $variables = array(
                        "head" => $head,
                        "date" => $dates,
                        "date_range" => $date_range_list,
                        "period_picker" => $period_picker
                    );
                    break;
                case 'Products':
                    $variables = array(
                        "head" => $head,
                        "date" => $dates,
                        "date_range" => $date_range_list,
                        "period_picker" => $period_picker
                    );
                    break;

                default:
                    $response = array(
                        "status"=>false,
                        "response_code"=>2,
                        "response"=>"Invalid period header_report 1"
                    );
        
                    echo json_encode($response); 
                    break;
            }

            //get the given data
            $display_data = get_bar_chart_data($variables);

            switch ($head) {
                case 'Sales':
                    $response[$head]['bar_chart_data'] = $display_data;
                    break;
                case 'Orders':
                    $response[$head]['bar_chart_data'] = $display_data;
                    break;
                case 'Revenue':
                    $response[$head]['bar_chart_data'] = $display_data;
                    break;
                case 'Products':
                    $response[$head]['bar_chart_data'] = $display_data;
                    break;

                default:
                    $response = array(
                        "status"=>false,
                        "response_code"=>2,
                        "response"=>"Invalid period header_report 2"
                    );
        
                    echo json_encode($response); 
                    break;
            }
            $dates = my_date_formatter($dateFrom,$dateTo);
            //end
            switch ($head) {
                case 'Sales':
                    $variables = array(
                        "dates"=>$dates,
                        "period"=>$period_picker,
                        "date_range" =>$date_range_list,
                        "head"=>$head
                    );
                    $table_data = get_table_data($variables);
                    $name = $head."_table_data";
                    $response[$head][$name] = array();

                    if(is_array($table_data['response'])){
                        foreach ($table_data['response'] as $key => $value) {
                            

                            $id = $value['sale_ID'];
                            $table = "tbl_subsale";
                            $ref = "fk_SaleID";

                            $data = array(
                                "table" => $table,
                                "id" => $id,
                                "head" => $head,
                                "ref" => $ref,
                            );

                            $resp = get_sub($data);

                            if(is_array($resp)){
                                $sale = $value;
                                $sale['sub_sale'] = array();

                                foreach ($resp as $key1 => $value1) {
                                    array_push($sale['sub_sale'],$value1);
                                }
                            }

                            array_push($response[$head][$name],$sale);

                        }
                    }else{
                        array_push($response[$head][$name],$table_data['response']);
                    }
                    break;
                case 'Orders':
                    $variables = array(
                        "dates"=>$dates,
                        "period"=>$period_picker,
                        "date_range" =>$date_range_list,
                        "head"=>$head
                    );
                    $table_data = get_table_data($variables);
                    $name = $head."_table_data";
                    $response[$head][$name] = array();

                    if(is_array($table_data['response'])){
                        foreach ($table_data['response'] as $key => $value) {
                            

                            $id = $value['UUID'];
                            $table = "tbl_suborders";
                            $ref = "fk_OrderID";

                            $data = array(
                                "table" => $table,
                                "id" => $id,
                                "head" => $head,
                                "ref" => $ref,
                            );

                            $resp = get_sub($data);

                            if(is_array($resp)){
                                $sale = $value;
                                $sale['sub_sale'] = array();

                                foreach ($resp as $key1 => $value1) {
                                    array_push($sale['sub_sale'],$value1);
                                }
                            }

                            array_push($response[$head][$name],$sale);

                        }
                    }else{
                        array_push($response[$head][$name],$table_data['response']);
                    }
                    break;
                case 'Revenue':
                    $variables = array(
                        "dates"=>$dates,
                        "period"=>$period_picker,
                        "date_range" =>$date_range_list,
                        "head"=>$head
                    );
                    $table_data = get_table_data($variables);
                    $name = $head."_table_data";
                    $response[$head][$name] = array();

                    if(is_array($table_data['response'])){
                        foreach ($table_data['response'] as $key => $value) {
                            

                            $id = $value['sale_ID'];
                            $table = "tbl_transaction";
                            $ref = "fk_saleReference";

                            $data = array(
                                "table" => $table,
                                "id" => $id,
                                "head" => $head,
                                "ref" => $ref,
                            );

                            $resp = get_sub($data);

                            if(is_array($resp)){
                                $sale = $value;
                                $sale['sub_sale'] = array();

                                foreach ($resp as $key1 => $value1) {
                                    array_push($sale['sub_sale'],$value1);
                                }
                            }

                            array_push($response[$head][$name],$sale);

                        }
                    }else{
                        array_push($response[$head][$name],$table_data['response']);
                    }
                    break;
                case 'Products':
                    $variables = array(
                        "dates"=>$dates,
                        "period"=>$period_picker,
                        "date_range" =>$date_range_list,
                        "head"=>$head
                    );
                    $table_data = get_table_data($variables);
                    $name = $head."_table_data";
                    $response[$head][$name] = array();

                    if(is_array($table_data['response'])){
                        foreach ($table_data['response'] as $key => $value) {
                            

                            $id = $value['sale_ID'];
                            $ref = "fk_productID";
                            $table = "tbl_subsale";
                            $ref = "fk_SaleID";

                            $data = array(
                                "table" => $table,
                                "id" => $id,
                                "head" => $head,
                                "ref" => $ref,
                            );

                            $resp = get_sub($data);

                            if(is_array($resp)){
                                $sale = $value;
                                $sale['sub_sale'] = array();

                                foreach ($resp as $key1 => $value1) {
                                    array_push($sale['sub_sale'],$value1);
                                }
                            }

                            array_push($response[$head][$name],$sale);

                        }
                    }else{
                        array_push($response[$head][$name],$table_data['response']);
                    }
                    break;
                
                default:
                    # code...
                    break;
            }
            $response['status'] = true;
            echo json_encode($response);

            break;
        case "export_report":
            $format = $data['format'];


            //fromat data to csv;
            $title = $data['Title'];
            $period = $data['Period'];
            $dates = $data['range'];
            $date_today = date('m/d/Y');
            $table_data = $data['sub_data'];
            $format = $data['format'];

            $response = array(
                "Title" => $title,
                "Period" => null,
                "Date_today" =>  $date_today,
                "Format" => $format,
                "table_data" => $table_data
            );

            switch ($period) {
                case 'Day':
                    $response['Period'] = "Daily Report";
                    break;
                case 'Week':
                    $response['Period'] = "Weekly Report";
                    break;
                case 'Month':
                    $response['Period'] = "Monthly report";
                    break;
                default:
                    $response['Period'] = "From ".$dates['from']." to ".$dates['to'];
                    break;
            }
            $_SESSION['reports_data'] = json_encode($response);
            
            echo json_encode($_SESSION['reports_data']);
        
            break;
        default:
            $response = array(
                "status"=>false,
                "response_code"=>1,
                "response"=>"Invalid Action"
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

function my_date_formatter($date1,$date2 = null,$instruction = null){
    $dates = null;

    if(isset($date2)){
        $dates = array(
            "start_date"=>$date1." 00:00:00",
            "end_date"=>$date2." 23:59:59"
        );
        
    } else {
        switch ($instruction) {
            case 'Week':

                $date = new DateTime($date1);
                $week = $date->format("W");
                $year = $date->format("Y");
                $dates=get_week_start_and_end($week,$year);

                break;
            case 'Month':
                $date = new DateTime($date1);
                $month = $date->format("m");
                $year = $date->format("Y");
                $dates=get_Month_start_and_end($month,$year);

                break;
            
            default:
                $dates = array(
                    "start_date"=>$date1." 00:00:00",
                    "end_date"=>$date1." 23:59:59"
                );
                break;
        }
    }
    

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

function get_Month_start_and_end($month,$year){


    $result = strtotime("{$year}-{$month}-01");
    $result = strtotime('-1 second', strtotime('+1 month', $result));
    
    $last_date = date('Y-m-d', $result);

    $result = strtotime("{$year}-{$month}-01");
    $first_day =  date('Y-m-d', $result);

    $dates = array(
        "start_date"=>$first_day." 00:00:00",
        "end_date"=>$last_date." 23:59:59",
    );

    return $dates;
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

            $all_sales = null; //$Report->get_by_period("tbl_sale",$dates);

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

function get_display_area_data($variables){
    $response = array(
        "Sales"=>array(),
        "Orders"=>array(),
        "Revenue"=>array(),
        "Products"=>array()
    );

    $array_response = array(
        "Sales"=>null,
        "Orders"=>null,
        "Revenue"=>null,
        "Products"=>null
    );

    $head = $variables['head'];
    $report = $variables['Reports'];
    $date_range = $variables['dates'];
    $data = null;

    foreach ($response as $key => $value) {
        switch ($key) {
            case 'Sales':
                $data = array(
                    "table"=>"tbl_sale",
                    "field_to_count"=>"saleQuantity",
                    "date_range"=>$date_range,
                    "ref"=>"dateCreated",
                    "head"=>$key
                );
                break;
            case 'Orders':
                $data = array(
                    "table"=>"tbl_orders",
                    "field_to_count"=>"Amount",
                    "date_range"=>$date_range,
                    "ref"=>"date_created",
                    "head"=>$key
                );
                break;
            case 'Revenue':
                $data = array(
                    "table"=>"tbl_transaction",
                    "field_to_count"=>"transactionValue",
                    "date_range"=>$date_range,
                    "ref"=>"dateCreated",
                    "head"=>$key
                );
                break;
            case 'Products':
                $data = array(
                    "table"=>"tbl_inventory",
                    "field_to_count"=>"currentStock",
                    "date_range"=>$date_range,
                    "ref"=>"dateCreated",
                    "head"=>$key
                );
                break;
            
            default:
                $result = array(
                    "status"=>false,
                    "responseCode"=>1,
                    "response"=>"Invalid head report"
                );
                echo json_encode($result);
                break;
            
        }
        // var_dump($data);
        $result = ($report->get_display_count($data));

        $result = $result['response'];

        foreach ($result as $key1 => $value1) {
            $complete_result = array(
                "count"=>$value1
            );

            $array_response[$key] = $complete_result;
        }
    }
    return $array_response;
}
function get_bar_chart_data($variables){
    $head = $variables['head'];
    $dates = $variables['date'];
    $range = $variables['date_range'];
    $period_picker = $variables['period_picker'];
    $Report = new Reports();
    $data1 = null;

    $bar_chart_data = array(
        "title" => $head,
        "Heading" => "",
        "chart_description"=>"",
        "x-axis"=>array()
    );




    switch ($head) {
        case 'Sales':
            $data1 = array(
                    "table"=>"tbl_sale",
                    "field_to_count"=>"saleQuantity",
                    "dates" =>$dates,
                    "ref"=>"dateCreated",
                    "head"=>$head
                );
            break;
        case 'Orders':
            $data1 = array(
                    "table"=>"tbl_orders",
                    "field_to_count"=>"Quantity",
                    "dates" =>$dates,
                    "ref"=>"date_created",
                    "head"=>$head
                );
            break;
        case 'Revenue':
            $data1 = array(
                    "table"=>"tbl_transaction",
                    "field_to_count"=>"transactionValue",
                    "dates" =>$dates,
                    "ref"=>"dateCreated",
                    "head"=>$head
                );
            break;
        case 'Products':
            $data1 = array(
                    "table"=>"tbl_sale",
                    "field_to_count"=>"saleQuantity",
                    "dates" =>$dates,
                    "ref"=>"dateCreated",
                    "head"=>$head
                );
            break;
        
        default:
            # code...
            break;
    }

    $date_ranges = $Report->format_date_rages($range);
    
    if($period_picker == "Month"){
        array_pop($date_ranges);
    }

    $bar_data = array();
    foreach ($date_ranges as $key => $value) {
        $data1['dates'] = $value;

        $response = $Report->get_bar_chart_data($data1);
        
        $field_to_count = $data1['field_to_count'];

        if($response == null){
            $response = number_format(0);
        } else {
            $response = number_format($response); 
        }

        $value['count'] = $response;

        array_push($bar_data,$value);
    }

    return $bar_data;
}
function get_table_data($variables){

    $head = $variables['head'];
    $dates = $variables['dates'];
    $range = $variables['date_range'];
    $period_picker = $variables['period'];
    $Report = new Reports();
    $data1 = null;

    if($variables['period'] == "Month"){
        $start_date = array_shift($range);
        array_pop($range);
        $end_date = end($range);

        $dates = array(
            "start_date"=>$start_date,
            "end_date"=>$end_date
        );
    }else if($variables['period'] == "Week"){
        $dates = explode(" ",$dates['start_date']);
        $dates = $dates[0];
        $dates = my_date_formatter($dates,null,"Week");

        $dates['start_date'] = $dates['start_date']." 00:00:00:";
        $dates['end_date'] = $dates['end_date']." 23:59:59:";

    }else if($variables['period'] == "Day"){
    }

    $data = null;

    switch ($head) {
        case 'Sales':
            $data = array(
                "table" => "tbl_sale",
                "field_to_count" => "saleQuantity",
                "dates" => $dates,
                "ref" => "dateCreated",
                "head" => $head,
            );
            break;
        case 'Orders':
            $data = array(
                "table" => "tbl_orders",
                "field_to_count" => "Quantity",
                "dates" => $dates,
                "ref" => "date_created",
                "head" => $head,
            );
            break;
        case 'Revenue':
            $data = array(
                "table" => "tbl_sale",
                "field_to_count" => "saleQuantity",
                "dates" => $dates,
                "ref" => "dateCreated",
                "head" => $head,
            );
            break;
        case 'Products':
            var_dump("none");
            break;
        
        default:
            var_dump("none");   
            break;
    }

    $return = $Report->get_table_data($data);

    return $return;
}
function get_sub($variable){
    $Report = new Reports();
    $resp = $Report->get_sub($variable);

    return $resp;
}

function P($data){
    var_dump($data);
}