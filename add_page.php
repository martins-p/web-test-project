<?php include ('includes/viewproduct.php') ?>

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
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" id="new-product-form">
    <table class="standard-table">
        <tr>
            <td>SKU</td>
            <td><input type="text" name="SKU" required></td>
        </tr>
        <tr>
            <td>Name</td>
            <td><input type="text" name="name" required></td>
        </tr>
        <tr>
            <td>Price</td>
            <td><input type="text" name="price" required></td>
        </tr>
        <tr>
            <td>Type</td>
            <td><select name="type" id="select-product-type" autocomplete="off" required>
                    <option selected disabled hidden style='display: none' value=''></option>
                    <?php
                    $productTypes = new ViewProduct(); 
                    foreach($productTypes->showAllProdTypes() as $row): ?>
                        <option> <?=$row["type"]?></option>
                    <?php endforeach;?>
                </select>
            </td>
        </tr>
</table>

        <div id="special-attribute-field">
                        
        </div>
        
    </form>

    <button type="submit" class="btn btn-success" id="save-button" form="new-product-form">Save</button>
</div>
<?php
if($_POST){
 
    $product = new Product();
    $product->sku = $_POST['SKU'];
    $product->name = $_POST['name'];
    $product->price = $_POST['price'];
    $product->type = $_POST['type'];
    $product->special_attribute_value = $_POST['special_attribute_value'];
    $product->special_attribute = $_POST['special_attribute'];
    $product->addProduct();
}
?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
<script src="main.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRi
</body>
</html>