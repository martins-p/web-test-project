<?php
//require_once 'validation.php';
include 'product.php';

class ProductsContr extends Product
{
    public function deleteProd()
    {
        if (count($_POST['selected_sku']) > 0) {
            $product = new Product();
            $product->deleteProduct();
        }
        //return array("ok": "1", "errormsg: ", "");
    }

    public function addProd()
    {
        //Validate input
        echo "Here we go";
        $validation = new InputValidator($_POST);
        $errors = $validation->validateForm();
        if (empty($errors)) {
            //Proceed with addition
            if (is_array($_POST['special_attribute_value'])) {
                $_POST['special_attribute_value'] = implode("x", $_POST['special_attribute_value']);
            }
            $product = Product::withData($_POST);
            $product->addProduct();
            // What if method fails to add?
        } else {
            echo json_encode($errors);
            //return $errors;
        }
    }
}
var_dump($_POST);

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
