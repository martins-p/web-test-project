<?php
require_once 'dbc.php';
require_once 'validation.php';

class Product extends Dbc
{
    private $sku;
    private $name;
    private $price;
    private $type;
    private $special_attribute;
    private $special_attribute_value;

    public static function withProductData($data)
    {
        $instance = new self();
        $instance->fillData($data);
        return $instance;
    }

    private function fillData($data)
    {
        $this->sku = $data['sku'];
        $this->name = $data['name'];
        $this->price = $data['price'];
        $this->type = $data['type'];
        $this->specialAttribute = $data['special_attribute'];
        $this->specialAttributeValue = $data['special_attribute_value'];
    }

    protected function getAllProducts()
    {
        $stmt = $this->query('SELECT products.id, products.sku, name, price, attribute, value FROM products LEFT JOIN attributes ON products.sku = attributes.sku');
        $output = array();
        try {
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $output[] = $this->addUnits($row);
            }
        } catch (Exception $e) {
            throw $e;
        }
        if (count($output) > 0) {
            return $output;
        } else {
            throw new Exception('No products to display');
        }
    }

    protected function getAllProdTypes()
    {
        $stmt = $this->query('SELECT type FROM product_types');
        $output = array();
        try {
            while ($row = $stmt->fetch()) {
                $output[] = $row;
            }
        } catch (Exception $e) {
            throw $e;
        }
        if (count($output) > 0) {
            return $output;
        } else {
            throw new Exception('No product types to display');
        }
    }

    protected function add()
    {
        $pdo = $this->connect();
        $stmtProduct = $pdo->prepare('INSERT INTO products (sku, name, price, type) VALUES (:sku,:name,:price,:type)');
        $stmtAttribute = $pdo->prepare('INSERT INTO attributes (sku, attribute, value) VALUES (:sku, :attribute, :value)');

        try {
            $pdo->beginTransaction();

            $stmtProduct->execute(array(
                'sku' => $this->sku,
                'name' => $this->name,
                'price' => $this->price,
                'type' => $this->type
            ));
            $stmtAttribute->execute(array(
                'sku' => $this->sku,
                'attribute' => $this->specialAttribute,
                'value' => $this->specialAttributeValue
            ));

            $pdo->commit();
        } catch (Exception $e) {
            $pdo->rollback();
            if ($e->getCode() == 23000) {
                throw new Exception('SKU already exists in database');
            } else {
                throw $e;
            }
        }
    }

    protected function delete($skus)
    {
        $queryPlaceholders = str_repeat('?,', count($skus) - 1) . '?';
        $pdo = $this->connect();
        $stmtProduct = $pdo->prepare("DELETE FROM products WHERE sku IN ($queryPlaceholders)");
        $stmtAttribute = $pdo->prepare("DELETE FROM attributes WHERE sku IN ($queryPlaceholders)");

        try {
            $pdo->beginTransaction();
            $stmtAttribute->execute($skus);
            $stmtProduct->execute($skus);
            $count = $stmtProduct->rowCount();
            if ($count == 0) {
                throw new Exception('Product could not be deleted.');
            }
            $pdo->commit();
        } catch (Exception $e) {
            $pdo->rollback();
            throw $e;
        }
    }

    private function addUnits($productData)
    {
        switch ($productData['attribute']) {
            case 'Size':
                $productData['measure_unit'] = 'GB';
                break;
            case 'Weight':
                $productData['measure_unit'] = 'Kg';
                break;
            case 'Dimensions':
                $productData['measure_unit'] = 'cm';
                break;
            default:
                break;
        }
        return $productData;
    }
}
