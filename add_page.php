<?php include ('includes/viewproduct.php') ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div><h2>Product Add</h2></div>
    <div><h3><a href="index.php">Product List</a></h3></div>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" id="new-product-form"><table>
        <tr>
            <td>SKU</td>
            <td><input type="text" name="SKU"></td>
        </tr>
        <tr>
            <td>Name</td>
            <td><input type="text" name="name"></td>
        </tr>
        <tr>
            <td>Price</td>
            <td><input type="text" name="price"></td>
        </tr>
        <tr>
            <td>Type</td>
            <td><select name="type" id="select-product-type">
                    <option selected disabled hidden style='display: none' value=''></option>
                    <?php
                    $productTypes = new ViewProduct(); 
                    foreach($productTypes->showAllProdTypes() as $row): ?>
                        <option> <?=$row["type"]?></option>
                    <?php endforeach; ?>
                    
                </select>
            </td>
        </tr>
</table>

        <div id="special-attribute-field">
                        
        </div>
        <button type="submit"  id="save-button">Save</button>
    </form>
<?php
if($_POST){
 
    $product = new Product();
    $product->sku = $_POST['SKU'];
    $product->name = $_POST['name'];
    $product->price = $_POST['price'];
    $product->type = $_POST['type'];
    $product->special_attribute_value = $_POST['special_attribute_value'];
    $product->special_attribute = $_POST['special_attribute'];
    //print_r ($product);
    $product->addProduct();
}
?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
<script src="main.js"></script>
</body>
</html>