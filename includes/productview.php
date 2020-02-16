<?php
require_once 'product.php';

class ProductView extends Product
{
    public function showProducts()
    {
        $dataSet = array();
        try {
            $dataSet = $this->getAllProducts();
            return $dataSet;
        } catch (Exception $e) {     
            $response = ['errorMsg' => "\nCould not retrieve products. " . $e->getMessage(), 'errType' => 'modalError',];
            return $response; 
        }
    }

    public function showProdTypes()
    {
        $dataSet = array();
        try {
            $dataSet = $this->getAllProdTypes();
            return $dataSet;
        } catch (Exception $e) {
            $response = ['errorMsg' => "\nCould not retrieve product types. " . $e->getMessage(), 'errType' => 'modalError',];
            return $response;
        }
    }
}
  
