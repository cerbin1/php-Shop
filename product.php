<?php
$mysqli = include 'connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if ($_POST['action'] == 'product') {
        $name = $_POST['name'];
        $type = $_POST['type'];
        $price = $_POST['price'];

        $name = $mysqli->real_escape_string($name);
        $age = $mysqli->real_escape_string($type);
        $price = $mysqli->real_escape_string($price);


        $sql = "INSERT INTO products (name, type, price)
            VALUES ('$name', '$type', $price)";

        if (isValidProduct($name, $type, $price)) {
            if ($mysqli->query($sql)) {
                http_response_code(201);
            } else {
                http_response_code(500);
            }
        } else {
            http_response_code(422);
        }
    }
}


function isValidProduct($name, $type, $price)
{
    return preg_match('/^[a-ząęóśłńćżź]{3,20}$/i', $name)
        && preg_match('/^[a-ząęóśłńćżź]{3,25}$/i', $type)
        && preg_match('/^[0-9]+(.[0-9]{2})?$/', $price)
        && $price < 10000;
}

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if ($_GET['action'] == 'products') {
        $result = $mysqli->query('SELECT * FROM products LIMIT 10');
        if ($result) {
            $array = array();

            while ($row = mysqli_fetch_assoc($result)) {
                $array[] = $row;
            }

            echo json_encode(['products' => $array]);
        } else {
            http_response_code(500);
        }
    }
}

$mysqli->close();
