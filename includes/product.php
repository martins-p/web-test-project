<?php
include 'dbc.php';
include 'validation.php';
//This class handles connections to database

class Product extends Dbc
{

    private $sku;
    private $name;
    private $price;
    private $type;
    private $special_attribute = "";
    private $special_attribute_value = null;
    //private $data; //Data submitted with POST


    public function __construct() //Why use constructor?
    {
        
    }

    public static function withData($data)
    {
        $instance = new self();
        $instance->fillData($data);
        return $instance;
    }

    protected function fillData($data)
    {
        $this->sku = $data['sku'];
        $this->name = $data['name'];
        $this->price = $data['price'];
        $this->type = $data['type'];
        $this->special_attribute = $data['special_attribute'];
        $this->special_attribute_value = $data['special_attribute_value'];
    }

    protected function getAllProducts()
    {
        $stmt = $this->query("SELECT products.id, products.sku, name, price, attribute, value FROM products LEFT JOIN attributes ON products.sku = attributes.sku");

        // $stmt = $this->connect()->query("SELECT products.id, products.sku, name, price, attribute, value FROM products LEFT JOIN attributes ON products.sku = attributes.sku");
        $output = array();
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $output[] = $row;
        }
        if (count($output) > 0) {
            return $output;
        }
    }

    protected function getAllProdTypes()
    {
        $stmt = $this->query("SELECT type FROM product_types");
        $output = array();
        while ($row = $stmt->fetch()) {
            $output[] = $row;
        }
        if (count($output) > 0) {
            return $output;
        }
    }

    function addProduct()
    {

        $pdo = $this->connect();
        if(!$pdo) {
            exit();
        }
        $stmt_product = $pdo->prepare("INSERT INTO products (sku, name, price, type) VALUES (:sku,:name,:price,:type)");
        $stmt_attribute = $pdo->prepare("INSERT INTO attributes (sku, attribute, value) VALUES (:sku, :attribute, :value)");

        $this->sku = $this->sanitizeInput($this->sku);
        $this->name = $this->sanitizeInput($this->name);
        $this->price = $this->sanitizeInput($this->price);
        $this->type = $this->sanitizeInput($this->type);
        $this->special_attribute = $this->sanitizeInput($this->special_attribute);
        $this->special_attribute_value = $this->sanitizeInput($this->special_attribute_value);

        try {
            $pdo->beginTransaction();

            $stmt_product->execute(array('sku' => $this->sku, 'name' => $this->name, 'price' => $this->price, 'type' => $this->type));
            $stmt_attribute->execute(array('sku' => $this->sku, 'attribute' => $this->special_attribute, 'value' => $this->special_attribute_value));

            $pdo->commit();

        } catch (Exception $e) {
            $pdo->rollback();
            $response = ['errorMsg' => 'SKU already exists in database.', 'errType' => 'duplicateFound',];
            echo json_encode($response);
        }
    }

    function sanitizeInput($data) //Is this necessary?
    {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    function deleteProduct()
    {
        $deleteSkus = implode("','", $_POST['selected_sku']);
        $pdo = $this->connect(); //This will still execute after DBC exception!!!!
        $stmt_product = $pdo->prepare("DELETE FROM products WHERE sku IN ('$deleteSkus')"); //Unsafe, check alternativ ewithout direct placement of variable

        $stmt_attribute = $pdo->prepare("DELETE FROM attributes WHERE sku IN ('$deleteSkus')");

        try {
            $pdo->beginTransaction();
            $stmt_attribute->execute();
            $stmt_product->execute();
            $pdo->commit();
        } catch (Exception $error) {
            $pdo->rollback();
            echo "\nError: " . $error->getMessage();
        }
    }

}
