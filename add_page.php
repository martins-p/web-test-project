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
    <form action="" method="post" id="new-product-form">
        SKU <input type="text" name="SKU"><br>
        Name <input type="text" name="name"><br>
        Price <input type="text" name="price"><br>
        Type <select name="type" id="select-product-type">
                <?php while($row = $attributeObject->fetch_assoc()): ?>
                    <option> <?=$row['type']?></option>
                <?php endWhile; ?>
            </select>

        <div>
            <div id="size-container">
                Size <input type="text" name="value"><br>
                <p>Info about size.</p>
            </div>
            <div id="size-container">
                Height <input type="number" id="furniture-height"> cm<br>
                Width <input type="number" id="furniture-width"> cm<br>
                Length <input type="number" id="furniture-length"> cm<br>
                <input type="hidden" name="value">
                <p>Info about Weight.</p>
            </div>
            <div id="weight-container">
                Size <input type="text" name="value"><br>
                <p>Info about size.</p>
            </div>
            
        </div>
    </form>
    <button type="submit" form="new-product-form" value="Submit">Save</button>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
<script src="main.js"></script>
</body>
</html>