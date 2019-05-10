<?php
$dbPassword = "";
$dbUserName = "root";
$dbServer = "localhost";
$dbName = "junior_test";

// Create connection
$connection = new mysqli($dbServer, $dbUserName, $dbPassword, $dbName);

// Check connection
if ($connection->connect_error) {
    die("Connection failed. Reason: " . $connection->connect_error);
}
?> 