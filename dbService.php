<?php

include 'config.php';

class DatabaseService
{
    private $db_host = $_PRIV8MESSAGING['DB_HOST'];
    private $db_name = $_PRIV8MESSAGING['DB_NAME'];
    private $db_user = $_PRIV8MESSAGING['DB_USER'];
    private $db_password = $_PRIV8MESSAGING['DB_PASSWORD'];
    public $conn;

    public function getConnection()
    {

        $this->conn = null;

        try {
            $this->conn = new PDO("mysql:host=" . $this->db_host . ";dbname=" . $this->db_name, $this->db_user, $this->db_password);
        } catch (PDOException $exception) {
            echo "Connection failed: " . $exception->getMessage();
        }

        return $this->conn;
    }
}
