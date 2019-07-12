<?php 
include 'dbc.php';
include 'validation.php';
//This class handles connections to database

class Product extends Dbc {

    public $sku;
    public $name;
    public $price;
    public $type;
    public $special_attribute = "";
    public $special_attribute_value = null;


    

    protected function getAllProducts() {

        $stmt = $this->connect()->query("SELECT id, products.sku, name, price, attribute, value FROM products LEFT JOIN attributes ON products.sku = attributes.sku");
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

    function addProduct () {
        $pdo = $this->connect();
        $stmt_product= $pdo->prepare("INSERT INTO products (sku, name, price, type) VALUES (:sku,:name,:price,:type)");
        $stmt_attribute= $pdo->prepare("INSERT INTO attributes (sku, attribute, value) VALUES (:sku, :attribute, :value)");
        
        $this->sku = $this->validate($this->sku);
        $this->name = $this->validate($this->name);
        $this->price = $this->validate($this->price);
        $this->type = $this->validate($this->type);
        $this->special_attribute = $this->validate($this->special_attribute);
        $this->special_attribute_value = $this->validate($this->special_attribute_value);

        try {
            $pdo->beginTransaction();

            $stmt_product->bindParam('sku', $this->sku);
            $stmt_product->bindParam('name', $this->name);
            $stmt_product->bindParam('price', $this->price);
            $stmt_product->bindParam('type', $this->type);

            $stmt_attribute->bindParam('sku', $this->sku);
            $stmt_attribute->bindParam('attribute', $this->special_attribute);
            $stmt_attribute->bindParam('value', $this->special_attribute_value);
            
            $stmt_product->execute();
            $stmt_attribute->execute();

            $pdo->commit();
        }
        catch (Exception $error) {
            $pdo->rollback();
            echo "Error: ".$error->getMessage();
        }

    }

    function validate($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    function deleteProduct() {
        if (count($_POST["selected_sku"]) > 0) {
            $deleteSkus = implode(",", $_POST['selected_sku']);
            $pdo = $this->connect();
            $stmt_product= $pdo->prepare("DELETE FROM products WHERE sku IN ('$deleteSkus')");
            $stmt_attribute= $pdo->prepare("DELETE FROM attributes WHERE sku IN ('$deleteSkus')");
    
            try {
                $pdo->beginTransaction();               
                $stmt_product->execute();
                $stmt_attribute->execute();
    
                $pdo->commit();
            }
            catch (Exception $error) {
                $pdo->rollback();
                echo "Error: ".$error->getMessage();
            }
        }
    }

}



