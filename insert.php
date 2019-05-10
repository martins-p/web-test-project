<?php include ('connection.php');

$query = "INSERT INTO id, SKU, name, price, attribute, value FROM products LEFT JOIN attributes ON products.id = attributes.product_id";
$productObject = $connection->query($query);
