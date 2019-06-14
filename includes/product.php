<?php 
include 'dbc.php';
//This class handles connections to database

class Product extends Dbc {

    public $sku;
    public $name;
    public $price;
    public $type;
    public $special_attribute;
    public $special_attribute_value;


    

    protected function getAllProducts() {
        // $query = "SELECT id, products.SKU, name, price, attribute, value FROM products LEFT JOIN attributes ON products.SKU = attributes.SKU";
        // $result = $this->connect()->query($query);
        // $numRows = $result->num_rows;
        // if ($numRows > 0) {
        //     while ($row = $result->fetch_assoc()) {
        //         $data[] = $row;
        //     }
        //     return $data;
        // }

        $stmt = $this->connect()->query("SELECT id, products.SKU, name, price, attribute, value FROM products LEFT JOIN attributes ON products.SKU = attributes.SKU");
        $output = array();
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $output[] = $row;
        }
        if (count($output) > 0) {
            return $output;
        }
    }

    protected function getAllProdTypes (){

        $stmt = $this->connect()->query("SELECT DISTINCT type FROM products");
        $output = array();
        while ($row = $stmt->fetch()) {
            $output[] = $row;
        }
        return($output);
    }

    protected function addProduct ($sku, $name, $price, $type, $attributeName, $attributeValue) {



    }
}

// $query = "SELECT id, products.SKU, name, price, attribute, value FROM products LEFT JOIN attributes ON products.SKU = attributes.SKU";
// $productObject = $connection->query($query);


// $queryAttributes = "SELECT DISTINCT type FROM products";
// $attributeObject = $connection->query($queryAttributes);


