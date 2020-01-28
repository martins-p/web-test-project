<?php
include 'product.php';

class ProductsView extends Product
{
    public function showProducts()
    {
        $dataSet = array();
        try {
            $dataSet = $this->getAllProducts();
            return $dataSet;
        } catch (Exception $e) {
            echo "\nFailed to retrieve products. Reason: " . $e->getMessage();
            //throw new Exception ("Uncaught exception");
            return $dataSet;
        }
    }

    public function showProdTypes()
    {
        $dataSet = array();
        try {
            $dataSet = $this->getAllProdTypes();
            echo "potato";
            return $dataSet;
        } catch (Exception $e) {
            echo "\nFailed to retrieve product types. Reason: " . $e->getMessage();
            return $dataSet;
        }
    }

}
