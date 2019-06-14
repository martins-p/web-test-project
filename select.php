<?php include ('includes/dbc.php');

//This class handles connections to database

class Product extends Dbc {

    protected function getAllProducts() {
        $query = "SELECT id, products.SKU, name, price, attribute, value FROM products LEFT JOIN attributes ON products.SKU = attributes.SKU";
        $result = $this->connect()->query($query);
        $numRows = $result->num_rows;
        if ($numRows > 0) {
            while ($row = $result->fetch_assoc()) {
                $data[] = $row;
            }
            return $data;
        }
    }
}

// $query = "SELECT id, products.SKU, name, price, attribute, value FROM products LEFT JOIN attributes ON products.SKU = attributes.SKU";
// $productObject = $connection->query($query);


// $queryAttributes = "SELECT DISTINCT type FROM products";
// $attributeObject = $connection->query($queryAttributes);


