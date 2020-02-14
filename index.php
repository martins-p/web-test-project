<?php require_once 'includes/productsview.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Junior developer test</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">

</head>

<body>
    <div class="header">
        <div class="row title">
            <div class="col">
                <h2>Product List</h2>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <h3><a href="add_page.php">Add Product</a></h3>
            </div>
            <div class="col">
                <button type="submit" name="deleteBtn" value="delete" form="productCardForm" class="delete-button btn btn-warning">Delete</button>
            </div>
        </div>
    </div>

    <!-- Form w/ product cards -->
    <form id="productCardForm" method="post">
        <div id="product-grid">
            <?php
            $viewProducts = new ProductsView();
            $dataSet = $viewProducts->showProducts();

            //Section that generates product cards
            if (isset($dataSet) && !array_key_exists('errorMsg', $dataSet)) {
                foreach ($viewProducts->showProducts() as $row) : ?>
                    <div class="product-card">
                        <input type="checkbox" class="product-checkbox" autocomplete="off" name="selected_sku[]" value="<?php echo $row['sku']; ?>">
                        <p><?= $row['sku'] ?></p>
                        <h3><?= $row['name'] ?></h3>
                        <p>Price: <?= $row['price'] ?>€</p>

                        <?php
                        if ($row['value'] !== null) : ?>
                            <p class="product-attribute"><?= $row['attribute'] ?>: <?= $row['value'] ?>&nbsp<?= $row['measure_unit'] ?></p>
                        <?php endif; ?>
                    </div>
            <?php endforeach;
            } else if (!isset($dataSet)) {
                echo "No products to display";
            } ?>

            <!-- Error message container -->
            <div class="error-message">
                <?php if (isset($dataSet) && array_key_exists('errorMsg', $dataSet)) {
                    echo $dataSet['errorMsg'];
                }
                ?>
            </div>
        </div>
    </form>

    <!-- Notification modal -->
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