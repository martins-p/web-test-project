<?php include ('includes/view_product.php');
require_once ('includes/validation.php');
     
/*if(isset($_POST['submit'])) {
    $validation = new InputValidator($_POST);
    $errors = $validation->validateForm();
    
    if(empty($errors)){
        //echo 'No errors';
        $product = Product::withData($_POST);
        $product->addProduct();

        $product = new Product();
        $product->sku = $_POST['sku'];
        $product->name = $_POST['name'];
        $product->price = $_POST['price'];
        $product->type = $_POST['type'];
        $product->special_attribute_value = $_POST['special_attribute_value'];
        $product->special_attribute = $_POST['special_attribute'];
        var_dump($product->sku);
        $product->addProduct();

    } else {
        echo 'Got errors';
    }
}*/

 ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="header">
        <h2>Product Add</h2>
        <h3><a href="index.php">Product List</a></h3>
    </div>
    <div class="content-wrapper">
    <form id="addProdForm" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
    <table class="standard-table">
        <tr>
            <td>SKU</td>
            <td><input type="text" name="sku" value="<?php echo htmlspecialchars($_POST['sku'] ?? '')?>" ></td>
        </tr>
        <tr>
            <td>Name</td>
            <td><input type="text" name="name" value="<?php echo htmlspecialchars($_POST['name'] ?? '')?>" ></td>
        </tr>
        <tr>
            <td>Price</td>
            <td><input type="text" name="price" value="<?php echo htmlspecialchars($_POST['price'] ?? '')?>" >
            
            
        </tr>
        <tr>
            <td>Type</td>
            <td><select name="type" id="select-product-type" autocomplete="off" value="">
                    <option selected hidden style='display: none' value=''></option>
                    <?php
                    $productTypes = new ViewProduct(); 
                    foreach($productTypes->showAllProdTypes() as $row): ?>
                        <option> <?=$row['type']?></option>
                    <?php endforeach;?>
                </select>
            </td>
        </tr>
</table>
        <div id="special-attribute-field">
            <input type="hidden" name="special_attribute" value="">
            <input type="hidden" name="special_attribute_value" value="">
        </div>
        <button type="submit" name='addProduct' class="btn btn-success" id="save-button" value="add" form="addProdForm">Save</button>
    </form>
    <div class="error"><?php if (isset($errors)) {
        print_r($errors);} else {echo 'No error';} ?></div>

    
</div>
<?php

/*if(isset($_POST['submit'])) {
    $validation = new InputValidator($_POST);
    $errors = $validation->validateForm();
    if(empty($errors)){
        $product = new Product();
    $product->sku = $_POST['SKU'];
    $product->name = $_POST['name'];
    $product->price = $_POST['price'];
    $product->type = $_POST['type'];
    $product->special_attribute_value = $_POST['special_attribute_value'];
    $product->special_attribute = $_POST['special_attribute'];
    $product->addProduct();
        
    }
}*/
/*if($_POST){
 
    $product = new Product();
    $product->sku = $_POST['SKU'];
    $product->name = $_POST['name'];
    $product->price = $_POST['price'];
    $product->type = $_POST['type'];
    $product->special_attribute_value = $_POST['special_attribute_value'];
    $product->special_attribute = $_POST['special_attribute'];
    $product->addProduct();
}*/
?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
<script src="main.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRi
</body>
</html>