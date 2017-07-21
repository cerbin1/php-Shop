<?php
$mysqli = include 'connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if ($_POST['action'] == 'add') {
        $name = $_POST['type'];

        $name = $mysqli->real_escape_string($name);

        $sql = "INSERT INTO types (name)
            VALUES ('$name')";

        if ($mysqli->query($sql)) {
            echo 'Added new type';
        } else {
            echo 'Error';
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