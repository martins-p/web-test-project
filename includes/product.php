<?php
require_once 'dbc.php';
require_once 'validation.php';

class Product extends Dbc
{
    private $sku;
    private $name;
    private $price;
    private $type;
    private $special_attribute = "";
    private $special_attribute_value = null;

    public static function withData($data)
    {
        $instance = new self();
        $instance->fillData($data);
        return $instance;
    }

    private function fillData($data)
    {
        $this->sku = $this->sanitizeInput($data['sku']);
        $this->name = $this->sanitizeInput($data['name']);
        $this->price = $this->sanitizeInput($data['price']);
        $this->type = $this->sanitizeInput($data['type']);
        $this->special_attribute = $this->sanitizeInput($data['special_attribute']);
        if (is_array($data['special_attribute_value'])) {
            $data['special_attribute_value'] = $this->dimensionsToString($data['special_attribute_value']);
        }
        $this->special_attribute_value = $this->sanitizeInput($data['special_attribute_value']);
    }

    protected function getAllProducts()
    {
        $stmt = $this->query('SELECT products.id, products.sku, name, price, attribute, value FROM products LEFT JOIN attributes ON products.sku = attributes.sku');

        $output = array();
        try {
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $output[] = self::addMeasurementUnits($row);
            }
        } catch (Exception $e) {
            throw $e;
            
        }
        if (count($output) > 0) {
            return $output;
        }
    }

    protected function getAllProdTypes()
    {
        try {
        $stmt = $this->query('SELECT type FROM product_types');
        $output = array();
        
            while ($row = $stmt->fetch()) {
                $output[] = $row;
            }
        } catch (Exception $e) {
            throw $e;
        }
        if (count($output) > 0) {
            return $output;
        }
    }

    protected function addProduct()
    {
        $pdo = $this->connect();
        //$stmt_checkExisting = $pdo->prepare('SELECT * FROM products WHERE sku=:sku');
        $stmt_product = $pdo->prepare('INSERT INTO products (sku, name, price, type) VALUES (:sku,:name,:price,:type)');
        $stmt_attribute = $pdo->prepare('INSERT INTO attributes (sku, attribute, value) VALUES (:sku, :attribute, :value)');

        try {
            $pdo->beginTransaction();

            $stmt_product->execute(array(
                'sku' => $this->sku,
                'name' => $this->name,
                'price' => $this->price,
                'type' => $this->type
            ));
            $stmt_attribute->execute(array(
                'sku' => $this->sku,
                'attribute' => $this->special_attribute,
                'value' => $this->special_attribute_value
            ));

            $pdo->commit();
        } catch (Exception $e) {
            $pdo->rollback();
            if ($e->getCode() == 23000) {
                throw new Exception('SKU already exists in database');
            } else {
                throw $e;
            }
            exit();
        }
    }

    protected function deleteProduct()
    {
        $deleteSkus = implode("','", $_POST['selected_sku']);
        $deleteSkus = $_POST['selected_sku'];
        $queryPlaceholders = str_repeat('?,', count($deleteSkus) - 1) . '?';
        $pdo = $this->connect();
        $stmt_product = $pdo->prepare("DELETE FROM products WHERE sku IN ($queryPlaceholders)");
        $stmt_attribute = $pdo->prepare("DELETE FROM attributes WHERE sku IN ($queryPlaceholders)");

        try {
            $pdo->beginTransaction();
            $stmt_attribute->execute($deleteSkus);
            $stmt_product->execute($deleteSkus);
            $count = $stmt_product->rowCount();
            if ($count == 0) {
                throw new Exception('Product could not be deleted.');
            }
            $pdo->commit();
        } catch (Exception $e) {
            $pdo->rollback();
            throw $e;
            exit();
        }
    }

    private function addMeasurementUnits($arr)
    {
        $attribute = $arr['attribute'];

        switch ($attribute) {
            case 'Size':
                $arr['measure_unit'] = 'GB';
                break;
            case 'Weight':
                $arr['measure_unit'] = 'Kg';
                break;
            case 'Dimensions':
                $arr['measure_unit'] = 'cm';
                break;
            default:
                break;
        }
        return $arr;
    }

    private function sanitizeInput($data)
    {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    private function dimensionsToString($array)
    {
        $trimmed = array_map('trim', $array);
        $string = implode('x', $trimmed);
        return $string;
    }
}
