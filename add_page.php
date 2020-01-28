<?php include('includes/productsview.php');
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
        <form id="addProdForm" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <table class="standard-table">
                <tr>
                    <td>SKU</td>
                    <td><input type="text" class="input-sku" name="sku" value="<?php echo htmlspecialchars($_POST['sku'] ?? '') ?>"></td>
                </tr>
                <tr>
                    <td>Name</td>
                    <td><input type="text" class="input-name" name="name" value="<?php echo htmlspecialchars($_POST['name'] ?? '') ?>"></td>
                </tr>
                <tr>
                    <td>Price</td>
                    <td><input type="text" class="input-price" name="price" value="<?php echo htmlspecialchars($_POST['price'] ?? '') ?>">
                </tr>
                <tr>
                    <td>Type</td>
                    <td><select name="type" id="select-product-type" class="input-type" autocomplete="off" value="">
                            <option selected hidden style='display: none' value=''></option>
                            <?php
                            $productTypes = new ProductsView();
                            foreach ($productTypes->showProdTypes() as $row) : ?>
                                <option> <?= $row['type'] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </td>
                </tr>
            </table>
            <div class="error"><?php ?></div>
            <div id="special-attribute-field">
                <input type="hidden" name="special_attribute" value="">
                <input type="hidden" name="special_attribute_value" value="">
            </div>
            <button type="submit" name='addProduct' class="btn btn-success" id="save-button" value="add" form="addProdForm">Save</button>
        </form>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
    <script src="main.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRi
</body>
</html>