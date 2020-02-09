<?php
require_once 'validation.php';
require_once 'product.php';

class ProductsContr extends Product
{
    public function deleteProd()
    {
        if (count($_POST['selected_sku']) > 0) {
            try {
                $product = new Product();
                $product->deleteProduct();
            } catch (Exception $e) {
                $response = ['errorMsg' => $e->getMessage(), 'errType' => 'modalError',];
                exit(json_encode($response));
            }
        }
    }

    public function addProd()
    {
        //Validate input
        $validation = new InputValidator($_POST);

        $validatedInput = $validation->validateForm();
         if (!array_key_exists('errType', $validatedInput)) {
            //Proceed with addition
            try {
                $product = Product::withData($validatedInput);
                $product->addProduct();
            } catch (Exception $e) {
                $response = ['errorMsg' => $e->getMessage(), 'errType' => 'modalError',];
                exit(json_encode($response));
            }
        } else {
            echo json_encode($validatedInput); 
            //return $errors;
        }
    }
}

if (isset($_POST['massDelBtn'])) {
    ProductsContr::deleteProd();

    
} else if (isset($_POST['addProduct'])) {
    ProductsContr::addProd();
}
