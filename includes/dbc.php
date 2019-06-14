<?php

class Dbc {

    private $servername;
    private $username;
    private $password;
    private $dbname;

    public function connect() {
        $this->servername = "localhost";
        $this->username = "root";
        $this->password = "";
        $this->dbname = "junior_test";
        
        try {
            $dsn = "mysql:host=".$this->servername.";dbname=".$this->dbname; //dsn = data source name
            $pdo = new PDO($dsn, $this->username, $this->password);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $pdo;

        } catch (PDOException $e) {
            echo "Connection failed: ".$e->getMessage();
        }
    }
}