<?php

/**
* User class
* This class contains all the methods required by a catalog
*
* @author David Kariuki (dk)
* @author Peter Kimani (dk)
* @copyright Copyright (c) 2021 All Rights Reserved.
*/


// Catalog class
trait Catalogue
{

    /**
    * Class constructor
    */
    function __construct()
    {

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
    public function addProductToDatabase($data,$sub_retail,$sub_wholesale,$sub_vehicle,$table){
        
        $response = [
            false,
        ];

        $tempArray  = array();

        // Check if user data is passed as array
        if (is_array($data)) {

            $arrayCount = count($data); // Get array count

            // Check array count length
            if ($arrayCount > 0) {
                $ID = $this->unique_ID_generator();

                $fields = array(); // Array to hold user data fields
                $values = array("MD_".$ID); // Array to hold user data values

                $user_ID = $this->get_my_id($_SESSION['LOGGED_USER']);

                if($user_ID['status']){
                    $user_ID = $user_ID['response'][0]['UUID'];
                }

                $fields = array(
                    "UUID",
                    "productName",
                    "productType",
                    "visibility",
                    "enableEdit",
                    "Notes",
                    "fk_addedBy",
                    "fk_modifiedBy"
                );

                $fieldsCombined = implode("`,`", $fields); // Join array elements with a comma
                $fieldsCombined = "`".$fieldsCombined."`";
                $placeholders = "?,?,?,?,?,?,?,?";
                $type = "isssssii";
                $values = array(
                    $ID,
                    $data['productName'],
                    $data['productType'],
                    $data['visibility'],
                    $data['enableEdit'],
                    $data['Notes'],
                    $user_ID,
                    $user_ID
                );
                

                $insert = $this->insert_to_database($table,$fieldsCombined,$placeholders,$type,$values);

                if($insert['status']){
                    $retail = $sub_retail;
                    $wholesale = $sub_wholesale;
                    $vehicle = $sub_vehicle;

                    $retail = $this->addSubProductDetails($retail,$ID,1);
                    $wholesale = $this->addSubProductDetails($wholesale,$ID,2);
                    $vehicle = $this->addSubProductDetails($vehicle,$ID,3);

                    if($retail['status'] && $wholesale['status'] && $vehicle['status']){
                        return $insert;
                    } else {
                        $response = array(
                            "status"=>false,
                            "response"=>'Error adding product'
                        );

                        return $response;
                    }
                }else{
                    return $insert;
                }
            }
        }

        return $response; // Return response array
    }

    /**
    * Function to
    *
    */
    public function updateProductByReference($data,$sub_retail,$sub_wholesale,$sub_vehicle, $table,$id){
        $response = [
            false,
        ];

        $tempArray  = array();

        // Check if user data is passed as array
        if (is_array($data)) {

            $arrayCount = count($data); // Get array count

            // Check array count length
            if ($arrayCount > 0) {

                $fields = array(); // Array to hold user data fields

                $user_ID = $this->get_my_id($_SESSION['LOGGED_USER']);

                if($user_ID['status']){
                    $user_ID = $user_ID['response'][0]['UUID'];
                }

                //check
                $fields = array(
                    "productName",
                    "productType",
                    "visibility",
                    "enableEdit",
                    "Notes",
                    "fk_addedBy",
                    "fk_modifiedBy"
                );
                $fieldsCombined = implode("`,`", $fields); // Join array elements with a comma
                $fieldsCombined = "`".$fieldsCombined."`";

                $values = array(
                    [$data['productName'],"si"],
                    [$data['productType'],"si"],
                    [$data['visibility'],"si"],
                    [$data['enableEdit'],"si"],
                    [$data['Notes'],"si"],
                    [$user_ID,"ii"],
                    [$user_ID,"ii"]
                );

                $data_combined = array_combine($fields,$values);

                $update = $this->database_update($table,$data_combined,$id);
                //end check

                if($update['status']){
                    $retail = $sub_retail;
                    $wholesale = $sub_wholesale;
                    $vehicle = $sub_vehicle;

                    $retail = $this->updateSubProductDetails($retail,$id,1);
                    $wholesale = $this->updateSubProductDetails($wholesale,$id,2);
                    $vehicle = $this->updateSubProductDetails($vehicle,$id,3);

                    if($retail['status'] && $wholesale['status'] && $vehicle['status']){
                        return $retail;
                    } else {
                        $response = array(
                            "status"=>false,
                            "response"=>'Error updating product'
                        );

                        return $response;
                    }
                }else{
                    $response = array(
                        "status"=>false,
                        "response"=>'Error updating product'
                    );

                    return $response;
                }
            }
        }

        return $response; // Return response array
    }

    /**
    * Function to
    *
    */
    public function readProductByReference(){

    }

    /**
    * Function to
    *
    */
    public function readAllProducts(){

    }



    /**
    * Function to
    *
    */
    public function deleteProduct(){

    }

    public function addSubProductDetails($data,$productID,$storageID){
        $ID = $this->unique_ID_generator();

        $fields = array(); // Array to hold user data fields

        $user_ID = $this->get_my_id($_SESSION['LOGGED_USER']);

        if($user_ID['status']){
            $user_ID = $user_ID['response'][0]['UUID'];
        }

        $fields = array(
            "UUID",
            "fk_productID",
            "fk_storageID",
            "currentStock",
            "lowStockThreashold",
            "regularPrice",
            "salePrice",
            "includedTaxPercent",
            "fk_createdBy",
            "fk_modifiedBy",
        );

        $fieldsCombined = implode("`,`", $fields); // Join array elements with a comma
        $fieldsCombined = "`".$fieldsCombined."`";
        $placeholders = "?,?,?,?,?,?,?,?,?,?";
        $type = "iiidddddii";
        $values = array(
            $ID,
            $productID,
            $storageID,
            $data['currentStock'],
            $data['lowStockThreshold'],
            $data['regularPrice'],
            $data['salePrice'],
            $data['includedTax'],
            $user_ID,
            $user_ID,
        );
        

        $insert = $this->insert_to_database("tbl_inventory",$fieldsCombined,$placeholders,$type,$values);

        return $insert;
    }

    public function updateSubProductDetails($data,$productID,$storageID){
        //find sub_product ID
        $sub_product = null;
        $table = "tbl_inventory";
        $fields = array(
            "*",
        );
        $order_by = "UUID";
        $order_set = "ASC";
        $offset = 0;
        $reference = array(
            "statement" => "fk_productID = ? AND fk_storageID = ?",
            "type"=>"ii",
            "values"=>[
                $productID,
                $storageID
            ]
        );

        $response = $this->database_read_by_ref($table,$fields,$order_by,$order_set,$offset,$reference);

        if($response['status']){
            $id = $response['response'][0]['UUID'];

            $user_ID = $this->get_my_id($_SESSION['LOGGED_USER']);

            if($user_ID['status']){
                $user_ID = $user_ID['response'][0]['UUID'];
            }

            $fields = array(
                "currentStock",
                "lowStockThreashold",
                "regularPrice",
                "salePrice",
                "includedTaxPercent",
                "fk_modifiedBy"
            );
            $fieldsCombined = implode("`,`", $fields); // Join array elements with a comma
            $fieldsCombined = "`".$fieldsCombined."`";

            $values = array(
                [$data['currentStock'],"si"],
                [$data['lowStockThreshold'],"si"],
                [$data['regularPrice'],"si"],
                [$data['salePrice'],"si"],
                [$data['includedTax'],"si"],
                [[$user_ID,"ii"],"ii"],
            );

            $data_combined = array_combine($fields,$values);

            $update = $this->database_update('tbl_inventory',$data_combined,$id);

            return $update;
        }else{
            exit();
        }

        
    }
}

// EOF : Catalog.php



// $retail = $sub_retail;
// $wholesale = $sub_wholesale;
// $vehicle = $sub_vehicle;

// $retail = $this->addSubProductDetails($retail,$ID,1);
// $wholesale = $this->addSubProductDetails($wholesale,$ID,2);
// $vehicle = $this->addSubProductDetails($vehicle,$ID,3);

// if($retail['status'] && $wholesale['status'] && $vehicle['status']){
//     return $insert;
// } else {
//     $response = array(
//         "status"=>false,
//         "response"=>'Error adding product'
//     );

//     return $response;
// }