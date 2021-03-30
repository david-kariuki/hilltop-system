<?php

/**
* User class
* This class contains all the methods required for sales
*
* @author David Kariuki (dk)
* @author Peter Kimani (dk)
* @copyright Copyright (c) 2021 All Rights Reserved.
*/


// Sales class
class Reports
{
    use Systemclass; // Call System class

    /**
    * Class constructor
    */
    function __construct()
    {
                // Creating objects of the required classes

        // Initialize database connection class instance
        $connectionInstance = DatabaseConnection::getConnectionInstance();

        // Initialize connection object
        $this->connectToDB  = $connectionInstance->getDatabaseConnection();
    }

    /**
    * Class destructor
    */
    function __destruct()
    {

    }

    /**
    * Function to
    *
    */
    public function get_display_count($data){
        $table = $data['table'];
        $field_to_count = $data['field_to_count'];
        $date_range = $data['date_range'];
        $date1 = $date_range['start_date'];
        $date2 = $date_range['end_date'];
        $ref = $data['ref'];
        $head = $data['head'];

        $response = array(
            "status"=>false,
            "responseCode"=>1,
            "response"=>"Undefined response"
        );

        if($head == 'Products'){
            $data = array(
                'statement'=>"SELECT SUM($field_to_count) as currentStock FROM $table",
                'type'=>null,
                'values'=>null,
                'reference'=>null
            );

            $result = $this->database_action($data);

        } else {
            $data = array(
                'statement'=>"SELECT SUM($field_to_count) as $field_to_count FROM $table WHERE $ref BETWEEN ? AND ?", 
                'type'=>"ss",
                'values'=>[
                    $date1,
                    $date2
                ],
                'reference'=>true
            );

            $result = $this->database_action($data);

            
        }

        return $result;
    }

    /**
    * Function to
    *
    */
    public function get_bar_chart_data($data){
        $table = $data['table'];
        $field_to_count = $data['field_to_count'];
        $date_range = $data['dates'];
        $date1 = $date_range['start_date'];
        $date2 = $date_range['end_date'];
        $ref = $data['ref'];
        $head = $data['head'];

        $response = array(
            "status"=>false,
            "responseCode"=>1,
            "response"=>"Undefined response"
        );

        if($head == "Products"){

            var_dump("Products");

        }else{
            $data = array(
                'statement'=>"SELECT SUM($field_to_count) as $field_to_count FROM $table WHERE $ref BETWEEN ? AND ?", 
                'type'=>"ss",
                'values'=>[
                    $date1,
                    $date2
                ],
                'reference'=>true
            );

            $result = $this->database_action($data);

            if($result['status']){
                $response = $result['response'][0][$field_to_count];
            }
        }

        return $response;
        exit();
    }

    /**
     * Function to
     */
    public function get_table_data($data){
        $table = $data['table'];
        $field_to_count = $data['field_to_count'];
        $date_range = $data['dates'];
        $date1 = $date_range['start_date'];
        $date2 = $date_range['end_date'];
        $ref = $data['ref'];
        $head = $data['head'];

        $response = array(
            "status"=>false,
            "responseCode"=>1,
            "response"=>"Undefined response"
        );

        if($head == "Products"){

            $response = array(
                "status"=>false,
                "responseCode"=>1,
                "response"=>"Product Data"
            );

        }else{
            $data = array(
                'statement'=>"SELECT * FROM $table WHERE $ref BETWEEN ? AND ?", 
                'type'=>"ss",
                'values'=>[
                    $date1,
                    $date2
                ],
                'reference'=>true
            );

            $result = $this->database_action($data);

            $response = $result;
        }
        // var_dump($response);
        return $response;
    }

    /**
    * Function to
    *
    */
    public function database_action($data){

        $return = array(
            "status"=>false,
            "responseCode"=>1,
            "response"=>array()
        );

        if(isset($data)){
            $statement = $data['statement'];
            $type = $data['type'];
            $values = $data['values'];
            $reference = isset($data['reference']) ? $data['reference'] : null;

            if(isset($statement)){
                $stmt =$this->connectToDB->prepare($statement);
    
                if (false === $stmt) {
                    $return['responseCode'] = 101;
                    $return['response'] = 'read prepare() failed: ' . htmlspecialchars($this->connectToDB->error);
                    return $return;
                }
        
                if($reference){
                    $bind = $stmt->bind_param($type, ...$values); // Bind parameters
        
                    if(false === $bind){
                        $return['responseCode'] = 102;
                        $return['response'] = 'read bind_param() failed: ' . htmlspecialchars($stmt->error);
                        return $return;
                    }
                }

                $execute = $stmt->execute(); // Execute statement
        
                if(false === $execute){
                    $return['responseCode'] = 103;
                    $return['response'] = 'read execute() failed: ' . htmlspecialchars($stmt->error);
                    return $return;
                }


                if($execute){
                    $response = $stmt->get_result(); 

                    if($response->num_rows >= 1) {   
                        while ($data = $response->fetch_assoc()) {
                            
                            $return['status'] = true;
                            $return['responseCode'] = 0;
                            array_push($return['response'],$data);

                            // var_dump($data);
                        }
                    }else{
                        $return['status'] = true;
                        $return['responseCode'] = 1;
                        $return['response'] = "No Data found";
                    }
                }            
                
        
                return $return;
            }else{
                $return['responseCode'] = 3;
                $return['response'] = "No statement Declared";

                return $return;
            }
        }else{
            $return['responseCode'] = 2;
            $return['response'] = "Data was not received";

            return $return;
        }
        

    }

    /**
    * Function to
    *
    */
    public function format_date_rages($data){
        $response = array();

        $days = [
            "Mon",
            "Tue",
            "Wed",
            "Thu",
            "Fri",
            "Sat",
            "Sun"
        ];

        foreach ($data as $key => $value) {
            $start_date = $value." 00:00:00";
            $end_date = $value." 23:59:59";

            $delta = $key%7;
            $date = explode("-",$start_date);
            $date = $date[2];
            $date = explode(" ",$date);
            $date = $date[0];

            $temp_array = array(
                "start_date"=>$start_date,
                "end_date" => $end_date,
                "day"=>$days[$delta]."-".$date,
                "count"=>null
            );

            array_push($response,$temp_array);
        }

        return $response;
    }

        /**
    * Function to
    *
    */
    public function get_sub($data){
        $table = $data['table'];
        $id = $data['id'];
        $head = $data['head'];
        $ref = $data['ref'];

        $response = array(
            "status"=>false,
            "responseCode"=>1,
            "response"=>"Undefined response"
        );

        if($head == "Products"){

            var_dump("Products");

        }else{
            $data = array(
                'statement'=>"SELECT * FROM $table WHERE $ref = ?", 
                'type'=>"i",
                'values'=>[
                    $id
                ],
                'reference'=>true
            );

            $result = $this->database_action($data);

            return $result;
        }

        return $response;
        exit();   
    }
}

// EOF : Sales.php
// SELECT i.fk_productID, p.productName,sum(i.currentStock) as currentStock FROM `tbl_inventory` i JOIN tbl_products p ON i.fk_productID = p.UUID GROUP by p.UUID
