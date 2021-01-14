<?php
/**
* This class represents the system as a whole
* Any functionality that the system should automate or perform in reaction to users minimal interaction should go here.
* This represents the [app/php/config/functions.php] in an OOP format to enable code reuse
*/

// System class
class system
{
    /**
    * This method takes in a token provided by other methods.
    * The token is verified against a system generated token to verify if the request comes from a valid user.
    * @param string $token
    * @return bool $verified
    */
    function verifyUser($token){
        $verified = false;
        /**
        * Code to verify goes here.
        * @todo generate code to verify.
        */
        return $verified;
    }


    /**
    * This method accepts a string as an input and returns a string as output.
    * when a string is passed with html sensitive characters, it returns an encoded string.
    * @param string $str_val
    * @return string $val
    */
    function encodeToHTML($strVal)
    {
        $val = htmlentities($strVal);
        return $val;
    }

    /**
    * This method decodes a string that is already encoded to html
    * @see [encodeToHTML()]
    * @param string $str_val
    * @return string $val
    */
    function decodeHTML($strVal)
    {
        $val = html_entity_decode($strVal);
        return $val;
    }

    /**/
    public function unique_ID_generator(){

    }

    /**/
    public function tocken_generator(){

    }

    /**/
    public function notifications_checker(){

    }

    /**/
    public function inventory_checker(){

    }

    /**/
    public function database_create(){

    }

    /**/
    public function database_read(){

    }

    /**/
    public function database_read_by_ref(){

    }

    /**/
    public function database_update(){

    }

    /**/
    public function database_delete(){

    }
}


// EOF : System.php
