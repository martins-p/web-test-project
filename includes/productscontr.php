<?php
//require_once 'validation.php';
include 'product.php';

class ProductsContr extends Product
{
    public function deleteProd()
    {
        if (count($_POST['selected_sku']) > 0) {
            try {
                $product = new Product();
                $product->deleteProduct();
            } catch (Exception $e) {
                $response = ['errorMsg' => $e->getMessage(), 'errType' => 'failedToDelete',];
                exit(json_encode($response));
            }
        }
    }

    public function addProd()
    {
        //Validate input
        $validation = new InputValidator($_POST);
        try {
            $errors = $validation->validateForm();
            if (empty($errors)) {
                //Proceed with addition
                $product = Product::withData($_POST);
                $product->addProduct();
            } else {
                echo json_encode($errors);
                //return $errors;
            }
        } catch (Exception $e) {
            $response = ['errorMsg' => $e->getMessage(), 'errType' => 'failedToAdd',];
            exit(json_encode($response));
        }
    }
}

if (isset($_POST['massDelBtn'])) {
    // $result = array(); 
    try {
        ProductsContr::deleteProd();
    } catch (Exception $e) {
        /* file_put_contents('php://stderr', print_r($e, TRUE));
        $result = array("ok": "0", "errormsg: " "server error"); */
        echo "Deletion failed. Reason: " . $e->getMessage();
    }
    // echo json_encode($result);
} else if (isset($_POST['addProduct'])) {
    try {
        ProductsContr::addProd();
    } catch (Exception $e) {
        echo "Addition failed. Reason: " . $e->getMessage();
    }
}
