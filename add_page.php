<?php require_once('includes/productview.php');
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
        <h2>Add Product</h2>
        <h3><a href="index.php">Product List</a></h3>
    </div>
    <div class="content-wrapper">
        <form id="addProductForm" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <table class="standard-table">
                <tr>
                    <td>SKU</td>
                    <td><input type="text" class="input_sku" name="sku" value="<?php echo htmlspecialchars($_POST['sku'] ?? '') ?>"></td>
                </tr>
                <tr>
                    <td>Name</td>
                    <td><input type="text" class="input_name" name="name" value="<?php echo htmlspecialchars($_POST['name'] ?? '') ?>"></td>
                </tr>
                <tr>
                    <td>Price</td>
                    <td><input type="number" step="0.01" class="input_price" name="price" value="<?php echo htmlspecialchars($_POST['price'] ?? '') ?>">
                </tr>
                <tr>
                    <td>Type</td>
                    <td><select name="type" id="select-product-type" class="input_type" autocomplete="off" value="">
                            <option selected hidden style='display: none' value=''></option>
                            <?php
                            $productTypes = new ProductView();
                            $dataSet = $productTypes->showProdTypes();
                            if (!isset($dataSet['errorMsg'])) {

                                foreach ($dataSet as $row) : ?>
                                    <option> <?= $row['type'] ?></option>
                            <?php endforeach;
                            } ?>
                        </select>
                    </td>
                </tr>
            </table>

            <div id="special-attribute-field">
                <input type="hidden" name="special_attribute" value="">
                <input type="hidden" name="special_attribute_value" value="">
            </div>
            <button type="submit" name='addProduct' class="save-button btn btn-success" id="save-buttn" value="add" form="addProductForm">Save</button>
        </form>

        <!-- Error message container -->
        <div class="error-message">
            <?php if (array_key_exists('errorMsg', $dataSet)) {
                echo $dataSet['errorMsg'];
            } ?>
        </div>

        <!-- Message modal -->
        <div id="notificationModal" class="modal">
            <div class="modal-outer-container">
                <div class="modal-inner-container">
                    <div class="modal-content">
                        <span class="close">&times;</span>
                        <p class="modal-text"></p>
                    </div>
                </div>
            </div>
        </div>

        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
        <script src="main.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRi
</body>
</html>