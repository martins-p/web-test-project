<?php

class ProductBase {

    function parseJson();
    function genDbQuery();

    $SKU
    $Name
}

class Dvd : public ProductBase {

    function parseJson($json) {
        $size = $json['size'];
    }

    function genDbQuery($json) {
        // TODO
    }

    $size
}

class Furniture : public ProductBase {

    function parseJson($json) {
        $dimension = $json['dimension'];
    }

    function genDbQuery($json) {
        // TODO
    }

    $dimension
}


function buildProduct($json) {
    if ($json['type'] ==  '1') {
        return DVD();
    }
    else if ($json['type'] == '2') {
        return Furniture();
    }
    else {
        // TODO
    }
}

$dbconnection =  CRATE_DB_CONNECTINO();

$json = json_decode("{adsfasfddsasdfasdfdsdf}");



// $json = json_decode(file_get_contents('php://input'), true);
// ProductBase $produ = buildProduct($json);
// $produ->parseJson($json);

// $dbconnection->exe($produ->genDbQuery());



