
<?php include 'includes/viewproduct.php' ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Junior developer test</title>
    <link rel="stylesheet" href="style.css">
    
</head>
<body>
    <div>
        <h2>Product List</h2>
    </div>
    
    <h3><a href="add_page.php">Add Product</a></h3>
    <div id="product-grid">
        <?php 
        $viewProducts = new ViewProduct();
        foreach($viewProducts->showAllProducts() as $row): ?>

            <div class="product-card">
                <h3><?=$row['name']?></h3>
                <p><?=$row['SKU']?></p>
                <p><?=$row['price']?></p>
                <?php 
                 if ($row['value'] !== null): ?>
                    <p class="product-attribute"><?=$row['attribute']?>: <?=$row['value']?></p>
                <?php endif; ?>
            </div>
        <?php endforeach; ?>
    </div>
    
    
</body>
</html>