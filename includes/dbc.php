<?php

class Dbc
{
    private $servername;
    private $username;
    private $password;
    private $dbname;
    private $pdo;

    protected function query($query)
    {
        $this->connect();
        if ($this->pdo) {
            return $this->pdo->query($query);
        } else {
            throw new Exception("Database query failed");
        }
    }

    protected function connect()
    {
        $this->servername = "localhost";
        $this->username = "root";
        $this->password = "";
        $this->dbname = "junior_test";
        
        try {
            $dsn = "mysql:host=" . $this->servername . ";dbname=" . $this->dbname; 
            $this->pdo = new PDO($dsn, $this->username, $this->password);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $this->pdo;
        } catch (PDOException $e) {
            throw $e;
        }
    }
}
