<?php
/** @var mysqli $mysqli */
$mysqli = include 'connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if ($_POST['action'] === 'product') {
        $name = $_POST['name'];
        $type = $_POST['type'];
        $price = $_POST['price'];

        $statement = $mysqli->prepare('INSERT INTO products (name, type, price) VALUES (?,?,?)');
        $statement->bind_param('ssd', $name, $type, $price);

        if (isValidProduct($name, $type, $price)) {
            if ($statement->execute()) {
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
        && preg_match('/^[0-9]+(.[0-9]{2})?$/', $price) // TODO tu jest błąd, kropka to dowolny znak, więc np "12.99" zadziała ale "12_99" i "12a99" też
        && $price < 10000;
}

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if ($_GET['action'] === 'products') {
        $result = $mysqli->query('SELECT * FROM products LIMIT 10');

        if ($result) {
            $array = [];
            while ($row = mysqli_fetch_assoc($result)) {
                $array[] = $row;
            }

            echo json_encode(['products' => $array]);
        } else {
            throw new mysqli_sql_exception("Couldn't execute sql statement! HTTP response code: 500");
        }
    }
}

$mysqli->close();
