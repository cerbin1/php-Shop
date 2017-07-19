<?php
$mysqli = new mysqli('localhost', 'root', '', 'shop');

if ($mysqli->connect_error) {
    echo 'Error connecting to database';
    die('Connection failed: ' . $mysqli->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if ($_POST['action'] == 'client') {
        $name = $_POST['name'];
        $age = $_POST['age'];
        $purchase_price = $_POST['purchase_price'];

        $name = $mysqli->real_escape_string($name);
        $age = $mysqli->real_escape_string($age);
        $purchase_price = $mysqli->real_escape_string($purchase_price);


        $sql = "INSERT INTO clients (name, age, purchase_price)
            VALUES ($name, $age, $purchase_price)";

        if (isValidClient($name, $age, $purchase_price)) {
            if (mysqli_query($mysqli, $sql)) {
                echo 'Added new client';
            }
        } else {
            echo 'Error';
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
    if ($_GET['action'] == 'clients') {

        $result = $mysqli->query('SELECT * FROM clients');
        $array = array();

        while ($row = mysqli_fetch_assoc($result)) {
            $array[] = $row;
        }

        echo json_encode(['clients' => $array]);
    }
}

$mysqli->close();