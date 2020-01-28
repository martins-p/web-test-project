<?php
//require_once 'includes/validation.php';
include 'includes/product.php';

class ProductsContr extends Product
{
    public function deleteProd() //Deletion method
    { 
        if (count($_POST['selected_sku']) > 0) {
            $product = new Product();
            $product->deleteProduct();
        }
    }

    public function addProd() //Addition method
    { 
        //Validate input
        $validation = new InputValidator($_POST);
        //Store errors in array
        $errors = $validation->validateForm();
        if (empty($errors)) {
            //Proceed with addition
            $product = Product::withData($_POST);
            $product->addProduct();
            // What if method fails to add?
        } else {
            
            echo json_encode($errors);
        }
    }
}

if (isset($_POST['massDelBtn'])) {
    $deleteProd = ProductsContr::deleteProd();
}

if (isset($_POST['addProduct'])) {
    $addProd = ProductsContr::addProd();
}
