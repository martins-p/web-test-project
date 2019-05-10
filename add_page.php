<?php include ('select.php') ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <div><h2>Product Add</h2></div>
    <form action="" method="post">
        SKU <input type="text" name="SKU"><br>
        Name <input type="text" name="name"><br>
        Price <input type="text" name="price"><br>
        Type <select name="type" id="selected-product-type">
                <?php while($row = $attributeObject->fetch_assoc()): ?>
                    <option> <?=$row['type']?></option>
                <?php endWhile; ?>
            </select>
        <div>
            <h3></h3>
        </div>
    </form>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
<script src="main.js"></script>
</body>
</html>