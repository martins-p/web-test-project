<?php

class Dbc
{
    private $servername;
    private $username;
    private $password;
    private $dbname;
    private $pdo;

    //Method to avoid manually connecting on every query 
    protected function query($query)
    {
        $this->connect();
        if ($this->pdo) {
            return $this->pdo->query($query);
        } else {
            throw new Exception("Query failed.");
        }
    }

    //DB connection method
    protected function connect()
    {
        $this->servername = "localhost";
        $this->username = "root";
        $this->password = "";
        $this->dbname = "junior_test";
        
        //Try to establish new DB connection via PDO
        try {
            $dsn = "mysql:host=" . $this->servername . ";dbname=" . $this->dbname; //dsn = data source name
            $this->pdo = new PDO($dsn, $this->username, $this->password);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $this->pdo;
        } catch (PDOException $e) {
            exit("Database connection problem: " .  $e->getMessage());
        }
    }
}
