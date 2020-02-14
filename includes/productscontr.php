<?php
require_once 'validation.php';
require_once 'product.php';

class ProductsContr extends Product
{
    private $formData;

    public function __construct($data)
    {
        $this->formData = $data;
    }

    public function deleteProd()
    {
        try {
            if (count($this->formData['selected_sku']) > 0) {
                foreach ($this->formData['selected_sku'] as $sku) {
                    if(!ctype_alnum($sku)) {
                        throw new Exception ("Invalid SKU detected: " . $sku);
                    }
                }
                $product = new Product();
                $product->deleteProduct();
            }
        } catch (Exception $e) {
            $response = ['errorMsg' => $e->getMessage(), 'errType' => 'modalError',];
            exit(json_encode($response));
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
        }
    }
}

if (isset($_POST)) {
    if ($_POST['btnAction'] == 'delete') {
        $controller = new ProductsContr($_POST);
        $controller->deleteProd();
    } else if ($_POST['btnAction'] == 'add') {
        $controller = new ProductsContr($_POST);
        $controller->addProd();
    }
}
