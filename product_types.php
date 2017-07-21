<?php
$mysqli = include 'connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if ($_GET['action'] == 'type') {
        $result = $mysqli->query('SELECT type FROM types');
        $array = array();

        while ($row = mysqli_fetch_assoc($result)) {
            $array[] = $row;
        }

        echo json_encode(['types' => $array]);
    }
}