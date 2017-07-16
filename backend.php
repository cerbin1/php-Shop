<?php
$mysqli = new mysqli('localhost', 'root', '', 'shop');

if ($mysqli->connect_error) {
    echo "Error connecting to database";
    die("Connection failed: " . $mysqli->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if ($_POST['action'] == 'client') {
        http_response_code(201);
    }

    if ($_POST['action'] == 'product') {
        http_response_code(201);
    }
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
