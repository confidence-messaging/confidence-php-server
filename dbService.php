<?php

include 'config.php';

class DatabaseService
{
    public $conn;

    public function getConnection()
    {

        global $_CONFIDENCE;
        $this->conn = null;

        try {
            $this->conn = new PDO("mysql:host=" . $_CONFIDENCE['DB_HOST'] . ";dbname=" .  $_CONFIDENCE['DB_NAME'],$_CONFIDENCE['DB_USER'],  $_CONFIDENCE['DB_PASSWORD']);
        } catch (PDOException $exception) {
            echo "Connection failed: " . $exception->getMessage();
        }

        return $this->conn;
    }
}
