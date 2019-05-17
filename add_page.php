<?php include ('select.php') ?>

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
    <form action="" method="post" id="new-product-form"><table>
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
                    <?php while($row = $attributeObject->fetch_assoc()): ?>
                        <option> <?=$row["type"]?></option>
                    <?php endWhile; ?>
                </select>
            </td>
        </tr>
</table>

        <div id="special-attribute-field">
                        
        </div>
    </form>
    <button type="submit" form="new-product-form" id="save-button">Save</button>
    <p id="hide-test">TEST</p>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
<script src="main.js"></script>
</body>
</html>