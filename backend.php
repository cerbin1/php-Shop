<?php
$mysqli = new mysqli('localhost', 'root', '', 'shop');

if ($mysqli->connect_error) {
    echo "Error connecting to database";
    die("Connection failed: " . $mysqli->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if ($_POST['action'] == 'client') {
        $name = $_POST["name"];
        $age = $_POST["age"];
        $purchase_price = $_POST["purchase_price"];

        $name = $mysqli->real_escape_string($name);
        $age = $mysqli->real_escape_string($age);
        $purchase_price = $mysqli->real_escape_string($purchase_price);


        $sql = "INSERT INTO clients (name, age, purchase_price)
            VALUES ('$name','$age','$purchase_price')";

        if (isValidClient($name, $age, $purchase_price)) {
            if (mysqli_query($mysqli, $sql)) {
                echo 'Added new client';
            }
        } else {
            echo "Error";
        }
    }

    if ($_POST['action'] == 'product') {
        $name = $_POST["name"];
        $type = $_POST["type"];
        $price = $_POST["price"];

        $name = $mysqli->real_escape_string($name);
        $age = $mysqli->real_escape_string($type);
        $price = $mysqli->real_escape_string($price);


        $sql = "INSERT INTO products (name, type, price)
            VALUES ('$name','$type','$price')";

        if (isValidProduct($name, $type, $price)) {
            if (mysqli_query($mysqli, $sql)) {
                echo 'Added new product';
            }
        } else {
            echo "Error";
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


function isValidProduct($name, $type, $price)
{
    return preg_match('/^[a-ząęóśłńćżź]{3,20}$/i', $name)
        && strlen($name)
        && preg_match('/^[a-ząęóśłńćżź]{3,25}$/i', $type)
        && preg_match('/^[0-9]+(.[0-9]{2})?$/', $price)
        && $price < 10000;
}

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if ($_GET['action'] == 'clients') {

        $result = $mysqli->query("SELECT * FROM clients");
        $array = array();

        while ($row = mysqli_fetch_assoc($result)) {
            $array[] = $row;
        }

        echo json_encode(['clients' => $array]);
    }

    if ($_GET['action'] == 'products') {
        $result = $mysqli->query("SELECT * FROM products");
        $array = array();

        while ($row = mysqli_fetch_assoc($result)) {
            $array[] = $row;
        }

        echo json_encode(['products' => $array]);
    }
}


$mysqli->close();
