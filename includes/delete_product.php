<?php

include 'product.php';



/*function validateFloat ($input) {
    if (!filter_var($input, FILTER_VALIDATE_FLOAT)) {
        $floatErr = "Input must be a number";
    }
}*/

if(isset($_POST['massDelBtn'])){
    //validatefloat($_POST['$sku']);
    $product = new Product();
    $product->deleteProduct();
}