<?php
class databaseTest{
    protected $databaseConnection;

    public function __construct(){
        $this->databaseConnection = new mysqli(
            "localhost",
            "root",
            "",
            "hilltop"
        );

        if ($this->databaseConnection->connect_error) {
            // Connection error

            trigger_error(
                "Connection Error: " . $this->databaseConnection->connect_error,
                E_USER_ERROR
            );
        }
    }

    public function getDatabaseConnection(){
        return $this->databaseConnection;
    }
    
}
