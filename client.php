<?php
/** @var mysqli $mysqli */
$mysqli = include 'connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if ($_POST['action'] === 'client') {
        $name = $_POST['name'];
        $age = $_POST['age'];
        $purchase_price = $_POST['purchase_price'];

        $statement = $mysqli->prepare('INSERT INTO clients (name, age, purchase_price) VALUES (?, ?, ?)');

        $statement->bind_param('sid', $name, $age, $purchase_price);

        if (isValidClient($name, $age, $purchase_price)) {
            if ($statement->execute()) {
                http_response_code(201);
            } else {
                throw new mysqli_sql_exception("Couldn't execute sql statement! HTTP response code: 500");
            }
        } else {
            http_response_code(422);
            throw new mysqli_sql_exception("Couldn't execute sql statement! HTTP response code: 500");
        }
    }
}

function isValidClient($name, $age, $purchase_price)
{
    return preg_match('/^[a-ząęóśłńćżź]{3,20}$/i', $name)
        && preg_match('/^[0-9]{2}$/', $age)
        && $age > 5 && $age < 90
        && preg_match('/^[0-9]+(.[0-9]{2})?$/', $purchase_price)
        && $purchase_price < 10000;
}

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if ($_GET['action'] === 'clients') {
        $result = $mysqli->query('SELECT * FROM clients LIMIT 10');
        if ($result) {
            $array = [];

            while ($row = mysqli_fetch_assoc($result)) {
                $array[] = $row;
            }

            echo json_encode(['clients' => $array]);
        } else {
            throw new mysqli_sql_exception("Couldn't execute sql statement! HTTP response code: 500");
        }
    }
}

$mysqli->close();
