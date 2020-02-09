<?php
require_once 'product.php';

class ProductsView extends Product
{
    public function showProducts()
    {
        $dataSet = array();
        try {
            $dataSet = $this->getAllProducts();
            return $dataSet;
        } catch (Exception $e) {
            
            $response = ['errorMsg' => "\nFailed to retrieve products. Reason: " . $e->getMessage(), 'errType' => 'modalError',];
            return $response; 
            //echo "\nFailed to retrieve products. Reason: " . $e->getMessage();
            //return $dataSet;
        }
    }

    public function showProdTypes()
    {
        $dataSet = array();
        try {
            $dataSet = $this->getAllProdTypes();
            return $dataSet;
        } catch (Exception $e) {
            $response = ['errorMsg' => "\nFailed to retrieve product types. Reason: " . $e->getMessage(), 'errType' => 'modalError',];
            return $response;
            //echo "\nFailed to retrieve product types. Reason: " . $e->getMessage();
            //return $dataSet;
        }
    }
}
  
