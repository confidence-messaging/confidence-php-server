<?php

include 'config.php';

class DatabaseService
{
    public $conn;

    public function getConnection()
    {

        $this->conn = null;

        try {
            $this->conn = new PDO("mysql:host=" . $_PRIV8MESSAGING['DB_HOST'] . ";dbname=" .  $_PRIV8MESSAGING['DB_NAME'],$_PRIV8MESSAGING['DB_USER'],  $_PRIV8MESSAGING['DB_PASSWORD']);
        } catch (PDOException $exception) {
            echo "Connection failed: " . $exception->getMessage();
        }

        return $this->conn;
    }
}
