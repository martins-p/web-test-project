<?php

class Dbc {

    private $servername;
    private $username;
    private $password;
    private $dbname;
    private $pdo;

    protected function query($query) { //Metode lai nav manuali jakonektejas katru reizi
        $this->connect();
        if ($this->pdo) {
            return $this->pdo->query($query);
        } else {
            throw new Exception("Query failed.");
        }
    }

    protected function connect() { 

        $this->servername = "localhost";
        $this->username = "root";
        $this->password = "";
        $this->dbname = "junior_test";
        
        if (isset($this->pdo)) return;

        try {
            $dsn = "mysql:host=".$this->servername.";dbname=".$this->dbname; //dsn = data source name
            $this->pdo = new PDO($dsn, $this->username, $this->password);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $this->pdo;

        } catch (PDOException $e) {
            echo "\nDatabase connection problem."; //.$e->getMessage(); //What happens in inherited classes?
        }
    }
}