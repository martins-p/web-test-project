<?php
require_once 'validation.php';
require_once 'product.php';

class ProductController extends Product
{
    private $formData;

    public function __construct($data)
    {
        $this->formData = $data;
    }

    public function deleteProduct()
    {
        $selectedSkuArr = $this->formData['selected_sku'];
        try {
            if (count($selectedSkuArr) > 0) {
                foreach ($selectedSkuArr as $sku) {
                    if (!ctype_alnum($sku)) {
                        throw new Exception("Invalid SKU detected: " . $sku);
                    }
                }
                $product = new Product();
                $product->delete($selectedSkuArr);
            }
        } catch (Exception $e) {
            $response = ['errorMsg' => $e->getMessage(), 'errType' => 'modalError',];
            exit(json_encode($response));
        }
    }

    public function addProduct()
    {
        $validation = new InputValidator($this->formData);

        $validationResult = $validation->validateForm();
        if (!array_key_exists('errType', $validationResult)) {
            try {
                $product = Product::withProductData($validationResult);
                $product->add();
            } catch (Exception $e) {
                $response = ['errorMsg' => $e->getMessage(), 'errType' => 'modalError',];
                exit(json_encode($response));
            }
        } else {
            echo json_encode($validationResult);
        }
    }
}

if (isset($_POST)) {
    if ($_POST['btnAction'] == 'delete') {
        $controller = new ProductController($_POST);
        $controller->deleteProduct();
    } else if ($_POST['btnAction'] == 'add') {
        $controller = new ProductController($_POST);
        $controller->addProduct();
    }
}
