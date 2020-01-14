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
    //public $data; //Data submitted with POST
    
//
    /*public function __construct() {
       // $this->data = $post_data;
    }

    public static function withData (array $data) {
        $instance = new self();
        $instance->fillData($data);
        return $instance;
    }

    protected function fillData(array $data) {
        $this->sku =$data['sku']; 
        $this->name = $data['name'];
        $this->price = $data['price'];
        $this->type = $data['type'];
        $this->special_attribute = $data['special_attribute'];
        $this->special_attribute_value = $data['special_attribute_value'];
    }*/

    protected function getAllProducts() {

        $stmt = $this->connect()->query("SELECT products.id, products.sku, name, price, attribute, value FROM products LEFT JOIN attributes ON products.sku = attributes.sku");
        $output = array();
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $output[] = $row;
        }
        if (count($output) > 0) {
            return $output;
        }
    }

    protected function getAllProdTypes (){

        $stmt = $this->connect()->query("SELECT type FROM product_types");
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
        
        $this->sku = $this->sanitizeInput($this->sku); 
        $this->name = $this->sanitizeInput($this->name);
        $this->price = $this->sanitizeInput($this->price);
        $this->type = $this->sanitizeInput($this->type);
        $this->special_attribute = $this->sanitizeInput($this->special_attribute);
        $this->special_attribute_value = $this->sanitizeInput($this->special_attribute_value);
        var_dump($this->sku);
        
        
        try {
            $pdo->beginTransaction();

            $stmt_product->bindParam('sku', $this->sku);
            $stmt_product->bindParam('name', $this->name); //Check -> PDO::PARAM_STR
            $stmt_product->bindParam('price', $this->price);
            $stmt_product->bindParam('type', $this->type);

            $stmt_attribute->bindParam('sku', $this->sku);
            $stmt_attribute->bindParam('attribute', $this->special_attribute);
            $stmt_attribute->bindParam('value', $this->special_attribute_value);
            
            $stmt_product->execute();
            $stmt_attribute->execute();

           /* $stmt_product->execute(array('sku' => $this->sku, 'name' => $this->name, 'price' => $this->price, 'type' => $this->type));
            $stmt_attribute->execute(array('sku' => $this->sku, 'attribute' => $this->special_attribute, 'value' => $this->special_attribute_value));*/

            $pdo->commit();
        }
        catch (Exception $error) {
            $pdo->rollback();
            echo "Error: ".$error->getMessage();
        }

    }

    function sanitizeInput($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    function deleteProduct() {
        if (count($_POST['selected_sku']) > 0) {
                        
            $deleteSkus = implode("','", $_POST['selected_sku']);
            print_r($deleteSkus);
            $pdo = $this->connect();
            $stmt_product= $pdo->prepare("DELETE FROM products WHERE sku IN ('$deleteSkus')");
            
            $stmt_attribute= $pdo->prepare("DELETE FROM attributes WHERE sku IN ('$deleteSkus')");
    
            try {
                $pdo->beginTransaction();               
                $stmt_attribute->execute();
                $stmt_product->execute();
                $pdo->commit();
            }
            catch (Exception $error) {
                $pdo->rollback();
                echo "Error: ".$error->getMessage();
            }
        }
    }

}
