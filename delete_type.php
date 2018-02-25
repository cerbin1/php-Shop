<?php
/** @var mysqli $mysqli */
$mysqli = include 'connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if ($_POST['action'] === 'delete') {
        $id = $_POST['id'];

        $statement = $mysqli->prepare('DELETE FROM types WHERE productID =?');

        $statement->bind_param('i', $id);

        if ($statement->execute()) {
            http_response_code(204);
        } else {
            http_response_code(500);
        }
    }
}
