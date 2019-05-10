<?php include ('connection.php');

$query = "SELECT id, products.SKU, name, price, attribute, value FROM products LEFT JOIN attributes ON products.SKU = attributes.SKU";
$productObject = $connection->query($query);


$queryAttributes = "SELECT DISTINCT type FROM products";
$attributeObject = $connection->query($queryAttributes);


