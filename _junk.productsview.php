<?php
include 'includes/product.php';

class ProductsView extends Product
{
    public function showProducts()
    {
        $dataSet = array();
        $dataSet = $this->getAllProducts();
        return $dataSet;
    }

    public function showProdTypes()
    {
        $dataSet = array();
        $dataSet = $this->getAllProdTypes();
        return $dataSet;
    }
}
