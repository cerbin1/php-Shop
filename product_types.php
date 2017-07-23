<?php
$mysqli = include 'connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if ($_POST['action'] == 'add') {
        $type = $_POST['type'];

        $type = $mysqli->real_escape_string($type);

        $sql = "INSERT INTO types (name)
            VALUES ('$type')";

        if ($mysqli->query($sql)) {
            http_response_code(201);
        } else {
            http_response_code(500);
        }
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if ($_GET['action'] == 'get') {
        $result = $mysqli->query('SELECT name FROM types');
        $array = array();

        while ($row = mysqli_fetch_assoc($result)) {
            $array[] = $row;
        }

        echo json_encode(['types' => $array]);
    }
}

$mysqli->close();
