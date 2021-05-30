<?php

class db{

    private $db_conn;
    private $host = "127.0.0.1";
    private $username = "root";
    private $password = "";
    private $db = "twitterclone";

    private $charset = 'utf8mb4';
    private $collate = 'utf8mb4_unicode_ci';

    //Database connection using PDO
    public function connect() {
        try{
            $this->db_conn = new PDO("mysql:host=$this->host;dbname=$this->db;charset=$this->charset", $this->username, $this->password);
            $this->db_conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->db_conn->setAttribute(PDO::ATTR_PERSISTENT, FALSE);
            $this->db_conn->setAttribute(PDO::ATTR_EMULATE_PREPARES, TRUE);
            $this->db_conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
            return $this->db_conn;
        }
        catch(PDOException $e){
            return "Database connection failed!";
        }

    }

}


?>