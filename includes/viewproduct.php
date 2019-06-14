<?php
include 'product.php';

//Shows data to user/index page
class ViewProduct extends Product {

    public function showAllProducts() {
        $dataSet = array();
        $dataSet = $this->getAllProducts();
        return $dataSet;
    }

    public function showAllProdTypes() {
        $dataSet = array();
        $dataSet = $this->getAllProdTypes();
        return $dataSet;
    }

    public function postFormData () {
        
    }
}